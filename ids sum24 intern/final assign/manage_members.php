<?php
include 'db.php';
session_start();

// Fetching all members
$query = "SELECT * FROM members";
$result = mysqli_query($conn, $query);

// Adding a new member
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_member'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Assuming password is stored as plain text
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $joining_date = mysqli_real_escape_string($conn, $_POST['joining_date']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $emergency_number = mysqli_real_escape_string($conn, $_POST['emergency_number']);
    $photo = mysqli_real_escape_string($conn, $_POST['photo']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);

    $query = "INSERT INTO members (full_name, email, password, dob, gender, joining_date, mobile_number, emergency_number, photo, profession, nationality) 
              VALUES ('$full_name', '$email', '$password', '$dob', '$gender', '$joining_date', '$mobile_number', '$emergency_number', '$photo', '$profession', '$nationality')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_members.php"); // Redirect to avoid duplicate entry on refresh
        exit;
    } else {
        echo "<script>alert('Failed to add member: " . mysqli_error($conn) . "');</script>";
    }
}

// Deleting a member
if (isset($_GET['delete'])) {
    $member_id = mysqli_real_escape_string($conn, $_GET['delete']);
    $query = "DELETE FROM members WHERE member_id='$member_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_members.php");
        exit;
    } else {
        echo "<script>alert('Failed to delete member: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h2>Manage Members</h2>
        
        <button  onclick="window.location.href='dashboard.php'">Back To Dashboard</button>
    </header>
    <div class="member-container">
        <form id="addMemberForm" action="manage_members.php" method="POST">
            <input type="text" id="full_name" name="full_name" placeholder="Full Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="date" id="dob" name="dob" placeholder="Date of Birth">
            <select id="gender" name="gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <input type="date" id="joining_date" name="joining_date" placeholder="Joining Date">
            <input type="text" id="mobile_number" name="mobile_number" placeholder="Mobile Number">
            <input type="text" id="emergency_number" name="emergency_number" placeholder="Emergency Number">
            <input type="text" id="photo" name="photo" placeholder="Photo URL">
            <input type="text" id="profession" name="profession" placeholder="Profession">
            <input type="text" id="nationality" name="nationality" placeholder="Nationality">
            <button type="submit" name="add_member">Add Member</button>
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
                        <td><?php echo htmlspecialchars($row['full_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['role'] ?? ''); ?></td>
                        <td>
                            <button onclick="deleteMember(<?php echo $row['member_id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
    function deleteMember(member_id) {
        if (confirm('Are you sure you want to delete this member?')) {
            window.location.href = 'manage_members.php?delete=' + member_id;
        }
    }

    
    </script>
</body>
</html>
