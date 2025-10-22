<?php
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/header.php';
?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <div class="content-wrapper">

    <section class="content-header" style="padding:15px;">
      <h1 style="font-weight:bold;">📚 Subjects</h1>
      <ol class="breadcrumb" style="background-color:transparent;">
        <li><a href="#" style="color:#FFD700;"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active" style="color:#FFD700;">Subjects</li>
      </ol>
    </section>

    <section class="content" style="padding:15px;">
      <?php
        if(isset($_SESSION['error'])){
          echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "<div class='alert alert-success'>".$_SESSION['success']."</div>";
          unset($_SESSION['success']);
        }
      ?>

      <div class="box" style="border-top:3px solid #006400; background-color:#FFFFFF; padding:15px;">

        <!-- Filter by subject dropdown -->
        <div class="form-group">
          <label>Select Subject to Show:</label>
          <select id="filterSubject" class="form-control">
            <option value="0">All Subjects</option>
            <?php
              $subject_query = $conn->query("SELECT * FROM subject ORDER BY name ASC");
              while($s = $subject_query->fetch_assoc()){
                echo "<option value='{$s['id']}'>".htmlspecialchars($s['name'])."</option>";
              }
            ?>
          </select>
        </div>

        <div id="subjectsContainer">
          <?php
          // Display subjects
          $subject_query = $conn->query("SELECT * FROM subject ORDER BY name ASC");
          while($subject = $subject_query->fetch_assoc()){
              echo "<div class='subject-block' data-subject='{$subject['id']}' style='margin-bottom:30px;'>
                      <h4 style='color:#006400;'>".htmlspecialchars($subject['name'])."</h4>";

              // Fetch books assigned to this subject
              $books_query = $conn->prepare("SELECT * FROM books WHERE subject_id = ?");
              $books_query->bind_param("i", $subject['id']);
              $books_query->execute();
              $books_result = $books_query->get_result();

              echo "<table class='table table-bordered table-striped'>
                      <thead style='background-color:#006400;color:#FFD700;'>
                        <tr>
                          <th>Title</th>
                          <th>Author</th>
                          <th>Publisher</th>
                        </tr>
                      </thead>
                      <tbody>";

              while($book = $books_result->fetch_assoc()){
                  echo "<tr>
                          <td>".htmlspecialchars($book['title'])."</td>
                          <td>".htmlspecialchars($book['author'])."</td>
                          <td>".htmlspecialchars($book['publisher'])."</td>
                        </tr>";
              }
              echo "</tbody></table>";

              // Manage books button
              echo "<button class='btn btn-primary btn-sm manageBooks' data-id='{$subject['id']}' data-name='".htmlspecialchars($subject['name'])."'>
                      <i class='fa fa-edit'></i> Assign Books
                    </button>";

              echo "</div>";
          }
          ?>
        </div>

      </div>

    </section>
  </div>
</div>

<?php include 'includes/scripts.php'; ?>

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="subject_add.php">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#006400;color:#FFD700;">
          <h4 class="modal-title">Add New Subject</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Subject Name</label>
            <input type="text" name="subject_name" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_subject" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Assign Books Modal -->
<div class="modal fade" id="assignBooksModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="subject_update_books.php">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#006400;color:#FFD700;">
          <h4 class="modal-title" id="assignBooksTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Search by Call No.</label>
            <input type="text" id="bookCallNoSearch" class="form-control" placeholder="Enter call no. to suggest books...">
          </div>
          <div id="assignBooksList">
            <!-- Suggested books loaded via AJAX -->
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="subject_id" id="subject_id">
          <button type="submit" class="btn btn-success">Save Changes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
$(function(){
  // Filter subjects
  $('#filterSubject').change(function(){
    var val = $(this).val();
    if(val == 0){
      $('.subject-block').show();
    } else {
      $('.subject-block').hide();
      $('.subject-block[data-subject="'+val+'"]').show();
    }
  });

  // Open Assign Books modal
  $('.manageBooks').click(function(){
    var subject_id = $(this).data('id');
    var subject_name = $(this).data('name');
    $('#subject_id').val(subject_id);
    $('#assignBooksTitle').text("Assign Books for: " + subject_name);
    $('#assignBooksList').html('');
    $('#bookCallNoSearch').val('');
    $('#assignBooksModal').modal('show');
  });

  // Type-ahead search for books by Call No
  $('#bookCallNoSearch').on('keyup', function(){
    var call_no = $(this).val();
    var subject_id = $('#subject_id').val();
    if(call_no.length >= 1){
      $.ajax({
        url: 'subject_books_suggest.php',
        method: 'GET',
        data: { call_no: call_no, subject_id: subject_id },
        success: function(data){
          $('#assignBooksList').html(data);
        }
      });
    } else {
      $('#assignBooksList').html('');
    }
  });
});
</script>
