<?php
session_start();
print_r($_SESSION);

require_once "../mysql/conn.php";

$errors = array();

if (isset($_POST['forgot_password'])) {
    $enteredPhoneNumber = isset($_SESSION['num']) ? $_SESSION['num'] : null;

    if (!$enteredPhoneNumber) {
        $errors[] = 'Please enter your registered mobile number.';
    }

    // Retrieve the user email from the session
    $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : null;

    if (!$userEmail) {
        // Redirect to the initial page or handle the case where user email is not set in session
        header("Location: ../path/to/initial_page.php");
        exit();
    }

    // Retrieve user data from the database based on the email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $userData = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($userData) {
            // Continue with the phone number verification
            $storedPhoneNumber = $userData['num']; // Assuming 'num' is the column name for the phone number in your table

            if ($storedPhoneNumber == $enteredPhoneNumber) {
                // Phone numbers match, proceed to OTP verification

                // Generate a new OTP
                $newOtp = rand(100000, 999999);

                // Update the OTP and timestamp in the database
                $updateSql = "UPDATE users SET otp = ?, is_expired = 0, otp_timestamp = CURRENT_TIMESTAMP WHERE num = ?";
                $stmtUpdate = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmtUpdate, $updateSql)) {
                    mysqli_stmt_bind_param($stmtUpdate, "is", $newOtp, $enteredPhoneNumber);

                    if (mysqli_stmt_execute($stmtUpdate)) {
                        // Update the session with the new OTP and timestamp
                        $_SESSION['otp'] = $newOtp;
                        $_SESSION['otp_timestamp'] = time(); // Update session timestamp

                        // Send OTP via SMS using Semaphore API
                        $ch = curl_init();

                        $semaphoreParameters = array(
                            'apikey' => 'your_semaphore_api_key',
                            'number' => $storedPhoneNumber,
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
                $errors[] = 'Entered phone number does not match.';
            }
        } else {
            $errors[] = 'User data not found in the database.';
        }
    } else {
        $errors[] = "Failed to prepare SQL statement: " . mysqli_stmt_error($stmt);
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
                        <div class="title">Enter security code<div><br>
                        <?php 
                            if(isset($errors)){
                                foreach($errors as $error){
                                    echo '<span class="error-msg"><i class="fa-solid fa-triangle-exclamation"></i>' . $error . '</span>';
                                }
                            }
                        ?>
                        <div class="text">Please enter your registered mobile number for password update.</div>
                        <div class="input_boxes">
                            <div class="input_box">
                                <i class="fa-solid fa-phone"></i>
                                <input type="tel" id="phone" name="phone" pattern="[0]{1}[9]{1}[0-9]{9}" placeholder="09123456789" required>
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