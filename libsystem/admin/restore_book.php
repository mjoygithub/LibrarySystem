<?php
include 'includes/session.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];

    // Fetch the archived book
    $sql = "SELECT * FROM archived_books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();

    if($book){
        // Insert back into books
        $stmt = $conn->prepare("INSERT INTO books (category_id, isbn, title, author, publisher, publish_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssi", $book['category_id'], $book['isbn'], $book['title'], $book['author'], $book['publisher'], $book['publish_date'], $book['status']);
        $stmt->execute();
        $stmt->close();

        // Delete from archive
        $stmt = $conn->prepare("DELETE FROM archived_books WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = 'Book restored successfully';
    } else {
        $_SESSION['error'] = 'Book not found';
    }
} else {
    $_SESSION['error'] = 'No book selected';
}

header('Location: archived_book.php');
?>
