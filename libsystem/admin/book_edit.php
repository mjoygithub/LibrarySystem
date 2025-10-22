<?php
include 'includes/session.php';
include 'includes/conn.php';

if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $isbn = trim($_POST['isbn']);
    $call_no = trim($_POST['call_no']);
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $publisher = trim($_POST['publisher']);
    $pub_date = trim($_POST['pub_date']);
    $categories = isset($_POST['category']) ? $_POST['category'] : [];

    // ✅ Validation
    if (empty($categories)) {
        $_SESSION['error'] = 'Please select at least one category.';
        header('location: book.php');
        exit();
    }

    if (!preg_match("/^\d{4}(-\d{2}-\d{2})?$/", $pub_date)) {
        $_SESSION['error'] = "Publish Date must be YYYY or YYYY-MM-DD";
        header('location: book.php');
        exit();
    }

    // ✅ Update main book info
    $stmt = $conn->prepare("
        UPDATE books 
        SET isbn = ?, call_no = ?, title = ?, author = ?, publisher = ?, publish_date = ? 
        WHERE id = ?
    ");
    $stmt->bind_param("ssssssi", $isbn, $call_no, $title, $author, $publisher, $pub_date, $id);

    if ($stmt->execute()) {
        $stmt->close();

        // ✅ Clear old category mappings
        $del_stmt = $conn->prepare("DELETE FROM book_category_map WHERE book_id = ?");
        $del_stmt->bind_param("i", $id);
        $del_stmt->execute();
        $del_stmt->close();

        // ✅ Insert new category selections
        $cat_stmt = $conn->prepare("INSERT INTO book_category_map (book_id, category_id) VALUES (?, ?)");
        foreach ($categories as $cat_id) {
            $cat_stmt->bind_param("ii", $id, $cat_id);
            $cat_stmt->execute();
        }
        $cat_stmt->close();

        $_SESSION['edited_book_id'] = $id;
        $_SESSION['success'] = 'Book updated successfully.';
    } else {
        $_SESSION['error'] = 'Failed to update book information.';
    }

    

    header('location: book.php');
    exit();

} else {
    $_SESSION['error'] = 'Select a book to edit first.';
    header('location: book.php');
    exit();
}
?>
