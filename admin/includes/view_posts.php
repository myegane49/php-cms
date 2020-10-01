<?php
include 'delete_modal.php';
?>

<?php
  if (isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $checkBoxValue) {
      $bulk_options = $_POST['bulk_options'];
      
      switch($bulk_options) {
        case 'published':
          $query = "UPDATE posts SET post_status = 'published' WHERE post_id = {$checkBoxValue}";
          $publish_result = mysqli_query($connection, $query);
          break;
        case 'draft':
          $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = {$checkBoxValue}";
          $draft_result = mysqli_query($connection, $query);
          break;
        case 'delete':
          $query = "DELETE FROM posts WHERE post_id = {$checkBoxValue}";
          $delete_result = mysqli_query($connection, $query);
          break;
        case 'clone':
          $query = "SELECT * FROM posts WHERE post_id = {$checkBoxValue}";
          $clone_result = mysqli_query($connection, $query);
          $row = mysqli_fetch_assoc($clone_result);

          $post_title = $row['post_title'];
          $post_author = $row['post_author'];
          $post_category_id = $row['post_category_id'];
          $post_status = $row['post_status'];
          $post_image = $row['post_image'];
          $post_tags = $row['post_tags'];
          $post_content = $row['post_content'];

          $query_clone = "INSERT INTO posts (post_title, post_author, post_category_id, post_status, post_image, post_tags, post_content, post_date) VALUES ('{$post_title}', '{$post_author}', '{$post_category_id}', '{$post_status}', '{$post_image}', '{$post_tags}', '{$post_content}', NOW())";
          $result_clone = mysqli_query($connection, $query_clone);
      }
    }
  } 
?>

<form method="post" action="">
  <table class="table table-bordered table-hover user-table">
    <div id="bulkOptionsContainer"  class="col-xs-4" style="padding-left: 0; padding-bottom: 1rem;">
      <select name="bulk_options" class="form-control">
        <option value="">Select Option</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
      </select>
    </div>
    <div class="col-xs 4">
      <input type="submit" name="submit" class="btn btn-success" value="Apply">
      <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>

    <thead>
      <tr>
        <th><input type="checkbox" id="selectAllBoxes"></th>
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Dates</th>
        <th>Views</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // $query = "SELECT * FROM posts ORDER BY post_id DESC";
        $query = "SELECT post_id, post_author, post_title, post_status, post_image, post_tags, post_date, post_views_count, cat_title, IFNULL(COUNT(comment_post_id), 0) AS comment_count FROM posts JOIN categories ON post_category_id = cat_id LEFT JOIN comments ON post_id = comment_post_id GROUP BY post_id";
        
        $result = mysqli_query($connection, $query);
        if (!$result) {
          echo mysqli_error($result);
        }
        while ($row = mysqli_fetch_assoc($result)) {
          $postId = $row['post_id'];
          $postAuthor = $row['post_author'];
          $postTitle = $row['post_title'];
          // $postCatId = $row['post_category_id'];
          $postStatus = $row['post_status'];
          $postImage = $row['post_image'];
          $postTags = $row['post_tags'];
          // $postCommentCount = $row['post_comment_count'];
          $postDate = $row['post_date'];
          $postViews = $row['post_views_count'];
          $catTitle = $row['cat_title'];
          $comment_count = $row['comment_count'];

          echo "<tr>";
          echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$postId'></td>";
          echo "<td>$postId</td>";
          echo "<td>$postAuthor</td>";
          echo "<td><a href='../post.php?p_id=$postId'>$postTitle</a></td>";

          // $query = "SELECT * FROM categories WHERE cat_id = {$postCatId}";
          // $category_result = mysqli_query($connection, $query);
          // $row = mysqli_fetch_assoc($category_result);
          // $catTitle = $row['cat_title'];
          echo "<td>$catTitle</td>";

          echo "<td>$postStatus</td>";
          echo "<td><img src='../images/$postImage' width='100'></td>";
          echo "<td>$postTags</td>";

          // echo "<td>$postCommentCount</td>";
          // $comment_count_query = "SELECT COUNT(*) AS comment_count_col FROM comments WHERE comment_post_id = $postId";
          // $comment_count_result = mysqli_query($connection, $comment_count_query);
          // $comment_count = mysqli_fetch_assoc($comment_count_result)['comment_count_col'];

          echo "<td><a href='comments.php?source=post_comments&post_id=$postId'>$comment_count</a></td>";

          echo "<td>$postDate</td>";
          echo "<td>$postViews <a href='posts.php?reset=$postId'>reset</a></td>";
          echo "<td><a href='../post.php?p_id=$postId'>View Post</a></td>";
          echo "<td><a href='posts.php?source=edit_post&p_id=$postId'>Edit</a></td>";
          echo "<td><a class='deleteBtn' data-postid='$postId' style='cursor: pointer;'>Delete</a></td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</form>


<?php
// if (isset($_GET['delete'])) {
//   $postId = $_GET['delete'];
//   $query = "DELETE FROM posts WHERE post_id = {$postId}";
//   $result = mysqli_query($connection, $query);
//   header("location: posts.php");
// }
  // posts.php?delete=$postId

  if (isset($_POST['delete'])) {
    $postId = $_POST['post_id'];
    $query = "DELETE FROM posts WHERE post_id = {$postId}";
    $result = mysqli_query($connection, $query);
    header("location: posts.php");
  }
?>

<?php
  if (isset($_GET['reset'])) {
    $postId = $_GET['reset'];
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$postId}";
    $result = mysqli_query($connection, $query);
    header("location: posts.php");
  }
?>
