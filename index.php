
<?php
  require('dbconnect.php');
  $stmt = $conn->prepare('SELECT * FROM todo_items');
  $stmt->execute();
  $todo_items = $stmt->fetchAll();
  $stmt->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Todo App</title>
  </head>
  <body>
    <h1>Todo App</h1>

    <form action="insert_item.php" method="post">
      <label for="name">Todo</label>
      <input type="text" name="name">
      <input type="submit" value="Add Todo">
    </form>

    <ul>
      <?php foreach ($todo_items as $item) : ?>
        <li><?=$item['name']?></li>
      <?php endforeach ; ?>
    </ul>
    
  </body>
</html>
