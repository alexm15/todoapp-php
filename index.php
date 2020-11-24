<?php
session_start();
require('dbconnect.php');

$stmt = $conn->prepare('SELECT * FROM todo_items');
$stmt->execute();
$todos = $stmt->fetchAll();
$stmt->closeCursor();

$message = (!empty($_SESSION['message'])) ? $_SESSION['message'] : $_SESSION['dbConnection'];
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/main.css">
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
        <span id="todoName"><?= $item['name'] ?></span>
        <form action="update_item.php" method="post" class="todo__update_form" style="display: none;">
          <input type="hidden" name="id" value="<?= $item['id'] ?>">
          <input type="hidden" name="name" value="<?= $item['name'] ?>">
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

  <script>
    const toggleInput = (e) => {
      var item = e.target;
      var itemText = item.innerText;
      var parent = item.parentNode;
      if (item.nodeName === 'SPAN') {
        var input = document.createElement('input');
        input.classList.add('todo__update_field');
        input.value = itemText;
        input.style.width = (item.offsetWidth + 20) + "px";

        parent.insertBefore(input, item);
        parent.removeChild(item);

        input.select();
        parent.querySelector(".todo__update_form").style.display = 'inline-block';

        input.onblur = function() {
          item.innerText = input.value;
          parent.insertBefore(item, input);
          parent.removeChild(input);
        }

      }
    }


    let todoNames = document.querySelectorAll('#todoName');
    todoNames.forEach(t => t.addEventListener('click', toggleInput));

    document.querySelector('.todo__update_form').addEventListener('click', e => {
      e.target.style.display = 'none';
    });
  </script>

</body>

</html>