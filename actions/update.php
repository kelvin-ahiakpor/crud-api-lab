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

// Get ID and optional fields from POST request
$id = intval($_POST['id']);
$book = isset($_POST['book']) ? $_POST['book'] : null;
$chapter = isset($_POST['chapter']) ? intval($_POST['chapter']) : null;
$verse = isset($_POST['verse']) ? intval($_POST['verse']) : null;
$text = isset($_POST['text']) ? $_POST['text'] : null;
$category = isset($_POST['category']) ? $_POST['category'] : null;

// Build dynamic update query (only update fields that are provided)
$updates = [];  // Array to store update clauses
$types = "";    // String to store parameter types for bind_param
$params = [];   // Array to store parameter values

// Add book to update if provided
if ($book !== null) {
    $updates[] = "book = ?";
    $types .= "s"; // s = string
    $params[] = $book;
}

// Add chapter to update if provided
if ($chapter !== null) {
    $updates[] = "chapter = ?";
    $types .= "i"; // i = integer
    $params[] = $chapter;
}

// Add verse to update if provided
if ($verse !== null) {
    $updates[] = "verse = ?";
    $types .= "i";
    $params[] = $verse;
}

// Add text to update if provided
if ($text !== null) {
    $updates[] = "text = ?";
    $types .= "s";
    $params[] = $text;
}

// Add category to update if provided
if ($category !== null) {
    $updates[] = "category = ?";
    $types .= "s";
    $params[] = $category;
}

// Check if at least one field was provided for update
if (empty($updates)) {
    echo json_encode(["success" => false, "error" => "No fields to update"]);
    exit;
}

// Build final SQL query
$sql = "UPDATE bible_verses SET " . implode(", ", $updates) . " WHERE id = ?";
$types .= "i"; // Add type for ID parameter
$params[] = $id; // Add ID to parameters

// Prepare and execute query
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params); // ... spreads the array into individual arguments

// Check if update was successful and at least one row was affected
if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Update failed or no changes made"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>