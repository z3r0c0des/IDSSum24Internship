<?php
include 'db.php';
session_start();

// Fetching all guides
$query = "SELECT * FROM guides";
$result = mysqli_query($conn, $query);

// Adding a new guide
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_guide'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // No hashing
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $joining_date = mysqli_real_escape_string($conn, $_POST['joining_date']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    $photo = mysqli_real_escape_string($conn, $_POST['photo']);

    // Insert query
    $query = "INSERT INTO guides (full_name, email, password,dob, joining_date, profession, photo) 
              VALUES ('$full_name', '$email', '$password', '$dob', '$joining_date', '$profession', '$photo')";

    // Debugging line: Print the query to check
    echo "<pre>$query</pre>";

    // Execute query and check for success
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Guide added successfully');</script>";
        header("Location: manage_guides.php"); // Redirect to avoid duplicate entry on refresh
        exit;
    } else {
        echo "<script>alert('Failed to add guide: " . mysqli_error($conn) . "');</script>";
    }
}


?>