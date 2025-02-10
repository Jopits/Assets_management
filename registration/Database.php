<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cti_assets";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM users_tbl ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["user_id"]. " - Name: " . $row["user_uname"]. " " . $row["user_pass"]. "<br>";
    }
} else {
    echo "wala beh". mysqli_error($conn);
}


$conn -> close();
?>