<?php
include 'conn.php';

if(isset($_GET['query'])){
  $search = trim($_GET['query']);

  $sql = "
    SELECT b.id, b.title, b.author, b.status, 
           GROUP_CONCAT(c.name SEPARATOR ', ') AS category,
           'Book' AS type
    FROM books b
    LEFT JOIN book_category_map bcm ON b.id = bcm.book_id
    LEFT JOIN category c ON bcm.category_id = c.id
    WHERE b.title LIKE '%$search%' OR b.author LIKE '%$search%' OR c.name LIKE '%$search%'
    GROUP BY b.id
    UNION
    SELECT p.id, p.title, '' AS author, 'Available' AS status, 
           'Digital Library' AS category, 'PDF' AS type
    FROM pdf_books p
    WHERE p.title LIKE '%$search%'
    ORDER BY title ASC
  ";

  $query = $conn->query($sql);

  if($query->num_rows > 0){
    echo "<div class='list-group shadow-sm'>";
    while($row = $query->fetch_assoc()){
      $statusColor = ($row['status'] == 'Available' || $row['status'] == 0) ? "text-success" : "text-danger";
      $statusLabel = ($row['status'] == 'Available' || $row['status'] == 0) ? "Available" : "Borrowed";
      $category = $row['category'] ?: "Uncategorized";

      echo "
      <div class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>
        <div>
          <h5 class='fw-bold mb-1 text-success'>".htmlspecialchars($row['title'])."</h5>
          <small class='text-muted'>
            ".($row['author'] ? "by ".htmlspecialchars($row['author'])." · " : "")."
            <span class='badge bg-light text-dark border'>$category</span>
            <span class='badge bg-success ms-2'>{$row['type']}</span>
          </small>
        </div>
        <span class='fw-bold $statusColor'>$statusLabel</span>
      </div>";
    }
    echo "</div>";
  } else {
    echo "<p class='text-muted mt-3 text-center'>No matching results found.</p>";
  }

} else {
  echo "<p class='text-muted text-center'>Please enter a search term.</p>";
}
?>
