<?php 
// Database configuration for PostgreSQL
$dsn = "pgsql:host=dpg-cvn925a4d50c73fv6m70-a;port=5432;dbname=admin_db_5jq5;user=admin_db_5jq5_user;password=zQ7Zey6xTtDtqT99fKgUepfsuEhCjIoZ";

try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Initialize tracking number with month and random number
$tracking_number = "CC-" . date("m") . "-" . rand(100000, 999999);

// Process form submission
if (isset($_POST['submit'])) {
    try {
        // Sender information
        $sname = $_POST['sname'];
        $scontact = $_POST['scontact'];
        $smail = $_POST['smail'];
        $saddress = $_POST['saddress'];
        
        // Receiver information
        $rname = $_POST['rname'];
        $rcontact = $_POST['rcontact'];
        $rmail = $_POST['rmail'];
        $raddress = $_POST['raddress'];
        
        // Shipment information
        $status = $_POST['status'];
        $dispatchl = $_POST['dispatchl'];
        $carrier = $_POST['carrier'];
        $carrier_ref = $_POST['carrier_ref'];
        $weight = $_POST['weight'];
        $payment_mode = $_POST['payment_mode'];
        $dest = $_POST['dest'];
        $desc = $_POST['desc'];
        $dispatch_date = $_POST['dispatch'];
        $delivery_date = $_POST['delivery'];
        $ship_mode = $_POST['ship_mode'];
        $quantity = $_POST['quantity'];
        $delivery_time = $_POST['delivery_time'];
        
        // Handle file upload
        $image_path = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $upload_dir = "uploads/";
                
                // Create directory if it doesn't exist
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                // Generate unique filename
                $filename = $tracking_number . "_" . basename($_FILES['image']['name']);
                $target_file = $upload_dir . $filename;
                
                // Move the uploaded file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_path = $target_file;
                } else {
                    $upload_error = "Error uploading file.";
                }
            } else {
                $upload_error = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
            }
        }
        
        // Current timestamp for creation date
        $created_at = date("Y-m-d H:i:s");
        
        // SQL query to insert tracking data using PDO prepared statement for PostgreSQL
        $stmt = $conn->prepare("INSERT INTO tracking_orders (
            tracking_number, 
            sender_name, 
            sender_contact, 
            sender_email, 
            sender_address, 
            receiver_name, 
            receiver_contact, 
            receiver_email, 
            receiver_address, 
            status, 
            dispatch_location, 
            carrier, 
            carrier_ref_no, 
            weight, 
            payment_mode, 
            destination, 
            package_desc, 
            dispatch_date, 
            delivery_date, 
            shipment_mode, 
            quantity, 
            delivery_time, 
            package_image, 
            created_at
        ) VALUES (
            :tracking_number, 
            :sname, 
            :scontact, 
            :smail, 
            :saddress, 
            :rname, 
            :rcontact, 
            :rmail, 
            :raddress, 
            :status, 
            :dispatchl, 
            :carrier, 
            :carrier_ref, 
            :weight, 
            :payment_mode, 
            :dest, 
            :desc, 
            :dispatch_date, 
            :delivery_date, 
            :ship_mode, 
            :quantity, 
            :delivery_time, 
            :image_path, 
            :created_at
        )");
        
        // Bind parameters
        $stmt->bindParam(':tracking_number', $tracking_number);
        $stmt->bindParam(':sname', $sname);
        $stmt->bindParam(':scontact', $scontact);
        $stmt->bindParam(':smail', $smail);
        $stmt->bindParam(':saddress', $saddress);
        $stmt->bindParam(':rname', $rname);
        $stmt->bindParam(':rcontact', $rcontact);
        $stmt->bindParam(':rmail', $rmail);
        $stmt->bindParam(':raddress', $raddress);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':dispatchl', $dispatchl);
        $stmt->bindParam(':carrier', $carrier);
        $stmt->bindParam(':carrier_ref', $carrier_ref);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':payment_mode', $payment_mode);
        $stmt->bindParam(':dest', $dest);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':dispatch_date', $dispatch_date);
        $stmt->bindParam(':delivery_date', $delivery_date);
        $stmt->bindParam(':ship_mode', $ship_mode);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':delivery_time', $delivery_time);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':created_at', $created_at);
        
        // Execute query
        $stmt->execute();
        
        // Set success message
        $success_message = "Tracking added successfully with tracking number: " . $tracking_number;
        
        // Generate new tracking number for next entry
        $tracking_number = "CC-" . date("m") . "-" . rand(100000, 999999);
    } catch(PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
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
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
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

                <?php if(isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if(isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if(isset($upload_error)): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $upload_error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <label style="font-weight: bold;font-size: 25px;">TRACKING NUMBER</label>
                                <input type="text" readonly value="<?php echo $tracking_number; ?>" name="tracking_number" class="form-control" id="exampleInputUsername1" placeholder="Tracking Number">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Sender's Info</h4>
                          <p class="card-description">
                            
                          </p>
                          <form method="post" action="" enctype="multipart/form-data" class="forms-sample">
                            <div class="form-group">
                              <label for="exampleInputUsername1">Sender's Name</label>
                              <input type="text" class="form-control" name="sname" value="" id="exampleInputUsername1" placeholder="Sender's Name" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Sender's Contact</label>
                              <input type="number" class="form-control" value="" name="scontact" id="exampleInputEmail1" placeholder="Sender's Contact" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Sender's Email</label>
                              <input type="email" class="form-control" name="smail" value="" id="exampleInputPassword1" placeholder="Sender's Email">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputConfirmPassword1">Sender's Address</label>
                              <textarea class="form-control" placeholder="Sender's Address" name="saddress" required></textarea>
                            </div>
                            <h4 class="card-title">Other Info</h4>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Status</label>
                              <select class="form-control" name="status">
                                <option value="Pending">Pending</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Picked Up">Picked Up</option>
                                <option value="Arrived">Arrived</option>
                                <option value="Delivered">Delivered</option>
                                <option value="On hold">On hold</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Dispatch Location</label>
                              <input type="text" class="form-control" value="" name="dispatchl" id="exampleInputPassword1" placeholder="Origin Port" required>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputPassword1">Carrier</label>
                              <input type="text" class="form-control" value="" name="carrier" id="exampleInputPassword1" placeholder="Carrier Ex- DHL" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Carrier reference number</label>
                              <input type="text" class="form-control" value="" name="carrier_ref" id="exampleInputPassword1" placeholder="Carrier reference number Ex- 32423">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Weight(Add unit e.g KG)</label>
                              <input type="text" class="form-control" value="" name="weight" id="exampleInputPassword1" placeholder="Weight" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Payment Mode</label>
                              <input type="text" class="form-control" value="" name="payment_mode" id="exampleInputPassword1" placeholder="Payment Mode">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Package Image</label>
                              <input type="file" class="form-control" name="image" required id="exampleInputPassword1">
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Receiver's Info</h4>
                          <p class="card-description">
                          </p>
                      
                            <div class="form-group">
                              <label for="exampleInputUsername1">Receiver's Name</label>
                              <input type="text" class="form-control" value="" name="rname" id="exampleInputUsername1" placeholder="Receiver's Name" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail1">Receiver's Contact</label>
                              <input type="number" class="form-control" value="" name="rcontact" id="exampleInputEmail1" placeholder="Receiver's Contact" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Receiver's Email</label>
                              <input type="email" name="rmail" class="form-control" value="" id="exampleInputPassword1" placeholder="Receiver's Email">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputConfirmPassword1">Receiver's Address</label>
                              <textarea class="form-control" name="raddress" placeholder="Receiver Address" required></textarea>
                            </div>
                            <h4 class="card-title">Other Info</h4>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Destination</label>
                              <input type="text" class="form-control" name="dest" value="" id="exampleInputPassword1" placeholder="Destination" required>
                            </div>
                           <div class="form-group">
                              <label for="exampleInputPassword1">Package description</label>
                              <input type="text" class="form-control" name="desc" value="" id="exampleInputPassword1" placeholder="Package Description" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Dispatch Date</label>
                              <input type="date" class="form-control" name="dispatch" value="" id="exampleInputPassword1" placeholder="Dispatch Date" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Estimated Delivery Date</label>
                              <input type="date" class="form-control" value="" name="delivery" id="exampleInputPassword1" placeholder="Estimated Delivery Date" required>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputPassword1">Shipment mode</label>
                              <input type="text" class="form-control" value="" name="ship_mode" id="exampleInputPassword1" placeholder="Shipment mode" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Quantity</label>
                              <input type="text" class="form-control" value="" name="quantity" id="exampleInputPassword1" placeholder="Quantity" required>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Delivery Time</label>
                              <input type="time" class="form-control" value="" name="delivery_time" id="exampleInputPassword1" placeholder="Delivery time" required>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-12 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Add</button>
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
                <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright ©Platinum Links 2025 All rights reserved.</span>
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

<!-- Client-side validation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('.forms-sample');
    
    // Add custom validation if needed beyond the required attributes
    form.addEventListener('submit', function(event) {
        // Additional validation can be added here if needed
        
        // Example: Validate email format
        const emailFields = document.querySelectorAll('input[type="email"]');
        emailFields.forEach(function(field) {
            if (field.value !== '' && !validateEmail(field.value)) {
                alert('Please enter a valid email address');
                event.preventDefault();
                field.focus();
                return;
            }
        });
    });
    
    // Email validation function
    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});
</script>
  </body>
</html>