<!-- Add -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content" style="border: 2px solid #006400;">
      <div class="modal-header" style="background-color:#006400; color:#FFD700;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><i class="fa fa-plus"></i> Add New Course</b></h4>
      </div>
      <div class="modal-body" style="background-color:white;">
        <form class="form-horizontal" method="POST" action="course_add.php">
          <div class="form-group">
            <label for="code" class="col-sm-3 control-label">Code</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="code" name="code" required>
            </div>
          </div>
          <div class="form-group">
            <label for="title" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="title" name="title" required>
            </div>
          </div>
      </div>
      <div class="modal-footer" style="background-color:#F0F0F0;">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
          <i class="fa fa-close"></i> Close
        </button>
        <button type="submit" class="btn btn-primary btn-flat" name="add" style="background-color:#006400; color:#FFD700;">
          <i class="fa fa-save"></i> Save
        </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content" style="border: 2px solid #006400;">
      <div class="modal-header" style="background-color:#006400; color:#FFD700;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><i class="fa fa-edit"></i> Edit Course</b></h4>
      </div>
      <div class="modal-body" style="background-color:white;">
        <form class="form-horizontal" method="POST" action="course_edit.php">
          <input type="hidden" class="corid" name="id">
          <div class="form-group">
            <label for="edit_code" class="col-sm-3 control-label">Code</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_code" name="code">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_title" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_title" name="title">
            </div>
          </div>
      </div>
      <div class="modal-footer" style="background-color:#F0F0F0;">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
          <i class="fa fa-close"></i> Close
        </button>
        <button type="submit" class="btn btn-success btn-flat" name="edit" style="background-color:#006400; color:#FFD700;">
          <i class="fa fa-check-square-o"></i> Update
        </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content" style="border: 2px solid #006400;">
      <div class="modal-header" style="background-color:#006400; color:#FFD700;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><i class="fa fa-trash"></i> Delete Course</b></h4>
      </div>
      <div class="modal-body text-center" style="background-color:white;">
        <form class="form-horizontal" method="POST" action="course_delete.php">
          <input type="hidden" class="corid" name="id">
          <p style="font-size:16px;">Are you sure you want to delete this course?</p>
          <h3 id="del_code" class="bold" style="color:#B22222;"></h3>
      </div>
      <div class="modal-footer" style="background-color:#F0F0F0;">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
          <i class="fa fa-close"></i> Close
        </button>
        <button type="submit" class="btn btn-danger btn-flat" name="delete" style="background-color:#006400; color:#FFD700;">
          <i class="fa fa-trash"></i> Delete
        </button>
        </form>
      </div>
    </div>
  </div>
</div>
