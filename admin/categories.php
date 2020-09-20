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

                        <div class="col-xs-6">
                          <?php insert_categories(); ?>
                          <form action="" method="post">
                            <div class="form-group">
                              <label>Add Category</label>
                              <input type="text" class="form-control" name="cat_title" value="">
                            </div>
                            <div class="form-group">
                              <input type="submit" name="add_cat" value="Add" class="btn btn-primary">
                            </div>
                          </form>

                          <?php
                            if (isset($_GET['edit'])) {
                              $catId = $_GET['edit'];
                              include 'includes/edit_categories.php';
                            }
                          ?>
                        </div>

                        <div class="col-xs-6">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Category Title</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php findAllCategories(); ?>
                              <?php deleteCategories(); ?>
                            </tbody>
                          </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
