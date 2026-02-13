<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Step 1: Testing database connection...<br><br>";

require_once 'db/config.php';

echo "Step 2: Config file loaded successfully<br><br>";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Step 3: Database connected successfully!<br><br>";

// Test query
$result = $conn->query("SELECT DATABASE()");
$row = $result->fetch_row();
echo "Step 4: Connected to database: " . $row[0] . "<br><br>";

// Check if table exists
$result = $conn->query("SHOW TABLES LIKE 'bible_verses'");
if ($result->num_rows > 0) {
    echo "Step 5: Table 'bible_verses' exists!<br><br>";
    
    // Count records
    $result = $conn->query("SELECT COUNT(*) as count FROM bible_verses");
    $row = $result->fetch_assoc();
    echo "Step 6: Found " . $row['count'] . " verses in the table<br>";
} else {
    echo "Step 5: ERROR - Table 'bible_verses' does not exist!<br>";
}

$conn->close();
?>
```

**Save it (Ctrl+X, Y, Enter), then visit in browser:**
```
http://169.239.251.102:280/~kelvin.ahiakpor/lab%202/test_db.php
