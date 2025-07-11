<!DOCTYPE html>
<html lang="en">
<?php include('header.php');?>
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
                              $error_message = 'Invalid company email or PIN.';
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

                  <form class="row g-3 needs-validation" action="servercheck.php" method="post" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Company Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input class="form-control" type="email" name="userid" placeholder="Company Email" autocomplete="off" autofocus="true">
                        <div class="invalid-feedback">Please enter your company email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Company PIN</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required placeholder="Company PIN">
                      <div class="invalid-feedback">Please enter your company PIN!</div>
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
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
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