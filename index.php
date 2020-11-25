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
        <form action="delete_item.php" method="post" class="todo__delete_form">
          <input type="checkbox" name="todo_completed" id="todo_completed" class="todo_completed" <?= ($item['completed'] != false) ? 'checked' : '' ?>>
          <span id="todoName"><?= $item['name'] ?></span>
          <input type="hidden" name="id" value="<?= $item['id'] ?>" class="todo_id">
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


    const ajax = (type = 'GET', url, options = {}, data, callback) => {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          callback(this.responseText);
        }
      };
      xmlhttp.open(type, url, true);
      for (const [header, value] in options) {
        xmlhttp.setRequestHeader(header, value);
      }
      xmlhttp.send(data);
    }


    document.querySelectorAll('.todo_completed').forEach(t => t.addEventListener('change', e => {
      let checkbox = e.target;
      let todoItem = checkbox.parentElement
      let todoNameSpan = todoItem.querySelector('#todoName');
      if (checkbox.checked) {
        todoNameSpan.style.textDecoration = 'line-through';

        let options = {
          "Content-type": 'application/x-www-form-urlencoded'
        }
        let todoName = todoNameSpan.innerText;
        let todoId = todoItem.querySelector('.todo_id').value
        let completed = checkbox.checked;
        let data = `name=${todoName}&id=${todoId}&todo_completed=${completed}`;

        ajax("POST", './update_item.php', options, data, result => {
          console.log(result)
        });
        // var xmlhttp = new XMLHttpRequest();
        // xmlhttp.onreadystatechange = function() {
        //   if (this.readyState == 4 && this.status == 200) {
        //     // document.getElementById("txtHint").innerHTML = this.responseText;
        //   }
        // };
        // xmlhttp.open("POST", "./update_item.php", true);
        // xmlhttp.set
        // let data = `todo_completed=${checkbox.checked}&id`
        // xmlhttp.send();

      } else {
        todoNameSpan.style.textDecoration = 'none';
      }
    }));
  </script>

</body>

</html>