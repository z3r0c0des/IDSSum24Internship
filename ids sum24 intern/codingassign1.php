<?php
$errors = [];
$success = '';

function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isFutureDate($date) {
    $today = date('Y-m-d');
    return ($date > $today);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = sanitizeInput($_POST['firstName'] ?? '');
    $lastName = sanitizeInput($_POST['lastName'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $address = sanitizeInput($_POST['address'] ?? '');
    $education = sanitizeInput($_POST['education'] ?? '');
    $graduationDate = $_POST['graduationDate'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $skills = $_POST['skills'] ?? [];

    // Validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword) || empty($address) || empty($education) || empty($graduationDate) || empty($experience) || empty($skills)) {
        $errors[] = "Please fill out all fields.";
    }

    if (!isValidEmail($email)) {
        $errors[] = "Please enter a valid email address.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (!isFutureDate($graduationDate)) {
        $errors[] = "Graduation date must be in the future.";
    }

    if ($experience < 0) {
        $errors[] = "Experience in years cannot be negative.";
    }

    if (empty($errors)) {
        $skillsList = implode(', ', $skills);
        $success = "Registration successful! Welcome $firstName $lastName. Your skills: $skillsList.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Consolas;
            background-color: gray;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: gray;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: lightgray;
            border: none;
            cursor: pointer;
            padding: 12px 20px;
        }
        input[type="submit"]:hover {
            background-color: wheat;
        }
        .checkbox-group {
            margin-bottom: 15px;
        }
        .checkbox-group label {
            display: inline;
            margin-right: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            color: red;
        }
        p {
            color: wheat;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        <?php if (!empty($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <p><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" id="firstName" value="<?php echo $firstName ?? ''; ?>" required>

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" id="lastName" value="<?php echo $lastName ?? ''; ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $email ?? ''; ?>" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" name="confirmPassword" id="confirmPassword" required>

            <label for="address">Address:</label>
            <textarea name="address" id="address" required><?php echo $address ?? ''; ?></textarea>

            <label for="education">Education:</label>
            <input type="text" name="education" id="education" value="<?php echo $education ?? ''; ?>" required>

            <label for="graduationDate">Graduation Date:</label>
            <input type="date" name="graduationDate" id="graduationDate" value="<?php echo $graduationDate ?? ''; ?>" required>

            <label for="experience">Experience in years:</label>
            <input type="number" name="experience" id="experience" value="<?php echo $experience ?? ''; ?>" required>

            <div class="checkbox-group">
                <label>Skills:</label><br>
                <input type="checkbox" name="skills[]" value="PHP" id="php" <?php if (in_array('PHP', $skills ?? [])) echo 'checked'; ?>>
                <label for="php">PHP</label>
                <input type="checkbox" name="skills[]" value="JavaScript" id="javascript" <?php if (in_array('JavaScript', $skills ?? [])) echo 'checked'; ?>>
                <label for="javascript">JavaScript</label>
                <input type="checkbox" name="skills[]" value="HTML" id="html" <?php if (in_array('HTML', $skills ?? [])) echo 'checked'; ?>>
                <label for="html">HTML</label>
                <input type="checkbox" name="skills[]" value="CSS" id="css" <?php if (in_array('CSS', $skills ?? [])) echo 'checked'; ?>>
                <label for="css">CSS</label>
                <input type="checkbox" name="skills[]" value="SQL" id="sql" <?php if (in_array('SQL', $skills ?? [])) echo 'checked'; ?>>
                <label for="sql">SQL</label>
            </div>

            <input type="submit" value="Register" style=" background-color: green">
        </form>
    </div>
</body>
</html>
