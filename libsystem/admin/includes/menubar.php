<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo !empty($user['photo']) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p></p> <!-- Name intentionally left blank -->
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Sidebar menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <!-- Reports Section -->
      <li class="header">REPORTS</li>
      <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

      <!-- Manage Section -->
      <li class="header">MANAGE</li>

      <!-- Transaction Menu -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-refresh"></i>
          <span>Transaction</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="borrow.php"><i class="fa fa-circle-o"></i> Borrow</a></li>
          <li><a href="return.php"><i class="fa fa-circle-o"></i> Return</a></li>
        </ul>
      </li>

      <!-- Books Menu -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-book"></i>
          <span>Books</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="book.php"><i class="fa fa-circle-o"></i> Book List</a></li>
          <li><a href="category.php"><i class="fa fa-circle-o"></i> Category</a></li>
          <li><a href="subjects.php"><i class="fa fa-circle-o"></i> Subjects</a></li>
          <li><a href="new_books.php"><i class="fa fa-circle-o"></i> New Books</a></li>
          <li><a href="pdf_books.php"><i class="fa fa-circle-o"></i> PDF Books</a></li>
        </ul>
      </li>

      <!-- Students Menu -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-graduation-cap"></i>
          <span>Students</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="student.php"><i class="fa fa-circle-o"></i> Student List</a></li>
          <li><a href="course.php"><i class="fa fa-circle-o"></i> Course</a></li>
        </ul>
      </li>

      <!-- Posts / News Menu -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-bullhorn"></i>
          <span>Posts / News</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="post.php"><i class="fa fa-circle-o"></i> Manage Posts</a></li>
        </ul>
      </li>

      <!-- Archive Section -->
      <li class="header">ARCHIVE</li>

      <!-- Archived Books -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-archive"></i>
          <span>Books</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="archived_book.php"><i class="fa fa-circle-o"></i> Book List</a></li>
          <li><a href="archived_category.php"><i class="fa fa-circle-o"></i> Category</a></li>
          <li><a href="archived_pdf_books.php"><i class="fa fa-circle-o"></i> PDF Books</a></li> <!-- ✅ Added Archived PDF Books -->
        </ul>
      </li>

      <!-- Archived Students -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Students</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="archived_student.php"><i class="fa fa-circle-o"></i> Student List</a></li>
          <li><a href="archived_course.php"><i class="fa fa-circle-o"></i> Course</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
