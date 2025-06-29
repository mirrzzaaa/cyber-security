<?php
// Database
$host = 'localhost';
$db = 'mfa_otp';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendOTP($email, $otp)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mirzamarwa76@gmail.com';
        $mail->Password = 'zfqjnxbxjehxeble'; // app password gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('mirzamarwa76@gmail.com', 'PHP OTP App');
        $mail->addAddress($email);
        $mail->Subject = 'Kode OTP Anda';
        $mail->Body = "Kode OTP Anda adalah: $otp";

        $mail->send();
    } catch (Exception $e) {
        die("Gagal kirim email. Error: {$mail->ErrorInfo}");
    }
}
?>