<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include './includes/db.php'; ?>
  <?php include './includes/head.php'; ?>
  <?php include './admin/functions.php'; ?>

</head>

<body>
<!-- Navigation -->
<?php include './includes/navigation.php'; ?>

<?php
  if (!isset($_GET['email']) || !isset($_GET['token'])) {
    header("location: index.php");
  }
  $emailed_token = $_GET['token'];
  $email = $_GET['email'];

  if ($stmt = mysqli_prepare($connection, "SELECT username, user_email, token FROM users WHERE token = ?")) {
    mysqli_stmt_bind_param($stmt, "s", $emailed_token);
    mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($emailed_token !== $token || $email !== $user_email) {
      header('location: index.php');
    }

    if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
      $password = $_POST['password'];
      if ($password === $_POST['confirmPassword']) {
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
        if ($stmt = mysqli_prepare($connection, "UPDATE users SET token = '', user_password = ? WHERE user_email = ?")) {
          mysqli_stmt_bind_param($stmt, "ss", $password, $email);
          mysqli_stmt_execute($stmt);
          if (mysqli_stmt_affected_rows() >= 1) { 
            header("location: login.php");
          }
        }
      }
    }
  }
?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="password" name="password" placeholder="New Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div> <!-- /.container -->
<hr>

<?php include './includes/footer.php'; ?>


<!-- jQuery -->
<script src="js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>