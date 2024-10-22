<?php
session_start();
include 'db.php';

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

$email = $_SESSION['email'] ?? '';

if ($email) {
    $stmt = $conn->prepare("SELECT fname, lname, email, address, education, graduationdate, experience, skills FROM user_info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($fname, $lname, $email, $address, $education, $graduationdate, $experience, $skills);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        $skillsArray = explode(', ', $skills);
        $data = [
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'address' => $address,
            'education' => $education,
            'graduationdate' => $graduationdate,
            'experience' => $experience,
            'skills' => $skillsArray
        ];
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No user found']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'User not logged in']);
}

$conn->close();
?>
