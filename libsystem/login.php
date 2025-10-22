<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['login'])) {
    $student_id = trim($_POST['student']);
    $password = trim($_POST['password']);

    // Empty field check
    if (empty($student_id) || empty($password)) {
        $_SESSION['error'] = 'Please enter both Student ID and Password.';
        header('Location: index.php');
        exit();
    }

    // Query to find student in users table
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = 'Student not found.';
        header('Location: index.php');
        exit();
    }

    $user = $result->fetch_assoc();

    // Compare plain-text password
    if ($password === $user['password']) {
        $_SESSION['student'] = $user['id'];
        $_SESSION['student_name'] = $user['firstname'] . ' ' . $user['lastname'];
        $_SESSION['student_id'] = $user['student_id'];
        header('Location: transaction.php');
        exit();
    } else {
        $_SESSION['error'] = 'Incorrect password.';
        header('Location: index.php');
        exit();
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Please fill out the login form.';
    header('Location: index.php');
    exit();
}
?>
