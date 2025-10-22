<?php
include 'includes/session.php';
include 'includes/header.php';
?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header" style="background-color: #006400; color: #FFD700; padding: 15px; border-radius: 5px 5px 0 0;">
      <h1 style="font-weight: bold;">📚 Archived Book List</h1>
    </section>

    <section class="content" style="background-color: #F8FFF0; padding: 15px; border-radius: 0 0 5px 5px;">
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
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead style="background-color: #006400; color: #FFD700; font-weight: bold;">
                  <th>Categories</th>
                  <th>ISBN</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Publisher</th>
                  <th>Status</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM archived_books";
                    $query = $conn->query($sql);

                    while($row = $query->fetch_assoc()){
                      $cat_sql = "SELECT c.name 
                                  FROM archived_book_category_map bcm 
                                  LEFT JOIN category c ON c.id = bcm.category_id 
                                  WHERE bcm.book_id = '".$row['id']."'";
                      $cat_query = $conn->query($cat_sql);
                      $categories = [];
                      while($cat = $cat_query->fetch_assoc()){
                        $categories[] = $cat['name'];
                      }
                      $category_list = !empty($categories) ? implode(', ', $categories) : 'Uncategorized';

                      $status = $row['status'] ? '<span style="color:#FFD700;">Borrowed</span>' : '<span style="color:#006400;">Available</span>';

                      echo "
                        <tr>
                          <td>".htmlspecialchars($category_list)."</td>
                          <td>".htmlspecialchars($row['isbn'])."</td>
                          <td>".htmlspecialchars($row['title'])."</td>
                          <td>".htmlspecialchars($row['author'])."</td>
                          <td>".htmlspecialchars($row['publisher'])."</td>
                          <td>".$status."</td>
                          <td>
                            <form method='POST' action='restore_book.php' style='display:inline-block;'>
                              <input type='hidden' name='id' value='".$row['id']."'>
                              <button class='btn btn-success btn-sm'><i class='fa fa-undo'></i> Restore</button>
                            </form>
                            <form method='POST' action='delete_book_permanently.php' style='display:inline-block;' onsubmit=\"return confirm('Delete permanently?');\">
                              <input type='hidden' name='id' value='".$row['id']."'>
                              <button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i> Delete</button>
                            </form>
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

</div>
<?php include 'includes/scripts.php'; ?>
</body>
</html>
