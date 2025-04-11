<?php
$conn = new mysqli("localhost", "root", "", "shopcy");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
