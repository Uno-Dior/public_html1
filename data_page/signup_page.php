<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../mysql/conn.php";
$mydb = new Database();

session_start();
$errors = array();

if (isset($_POST['Signup'])) {
    $f_name = $_POST['f_name'];
    $s_name = $_POST['s_name'];
    $num = $_POST['phone'];
    $email = $_POST['email'];
    $user_type = $_POST['user'];

    if (!file_exists('../database/database.php')) {
        die('Error: database.php not found');
    }

    // Check if the email already exists in the users table
    $check_sql = "SELECT * FROM users WHERE email = ?";
    $stmt_check = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt_check, $check_sql)) {
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $errors['email'] = 'User already exists!';
        } else {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;

            $stmt_insert = mysqli_stmt_init($conn);

            $insert_sql = "INSERT INTO users (user_type, email, f_name, s_name, num, otp) VALUES (?, ?, ?, ?, ?, ?)";

            if (mysqli_stmt_prepare($stmt_insert, $insert_sql)) {
                mysqli_stmt_bind_param($stmt_insert, "issssi", $user_type, $email, $f_name, $s_name, $num, $otp);
                if (mysqli_stmt_execute($stmt_insert)) {
                    
                    require_once '../vendor/autoload.php';

                    $mail = new PHPMailer\PHPMailer\PHPMailer();

                    // SMTP settings
                    $mail->IsSMTP();
                    $mail->SMTPDebug  = 0;
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->Port       = 465;
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

                        $ch = curl_init();

                        $semaphoreParameters = array(
                            'apikey' => 'your_semaphore_api_key',
                            'number' => $num,
                            'message' => 'Thanks for registering. Your OTP Code is ' . $otp . '.',
                            'sendername' => 'ResiHive'
                        );

                        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                        curl_setopt($ch, CURLOPT_POST, 1);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($semaphoreParameters));

                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $output = curl_exec($ch);
                        curl_close($ch);

                        echo $output;
                        
                        $_SESSION['otp'] = $otp;
                        $_SESSION['email'] = $email;
                        $_SESSION['f_name'] = $f_name;
                        $_SESSION['s_name'] = $f_name;
                        $_SESSION['num'] = $num;
                        $_SESSION['otp'] = $otp;
                        $_SESSION['user_type'] = $user_type;
                        $_SESSION['otp_timestamp'] = time();  // Timestamp when the OTP was generated

                        if ($user_type == '1') {
                            $_SESSION['land'] = array(
                                'f_name' => $f_name,
                                's_name' => $s_name,
                                'num' => $num,
                                'email' => $email,
                                'otp' => $otp
                            );
                            header("Location: ../data_page/otp_verification_page.php");
                            exit();
                        } elseif ($user_type == '2') {
                            $_SESSION['tenant'] = array(
                                'f_name' => $f_name,
                                's_name' => $s_name,
                                'num' => $num,
                                'email' => $email,
                                'otp' => $amountOptionsQuery
                            );
                            header("Location: ../data_page/otp_verification.php");
                            exit();
                        }
                    }
                    } else {
                        echo 'Error executing query: ' . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt_insert);
                } else {
                    echo 'Error preparing statement: ' . mysqli_error($conn);
                }
            }
            mysqli_stmt_close($stmt_check);
        } else {
            echo 'Error preparing statement: ' . mysqli_error($conn);
        }
    } else {
        $errors[] = 'Form submission failed.';
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
    <!-- <section id="breadcrumbs" class="breadcrumbs">
        <div class="container1">
            <ol>
                <li><a href="../index.php">Home</a></li>
                <li>Login</li>
                <li>Signup</li>
            </ol>
        </div>
    </section> -->
    <!-- End Breadcrumbs -->

    <section class="box-cont">
        <div class="container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form1">
                <div class="form_content">
                    <div class="login_form">
                        <div class="title">Sign Up</div>
                        <?php if (isset($errors['email'])) : ?>
                            <span class="error-msg"><i class="fa-solid fa-triangle-exclamation"></i><?php echo $errors['email']; ?></span>
                        <?php endif; ?>
                        <div class="input_boxes">
                            <label for="user" class="sub_title">Signup as:</label>
                            <div class="input_box">
                                <i class="fa-solid fa-user"></i>
                                <select name="user" required>
                                    <option value="2">Renter</option>
                                    <option value="1">Landowner</option>
                                </select>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="input350">
                                    <label for="f_name" class="sub_title">First Name:</label>
                                    <div class="input_box">
                                        <i class="fa-solid fa-id-card"></i>
                                        <input type="text" name="f_name" id="f_name" placeholder="Juan" required>
                                    </div>
                                </div>
                               <div class="input350">
                                    <label for="s_name" class="sub_title">Last Name:</label>
                                    <div class="input_box">
                                        <i class="fa-solid fa-id-card"></i>
                                        <input type="text" name="s_name" placeholder="Tamad" required>
                                    </div>
                               </div>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="input350">
                                    <label for="email" class="sub_title">Email Address:</label>
                                    <div class="input_box">
                                        <i class="fa-solid fa-envelope"></i>
                                        <input type="email" name="email" placeholder="you@email.com" required>
                                    </div>
                                </div>
                               <div class="input350">
                                    <label for="phone" class="sub_title">Phone Number:</label>
                                    <div class="input_box">
                                        <i class="fa-solid fa-phone"></i>
                                        <input type="tel" id="phone" name="phone" pattern="[0]{1}[9]{1}[0-9]{9}" placeholder="09123456789" required>
                                    </div>
                               </div>
                            </div>
                            <div class="button_box">
                                <button type="submit" value="Sign up" name="Signup">Sign up</button>
                            </div>
                            <div class="text">Already have an account?<a href="../data_page/login_page.php"> Login Now</a></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
