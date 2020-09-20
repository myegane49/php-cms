<!DOCTYPE html>
<html lang="en">
<head>
  <?php include './includes/db.php'; ?>
  <?php include './includes/head.php'; ?>
</head>
<body>
    <!-- Navigation -->
    <?php include './includes/navigation.php'; ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php include './includes/header.php'; ?>
                <?php
                  if (isset($_POST['submitSearch'])) {
                    $search = $_POST['search'];
                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' AND post_status = 'published'";
                    $result = mysqli_query($connection, $query);
                    $count = mysqli_num_rows($result);

                    if ($count == 0) {
                      echo '<h1>No Results!</h1>';
                    } else {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $postId = $row['post_id'];
                        $postTitle = $row['post_title'];
                        $postAuthor = $row['post_author'];
                        $postDate = $row['post_date'];
                        $postImage = $row['post_image'];
                        $postContent = substr($row['post_content'], 0, 100);
                      ?>
                      <h2>
                          <a href="post.php?p_id=<?php echo $postId; ?>"><?php echo $postTitle ?></a>
                      </h2>
                      <p class="lead">
                          by <a href="index.php"><?php echo $postAuthor ?></a>
                      </p>
                      <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $postDate ?></p>
                      <hr>
                      <a href="post.php?p_id=<?php echo $postId; ?>" style="display: block;">
                        <img class="img-responsive" src="images/<?php echo $postImage; ?>" alt="">
                      </a>
                      <hr>
                      <p><?php echo $postContent ?></p>
                      <a class="btn btn-primary" href="post.php?p_id=<?php echo $postId; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                      <hr>
                  <?php } ?>

                  <?php
                    }
                  } else {
                    $query = "SELECT * FROM posts WHERE post_status = 'published'";
                    $result = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                      $postId = $row['post_id'];
                      $postTitle = $row['post_title'];
                      $postAuthor = $row['post_author'];
                      $postDate = $row['post_date'];
                      $postImage = $row['post_image'];
                      $postContent = substr($row['post_content'], 0, 100);
                  ?>

                    <h2>
                        <a href="post.php?p_id=<?php echo $postId; ?>"><?php echo $postTitle ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $postAuthor ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $postDate ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $postId; ?>" style="display: block;">
                      <img class="img-responsive" src="images/<?php echo $postImage; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $postContent ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $postId; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>

                <?php
                    }
                  }
                ?>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include './includes/sidebar.php'; ?>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
        <?php include './includes/footer.php'; ?>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
