<?php
session_start();
// print_r($_SESSION);

require_once "../mysql/conn.php";

// Your password processing logic
if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_type = $_SESSION['user_type'];
    $f_name = $_SESSION['f_name'];
    $s_name = $_SESSION['s_name'];
    $num = $_SESSION['num'];

    $errors = array();

    // Check if the password is at least 8 characters long
    if (strlen($newPassword) < 8) {
        $errors[] = "Password must be at least 8 characters long!";
    }

    // Check if the password contains a number
    if (!preg_match('/[0-9]/', $newPassword)) {
        $errors[] = "Password must contain at least one number!";
    }

    // Check if the password contains a special character
    if (!preg_match('/[^A-Za-z0-9]/', $newPassword)) {
        $errors[] = "Password must contain at least one special character!";
    }

    // Check if password and confirmPassword match
    if ($newPassword !== $confirmPassword) {
        $errors[] = "Passwords do not match!";
    }

    if (empty($errors)) {
        // Determine the table based on user_type
        $tableName = ($user_type == '1') ? "tbl_landowner_account" : "tbl_renters_account";

        // Check if the user with the provided email exists
        $sqlCheckUser = "SELECT * FROM $tableName WHERE email = ?";
        $stmtCheckUser = $conn->prepare($sqlCheckUser);

        if ($stmtCheckUser) {
            $stmtCheckUser->bind_param("s", $email);
            $stmtCheckUser->execute();
            $result = $stmtCheckUser->get_result();
            $stmtCheckUser->close();

            if ($result->num_rows === 1) {
                // Update the password for the existing user
                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $sqlUpdate = "UPDATE $tableName SET password = ?, status='verified' WHERE email = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);

                if ($stmtUpdate) {
                    $stmtUpdate->bind_param("ss", $passwordHash, $email);
                    $stmtUpdate->execute();
                    $stmtUpdate->close();

                    // Set session variable to indicate password update
                    $_SESSION['password_updated'] = true;
                } else {
                    $errors[] = "Error updating password: " . $conn->error;
                }
            } else {
                // Insert new user record
                $sqlInsertUser = "INSERT INTO $tableName (email, password, f_name, s_name, num) VALUES (?, ?, ?, ?, ?)";
                $stmtInsertUser = $conn->prepare($sqlInsertUser);

                if ($stmtInsertUser) {
                    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmtInsertUser->bind_param("sssss", $email, $passwordHash, $f_name, $s_name, $num);
                    $stmtInsertUser->execute();
                    $stmtInsertUser->close();

                    // Set session variable to indicate password update
                    $_SESSION['password_updated'] = true;
                } else {
                    $errors[] = "Error inserting new user: " . $conn->error;
                }
            }

            // Update the password for the user in the 'users' table
            $updateUserSql = "UPDATE users SET password = ? WHERE email = ?";
            $updateUserStmt = $conn->prepare($updateUserSql);

            if ($updateUserStmt) {
                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateUserStmt->bind_param("ss", $passwordHash, $email);
                $updateUserStmt->execute();
                $updateUserStmt->close();
            } else {
                $errors[] = "Error updating password in users table: " . $conn->error;
            }
        } else {
            $errors[] = "Error checking user: " . $conn->error;
        }
    }

    // If there are errors, store them in the session
    if (!empty($errors)) {
        $_SESSION['alerts'] = $errors;
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
        <?php if (isset($_SESSION['password_updated']) && $_SESSION['password_updated']) : ?>
            <p>Your password has been updated successfully. Confirm to log in!</p>
            <button onclick="confirmInquiry()">Okay</button>
        <?php else : ?>
            <?php foreach ($_SESSION['alerts'] as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
            <button onclick="handleButtonClick()">Close</button>
        <?php endif; ?>
    </div>
</div>

<script>
    function confirmInquiry() {
        // Destroy the session using JavaScript
        fetch('../logout.php') // Adjust the path accordingly
            .then(response => response.text())
            .then(() => {
                // Redirect to the login page
                window.location.href = '../data_page/login_page.php';
            });
    }

    function handleButtonClick() {
        // Hide the modal
        var modal = document.getElementById("confirmationModal");
        modal.style.display = "none";
        // Redirect to the password page
        window.location.href = '../data_page/password_page.php';
    }
</script>
</body>
</html>
