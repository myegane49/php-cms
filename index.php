<!DOCTYPE html>
<html lang="en">
<head>
  <?php include './includes/db.php'; ?>
  <?php include './includes/head.php'; ?>
  <?php include './admin/functions.php'; ?>
</head>
<body>
    <!-- Navigation -->
    <?php include './includes/navigation.php'; ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <!-- <?php include './includes/header.php'; ?> -->
                <?php
                  $posts_per_page = 3;
                  $page = "";
                  $published = 'published';
                  $statement = '';
                  
                  if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                  }

                  if ($page === "" || $page === 1) {
                    $skip = 0;
                  } else {
                    $skip = ($page * $posts_per_page) - $posts_per_page;
                  }

                  if (isset($_POST['submitSearch'])) {
                    $search = $_POST['search'];
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                      $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' LIMIT {$skip}, {$posts_per_page}";
                      $posts_count_query = "SELECT COUNT(*) AS postCount FROM posts WHERE post_tags LIKE '%$search%'";
                    } else {
                      $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' AND post_status = 'published' LIMIT {$skip}, {$posts_per_page}";
                      $posts_count_query = "SELECT COUNT(*) AS postCount FROM posts WHERE post_tags LIKE '%$search%' AND post_status = 'published'";
                    }
                  } else if (isset($_GET['cat_id'])) {
                    $catId = $_GET['cat_id'];
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                      $query = "SELECT * FROM posts WHERE post_category_id = {$catId} LIMIT {$skip}, {$posts_per_page}";
                      // $statement = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? LIMIT {$skip}, {$posts_per_page}");                      
                      $posts_count_query = "SELECT COUNT(*) AS postCount FROM posts WHERE post_category_id = {$catId}";
                    } else {
                      $query = "SELECT * FROM posts WHERE post_category_id = {$catId} AND post_status = 'published' LIMIT {$skip}, {$posts_per_page}";
                      // $statement = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? LIMIT {$skip}, {$posts_per_page}");
                      $posts_count_query = "SELECT COUNT(*) AS postCount FROM posts WHERE post_category_id = {$catId} AND post_status = 'published'";
                    }
                    
                    
                  } else if (isset($_GET['author'])) {
                    $author = $_GET['author'];
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                      $query = "SELECT * FROM posts WHERE post_author = '{$author}' LIMIT {$skip}, {$posts_per_page}";
                      $posts_count_query = "SELECT COUNT(*) AS postCount FROM posts WHERE post_author = '{$author}'";
                    } else {
                      $query = "SELECT * FROM posts WHERE post_author = '{$author}' AND post_status = 'published' LIMIT {$skip}, {$posts_per_page}";
                      $posts_count_query = "SELECT COUNT(*) AS postCount FROM posts WHERE post_author = '{$author}' AND post_status = 'published'";
                    }
                    
                    
                  } else {
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                      $query = "SELECT * FROM posts LIMIT {$skip}, {$posts_per_page}";
                      $posts_count_query = "SELECT COUNT(*) AS postCount FROM posts";
                    } else {
                      $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT {$skip}, {$posts_per_page}";
                      $posts_count_query = "SELECT COUNT(*) AS postCount FROM posts WHERE post_status = 'published'";
                    }
                    
                  }

                  $count_result = mysqli_query($connection, $posts_count_query);
                  $row = mysqli_fetch_assoc($count_result);
                  $posts_count = $row['postCount'];
                  $pages_count = ceil($posts_count / $posts_per_page);

                  $result = mysqli_query($connection, $query);
                  $count = mysqli_num_rows($result);

                  // if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {                   
                  //   mysqli_stmt_bind_param($statement, "i", $catId);                   
                  // } else {            
                  //   mysqli_stmt_bind_param($statement, "is", $catId, $published);
                  // }                 
                  // mysqli_stmt_execute($statement);
                  // mysqli_stmt_bind_result($statement, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                  // $count = mysqli_stmt_num_rows($statement);
                  
                  if ($count == 0) {
                    echo '<h1>No Results!</h1>';                  
                  } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                    // while (mysqli_stmt_fetch($statement)) {
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
                          by <a href="index.php?author=<?php echo $postAuthor; ?>"><?php echo $postAuthor ?></a>
                      </p>
                      <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $postDate ?></p>
                      <hr>
                      <a href="post.php?p_id=<?php echo $postId; ?>" style="display: block;">
                        <img class="img-responsive" src="images/<?php echo postImage($postImage); ?>" alt="">
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
                    <!-- <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li> -->
                    <?php
                    if (isset($_GET['cat_id'])) {
                      $catId = $_GET['cat_id'];
                      for ($i = 1; $i <= $pages_count; $i++) {   
                        if ($i == $page || ($i === 1 && $page == '')) {
                          echo "<li><a class='active_link' href='index.php?cat_id=$catId&page={$i}'>{$i}</a></li>";
                        } else {                    
                          echo "<li><a href='index.php?cat_id=$catId&page={$i}'>{$i}</a></li>";
                        }
                      }
                    } else if (isset($_GET['author'])) {
                      $author = $_GET['author'];
                      for ($i = 1; $i <= $pages_count; $i++) {
                        if ($i == $page || ($i === 1 && $page == '')) {
                          echo "<li><a class='active_link' href='index.php?author=$author&page={$i}'>{$i}</a></li>";
                        } else {                
                          echo "<li><a href='index.php?author=$author&page={$i}'>{$i}</a></li>";
                        }
                      }
                    } else {
                      for ($i = 1; $i <= $pages_count; $i++) {   
                        if ($i == $page || ($i === 1 && $page == '')) {
                          echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                        } else {
                          echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                        }                    
                      }
                    }
                    ?>
                    <!-- <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li> -->
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
