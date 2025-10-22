<?php
include 'includes/session.php';
include 'includes/conn.php';

if(isset($_POST['add_subject'])){
    $name = trim($_POST['subject_name']);
    if($name != ''){
        $stmt = $conn->prepare("SELECT id FROM subjects WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $_SESSION['error'] = 'Subject already exists.';
        } else {
            $stmt2 = $conn->prepare("INSERT INTO subjects (name) VALUES (?)");
            $stmt2->bind_param("s",$name);
            if($stmt2->execute()){
                $_SESSION['success'] = 'Subject added successfully.';
            } else {
                $_SESSION['error'] = $stmt2->error;
            }
            $stmt2->close();
        }
        $stmt->close();
    }
    header('location: subjects_books.php');
    exit();
}

if(isset($_POST['add_book'])){
    $isbn = trim($_POST['isbn']);
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $publisher = trim($_POST['publisher']);
    $publish_date = $_POST['publish_date'];
    $subjects = isset($_POST['subjects']) ? $_POST['subjects'] : [];

    // Add new subject if typed
    if(!empty($_POST['new_subject'])){
        $new_sub = trim($_POST['new_subject']);
        if($new_sub != ''){
            $stmt = $conn->prepare("SELECT id FROM subjects WHERE name = ?");
            $stmt->bind_param("s",$new_sub);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows == 0){
                $stmt2 = $conn->prepare("INSERT INTO subjects (name) VALUES (?)");
                $stmt2->bind_param("s",$new_sub);
                $stmt2->execute();
                $subjects[] = $stmt2->insert_id;
                $stmt2->close();
            } else {
                $stmt->bind_result($sub_id);
                $stmt->fetch();
                $subjects[] = $sub_id;
            }
            $stmt->close();
        }
    }

    // Insert book
    $date_added = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO books (isbn, title, author, publisher, publish_date, date_added, status) VALUES (?,?,?,?,?,?,0)");
    $stmt->bind_param("ssssss",$isbn,$title,$author,$publisher,$publish_date,$date_added);
    if($stmt->execute()){
        $book_id = $stmt->insert_id;
        // Map subjects
        $stmt2 = $conn->prepare("INSERT INTO book_subject_map (book_id, subject_id) VALUES (?,?)");
        foreach($subjects as $sub_id){
            $stmt2->bind_param("ii",$book_id,$sub_id);
            $stmt2->execute();
        }
        $stmt2->close();
        $_SESSION['success'] = 'Book added successfully.';
    } else {
        $_SESSION['error'] = $stmt->error;
    }
    $stmt->close();
    header('location: subjects_books.php');
    exit();
}
?>
