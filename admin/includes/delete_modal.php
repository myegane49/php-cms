<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Delete Confirm</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Are you sure you want to delete?</h3>
      </div>
      <div class="modal-footer">
        <form action="" method="post" style="display: inline;">
          <input type="hidden" name="post_id" class="post_delete_input">
          <input type="submit" class="btn btn-danger" value="Delete" name="delete">
        </form>
        <!-- <button type="button" class="btn btn-danger modal_delete_link">Delete</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>