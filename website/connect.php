<?php
$servername = "agile136.science.uva.nl";
$username = "mhbp";
$password = "qdtboXhCHJyL2szC";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

?>
