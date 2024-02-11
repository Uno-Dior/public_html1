<?php
    if (isset($_POST['Login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        require_once '../database/database.php';

        $sql = "SELECT * FROM tbl_renters_account WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $tenants = $result->fetch_assoc();
        $stmt->close();

        if ($tenants) {
            if (password_verify($password, $tenants["password"])) {
                session_start();
                // Group the data in the session under 'tenant'
                $_SESSION['tenant'] = array($tenants);
                header("Location: ../data_page/renters_dashboard_1.php");
                die();
            } else { 
                echo "<script>alert('Password does not match.'); window.location.href='../data_page/renters_login.php';</script>";
            }
        } else {
            echo "<script>alert('Email does not exists.'); window.location.href='../data_page/renters_login.php';</script>";
        }
    }
?>