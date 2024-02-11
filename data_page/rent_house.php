<?php

require_once '../mysql/conn.php';

$mydb = new Database();

// Assuming that the renter's userid is stored in the session
session_start();

$response = array(); // Initialize a response array

// Check if 'tenant' is set in the session and has the 'userid' key
if (isset($_SESSION['tenant']) && isset($_SESSION['tenant']['userid'])) {
    $renterUserId = $_SESSION['tenant']['userid'];
} else {
    // Redirect to a login page or handle the session absence
    $response['success'] = false;
    $response['message'] = 'Session error: Renter userid not found.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Check if 'rent_option_id' is set in the POST parameters
if (isset($_POST['rent_option_id'])) {
    $rentOptionId = $_POST['rent_option_id'];

    // Fetch owner details from rental_options table
    $ownerQuery = "SELECT owner_user_id FROM rental_options WHERE id = ?";
    $stmtOwner = $mydb->getConnection()->prepare($ownerQuery);
    $stmtOwner->bind_param("i", $rentOptionId);

    if ($stmtOwner->execute()) {
        $stmtOwner->bind_result($landownerUserId);
        $stmtOwner->fetch();
        $stmtOwner->close();

        if ($landownerUserId !== null) {
            // Fetch renter details from tbl_renters_account using the renter's userid from the session
            $renterQuery = "SELECT userid, f_name, s_name FROM tbl_renters_account WHERE userid = ?";
            $stmtRenter = $mydb->getConnection()->prepare($renterQuery);
            $stmtRenter->bind_param("i", $renterUserId);
            $stmtRenter->execute();
            $stmtRenter->bind_result($renterUserId, $renterFirstName, $renterLastName);
            $stmtRenter->fetch();
            $stmtRenter->close();

            // Insert rental option into the rental_options table
            $insertQuery = "UPDATE rental_options SET status = 'Pending' WHERE id = ?";
            $stmt = $mydb->getConnection()->prepare($insertQuery);
            $stmt->bind_param("i", $rentOptionId);

            if ($stmt->execute()) {
                // Inquiry confirmed successfully
                $response['success'] = true;
                $response['message'] = 'Rent option confirmed!';
            } else {
                // Error confirming rent option
                $response['success'] = false;
                $response['message'] = 'Error confirming rent option: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            // Invalid rent_option_id
            $response['success'] = false;
            $response['message'] = 'Invalid rent_option_id!';
        }
    } else {
        // Error fetching owner details
        $response['success'] = false;
        $response['message'] = 'Error fetching owner details: ' . $stmtOwner->error;
    }
} else {
    // Invalid request, rent_option_id not set
    $response['success'] = false;
    $response['message'] = 'Success';
}

$mydb->closeConnection();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
