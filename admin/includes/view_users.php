<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Role</th>
      <!-- <th>Date</th> -->
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $query = "SELECT * FROM users";
      $result = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        $userId = $row['user_id'];
        $username = $row['username'];
        $userEmail = $row['user_email'];
        $userFirstname = $row['user_firstname'];
        $userLastname = $row['user_lastname'];
        $userRole = $row['user_role'];
        $userImage = $row['user_image'];

        echo "<tr>";
        echo "<td>$userId</td>";
        echo "<td>$username</td>";
        echo "<td>$userFirstname</td>";
        echo "<td>$userLastname</td>";
        echo "<td>$userEmail</td>";

        // $query = "SELECT * FROM posts WHERE post_id = {$commentPostId}";
        // $comment_result = mysqli_query($connection, $query);
        // $row = mysqli_fetch_assoc($comment_result);
        // $postTitle = $row['post_title'];
        // echo "<td><a href='../post.php?p_id=$commentPostId'>$postTitle</a></td>";
        // echo "<td>$commentPostId</td>";

        echo "<td>$userRole</td>";
        // echo "<td></td>";
        echo "<td><a href='users.php?source=edit_user&u_id=$userId'>Edit</a></td>";
        echo "<td><a href='users.php?delete=$userId'>Delete</a></td>";
        echo "</tr>";
      }
    ?>
  </tbody>
</table>

<?php
if (isset($_GET['delete'])) {
  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    $userId = $_GET['delete'];
    $query = "DELETE FROM users WHERE user_id = {$userId}";
    $result = mysqli_query($connection, $query);
    header("location: users.php");
  }
}
?>
