<?php
session_start();
include 'db.php';

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginp.html"); // Redirect if not logged in
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $fname = sanitizeInput($_POST['fname'] ?? '');
    $lname = sanitizeInput($_POST['lname'] ?? '');
    $address = sanitizeInput($_POST['address'] ?? '');
    $education = sanitizeInput($_POST['education'] ?? '');
    $graduationdate = $_POST['graduationdate'] ?? '';
    $experience = $_POST['experience'] ?? 0;
    $skills = isset($_POST['skills']) ? implode(', ', $_POST['skills']) : '';

    $errors = [];

    if (empty($fname) || empty($lname) || empty($address) || empty($education) || empty($graduationdate) || empty($experience) || empty($skills)) {
        $errors[] = "Please fill out all fields.";
    }

    if (strtotime($graduationdate) <= time()) {
        $errors[] = "Graduation date must be in the future.";
    }

    if ($experience < 0) {
        $errors[] = "Experience in years cannot be negative.";
    }

    // If no errors, update profile
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE user_info SET fname = ?, lname = ?, address = ?, education = ?, graduationdate = ?, experience = ?, skills = ? WHERE email = ?");
        $stmt->bind_param("ssssisss", $fname, $lname, $address, $education, $graduationdate, $experience, $skills, $email);

        if ($stmt->execute()) {
            // Optionally, redirect to profile page
            header("Location: profilep.php");
            exit;
        } else {
            echo "Error updating profile: " . $stmt->error;
        }

        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}

$conn->close();
?>
