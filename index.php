<?php
session_start();
require 'autoload.php';

use App\Services\Database;

$db = Database::getInstance();
$message = '';

// Handle Login Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData && password_verify($pass, $userData['password'])) {
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['user_role'] = $userData['role'];
        $message = "Login successful!";
    } else {
        $message = "Invalid email or password.";
    }
}

// Handle Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management System</title>
</head>
<body>
    <h2>User Management System</h2>
    
    <?php if (isset($_SESSION['user_name'])): ?>
        <p>Welcome, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong> (Role: <?= htmlspecialchars($_SESSION['user_role']) ?>)</p>
        <a href="index.php?action=logout">Logout</a>
    <?php else: ?>
        <?php if ($message): ?>
            <p><strong><?= htmlspecialchars($message) ?></strong></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit" name="login">Login</button>
        </form>
    <?php endif; ?>
</body>
</html>