<?php
session_start();
require_once "../database/database.php";

$errors = array();

if (isset($_POST['Signup'])) {
    $f_name = $_POST['f_name'];
    $s_name = $_POST['s_name'];
    $num = $_POST['phone'];
    $email = $_POST['email'];

    // Perform data verification for signup
    if (empty($f_name) || empty($s_name) || empty($num) || empty($email)) {
        $_SESSION['alerts'][] = "All fields are required";
        header("Location: ../data_page/renters_login.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $email)) {
        $_SESSION['alerts'][] = "Email is not valid";
        header("Location: ../data_page/renters_login.php");
        exit();
    }

    if (!preg_match('/^09[0-9]{9}$/', $num)) {
        $_SESSION['alerts'][] = "Invalid Phone number";
        header("Location: ../data_page/renters_login.php");
        exit();
    }

    require_once 'database.php';

    // Check if the email already exists
    $check_sql = "SELECT * FROM tbl_renters_account WHERE email = ?";
    $stmt_check = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt_check, $check_sql)) {
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            // Email already exists, handle accordingly
            $_SESSION['alerts'][] = "Email already exists. Please use a different email.";
            header("Location: ../data_page/renters_login.php");
            exit();
        } else {
            // Email does not exist, generate OTP and send
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;  // Store the generated OTP in the session

            // Insert data into the database
            $insert_sql = "INSERT INTO tbl_renters_account (f_name, s_name, num, email, otp) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt_insert, $insert_sql)) {
                mysqli_stmt_bind_param($stmt_insert, "ssssi", $f_name, $s_name, $num, $email, $otp);
                if (mysqli_stmt_execute($stmt_insert)) {
                    // Continue with the rest of the signup process
                    require_once '../vendor/autoload.php';

                    // Create a new PHPMailer instance
                    $mail = new PHPMailer\PHPMailer\PHPMailer();

                    // SMTP settings
                    $mail->IsSMTP();
                    $mail->SMTPDebug  = 0;
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = 'ssl'; // Use 'tls' or 'ssl'
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->Port       = 465; // Use 587 for TLS, 465 for SSL
                    $mail->Username   = 'resihive@gmail.com';
                    $mail->Password   = 'vdqlozvhwdwrznog';

                    // Sender and recipient information
                    $mail->SetFrom('resihive@gmail.com', 'OTP Code');
                    $mail->AddAddress($email);

                    // Email content
                    $mail->Subject = 'Verification Code';
                    $mail->Body    = 'Your verification code for account verification is ' . $otp . ' please do not share this code to anyone.';

                    // Send the email
                    if ($mail->Send()) {

                        // Email sent successfully, now send SMS using Semaphore API
                        // Uncomment the following lines and replace the placeholder values with your Semaphore API key and other details

                        $ch = curl_init();  // Initialize cURL session

                        $semaphoreParameters = array(
                            'apikey' => 'eb94b140f2a7bc57df418c6337061557',  // Your Semaphore API key
                            'number' => $num,  // Recipient's phone number
                            'message' => 'Thanks for registering. Your OTP Code is ' . $otp . '.',  // SMS content with OTP
                            'sendername' => 'ResiHive'  // Sender's name
                        );

                        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');  // Set the URL
                        curl_setopt($ch, CURLOPT_POST, 1);  // Set cURL to perform a POST request

                        // Send the parameters set above with the request
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($semaphoreParameters));

                        // Receive response from the server
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $output = curl_exec($ch);  // Execute cURL session
                        curl_close($ch);  // Close cURL session

                        // Show the server response
                        echo $output;

                        // Store the generated OTP and timestamp in the session
                        $_SESSION['otp'] = $otp;
                        $_SESSION['email'] = $email;
                        $_SESSION['f_name'] = $f_name;
                        $_SESSION['s_name'] = $f_name;
                        $_SESSION['num'] = $num;
                        $_SESSION['otp_timestamp'] = time();  // Timestamp when the OTP was generated

                        // Group the data in the session under 'land'
                        $_SESSION['tenant'] = array(
                            'f_name' => $f_name,
                            's_name' => $s_name,
                            'num' => $num,
                            'email' => $email,
                            // Add any other fields you want to include
                        );

                        // Redirect to the OTP verification page
                        header("Location: ../data_page/registration_TT.php");
                        exit();
                } else {
                    $_SESSION['alerts'][] = "Email could not be sent. Mailer Error: " . $mail->ErrorInfo;
                    header("Location: ../data_page/renters_login.php");
                    exit();
                }
            } else {
                $_SESSION['alerts'][] = "Something went wrong with data insertion";
                header("Location: ../data_page/renters_login.php");
                exit();
            }
        } else {
            $_SESSION['alerts'][] = "Failed to prepare data insertion statement";
            header("Location: ../data_page/renters_login.php");
            exit();
        }
    }
} else {
    $_SESSION['alerts'][] = "Something went wrong with email check";
    header("Location: ../data_page/renters_login.php");
    exit();
}

// Close the check statement
mysqli_stmt_close($stmt_check);
}
?>