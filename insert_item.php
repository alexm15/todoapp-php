<?php

require './dbconnect.php';

$todoName = filter_input(INPUT_POST, 'todoName', FILTER_SANITIZE_STRING);
if ($todoName != false) {
    $stmt = $conn->prepare('INSERT INTO todo_items (name) VALUES (:todoName)');
    $stmt->bindValue(':todoName', $todoName);

    $execute = $stmt->execute();
    $stmt->closeCursor();
    $_SESSION['message'] = "$todoName was added to the list";
} else {
    $_SESSION['message'] = "Something went wrong when trying to add item";
}

header("Location: index.php");
exit;
