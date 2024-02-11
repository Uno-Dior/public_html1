<?php
include_once "../mysql/conn.php"; // Adjust the path as needed

if (isset($_GET['house_id'])) {
    $houseId = $_GET['house_id'];

    // Fetch house details from house_rentals table
    $sql = mysqli_query($conn, "SELECT house_name, house_image, house_type FROM house_rentals WHERE house_id = '$houseId'");

    if ($sql && mysqli_num_rows($sql) > 0) {
        $houseDetails = mysqli_fetch_assoc($sql);

        // Return the house details as JSON
        echo json_encode($houseDetails);
    } else {
        // Handle the case where no rows are returned
        echo json_encode(array('error' => 'House details not found'));
    }
} else {
    // Handle the case where house_id is not provided
    echo json_encode(array('error' => 'house_id parameter missing'));
}
?>
