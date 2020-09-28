<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="index.php" method="post">
          <div class="input-group">
            <input type="text" class="form-control" name="search">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit" name="submitSearch">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Login -->
    <div class="well">
      <?php
        if (isset($_SESSION['user_role'])) {
          $username = $_SESSION['username'];
          echo "<h4>Logged in as $username</h4>";
          echo "<a class='btn btn-primary' href='includes/logout.php'>Logout</a>";
        } else {
        ?>
          <h4>Login</h4>
          <form action="includes/login.php" method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="username" placeholder="Enter Username">
            </div>
            <div class="input-group">
              <input type="password" class="form-control" name="password" placeholder="Enter Password">
              <span class="input-group-btn">
                <button class="btn btn-primary" name="login" type="submit">Submit</button>
              </span>
            </div>
          </form>

        <?php
          }
        ?>
        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                  <?php
                    $query = "SELECT * FROM categories";
                    $result = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                      $catTitle = $row['cat_title'];
                      $catId = $row['cat_id'];
                      echo "<li><a href='index.php?cat_id=$catId'>$catTitle</a></li>";
                    }
                  ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include 'widget.php'; ?>
</div>
