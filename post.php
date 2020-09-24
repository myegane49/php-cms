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
                  if (isset($_GET['p_id'])) {
                    $postId = $_GET['p_id'];

                    $update_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$postId}";
                    $views_result = mysqli_query($connection, $update_query);

                    $query = "SELECT * FROM posts WHERE post_id = {$postId}";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $postTitle = $row['post_title'];
                    $postAuthor = $row['post_author'];
                    $postDate = $row['post_date'];
                    $postImage = $row['post_image'];
                    $postContent = $row['post_content'];
                  ?>

                    <h2>
                        <a href="#"><?php echo $postTitle ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $postAuthor ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $postDate ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $postImage; ?>" alt="">
                    <hr>
                    <p><?php echo $postContent ?></p>
                    <hr>

                <?php } ?>

                <!-- Blog Comments -->
                <?php
                  if(isset($_POST['create_comment'])) {
                    $postId = $_GET['p_id'];
                    $commentAuthor = $_POST['comment_author'];
                    $commentEmail = $_POST['comment_email'];
                    $commentContent = $_POST['comment_content'];

                    if (!empty($commentAuthor) && !empty($commentEmail) && !empty($commentContent)) {
                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_date, comment_content, comment_status) ";
                        $query .= "VALUES ({$postId}, '{$commentAuthor}', '{$commentEmail}', NOW(), '{$commentContent}', 'unapproved')";
                        $result_comment = mysqli_query($connection, $query);
                        if (!$result_comment) {
                          echo mysqli_error($connection);
                        }
    
                        $post_query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = {$postId}";
                        $result_update_post = mysqli_query($connection, $post_query);
                    } else {
                        echo "<script>alert('Fields cannot be empty!')</script>";
                    }

                  }
                ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                          <label>Author</label>
                            <input class="form-control" type="text" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label>Your Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                $query = "SELECT * FROM comments WHERE comment_post_id = {$postId} AND comment_status = 'approved' ORDER BY comment_id DESC";
                $result_all_comments = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result_all_comments)) {
                  $commentDate = $row['comment_date'];
                  $commentContent = $row['comment_content'];
                  $commentAuthor = $row['comment_author'];
                ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $commentAuthor; ?>
                            <small><?php echo $commentDate; ?></small>
                        </h4>
                        <?php echo $commentContent; ?>
                    </div>
                </div>

              <?php } ?>

                <!-- Comment -->


                <!-- Comment -->
                <!-- <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. -->
                        <!-- Nested Comment -->
                        <!-- <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div> -->
                        <!-- End Nested Comment -->
                    <!-- </div>
                </div> -->

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
