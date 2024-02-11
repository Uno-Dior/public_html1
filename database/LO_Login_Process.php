<?php
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        require_once '../database/database.php';

        $sql = "SELECT * FROM tbl_landowner_account WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);  
        $stmt->execute();
        $result = $stmt->get_result();
        $land = $result->fetch_assoc();
        $stmt->close();

        if ($land) { 
            if (password_verify($password, $land["password"])) {
                session_start();
               // Group the data in the session under 'land'
                $_SESSION['land'] = array($land);
                header("Location: ../data_page/landowners_dashboard.php");
                die();
            } else { 
                echo "<script>alert('Password does not match.'); window.location.href='../data_page/landowners_login.php';</script>";
            }
        } else {
            echo "<script>alert('Email does not exists.'); window.location.href='../data_page/landowners_login.php';</script>";
        }
    }
?>
