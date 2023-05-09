<?php

$dbHost = $_ENV['MYSQL_HOST'];
$dbUsername = $_ENV['MYSQL_USER'];
$dbPassword = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DATABASE'];

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}