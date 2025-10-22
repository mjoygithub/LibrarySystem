<?php
include 'includes/session.php';
include 'includes/conn.php';

if(isset($_POST['assign_books'])){
    $subject_id = $_POST['subject_id'];
    $book_ids = explode(',', $_POST['book_ids']); // convert back to array

    // Remove previous assignments
    $conn->query("DELETE FROM book_subject_map WHERE subject_id='$subject_id'");

    // Assign new selections
    foreach($book_ids as $book_id){
        if(!empty($book_id)){
            $conn->query("INSERT INTO book_subject_map (subject_id, book_id) VALUES ('$subject_id', '$book_id')");
        }
    }

    $_SESSION['success'] = "Books successfully updated for this subject.";
    header('location: subjects.php');
}
?>
