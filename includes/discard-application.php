<?php
require_once '../mysql/conn.php';

if (isset($_POST['discard_app'])) {
    $renter_user_id = $_POST['userid'];
    $adn = "DELETE FROM rental_options WHERE renter_user_id = ? LIMIT 1";
    $stmt = $mydb->getConnection()->prepare($adn);
    $stmt->bind_param('s', $renter_user_id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=../data_page/landowners_dashboard_5.php");
    } else {
        $err = "Try Again Later";
    }
}
?>