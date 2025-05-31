<?php
require_once '../config/koneksi.php'; // sesuaikan path koneksi database

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // pastikan path ini sesuai tempat PHPMailer autoload

function sendResetEmail($email) {
    $resetLink = "http://localhost/public/reset_password.php";

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.elasticemail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sugomadics@gmail.com';  // Ganti dengan email Elastic Email kamu
        $mail->Password   = '68FB1A8661F8BD26604787C4D736DBAE556B';            // Ganti dengan API Key Elastic Email kamu
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        //Recipients
        $mail->setFrom('sugomadics@gmail.com', 'Studiv');
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

    if (!$email) {
        echo "Email tidak valid.";
        exit;
    }

    // Cek apakah email ada di database
    $query = "SELECT id FROM account WHERE email = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        echo "Email tidak terdaftar.";
        exit;
    }

    // Kirim email reset password
    if (sendResetEmail($email)) {
        echo "Link reset password sudah dikirim ke email Anda.";
    } else {
        echo "Gagal mengirim email, coba lagi nanti.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
