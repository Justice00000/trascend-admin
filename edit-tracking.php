<?php
// Ensure no output before headers
ob_start();

// Database configuration for PostgreSQL
$dsn = "pgsql:host=dpg-cvn925a4d50c73fv6m70-a;port=5432;dbname=admin_db_5jq5;user=admin_db_5jq5_user;password=zQ7Zey6xTtDtqT99fKgUepfsuEhCjIoZ";

try {
    // Create PDO connection
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Sanitize and validate tracking number
    $tracking_number = filter_input(INPUT_GET, 'num', FILTER_UNSAFE_RAW);
    $tracking_number = trim(htmlspecialchars($tracking_number, ENT_QUOTES, 'UTF-8'));
    
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
        // Sanitize and validate inputs
        $status = filter_input(INPUT_POST, 'status', FILTER_UNSAFE_RAW);
        $status = trim(htmlspecialchars($status, ENT_QUOTES, 'UTF-8'));
        
        $dispatch_location = filter_input(INPUT_POST, 'dispatch_location', FILTER_UNSAFE_RAW);
        $dispatch_location = trim(htmlspecialchars($dispatch_location, ENT_QUOTES, 'UTF-8'));
        
        // Handle date and time
        $tracking_date = filter_input(INPUT_POST, 'date', FILTER_UNSAFE_RAW);
        $tracking_time = filter_input(INPUT_POST, 'time', FILTER_UNSAFE_RAW);
        
        // Safely handle numeric inputs
        $delivery_charge = filter_input(INPUT_POST, 'delivery_charge', FILTER_VALIDATE_FLOAT);
        $delivery_charge = ($delivery_charge === false || is_null($delivery_charge)) ? 0 : $delivery_charge;
        
        $total_charge = filter_input(INPUT_POST, 'total_charge', FILTER_VALIDATE_FLOAT);
        $total_charge = ($total_charge === false || is_null($total_charge)) ? 0 : $total_charge;
        
        $note = filter_input(INPUT_POST, 'note', FILTER_UNSAFE_RAW);
        $note = trim(htmlspecialchars($note, ENT_QUOTES, 'UTF-8'));
        
        // Begin a transaction
        $conn->beginTransaction();
        
        try {
            // 1. Update main tracking_orders table
            $update_main_stmt = $conn->prepare("
                UPDATE tracking_orders 
                SET 
                    status = :status, 
                    dispatch_location = :dispatch_location,
                    updated_at = CURRENT_TIMESTAMP
                WHERE tracking_number = :tracking_number
            ");
            
            $update_main_stmt->bindParam(':status', $status);
            $update_main_stmt->bindParam(':dispatch_location', $dispatch_location);
            $update_main_stmt->bindParam(':tracking_number', $tracking_number);
            $update_main_stmt->execute();
            
            // 2. Insert into tracking_updates table
            $insert_update_stmt = $conn->prepare("
                INSERT INTO tracking_updates (
                    tracking_number, 
                    status, 
                    dispatch_location, 
                    tracking_date, 
                    tracking_time, 
                    delivery_charge, 
                    total_charge, 
                    note
                ) VALUES (
                    :tracking_number, 
                    :status, 
                    :dispatch_location, 
                    :tracking_date, 
                    :tracking_time, 
                    :delivery_charge, 
                    :total_charge, 
                    :note
                )
            ");
            
            $insert_update_stmt->bindParam(':tracking_number', $tracking_number);
            $insert_update_stmt->bindParam(':status', $status);
            $insert_update_stmt->bindParam(':dispatch_location', $dispatch_location);
            $insert_update_stmt->bindParam(':tracking_date', $tracking_date);
            $insert_update_stmt->bindParam(':tracking_time', $tracking_time);
            $insert_update_stmt->bindParam(':delivery_charge', $delivery_charge, PDO::PARAM_STR);
            $insert_update_stmt->bindParam(':total_charge', $total_charge, PDO::PARAM_STR);
            $insert_update_stmt->bindParam(':note', $note);
            $insert_update_stmt->execute();
            
            // Commit the transaction
            $conn->commit();
            
            // Redirect to view details with success message
            header("Location: view-details.php?num=" . urlencode($tracking_number) . "&updated=1");
            exit();
            
        } catch (PDOException $e) {
            // Rollback the transaction
            $conn->rollBack();
            $update_error = "Failed to update tracking information: " . $e->getMessage();
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
        <!-- Existing navigation code -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php if(isset($connection_error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($connection_error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($update_error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($update_error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <label style="font-weight: bold;font-size: 25px;">TRACKING NUMBER - <?php echo htmlspecialchars($tracking_number); ?></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" action="edit-tracking.php?num=<?php echo urlencode($tracking_number); ?>" class="forms-sample">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status" required>
                                                <?php 
                                                $statuses = [
                                                    'Pending', 'Active', 'Inactive', 
                                                    'Picked Up', 'On going', 'Delivered', 
                                                    'Departed', 'On hold'
                                                ];
                                                foreach ($statuses as $status): ?>
                                                    <option value="<?php echo htmlspecialchars($status); ?>" 
                                                        <?php echo ($tracking_record['status'] == $status) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($status); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="dispatch_location">Current Location</label>
                                            <input type="text" class="form-control" 
                                                   value="<?php echo htmlspecialchars($tracking_record['dispatch_location'] ?? ''); ?>" 
                                                   name="dispatch_location" 
                                                   placeholder="Current Location" 
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" class="form-control" 
                                                   value="<?php echo date('Y-m-d'); ?>" 
                                                   name="date" 
                                                   placeholder="Date" 
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <label for="time">Time</label>
                                            <input type="time" class="form-control" 
                                                   value="<?php echo date('H:i'); ?>" 
                                                   name="time" 
                                                   required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="delivery_charge">Delivery Charge</label>
                                            <input type="number" 
                                                   step="0.01" 
                                                   class="form-control" 
                                                   name="delivery_charge" 
                                                   placeholder="Delivery Charge"
                                                   min="0">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="total_charge">Total Charge</label>
                                            <input type="number" 
                                                   step="0.01" 
                                                   class="form-control" 
                                                   name="total_charge" 
                                                   placeholder="Total Charge"
                                                   min="0">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea name="note" 
                                                      class="form-control" 
                                                      placeholder="Enter update notes or description"></textarea>
                                        </div>
                                        
                                        <div class="col-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <button type="submit" 
                                                            class="btn btn-lg btn-success btn-block" 
                                                            name="update">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer code -->
                <footer class="footer">
                  <div class="footer-wrap">
                      <div class="w-100 clearfix">
                        <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © Transcend Logistics 2025 All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> <i class="mdi mdi-heart-outline"></i></span>
                      </div>
                  </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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
<?php 
// Flush the output buffer
ob_end_flush(); 
?>