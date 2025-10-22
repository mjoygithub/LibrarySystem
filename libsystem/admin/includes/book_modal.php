<!-- ===================== ADD BOOK MODAL ===================== -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog modal-lg custom-modal-width">
    <div class="modal-content" style="background-color:#ffffff; color:#000;">
      <div class="modal-header" style="background-color:#006400; color:#FFD700;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFD700;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><b>Add New Book</b></h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="book_add.php">

          <!-- ISBN -->
          <div class="form-group">
            <label class="col-sm-3 control-label">ISBN</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="isbn" required>
            </div>
          </div>

          <!-- Call No -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Call No.</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="call_no" required>
            </div>
          </div>

          <!-- Title -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="title" required></textarea>
            </div>
          </div>

          <!-- Category -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Category</label>
            <div class="col-sm-9 category-box">
              <?php
                $sql = "SELECT * FROM category ORDER BY name ASC";
                $query = $conn->query($sql);
                while($crow = $query->fetch_assoc()){
                  echo "
                    <div class='checkbox'>
                      <label>
                        <input type='checkbox' name='category[]' value='".htmlspecialchars($crow['id'])."'>
                        ".htmlspecialchars($crow['name'])."
                      </label>
                    </div>
                  ";
                }
              ?>
            </div>
          </div>

          <!-- Author -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Author</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="author">
            </div>
          </div>

          <!-- Publisher -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Publisher</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="publisher">
            </div>
          </div>

          <!-- Number of Copies -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Number of Copies</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="num_copies" min="1" value="1" required>
            </div>
          </div>

          <!-- Publish Date -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Publish Date</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="pub_date" placeholder="YYYY-MM-DD or YYYY">
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="form-group text-center" style="margin-top:20px;">
            <button type="submit" name="add" class="btn btn-success btn-flat" style="background-color:#FFD700; color:#006400; border:none;">
              <i class="fa fa-save"></i> Add Book
            </button>
          </div>

        </form>
      </div>

      <div class="modal-footer" style="background-color:#f5f5f5;">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal" style="background-color:#006400; color:#FFD700; border:none;">
          <i class="fa fa-close"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ===================== EDIT BOOK MODAL ===================== -->
<div class="modal fade" id="edit">
  <div class="modal-dialog modal-lg custom-modal-width">
    <div class="modal-content" style="background-color:#ffffff; color:#000;">
      
      <!-- Modal Header -->
      <div class="modal-header" style="background-color:#006400; color:#FFD700;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFD700;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><b>Edit Book</b></h4>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="book_edit.php">
          <input type="hidden" id="edit_id" name="id">

          <!-- ISBN -->
          <div class="form-group">
            <label class="col-sm-3 control-label">ISBN</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_isbn" name="isbn" required>
            </div>
          </div>

          <!-- Call No -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Call No.</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_call_no" name="call_no" required>
            </div>
          </div>

          <!-- Title -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="edit_title" name="title" required></textarea>
            </div>
          </div>

          <!-- Category -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Category</label>
            <div class="col-sm-9 category-box">
              <?php
                $sql = "SELECT * FROM category ORDER BY name ASC";
                $query = $conn->query($sql);
                while($crow = $query->fetch_assoc()){
                  echo "
                    <div class='checkbox'>
                      <label>
                        <input type='checkbox' name='category[]' value='".htmlspecialchars($crow['id'])."'>
                        ".htmlspecialchars($crow['name'])."
                      </label>
                    </div>
                  ";
                }
              ?>
            </div>
          </div>

          <!-- Author -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Author</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_author" name="author">
            </div>
          </div>

          <!-- Publisher -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Publisher</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_publisher" name="publisher">
            </div>
          </div>

          <!-- Publish Date -->
          <div class="form-group">
            <label class="col-sm-3 control-label">Publish Date</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="datepicker_edit" name="pub_date" placeholder="YYYY-MM-DD or YYYY">
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="form-group text-center" style="margin-top:20px;">
            <button type="submit" name="edit" class="btn btn-success btn-flat" style="background-color:#FFD700; color:#006400; border:none;">
              <i class="fa fa-check-square-o"></i> Update Book
            </button>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer" style="background-color:#f5f5f5;">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal" style="background-color:#006400; color:#FFD700; border:none;">
          <i class="fa fa-close"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>





<!-- ===================== DELETE BOOK MODAL ===================== -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#ffffff; color:#000;">
      <div class="modal-header" style="background-color:#006400; color:#FFD700;">
        <button type="button" class="close" data-dismiss="modal" style="color:#FFD700;">&times;</button>
        <h4 class="modal-title"><b>Deleting...</b></h4>
      </div>
      <div class="modal-body text-center">
        <form class="form-horizontal" method="POST" action="book_delete.php">
          <input type="hidden" class="bookid" name="id">
          <p>DELETE BOOK</p>
          <h2 id="del_book" class="bold"></h2>
      </div>
      <div class="modal-footer" style="background-color:#f5f5f5;">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal" style="background-color:#006400; color:#FFD700; border:none;">
          <i class="fa fa-close"></i> Close
        </button>
        <button type="submit" class="btn btn-danger btn-flat" name="delete" style="background-color:#FFD700; color:#006400; border:none;">
          <i class="fa fa-trash"></i> Delete
        </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ===================== MODAL CSS ===================== -->
<style>
.category-box {
  max-height: 220px;
  overflow-y: auto;
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 4px;
}

.custom-modal-width {
  max-width: 900px;
  width: 90%;
}

.modal-body {
  overflow-y: auto;
  max-height: calc(100vh - 180px);
}

.modal-open {
  overflow: hidden !important;
  padding-right: 0 !important;
}

@media (max-width: 768px) {
  .custom-modal-width {
    width: 95%;
    margin: 10px auto;
  }
}

.modal-content {
  border-radius: 10px;
  box-shadow: 0 5px 25px rgba(0,0,0,0.3);
}
</style>
