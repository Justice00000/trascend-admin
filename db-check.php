<?php
// Database configuration
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "tracking_db";

// Establish database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Database Connection Test</h2>";
echo "Successfully connected to database: " . $database . "<br><br>";

// Check if tracking_orders table exists
$result = $conn->query("SHOW TABLES LIKE 'tracking_orders'");
if ($result->num_rows > 0) {
    echo "Table 'tracking_orders' exists.<br>";
    
    // Get column information
    echo "<h3>Column Structure for tracking_orders:</h3>";
    $columns = $conn->query("SHOW COLUMNS FROM tracking_orders");
    
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    while ($column = $columns->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "<td>" . $column['Extra'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Table 'tracking_orders' does not exist.<br>";
    
    // Create the table
    echo "<h3>Creating tracking_orders table:</h3>";
    
    $create_table_sql = "CREATE TABLE tracking_orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tracking_number VARCHAR(20) NOT NULL UNIQUE,
        sender_name VARCHAR(100) NOT NULL,
        sender_contact VARCHAR(20) NOT NULL,
        sender_email VARCHAR(100),
        sender_address TEXT NOT NULL,
        receiver_name VARCHAR(100) NOT NULL,
        receiver_contact VARCHAR(20) NOT NULL,
        receiver_email VARCHAR(100),
        receiver_address TEXT NOT NULL,
        status VARCHAR(50) NOT NULL DEFAULT 'Pending',
        dispatch_location VARCHAR(100) NOT NULL,
        carrier VARCHAR(100) NOT NULL,
        carrier_ref_no VARCHAR(100),
        weight VARCHAR(50) NOT NULL,
        payment_mode VARCHAR(50),
        destination VARCHAR(100) NOT NULL,
        package_desc TEXT NOT NULL,
        dispatch_date DATE NOT NULL,
        delivery_date DATE NOT NULL,
        shipment_mode VARCHAR(50) NOT NULL,
        quantity VARCHAR(50) NOT NULL,
        delivery_time TIME NOT NULL,
        package_image VARCHAR(255),
        created_at DATETIME NOT NULL
    )";
    
    if ($conn->query($create_table_sql) === TRUE) {
        echo "Table 'tracking_orders' created successfully.<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// Check uploads directory
echo "<h3>Uploads Directory Check:</h3>";
$upload_dir = "uploads/";
if (file_exists($upload_dir)) {
    echo "Uploads directory exists.<br>";
    
    // Check if it's writable
    if (is_writable($upload_dir)) {
        echo "Uploads directory is writable.<br>";
    } else {
        echo "Warning: Uploads directory is not writable.<br>";
        echo "Try running: chmod 777 uploads/<br>";
    }
} else {
    echo "Uploads directory does not exist. Creating...<br>";
    if (mkdir($upload_dir, 0777, true)) {
        echo "Uploads directory created successfully.<br>";
    } else {
        echo "Error creating uploads directory.<br>";
    }
}

// Close connection
$conn->close();
?>