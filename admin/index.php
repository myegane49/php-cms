<?php include './includes/admin_head.php'; ?>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include './includes/admin_navigation.php'; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <!-- /.row -->
                                            
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                <?php 
                                    $posts_query = "SELECT * FROM posts";
                                    $posts_result = mysqli_query($connection, $posts_query);
                                    $posts_count = mysqli_num_rows($posts_result)
                                ?>
                                <div class='huge'><?php echo $posts_count; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php 
                                        $comments_query = "SELECT * FROM comments";
                                        $comments_result = mysqli_query($connection, $comments_query);
                                        $comments_count = mysqli_num_rows($comments_result)
                                    ?>
                                    <div class='huge'><?php echo $comments_count; ?></div>
                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php 
                                        $users_query = "SELECT * FROM users";
                                        $users_result = mysqli_query($connection, $users_query);
                                        $users_count = mysqli_num_rows($users_result)
                                    ?>
                                    <div class='huge'><?php echo $users_count; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php 
                                        $categories_query = "SELECT * FROM categories";
                                        $categories_result = mysqli_query($connection, $categories_query);
                                        $categories_count = mysqli_num_rows($categories_result)
                                    ?>
                                        <div class='huge'><?php echo $categories_count; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <?php 
                    $posts_draft_query = "SELECT * FROM posts WHERE post_status = 'draft'";
                    $posts_draft_result = mysqli_query($connection, $posts_draft_query);
                    $posts_draft_count = mysqli_num_rows($posts_draft_result);

                    $posts_published_query = "SELECT * FROM posts WHERE post_status = 'published'";
                    $posts_published_result = mysqli_query($connection, $posts_published_query);
                    $posts_published_count = mysqli_num_rows($posts_published_result);

                    $comment_unapproved_query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                    $comment_unapproved_result = mysqli_query($connection, $comment_unapproved_query);
                    $comment_unapproved_count = mysqli_num_rows($comment_unapproved_result);

                    $users_subscriber_query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                    $users_subscriber_result = mysqli_query($connection, $users_subscriber_query);
                    $users_subscriber_count = mysqli_num_rows($users_subscriber_result);
                ?>
                <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            <?php
                                $element_text = ['All Posts', 'Draft Posts', 'Published Posts', 'Comments', 'Unapproved Comments', 'Users', 'Subscribers', 'Categories'];
                                $element_count = [$posts_count, $posts_draft_count, $posts_published_count, $comments_count, $comment_unapproved_count, $users_count, $users_subscriber_count, $categories_count];
                                for ($i = 0; $i < 7; $i++) {
                                    echo "['{$element_text[$i]}', {$element_count[$i]}],";
                                }
                            ?>
                            ]);

                            var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }

                    </script>
                    <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

 <?php include './includes/admin_footer.php'; ?>

 </body>
</html>
