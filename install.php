<?php
$servername = "localhost";
$username = "root";
$password = "password";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DROP DATABASE IF EXISTS camagru";
if ($conn->query($sql) === TRUE)
{
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    if ($conn->query($sql) === TRUE)
    {
        $dbname = "camagru";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "CREATE TABLE users (
            email VARCHAR(50) PRIMARY KEY NOT NULL,
            username VARCHAR(16) UNIQUE NOT NULL,
            password VARCHAR(30) NOT NULL
            )";
        if ($conn->query($sql) === TRUE)
            header("Location: index.php");
        else 
            echo "Error creating table: " . $conn->error;
    } 
    else
        echo "Error creating database: " . $conn->error . "<br>";
}
else
    echo "Error Dropping database: " . $conn->error . "<br>";
?>