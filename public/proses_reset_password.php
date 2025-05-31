<?php
require_once '../config/koneksi.php'; // sesuaikan path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (!$email) {
        echo "Email tidak valid.";
        exit;
    }

    if ($password !== $confirm) {
        echo "Password tidak cocok.";
        exit;
    }

    // Cek apakah email terdaftar
    $stmt = mysqli_prepare($link, "SELECT id FROM account WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        echo "Email tidak terdaftar.";
        exit;
    }
    mysqli_stmt_close($stmt);

    // Hash password baru
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update password
    $update = mysqli_prepare($link, "UPDATE account SET password = ? WHERE email = ?");
    mysqli_stmt_bind_param($update, "ss", $hashedPassword, $email);
    if (mysqli_stmt_execute($update)) {
        echo "Password berhasil diubah. Silakan login.";
    } else {
        echo "Gagal mengubah password.";
    }
    mysqli_stmt_close($update);

    mysqli_close($link);
}
?>
