<?php
// Database configuration for PostgreSQL
$dsn = "pgsql:host=dpg-cvn925a4d50c73fv6m70-a;port=5432;dbname=admin_db_5jq5;user=admin_db_5jq5_user;password=zQ7Zey6xTtDtqT99fKgUepfsuEhCjIoZ";

try {
    // Get the tracking number from the URL
    $tracking_number = isset($_GET['num']) ? $_GET['num'] : '';
    
    if (empty($tracking_number)) {
        header("Location: index.php");
        exit();
    }
    
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch tracking record details
    $stmt = $conn->prepare("SELECT * FROM tracking_orders WHERE tracking_number = :tracking_number");
    $stmt->bindParam(':tracking_number', $tracking_number);
    $stmt->execute();
    $tracking_record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tracking_record) {
        header("Location: index.php?error=record_not_found");
        exit();
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
    <title>View Tracking Details</title>
    <!-- base:css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
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

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <label style="font-weight: bold;font-size: 25px;">TRACKING NUMBER</label>
                                    <input type="text" readonly="" value="<?php echo $tracking_record['tracking_number']; ?>" name="tracking_number" class="form-control" id="exampleInputUsername1" placeholder="Tracking Number">
                                </div>
                            </div>
                        </div>
                        
                        <center>
                            <?php if(!empty($tracking_record['package_image'])): ?>
                                <img height="200" width="250" src="<?php echo $tracking_record['package_image']; ?>" alt="Package Image">
                            <?php else: ?>
                                <img height="200" width="250" src="images/no-image.png" alt="No Image Available">
                            <?php endif; ?>
                        </center>
                        
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Sender's Info</h4>
                                    
                                    <form class="forms-sample">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Sender's Name</label>
                                            <input type="text" class="form-control" name="sname" value="<?php echo $tracking_record['sender_name'] ?? ''; ?>" id="exampleInputUsername1" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Sender's Contact</label>
                                            <input type="text" class="form-control" value="<?php echo $tracking_record['sender_contact'] ?? ''; ?>" name="scontact" id="exampleInputEmail1" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Sender's Email</label>
                                            <input type="text" class="form-control" name="smail" value="<?php echo $tracking_record['sender_email'] ?? ''; ?>" id="exampleInputPassword1" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Sender's Address</label>
                                            <textarea class="form-control" name="saddress" readonly><?php echo $tracking_record['sender_address'] ?? ''; ?></textarea>
                                        </div>
                                        <h4 class="card-title">Other Info</h4>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Status</label>
                                            <input type="text" class="form-control" value="<?php echo $tracking_record['status'] ?? ''; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Dispatch Location</label>
                                            <input type="text" class="form-control" value="<?php echo $tracking_record['dispatch_location'] ?? ''; ?>" name="dispatchl" id="exampleInputPassword1" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Carrier</label>
                                            <input type="text" class="form-control" value="<?php echo $tracking_record['carrier'] ?? ''; ?>" name="carrier" id="exampleInputPassword1" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Carrier reference number</label>
                                            <input type="text" class="form-control" value="<?php echo $tracking_record['carrier_ref_no'] ?? ''; ?>" name="carrier_ref" id="exampleInputPassword1" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Weight</label>
                                            <input type="text" class="form-control" value="<?php echo $tracking_record['weight'] ?? ''; ?>" name="weight" id="exampleInputPassword1" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Payment Mode</label>
                                            <input type="text" class="form-control" value="<?php echo $tracking_record['payment_mode'] ?? ''; ?>" name="payment_mode" id="exampleInputPassword1" readonly>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Receiver's Info</h4>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Receiver's Name</label>
                                        <input type="text" class="form-control" value="<?php echo $tracking_record['receiver_name'] ?? ''; ?>" name="rname" id="exampleInputUsername1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Receiver's Contact</label>
                                        <input type="text" class="form-control" value="<?php echo $tracking_record['receiver_contact'] ?? ''; ?>" name="rcontact" id="exampleInputEmail1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Receiver's Email</label>
                                        <input type="text" name="rmail" class="form-control" value="<?php echo $tracking_record['receiver_email'] ?? ''; ?>" id="exampleInputPassword1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Receiver's Address</label>
                                        <textarea class="form-control" name="raddress" readonly><?php echo $tracking_record['receiver_address'] ?? ''; ?></textarea>
                                    </div>
                                    <h4 class="card-title">Other Info</h4>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Destination</label>
                                        <input type="text" class="form-control" name="destination" value="<?php echo $tracking_record['destination'] ?? ''; ?>" id="exampleInputPassword1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Package description</label>
                                        <input type="text" class="form-control" name="desc" value="<?php echo $tracking_record['package_desc'] ?? ''; ?>" id="exampleInputPassword1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Dispatch Date</label>
                                        <input type="text" class="form-control" name="dispatch" value="<?php echo $tracking_record['dispatch_date'] ?? ''; ?>" id="exampleInputPassword1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Estimated Delivery Date</label>
                                        <input type="text" class="form-control" value="<?php echo $tracking_record['delivery_date'] ?? ''; ?>" name="delivery" id="exampleInputPassword1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Shipment mode</label>
                                        <input type="text" class="form-control" value="<?php echo $tracking_record['shipment_mode'] ?? ''; ?>" name="ship_mode" id="exampleInputPassword1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Quantity</label>
                                        <input type="text" class="form-control" value="<?php echo $tracking_record['quantity'] ?? ''; ?>" name="quantity" id="exampleInputPassword1" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Delivery Time</label>
                                        <input type="text" class="form-control" value="<?php echo $tracking_record['delivery_time'] ?? ''; ?>" name="delivery_time" id="exampleInputPassword1" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 grid-margin stretch-card mt-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
                                    <a href="edit-tracking.php?num=<?php echo $tracking_record['tracking_number']; ?>" class="btn btn-primary">Edit Details</a>
                                    <a href="view-updates.php?num=<?php echo $tracking_record['tracking_number']; ?>" class="btn btn-info">View Updates</a>
                                    <button onclick="copyTrackingNumber('<?php echo $tracking_record['tracking_number']; ?>')" class="btn btn-success">Copy Tracking Number</button>
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