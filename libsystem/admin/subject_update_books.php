<?php
include 'includes/conn.php';
include 'includes/session.php';

if(isset($_POST['subject_id'])){
    $subject_id = intval($_POST['subject_id']);
    $selected_books = isset($_POST['book_ids']) ? $_POST['book_ids'] : [];

    // Unassign all books from this subject
    $conn->query("UPDATE books SET subject_id = NULL WHERE subject_id = $subject_id");

    // Assign selected books
    if(!empty($selected_books)){
        $ids = implode(',', array_map('intval', $selected_books));
        $conn->query("UPDATE books SET subject_id = $subject_id WHERE id IN ($ids)");
    }

    $_SESSION['success'] = "Books successfully updated.";
} else {
    $_SESSION['error'] = "Invalid request.";
}

header('location: subjects.php');
?>
