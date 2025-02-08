<?php
/**
 * Monster Registration Form - Server-side Validation
 * Copyright (c) 2025 [Your Name]
 * Licensed under the MIT License (see LICENSE file for details)
 */
?>

<?php
session_start();

// Retrieve errors and form data from session if they exist
$errors = $_SESSION['errors'] ?? [];
$formData = $_SESSION['post_data'] ?? [];
$successMessage = $_SESSION['success'] ?? "";

// Clear session data after retrieving to prevent repeated display
unset($_SESSION['errors']);
unset($_SESSION['post_data']);
unset($_SESSION['success']);
?>

<!-- Display success message if it exists -->
<?php if (!empty($successMessage)): ?>
    <div class="success-message">
        <?php echo $successMessage; ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monster Registration Form</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>

<div class="logo-container">
    <img src="./images/monsters-university-logo.png" alt="Monsters University Logo">
</div>

<form id="monsterForm" method="POST" action="process.php" novalidate>
    <label for="FullMonsterName">Full Monster Name:</label>
    <input type="text" id="Full Monster Name" name="FullMonsterName"
        placeholder="Enter your full monster name" 
        value="<?php echo htmlspecialchars($formData['FullMonsterName'] ?? ''); ?>"
        class="<?php echo isset($errors['FullMonsterName']) ? 'invalid' : (isset($formData['FullMonsterName']) ? 'valid' : ''); ?>">
    <span class="error-message"><?php echo $errors['FullMonsterName'] ?? ''; ?></span><br>

    <label for="MonsterEmail">Monster Email Address:</label>
    <input type="email" id="Monster Email Address" name="MonsterEmail"
        placeholder="Enter your monster email address"
        value="<?php echo htmlspecialchars($formData['MonsterEmail'] ?? ''); ?>"
        class="<?php echo isset($errors['MonsterEmail']) ? 'invalid' : (isset($formData['MonsterEmail']) ? 'valid' : ''); ?>">
    <span class="error-message"><?php echo $errors['MonsterEmail'] ?? ''; ?></span><br>

    <label for="ScareLevel">Scare Experience Level:</label>
    <select id="Scare Experience Level" name="ScareLevel" class="<?php echo isset($errors['ScareLevel']) ? 'invalid' : (isset($formData['ScareLevel']) ? 'valid' : ''); ?>">
        <option value="">Select Level</option>
        <option value="Beginner" <?php echo (isset($formData['ScareLevel']) && $formData['ScareLevel'] == 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
        <option value="Intermediate" <?php echo (isset($formData['ScareLevel']) && $formData['ScareLevel'] == 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
        <option value="Advanced" <?php echo (isset($formData['ScareLevel']) && $formData['ScareLevel'] == 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
    </select>
    <span class="error-message"><?php echo $errors['ScareLevel'] ?? ''; ?></span><br>

    <label for="Appendages">Number of Tentacles/Arms/Appendages:</label>
    <input type="number" id="Number of Appendages" name="Appendages"
        placeholder="Enter number of appendages"
        value="<?php echo htmlspecialchars($formData['Appendages'] ?? ''); ?>"
        class="<?php echo isset($errors['Appendages']) ? 'invalid' : (isset($formData['Appendages']) ? 'valid' : ''); ?>">
    <span class="error-message"><?php echo $errors['Appendages'] ?? ''; ?></span><br>

    <label for="ScareMethod">Preferred Scare Method:</label>
    <input type="text" id="Preferred Scare Method" name="ScareMethod"
        placeholder="Enter your preferred scare method"
        value="<?php echo htmlspecialchars($formData['ScareMethod'] ?? ''); ?>"
        class="<?php echo isset($errors['ScareMethod']) ? 'invalid' : (isset($formData['ScareMethod']) ? 'valid' : ''); ?>">
    <span class="error-message"><?php echo $errors['ScareMethod'] ?? ''; ?></span><br>

    <label for="MonsterSpecies">Monster Species Classification:</label>
    <input type="text" id="Monster Species Classification" name="MonsterSpecies"
        placeholder="Enter your monster species classification"
        value="<?php echo htmlspecialchars($formData['MonsterSpecies'] ?? ''); ?>"
        class="<?php echo isset($errors['MonsterSpecies']) ? 'invalid' : (isset($formData['MonsterSpecies']) ? 'valid' : ''); ?>">
    <span class="error-message"><?php echo $errors['MonsterSpecies'] ?? ''; ?></span><br>

    <button type="submit">Register Monster</button>
</form>

<div id="customPopup" class="popup";>
    <div class="popup-content">
        <span id="popupMessage"></span>
        <button id="popupCloseBtn">Close</button>
    </div>
</div>

<script src="./js/validation.js"></script>
</body>
</html>
