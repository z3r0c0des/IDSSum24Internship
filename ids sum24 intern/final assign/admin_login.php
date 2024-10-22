<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $_SESSION['admin'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid Email or Password!";
        header("Location: admin_login.html");
        exit();
    }
}
?>
