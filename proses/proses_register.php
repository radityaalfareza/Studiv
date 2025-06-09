<?php
require_once '../config/koneksi.php';

// Fungsi untuk membersihkan input
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Ambil dan bersihkan input dari form
$username = sanitize($_POST['username'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$password = $_POST['password'] ?? ''; // password tidak disanitize dengan htmlspecialchars

// Validasi sederhana
$errors = [];

if (empty($username) || strlen($username) < 3) {
    $errors[] = "Username minimal 3 karakter.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

if (strlen($password) < 6) {
    $errors[] = "Password minimal 6 karakter.";
}

// Validasi hanya huruf, angka, underscore untuk username dan email
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    $errors[] = "Username hanya boleh berisi huruf, angka, dan underscore (_).";
}

if (!preg_match('/^[a-zA-Z0-9_@.]+$/', $email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email tidak valid atau mengandung karakter terlarang.";
}

// Cek apakah email atau username sudah digunakan
if (empty($errors)) {
    $check = mysqli_prepare($link, "SELECT id FROM account WHERE email = ? OR username = ?");
    mysqli_stmt_bind_param($check, "ss", $email, $username);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);
    
    if (mysqli_stmt_num_rows($check) > 0) {
        $errors[] = "Email atau username sudah digunakan.";
    }
    mysqli_stmt_close($check);
}

// Jika ada error, tampilkan semua
if (!empty($errors)) {
    foreach ($errors as $error) {
        header("Location: ../halaman_login.php?error=terjadi_kesalahan");
    }
    exit;
}

// Hash password untuk keamanan
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database
$query = "INSERT INTO account (username, email, password, bio) VALUES (?, ?, ?, '')";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../halaman_login.php?error=registrasi_berhasil");
} else {
    header("Location: ../halaman_login.php?error=registrasi_gagal");
}

mysqli_stmt_close($stmt);
mysqli_close($link);
?>
