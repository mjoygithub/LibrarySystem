<?php 
include 'includes/session.php'; 
include 'includes/header.php'; 
include 'includes/conn.php';
?>

<body class="bg-light d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 d-flex flex-column">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'; ?>

  <!-- Main Content -->
  <div class="content-wrapper flex-grow-1 py-4">
    <div class="container">

      <!-- Title -->
      <div class="text-center mb-4">
        <h2 class="fw-bold text-success">
          <i class="fa fa-book-open me-2"></i> Library Catalog
        </h2>
        <div class="mx-auto" style="width:120px; height:3px; background:#FFD700;"></div>
        <p class="text-muted mt-2">Browse and search all available books and digital materials.</p>
      </div>

      <!-- Filters -->
      <div class="row g-3 align-items-center mb-4">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-success text-white fw-bold border-success">
              Category
            </span>
            <select class="form-select border-success" id="catlist">
              <option value="0">ALL</option>
              <?php
                $sql = "SELECT * FROM category ORDER BY name ASC";
                $query = $conn->query($sql);
                while($catrow = $query->fetch_assoc()){
                    echo "<option value='".$catrow['id']."'>".$catrow['name']."</option>";
                }
              ?>
            </select>
          </div>
        </div>

        <div class="col-md-6">
        </div>
      </div>

      <!-- Book & PDF List -->
      <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white fw-bold">
          <i class="fa fa-book me-2"></i> Book & PDF List
        </div>

        <div class="card-body table-responsive">
          <table id="booklist" class="table table-striped table-bordered align-middle">
            <thead class="table-success text-center">
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author / Type</th>
                <th>Categories</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $i = 1;

                // Books
                $sqlBooks = "SELECT b.id, b.title, b.author, b.status,
                             GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
                             FROM books b
                             LEFT JOIN book_category_map bcm ON b.id = bcm.book_id
                             LEFT JOIN category c ON bcm.category_id = c.id
                             GROUP BY b.id";
                $queryBooks = $conn->query($sqlBooks);

                while($row = $queryBooks->fetch_assoc()){
                  $categories = $row['categories'] ?: 'Uncategorized';
                  $status = ($row['status'] == 0)
                    ? '<span class="badge bg-success">Available</span>'
                    : '<span class="badge bg-danger">Borrowed</span>';

                  echo "
                    <tr>
                      <td class='text-center'>{$i}</td>
                      <td>".htmlspecialchars($row['title'])."</td>
                      <td>".htmlspecialchars($row['author'])." <span class='text-muted'>(Book)</span></td>
                      <td>".htmlspecialchars($categories)."</td>
                      <td class='text-center'>$status</td>
                      <td class='text-center text-muted'>—</td>
                      
                    </tr>
                  ";
                  $i++;
                }

                // PDFs
                $sqlPDF = "SELECT id, title, file_path FROM pdf_books ORDER BY id DESC";
                $queryPDF = $conn->query($sqlPDF);
                while($row = $queryPDF->fetch_assoc()){
                  echo "
                    <tr>
                      <td class='text-center'>{$i}</td>
                      <td>".htmlspecialchars($row['title'])."</td>
                      <td><span class='text-muted'>PDF File</span></td>
                      <td>Digital Library</td>
                      <td class='text-center'><span class='badge bg-info text-dark'>Available</span></td>
                      <td class='text-center'>
                        <a href='admin/uploads/pdf_books/".htmlspecialchars($row['file_path'])."' target='_blank' class='btn btn-success btn-sm me-1'>
                          <i class='fa fa-eye'></i> View
                        </a>
                        <a href='admin/uploads/pdf_books/".htmlspecialchars($row['file_path'])."' download class='btn btn-warning btn-sm'>
                          <i class='fa fa-download'></i> Download
                        </a>
                      </td>
                    </tr>
                  ";
                  $i++;
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
  const table = $('#booklist').DataTable({
    paging: true,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    language: {
      paginate: {
        previous: '<i class="fa fa-arrow-left"></i> Previous',
        next: 'Next <i class="fa fa-arrow-right"></i>'
      },
      info: "Showing _START_ to _END_ of _TOTAL_ entries"
    }
  });

  // Search box
  $('#searchBox').on('keyup', function(){
    table.search(this.value).draw();
  });

  // Category filter
  $('#catlist').on('change', function(){
    const catText = $("#catlist option:selected").text();
    if($(this).val() == 0){
      table.column(3).search('').draw();
    } else {
      table.column(3).search(catText).draw();
    }
  });
});
</script>


<style>
/* === General Page Styling === */
body, .content-wrapper { 
  background-color: #f9f9f9; 
  color: #000; 
  font-family: 'Segoe UI', Tahoma, sans-serif; 
}

/* === Box Container === */
.box { 
  border: 2px solid #006400; 
  border-radius: 12px; 
  overflow: hidden; 
  background-color: #fff; 
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.box:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

/* === Box Header === */
.box-header { 
  background: linear-gradient(90deg, #006400, #004d00); 
  color: white; 
  padding: 15px; 
  border-bottom: 3px solid #FFD700; 
  font-weight: bold; 
  font-size: 20px; 
  letter-spacing: 1px;
  text-shadow: 0 1px 1px rgba(0,0,0,0.3);
}

/* === Table === */
#booklist { 
  border: 2px solid #006400; 
  border-radius: 8px; 
  width: 100%; 
  border-collapse: collapse; 
  background-color: #fff;
}
#booklist thead th { 
  position: sticky; 
  top: 0; 
  z-index: 2; 
  background: #006400; 
  color: white; 
  text-align: center;
  vertical-align: middle;
  padding: 10px;
  border-bottom: 2px solid #FFD700;
}
#booklist tbody tr:nth-child(odd) { 
  background-color: #ffffff; 
}
#booklist tbody tr:nth-child(even) { 
  background-color: #f7f7f7; 
}
#booklist tbody tr:hover { 
  background-color: #006400 !important; 
  color: #fff; 
  cursor: pointer; 
  transition: 0.3s ease;
}
#booklist td {
  vertical-align: middle;
  text-align: left;
  padding: 10px;
}
#booklist td:last-child {
  text-align: center;
}
#booklist td a.btn {
  min-width: 95px;
  text-align: center;
  border-radius: 25px;
  font-weight: 600;
  transition: 0.25s;
}
#booklist td a.btn:hover {
  transform: scale(1.05);
  box-shadow: 0 3px 6px rgba(0,0,0,0.2);
}

/* === Status Labels === */
.label {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: bold;
}
.label-success { background-color: #28a745; color: white; }
.label-danger  { background-color: #dc3545; color: white; }
.label-info    { background-color: #17a2b8; color: white; }

/* === Category Filter === */
#catlist {
  font-weight: 500;
  color: #004d00;
  background-color: #fff;
  transition: 0.3s ease;
}
#catlist:hover {
  border-color: #FFD700;
  box-shadow: 0 0 6px rgba(255, 215, 0, 0.4);
}

/* === Search Box === */
#searchBox {
  transition: box-shadow 0.3s ease, border-color 0.3s ease;
}
#searchBox:focus {
  border-color: #FFD700;
  box-shadow: 0 0 6px rgba(255, 215, 0, 0.6);
}

/* === Pagination Styling (Bootstrap Green-Gold Theme) === */
.dataTables_wrapper .dataTables_paginate {
  margin-top: 15px;
  text-align: center;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
  color: #006400 !important;
  border: 2px solid #006400 !important;
  border-radius: 6px;
  padding: 6px 14px;
  margin: 0 3px;
  font-weight: 600;
  background-color: #fff !important;
  transition: all 0.25s ease;
}

/* Active page */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background-color: #006400 !important;
  color: #FFD700 !important;
  border-color: #004d00 !important;
}

/* Hover effect */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background-color: #adffadff !important;
  color: #FFD700 !important;
  transform: translateY(-2px);
  box-shadow: 0 3px 6px rgba(0,0,0,0.2);
}

/* Disabled buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
  opacity: 0.5;
  cursor: not-allowed !important;
  background-color: #eee !important;
  color: #666 !important;
  border-color: #ccc !important;
}

/* Page Info */
.dataTables_wrapper .dataTables_info {
  color: #004d00;
  font-weight: 500;
  margin-top: 8px;
  text-align: center;
}

/* === Responsive === */
@media (max-width: 768px) {
  .box-header {
    font-size: 18px;
    text-align: center;
  }
  #booklist th, #booklist td {
    font-size: 14px;
  }
  #searchBox, #catlist {
    height: 40px;
  }
}


</style>

</body>
</html>
