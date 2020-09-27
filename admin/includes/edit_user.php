<?php
if (isset($_GET['u_id'])) {
  $userId = $_GET['u_id'];
  $query = "SELECT * FROM users WHERE user_id = {$userId}";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);

  $user_firstname = $row['user_firstname'];
  $user_lastname = $row['user_lastname'];
  $user_role = $row['user_role'];
  $username = $row['username'];
  $user_email = $row['user_email'];
  $user_password = $row['user_password'];
}
if (isset($_POST['edit_user'])) {
  $userFirstname = $_POST['user_firstname'];
  $userLastname = $_POST['user_lastname'];
  $userRole = $_POST['user_role'];
  $userName = $_POST['username'];

  // $userImage        = $_FILES['image']['name'];
  // $userImageTemp   = $_FILES['image']['tmp_name'];

  $userEmail = $_POST['user_email'];
  $userPassword = $_POST['user_password'];

  // if (empty($postImage)) {
  //   $query = "SELECT * FROM posts WHERE post_id = {$postId}";
  //   $result = mysqli_query($connection, $query);
  //   $row = mysqli_fetch_assoc($result);
  //   $postImage = $row['post_image'];
  // } else {
  //   move_uploaded_file($postImageTemp, "../images/$postImage");
  // }

//   $salt_query = "SELECT randSalt FROM users LIMIT 1";
//   $salt_result = mysqli_query($connection, $salt_query);
//   if (!$salt_result) {
//    echo mysqli_error($salt_result);
//   }
//   $row = mysqli_fetch_assoc($salt_result);
//   $salt = $row['randSalt'];
  if ($userPassword != $user_password) {
   //   $userPassword = crypt($userPassword, $salt);
     $userPassword = password_hash($userPassword, PASSWORD_BCRYPT, ['cost' => 10]);
  }

  $query = "UPDATE users SET user_firstname = '{$userFirstname}', user_lastname = '{$userLastname}', user_role = '{$userRole}', ";
  $query .= "username = '{$userName}', user_email = '{$userEmail}', user_password = '{$userPassword}' ";
  $query .= "WHERE user_id = {$userId}";
  $result = mysqli_query($connection, $query);
  queryErrorHandler($result);
}
?>

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
         <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
     </div>

</form>
