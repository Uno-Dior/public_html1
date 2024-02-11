<?php

require_once '../mysql/conn.php';

$mydb = new Database();

// Assuming that the renter's userid is stored in the session
session_start();

// Check if 'tenant' is set in the session and has the 'userid' key
if (isset($_SESSION['tenant']) && isset($_SESSION['tenant']['userid'])) {
    $renterUserId = $_SESSION['tenant']['userid'];
} else {
    // Redirect to a login page or handle the session absence
    header("Location: ../data_page/renters_login.php");
    exit();
}

$response = array(); // Initialize a response array

if (isset($_POST['house_id'])) {
    // Get data from the form
    $houseId = $_POST['house_id'];

    // Fetch owner details from house_rentals table
    $ownerQuery = "SELECT landowner_userid FROM house_rentals WHERE house_id = ?";
    $stmtOwner = $mydb->getConnection()->prepare($ownerQuery);
    $stmtOwner->bind_param("i", $houseId);

    if ($stmtOwner->execute()) {
        $stmtOwner->bind_result($landownerUserId);
        $stmtOwner->fetch();
        $stmtOwner->close();

        if ($landownerUserId !== null) {
            // Fetch owner_user_id from tbl_landowner_account
            $ownerUserIdQuery = "SELECT userid FROM tbl_landowner_account WHERE userid = ?";
            $stmtOwnerUserId = $mydb->getConnection()->prepare($ownerUserIdQuery);
            $stmtOwnerUserId->bind_param("i", $landownerUserId);
            $stmtOwnerUserId->execute();
            $stmtOwnerUserId->bind_result($ownerUserId);
            $stmtOwnerUserId->fetch();
            $stmtOwnerUserId->close();

            // Fetch renter details from tbl_renters_account using the renter's userid from the session
            $renterQuery = "SELECT userid, f_name, s_name FROM tbl_renters_account WHERE userid = ?";
            $stmtRenter = $mydb->getConnection()->prepare($renterQuery);
            $stmtRenter->bind_param("i", $renterUserId);
            $stmtRenter->execute();
            $stmtRenter->bind_result($renterUserId, $renterFirstName, $renterLastName);
            $stmtRenter->fetch();
            $stmtRenter->close();

            // Insert rental option into the rental_options table
            $insertQuery = "INSERT INTO rental_options (house_id, owner_user_id, renter_user_id, renter_first_name, renter_last_name, status) VALUES (?, ?, ?, ?, ?, 'Inquired')";
            $stmt = $mydb->getConnection()->prepare($insertQuery);
            $stmt->bind_param("iiiss", $houseId, $ownerUserId, $renterUserId, $renterFirstName, $renterLastName);

            if ($stmt->execute()) {
                // Insert inquiry details into the chat_users table
                $chatInsertQuery = "INSERT INTO chat_users (user_id, house_id, owner_user_id) VALUES (?, ?, ?)";
                $stmtChatInsert = $mydb->getConnection()->prepare($chatInsertQuery);
                $stmtChatInsert->bind_param("iii", $renterUserId, $houseId, $ownerUserId);
                $stmtChatInsert->execute();
                $stmtChatInsert->close();

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
            // Invalid house ID
            $response['success'] = false;
            $response['message'] = 'Invalid house ID!';
        }
    } else {
        // Error fetching owner details
        $response['success'] = false;
        $response['message'] = 'Error fetching owner details: ' . $stmtOwner->error;
    }
} else {
    // Invalid request, house_id not set
    $response['success'] = false;
    $response['message'] = 'Invalid request. House ID not set.';
}

$mydb->closeConnection();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
