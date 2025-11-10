<?php
// Database connection details
$servername = "localhost";
$username = "root"; // default for XAMPP
$password = "";     // default is empty for XAMPP
$dbname = "unievents_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Auto-create `users` table if it doesn't exist
$createTableSQL = "
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($createTableSQL)) {
    die("Error creating table: " . $conn->error);
}

// ✅ Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? ''); // plain text (not recommended in production)

    // Validate fields
    if (empty($fullname) || empty($email) || empty($password)) {
        echo "All fields are required!";
        exit;
    }

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Email already registered!";
        exit;
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $password);

    if ($stmt->execute()) {
        // Registration successful → redirect to login page
        header("Location: ../login/login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>