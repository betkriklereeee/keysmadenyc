<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone   = strip_tags(trim($_POST["phone"]));
    $message = strip_tags(trim($_POST["message"]));

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill out all required fields.";
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.keysmadenyc.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@keysmadenyc.com';
        $mail->Password   = 'gP5de5*82';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('info@keysmadenyc.com', 'Keys Made NYC');
        $mail->addAddress('zipcodelocksites@gmail.com');
        $mail->addReplyTo($email, $name);

        $mail->Subject = 'New Form Submission from KeysMadeNYC.com';
        $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

        $mail->send();
        http_response_code(200);
        echo "success";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "Forbidden";
}
?>