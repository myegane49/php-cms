<?php
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
