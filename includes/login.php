<?php include "db.php"; ?>
<?php session_start(); ?>

<?php
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);

  $query = "SELECT * FROM users WHERE username = '{$username}'";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    echo mysqli_error($connection);
  }
  $row = mysqli_fetch_assoc($result);

  $db_username = $row['username'];
  $db_userFirstname = $row['user_firstname'];
  $db_userLastname = $row['user_lastname'];
  $db_userRole = $row['user_role'];
  $db_userPassword = $row['user_password'];

  $password = crypt($password, $db_userPassword);

  if ($username === $db_username && $password === $db_userPassword) {
    $_SESSION['username'] = $db_username;
    $_SESSION['firstname'] = $db_userFirstname;
    $_SESSION['lastname'] = $db_userLastname;
    $_SESSION['user_role'] = $db_userRole;
    header("Location: ../admin/");
  } else {
    header("Location: ../index.php");
  }
}
?>

