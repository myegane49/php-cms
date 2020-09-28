<?php
function escape($userInput) {
  global $connection;
  return mysqli_real_escape_string($connection, trim($userInput));
}

function users_online() {
  if (isset($_GET['onlineusers'])) {
    global $connection;

    if (!$connection) {
      session_start();
      include '../includes/db.php';
    }
  
    $session = session_id();   
    $time = time();
    $time_out_sec = 60;
    $time_out = $time - $time_out_sec;
  
    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $result = mysqli_query($connection, $query);
    $online_count = mysqli_num_rows($result);
  
    if ($online_count == 0) {
        $insert_online_query = "INSERT INTO users_online (session, time) VALUES ('$session', '$time')";
        $insert_online_result = mysqli_query($connection, $insert_online_query);
    } else {
        $update_query = "UPDATE users_online SET time = '$time' WHERE session = '$session'" ;
    }
  
    $online_users_query = "SELECT COUNT(*) AS online_users_count FROM users_online WHERE time > '$time_out'";
    $online_users_result = mysqli_query($connection, $online_users_query);
    echo $online_users_count = mysqli_fetch_assoc($online_users_result)['online_users_count'];
  }

}
users_online();

function queryErrorHandler($result) {
  global $connection;
  if (!$result) {
    die('Query Failed' . mysqli_error($connection));
  }
}

function insert_categories() {
  global $connection;
  if (isset($_POST['add_cat'])) {
    $catTitle = $_POST['cat_title'];
    if ($catTitle == '' || empty($catTitle)) {
      echo 'this field cannot be empty';
    } else {
      $query = "INSERT INTO categories(cat_title) VALUES ('$catTitle')";
      $result = mysqli_query($connection, $query);
      if (!$result) {
        die('query failed' . mysqli_error($connection));
      }
    }
  }
}

function findAllCategories() {
  global $connection;

  $query = "SELECT * FROM categories";
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $catTitle = $row['cat_title'];
    $catId = $row['cat_id'];

    echo "<tr>";
    echo "<td>$catId</td>";
    echo "<td>$catTitle</td>";
    echo "<td><a href='categories.php?delete=$catId'>Delete</a></td>";
    echo "<td><a href='categories.php?edit=$catId'>Edit</a></td>";
    echo "</tr>";
  }
}

function deleteCategories() {
  global $connection;

  if (isset($_GET['delete'])) {
    $categoryId = $_GET['delete'];
    $query = "DELETE FROM categories WHERE cat_id = {$categoryId}";
    $result = mysqli_query($connection, $query);
    header("location: categories.php");
  }
}
?>
