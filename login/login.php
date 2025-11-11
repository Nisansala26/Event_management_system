<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read JSON from JS fetch
$data = json_decode(file_get_contents("php://input"), true);
$email = trim($data['email'] ?? '');
$password_input = trim($data['password'] ?? '');

if(empty($email) || empty($password_input)){
    echo json_encode(["status"=>"error","message"=>"All fields are required"]);
    exit;
}

// DB connection
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "unievents_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);
if($conn->connect_error){
    echo json_encode(["status"=>"error","message"=>"Database connection failed"]);
    exit;
}

// Check user exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 1){
    $user = $result->fetch_assoc();

    // Verify password (plain text for now)
    if($password_input === $user['password']){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if($user['role'] === 'admin'){
            echo json_encode([
                "status" => "success",
                "message" => "Admin login successful",
                "redirect" => "admin.html"
            ]);
        } else {
            echo json_encode([
                "status" => "success",
                "message" => "User login successful",
                "redirect" => "../home/home.html"
            ]);
        }
    } else {
        echo json_encode(["status"=>"error","message"=>"Incorrect password"]);
    }
} else {
    echo json_encode(["status"=>"error","message"=>"Email not found"]);
}

$stmt->close();
$conn->close();
?>
