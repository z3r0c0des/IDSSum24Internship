<?php
include 'db.php';
session_start();

// Fetching all events
$query = "SELECT * FROM events";
$result = mysqli_query($conn, $query);

// Adding a new event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']); // Assuming category_id is used
    $destination = mysqli_real_escape_string($conn, $_POST['destination']);
    $date_from = mysqli_real_escape_string($conn, $_POST['date_from']);
    $date_to = mysqli_real_escape_string($conn, $_POST['date_to']);
    $cost = mysqli_real_escape_string($conn, $_POST['cost']);
    $status = mysqli_real_escape_string($conn, $_POST['status']); // Handle status

    $query = "INSERT INTO events (name, description, category_id, destination, date_from, date_to, cost, status) 
              VALUES ('$name', '$description', '$category_id', '$destination', '$date_from', '$date_to', '$cost', '$status')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_events.php"); // Redirect to avoid duplicate entry on refresh
        exit;
    } else {
        echo "<script>alert('Failed to add event: " . mysqli_error($conn) . "');</script>";
    }
}

// Deleting an event
if (isset($_GET['delete'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['delete']);
    $query = "DELETE FROM events WHERE event_id='$event_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_events.php");
        exit;
    } else {
        echo "<script>alert('Failed to delete event: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        
    <h2>Manage Events</h2>
    
    <button onclick="window.location.href='dashboard.php'">Back To Dashboard</button>
    </header>
    <div class="event-container">
        <form id="addEventForm" action="manage_events.php" method="POST">
            <input type="text" id="name" name="name" placeholder="Event Name" required>
            <textarea id="description" name="description" placeholder="Description" required></textarea>
            <input type="number" id="category_id" name="category_id" placeholder="Category ID" required>
            <input type="text" id="destination" name="destination" placeholder="Destination" required>
            <input type="date" id="date_from" name="date_from" required>
            <input type="date" id="date_to" name="date_to" required>
            <input type="number" id="cost" name="cost" placeholder="Cost" step="0.01" required>
            <select id="status" name="status" required>
                <option value="Planned">Planned</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Completed">Completed</option>
            </select>
            <button type="submit" name="add_event">Add Event</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['category_id'] ?? ''); ?></td> <!-- Display category_id or name if available -->
                        <td><?php echo htmlspecialchars($row['date_from'] ?? '') . ' to ' . htmlspecialchars($row['date_to'] ?? ''); ?></td>
                        <td>
                            <button onclick="deleteEvent(<?php echo $row['event_id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
    function deleteEvent(id) {
        if (confirm('Are you sure you want to delete this event?')) {
            window.location.href = 'manage_events.php?delete=' + id;
        }
    }

    
    </script>
</body>
</html>
