<?php

define("DB_USER", "todo_app");
define("DB_PASSWORD", "todoapp123");
$dsn = "mysql:host=localhost;dbname=todo_app";

try {
    $conn = new PDO($dsn, DB_USER, DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_SESSION['dbConnection'] = 'Connected Successfully to DB';
} catch(PDOException $e) {
    $_SESSION['dbConnection'] = "Connection failed: " . $e->getMessage();
    exit();
}