<?php
session_start();
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = isset($_POST['userid']) ? trim($_POST['userid']) : '';
  $pin = isset($_POST['password']) ? trim($_POST['password']) : '';

  if ($email === '' || $pin === '') {
    header('Location: loginpage.php?error=empty');
    exit();
  }

  // Fetch user by email
  $stmt = $pdo->prepare('SELECT * FROM tbl_users WHERE user_email = ? LIMIT 1');
  $stmt->execute([$email]);
  $user = $stmt->fetch();
  $usernum = $stmt->rowCount();

  if ($usernum > 0) 
    {
    // Login success - store user data in session
      $_SESSION['user_id'] = $user['unique_id'];
      $_SESSION['user_email'] = $user['user_email'];
      $_SESSION['user_image'] = $user['user_image'];
      $_SESSION['user_position'] = $user['user_position'];
      $_SESSION['user_role'] = $user['user_role'];
      $_SESSION['user_created'] = $user['created_at'];

      // Redirect based on role
      if ($user['user_role'] === 'Admin') {
        header('Location: index.php');
      } else {
        header('Location: all_articles.php');
      }
      exit();
  } else {
    // Login failed
    header("Location: loginpage.php?error=invalid");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2" style="text-align:center;">
                    <img src="assets/img/logo.png" alt="" style="width:200px;height:100px;text-align:center;">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your company email & PIN to login</p>
                  </div>

                  <?php
                  // Display error messages
                  if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    $error_message = '';
                    $alert_class = 'alert-danger';

                    switch ($error) {
                      case 'empty':
                        $error_message = 'Please fill in all fields.';
                        break;
                      case 'invalid':
                        $error_message = 'Invalid password.';
                        break;
                      case 'inactive':
                        $error_message = 'Your account is inactive. Please contact administrator.';
                        break;
                      default:
                        $error_message = 'An error occurred. Please try again.';
                    }

                    if ($error_message) {
                      echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">
                                  ' . $error_message . '
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                    }
                  }
                  ?>

                  <form class="row g-3 needs-validation" method="post" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input class="form-control" type="email" name="userid" placeholder="Email" autocomplete="off" autofocus="true">
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required placeholder="Password">
                      <div class="invalid-feedback">Please enter your company password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>