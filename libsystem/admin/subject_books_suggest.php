<?php
include 'includes/conn.php';

$call_no = $_GET['call_no'] ?? '';
$subject_id = intval($_GET['subject_id'] ?? 0);

$stmt = $conn->prepare("
    SELECT id, call_no, title, author, publisher, publish_date
    FROM books
    WHERE call_no LIKE CONCAT('%', ?, '%')
    ORDER BY call_no ASC
    LIMIT 20
");
$stmt->bind_param("s", $call_no);
$stmt->execute();
$result = $stmt->get_result();

echo "<table class='table table-bordered'>
        <thead>
          <tr>
            <th>Select</th>
            <th>Call No.</th>
            <th>Title</th>
            <th>Author</th>
            <th>Publisher</th>
            <th>Publish Date</th>
          </tr>
        </thead>
        <tbody>";
while($book = $result->fetch_assoc()){
    // Check if book already assigned
    $check = $conn->prepare("SELECT * FROM books WHERE id=? AND subject_id=?");
    $check->bind_param("ii", $book['id'], $subject_id);
    $check->execute();
    $assigned = $check->get_result()->num_rows ? "checked" : "";
    
    echo "<tr>
            <td><input type='checkbox' name='book_ids[]' value='{$book['id']}' $assigned></td>
            <td>".htmlspecialchars($book['call_no'])."</td>
            <td>".htmlspecialchars($book['title'])."</td>
            <td>".htmlspecialchars($book['author'])."</td>
            <td>".htmlspecialchars($book['publisher'])."</td>
            <td>".htmlspecialchars($book['publish_date'])."</td>
          </tr>";
}
echo "</tbody></table>";
