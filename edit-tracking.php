<?php
// Database configuration for PostgreSQL
$dsn = "pgsql:host=dpg-cvn925a4d50c73fv6m70-a;port=5432;dbname=admin_db_5jq5;user=admin_db_5jq5_user;password=zQ7Zey6xTtDtqT99fKgUepfsuEhCjIoZ";

try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the tracking number from the URL
    $tracking_number = isset($_GET['num']) ? $_GET['num'] : '';
    
    if (empty($tracking_number)) {
        header("Location: index.php");
        exit();
    }
    
    // Fetch tracking record details
    $stmt = $conn->prepare("SELECT * FROM tracking_orders WHERE tracking_number = :tracking_number");
    $stmt->bindParam(':tracking_number', $tracking_number);
    $stmt->execute();
    $tracking_record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tracking_record) {
        header("Location: index.php?error=record_not_found");
        exit();
    }
    
    // Process form submission for updates
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $status = $_POST['status'] ?? '';
        $current_loc = $_POST['current_loc'] ?? '';
        $note = $_POST['note'] ?? '';
        
        // Update the tracking record with new status and location
        $update_stmt = $conn->prepare("
            UPDATE tracking_orders 
            SET status = :status, 
                current_location = :current_loc,
                updated_at = CURRENT_TIMESTAMP
            WHERE tracking_number = :tracking_number
        ");
        
        $update_stmt->bindParam(':status', $status);
        $update_stmt->bindParam(':current_loc', $current_loc);
        $update_stmt->bindParam(':tracking_number', $tracking_number);
        
        if ($update_stmt->execute()) {
            // Redirect to view details with success message
            header("Location: view-details.php?num=$tracking_number&updated=1");
            exit();
        } else {
            $update_error = "Failed to update tracking information.";
        }
    }
} catch (PDOException $e) {
    $connection_error = "Database Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update Tracking Details</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
        <!-- partial:partials/_horizontal-navbar.html -->
        <div class="horizontal-menu">
          <nav class="navbar top-navbar col-lg-12 col-12 p-0">
            <div class="container-fluid">
              <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                <ul class="navbar-nav navbar-nav-left">
                </ul>
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                  <a class="navbar-brand brand-logo" href="index.php">
                    <img src="images/logo.png" alt="logo" class="enhanced-logo"/>
                  </a>
                  <a class="navbar-brand brand-logo-mini" href="index.php">
                    <img src="images/logo.png" alt="logo" class="enhanced-logo-mini"/>
                  </a>
                </div>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                      <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <span class="nav-profile-name">Admin</span>
                        <span class="online-status"></span>
                        <img src="images/face28.png" alt="profile"/>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                          <a href="settings.php" class="dropdown-item">
                            <i class="mdi mdi-settings text-primary"></i>
                            Settings
                          </a>
                          <a href="logout.php" class="dropdown-item">
                            <i class="mdi mdi-logout text-primary"></i>
                            Logout
                          </a>
                      </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                  <span class="mdi mdi-menu"></span>
                </button>
              </div>
            </div>
          </nav>
          <nav class="bottom-navbar">
            <div class="container">
                <ul class="nav page-navigation">
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">
                      <i class="mdi mdi-file-document-box menu-icon"></i>
                      <span class="menu-title">Dashboard</span>
                    </a>
                  </li>
                  <li class="nav-item">
                      <a href="add-tracking.php" class="nav-link">
                        <i class="mdi mdi-grid menu-icon"></i>
                        <span class="menu-title">Add Tracking</span>
                        <i class="menu-arrow"></i>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="account.php" class="nav-link">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">Account</span>
                        <i class="menu-arrow"></i>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="settings.php" class="nav-link">
                        <i class="mdi mdi-settings menu-icon"></i>
                        <span class="menu-title">Settings</span>
                        <i class="menu-arrow"></i>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="logout.php" class="nav-link">
                        <i class="mdi mdi-close menu-icon"></i>
                        <span class="menu-title">Logout</span>
                        <i class="menu-arrow"></i>
                      </a>
                  </li>
                </ul>
            </div>
          </nav>
        </div>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php if(isset($connection_error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $connection_error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($update_error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $update_error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <label style="font-weight: bold;font-size: 25px;">TRACKING NUMBER - <?php echo $tracking_number; ?></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="edit-tracking.php?num=<?php echo $tracking_number; ?>" class="forms-sample">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="Pending" <?php echo ($tracking_record['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Active" <?php echo ($tracking_record['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                                <option value="Inactive" <?php echo ($tracking_record['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                <option value="Picked Up" <?php echo ($tracking_record['status'] == 'Picked Up') ? 'selected' : ''; ?>>Picked Up</option>
                                                <option value="On going" <?php echo ($tracking_record['status'] == 'On going') ? 'selected' : ''; ?>>On going</option>
                                                <option value="Delivered" <?php echo ($tracking_record['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                                <option value="Departed" <?php echo ($tracking_record['status'] == 'Departed') ? 'selected' : ''; ?>>Departed</option>
                                                <option value="On hold" <?php echo ($tracking_record['status'] == 'On hold') ? 'selected' : ''; ?>>On hold</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="current_loc">Current Location</label>
                                            <input type="text" class="form-control" value="<?php echo $tracking_record['current_location'] ?? ''; ?>" name="current_loc" placeholder="Current Location">
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="date" placeholder="Date">
                                        </div>

                                        <div class="form-group">
                                            <label for="time">Time</label>
                                            <input type="time" class="form-control" value="<?php echo date('H:i'); ?>" name="time">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="delivery_charge">Delivery Charge</label>
                                            <input type="text" class="form-control" value="" name="delivery_charge" placeholder="Delivery Charge">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="total_charge">Total Charge</label>
                                            <input type="text" class="form-control" value="" name="total_charge" placeholder="Total Charge">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea name="note" class="form-control" placeholder="Enter update notes or description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-lg btn-success btn-block" name="update">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                  <div class="footer-wrap">
                      <div class="w-100 clearfix">
                        <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © Transcend Logistics 2025 All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> <i class="mdi mdi-heart-outline"></i></span>
                      </div>
                  </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <script src="js/template.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="vendors/select2/select2.min.js"></script>
    <script src="js/file-upload.js"></script>
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
  </body>
</html>