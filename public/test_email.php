<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.elasticemail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sugomadics@gmail.com'; // Elastic Email email
    $mail->Password = '68FB1A8661F8BD26604787C4D736DBAE556B';              // API Key kamu
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 2525;

    $mail->setFrom('sugomadics@gmail.com', 'Studiv');
    $mail->addAddress('sugomadics@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Tes Email dari PHP';
    $mail->Body    = 'Ini adalah email tes sederhana dari PHPMailer + Elastic Email.';

    $mail->send();
    echo "Email berhasil dikirim.";
} catch (Exception $e) {
    echo "Gagal mengirim email. Error: {$mail->ErrorInfo}";
}
