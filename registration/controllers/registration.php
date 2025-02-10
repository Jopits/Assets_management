<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User Form</title>
    <style>
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 8px;
            margin: 5px 0 10px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function validateForm() {
            var name = document.getElementById('user_uname').value;
            var password = document.getElementById('user_pass').value;
            var email = document.getElementById("user_email").value;
            var passwordConfirm = document.getElementById('passwordConfirm').value;

            // Clear previous errors
            document.getElementById('nameError').innerText = '';
            document.getElementById('passwordError').innerText = '';
            document.getElementById('passwordConfirmError').innerText = '';
            document.getElementById('emailError').innerText = '';

            var isValid = true;

            // Validate name
            if (name.trim() === "") {
                document.getElementById('nameError').innerText = 'Name is required.';
                isValid = false;
            }

            // Validate password length
            if (password.length < 6) {
                document.getElementById('passwordError').innerText = 'Password must be at least 6 characters long.';
                isValid = false;
            }

            // Validate password match
            if (password !== passwordConfirm) {
                document.getElementById('passwordConfirmError').innerText = 'Passwords do not match.';
                isValid = false;
            }

            // Validate email format
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('emailError').innerText = 'Invalid email format.';
                isValid = false;
            }

            return isValid;
        }
    </script>
</head>
<body>
    <?php
        session_start(); // Start the session to access error messages
        $routes = require("./routes.php");

        // Display errors from PHP backend
        if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<p class='error'>$error</p>";
            }
            // Clear errors after displaying them
            unset($_SESSION['errors']);
        }
    ?>
    <h2>Create User</h2>
    <form action="/validation" method="POST" onsubmit="return validateForm()">
        <label for="user_uname">Name:</label><br>
        <input type="text" id="user_uname" name="user_uname" required><br>
        <span id="nameError" class="error"></span><br>

        <label for="user_pass">Password:</label><br>
        <input type="password" id="user_pass" name="user_pass" required><br>
        <span id="passwordError" class="error"></span><br>

        <label for="passwordConfirm">Confirm Password:</label><br>
        <input type="password" id="passwordConfirm" name="passwordConfirm" required><br>
        <span id="passwordConfirmError" class="error"></span><br>

        <label for="user_email">Email:</label><br>
        <input type="text" id="user_email" name="user_email" required><br>
        <span id="emailError" class="error"></span><br>

        <label for="user_dept">Department:</label><br>
        <select name="user_dept" id="user_dept">
            <option value="bssc">BSSC</option>
        </select><br><br>

        <input type="submit" value="Create User">
    </form>
</body>
</html>