<?php
require_once '../config/koneksi.php'; // sesuaikan path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = "sugomadics@gmail.com";
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (!$email) {
        header("Location: ../halaman_login.php?error=email_tidak_valid");
        exit;
    }

    if ($password !== $confirm) {
        header("Location: ../halaman_login.php?error=password_tidak_cocok");
        exit;
    }

    // Cek apakah email terdaftar
    $stmt = mysqli_prepare($link, "SELECT id FROM account WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        header("Location: ../halaman_login.php?error=email_tidak_terdaftar");
        exit;
    }
    mysqli_stmt_close($stmt);

    // Hash password baru
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update password
    $update = mysqli_prepare($link, "UPDATE account SET password = ? WHERE email = ?");
    mysqli_stmt_bind_param($update, "ss", $hashedPassword, $email);
    if (mysqli_stmt_execute($update)) {
        header("Location: ../halaman_login.php?error=password_berhasil_diubah");
    } else {
        header("Location: ../halaman_login.php?error=password_gagal_diubah");
    }
    mysqli_stmt_close($update);

    mysqli_close($link);
}
?>
