<?php
session_start();
include 'db.php';

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Get the current user's data
$user_email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT fname, lname, email, address, education, graduationdate, experience, skills FROM user_info WHERE email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($fname, $lname, $email, $address, $education, $graduationdate, $experience, $skills);
$stmt->fetch();

// Check if the user data was retrieved successfully
if (!empty($fname)) {
    $user = [
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'address' => $address,
        'education' => $education,
        'graduationdate' => $graduationdate,
        'experience' => $experience,
        'skills' => explode(', ', $skills)
    ];
} else {
    // Handle case where user data is not found
    echo "User data not found.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styling.css"> <!-- Ensure the path is correct -->
</head>
<body>
    <div class="container">
        <h1>Profile</h1>
        <div class="profile-info">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['fname']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><strong>Education:</strong> <?php echo htmlspecialchars($user['education']); ?></p>
            <p><strong>Graduation Date:</strong> <?php echo htmlspecialchars($user['graduationdate']); ?></p>
            <p><strong>Experience:</strong> <?php echo htmlspecialchars($user['experience']); ?> years</p>
            <p><strong>Skills:</strong> <?php echo htmlspecialchars(implode(', ', $user['skills'])); ?></p>
        </div>
        <a href="editprofilep.html" class="button">Edit Profile</a>
    </div>
</body>
</html>
