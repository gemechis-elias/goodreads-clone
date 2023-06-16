<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'goodreads';

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die('Database connection failed: ' . $connection->connect_error);
}
?>
