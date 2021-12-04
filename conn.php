<?php
// Create connection
// $conn = mysqli_connect('localhost', 'thedigit_flutter', 'Tech@123!', 'thedigit_flutter_test_db');//for localhost
$conn = mysqli_connect('localhost', 'root', '', 'flutter_tutorial_db');//for localhost

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>