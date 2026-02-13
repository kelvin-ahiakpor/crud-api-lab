<?php
// Set response type to JSON
header('Content-Type: application/json');

// Include database connection
require_once '../db/config.php';

// Check if all required fields are provided
if (!isset($_POST['book']) || !isset($_POST['chapter']) || !isset($_POST['verse']) || !isset($_POST['text'])) {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
    exit;
}

// Get data from POST request
$book = $_POST['book'];
$chapter = intval($_POST['chapter']);
$verse = intval($_POST['verse']);
$text = $_POST['text'];
$category = isset($_POST['category']) ? $_POST['category'] : null; // Category is optional

// Prepare SQL query to insert new verse
$sql = "INSERT INTO bible_verses (book, chapter, verse, text, category) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiis", $book, $chapter, $verse, $text, $category); // s=string, i=integer

// Execute query and check if successful
if ($stmt->execute()) {
    // Get the ID of the newly created record
    $newId = $stmt->insert_id;
    echo json_encode(["success" => true, "data" => ["id" => $newId]]);
} else {
    // Return error if insert failed
    echo json_encode(["success" => false, "error" => "Failed to create verse"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>