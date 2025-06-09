<?php
require_once '../config/koneksi.php'; // sesuaikan path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        header("Location: ../halaman_login.php?error=password_tidak_cocok");
        exit;
    }

    // Hash password baru
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update password
    $stmt = mysqli_prepare($link, "UPDATE account SET password = ?, reset_token = NULL, reset_expires_at = NULL WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../halaman_login.php?error=password_berhasil_diubah");
    } else {
        header("Location: ../halaman_login.php?error=password_gagal_diubah");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
