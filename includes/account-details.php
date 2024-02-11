<?php
require_once '../mysql/conn.php';
$userid = $_SESSION['tenant']['userid'];
$select_details ="SELECT * FROM tbl_renters_account where userid='$userid'";
$result_details = $conn->query($select_details);
    $udetails =mysqli_fetch_assoc($result_details);
?>