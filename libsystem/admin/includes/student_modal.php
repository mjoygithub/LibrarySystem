<!-- Add -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content" style="border: 2px solid #006400;">
      <div class="modal-header" style="background-color:#006400; color:#FFD700; border: 2px solid #006400;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFD700;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><b><i class="fa fa-user-plus"></i> Add New Student</b></h4>
      </div>
      <div class="modal-body" style="background-color:#FFFFFF; border-left:2px solid #006400; border-right:2px solid #006400;">
        <form class="form-horizontal" method="POST" action="student_add.php">
          <div class="form-group">
            <label for="student_id" class="col-sm-3 control-label">Student ID</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
          </div>
          <div class="form-group">
            <label for="firstname" class="col-sm-3 control-label">Firstname</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
          </div>
          <div class="form-group">
            <label for="lastname" class="col-sm-3 control-label">Lastname</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
          </div>
          <div class="form-group">
            <label for="course" class="col-sm-3 control-label">Course</label>
            <div class="col-sm-9">
              <select class="form-control" id="course" name="course" required>
                <option value="" selected>- Select -</option>
                <?php
                  $sql = "SELECT * FROM course";
                  $query = $conn->query($sql);
                  while($row = $query->fetch_array()){
                    echo "<option value='".$row['id']."'>".$row['code']."</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
          </div>
      </div>
      <div class="modal-footer" style="background-color:#F0FFF0; border: 2px solid #006400;">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
          <i class="fa fa-close"></i> Close
        </button>
        <button type="submit" class="btn btn-success btn-flat" name="add" style="background-color:#006400; color:#FFD700;">
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
      <div class="modal-header" style="background-color:#006400; color:#FFD700; border: 2px solid #006400;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFD700;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><b><i class="fa fa-edit"></i> Edit Student</b></h4>
      </div>
      <div class="modal-body" style="background-color:#FFFFFF; border-left:2px solid #006400; border-right:2px solid #006400;">
        <form class="form-horizontal" method="POST" action="student_edit.php">
          <input type="hidden" class="studid" name="id">
          <div class="form-group">
            <label for="edit_firstname" class="col-sm-3 control-label">Firstname</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_firstname" name="firstname">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_lastname" class="col-sm-3 control-label">Lastname</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_lastname" name="lastname">
            </div>
          </div>
          <div class="form-group">
            <label for="course" class="col-sm-3 control-label">Course</label>
            <div class="col-sm-9">
              <select class="form-control" id="course" name="course" required>
                <option value="" selected id="selcourse"></option>
                <?php
                  $sql = "SELECT * FROM course";
                  $query = $conn->query($sql);
                  while($row = $query->fetch_array()){
                    echo "<option value='".$row['id']."'>".$row['code']."</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="edit_password" name="password" placeholder="Leave blank to keep current password">
            </div>
          </div>
      </div>
      <div class="modal-footer" style="background-color:#F0FFF0; border: 2px solid #006400;">
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
      <div class="modal-header" style="background-color:#006400; color:#FFD700; border: 2px solid #006400;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFD700;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><b><i class="fa fa-trash"></i> Delete Student</b></h4>
      </div>
      <div class="modal-body text-center" style="background-color:#FFFFFF; border-left:2px solid #006400; border-right:2px solid #006400;">
        <form class="form-horizontal" method="POST" action="student_delete.php">
          <input type="hidden" class="studid" name="id">
          <p style="font-size:16px;">Are you sure you want to delete?</p>
          <h3 class="del_stu bold" style="color:#B22222;"></h3>
      </div>
      <div class="modal-footer" style="background-color:#F0FFF0; border: 2px solid #006400;">
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
