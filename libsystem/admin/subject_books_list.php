<?php
include 'includes/conn.php';
$subject_id = intval($_GET['id']);

// Fetch all books and mark assigned ones
$stmt = $conn->prepare("
    SELECT id, call_no, title, author, publisher, publish_date, 
           IF(subject_id = ?, 1, 0) AS assigned
    FROM books
    ORDER BY title ASC
");
$stmt->bind_param("i", $subject_id);
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
    $checked = $book['assigned'] ? "checked" : "";
    echo "<tr>
            <td><input type='checkbox' name='book_ids[]' value='{$book['id']}' $checked></td>
            <td>".htmlspecialchars($book['call_no'])."</td>
            <td>".htmlspecialchars($book['title'])."</td>
            <td>".htmlspecialchars($book['author'])."</td>
            <td>".htmlspecialchars($book['publisher'])."</td>
            <td>".htmlspecialchars($book['publish_date'])."</td>
          </tr>";
}
echo "</tbody></table>";
