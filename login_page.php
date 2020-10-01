<?php session_start(); ?>
<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include './includes/db.php'; ?>
  <?php include './includes/head.php'; ?>
  <?php include './admin/functions.php'; ?>

</head>

<body>
<?php
  checkLoggedInRedirect('/admin');
  if (isRequestMethod('post')) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

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

      if ($username === $db_username && password_verify($password, $db_userPassword)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_userFirstname;
        $_SESSION['lastname'] = $db_userLastname;
        $_SESSION['user_role'] = $db_userRole;
        header("location: admin/");
      } else {
        header("location: login_page.php");
      }

    } else {
      header("location: login_page.php");
    }
  }
?>
<!-- Navigation -->
<?php include './includes/navigation.php'; ?>

    <!-- Page Content -->
<div class="container">

<div class="form-gap"></div>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="text-center">


            <h3><i class="fa fa-user fa-4x"></i></h3>
            <h2 class="text-center">Login</h2>
            <div class="panel-body">


              <form action="login_page.php" id="login-form" role="form" autocomplete="off" class="form" method="post">

                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                  </div>
                </div>

                <div class="form-group">

                  <input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
                </div>


              </form>

            </div><!-- Body-->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        <hr>
        <!-- Footer -->
        <?php include './includes/footer.php'; ?>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
