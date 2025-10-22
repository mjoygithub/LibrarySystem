<?php
	session_start();
	if (isset($_SESSION['admin'])) {
		header('location:home.php');
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | BSU Library Management System</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    margin: 0;
    padding: 0;
    font-family: "Poppins", Arial, sans-serif;
    background: #0b3d2e;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* Back Button */
  .back-btn {
    position: fixed;
    top: 20px;
    left: 20px;
    background: transparent;
    color: #d4af37;
    border: 2px solid #d4af37;
    border-radius: 25px;
    padding: 6px 15px;
    font-weight: bold;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
    z-index: 10;
  }

  .back-btn:hover {
    background-color: #d4af37;
    color: #0b3d2e;
    box-shadow: 0 0 8px rgba(212,175,55,0.5);
  }

  /* Smaller Container */
  .login-container {
    display: flex;
    width: 820px;           /* reduced width */
    height: 460px;          /* reduced height */
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.3);
    background: #fff;
  }

  .left-img, .right-img {
    width: 32%;            /* slightly narrower sides */
    object-fit: cover;
  }

  /* Center Login Box */
  .login-box {
    width: 36%;            /* adjusted center width */
    height: 100%;
    background-color: #0b3d2e;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 30px 25px;
    box-sizing: border-box;
    text-align: center;
  }

  .login-box img {
    width: 90px; /* slightly smaller logo */
    margin-bottom: 10px;
  }

  .login-box h2 {
    color: #d4af37;
    font-size: 24px;
    margin-bottom: 0;
    font-weight: 700;
  }

  .login-box h3 {
    color: #ffffff;
    font-size: 18px;
    margin-bottom: 10px;
  }

  .form-group label {
    color: #ffffff;
    font-weight: bold;
    font-size: 13px;
  }

  .form-control {
    border-radius: 25px;
    border: 1.5px solid #d4af37;
    font-size: 13px;
    padding: 9px 12px;
    font-weight: 500;
  }

  .form-control:focus {
    border-color: #d4af37;
    box-shadow: 0 0 5px rgba(212,175,55,0.6);
  }

  .login-btn {
    background: linear-gradient(to bottom, #d4af37, #b89624);
    color: #0b3d2e;
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 25px;
    font-size: 15px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
  }

  .login-btn:hover {
    background: linear-gradient(to bottom, #e6c75b, #c5a235);
    transform: scale(1.03);
  }

  .forgot a {
    color: #d4af37;
    text-decoration: none;
    font-size: 12px;
  }

  .forgot a:hover {
    text-decoration: underline;
  }

  .error-message {
    margin-top: 10px;
    padding: 8px;
    background: #fff3cd;
    color: #8b0000;
    border: 1px solid #ffeeba;
    border-radius: 5px;
    text-align: center;
    width: 100%;
    font-size: 13px;
  }

  /* Responsive Fix */
  @media (max-width: 992px) {
    .login-container {
      flex-direction: column;
      width: 90%;
      height: auto;
    }
    .left-img, .right-img {
      display: none;
    }
    .login-box {
      width: 100%;
      height: auto;
      padding: 40px 30px;
    }
  }
</style>
</head>

<body>

<!-- 🟢 Back Button -->
<a href="../index.php" class="back-btn">
  ← Back to Homepage
</a>

<div class="login-container">
  <!-- Left side image -->
  <img src="../images/book1.jpg" class="left-img" alt="Library Image 1">

  <!-- Center login form -->
  <div class="login-box">
    <img src="../images/logo.png" alt="Logo">
    <h2>BSU-Bokod</h2>
    <h3>Library Management System (Admin)</h3>

    <form action="login.php" method="POST" class="w-100">
      <div class="form-group mb-3 text-start">
        <label for="email">Email</label>
        <input type="text" id="email" name="username" class="form-control" placeholder="Enter your email" required autofocus>
      </div>

      <div class="form-group mb-4 text-start">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
      </div>

      <button type="submit" class="login-btn" name="login">Login</button>
    </form>

    <div class="forgot mt-3">
      <a href="forgot_password.php">Forgot Password?</a>
    </div>

    <?php
      if (isset($_SESSION['error'])) {
        echo "<div class='error-message'>".$_SESSION['error']."</div>";
        unset($_SESSION['error']);
      }
    ?>
  </div>

  <!-- Right side image -->
  <img src="../images/book2.jpg" class="right-img" alt="Library Image 2">
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
