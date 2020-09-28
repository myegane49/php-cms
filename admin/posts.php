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
                          case 'add_post':
                            include 'includes/add_post.php';
                            break;
                          case 'edit_post':
                            include 'includes/edit_post.php';
                            break;
                          default:
                            include 'includes/view_posts.php';
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

    <script src="../ckeditor/ckeditor.js"></script>
    <script>
      ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
      
    </script>

    <script>
      $(document).ready(() => {
        $('#selectAllBoxes').change(function() {
          if (this.checked) {
            $('.checkBoxes').each(function() {
              this.checked = true;
            })
          } else {
            $('.checkBoxes').each(function() {
              this.checked = false;
            })
          }
        })
      })

      document.querySelector('.user-table').addEventListener('click', (event) => {
        if (event.target.className.includes('deleteBtn')) {
          const postId = event.target.dataset.postid;
          // const sure = confirm('Are you sure you wanna delete?');
          // if (sure) {
          //   location.href = './posts.php?delete=' + postId
          // }

          $('#confirmModal').modal('show');
          document.querySelector('.modal_delete_link').addEventListener('click', () => {
            location.href = './posts.php?delete=' + postId
          })

        } 
      })
    </script>
</body>
</html>
