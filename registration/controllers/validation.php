<?php
session_start(); // Start the session for storing error messages

// Load the routes array
$routes = require('routes.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = trim($_POST['user_uname']);
    $password = $_POST['user_pass'];
    $email = trim($_POST['user_email']);
    $dept = trim($_POST['user_dept']);
    $passwordConfirm = $_POST['passwordConfirm'];

    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate password length
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Validate password match
    if ($password !== $passwordConfirm) {
        $errors[] = "Passwords do not match.";
    }

    // If no errors, proceed to check for duplicate username and insert data
    if (empty($errors)) {
        // Database connection
        $mysqli = new mysqli("localhost", "root", "", "cti_assets");

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Check if username already exists
        $stmt = $mysqli->prepare("SELECT user_id FROM users_tbl WHERE user_uname = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Username already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user
            $insertStmt = $mysqli->prepare("INSERT INTO users_tbl (user_uname, user_pass, user_email, user_dept) VALUES (?, ?, ?, ?)");
            $insertStmt->bind_param("ssss", $name, $hashedPassword, $email, $dept);

            if ($insertStmt->execute()) {
                // Redirect to /login page after successful registration
                header("Location: " . $routes['/login']);
                exit(); // Ensure no further code is executed after redirection
            } else {
                $errors[] = "Error creating user: " . $mysqli->error;
            }

            $insertStmt->close();
        }

        $stmt->close();
        $mysqli->close();
    }

    // If there are errors, store them in the session and redirect back to the form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: " . $routes['/register']); // Redirect back to the registration page
        exit();
    }
}
?>