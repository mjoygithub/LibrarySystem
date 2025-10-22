<!-- Borrow Books -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content" style="border: 2px solid #006400; background-color:#ffffff; color:#000;">
      
      <!-- Header -->
      <div class="modal-header" style="background-color: #006400; color: #FFD700;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFD700;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><b>Borrow Books</b></h4>
      </div>

      <!-- Body -->
      <div class="modal-body" style="background-color:#ffffff;">
        <form class="form-horizontal" method="POST" action="borrow_add.php">
          
          <!-- Student ID -->
          <div class="form-group">
            <label for="student" class="col-sm-3 control-label" style="font-weight:bold;">Student ID</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="student" name="student" placeholder="Enter Student ID" required>
            </div>
          </div>

          <!-- Student Phone -->
          <div class="form-group">
            <label for="phone" class="col-sm-3 control-label" style="font-weight:bold;">Phone</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Student Phone" required>
            </div>
          </div>

          <!-- ISBN -->
          <div class="form-group">
            <label for="isbn" class="col-sm-3 control-label" style="font-weight:bold;">ISBN</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="isbn" name="isbn[]" placeholder="Enter Book ISBN" required>
            </div>
          </div>

          <!-- Dynamic ISBN Fields -->
          <span id="append-div"></span>

          <!-- Add Another Book Button -->
          <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
              <button class="btn btn-flat btn-xs" id="append" type="button" 
                      style="background-color:#FFD700; color:#006400; border:none;">
                <i class="fa fa-plus"></i> Add Another Book
              </button>
            </div>
          </div>

          <!-- Return Due Date -->
          <div class="form-group">
            <label for="due_date" class="col-sm-3 control-label" style="font-weight:bold;">Return Date</label>
            <div class="col-sm-9">
              <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
          </div>

          <!-- Borrow Info -->
          <div class="form-group" style="margin-top:10px;">
            <div class="col-sm-12 text-center">
              <small style="color:#555;">
                <i class="fa fa-info-circle"></i> Please enter the student info and select the due date when books must be returned.
              </small>
            </div>
          </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer" style="background-color:#f5f5f5;">
        <button type="button" class="btn btn-flat pull-left" data-dismiss="modal" 
                style="background-color:#006400; color:#FFD700; border:none;">
          <i class="fa fa-close"></i> Close
        </button>
        <button type="submit" class="btn btn-flat" name="add" 
                style="background-color:#FFD700; color:#006400; border:none;">
          <i class="fa fa-save"></i> Save
        </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Add Dynamic ISBN JS -->
<script>
  document.getElementById("append").addEventListener("click", function() {
    const div = document.createElement("div");
    div.classList.add("form-group");
    div.innerHTML = `
      <label class="col-sm-3 control-label"></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="isbn[]" placeholder="Enter Book ISBN" required>
      </div>`;
    document.getElementById("append-div").appendChild(div);
  });
</script>
