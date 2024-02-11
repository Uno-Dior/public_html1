<?php
session_start();
require_once "../mysql/conn.php";

$errors = array();

if (isset($_POST['forgot_password'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        // Store individual user data in session
        $_SESSION['otp'] = $user['otp'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['f_name'] = $user['f_name'];
        $_SESSION['s_name'] = $user['s_name'];
        $_SESSION['num'] = $user['num'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['otp_timestamp'] = $user['otp_timestamp'];

        // Continue with the OTP verification

        // Generate a new OTP
        $newOtp = rand(100000, 999999);

        // Update the OTP and timestamp in the database
        $updateSql = "UPDATE users SET otp = ?, is_expired = 0, otp_timestamp = CURRENT_TIMESTAMP WHERE num = ?";
        $stmtUpdate = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmtUpdate, $updateSql)) {
            mysqli_stmt_bind_param($stmtUpdate, "is", $newOtp, $_SESSION['num']);

            if (mysqli_stmt_execute($stmtUpdate)) {
                // Update the session with the new OTP and timestamp
                $_SESSION['otp'] = $newOtp;
                $_SESSION['otp_timestamp'] = time(); // Update session timestamp

                // Send OTP via SMS using Semaphore API
                $ch = curl_init();

                $semaphoreParameters = array(
                    'apikey' => 'your_semaphore_api_key',
                    'number' => $_SESSION['num'],
                    'message' => 'Your new OTP Code is ' . $newOtp . '.',
                    'sendername' => 'ResiHive'
                );

                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($semaphoreParameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $output = curl_exec($ch);
                curl_close($ch);

                echo $output; // Output the response from Semaphore (success or failure)

                // Redirect to OTP verification page
                header("Location: ../data_page/otp_verification.php");
                exit();
            } else {
                $errors[] = "Failed to update OTP and timestamp in the database: " . mysqli_stmt_error($stmtUpdate);
            }
        } else {
            $errors[] = "Failed to prepare OTP update statement: " . mysqli_stmt_error($stmtUpdate);
        }

        // Close the update statement
        mysqli_stmt_close($stmtUpdate);
    } else {
        $errors[] = 'Email does not exist.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../data_image/favicon.png">
    <link rel="stylesheet" type="text/css" href="../data_style/styles-logins.css">
    <script src="https://kit.fontawesome.com/4d86b94a8a.js" crossorigin="anonymous"></script>
    <title>ResiHive - for Renters</title>
</head>
<body>

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container1">
            <ol>
                <li><a href="../index.php">Home</a></li>
                <li>Login</li>
            </ol>
        </div>
    </section>
    <!-- End Breadcrumbs -->

    <section class="box-cont">
        <div class="container">
            <form action="" method="post" class="form">
                <div class="form_content">  
                    <div class="login_form">
                        <div class="title">Forgot your password?</div><br><br>
                        <?php 
                            if(isset($errors)){
                                foreach($errors as $error){
                                    echo '<span class="error-msg"><i class="fa-solid fa-triangle-exclamation"></i>' . $error . '</span>';
                                }
                            }
                        ?>
                        <div class="text">Please enter your email to search for your account. The code will be sent to your registered mobile number.</div>
                        <div class="input_boxes">
                            <div class="input_box">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="button_box">
                                <button type="submit" value="Submit" name="forgot_password">Submit</button>
                            </div>
                            <div class="text">Don't have an account?<a href="../data_page/signup_page.php"> Sign up Now</a></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>