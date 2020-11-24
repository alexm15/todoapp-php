<?php

session_start();
require './dbconnect.php';

$todoName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$id = $_POST['id'] ?? false;
if ($todoName != false && $id != false) {
    $stmt = $conn->prepare('UPDATE todo_items SET name=:name WHERE id = :id');
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':name', $todoName);

    $execute = $stmt->execute();
    $stmt->closeCursor();
    $_SESSION['message'] = "$todoName was updated";
} else {
    $_SESSION['message'] = "Something went wrong when trying to update $todoName";
}

header("Location: index.php");
exit;
