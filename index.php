<?php
// Database configuration - use environment variables or a secure configuration file
$dbConfig = [
    'host' => getenv('DB_HOST') ?: 'dpg-cvn925a4d50c73fv6m70-a',
    'port' => getenv('DB_PORT') ?: 5432,
    'dbname' => getenv('DB_NAME') ?: 'admin_db_5jq5',
    'user' => getenv('DB_USER') ?: 'admin_db_5jq5_user',
    'password' => getenv('DB_PASSWORD') ?: 'zQ7Zey6xTtDtqT99fKgUepfsuEhCjIoZ'
];

// Construct DSN more securely
$dsn = sprintf(
    "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
    $dbConfig['host'], 
    $dbConfig['port'], 
    $dbConfig['dbname'], 
    $dbConfig['user'], 
    $dbConfig['password']
);

try {
    // Create PDO connection with error mode and persistent connections
    $conn = new PDO($dsn, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
    
    // Sanitize and validate tracking number
    $tracking_number = filter_input(INPUT_GET, 'num', FILTER_SANITIZE_STRING);
    
    if (empty($tracking_number)) {
        header("Location: index.php");
        exit();
    }
    
    // Fetch tracking record details with parameterized query
    $stmt = $conn->prepare("SELECT * FROM tracking_orders WHERE tracking_number = :tracking_number");
    $stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
    $stmt->execute();
    $tracking_record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tracking_record) {
        header("Location: index.php?error=record_not_found");
        exit();
    }
    
    // Process form submission for updates
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        // Sanitize and validate input
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
        $dispatch_location = filter_input(INPUT_POST, 'dispatch_location', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);
        $delivery_charge = filter_input(INPUT_POST, 'delivery_charge', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $total_charge = filter_input(INPUT_POST, 'total_charge', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
        
        // Validate required fields
        if (empty($status) || empty($dispatch_location)) {
            $update_error = "Status and Current Location are required.";
        } else {
            // Prepare update statement with additional fields
            $update_stmt = $conn->prepare("
                UPDATE tracking_orders 
                SET 
                    status = :status, 
                    dispatch_location = :dispatch_location,
                    tracking_date = :tracking_date,
                    tracking_time = :tracking_time,
                    delivery_charge = :delivery_charge,
                    total_charge = :total_charge,
                    note = :note,
                    updated_at = CURRENT_TIMESTAMP
                WHERE tracking_number = :tracking_number
            ");
            
            // Bind parameters
            $update_stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $update_stmt->bindParam(':dispatch_location', $dispatch_location, PDO::PARAM_STR);
            $update_stmt->bindParam(':tracking_date', $date, PDO::PARAM_STR);
            $update_stmt->bindParam(':tracking_time', $time, PDO::PARAM_STR);
            $update_stmt->bindParam(':delivery_charge', $delivery_charge, PDO::PARAM_STR);
            $update_stmt->bindParam(':total_charge', $total_charge, PDO::PARAM_STR);
            $update_stmt->bindParam(':note', $note, PDO::PARAM_STR);
            $update_stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
            
            try {
                if ($update_stmt->execute()) {
                    // Redirect to view details with success message
                    header("Location: view-details.php?num=" . urlencode($tracking_number) . "&updated=1");
                    exit();
                } else {
                    $update_error = "Failed to update tracking information.";
                }
            } catch (PDOException $e) {
                $update_error = "Update Error: " . $e->getMessage();
                // Log the error securely
                error_log("Tracking Update Error: " . $e->getMessage());
            }
        }
    }
} catch (PDOException $e) {
    // Log the error securely
    error_log("Database Connection Error: " . $e->getMessage());
    $connection_error = "Database Error: Unable to connect. Please try again later.";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
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

                <?php if(isset($_GET['deleted'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Tracking record deleted successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if(isset($connection_error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $connection_error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">TRACKERS</h4>
                         
                          <div class="table-responsive pt-3">
                            <table class="table table-dark">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Image</th>
                                  <th>Tracking Number</th>
                                  <th>Status</th>
                                  <th>Date Added</th>
                                  <th>Edit</th>
                                  <th>Delete</th>
                                  <th>Copy</th>
                                  <th>View Details</th>
                                  <th>View Updates</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if(isset($tracking_records) && count($tracking_records) > 0): ?>
                                    <?php $counter = 1; ?>
                                    <?php foreach($tracking_records as $record): ?>
                                        <form method="post" action="index.php">
                                            <input type="hidden" name="tnumb" value="<?php echo $record['tracking_number']; ?>">
                                            <tr>
                                                <td><?php echo $counter++; ?></td>
                                                <td>
                                                    <?php if(!empty($record['package_image'])): ?>
                                                        <img style="height: 90px;width: 90px;" src="<?php echo $record['package_image']; ?>" >
                                                    <?php else: ?>
                                                        <img style="height: 90px;width: 90px;" src="images/no-image.png" >
                                                    <?php endif; ?>
                                                </td>
                                                <td><b><?php echo $record['tracking_number']; ?></b></td>
                                                <td><b><?php echo $record['status']; ?></b></td>
                                                <td><b><?php echo $record['created_at']; ?></b></td>
                                                <td><a href="edit-tracking.php?num=<?php echo $record['tracking_number']; ?>" class="btn btn-primary">Update</a></td>
                                                <td><button type="submit" name="delete" onclick="return confirm('Do you really want to delete this ?')" class="btn btn-danger">Delete</button></td>
                                                <td><button type="button" onclick="copyTrackingNumber('<?php echo $record['tracking_number']; ?>')" class="btn btn-info">Copy Tracking Number</button></td>
                                                <td><a class="btn btn-secondary" href="view-details.php?num=<?php echo $record['tracking_number']; ?>">View Details</a></td>
                                                <td><a class="btn btn-warning" href="view-updates.php?num=<?php echo $record['tracking_number']; ?>">View Updates</a></td>
                                            </tr>
                                            <input type="hidden" name="image" value="<?php echo basename($record['package_image']); ?>">
                                        </form>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No tracking records found</td>
                                    </tr>
                                <?php endif; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
				<!-- content-wrapper ends -->
				<!-- partial:partials/_footer.html -->
				<footer class="footer">
          <div class="footer-wrap">
              <div class="w-100 clearfix">
                <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright ©Transcend Logistics 2025 All rights reserved.</span>
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

<script>
function copyTrackingNumber(trackingNumber) {
    navigator.clipboard.writeText(trackingNumber)
        .then(() => {
            alert("Copied the tracking number: " + trackingNumber);
        })
        .catch(err => {
            console.error('Failed to copy: ', err);
        });
}
</script>
  </body>
</html>