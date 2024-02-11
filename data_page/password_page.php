<?php
session_start();
// print_r($_SESSION);

// Determine the user type and retrieve email from the session
// $userType = isset($_SESSION['tenant']) ? 'tenant' : 'land';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <link rel="stylesheet" type="text/css" href="..\data_style\styles-logins.css">
    <script src="https://kit.fontawesome.com/4d86b94a8a.js" crossorigin="anonymous"></script>
    <title>ResiHive - for Registration</title>
</head>
<body>

    <!-- ======= Breadcrumbs ======= -->
    <!-- <section id="breadcrumbs" class="breadcrumbs">
        <div class="container1">
            <ol>
                <li>Home</li>
                <li>Login</li>
                <li>Signup</li>
                <li>OTP Validation</li>
                <li>Password</li>
            </ol>
        </div>
    </section> -->
    <!-- End Breadcrumbs -->

<div class="container4">
    <form action="../database/password_process.php" method="post" class="form4" onsubmit="validateForm(event)">
        <div class="form_content">
            <div class="password_form">
                <div class="title4">Password</div>
                <div class="input_boxes4">
                    <!-- <input type="input" name="user_type" value="<php echo $userType; ?>"> -->
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <div class="input_box">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input_box">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter your password" required>
                    </div>
                    <div class="button_box">
                        <button type="submit" value="Submit" name="Login">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>
