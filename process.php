<?php
/**
 * Monster Registration Form - Server-side Validation
 * Copyright (c) 2025 [Your Name]
 * Licensed under the MIT License (see LICENSE file for details)
 */
?>

<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the request is an AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Database connection
$host = "localhost"; // Change if using another host
$dbname = "monster_db"; // Change to your database name
$username = "root"; // Change if using another user
$password = ""; // Change if your MySQL has a password

// Connect to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    if ($isAjax) {
        echo json_encode(["status" => "error", "message" => "Database connection failed: " . $e->getMessage()]);
    } else {
        $_SESSION['errors']['database'] = "Database connection failed: " . $e->getMessage();
        header("Location: index.php");
    }
    exit();
}

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Array to hold validation errors
$errors = [];

// Validate Full Monster Name
if (empty($_POST['FullMonsterName'])) {
    $errors['FullMonsterName'] = "Full Monster Name is required.";
} else {
    $fullMonsterName = sanitizeInput($_POST['FullMonsterName']);
    if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $fullMonsterName)) {
        $errors['FullMonsterName'] = "Full Monster Name must be 3-50 characters long and contain only letters, numbers, and spaces.";
    }
}

// Validate Monster Email
if (empty($_POST['MonsterEmail'])) {
    $errors['MonsterEmail'] = "Monster Email Address is required.";
} else {
    $monsterEmail = sanitizeInput($_POST['MonsterEmail']);
    if (!filter_var($monsterEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['MonsterEmail'] = "Please enter a valid email address.";
    } else {
        // **Check if the email already exists in the database**
        $stmt = $conn->prepare("SELECT COUNT(*) FROM monsters WHERE email = :email");
        $stmt->execute([':email' => $monsterEmail]);
        $emailExists = $stmt->fetchColumn();

        if ($emailExists > 0) {
            $errors['MonsterEmail'] = "This email is already registered.";  // ✅ Set error
        }
    }
}

// Validate Scare Level
$validScareLevels = ["Beginner", "Intermediate", "Advanced"];
if (empty($_POST['ScareLevel']) || !in_array($_POST['ScareLevel'], $validScareLevels)) {
    $errors['ScareLevel'] = "Please select a valid scare experience level.";
} else {
    $scareLevel = sanitizeInput($_POST['ScareLevel']);
}

// Validate Number of Appendages
if (empty($_POST['Appendages'])) {
    $errors['Appendages'] = "Number of Appendages is required.";
} else {
    $appendages = sanitizeInput($_POST['Appendages']);
    if (!is_numeric($appendages) || $appendages < 1 || $appendages > 100) {
        $errors['Appendages'] = "Number of Appendages must be between 1 and 100.";
    }
}

// Validate Preferred Scare Method
if (empty($_POST['ScareMethod'])) {
    $errors['ScareMethod'] = "Preferred Scare Method is required.";
} else {
    $scareMethod = sanitizeInput($_POST['ScareMethod']);
    if (strlen($scareMethod) < 10 || strlen($scareMethod) > 200) {
        $errors['ScareMethod'] = "Preferred Scare Method must be between 10 and 200 characters.";
    }
}

// Validate Monster Species
if (empty($_POST['MonsterSpecies'])) {
    $errors['MonsterSpecies'] = "Monster Species Classification is required.";
} else {
    $monsterSpecies = sanitizeInput($_POST['MonsterSpecies']);
    if (!preg_match("/^[A-Z][a-z]+ (Monster|Creature|Beast)$/", $monsterSpecies)) {
        $errors['MonsterSpecies'] = 'Monster Species must start with a capital letter and end with "Monster", "Creature", or "Beast".';
    }
}

// If errors exist, return JSON for JavaScript OR redirect if JS is disabled
if (!empty($errors)) {
    if ($isAjax) {
        echo json_encode(["status" => "error", "errors" => $errors]);
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['post_data'] = $_POST;
        header("Location: index.php"); // Redirect back to form normally
    }
    exit();
}

// If no errors, insert into database
try {
    $stmt = $conn->prepare("INSERT INTO monsters (full_name, email, scare_level, appendages, scare_method, monster_species) 
                            VALUES (:full_name, :email, :scare_level, :appendages, :scare_method, :monster_species)");

    $stmt->execute([
        ':full_name' => $_POST['FullMonsterName'],
        ':email' => $_POST['MonsterEmail'],
        ':scare_level' => $_POST['ScareLevel'],
        ':appendages' => $_POST['Appendages'],
        ':scare_method' => $_POST['ScareMethod'],
        ':monster_species' => $_POST['MonsterSpecies']
    ]);

    if ($isAjax) {
        echo json_encode(["status" => "success", "message" => "Monster registration successful!"]);
    } else {
        $_SESSION['success'] = "Monster registration successful!";
        header("Location: index.php");
    }
    exit();
} catch (PDOException $e) {
    if ($isAjax) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    } else {
        $_SESSION['errors']['database'] = "Database error: " . $e->getMessage();
        header("Location: index.php");
    }
    exit();
}