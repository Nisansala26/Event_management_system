<?php
session_start();

// Step 1: Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.html");
    exit();
}

// Step 2: Allow only admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../home/home.html");
    exit();
}

// Step 3: Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unievents_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Step 4: Get total registered users
$userCountQuery = "SELECT COUNT(*) AS total_users FROM users";
$userCountResult = $conn->query($userCountQuery);
$userCount = $userCountResult->fetch_assoc()['total_users'];

// Step 5: Get total events
$eventCountQuery = "SELECT COUNT(*) AS total_events FROM events";
$eventCountResult = $conn->query($eventCountQuery);
$eventCount = $eventCountResult->fetch_assoc()['total_events'];

// Step 6: Get pending approvals
$pendingQuery = "SELECT COUNT(*) AS pending_users FROM users WHERE status='pending'";
$pendingResult = $conn->query($pendingQuery);
$pendingUsers = $pendingResult->fetch_assoc()['pending_users'];

// Step 7: Get upcoming events
$upcomingQuery = "SELECT COUNT(*) AS upcoming_events FROM events WHERE date >= CURDATE()";
$upcomingResult = $conn->query($upcomingQuery);
$upcomingEvents = $upcomingResult->fetch_assoc()['upcoming_events'];

// Close DB connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | UniEvents</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <img src="../login/logowhite.png" alt="Logo">
        </div>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Manage Users</a></li>
            <li><a href="#">Manage Events</a></li>
            <li><a href="logout.php" class="login-btn">Logout</a></li>
        </ul>
    </header>

    <!-- Dashboard Section -->
    <section class="dashboard-section">
        <div class="dashboard-container">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?> 👋</h1>
            <p>Here’s your current event summary.</p>

            <div class="cards">
                <div class="card">
                    <h2><?php echo $eventCount; ?></h2>
                    <p>Total Events</p>
                </div>
                <div class="card">
                    <h2><?php echo $userCount; ?></h2>
                    <p>Registered Users</p>
                </div>
                <div class="card">
                    <h2><?php echo $pendingUsers; ?></h2>
                    <p>Pending Approvals</p>
                </div>
                <div class="card">
                    <h2><?php echo $upcomingEvents; ?></h2>
                    <p>Upcoming Events</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
