<?php
// Test MySQL connection
$mysqli = new mysqli("localhost", "root", "", "cti_assets");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Successfully connected to the database!";
}

$mysqli->close();
?>