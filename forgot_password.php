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
<!-- Navigation -->
<?php include './includes/navigation.php'; ?>

<?php // require './classes/Config.php'; ?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
  if (isRequestMethod('get') && !isset($_GET['forgot'])) {
    header("location index.php");
  }

  if (isRequestMethod('post') && isset($_POST['email'])) {
    $email = $_POST['email'];
    $length = 50;
    $token = bin2hex(openssl_random_pseudo_bytes($length));

    if (email_exists($email)) {
      if ($stmt = mysqli_prepare($connection, "UPDATE users SET token = ? WHERE user_email = ?")) {
        mysqli_stmt_bind_param($stmt, "ss", $token, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Load Composer's autoloader
        require 'vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = Config::SMTP_HOST;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = Config::SMTP_USERNAME;                     // SMTP username
            $mail->Password   = Config::SMTP_PASSWORD;                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = Config::SMTP_PORT;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('m.yegane49@protonmail.com', 'myegane49');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Here is the subject';
            $mail->Body    = "<p>Please click to reset your password</p><a href='localhost:8080/reset.php?email=$email&token=$token'>link</a>";

            $mail->send();
            $emailSent = true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      } else {
        echo mysqli_error($connection);
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

                          <?php if(!isset($emailSent)): ?>

                          <h3><i class="fa fa-lock fa-4x"></i></h3>
                          <h2 class="text-center">Forgot Password?</h2>
                          <p>You can reset your password here.</p>
                          <div class="panel-body">

                              <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                  <div class="form-group">
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                          <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Send Link to Email" type="submit">
                                  </div>

                                  <input type="hidden" class="hide" name="token" id="token" value="">
                              </form>

                          </div><!-- Body-->

                          <?php else: ?>

                          <h3>Please check your email</h3>

                          <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /.container -->
        <hr>
        <!-- Footer -->
        <?php include './includes/footer.php'; ?>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>


