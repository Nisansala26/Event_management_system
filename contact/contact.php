<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "unievents_db";

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// ✅ Create table automatically if not exists
$createTableSQL = "
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($createTableSQL)) {
    die("Error creating table: " . $conn->error);
}

// ✅ Get form data safely
$firstName = trim($_POST['firstName'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// ✅ Validate required fields
if (empty($firstName) || empty($email) || empty($message)) {
    die("⚠️ Please fill in all required fields!");
}

// ✅ Insert into DB
$stmt = $conn->prepare("INSERT INTO contact_messages (first_name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $firstName, $email, $message);

if ($stmt->execute()) {
    echo "<script>
        alert('✅ Message sent successfully!');
        window.location.href = '../home/home.html';
    </script>";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
