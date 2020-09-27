<?php
if (isset($_POST['create_user'])) {
   $userFirstname       = $_POST['user_firstname'];
   $userLastname       = $_POST['user_lastname'];
   $userRole  = $_POST['user_role'];
   $username       = $_POST['username'];

   // $userImage        = $_FILES['image']['name'];
   // $userImageTemp   = $_FILES['image']['tmp_name'];

   $userEmail         = $_POST['user_email'];
   $userPassword      = $_POST['user_password'];
   // $userdate         = date('d-m-y'); // or you could use the NOW() function of the mysql

   // move_uploaded_file($userImageTemp, "../images/profiles/$userImage");

   $userPassword = password_hash($userPassword, PASSWORD_BCRYPT, ['cost' => 10]);

   $query = "INSERT INTO users (user_firstname, user_lastname, user_role, username, user_email, user_password) ";
   $query .= "VALUES ('{$userFirstname}','{$userLastname}','{$userRole}', '{$username}','{$userEmail}','{$userPassword}') ";
   $result = mysqli_query($connection, $query);
   queryErrorHandler($result);

   echo "User is created: " . "<a href='users.php'>View Users</a>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
     <div class="form-group">
        <label>Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
     </div>

     <div class="form-group">
        <label>Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
     </div>

     <div class="form-group">
        <label>User Role</label>
        <select name="user_role">
          <option value="subscriber">Subscriber</option>
          <option value="admin">Admin</option>
        </select>
     </div>

     <div class="form-group">
        <label>Username</label>
         <input type="text" class="form-control" name="username">
     </div>

     <div class="form-group">
        <label>Email</label>
         <input type="email" class="form-control" name="user_email">
     </div>

     <div class="form-group">
       <label>Password</label>
       <input type="password" class="form-control" name="user_password">
     </div>

     <!-- <div class="form-group">
        <label>User Image</label>
         <input type="file"  name="image">
     </div> -->

      <div class="form-group">
         <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
     </div>

</form>
