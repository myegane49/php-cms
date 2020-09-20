<?php
if (isset($_POST['create_post'])) {
   $post_title        = $_POST['post_title'];
   $post_author       = $_POST['post_author'];
   $post_category_id  = $_POST['post_category'];
   $post_status       = $_POST['post_status'];

   $post_image        = $_FILES['image']['name'];
   $post_image_temp   = $_FILES['image']['tmp_name'];

   $post_tags         = $_POST['post_tags'];
   $post_content      = $_POST['post_content'];
   $post_date         = date('d-m-y'); // or you could use the NOW() function of the mysql

   move_uploaded_file($post_image_temp, "../images/$post_image");

   $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
   $query .= "VALUES ({$post_category_id},'{$post_title}','{$post_author}', NOW(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";
   $result = mysqli_query($connection, $query);
   queryErrorHandler($result);
}
?>

<form action="" method="post" enctype="multipart/form-data">
     <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
     </div>

     <div class="form-group">
      <label for="category">Category</label>
      <select name="post_category" id="">
        <?php
        $query = "SELECT * FROM categories";
        $result = mysqli_query($connection, $query);
        queryErrorHandler($result);

        while ($row = mysqli_fetch_assoc($result)) {
          $catTitle = $row['cat_title'];
          $catId = $row['cat_id'];
          echo "<option value='{$catId}'>{$catTitle}</option>";
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
         <input type="text" class="form-control" name="post_author">
     </div>

     <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status">
          <option value="draft">Draft</option>
          <option value="published">Published</option>
        </select>
     </div>

      <!-- <div class="form-group">
        <select name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
     </div> -->

    <div class="form-group">
        <label for="post_image">Post Image</label>
         <input type="file"  name="image">
     </div>

     <div class="form-group">
        <label for="post_tags">Post Tags</label>
         <input type="text" class="form-control" name="post_tags">
     </div>

     <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="body" cols="30" rows="10"></textarea>
     </div>

      <div class="form-group">
         <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
     </div>

</form>
