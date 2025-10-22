<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header" style=" padding: 15px; border-radius: 5px 5px 0 0;">
      <h1 style="font-weight: bold;">📚 Category</h1>
      <ol class="breadcrumb" style="background-color: transparent; color: #000000ff; font-weight: bold;">
        <li><a href="#" style="color: #FFD700;"><i class="fa fa-dashboard"></i> Home</a></li>
        <li style="color: #FFD700;">Books</li>
        <li class="active" style="color: #FFD700;">Category</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="background-color: #F8FFF0; padding: 15px; border-radius: 0 0 5px 5px;">
      <?php
        if(isset($_SESSION['error'])){
          echo "<div class='alert alert-danger' style='background-color: #FF6347; color: white; font-weight: bold; padding:10px; border-radius:5px;'>".$_SESSION['error']."</div>";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "<div class='alert alert-success' style='background-color: #32CD32; color: #006400; font-weight: bold; padding:10px; border-radius:5px;'>".$_SESSION['success']."</div>";
          unset($_SESSION['success']);
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="border-top: 3px solid #006400; border-radius: 5px;">
            
            <!-- Box Header -->
            <div class="box-header with-border" style="background-color: #FFFFFF; border-radius: 5px 5px 0 0; padding:10px;">
              <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm" 
                 style="background-color: #32CD32; color: white; font-weight: bold;">
                <i class="fa fa-plus"></i> New
              </a>
            </div>

            <!-- Box Body -->
            <div class="box-body" style="background-color: #FFFFFF; border-radius: 0 0 5px 5px;">
              <table id="example1" class="table table-bordered table-striped">
                <thead style="background-color: #006400; color: #FFD700; font-weight: bold;">
                  <tr>
                    <th>Category</th>
                    <th>Tools</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM category";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".htmlspecialchars($row['name'])."</td>
                          <td>
                            <!-- Edit Button -->
                            <button class='btn btn-success btn-sm edit' data-id='".$row['id']."' 
                              style='background-color:#32CD32; color:white; font-weight:bold;'>
                              <i class='fa fa-edit'></i> Edit
                            </button>

                            <!-- Delete Button -->
                            <button class='btn btn-danger btn-sm delete' data-id='".$row['id']."' 
                              style='background-color:#FF6347; color:white; font-weight:bold;'>
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
  
  <?php include 'includes/category_modal.php'; ?>
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
    url: 'category_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.catid').val(response.id);
      $('#edit_name').val(response.name);
      $('#del_cat').html(response.name);
    }
  });
}
</script>
</body>
</html>
