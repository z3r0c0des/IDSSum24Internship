<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM Members WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Direct comparison (not recommended but used as per your request)
        if ($password === $user['password']) {
            $_SESSION['member_id'] = $user['member_id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: events.html");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
    }

    // Redirect back to the login page with an error message
    header("Location: index.php");
    exit();
}
?>
