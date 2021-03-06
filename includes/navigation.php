<?php session_start(); ?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <?php
                $query = "SELECT * FROM categories";
                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                  $catTitle = $row['cat_title'];
                  $cat_id = $row['cat_id'];
                  $active_class = null;
                  $currentCategory = $_GET['cat_id'];
                  if ($cat_id == $currentCategory) {
                    $active_class = 'active';
                  }
                  echo "<li class='$active_class'><a href='index.php?cat_id=$cat_id'>$catTitle</a></li>";
                }

                $active_page = basename($_SERVER['PHP_SELF']);
                
              ?>

              <?php if (isLoggedIn()): ?>
                <li><a href="admin/">Admin</a></li>
                <li><a href="includes/logout.php">Logout</a></li>
              <?php else: ?>
                <li><a href="login_page.php">Login</a></li>
              <?php endif; ?>
              <li class="<?php echo $active_page == 'registration.php' ? 'active': null; ?>"><a href="registration.php">Register</a></li>
              <li class="<?php echo $active_page == 'contact.php' ? 'active': null; ?>"><a href="contact.php">Contact</a></li>

              <?php
                
                // if (isset($_SESSION['user_role']) && isset($_GET['p_id'])) {
                if (isset($_SESSION['user_role'])) {
                    if (isset($_GET['p_id'])) {
                        $postId = $_GET['p_id'];
                        echo "<li><a href='admin/posts.php?source=edit_post&p_id=$postId'>Edit Post</a></li>";   
                    }
                }
              
              ?>

                <!--
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li> -->
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
