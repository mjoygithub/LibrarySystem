<?php
include 'includes/session.php';

if(isset($_POST['delete'])){
    $id = $_POST['id'];

    // Fetch the course data
    $query = $conn->query("SELECT * FROM course WHERE id = '$id'");
    $course = $query->fetch_assoc();

    if($course){
        $code = $course['code'];
        $title = $course['title']; // Use the column name from the course table

        // Insert into archived_course (use correct column names)
        $archive_sql = "INSERT INTO archived_course (code, title) VALUES ('$code', '$title')";
        if($conn->query($archive_sql)){
            // Now delete from course
            $delete_sql = "DELETE FROM course WHERE id = '$id'";
            if($conn->query($delete_sql)){
                $_SESSION['success'] = 'Course archived successfully';
            } else {
                $_SESSION['error'] = 'Failed to delete course: ' . $conn->error;
            }
        } else {
            $_SESSION['error'] = 'Failed to archive course: ' . $conn->error;
        }
    } else {
        $_SESSION['error'] = 'Course not found';
    }
} else {
    $_SESSION['error'] = 'Select item to delete first';
}

header('location: course.php');
?>
