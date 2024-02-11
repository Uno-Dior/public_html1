<?php
session_start();
require_once "../mysql/conn.php";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Generate a new OTP
    $new_otp = rand(100000, 999999);

    // Update the OTP and timestamp in the database
    $update_sql = "UPDATE users SET otp = ?, otp_timestamp = CURRENT_TIMESTAMP WHERE email = ?";
    $stmt_update = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt_update, $update_sql)) {
        mysqli_stmt_bind_param($stmt_update, "is", $new_otp, $email);

        if (mysqli_stmt_execute($stmt_update)) {
            // Update the session with the new OTP and timestamp
            $_SESSION['otp'] = $new_otp;
            $_SESSION['otp_timestamp'] = time(); // Update session timestamp

            // Email sending logic
            require_once '../vendor/autoload.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->IsSMTP();
            $mail->SMTPDebug  = 0;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host       = 'smtp.gmail.com';
            $mail->Port       = 465;
            $mail->Username   = 'resihive@gmail.com';
            $mail->Password   = 'vdqlozvhwdwrznog';

            $mail->SetFrom('resihive@gmail.com', 'OTP Code');
            $mail->AddAddress($email);

            $mail->Subject = 'New Verification Code';
            $mail->Body    = 'Your new verification code for account verification is ' . $new_otp . ' please do not share this code with anyone.';

            if ($mail->Send()) {
                // SMS sending logic (Uncomment and replace placeholders with your Semaphore API key and details)
                /*
                $ch = curl_init();

                $semaphoreParameters = array(
                    'apikey' => 'your_semaphore_api_key',
                    'number' => $num,
                    'message' => 'Your new OTP Code is ' . $new_otp . '.',
                    'sendername' => 'ResiHive'
                );

                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($semaphoreParameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $output = curl_exec($ch);
                curl_close($ch);

                echo $output;
                */

                $_SESSION['otp'] = $new_otp;

                // Redirect back to Registration_TT.php
                header("Location: ../data_page/otp_verification_page.php");
                exit();
            } else {
                $_SESSION['alerts'][] = "Email could not be sent. Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            $_SESSION['alerts'][] = "Failed to update OTP and timestamp in the database";
        }
    } else {
        $_SESSION['alerts'][] = "Failed to prepare OTP update statement";
    }

    // Close the update statement
    mysqli_stmt_close($stmt_update);
} else {
    $_SESSION['alerts'][] = "Email not found in session";
}

// Redirect back to the previous page (renters_login.php in this case) on error
header("Location: ../data_page/signup_page.php");
exit();
?>
