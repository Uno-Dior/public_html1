<?php
session_start();
// print_r($_SESSION);
require_once "../mysql/conn.php";

if (isset($_SESSION["tenant"])) {
    header("Location: ../data_page/renters_dashboard_1.php");
    exit();
}

if (isset($_SESSION["land"])) {
    header("Location: ../data_page/landowners_dashboard.php");
    exit();
}

$errors = array();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);  
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        if (password_verify($password, $user["password"])) {
            // Check user_type and fetch data accordingly
            if ($user['user_type'] == 1) {
                $sqlLand = "SELECT * FROM tbl_landowner_account WHERE email = ?";
                $stmtLand = $conn->prepare($sqlLand);
                $stmtLand->bind_param("s", $email);
                $stmtLand->execute();
                $resultLand = $stmtLand->get_result();
                $userData = $resultLand->fetch_assoc();
                $stmtLand->close();

                // Store landowner data in session
                session_start();
                $_SESSION['land'] = $userData;

                header("Location: ../data_page/landowners_dashboard.php");
                die();
            } elseif ($user['user_type'] == 2) {
                $sqlTenant = "SELECT * FROM tbl_renters_account WHERE email = ?";
                $stmtTenant = $conn->prepare($sqlTenant);
                $stmtTenant->bind_param("s", $email);
                $stmtTenant->execute();
                $resultTenant = $stmtTenant->get_result();
                $userData = $resultTenant->fetch_assoc();
                $stmtTenant->close();

                // Store tenant data in session
                session_start();
                $_SESSION['tenant'] = $userData;

                header("Location: ../data_page/renters_dashboard_1.php");
                die();
            }
        } else {
            $errors[] = 'Password does not match.';
        }
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
    <!-- <section id="breadcrumbs" class="breadcrumbs">
        <div class="container1">
            <ol>
                <li><a href="../index.php">Home</a></li>
                <li>Login</li>
            </ol>
        </div>
    </section> -->
    <!-- End Breadcrumbs -->

    <section class="box-cont0">
        <div class="container0">
            <form action="" method="post" class="form">
                <div class="form_content">  
                    <div class="login_form">
                        <div class="title">Login</div>
                        <?php 
                            if(isset($errors)){
                                foreach($errors as $error){
                                    echo '<span class="error-msg"><i class="fa-solid fa-triangle-exclamation"></i>' . $error . '</span>';
                                }
                            }
                        ?>
                        <div class="input_boxes">
                            <div class="input_box">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input_box">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="text"><a href="../data_page/forgot_password_page.php">Forgot password?</a></div>
                            <div class="button_box">
                                <button type="submit" value="Submit" name="login">Login</button>
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