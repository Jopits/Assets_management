<?php
session_start();

$routes = require('./../routes.php');
$routes->get('','');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $password = $_POST['password'];

    // Database connection
    $mysqli = new mysqli("localhost", "root", "", "cti_assets");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Fetch user from database
    $stmt = $mysqli->prepare("SELECT user_id, user_pass FROM users_tbl WHERE user_uname = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashedPassword);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        echo"<p style='color: red;'>gumana</p>";
        // Login successful
        $_SESSION['user_id'] = $id;
        $_SESSION['user_uname'] = $name;  // Optional: Store the username in session for later use

        // Redirect to welcome page (Note: remove the leading slash for the relative URL)
        header("Location: welcome"); 
        exit();
    } else {
        echo "<p style='color: red;'>Invalid username or password.</p>";
    }

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="login.php"> <!-- Corrected action URL -->
        <label for="name">Username:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
