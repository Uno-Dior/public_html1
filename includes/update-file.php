<?php
require '../database/database.php';
if (isset($_POST['updatefile'])) {
    $userid = $_POST['userid'];
    $file_name = $_POST['file_name'];
    $file_status = $_POST['file_status'];
    if ($file_status == 'Reject') {
        $reason = $_POST['reason'];
    } else {
        $reason = '';
    }
    $update_file = "UPDATE tenants_file set file_status='$file_status',remarks='$reason' where file_name='$file_name'";
    if ($conn->query($update_file) === TRUE) {
        header('location:../data_page/view-user.php?userid=' . $userid . '&approval=success');
    }
}
?>