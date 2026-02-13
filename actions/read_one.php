<?php
// Set response type to JSON
header('Content-Type: application/json');

// Include database connection
require_once '../db/config.php';

// Check if ID parameter is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["success" => false, "error" => "ID parameter required"]);
    exit;
}

// Get ID from URL parameter and convert to integer
$id = intval($_GET['id']);

// Prepare SQL query to get one verse by ID (using prepared statement for security)
$sql = "SELECT * FROM bible_verses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // "i" means integer
$stmt->execute();
$result = $stmt->get_result();

// Check if verse was found
if ($result->num_rows > 0) {
    // Get the verse data
    $verse = $result->fetch_assoc();
    echo json_encode(["success" => true, "data" => $verse]);
} else {
    // Return error if verse not found
    echo json_encode(["success" => false, "error" => "not found"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>