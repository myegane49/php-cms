<!DOCTYPE html>
<html lang="en">
<head>
  <?php include './includes/db.php'; ?>
  <?php include './includes/head.php'; ?>
</head>
<body>
<!-- Navigation -->
<?php include './includes/navigation.php'; ?>
<?php 
    if (isset($_POST['submit'])) {
        $message = '';
        $to = 'm.yegane49@gmail.com';
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $header = "From:" . $_POST['email'];
        
        if (!empty($subject) && !empty($email) && !empty($body)) {
            $subject = mysqli_real_escape_string($connection, $subject);
            $email = mysqli_real_escape_string($connection, $email);
            $body = mysqli_real_escape_string($connection, $body);
    
            mail($to, $subject, $body, $header);
            $message = '<h5 class="text-center text-success">Registeration Successfull</h5>';
        } else {
            $message = '<h5 class="text-center text-danger">These fields cannot be empty</h5>';
        }
    }
?>
    <!-- Page Content -->
    <div class="container">
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Contact</h1>
                            <form role="form" action="" method="post" id="login-form" autocomplete="off">
                                <?php echo $message ?>
                                
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="sr-only">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                                </div>
                        
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
        <hr>
        <!-- Footer -->
        <?php include './includes/footer.php'; ?>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
