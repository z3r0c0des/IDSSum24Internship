<?php
session_start();
include 'db.php';

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT email, password FROM user_info WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($fetched_email, $hashed_password);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $fetched_email;
                header("Location: profilep.php"); // Updated to redirect to profilep.php
                exit;
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No account found with that email.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
