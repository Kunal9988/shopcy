<?php
include 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@.*\.com$/", $email)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match("/^[0-9]{10,12}$/", $phone)) {
        $errors[] = "Phone must be between 10 to 12 digits.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);
        if ($stmt->execute()) {
            header("Location: user_login.php?msg=registered");
            exit();
        } else {
            $errors[] = "Email already exists or error in registration.";
        }
    }
}
?>

<!-- HTML form -->
<!DOCTYPE html>
<html>
<head><title>Signup</title></head>
<body>
    <h2>User Signup</h2>
    <?php if (!empty($errors)) foreach ($errors as $error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="text" name="phone" placeholder="Phone (10-12 digits)" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
