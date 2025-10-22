<?php
include 'includes/session.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];

    // Delete the book from archived_books
    $conn->query("DELETE FROM archived_books WHERE id='$id'");

    $_SESSION['success'] = 'Book deleted permanently';
}
header('Location: archived_book.php');
?>
