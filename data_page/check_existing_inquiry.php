<?php
// check_existing_inquiry.php

require_once '../mysql/conn.php';

$mydb = new Database();

$response = array(); // Initialize a response array

if (isset($_GET['house_id']) && isset($_GET['renter_user_id'])) {
    $houseId = $_GET['house_id'];
    $renterUserId = $_GET['renter_user_id'];

    // Check if an existing inquiry exists for the specified house_id and renter_user_id
    $checkQuery = "SELECT COUNT(*) AS count FROM rental_options WHERE house_id = ? AND renter_user_id = ?";
    $stmt = $mydb->getConnection()->prepare($checkQuery);
    $stmt->bind_param("ii", $houseId, $renterUserId);

    if ($stmt->execute()) {
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // Return the result as JSON
        $response['exists'] = ($count > 0);
    } else {
        // Error checking existing inquiry
        $response['exists'] = false;
        $response['message'] = 'Error checking existing inquiry: ' . $stmt->error;
    }
} else {
    // Invalid request, house_id or renter_user_id not set
    $response['exists'] = false;
    $response['message'] = 'Invalid request. House ID or renter user ID not set.';
}

$mydb->closeConnection();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
