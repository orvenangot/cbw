<?php
require_once 'Auth/auth.php';

// Validate admin session
$auth->validateSession();

// Database connection
include('dbconnect.php');

// Fetch all users
$query = "SELECT * FROM tbl_accounts ORDER BY date_registered DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll();
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
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            
            <!-- Users Table -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Recent Users</h5>
                  
                  <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Account Number</th>
                          <th scope="col">Name</th>
                          <th scope="col">Card Type</th>
                          <th scope="col">Status</th>
                          <th scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (empty($users)): ?>
                          <tr>
                            <td colspan="6" class="text-center">No users found</td>
                          </tr>
                        <?php else: ?>
                          <?php foreach (array_slice($users, 0, 5) as $index => $user): 
                            $newindex = $index + 1;?>
                            <tr>
                              <th scope="row"><?php echo $newindex; ?></th>
                              <td>
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($user['account_number']); ?></span>
                              </td>
                              <td>
                                <strong><?php echo htmlspecialchars($user['account_first_name'] . ' ' . $user['account_last_name']); ?></strong>
                              </td>
                              <td>
                                <?php 
                                $cardClass = '';
                                switch($user['card_type']) {
                                    case 'GOLD':
                                        $cardClass = 'bg-warning';
                                        break;
                                    case 'SILVER':
                                        $cardClass = 'bg-secondary';
                                        break;
                                    case 'BRONZE':
                                        $cardClass = 'bg-danger';
                                        break;
                                    default:
                                        $cardClass = 'bg-info';
                                }
                                ?>
                                <span class="badge <?php echo $cardClass; ?>"><?php echo htmlspecialchars($user['card_type']); ?></span>
                              </td>
                              <td>
                                <?php if ($user['card_status'] == 1): ?>
                                  <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                  <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                              </td>
                              <td>
                                <a href="view_user.php?id=<?php echo $user['unique_id']; ?>" class="btn btn-sm btn-outline-primary" title="View">
                                  <i class="bi bi-eye"></i>
                                </a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                  
                  <?php if (count($users) > 5): ?>
                    <div class="text-center mt-3">
                      <a href="users.php" class="btn btn-primary">View All Users (<?php echo count($users); ?>)</a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Left side columns -->
        
        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- Statistics Cards -->
          <div class="row">
            <div class="col-12">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Total Users</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo count($users); ?></h6>
                      <span class="text-success small pt-1 fw-bold">All Users</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Gold Members</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-award"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo count(array_filter($users, function($user) { return $user['card_type'] == 'GOLD'; })); ?></h6>
                      <span class="text-warning small pt-1 fw-bold">Premium</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Silver Members</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-award"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo count(array_filter($users, function($user) { return $user['card_type'] == 'SILVER'; })); ?></h6>
                      <span class="text-secondary small pt-1 fw-bold">Standard</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Bronze Members</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-award"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo count(array_filter($users, function($user) { return $user['card_type'] == 'BRONZE'; })); ?></h6>
                      <span class="text-danger small pt-1 fw-bold">Basic</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Right side columns -->
      </div>
    </section>
  </main><!-- End #main -->
  <?php include('footer.php');?>
</body>
</html> 