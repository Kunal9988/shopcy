<?php
include '../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@.*\.com$/", $email)) {
        $error = "Enter a valid email with '@' and '.com'";
    } elseif (!preg_match("/^[0-9]{10,12}$/", $phone)) {
        $error = "Phone number must be exactly 10 digits.";
    } else {
        $check = $conn->query("SELECT * FROM admins WHERE email = '$email'");
        if ($check->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            $sql = "INSERT INTO admins (name, email, password, phone) 
                    VALUES ('$name', '$email', '$password', '$phone')";
            if ($conn->query($sql)) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Error while registering.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin Signup</title></head>
<body>
    <h2>Admin Signup</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="text" name="email" placeholder="Email ID" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="text" name="phone" placeholder="Phone Number" required><br><br>
        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="admin_login.php">Login here</a></p>
</body>
</html>
