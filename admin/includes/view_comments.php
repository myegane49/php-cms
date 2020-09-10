<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Author</th>
      <th>Comment</th>
      <th>Email</th>
      <th>Status</th>
      <th>In Response to</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $query = "SELECT * FROM comments";
      $result = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        $commentId = $row['comment_id'];
        $commentAuthor = $row['comment_author'];
        $commentEmail = $row['comment_email'];
        $commentPostId = $row['comment_post_id'];
        $commentStatus = $row['comment_status'];
        $commentDate = $row['comment_date'];
        $commentContent = $row['comment_content'];

        echo "<tr>";
        echo "<td>$commentId</td>";
        echo "<td>$commentAuthor</td>";
        echo "<td>$commentContent</td>";
        echo "<td>$commentEmail</td>";
        echo "<td>$commentStatus</td>";

        $query = "SELECT * FROM posts WHERE post_id = {$commentPostId}";
        $comment_result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($comment_result);
        $postTitle = $row['post_title'];
        echo "<td><a href='../post.php?p_id=$commentPostId'>$postTitle</a></td>";
        // echo "<td>$commentPostId</td>";

        echo "<td>$commentDate</td>";
        echo "<td><a href='comments.php?approve=$commentId'>Approve</a></td>";
        echo "<td><a href='comments.php?unapprove=$commentId'>Unapprove</a></td>";
        echo "<td><a href='comments.php?delete=$commentId'>Delete</a></td>";
        echo "</tr>";
      }
    ?>
  </tbody>
</table>

<?php
if (isset($_GET['approve'])) {
  $commentId = $_GET['approve'];
  $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$commentId}";
  $approve_result = mysqli_query($connection, $query);
  header("location: comments.php");
}

if (isset($_GET['unapprove'])) {
  $commentId = $_GET['unapprove'];
  $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$commentId}";
  $unapprove_result = mysqli_query($connection, $query);
  header("location: comments.php");
}

if (isset($_GET['delete'])) {
  $commentId = $_GET['delete'];
  $query = "DELETE FROM comments WHERE comment_id = {$commentId}";
  $result = mysqli_query($connection, $query);
  header("location: comments.php");
}
?>
