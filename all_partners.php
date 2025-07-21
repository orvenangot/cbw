<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>

<body>
  <!-- ======= Header ======= -->
  <?php include('index_header.php'); ?>
  <!-- ======= Header ======= -->
  <!-- ======= Sidebar ======= -->
  <?php include('index_sidebar.php'); ?>
  <!-- ======= Sidebar ======= -->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>All Partners</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_dashboard.php">Admin</a></li>
          <li class="breadcrumb-item active">All Partners</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Partner Management</h5>
                <a href="add_partner.php" class="btn btn-primary">
                  <i class="bi bi-plus-circle"></i> Add New Partner
                </a>
              </div>

              <!-- Partners Table -->
              <div class="table-responsive">
                <table class="table table-striped table-hover datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Profile</th>
                      <th scope="col">Company Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Address</th>
                      <th scope="col">Type</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Fetch all partners/companies
                    include('dbconnect.php');
                    $actquery = "SELECT unique_id,comp_name,comp_address,comp_pin,comp_image,comp_email,comp_type,comp_stat FROM tbl_companies WHERE comp_stat = '1' ORDER BY comp_name ASC";
                    $actstmt = $pdo->prepare($actquery);
                    $actstmt->execute();
                    $actpcount = $actstmt->rowCount();
                    
                    $inactquery = "SELECT unique_id,comp_name,comp_address,comp_pin,comp_image,comp_email,comp_type,comp_stat FROM tbl_companies WHERE comp_stat = '0' ORDER BY comp_name ASC";
                    $inactstmt = $pdo->prepare($inactquery);
                    $inactstmt->execute();
                    $inactpcount = $inactstmt->rowCount();

                    $query = "SELECT unique_id,comp_name,comp_address,comp_pin,comp_image,comp_email,comp_type,comp_stat FROM tbl_companies ORDER BY comp_name ASC";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();

                    $pcount = $stmt->rowCount();
                    
                    $stmt->bindColumn('unique_id', $unique_id);
                    $stmt->bindColumn('comp_name', $comp_name);
                    $stmt->bindColumn('comp_address', $comp_address);
                    $stmt->bindColumn('comp_image', $comp_image);
                    $stmt->bindColumn('comp_email', $comp_email);
                    $stmt->bindColumn('comp_type', $comp_type);
                    $stmt->bindColumn('comp_stat', $comp_stat);

                    $rowid = 1;
                    while ($row = $stmt->fetch( PDO::FETCH_BOUND))
                    {
                      ?>
                      <tr>
                          <th scope="row"><?php echo $rowid; ?></th>
                          <td>
                            <?php
                            if($comp_image != "")
                              {
                                ?>
                                <img src="<?php echo htmlspecialchars($comp_image); ?>"
                                alt="<?php echo htmlspecialchars($comp_name); ?> Logo"
                                class="rounded-circle"
                                style="width: 50px; height: 50px; object-fit: cover;">
                                <?php
                            }
                            else
                              {
                                ?>
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                  style="width: 50px; height: 50px;">
                                  <i class="bi bi-building text-muted"></i>
                                </div>
                                <?php
                            }
                            ?>
                          </td>
                          <td>
                            <strong><?php echo htmlspecialchars($comp_name); ?></strong>
                            <br>
                            <small class="text-muted">ID: <?php echo htmlspecialchars($unique_id); ?></small>
                          </td>
                          <td>
                            <span class="badge bg-info"><?php echo htmlspecialchars($comp_email); ?></span>
                          </td>
                          <td>
                            <small><?php echo htmlspecialchars($comp_address); ?></small>
                          </td>
                          <td>
                            <?php if ($comp_type == 0): ?>
                              <span class="badge bg-danger">Administrator</span>
                            <?php else: ?>
                              <span class="badge bg-primary">Partner</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php if ($comp_stat == 1): ?>
                              <span class="badge bg-success">Active</span>
                            <?php else: ?>
                              <span class="badge bg-danger">Inactive</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <div class="btn-group" role="group">
                              <form action="view_partner.php" method="POST">
                                    <input type="hidden" name="unique_id" value="<?php echo $unique_id;?>">
                                    <button type="submit" class="btn btn-sm btn-outline-success"><i class="bi bi-pencil"></i></button>
                                </form>
                              </div>
                          </td>
                        </tr>
                      <?php
                      $rowid++;
                    }
                    ?>
                      </tbody>
                </table>
              </div>

              <!-- Statistics Cards -->
              <div class="row mt-4">
                <div class="col-md-3">
                  <div class="card info-card sales-card">
                    <div class="card-body">
                      <h5 class="card-title">Total Partners</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-building"></i>
                        </div>
                        <div class="ps-3">
                          <h6><?php echo $pcount; ?></h6>
                          <span class="text-success small pt-1 fw-bold">All Partners</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="card info-card revenue-card">
                    <div class="card-body">
                      <h5 class="card-title">Active Partners</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="ps-3">
                          <h6><?php echo $actpcount; ?></h6>
                          <span class="text-success small pt-1 fw-bold">Active</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="card info-card customers-card">
                    <div class="card-body">
                      <h5 class="card-title">Inactive Partners</h5>
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-x-circle"></i>
                        </div>
                        <div class="ps-3">
                          <h6><?php echo $inactpcount; ?></h6>
                          <span class="text-danger small pt-1 fw-bold">Inactive</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <script>
    function confirmDelete(partnerId, partnerName) {
      if (confirm('Are you sure you want to suspend partner "' + partnerName + '"? This will deactivate their account, but not delete it.')) {
        // Send suspend request via POST
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'suspend_partner.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              alert('Partner suspended successfully!');
              location.reload();
            } else {
              alert('Error suspending partner.');
            }
          }
        };
        xhr.send('id=' + encodeURIComponent(partnerId));
      }
    }
  </script>

  <?php include('footer.php'); ?>

</body>

</html>