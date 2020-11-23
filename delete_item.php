<?php

require './dbconnect.php';

$id = $_POST['id'] ?? false;
$name = $_POST['name'] ?? false;

if ($id != false) {
    $stmt = $conn->prepare("DELETE FROM todo_items WHERE id = :id");
    $stmt->bindValue(':id', $id);

    $execute = $stmt->execute();
    $stmt->closeCursor();

    $_SESSION['message'] = "$name was removed the list";
} else {
    $_SESSION['message'] = "$name was not found";
}

header("Location: index.php");
exit;
