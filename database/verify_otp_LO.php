<?php
session_start();

if (isset($_POST['verify'])) {
    // Get the user-entered OTP
    $user_otp = implode('', $_POST['otp']);

    require_once '../database/database.php';

    // Retrieve the generated OTP and its timestamp from the session
    $generated_otp = isset($_SESSION["otp"]) ? $_SESSION["otp"] : null;

    // Check if the user-entered OTP matches the generated OTP
    if ($generated_otp && (string)$generated_otp === $user_otp) {
        // Retrieve additional user data from the database
        $sql = "SELECT * FROM tbl_landowner_account WHERE otp = ? AND is_expired != 1 AND NOW() <= DATE_ADD(otp_timestamp, INTERVAL 5 MINUTE)";
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
                echo '<script>
                    alert("The OTP has expired. Please request a new OTP.");
                    window.location.href = "../database/resend_otp_LO.php";
                </script>';
                exit;
            }

            // Update the database to mark OTP as expired
            $update_sql = "UPDATE tbl_landowner_account SET is_expired = 1 WHERE otp = ?";
            $update_stmt = $conn->prepare($update_sql);

            if ($update_stmt) {
                $update_stmt->bind_param("s", $user_otp);
                $update_stmt->execute();
                $update_stmt->close();

                // Redirect to the next page
                $_SESSION["land"] = $user_data;
                header("Location: ../data_page/LO_password.php");
                exit;
            } else {
                die('Error in preparing the update statement: ' . $conn->error);
            }
        } else {
            // No user found with the provided OTP or OTP conditions not met
            echo '<script>
                alert("Invalid OTP or OTP conditions not met. Please try again.");
                window.location.href = "../data_page/registration_LO.php";
            </script>';
        }
    } else {
        // Verification failed
        echo '<script>
            alert("Invalid OTP. Please try again.");
            window.location.href = "../data_page/registration_LO.php";
        </script>';
    }
}
?>
