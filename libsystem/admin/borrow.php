<?php include 'includes/session.php'; ?> 
<?php include 'includes/header.php'; ?> 

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?> 
  <?php include 'includes/menubar.php'; ?> 

  <!-- Content Wrapper -->
  <div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header" style="background-color: #006400; color: #FFD700; padding: 15px; border-radius: 5px 5px 0 0;">
      <h1 style="font-weight: bold; margin: 0;">📖 Borrow Books</h1>
      <ol class="breadcrumb" style="background-color: transparent; margin: 0; padding-top: 8px; font-weight: bold;">
        <li><a href="#" style="color: #FFD700;"><i class="fa fa-dashboard"></i> Home</a></li>
        <li style="color: #FFF;">Transaction</li>
        <li class="active" style="color: #FFD700;">Borrow</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="background-color: #F8FFF0; padding: 15px; border-radius: 0 0 5px 5px;">

      <!-- Error Message -->
      <?php if(isset($_SESSION['error'])){ ?>
        <div class="alert alert-danger alert-dismissible" style="background-color: #FF6347; color: white; font-weight: bold; border-radius:5px;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-warning"></i> Error!</h4>
          <ul>
            <?php foreach($_SESSION['error'] as $error){ echo "<li>".$error."</li>"; } ?>
          </ul>
        </div>
      <?php unset($_SESSION['error']); } ?>

      <!-- Success Message -->
      <?php if(isset($_SESSION['success'])){ ?>
        <div class="alert alert-success alert-dismissible" style="background-color: #32CD32; color: #006400; font-weight: bold; border-radius:5px;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>
          <?php echo $_SESSION['success']; ?>
        </div>
      <?php unset($_SESSION['success']); } ?>

      <?php
        // ============================
        // 🔔 Overdue Notification Logic
        // ============================
        $today = date('Y-m-d');
        $notif_sql = "SELECT borrow.*, students.student_id AS stud, students.firstname, students.lastname, books.title, borrow.due_date 
                      FROM borrow
                      LEFT JOIN students ON students.id = borrow.student_id
                      LEFT JOIN books ON books.id = borrow.book_id
                      WHERE borrow.status = 0 AND borrow.due_date < '$today'";
        $notif_query = $conn->query($notif_sql);
        if($notif_query->num_rows > 0){
          echo '
          <div class="alert alert-warning alert-dismissible" style="background-color:#FFD700; color:#8B0000; font-weight:bold; border-radius:5px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-exclamation-triangle"></i> Overdue Books!</h4>
            <ul style="margin:0; padding-left:20px;">';
          while($over = $notif_query->fetch_assoc()){
            echo "<li>📚 <b>".$over['title']."</b> borrowed by ".$over['firstname']." ".$over['lastname']." (".$over['stud'].") was due on ".date('M d, Y', strtotime($over['due_date'])).".</li>";
          }
          echo '</ul></div>';
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="border-top: 3px solid #006400;">

            <div class="box-header with-border" style="background-color: #F0FFF0; padding: 15px;">
              <!-- Button to trigger modal -->
              <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat" 
                 style="background-color: #32CD32; color: white; font-weight: bold;">
                <i class="fa fa-plus"></i> Borrow
              </a>
            </div>

            <div class="box-body" style="background-color: #FFFFFF; padding: 15px;">
              <table id="example1" class="table table-bordered table-striped">
                <thead style="background-color: #006400; color: #FFD700; font-weight: bold;">
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>ISBN</th>
                  <th>Title</th>
                  <th>Due Date</th>
                  <th>Status</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT borrow.*, students.student_id AS stud, students.firstname, students.lastname, students.phone, 
                                   books.isbn, books.title, borrow.status AS barstat, borrow.due_date 
                            FROM borrow 
                            LEFT JOIN students ON students.id = borrow.student_id 
                            LEFT JOIN books ON books.id = borrow.book_id 
                            ORDER BY borrow.date_borrow DESC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){

                      // Determine status label
                      if($row['barstat']){
                        $status = '<span class="label" style="background-color: #32CD32; color: #006400; font-weight: bold; padding: 6px 10px; border-radius: 4px;">Returned</span>';
                      } else {
                        if($today > $row['due_date']){
                          $status = '<span class="label" style="background-color: #FF0000; color: #fff; font-weight: bold; padding: 6px 10px; border-radius: 4px;">Overdue</span>';
                        } else {
                          $status = '<span class="label" style="background-color: #FF6347; color: white; font-weight: bold; padding: 6px 10px; border-radius: 4px;">Not Returned</span>';
                        }
                      }

                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".date('M d, Y', strtotime($row['date_borrow']))."</td>
                          <td>".$row['stud']."</td>
                          <td>".$row['firstname'].' '.$row['lastname']."</td>
                          <td>".$row['phone']."</td>
                          <td>".$row['isbn']."</td>
                          <td>".$row['title']."</td>
                          <td>".date('M d, Y', strtotime($row['due_date']))."</td>
                          <td>".$status."</td>
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

  <!-- Borrow Modal -->
  <?php include 'includes/borrow_modal.php'; ?> 
</div>

<!-- Scripts -->
<?php include 'includes/scripts.php'; ?> 

<script>
$(function(){
  $(document).on('click', '#append', function(e){
    e.preventDefault();
    $('#append-div').append(
      '<div class="form-group">'+
        '<label for="" class="col-sm-3 control-label">ISBN</label>'+
        '<div class="col-sm-9">'+
          '<input type="text" class="form-control" name="isbn[]">'+
        '</div>'+
      '</div>'
    );
  });
});
</script>

</body>
</html>
