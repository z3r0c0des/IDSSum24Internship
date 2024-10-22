<?php
session_start();

// Check if the user is logged in; otherwise, redirect to login
if (!isset($_SESSION['member_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <button id="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
        <button id="events-btn" onclick="window.location.href='events.html'">Back to Events</button>
    </header>
    <main>
        <h1>Admin Dashboard</h1>
        <div class="dashboard-buttons">
            <button onclick="window.location.href='manage_admins.php'">Manage Admins</button>
            <button onclick="window.location.href='manage_guides.php'">Manage Guides</button>
            <button onclick="window.location.href='manage_events.php'">Manage Events</button>
            <button onclick="window.location.href='manage_members.php'">Manage Members</button>
            <button onclick="window.location.href='manage_lookups.php'">Manage Lookups</button>
        </div>
    </main>
    <script src="dashboard.js"></script>
</body>
</html>
