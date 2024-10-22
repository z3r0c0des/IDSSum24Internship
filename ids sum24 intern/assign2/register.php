<?php
session_start();
include 'db.php';
include 'registerp.html';
$errors = [];

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Function to check if an email is valid
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to check if a date is in the future
function isFutureDate($date) {
    $today = date('Y-m-d');
    return ($date > $today);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form inputs
    $fname = sanitizeInput($_POST['fname'] ?? '');
    $lname = sanitizeInput($_POST['lname'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $address = sanitizeInput($_POST['address'] ?? '');
    $education = sanitizeInput($_POST['education'] ?? '');
    $graduationdate = $_POST['graduationdate'] ?? '';
    $experience = $_POST['experience'] ?? 0;
    $skills = $_POST['skills'] ?? [];

    // Validation
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($address) || empty($education) || empty($graduationdate) || empty($experience) || empty($skills)) {
        $errors[] = "Please fill out all fields.";
    }

    if (!isValidEmail($email)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (!isFutureDate($graduationdate)) {
        $errors[] = "Graduation date must be in the future.";
    }

    if ($experience < 0) {
        $errors[] = "Experience in years cannot be negative.";
    }

    // If no errors, save to database
    if (empty($errors)) {
        $skillsList = implode(', ', $skills);

        $stmt = $conn->prepare("INSERT INTO user_info (fname, lname, email, password, address, education, graduationdate, experience, skills) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssis", $fname, $lname, $email, $password, $address, $education, $graduationdate, $experience, $skillsList);

        if ($stmt->execute()) {
            // Start session and set email
            $_SESSION['email'] = $email;

            // Redirect to profilep.php
            header("Location: profilep.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
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
