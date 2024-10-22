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

// Get the current user's data
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT fname, lname, email, address, education, graduationdate, experience, skills FROM user_info WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($fname, $lname, $email, $address, $education, $graduationdate, $experience, $skills);
$stmt->fetch();
$stmt->close();

// Split skills into an array
$skillsArray = explode(', ', $skills);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form action="updateprofile.php" method="post">
        <label for="fname">First Name:</label>
        <input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($fname); ?>" required><br>

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" value="<?php echo htmlspecialchars($lname); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required disabled><br>

        <label for="address">Address:</label>
        <textarea name="address" id="address" required><?php echo htmlspecialchars($address); ?></textarea><br>

        <label for="education">Education:</label>
        <input type="text" name="education" id="education" value="<?php echo htmlspecialchars($education); ?>" required><br>

        <label for="graduationdate">Graduation Date:</label>
        <input type="date" name="graduationdate" id="graduationdate" value="<?php echo htmlspecialchars($graduationdate); ?>" required><br>

        <label for="experience">Experience (in years):</label>
        <input type="number" name="experience" id="experience" value="<?php echo htmlspecialchars($experience); ?>" required><br>

        <label for="skills">Skills:</label><br>
        <?php
        $skillsList = ['PHP', 'JavaScript', 'HTML', 'CSS', 'SQL'];
        foreach ($skillsList as $skill) {
            $checked = in_array($skill, $skillsArray) ? 'checked' : '';
            echo "<input type='checkbox' name='skills[]' value='$skill' id='$skill' $checked>";
            echo "<label for='$skill'>$skill</label><br>";
        }
        ?>
        <input type="submit" value="Update Profile">
    </form>
</body>
</html>
