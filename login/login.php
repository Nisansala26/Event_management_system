<?php
session_start();
header('Content-Type: application/json');

// Read raw JSON input
$data = json_decode(file_get_contents("php://input"), true);
$email = trim($data['email'] ?? '');
$password_input = trim($data['password'] ?? '');

if(empty($email) || empty($password_input)){
    echo json_encode(["status"=>"error","message"=>"All fields are required"]);
    exit;
}

// DB connection...
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "unievents_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);
if($conn->connect_error){
    echo json_encode(["status"=>"error","message"=>"Database connection failed"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 1){
    $user = $result->fetch_assoc();
    if($password_input === $user['password']){
        echo json_encode(["status"=>"success","message"=>"Login successful"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Incorrect password"]);
    }
} else {
    echo json_encode(["status"=>"error","message"=>"Email not found"]);
}

$stmt->close();
$conn->close();
?>
