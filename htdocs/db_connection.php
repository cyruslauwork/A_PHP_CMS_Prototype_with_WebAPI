<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // echo "Successfully connected to the database<hr>";
} catch (PDOException $e) {
    echo $e->getMessage();
}
