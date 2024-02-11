<?php
session_start();
require_once "../database/database.php";

if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $newPassword = $_POST['confirmPassword'];

    $errors = array();

    // Check if the password is at least 8 characters long
    if (strlen($newPassword) < 8) {
        $_SESSION['alerts'][] = "Password must be at least 8 characters long!";
        header("Location: ../data_page/LO_password.php");
        exit();
    }

    // Check if the password contains a number
    if (!preg_match('/[0-9]/', $newPassword)) {
        $_SESSION['alerts'][] = "Password must contain at least one number!";
        header("Location: ../data_page/LO_password.php");
        exit();
    }

    // Check if the password contains a special character
    if (!preg_match('/[^A-Za-z0-9]/', $newPassword)) {
        $_SESSION['alerts'][] = "Password must contain at least one special character!";
        header("Location: ../data_page/LO_password.php");
        exit();
    }

    if (empty($errors)) {
        // Check if the user with the provided email exists
        $sqlCheckUser = "SELECT * FROM tbl_landowner_account WHERE email = ?";
        $stmtCheckUser = $conn->prepare($sqlCheckUser);

        if ($stmtCheckUser) {
            $stmtCheckUser->bind_param("s", $email);
            $stmtCheckUser->execute();
            $result = $stmtCheckUser->get_result();
            $stmtCheckUser->close();

            if ($result->num_rows === 1) {
                // Update the password for the existing user
                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $sqlUpdate = "UPDATE tbl_landowner_account SET password = ?, status='verified' WHERE email = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);

                if ($stmtUpdate) {
                    $stmtUpdate->bind_param("ss", $passwordHash, $email);
                    $stmtUpdate->execute();
                    $stmtUpdate->close();

                    // Display the modal
                    echo '<script>';
                    echo 'var modal = document.getElementById("confirmationModal");';
                    echo '</script>';

                    // Set session variable to indicate password update
                    $_SESSION['password_updated'] = true;
                } else {
                    $_SESSION['alerts'][] = "Error updating password: " . $conn->error;
                    header("Location: ../data_page/landowners_login.php");
                    exit();
                }
            } else {
                $_SESSION['alerts'][] = "User with the provided email does not exist";
                header("Location: ../data_page/landowners_login.php");
                exit();
            }
        } else {
            $_SESSION['alerts'][] = "Error checking user: " . $conn->error;
            header("Location: ../data_page/landowners_login.php");
            exit();
        }
    } else {
        // If there are errors, store them in the session and redirect
        $_SESSION['alerts'] = $errors;
        header("Location: ../data_page/LO_password.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <title>ResiHive - for Registration</title>
</head>
<style>
    /* Modal Styles */
.modal {
  display: flex;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
  z-index: 100;
}

.modal-content {
  display: flex;
  flex-direction: column;
  background-color: #fff;
  padding: 10px 20px 20px 20px;
  border-radius: 5px;
  text-align: center;
  height: 300px;
  width: 500px;
  justify-content: space-evenly;
  align-items: center;
}

.modal-content p {
  margin: 20px 0 20px 0;
  font-size: 24px;
}


.modal-content button {
  padding: 10px 20px;
  margin: 0 10px;
  cursor: pointer;
  height: 50px;
  border-radius: 20px;
  font-size: 14px;
  color: white;
  background-color: #000038;
  width: 200px;
}

</style>
<body>

    <!-- Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <p>Your password has been updated successfully. Confirm to log in!</p>
            <button onclick="confirmInquiry()">Okay</button>
        </div>
    </div>

    <script src="..\jscripts\passwordfeat.js"></script>
    <script>
        function confirmInquiry() {
            // Destroy the session
            <?php session_destroy(); ?>
            // Redirect to the login page
            window.location.href = '../data_page/landowners_login.php';
        }
    </script>

</body>
</html>
