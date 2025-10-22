<?php
include 'includes/session.php';
include 'includes/conn.php';

if(isset($_POST['assign_books'])){
    $subject_id = $_POST['subject_id'];
    $book_ids = $_POST['book_ids'];

    if(!empty($book_ids)){
        foreach($book_ids as $book_id){
            // Prevent duplicates
            $check = $conn->query("SELECT * FROM book_subject_map WHERE subject_id='$subject_id' AND book_id='$book_id'");
            if($check->num_rows == 0){
                $conn->query("INSERT INTO book_subject_map (subject_id, book_id) VALUES ('$subject_id', '$book_id')");
            }
        }
        $_SESSION['success'] = "Books successfully assigned to the subject.";
    } else {
        $_SESSION['error'] = "No books selected.";
    }
    header('location: subjects.php');
}
?>
