<?php
require 'db.php';

// Fetch events based on status if provided
$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($status) {
    $sql = "SELECT e.event_id, e.name, e.description, e.destination, e.date_from, e.date_to, l.name as category, e.cost, e.status
            FROM Events e
            LEFT JOIN Lookups l ON e.category_id = l.lookup_id
            WHERE e.status = ?
            ORDER BY e.date_from DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT e.event_id, e.name, e.description, e.destination, e.date_from, e.date_to, l.name as category, e.cost, e.status
            FROM Events e
            LEFT JOIN Lookups l ON e.category_id = l.lookup_id
            ORDER BY e.date_from DESC";
    $result = $conn->query($sql);
}

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode(['records' => $events]);
?>
