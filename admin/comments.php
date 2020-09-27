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
                          <small>Author</small>
                      </h1>

                      <?php
                        $source = '';
                        if (isset($_GET['source'])) {
                          $source = $_GET['source'];
                        }
                        switch ($source) {
                          case 'post_comments':
                            include 'includes/post_comments.php';
                            break;
                          default:
                            include 'includes/view_comments.php';
                            break;
                        }
                      ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <?php include './includes/admin_footer.php'; ?>

    </body>
</html>