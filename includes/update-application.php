<?php
session_start();
require '../database/database.php';

if (isset($_POST['update_app'])) {
    $renter_user_id = $_POST['userid'];
    $appstatus = $_POST['application_status'];

    // Set default value for reason
    $reason = '';

    if ($appstatus == 'rejected') {
        // If the status is rejected, retrieve the reason
        $reason = $_POST['reason'];
    }

    // Update the application status directly
    $update_file = "UPDATE rental_options SET status='$appstatus' WHERE renter_user_id='$renter_user_id' AND status = 'Pending' LIMIT 1";
    if ($conn->query($update_file) === TRUE) {
        header('location:../data_page/landowners_dashboard_2.php'); // Redirect to Landowners_Dashboard_2.php after approval
        exit(); // Stop execution after redirect
    }

} 
?>
