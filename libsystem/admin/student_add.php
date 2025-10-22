<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$student_id = $_POST['student_id']; 
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$course = $_POST['course'];
		$password = $_POST['password'];

		// Securely hash the password before saving
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		// Insert into database
		$sql = "INSERT INTO students (student_id, firstname, lastname, course_id, password, created_on) 
				VALUES ('$student_id', '$firstname', '$lastname', '$course', '$hashed_password', NOW())";

		if($conn->query($sql)){
			$_SESSION['success'] = 'Student added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: student.php');
?>
