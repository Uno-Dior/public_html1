<?php
session_start();

require_once "../database/database.php";
$errors = array();

if (isset($_SESSION["land"])) {
    header("Location: ../data_page/landowners_dashboard.php");
    exit();
}

// Check if there are any alert messages to display
if (!empty($_SESSION['alerts'])) {
    foreach ($_SESSION['alerts'] as $alert) {
        echo '<script>alert("' . $alert . '");</script>';
    }
    unset($_SESSION['alerts']); // Clear the alerts after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../data_image/favicon.png">
    <link rel="stylesheet" type="text/css" href="../data_style/styles-login.css">
    <title>ResiHive - for Landowners</title>
</head>
<body>

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container1">
            <ol>
                <li><a href="../index.php">Home</a></li>
                <li>Log in</li>
            </ol>
        </div>
    </section>
    <!-- End Breadcrumbs -->

    <section class="box-cont">
        <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <div>
                    <a href="../index.php"><img src="../data_image/RESIHIVE SYMBOL2.png" class="logo" alt="logo"></a>
                </div>
                <div class="text">Be a bee that shelters the hive!</div>
            </div>
        </div>
            <form action="../database/LO_Login_Process.php" method="post" class="form1">
                <div class="form_content">
                    <div class="login_form">
                        <div class="title">Login</div>
                        <div class="input_boxes">
                            <div class="input_box">
                                <img src="../data_image/email.png" alt="email_img">
                                <input type="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input_box">
                                <img src="../data_image/password.png" alt="password_img">
                                <input type="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="text"><a href="#">Forgot password?</a></div>
                            <div class="button input_box">
                                <input type="submit" value="Login" name="login">
                            </div>
                            <div class="text">Don't have an account? <label for="flip">Sign up Now</label></div>
                        </div>
                    </div>
                </div>
            </form>
        
            <form action="../database/LO_Signup_Process.php" method="post" class="form2" novalidate>
                <div class="form_content">
                    <div class="signup_form">
                        <div class="title">Sign Up</div>
                        <div class="input_boxes">
                                <label for="f_name" class="sub_title">First Name:</label>
                            <div class="input_box">
                                <img src="../data_image/username.png" alt="username_img">
                                <input type="text" name="f_name" id="f_name" placeholder="Juan" required>
                            </div>
                                <label for="s_name" class="sub_title">Last Name:</label>
                            <div class="input_box">
                                <img src="../data_image/username.png" alt="username_img">
                                <input type="text" name="s_name" placeholder="Tamad" required>
                            </div>
                                <label for="email" class="sub_title">Email Address:</label>
                            <div class="input_box">
                                <img src="../data_image/email.png" alt="email_img">
                                <input type="email" name="email" placeholder="you@email.com" required>
                            </div>  
                                <label for="phone" class="sub_title">Phone Number:</label>
                            <div class="input_box">
                                <img src="../data_image/Phone.png" alt="phone_img">
                                <input type="tel" id="phone" name="phone" pattern="[0]{1}[9]{1}[0-9]{9}" placeholder="09123456789" required>
                            </div>
                            <div class="button input_box">
                                <input type="submit" value="Sign up" name="Signup">
                            </div>
                            <div class="text">Already have an account? <label for="flip">Login Now</label></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

</body>
</html>