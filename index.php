<?php
session_start();
require('dbconnect.php');

$stmt = $conn->prepare('SELECT * FROM todo_items');
$stmt->execute();
$todos = $stmt->fetchAll();
$stmt->closeCursor();


$message = (!empty($_SESSION['message'])) ? $_SESSION['message'] : $_SESSION['dbConnection'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="main.css">
  <title>Todo App</title>
</head>

<body>
  <div class="badge"><?= $message ?></div>
  <h1>Todo App</h1>

  <form action="insert_item.php" method="post">
    <label for="todoName">Todo</label>
    <input type="text" name="todoName">
    <input type="submit" value="Add Todo">
  </form>

  <ul class="todo_list">
    <?php foreach ($todos as $item) : ?>
      <li class="todo">
        <span><?= $item['name'] ?></span>
        <form action="update_item.php" method="post" class="todo__update_form" style="display: none;">
          <input type="hidden" name="id" value="<?= $item['id'] ?>">
          <input type="submit" value="Save">
        </form>
        <form action="delete_item.php" method="post" class="todo__delete_form">
          <input type="hidden" name="id" value="<?= $item['id'] ?>">
          <input type="hidden" name="name" value="<?= $item['name'] ?>">
          <input type="submit" value="Delete">
        </form>
      </li>
    <?php endforeach; ?>
  </ul>

</body>

</html>