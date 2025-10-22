<?php
include 'includes/session.php';
include 'includes/header.php';
?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header" style="background-color:#006400;color:#FFD700;padding:15px;border-radius:5px 5px 0 0;">
      <h1 style="font-weight:bold;">📄 PDF Books</h1>
    </section>

    <section class="content" style="background-color:#F8FFF0;padding:15px;border-radius:0 0 5px 5px;">
      <?php
        include 'includes/conn.php';

        if(isset($_SESSION['error'])){
          echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "<div class='alert alert-success'>".$_SESSION['success']."</div>";
          unset($_SESSION['success']);
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="border-top:3px solid #006400;">
            <div class="box-header with-border" style="background-color:#F0FFF0;">
              <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat">
                <i class="fa fa-plus"></i> New PDF
              </a>
            </div>

            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead style="background-color:#006400;color:#FFD700;font-weight:bold;">
                  <th>#</th>
                  <th>Title</th>
                  <th>File</th>
                  <th class="text-center">Tools</th>
                </thead>
                <tbody>
                  <?php
                    $i = 1;
                    $query = $conn->query("SELECT * FROM pdf_books ORDER BY id DESC");
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".$i++."</td>
                          <td>".htmlspecialchars($row['title'])."</td>
                          <td><a href='uploads/pdf_books/".htmlspecialchars($row['file_path'])."' target='_blank'>View PDF</a></td>
                          <td class='text-center'>
                            <div class='btn-group'>
                              <button class='btn btn-primary btn-sm edit btn-flat' data-id='".$row['id']."' style='margin-right:5px;'>
                                <i class='fa fa-edit'></i> Edit
                              </button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'>
                                <i class='fa fa-trash'></i> Delete
                              </button>
                            </div>
                          </td>
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Add PDF Modal -->
  <div class="modal fade" id="addnew">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#32CD32;color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Add New PDF</b></h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="pdf_books_action.php" enctype="multipart/form-data">
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Upload PDF</label>
              <input type="file" name="pdf_file" class="form-control" accept=".pdf" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="upload" class="btn btn-success"><i class="fa fa-upload"></i> Upload</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit PDF Modal -->
  <div class="modal fade" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#006400;color:#FFD700;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Edit PDF</b></h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="pdf_books_action.php" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" id="edit_title" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Replace PDF (optional)</label>
              <input type="file" name="pdf_file" class="form-control" accept=".pdf">
              <small>Leave blank to keep current file.</small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  // Delete
  $(document).on('click', '.delete', function(){
    var id = $(this).data('id');
    if(confirm('Are you sure you want to delete this PDF?')){
      window.location = 'pdf_books_action.php?delete=' + id;
    }
  });

  // Edit
  $(document).on('click', '.edit', function(){
    var id = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: 'pdf_books_action.php',
      data: {id:id, getEdit:true},
      dataType: 'json',
      success: function(response){
        $('#edit_id').val(response.id);
        $('#edit_title').val(response.title);
        $('#editModal').modal('show');
      }
    });
  });
});
</script>
</body>
</html>
