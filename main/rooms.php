<?php
include "db_connect.php"; // Include DB connection

header("Content-Type: application/json"); // Set JSON output format

// Get parameters
$hotel_id = isset($_GET['hotel_id']) ? intval($_GET['hotel_id']) : 0;
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : null;
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : null;

// Check if required parameters are provided
if (!$hotel_id || !$checkin || !$checkout) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

// Query to get available rooms
$sql = "SELECT r.*
FROM rooms r
LEFT JOIN bookings b ON r.id = b.room_id
WHERE (b.id IS NULL OR NOT (b.check_in_date <= ? AND b.check_out_date >= ?))
AND r.hotel_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $checkin, $checkout, $hotel_id);
$stmt->execute();
$result = $stmt->get_result();

$response = ["success" => true, "data" => []];

while ($row = $result->fetch_assoc()) {
    $response["data"][] = $row;
}

echo json_encode($response);
?>