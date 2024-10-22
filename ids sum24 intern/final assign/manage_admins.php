<?php
include 'db.php';
session_start();

// Adding a new admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_admin'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // No hashing
    $role = mysqli_real_escape_string($conn, $_POST['role']); // Role should be either 'Admin' or 'SuperAdmin'

    // Check for duplicate email
    $checkQuery = "SELECT * FROM admins WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Admin with this email already exists');</script>";
    } else {
        // Insert query
        $query = "INSERT INTO admins (`name`, `dob`, `gender`, `email`, `password`, `role`) 
                  VALUES ('$name', '$dob', '$gender', '$email', '$password', '$role')";

        // Execute query and check for success
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Admin added successfully');</script>";
        } else {
            echo "<script>alert('Failed to add admin: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Deleting an admin
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM admins WHERE admin_id='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Admin deleted successfully');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to delete admin: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetching all admins
$query = "SELECT * FROM admins";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
    <h2>Manage Admins</h2>
    
    <button  onclick="window.location.href='dashboard.php'">Back To Dashboard</button>
    </header>
    <div class="admin-container">
        
        <form id="addAdminForm" method="POST">
            <input type="text" id="name" name="name" placeholder="Name" required>
            <input type="date" id="dob" name="dob" required>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <select id="role" name="role" required>
                <option value="Admin">Admin</option>
                <option value="SuperAdmin">SuperAdmin</option>
            </select>
            <button type="submit" name="add_admin">Add Admin</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td>
                            <button onclick="deleteAdmin(<?php echo $row['admin_id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
    function deleteAdmin(id) {
        if (confirm('Are you sure you want to delete this admin?')) {
            window.location.href = '?delete=' + id;
        }
    }
    </script>
</body>
</html>
