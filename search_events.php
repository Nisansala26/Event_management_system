<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unievents_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$q = $_GET['q'] ?? '';

if ($q !== '') {
    $search = "%" . $conn->real_escape_string($q) . "%";

    $sql = "SELECT * FROM events WHERE title LIKE ? OR location LIKE ? LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='event-item'>
                    <h3>" . htmlspecialchars($row['title']) . "</h3>
                    <p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>
                    <p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>
                    <p>" . htmlspecialchars($row['description']) . "</p>
                  </div><hr>";
        }
    } else {
        echo "<p>No events found.</p>";
    }
}

$conn->close();
?>
