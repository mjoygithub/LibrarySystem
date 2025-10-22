<?php include 'includes/session.php'; ?> 
<?php include 'includes/header.php'; ?> 

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?> 
  <?php include 'includes/menubar.php'; ?> 

  <!-- Content Wrapper -->
  <div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header" style="padding: 15px; border-radius: 5px 5px 0 0;">
      <h1 style="font-weight: bold;">👩‍🎓 Student List</h1>
      <ol class="breadcrumb" style="background-color: transparent; color: #000000ff; font-weight: bold;">
        <li><a href="#" style="color: #FFD700;"><i class="fa fa-dashboard"></i> Home</a></li>
        <li style="color: #FFF;">Students</li>
        <li class="active" style="color: #FFD700;">Student List</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content" style="background-color: #F8FFF0; padding: 15px; border-radius: 0 0 5px 5px;">

      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible' style='background-color: #FF6347; color: white; font-weight: bold; border-radius:5px;'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']." 
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible' style='background-color: #32CD32; color: #006400; font-weight: bold; border-radius:5px;'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="border-top: 3px solid #006400; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
            
            <!-- Header with New Button -->
            <div class="box-header with-border" style="background-color: #F0FFF0; padding: 15px;">
              <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat" 
                 style="background-color: #32CD32; color: white; font-weight: bold; border: none; border-radius: 4px;">
                <i class="fa fa-plus"></i> New
              </a>
            </div>

            <!-- Student Table -->
            <div class="box-body" style="background-color: #FFFFFF; padding: 15px;">
              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead style="background-color: #006400; color: #FFD700; font-weight: bold;">
                  <tr>
                    <th style="text-align:center;">Course</th>
                    <th style="text-align:center;">Student ID</th>
                    <th style="text-align:center;">Firstname</th>
                    <th style="text-align:center;">Lastname</th>
                    <th style="text-align:center;">Tools</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT *, students.id AS studid 
                            FROM students 
                            LEFT JOIN course ON course.id = students.course_id";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td style='text-align:center;'>".htmlspecialchars($row['code'])."</td>
                          <td style='text-align:center;'>".htmlspecialchars($row['student_id'])."</td>
                          <td style='text-align:center;'>".htmlspecialchars($row['firstname'])."</td>
                          <td style='text-align:center;'>".htmlspecialchars($row['lastname'])."</td>
                          <td style='text-align:center;'>
                            <button class='btn btn-success btn-sm edit btn-flat' data-id='".htmlspecialchars($row['studid'])."' 
                              style='background-color: #228B22; color:white; font-weight:bold; border:none; border-radius:4px;'>
                              <i class='fa fa-edit'></i> Edit
                            </button>
                            <button class='btn btn-danger btn-sm delete btn-flat' data-id='".htmlspecialchars($row['studid'])."' 
                              style='background-color: #FF4500; color:white; font-weight:bold; border:none; border-radius:4px;'>
                              <i class='fa fa-trash'></i> Delete
                            </button>
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
    
  <?php include 'includes/student_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
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
    url: 'student_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.studid').val(response.studid);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#selcourse').val(response.course_id);
      $('#selcourse').html(response.code);
      $('.del_stu').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>
