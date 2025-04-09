<?php
// Ensure no output before headers
ob_start();

// Database configuration
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

// Initialize variables
$tracking_number = null;
$update_history = [];
$connection_error = null;

try {
    // Create PDO connection
    $conn = new PDO($dsn, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
    
    // Sanitize and validate tracking number
    $tracking_number = filter_input(INPUT_GET, 'num', FILTER_UNSAFE_RAW);
    $tracking_number = trim(htmlspecialchars($tracking_number, ENT_QUOTES, 'UTF-8'));
    
    if (empty($tracking_number)) {
        header("Location: index.php");
        ob_end_clean();
        exit();
    }
    
    // Fetch initial tracking record to verify existence
    $verify_stmt = $conn->prepare("SELECT * FROM tracking_orders WHERE tracking_number = :tracking_number");
    $verify_stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
    $verify_stmt->execute();
    $initial_record = $verify_stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$initial_record) {
        header("Location: index.php?error=record_not_found");
        ob_end_clean();
        exit();
    }
    
    // Fetch update history
    $history_stmt = $conn->prepare("
        SELECT 
            status, 
            dispatch_location, 
            tracking_date, 
            tracking_time, 
            delivery_charge, 
            total_charge, 
            note, 
            updated_at 
        FROM tracking_orders 
        WHERE tracking_number = :tracking_number 
        ORDER BY updated_at DESC
    ");
    $history_stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
    $history_stmt->execute();
    $update_history = $history_stmt->fetchAll(PDO::FETCH_ASSOC);
    
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
    <title>Update History - <?php echo htmlspecialchars($tracking_number); ?></title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <style>
        .timeline-item {
            border-left: 3px solid #007bff;
            padding-left: 20px;
            margin-bottom: 20px;
            position: relative;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            left: -12px;
            top: 0;
            background-color: #007bff;
        }
        .timeline-badge {
            position: absolute;
            left: -40px;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
        <!-- Navigation code remains the same as in previous templates -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Update History - Tracking Number: <?php echo htmlspecialchars($tracking_number); ?></h4>
                                    
                                    <?php if(isset($connection_error)): ?>
                                        <div class="alert alert-danger">
                                            <?php echo htmlspecialchars($connection_error); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(empty($update_history)): ?>
                                        <div class="alert alert-info">
                                            No update history found for this tracking number.
                                        </div>
                                    <?php else: ?>
                                        <div class="timeline">
                                            <?php foreach($update_history as $index => $update): ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-badge"><?php echo $index + 1; ?></div>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">
                                                                <?php echo htmlspecialchars($update['status'] ?? 'No Status'); ?> 
                                                                @ <?php echo htmlspecialchars($update['dispatch_location'] ?? 'Unknown Location'); ?>
                                                            </h5>
                                                            <p class="card-text">
                                                                <strong>Date:</strong> <?php echo htmlspecialchars($update['tracking_date'] ?? 'N/A'); ?><br>
                                                                <strong>Time:</strong> <?php echo htmlspecialchars($update['tracking_time'] ?? 'N/A'); ?><br>
                                                                <strong>Delivery Charge:</strong> $<?php echo htmlspecialchars($update['delivery_charge'] ?? '0'); ?><br>
                                                                <strong>Total Charge:</strong> $<?php echo htmlspecialchars($update['total_charge'] ?? '0'); ?><br>
                                                                <strong>Note:</strong> <?php echo htmlspecialchars($update['note'] ?? 'No additional notes'); ?><br>
                                                                <small class="text-muted">
                                                                    <strong>Updated At:</strong> <?php echo htmlspecialchars($update['updated_at']); ?>
                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer code remains the same as in previous templates -->
            </div>
        </div>
    </div>

    <!-- Scripts remain the same as in previous templates -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <script src="js/template.js"></script>
  </body>
</html>
<?php 
// Flush the output buffer
ob_end_flush(); 
?>