<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = $_POST['passphrase'] ?? '';
    if ($pass === 'admin') {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid passphrase';
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
<h2>Admin Login</h2>
<form method="POST">
<input type="password" name="passphrase" placeholder="Passphrase" required>
<button type="submit">Login</button>
</form>
<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>