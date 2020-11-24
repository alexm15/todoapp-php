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
        <form action="delete_item.php" method="post" class="todo__delete_form">
          <input type="hidden" name="id" value="<?= $item['id'] ?>">
          <input type="hidden" name="name" value="" class="todo_name_input">
          <input type="submit" value="Save" formaction="update_item.php" class="todo__update_form">
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
        item.style.display = "none";


        input.select();
        parent.querySelector(".todo__update_form").style.display = 'inline-block';

        input.onblur = function() {
          item.innerText = input.value;
          item.style.display = 'inline-block';
          parent.removeChild(input);
        }
      }
    }

    const updateName = (e) => {
      let todoSpan = e.target;
      todoSpan.parentElement.querySelector('.todo_name_input').value = todoSpan.innerText;
      console.log(todoSpan.parentElement.querySelector('.todo_name_input').value);
    }


    let todoNames = document.querySelectorAll('#todoName');
    todoNames.forEach(t => t.addEventListener('click', toggleInput));
    todoNames.forEach(t => t.addEventListener('DOMSubtreeModified', updateName));

    document.querySelector('.todo__update_form').addEventListener('click', e => {
      e.target.style.display = 'none';
    });
  </script>

</body>

</html>