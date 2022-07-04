<?php
$servername = "vicencioperfumerias.cl";
$username = "vstore_user";
$password = "vicencio2016++";
$dbname = "vstore_site";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 