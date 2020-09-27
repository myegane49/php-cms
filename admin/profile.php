<?php include './includes/admin_head.php'; ?>

<?php
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    $userId = $row['user_id'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_role = $row['user_role'];
    $username = $row['username'];
    $user_email = $row['user_email'];
    $user_password = $row['user_password'];
  }
?>

<?php
if (isset($_POST['update_profile'])) {
  $userFirstname = $_POST['user_firstname'];
  $userLastname = $_POST['user_lastname'];
  $userRole = $_POST['user_role'];
  $userName = $_POST['username'];

  // $userImage        = $_FILES['image']['name'];
  // $userImageTemp   = $_FILES['image']['tmp_name'];

  $userEmail = $_POST['user_email'];
  $userPassword = $_POST['user_password'];

  $_SESSION['username'] = $userName;
  $_SESSION['firstname'] = $userFirstname;
  $_SESSION['lastname'] = $userLastname;
  $_SESSION['user_role'] = $userRole;

  // if (empty($postImage)) {
  //   $query = "SELECT * FROM posts WHERE post_id = {$postId}";
  //   $result = mysqli_query($connection, $query);
  //   $row = mysqli_fetch_assoc($result);
  //   $postImage = $row['post_image'];
  // } else {
  //   move_uploaded_file($postImageTemp, "../images/$postImage");
  // }

  if ($userPassword != $user_password) {
    $userPassword = password_hash($userPassword, PASSWORD_BCRYPT, ['cost' => 10]);
  }

  $query = "UPDATE users SET user_firstname = '{$userFirstname}', user_lastname = '{$userLastname}', user_role = '{$userRole}', ";
  $query .= "username = '{$userName}', user_email = '{$userEmail}', user_password = '{$userPassword}' ";
  $query .= "WHERE user_id = {$userId}";
  $result = mysqli_query($connection, $query);
  queryErrorHandler($result);

  header("Location: profile.php");
}
?>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include './includes/admin_navigation.php'; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                      <h1 class="page-header">
                          Welcome to admin
                          <small><?php echo $username; ?></small>
                      </h1>

                      <form action="" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                              <label>Firstname</label>
                              <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
                          </div>

                          <div class="form-group">
                              <label>Lastname</label>
                              <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
                          </div>

                          <div class="form-group">
                              <label>User Role</label>
                              <select name="user_role">
                                <option <?php if ($user_role === 'subscriber') echo 'selected'; ?> value="subscriber">Subscriber</option>
                                <option <?php if ($user_role === 'admin') echo 'selected'; ?> value="admin">Admin</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label>Username</label>
                              <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                          </div>

                          <div class="form-group">
                              <label>Email</label>
                              <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
                          </div>

                          <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
                          </div>

                          <!-- <div class="form-group">
                              <label>User Image</label>
                              <input type="file"  name="image">
                          </div> -->

                            <div class="form-group">
                              <input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
                          </div>

                      </form>

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <?php include './includes/admin_footer.php'; ?>
</body>
</html>
