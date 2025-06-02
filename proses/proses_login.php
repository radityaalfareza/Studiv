<?php
session_start();
require_once '../config/koneksi.php'; // sesuaikan path

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$username = sanitize($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

// Validasi input
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    $errors[] = "username_tidak_valid";
}

if (strlen($password) < 6) {
    $errors[] = "password_minimal_6_karakter";
}

if (!empty($errors)) {
    // Gabungkan semua error jadi 1 string agar header tidak error multiple headers
    $error_str = implode(',', $errors);
    header("Location: ../halaman_login.php?error=$error_str");
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
        // Berhasil login, simpan session
        $_SESSION['account_id'] = $user['id'];      // Simpan ID akun ke session
        $_SESSION['username'] = $user['username'];

        // Redirect ke halaman beranda setelah login sukses
        header("Location: ../beranda.php");
        exit;
    } else {
        header("Location: ../halaman_login.php?error=password_salah");
        exit;
    }
} else {
    header("Location: ../halaman_login.php?error=username_tidak_ditemukan");
    exit;
}
?>
