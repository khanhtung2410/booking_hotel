<?php
include("email.php");
session_start();

// Define the cooldown period and max attempts
$cooldownPeriod = 60;
$maxAttempts = 5;

if (!isset($_SESSION['otp_resend_attempts'])) {
    $_SESSION['otp_resend_attempts'] = 0;
}

if (isset($_SESSION['last_otp_resend'])) {
    $timeSinceLastResend = time() - $_SESSION['last_otp_resend'];

    if ($timeSinceLastResend < $cooldownPeriod) {
        $remainingTime = $cooldownPeriod - $timeSinceLastResend;
        header("Location: verify.php?msg=Vui lòng chờ $remainingTime giây trước khi gửi lại mã OTP.");
        exit();
    }
}

if ($_SESSION['otp_resend_attempts'] >= $maxAttempts) {
    header("Location: verify.php?msg=Bạn đã vượt quá số lần gửi lại OTP. Vui lòng thử lại sau.");
    exit();
}

// Tang bo dem
$_SESSION['otp_resend_attempts']++;

// Sent otp
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expire'] = time() + 300; // OTP expire time = 5 minutes
$_SESSION['last_otp_resend'] = time();
$_SESSION['email'] = $_POST['email'];

sendMail($_POST['email'], "OTP verify", $otp);


header("Location: verify.php?msg=Mã OTP đã được gửi lại.");
exit();
