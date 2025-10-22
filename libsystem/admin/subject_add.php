<?php
include 'includes/session.php';
include 'includes/conn.php';

if(isset($_POST['add_subject'])){
    $subject_name = trim($_POST['subject_name']);

    if(!empty($subject_name)){
        // Check if already exists
        $stmt = $conn->prepare("SELECT id FROM subject WHERE name = ?");
        $stmt->bind_param("s", $subject_name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $_SESSION['error'] = "Subject already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO subject (name) VALUES (?)");
            $stmt->bind_param("s", $subject_name);
            if($stmt->execute()){
                $_SESSION['success'] = "Subject added successfully.";
            } else {
                $_SESSION['error'] = $stmt->error;
            }
        }
    } else {
        $_SESSION['error'] = "Subject name cannot be empty.";
    }

    header('location: subjects.php');
}
?>
