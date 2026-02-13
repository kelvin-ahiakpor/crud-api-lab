<?php
// Set response type to JSON
header('Content-Type: application/json');

// Include database connection
require_once '../db/config.php';

// SQL query to get all verses, ordered by ID
$sql = "SELECT * FROM bible_verses ORDER BY id ASC";
$result = $conn->query($sql);

// Check if query was successful
if ($result) {
    // Initialize empty array to store verses
    $verses = [];
    
    // Loop through results and add each row to array
    while ($row = $result->fetch_assoc()) {
        $verses[] = $row;
    }
    
    // Return success response with data
    echo json_encode(["success" => true, "data" => $verses]);
} else {
    // Return error response if query failed
    echo json_encode(["success" => false, "error" => "Failed to retrieve verses"]);
}

// Close database connection
$conn->close();
?>