<?php
include 'db.php';
session_start();

// Fetching all lookups
$query = "SELECT * FROM lookups";
$result = mysqli_query($conn, $query);

// Adding a new lookup
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_lookup'])) {
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $display_order = mysqli_real_escape_string($conn, $_POST['display_order']);

    $query = "INSERT INTO lookups (code, name, display_order) VALUES ('$code', '$name', '$display_order')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_lookups.php");
        exit;
    } else {
        echo "<script>alert('Failed to add lookup: " . mysqli_error($conn) . "');</script>";
    }
}

// Deleting a lookup
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $query = "DELETE FROM lookups WHERE lookup_id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_lookups.php");
        exit;
    } else {
        echo "<script>alert('Failed to delete lookup: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Lookups</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
    <h2>Manage Lookups</h2>
    
    <button  onclick="window.location.href='dashboard.php'">Back To Dashboard</button>
    </header>

    <div class="lookup-container">

        <form id="addLookupForm" action="manage_lookups.php" method="POST">
            <input type="text" id="code" name="code" placeholder="Code" required>
            <input type="text" id="name" name="name" placeholder="Name" required>
            <input type="number" id="display_order" name="display_order" placeholder="Display Order" required>
            <button type="submit" name="add_lookup">Add Lookup</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Display Order</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['code']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['display_order']); ?></td>
                        <td>
                            <button onclick="deleteLookup(<?php echo $row['lookup_id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script>
    function deleteLookup(id) {
        if (confirm('Are you sure you want to delete this lookup?')) {
            window.location.href = 'manage_lookups.php?delete=' + id;
        }
    }

    
    </script>
</body>
</html>
