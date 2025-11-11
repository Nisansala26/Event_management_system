<?php
header('Content-Type: application/json; charset=utf-8');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unievents_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Get filters
$q = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$from = trim($_GET['from'] ?? '');
$to = trim($_GET['to'] ?? '');

// Build query
$where = [];
if ($q !== '') {
    $where[] = "(title LIKE '%$q%' OR description LIKE '%$q%' OR location LIKE '%$q%')";
}
if ($category !== '') {
    $where[] = "category = '$category'";
}
if ($from !== '') {
    $where[] = "event_date >= '$from'";
}
if ($to !== '') {
    $where[] = "event_date <= '$to'";
}

$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT * FROM events $whereSQL ORDER BY event_date ASC";
$result = $conn->query($sql);

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events, JSON_UNESCAPED_UNICODE);
$conn->close();
?>
