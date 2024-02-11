<?php
session_start();
require_once '../mysql/conn.php';

$userid = $_SESSION['tenant']['userid'];

if (isset($_POST['uploading'])) {
    // Define the upload directory
    $upload_dir = '../data_style/assets/profile/'; // Change this to your desired directory

    // Create the directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate a unique file name to avoid overwriting
    $file_name = uniqid() . '_' . $_FILES['profile_image']['name'];
    $target_path = $upload_dir . $file_name;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path)) {
        // Insert the file path or binary data into your database
        $image_path = $target_path; // Change this to the appropriate column name in your database

        // Perform the database insert operation here
        // Replace 'your_database_table' with your actual table name
        $sql = "UPDATE tbl_renters_account SET profile_img = '$file_name' WHERE userid ='$userid'"; // Assuming you have a user ID to associate with the image
        // Execute the SQL statement using prepared statements
        $result = $conn->query($sql);


        // Redirect or display a success message
        header('Location:../data_page/renters_dashboard_3.php'); // Redirect to a profile page or wherever you need to go
        exit();
    } else {
        // Handle the file upload error
        echo 'Error uploading the image.';
    }
}
?>