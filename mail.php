<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Start session
session_start();

// Required files
require __DIR__ . '/phpmailer/src/Exception.php';
require __DIR__ . '/phpmailer/src/PHPMailer.php';
require __DIR__ . '/phpmailer/src/SMTP.php';

// Create an instance; passing `true` enables exceptions
if (isset($_POST["send"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                              // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';        // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                     // Enable SMTP authentication
        $mail->Username   = 'resihive@gmail.com';    // SMTP write your email
        $mail->Password   = 'mkxglximtvmlggyy';       // SMTP password
        $mail->SMTPSecure = 'ssl';                    // Enable implicit SSL encryption
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom($email, $name); // Sender Email and name
        $mail->addAddress('resihive@gmail.com');     // Add a recipient email  
        $mail->addReplyTo($email, $name); // Reply to sender email

        // Content
        $mail->isHTML(true);               // Set email format to HTML
        $mail->Subject = $subject;   // Email subject heading
        $mail->Body = "<h3>Name:    $name <br>Email:    $email <br>Message:     $message</h3>";

        // Success sent message alert
        $mail->send();

        // Redirect back to HTML file with a success parameter
        header('Location: ../index.php?success=true#contact');
        exit();

    } catch (Exception $e) {
        // Send an error response
        echo 'error';
    }
}
?>
