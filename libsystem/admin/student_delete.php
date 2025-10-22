<?php
include 'includes/session.php';

if(isset($_POST['delete'])){
    $id = $_POST['id'];

    // Fetch the student details first
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    if($student){
        $student_id = $student['student_id']; // your column name
        $firstname  = $student['firstname'];
        $lastname   = $student['lastname'];
        $course_id  = $student['course_id'];

        // Insert into archived_students
        $stmt2 = $conn->prepare("INSERT INTO archived_students (student_id, firstname, lastname, course_id) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("sssi", $student_id, $firstname, $lastname, $course_id);

        if($stmt2->execute()){
            $stmt2->close();

            // Delete from original students table
            $stmt3 = $conn->prepare("DELETE FROM students WHERE id = ?");
            $stmt3->bind_param("i", $id);
            if($stmt3->execute()){
                $_SESSION['success'] = 'Student archived successfully';
            } else {
                $_SESSION['error'] = 'Failed to delete student: '.$conn->error;
            }
            $stmt3->close();
        } else {
            $_SESSION['error'] = 'Failed to archive student: '.$conn->error;
        }
    } else {
        $_SESSION['error'] = 'Student not found';
    }
} else {
    $_SESSION['error'] = 'Select item to delete first';
}

// Redirect to Archived Students page
header('Location: archived_student.php'); // Make sure this file exists
exit();
?>
