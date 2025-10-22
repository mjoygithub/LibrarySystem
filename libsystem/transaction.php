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
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <div>
          <h2 class="fw-bold text-success mb-0">
            <i class="fa fa-exchange-alt me-2"></i> My Transactions
          </h2>
          <div style="width:120px; height:3px; background:#FFD700; margin-top:5px;"></div>
          <p class="text-muted mt-2 mb-0">View your borrowed and returned books below.</p>
        </div>

        <!-- Transaction Type Dropdown (Left on desktop, stacked on mobile) -->
        <div class="mt-3 mt-md-0">
          <select class="form-select form-select-sm border-success fw-semibold text-success" id="transelect" style="min-width:150px;">
            <option value="borrow" <?= (!isset($_GET['action'])) ? 'selected' : ''; ?>>Borrow</option>
            <option value="return" <?= (isset($_GET['action']) && $_GET['action'] == 'return') ? 'selected' : ''; ?>>Return</option>
          </select>
        </div>
      </div>

      <!-- Transaction Table -->
      <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white fw-bold">
          <i class="fa fa-book me-2"></i> <?= (isset($_GET['action']) && $_GET['action'] == 'return') ? 'Returned Books' : 'Borrowed Books'; ?>
        </div>

        <div class="card-body table-responsive">
          <table id="transTable" class="table table-striped table-bordered align-middle">
            <thead class="table-success text-center">
              <tr>
                <th>Date</th>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stuid = $_SESSION['student'];
              $sql = "SELECT * FROM borrow LEFT JOIN books ON books.id=borrow.book_id WHERE student_id='$stuid' ORDER BY date_borrow DESC";
              $action = '';
              if(isset($_GET['action']) && $_GET['action'] == 'return'){
                $sql = "SELECT * FROM returns LEFT JOIN books ON books.id=returns.book_id WHERE student_id='$stuid' ORDER BY date_return DESC";
                $action = 'return';
              }

              $query = $conn->query($sql);
              if ($query->num_rows > 0) {
                while ($row = $query->fetch_assoc()) {
                  $dateField = ($action == 'return') ? 'date_return' : 'date_borrow';
                  echo "
                    <tr>
                      <td>".date('M d, Y', strtotime($row[$dateField]))."</td>
                      <td>".htmlspecialchars($row['isbn'])."</td>
                      <td>".htmlspecialchars($row['title'])."</td>
                      <td>".htmlspecialchars($row['author'])."</td>
                    </tr>
                  ";
                }
              } else {
                echo "<tr><td colspan='4' class='text-center text-muted py-4'>No records found.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
  const table = $('#transTable').DataTable({
    paging: true,
    lengthChange: false,
    searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    language: {
      paginate: {
        previous: '<i class="fa fa-arrow-left"></i> Previous',
        next: 'Next <i class="fa fa-arrow-right"></i>'
      },
      info: "Showing _START_ to _END_ of _TOTAL_ records"
    }
  });

  $('#transelect').on('change', function(){
    const action = $(this).val();
    if (action === 'borrow') window.location = 'transaction.php';
    else window.location = 'transaction.php?action=return';
  });
});
</script>

<style>
/* === General Styling (Matches Catalog) === */
body, .content-wrapper { 
  background-color: #f9f9f9; 
  color: #000; 
  font-family: 'Segoe UI', Tahoma, sans-serif; 
}

/* === Card === */
.card {
  border: 2px solid #006400; 
  border-radius: 12px; 
  overflow: hidden; 
  background-color: #fff;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}
.card-header {
  background: linear-gradient(90deg, #006400, #004d00);
  border-bottom: 3px solid #FFD700;
  font-size: 18px;
  text-shadow: 0 1px 1px rgba(0,0,0,0.3);
}

/* === Table === */
#transTable { 
  border: 2px solid #006400; 
  border-radius: 8px; 
  width: 100%;
}
#transTable thead th { 
  background: #006400; 
  color: white; 
  text-align: center;
  border-bottom: 2px solid #FFD700;
}
#transTable tbody tr:nth-child(odd) { background-color: #ffffff; }
#transTable tbody tr:nth-child(even) { background-color: #f7f7f7; }
#transTable tbody tr:hover { 
  background-color: #006400 !important; 
  color: white; 
  cursor: pointer; 
  transition: 0.3s ease;
}

/* === Pagination (Green-Gold theme) === */
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
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background-color: #006400 !important;
  color: #FFD700 !important;
  border-color: #004d00 !important;
  transform: scale(1.1);
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background-color: #adffadff !important;
  color: #FFD700 !important;
  transform: scale(1.1);
  box-shadow: 0 3px 6px rgba(0,0,0,0.2);
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
  opacity: 0.5;
  cursor: not-allowed !important;
  background-color: #eee !important;
  color: #666 !important;
  border-color: #ccc !important;
}
.dataTables_wrapper .dataTables_info {
  color: #004d00;
  font-weight: 500;
  margin-top: 8px;
  text-align: center;
}

/* === Select Filter === */
#transelect {
  font-weight: 500;
  color: #004d00;
  background-color: #fff;
  transition: 0.3s ease;
}
#transelect:hover {
  border-color: #FFD700;
  box-shadow: 0 0 6px rgba(255, 215, 0, 0.4);
}

/* === Responsive Adjustments === */
@media (max-width: 768px) {
  .card-header {
    font-size: 16px;
    text-align: center;
  }
  #transTable th, #transTable td {
    font-size: 14px;
  }
  #transelect {
    height: 40px;
  }
}
</style>

</body>
</html>
