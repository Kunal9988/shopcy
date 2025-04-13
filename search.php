<?php
header('Content-Type: application/json');
include 'includes/connection.php';

// Get the search term from the request
$term = isset($_GET['term']) ? $_GET['term'] : '';

if (empty($term)) {
    echo json_encode([]);
    exit();
}

// Prepare a statement to search for product names matching the term (using LIKE)
$stmt = $conn->prepare("SELECT name FROM products WHERE name LIKE ? LIMIT 10");
$searchTerm = '%' . $term . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
    // Each suggestion is simply the product name. You could also return label/value objects.
    $suggestions[] = $row['name'];
}

// Return the suggestions as JSON
echo json_encode($suggestions);
?>
