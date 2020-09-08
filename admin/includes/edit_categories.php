<form action="" method="post">
  <div class="form-group">
    <label>Edit Category</label>
    <?php
      // if (isset($_GET['edit'])) {
        // $catId = $_GET['edit'];
        $query = "SELECT * FROM categories WHERE cat_id = '$catId'";
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
          // $catId = $row['cat_id'];
          $catTitle = $row['cat_title'];
      ?>

        <input type="text" class="form-control" name="cat_title"
          value="<?php if (isset($catTitle)) {echo $catTitle;} ?>">

      <?php
        }
      // }
    ?>

  <?php
    if (isset($_POST['edit_cat'])) {
      $catTitle = $_POST['cat_title'];
      $query = "UPDATE categories SET cat_title = '$catTitle' WHERE cat_id = '$catId'";
      $result = mysqli_query($connection, $query);
    }
  ?>

  </div>
  <div class="form-group">
    <input type="submit" name="edit_cat" value="Edit" class="btn btn-primary">
  </div>
</form>
