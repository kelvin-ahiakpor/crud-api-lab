<?php
// Set response type to JSON
header('Content-Type: application/json');

// Include database connection
require_once '../db/config.php';

// Check if ID is provided
if (!isset($_POST['id'])) {
    echo json_encode(["success" => false, "error" => "ID required"]);
    exit;
}

// Get ID from POST request and convert to integer
$id = intval($_POST['id']);

// Prepare SQL query to delete verse by ID
$sql = "DELETE FROM bible_verses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // i = integer

// Execute query and check if successful
if ($stmt->execute() && $stmt->affected_rows > 0) {
    // Success - record was deleted
    echo json_encode(["success" => true]);
} else {
    // Error - delete failed or record not found
    echo json_encode(["success" => false, "error" => "Delete failed or record not found"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>