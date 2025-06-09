<?php
require_once '../config/koneksi.php'; // sesuaikan path koneksi database

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // pastikan path ini sesuai tempat PHPMailer autoload

function sendResetEmail($email, $token) {
    $resetLink = "https://localhost/reset_password.php?token=$token";

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'awokawokawok227@gmail.com';  // Ganti dengan email Elastic Email kamu
        $mail->Password   = 'gzpw fmlj mpga wqam';            // Ganti dengan API Key Elastic Email kamu
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('awokawokawok227@gmail.com', 'Studiv');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Anda';
        $mail->Body    = "Halo,<br><br>Silakan klik link berikut untuk mereset password Anda:<br><a href='{$resetLink}'>{$resetLink}</a><br><br>Jika Anda tidak meminta reset password, abaikan email ini.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Gagal mengirim email. Error: {$mail->ErrorInfo}";
        return false;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

    // Cek apakah email terdaftar
    $stmt = mysqli_prepare($link, "SELECT id FROM account WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        header("Location: ../lupa_password.php?info=email_tidak_terdaftar");
        exit;
    }

    // Buat token dan simpan ke DB
    $token = bin2hex(random_bytes(32));
    $expires_at = date("Y-m-d H:i:s", time() + 600); // 10 menit

    $update = mysqli_prepare($link, "UPDATE account SET reset_token = ?, reset_expires_at = ? WHERE email = ?");
    mysqli_stmt_bind_param($update, "sss", $token, $expires_at, $email);
    mysqli_stmt_execute($update);
    mysqli_stmt_close($update);

    // Kirim email reset password
    if (sendResetEmail($email, $token)) {
        header("Location: ../halaman_login.php?info=link_reset_dikirim");
    } else {
        header("Location: ../halaman_login.php?error=gagal_kirim_email");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
