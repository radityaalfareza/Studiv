<?php
session_start();
require_once '../config/koneksi.php'; // atau sesuaikan path

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$username = sanitize($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

// Validasi input
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    $errors[] = "Username tidak valid.";
}

if (strlen($password) < 6) {
    $errors[] = "Password minimal 6 karakter.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    exit;
}

// Ambil data user dari database
$query = "SELECT id, username, password FROM account WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $user['password'])) {
        // Berhasil login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "<p style='color:green;'>Login berhasil. Selamat datang, {$user['username']}!</p>";
        // redirect pakai: header("Location: dashboard.php");
    } else {
        echo "<p style='color:red;'>Password salah.</p>";
    }
} else {
    echo "<p style='color:red;'>Username tidak ditemukan.</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($link);
?>
