<?php
include 'includes/session.php';

if(isset($_POST['delete'])){
    $id = $_POST['id'];

    // Get book data first
    $sql = "SELECT * FROM books WHERE id = '$id'";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();

    if($row){
        // Insert into archived_books
        $insert = "INSERT INTO archived_books (isbn, title, category_id, author, publisher, publish_date, status)
                   VALUES ('".$row['isbn']."', '".$row['title']."', '".$row['category_id']."', '".$row['author']."', '".$row['publisher']."', '".$row['publish_date']."', '".$row['status']."')";
        
        if($conn->query($insert)){
            // First delete related borrow and return records
            $conn->query("DELETE FROM borrow WHERE book_id = '$id'");
            $conn->query("DELETE FROM returns WHERE book_id = '$id'");

            // Now delete from books table
            if($conn->query("DELETE FROM books WHERE id = '$id'")){
                $_SESSION['success'] = 'Book deleted, archived, and related records removed successfully';
            } else {
                $_SESSION['error'] = $conn->error;
            }
        } else {
            $_SESSION['error'] = $conn->error;
        }
    } else {
        $_SESSION['error'] = 'Book not found';
    }
} else {
    $_SESSION['error'] = 'Select a book to delete';
}

header('location: book.php');
?>
