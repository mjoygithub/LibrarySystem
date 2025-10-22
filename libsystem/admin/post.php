<?php
include 'includes/session.php';
include 'includes/conn.php';

// Handle new post submission
if (isset($_POST['submit'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO posts (title, content, created_at) VALUES ('$title', '$content', NOW())";
        if ($conn->query($sql)) {
            $_SESSION['success'] = "Post successfully published!";
        } else {
            $_SESSION['error'] = "Database error: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Please fill in all fields.";
    }
    header("Location: post.php");
    exit();
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $sql = "DELETE FROM posts WHERE id = $id";
    if ($conn->query($sql)) {
        $_SESSION['success'] = "Post deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting post: " . $conn->error;
    }
    header("Location: post.php");
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>📢 Manage Posts</h1>
    </section>

    <section class="content">
      <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger text-center'>{$_SESSION['error']}</div>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success text-center'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']);
        }
      ?>

      <!-- Add Post Form -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Create a New Post</h3>
        </div>
        <form method="POST" action="">
          <div class="box-body">
            <div class="form-group">
              <label for="title">Post Title</label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" required>
            </div>
            <div class="form-group">
              <label for="content">Post Content</label>
              <textarea name="content" id="content" rows="6" class="form-control" placeholder="Write your update or news here..." required></textarea>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> Publish</button>
          </div>
        </form>
      </div>

      <!-- List of Existing Posts -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Published Posts</h3>
        </div>
        <div class="box-body">
          <ul class="list-group">
            <?php
              $sql = "SELECT * FROM posts ORDER BY created_at DESC";
              $query = $conn->query($sql);
              if ($query->num_rows > 0) {
                  while ($row = $query->fetch_assoc()) {
                      echo "
                        <li class='list-group-item'>
                          <strong>{$row['title']}</strong>
                          <a href='post.php?delete={$row['id']}' class='btn btn-danger btn-xs pull-right' onclick=\"return confirm('Are you sure you want to delete this post?');\">
                            <i class='fa fa-trash'></i> Delete
                          </a>
                          <br>
                          <small class='text-muted'>Published on: {$row['created_at']}</small>
                          <p>".substr($row['content'], 0, 150)."...</p>
                        </li>
                      ";
                  }
              } else {
                  echo "<p class='text-center'>No posts yet.</p>";
              }
            ?>
          </ul>
        </div>
      </div>
    </section>
  </div>

  <?php include 'includes/footer.php'; ?>
</div>
</body>
</html>
