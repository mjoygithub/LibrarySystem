<?php 
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/header.php'; 

$catid = 0;
$where = '';
if(isset($_GET['category'])){
  $catid = intval($_GET['category']);
  if($catid > 0){
    $where .= " AND m.category_id = $catid";
  }
}

$subjid = 0;
$subject_where = '';
if(isset($_GET['subject'])){
  $subjid = intval($_GET['subject']);
  if($subjid > 0){
    $subject_where .= " AND books.subject_id = $subjid";
  }
}
?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header" style="background-color: #006400; color: #FFD700; padding: 15px; border-radius:5px 5px 0 0;">
      <h1 style="font-weight: bold;">📚 Book List</h1>
      <ol class="breadcrumb" style="background-color: transparent; color: #FFD700; font-weight: bold;">
        <li><a href="#" style="color: #FFD700;"><i class="fa fa-dashboard"></i> Home</a></li>
        <li style="color: #FFD700;">Books</li>
        <li class="active" style="color: #FFD700;">Book List</li>
      </ol>
    </section>

    <section class="content" style="background-color: #F8FFF0; padding: 15px; border-radius:0 0 5px 5px;">
      <?php
        if(isset($_SESSION['error'])){
          echo "<div class='alert alert-danger alert-dismissible'>".$_SESSION['error']."</div>";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "<div class='alert alert-success alert-dismissible'>".$_SESSION['success']."</div>";
          unset($_SESSION['success']);
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="border-top: 3px solid #006400;">
            <div class="box-header with-border" style="background-color: #F0FFF0;">
              <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat">
                <i class="fa fa-plus"></i> New
              </a>
              <div class="box-tools pull-right">
                <form class="form-inline">
                  <div class="form-group">
                    <label style="color: #006400; font-weight: bold;">Category: </label>
                    <select class="form-control input-sm" id="select_category">
                      <option value="0">ALL</option>
                      <?php
                        $sql = "SELECT * FROM category ORDER BY name ASC";
                        $query = $conn->query($sql);
                        while($catrow = $query->fetch_assoc()){
                          $selected = ($catid == $catrow['id']) ? " selected" : "";
                          echo "<option value='".$catrow['id']."' ".$selected.">".$catrow['name']."</option>";
                        }
                      ?>
                    </select>
                  </div>

                  <div class="form-group" style="margin-left:10px;">
                    <label style="color: #006400; font-weight: bold;">Subject: </label>
                    <select class="form-control input-sm" id="select_subject">
                      <option value="0">ALL</option>
                      <?php
                        $sql = "SELECT * FROM subject ORDER BY name ASC";
                        $query = $conn->query($sql);
                        while($subjrow = $query->fetch_assoc()){
                          $selected = ($subjid == $subjrow['id']) ? " selected" : "";
                          echo "<option value='".$subjrow['id']."' ".$selected.">".$subjrow['name']."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </form>
              </div>
            </div>

            <div class="box-body" style="background-color: #FFFFFF;">
              <table id="example1" class="table table-bordered table-striped">
                <thead style="background-color: #006400; color: #FFD700; font-weight: bold;">
                  <th>Categories</th>
                  <th>Subject</th>
                  <th>ISBN</th>
                  <th>Call No.</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Publisher</th>
                  <th>Publish Date</th>
                  <th>Date Added</th>
                  <th>Copy No.</th>
                  <th>Status</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "
                      SELECT 
                        books.id AS bookid,
                        books.isbn,
                        books.call_no,
                        books.title,
                        books.author,
                        books.publisher,
                        books.publish_date,
                        books.date_created,
                        books.status,
                        books.copy_number,
                        books.subject_id,
                        subject.name AS subject_name,
                        GROUP_CONCAT(DISTINCT category.name ORDER BY category.name SEPARATOR ', ') AS category_list
                      FROM books
                      LEFT JOIN book_category_map m ON books.id = m.book_id
                      LEFT JOIN category ON m.category_id = category.id
                      LEFT JOIN subject ON books.subject_id = subject.id
                      WHERE 1=1
                      $where
                      $subject_where
                      GROUP BY books.id
                      ORDER BY books.id DESC
                    ";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      $status = $row['status'] ? 
                        '<span class="label label-danger">Borrowed</span>' :
                        '<span class="label label-success">Available</span>';

                      echo "
                        <tr>
                          <td>".htmlspecialchars($row['category_list'] ?: 'Uncategorized')."</td>
                          <td>".htmlspecialchars($row['subject_name'] ?: 'Unassigned')."</td>
                          <td>".htmlspecialchars($row['isbn'])."</td>
                          <td>".htmlspecialchars($row['call_no'])."</td>
                          <td>".htmlspecialchars($row['title'])."</td>
                          <td>".htmlspecialchars($row['author'])."</td>
                          <td>".htmlspecialchars($row['publisher'])."</td>
                          <td>".htmlspecialchars($row['publish_date'])."</td>
                          <td>".htmlspecialchars(date('F d, Y', strtotime($row['date_created'])))."</td>
                          <td>".htmlspecialchars($row['copy_number'])."</td>
                          <td>".$status."</td>
                          <td class='text-center'>
                              <div class='btn-group btn-group-sm' role='group'>
                                <button class='btn btn-success edit' data-id='".$row['bookid']."' title='Edit'>
                                  <i class='fa fa-edit'></i>
                                </button>
                                <button class='btn btn-danger delete' data-id='".$row['bookid']."' title='Delete'>
                                  <i class='fa fa-trash'></i>
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

  <?php include 'includes/book_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>

<script>
$(function(){
  $('#select_category').change(function(){
    var value = $(this).val();
    var subj = $('#select_subject').val();
    var url = 'book.php?';
    if(value > 0) url += 'category=' + value + '&';
    if(subj > 0) url += 'subject=' + subj;
    window.location = url;
  });

  $('#select_subject').change(function(){
    var value = $(this).val();
    var cat = $('#select_category').val();
    var url = 'book.php?';
    if(cat > 0) url += 'category=' + cat + '&';
    if(value > 0) url += 'subject=' + value;
    window.location = url;
  });

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});



function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'book_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#edit_id').val(response.id);
      $('#edit_isbn').val(response.isbn);
      $('#edit_call_no').val(response.call_no);
      $('#edit_title').val(response.title);
      $('#edit_author').val(response.author);
      $('#edit_publisher').val(response.publisher);
      $('#datepicker_edit').val(response.publish_date);

      // Reset all checkboxes
      $('input[name="category[]"]').prop('checked', false);
      $('input[name="subject[]"]').prop('checked', false);

      // Check existing categories
      if (response.categories) {
        response.categories.forEach(function(cat){
          $('input[name="category[]"][value="'+cat+'"]').prop('checked', true);
        });
      }

      // Check existing subjects
      if (response.subjects) {
        response.subjects.forEach(function(subj){
          $('input[name="subject[]"][value="'+subj+'"]').prop('checked', true);
        });
      }
    }
  });
}
</script>




</body>
</html>
