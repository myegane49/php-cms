<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Dates</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $query = "SELECT * FROM posts";
      $result = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        $postId = $row['post_id'];
        $postAuthor = $row['post_author'];
        $postTitle = $row['post_title'];
        $postCatId = $row['post_category_id'];
        $postStatus = $row['post_status'];
        $postImage = $row['post_image'];
        $postTags = $row['post_tags'];
        $postCommentCount = $row['post_comment_count'];
        $postDate = $row['post_date'];

        echo "<tr>";
        echo "<td>$postId</td>";
        echo "<td>$postAuthor</td>";
        echo "<td>$postTitle</td>";
        echo "<td>$postCatId</td>";
        echo "<td>$postStatus</td>";
        echo "<td><img src='../images/$postImage' width='100'></td>";
        echo "<td>$postTags</td>";
        echo "<td>$postCommentCount</td>";
        echo "<td>$postDate</td>";
        echo "<td><a href='posts.php?delete=$postId'>Delete</a></td>";
        echo "<td><a href='posts.php?source=edit_post&p_id=$postId'>Edit</a></td>";
        echo "</tr>";
      }
    ?>
  </tbody>
</table>

<?php
if (isset($_GET['delete'])) {
  $postId = $_GET['delete'];
  $query = "DELETE FROM posts WHERE post_id = {$postId}";
  $result = mysqli_query($connection, $query);
  header("location: posts.php");
}
?>
