<header class="main-header" style="background: linear-gradient(90deg, #006400, #228B22);">
  <!-- Logo -->
  <a href="#" class="logo" style="background: linear-gradient(90deg, #006400, #228B22); color:white;">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>B</b>SU</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>BSU</b>- BOKOD</span>
  </a>
  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" style="background: linear-gradient(90deg, #006400, #228B22);">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="color:white;">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:white;">
            <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $user['firstname'].' '.$user['lastname']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header" style="background: linear-gradient(90deg, #006400, #228B22); color:white;">
              <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">

              <p>
                <?php echo $user['firstname'].' '.$user['lastname']; ?>
                <small>Member since <?php echo date('M. Y', strtotime($user['created_on'])); ?></small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#profile" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile">Update</a>
              </div>
              <div class="pull-right">
                <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<?php include 'includes/profile_modal.php'; ?>
