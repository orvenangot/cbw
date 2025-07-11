<?php
session_start();
// Check if user is logged in and is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: loginpage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php');?>
<body>
  <!-- ======= Header ======= -->
  <?php include('index_header.php');?>
  <!-- ======= Header ======= -->
  <!-- ======= Sidebar ======= -->
  <?php include('index_sidebar.php');?>
  <!-- ======= Sidebar ======= -->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Admin Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Welcome, <?php echo htmlspecialchars($_SESSION['company_name']); ?>!</h5>
                  <p class="card-text">You are logged in as <b>Administrator</b>.</p>
                  <p class="card-text">Use the sidebar to manage companies, users, and system settings.</p>
                </div>
              </div>
            </div>
            <!-- You can add more admin-specific cards here -->
          </div>
        </div><!-- End Left side columns -->
        <!-- Right side columns -->
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Quick Links</h5>
              <ul>
                <li><a href="#">Manage Companies</a></li>
                <li><a href="#">Manage Users</a></li>
                <li><a href="#">System Settings</a></li>
                <li><a href="#">Reports & Analytics</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </div>
          </div>
        </div><!-- End Right side columns -->
      </div>
    </section>
  </main><!-- End #main -->
  <?php include('footer.php');?>
</body>
</html> 