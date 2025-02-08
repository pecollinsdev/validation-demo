Validation Library 🛠️
📌 Overview

The Validation Library is a custom JavaScript validation tool designed to handle real-time form validation, error handling, and AJAX-based form submission. It ensures user inputs are validated both on the client and server sides to enhance security and user experience.

This library:

    Prevents invalid form submissions before reaching the server.
    Provides real-time feedback with dynamic error messages.
    Handles AJAX form submissions for a seamless user experience.
    Works alongside PHP server-side validation (process.php).

🚀 Installation
1️⃣ Download the Library

Clone the repository or download the required files:

git clone https://github.com/pecollinsdev/validation-demo.git

Alternatively, download validation.js and place it in your project's js/ folder.
📂 Project Structure

/project-folder
│── /css
│   └── styles.css          # CSS for styling form fields
│── /images
│   └── monsters-university-logo.png
│── /js
│   └── validation.js       # JavaScript validation library
│── index.php               # Main form file
│── process.php             # Handles server-side validation
│── README.md               # Documentation

📌 Usage
2️⃣ Include the Library in Your Project

In your index.php (or any HTML file), link the validation script:

<script src="./js/validation.js"></script>

3️⃣ Setup Your Form

Make sure your form follows this structure:

<form id="monsterForm" method="POST" action="process.php" novalidate>
    <label for="FullMonsterName">Full Monster Name:</label>
    <input type="text" id="Full Monster Name" name="FullMonsterName" placeholder="Enter monster name">
    <span class="error-message"></span>

    <label for="MonsterEmail">Monster Email:</label>
    <input type="email" id="Monster Email" name="MonsterEmail" placeholder="Enter email">
    <span class="error-message"></span>

    <button type="submit">Register Monster</button>
</form>

4️⃣ Configure Field Validations

Define form field validation rules in validation.js:

const formFields = [
    { id: 'Full Monster Name', validators: ['validateRequired', 'validateFullName'], events: ['input', 'blur'] },
    { id: 'Monster Email', validators: ['validateEmail'], events: ['input', 'blur'] },
];

This ensures:

    "Full Monster Name" is required and only contains letters & spaces.
    "Monster Email" is required and follows a valid email format.

5️⃣ How Validation Works

The library automatically: ✅ Highlights fields in green if they are valid.
❌ Highlights fields in red and displays error messages if they are invalid.

Example real-time validation:

validator.validateRequired(document.getElementById('Full Monster Name'));
validator.validateEmail(document.getElementById('Monster Email'));

6️⃣ Enable AJAX Form Submission

The library intercepts form submission and submits data using fetch(), preventing full page reloads.

✅ Automatic error handling & popups:

    If invalid, the popup shows the errors and prevents submission.
    If valid, the data is sent to process.php via AJAX.

🚀 No extra setup needed! The library handles everything.
📌 Example: Full Implementation

<form id="monsterForm" method="POST" action="process.php" novalidate>
    <label for="FullMonsterName">Full Monster Name:</label>
    <input type="text" id="Full Monster Name" name="FullMonsterName" placeholder="Enter monster name">
    <span class="error-message"></span>

    <label for="MonsterEmail">Monster Email:</label>
    <input type="email" id="Monster Email" name="MonsterEmail" placeholder="Enter email">
    <span class="error-message"></span>

    <button type="submit">Register Monster</button>
</form>

<div id="customPopup" class="popup">
    <div class="popup-content">
        <span id="popupMessage"></span>
        <button id="popupCloseBtn">Close</button>
    </div>
</div>

<script src="./js/validation.js"></script>

📌 Error Handling & Popups
7️⃣ Displaying Validation Errors

If an input fails validation, an error message appears dynamically:

validator.setInvalid(field, "This field is required.");

If the input is corrected, the error disappears:

validator.setValid(field);

8️⃣ Custom Popups for Errors & Success

The library includes a popup notification system for feedback.

Validator.showPopup("Monster registration successful!", "success");
Validator.showPopup("Please correct the errors before submitting.", "error");

📌 Backend: PHP Validation (process.php)

Even though the library validates fields in real-time, PHP still validates everything on the server for security.

if (!empty($_POST['MonsterEmail']) && !filter_var($_POST['MonsterEmail'], FILTER_VALIDATE_EMAIL)) {
    $errors['MonsterEmail'] = "Invalid email format.";
}

📌 Troubleshooting
Issue	Solution
Validation not working?	Ensure validation.js is included and the form uses correct field IDs.
Popups not showing?	Check if customPopup exists in your HTML.
Fields not turning green?	Ensure setValid() and setInvalid() are correctly called.
No AJAX submission?	Ensure fetch() is enabled in validation.js.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
