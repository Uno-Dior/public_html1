<?php
session_start();
// print_r($_SESSION);
require_once "../mysql/conn.php";

// Check if the user is already logged in
// if (empty($_SESSION["otp"])) {
//    header("Location: ../data_page/renters_login.php");
//    exit();
// }

// Get the stored OTP from the session
$generatedOTP = $_SESSION["otp"];


// Display the stored OTP (for testing purposes)
// echo "Generated OTP: " . $generatedOTP;


$errors = array();

if (isset($_POST['verify'])) {
    // Get the user-entered OTP
    $user_otp = implode('', $_POST['otp']);

    // Retrieve the generated OTP and its timestamp from the session
    $generated_otp = isset($_SESSION["otp"]) ? $_SESSION["otp"] : null;

    // Check if the user-entered OTP matches the generated OTP
    if ($generated_otp && (string)$generated_otp === $user_otp) {
        // Retrieve additional user data from the database
        $sql = "SELECT * FROM users WHERE otp = ? AND is_expired != 1 AND NOW() <= DATE_ADD(otp_timestamp, INTERVAL 5 MINUTE)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die('Error in preparing the statement: ' . $conn->error);
        }

        $stmt->bind_param("s", $user_otp);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            // Check if the OTP has expired
            if ($user_data['is_expired'] == 1) {
                $errors[] = 'The OTP has expired. Please request a new OTP.';
                exit;
            }

            // Update the database to mark OTP as expired
            $update_sql = "UPDATE users SET is_expired = 1 WHERE otp = ?";
            $update_stmt = $conn->prepare($update_sql);

            if ($update_stmt) {
                $update_stmt->bind_param("s", $user_otp);
                $update_stmt->execute();
                $update_stmt->close();

                // Redirect to the next page
                // $_SESSION["tenant"] = $user_data;
                header("Location: ../data_page/password_page.php");
                exit;
            } else {
                die('Error in preparing the update statement: ' . $conn->error);
            }
        } else {
            $errors[] = 'Invalid OTP or OTP has expired. <br>Request for OTP resend.';
        }
    } else {
        $errors[] = 'Invalid OTP. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <link rel="stylesheet" type="text/css" href="../data_style/styles-logins.css">
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
            </ol>
        </div>
    </section> -->
    <!-- End Breadcrumbs -->

    <div class="container3">
        <form action="" method="POST" class="form3">
            <div class="form_content">
                <div class="validation_form">
                    <div class="title3">OTP Verification</div><br><br>
                    <div class="text">Please check for a code we have sent to you. Your code is 6 characters long.</div>

                    <?php 
                            if(isset($errors)){
                                foreach($errors as $error){
                                    echo '<span class="error-msg"><i class="fa-solid fa-triangle-exclamation"></i>' . $error . '</span>';
                                }
                            }
                    ?>

                    <div class="input_boxes3">
                        <div id="inputs" class="inputs3"> 
                            <input class="input" type="text" name="otp[]" inputmode="numeric" maxlength="1" required>
                            <input class="input" type="text" name="otp[]" inputmode="numeric" maxlength="1" required>
                            <input class="input" type="text" name="otp[]" inputmode="numeric" maxlength="1" required>
                            <input class="input" type="text" name="otp[]" inputmode="numeric" maxlength="1" required>
                            <input class="input" type="text" name="otp[]" inputmode="numeric" maxlength="1" required>
                            <input class="input" type="text" name="otp[]" inputmode="numeric" maxlength="1" required>
                        </div>
                    </div>
                    <div class="button_box">
                        <button type="submit" value="Verify" name="verify">Verify</button>
                    </div>
                    <p id="demo" style="text-align: center; margin: 20px;"></p>
                    <div class="text">
                        Didn't get the code? 
                        <a href="../database/resend_otp.php" class="resend">Resend</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    const inputs = document.getElementById("inputs");

    inputs.addEventListener("input", function (e) {
        const target = e.target;
        const val = target.value;

        if (isNaN(val)) {
            target.value = "";
            return;
        }

        if (val != "") {
            const next = target.nextElementSibling;
            if (next) {
                next.focus();
            }
        }
    });

    inputs.addEventListener("keyup", function (e) {
        const target = e.target;
        const key = e.key.toLowerCase();

        if (key == "backspace" || key == "delete") {
            target.value = "";
            const prev = target.previousElementSibling;
            if (prev) {
                prev.focus();
            }
            return;
        }
    });
</script>

<script>
    // Get the otp_timestamp from the session
    var otpTimestamp = new Date(<?php echo $_SESSION['otp_timestamp'] * 1000; ?>);

    // Set the date we're counting down to (5 minutes after otp_timestamp)
    var countDownDate = new Date(otpTimestamp.getTime() + 5 * 60 * 1000);

    // Update the count down every 1 second
    var x = setInterval(function () {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for minutes and seconds
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = "Resend OTP in: " + minutes + "m " + seconds + "s";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "";
        }
    }, 1000);
</script>

<script>
    function showErrorModal(errorMessage) {
        document.getElementById("errorText").innerHTML = errorMessage;
        document.getElementById("errorModal").style.display = "block";
    }

    function closeErrorModal() {
    document.getElementById("errorModal").style.display = "none";
    }

    window.addEventListener("click", function (event) {
    var modal = document.getElementById("errorModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
});
</script>

</body>
</html>
