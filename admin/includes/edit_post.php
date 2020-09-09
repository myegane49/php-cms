<?php
if (isset($_GET['p_id'])) {
  $postId = $_GET['p_id'];
  $query = "SELECT * FROM posts WHERE post_id = {$postId}";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);

  $postId = $row['post_id'];
  $postAuthor = $row['post_author'];
  $postTitle = $row['post_title'];
  $postCatId = $row['post_category_id'];
  $postStatus = $row['post_status'];
  $postImage = $row['post_image'];
  $postContent = $row['post_content'];
  $postTags = $row['post_tags'];
  $postCommentCount = $row['post_comment_count'];
  $postDate = $row['post_date'];

}
if (isset($_POST['edit_post'])) {
  $postAuthor = $_POST['post_author'];
  $postTitle = $_POST['post_title'];
  $postCatId = $_POST['post_category_id'];
  $postStatus = $_POST['post_status'];
  $postImage = $_FILES['image']['name'];
  $postImageTemp = $_FILES['image']['tmp_name'];
  $postContent = $_POST['post_content'];
  $postTags = $_POST['post_tags'];

  if (empty($postImage)) {
    $query = "SELECT * FROM posts WHERE post_id = {$postId}";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $postImage = $row['post_image'];
  } else {
    move_uploaded_file($postImageTemp, "../images/$postImage");
  }

  $query = "UPDATE posts SET post_title = '{$postTitle}', post_author = '{$postAuthor}', post_category_id = '{$postCatId}', ";
  $query .= "post_status = '{$postStatus}', post_date = NOW(), post_tags = '{$postTags}', post_content = '{$postContent}', ";
  $query .= "post_image = '{$postImage}' WHERE post_id = {$postId}";
  $result = mysqli_query($connection, $query);
  queryErrorHandler($result);
}
?>

<form action="" method="post" enctype="multipart/form-data">
     <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $postTitle; ?>" type="text" class="form-control" name="post_title">
     </div>

     <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category_id">
          <?php
          $query = "SELECT * FROM categories";
          $result = mysqli_query($connection, $query);
          queryErrorHandler($result);

          while ($row = mysqli_fetch_assoc($result)) {
            $catTitle = $row['cat_title'];
            $catId = $row['cat_id'];

            if ($catId === $postCatId) {
              echo "<option selected value='{$catId}'>{$catTitle}</option>";
            } else {
              echo "<option value='{$catId}'>{$catTitle}</option>";
            }

          }
          ?>
        </select>
     </div>

     <!-- <div class="form-group">
      <label for="users">Users</label>
      <select name="post_user" id="">

      </select>
     </div> -->

     <div class="form-group">
        <label for="title">Post Author</label>
         <input value="<?php echo $postAuthor; ?>" type="text" class="form-control" name="post_author">
     </div>

     <div class="form-group">
        <label for="post_status">Post Status</label>
        <input value="<?php echo $postStatus; ?>" type="text" class="form-control" name="post_status">
     </div>

      <!-- <div class="form-group">
        <select name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
     </div> -->

    <div class="form-group">
      <img src="<?php echo '../images/' . $postImage; ?>" alt="" width="200">
        <label for="post_image">Post Image</label>
         <input type="file"  name="image">
     </div>

     <div class="form-group">
        <label for="post_tags">Post Tags</label>
         <input value="<?php echo $postTags; ?>" type="text" class="form-control" name="post_tags">
     </div>

     <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="" cols="30" rows="10"><?php echo $postContent; ?></textarea>
     </div>

      <div class="form-group">
         <input class="btn btn-primary" type="submit" name="edit_post" value="Edit Post">
     </div>

</form>
