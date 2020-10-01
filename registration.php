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
    // if (isset($_POST['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = '';

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $error = [ // we could do all the validation here but we didn't for future references
            'username' => '',
            'password' => ''
        ];

        if (strlen($username) < 4) {
            $error['username'] = 'Username needs to be longer';
        }

        if (strlen($password) < 6) {
            $error['password'] = 'password must be at least 6 characters';
        }

        // $valid = true;

        foreach($error as $key => $value) {
            // if (!empty($value)) {
            //     $valid = false;
            //     $message = "<h5 class='text-center text-danger'>$value</h5>";
            // }

            if (empty($value)) {
                unset($error[$key]);
                $message = "<h5 class='text-center text-danger'>$value</h5>";
            }
        }

        // if ($valid) {
        if (empty($error)) {
            if (username_exists($username)) {
                $message = '<h5 class="text-center text-danger">username exists</h5>';
            } else if (email_exists($email)) {
                $message = '<h5 class="text-center text-danger">email exists</h5>';
            } else {
                if (!empty($username) && !empty($email) && !empty($password)) {
                    $username = mysqli_real_escape_string($connection, $username);
                    $email = mysqli_real_escape_string($connection, $email);
                    $password = mysqli_real_escape_string($connection, $password);
        
                    $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
            
                    // $query = "SELECT randSalt FROM users LIMIT 1";
                    // $salt_result = mysqli_query($connection, $query);
                    // if (!$salt_result) {
                    //     echo mysqli_error($salt_result);
                    // } else {
                        // $row = mysqli_fetch_assoc($salt_result);
                        // $salt = $row['randSalt'];
                        // $password = crypt($password, $salt);
            
                        $insert_query = "INSERT INTO users (username, user_email, user_password) VALUES ('{$username}', '{$email}', '{$password}')";
                        $insert_result = mysqli_query($connection, $insert_query);
                        if (!$insert_result) {
                            echo '<h1>Errooooor</h1>' . mysqli_error($connection);
                        } else {
                            $message = '<h5 class="text-center text-success">Registeration Successfull</h5>';
                            $_SESSION['username'] = $username;
                            $_SESSION['user_role'] = 'subscriber';
                        }
                    // }
                } else {
                    $message = '<h5 class="text-center text-danger">These fields cannot be empty</h5>';
                }
            }
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
                        <h1>Register</h1>
                            <form role="form" action="" method="post" id="login-form" autocomplete="off">
                                <?php echo $message ?>
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input autocomplete="on" type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" value="<?php echo isset($username) ? $username : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input autocomplete="on" type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" value="<?php echo isset($email) ? $email : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                </div>
                        
                                <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
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
