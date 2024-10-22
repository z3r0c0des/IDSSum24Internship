<?php
include 'db.php';
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Adding a new guide
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_guide'])) {
    // Debugging: Output received POST data
    echo "<pre>Received POST Data:";
    print_r($_POST);
    echo "</pre>";

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $joining_date = mysqli_real_escape_string($conn, $_POST['joining_date']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    $photo = mysqli_real_escape_string($conn, $_POST['photo']);
    
    // Check for duplicate email
    $checkQuery = "SELECT * FROM guides WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (!$checkResult) {
        echo "<script>alert('Database error during duplicate check: " . mysqli_error($conn) . "');</script>";
    } elseif (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Guide with this email already exists');</script>";
    } else {
        // Insert query
        $query = "INSERT INTO guides (full_name, email, password, dob, joining_date, profession, photo) 
                  VALUES ('$full_name', '$email', '$password', '$dob', '$joining_date', '$profession', '$photo')";

        // Debugging: Print the query
        echo "<pre>SQL Query: $query</pre>";

        // Execute query and check for success
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Guide added successfully');</script>";
            header("Location: manage_guides.php"); // Redirect to avoid duplicate entry on refresh
            exit;
        } else {
            echo "<script>alert('Failed to add guide: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Deleting a guide
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $query = "DELETE FROM guides WHERE guide_id='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Guide deleted successfully');</script>";
        header("Location: manage_guides.php");
        exit;
    } else {
        echo "<script>alert('Failed to delete guide: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetching all guides
$query = "SELECT * FROM guides";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Guides</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h2>Manage Guides</h2>
        <button onclick="window.location.href='dashboard.php'">Back To Dashboard</button>
    </header>
    <div class="guide-container">
        <form id="addGuideForm" method="POST">
            <input type="text" id="full_name" name="full_name" placeholder="Full Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="date" id="dob" name="dob" placeholder="Date of Birth">
            <input type="date" id="joining_date" name="joining_date" placeholder="Joining Date">
            <input type="text" id="profession" name="profession" placeholder="Profession">
            <input type="text" id="photo" name="photo" placeholder="Photo URL">
            <button type="submit" name="add_guide">Add Guide</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <button onclick="deleteGuide(<?php echo $row['guide_id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
    function deleteGuide(id) {
        if (confirm('Are you sure you want to delete this guide?')) {
            window.location.href = '?delete=' + id;
        }
    }

        </script>
</body>
</html>
