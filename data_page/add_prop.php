<?php
// Include the database.php file
require_once '../mysql/conn.php';

// Start the session
session_start();

if (empty($_SESSION["land"])) {
    header("Location: ../data_page/landowners_login.php");
    exit();
 }

// Initialize the Database class
$mydb = new Database();

// Create tables if they don't exist
$createDormTableQuery = "CREATE TABLE IF NOT EXISTS dorms LIKE house_rentals";
$createApartmentTableQuery = "CREATE TABLE IF NOT EXISTS apartments LIKE house_rentals";

$mydb->getConnection()->query($createDormTableQuery);
$mydb->getConnection()->query($createApartmentTableQuery);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $houseName = mysqli_real_escape_string($mydb->getConnection(), $_POST['house_name']);
    $rentAmount = mysqli_real_escape_string($mydb->getConnection(), $_POST['rent_amount']);
    $location = mysqli_real_escape_string($mydb->getConnection(), $_POST['location']);
    
    // Retrieve landowner_userid from the session
    $landowner_userid = $_SESSION['land']['userid']; // Assuming the landowner userid is stored in the session

    // Handle image upload
    $targetDir = "../data_image/rental_houses/";  // Change this to the directory where you want to store the images
    $targetFile = $targetDir . basename($_FILES["house_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["house_image"]["tmp_name"]);
    if ($check !== false) {
        // File is an image
        $uploadOk = 1;
    } else {
        // File is not an image
        $uploadOk = 0;
        echo '<script>alert("File is not an image.");</script>';
    }

    // Check if file already exists
    $imageFileName = basename($_FILES["house_image"]["name"]);
    $uniqueFileName = time() . '_' . $imageFileName;
    $targetFile = $targetDir . $uniqueFileName;

    // Check file existence and generate a unique name
    while (file_exists($targetFile)) {
        $uniqueFileName = time() . '_' . $imageFileName;
        $targetFile = $targetDir . $uniqueFileName;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo '<script>alert("Sorry, your file was not uploaded.");</script>';
    } else {
        if (move_uploaded_file($_FILES["house_image"]["tmp_name"], $targetFile)) {
            // File has been uploaded successfully
            echo '<script>alert("The file ' . $uniqueFileName . ' has been uploaded.");</script>';
        } else {
            echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
        }
    }

    // Perform database insertion if image upload is successful
    if ($uploadOk == 1) {
        // Retrieve and sanitize the values of new inputs
        $description = mysqli_real_escape_string($mydb->getConnection(), $_POST['description']);
        $houseType = mysqli_real_escape_string($mydb->getConnection(), $_POST['house_type']);
        $numberOfBeds = mysqli_real_escape_string($mydb->getConnection(), $_POST['number_of_beds']);
        $availability = mysqli_real_escape_string($mydb->getConnection(), $_POST['availability']);
        $amenities = implode(', ', $_POST['amenities']); // Assuming amenities is an array
        $spaceFor = mysqli_real_escape_string($mydb->getConnection(), $_POST['space_for']);
        $cr = mysqli_real_escape_string($mydb->getConnection(), $_POST['cr']);
        $paymentTerms = implode(', ', $_POST['payment_terms']); // Assuming payment_terms is an array

        // Perform database insertion
        $mydb->setQuery("INSERT INTO house_rentals (house_name, rent_amount, location, landowner_userid, house_image, description, house_type, number_of_beds, availability, amenities, space_for, cr, payment_terms) VALUES ('$houseName', '$rentAmount', '$location', '$landowner_userid', '$targetFile', '$description', '$houseType', '$numberOfBeds', '$availability', '$amenities', '$spaceFor', '$cr', '$paymentTerms')");
        $mydb->executeQuery();

        // Check house_type and insert into the corresponding table
        if ($houseType == 'Dorm') {
            $mydb->setQuery("INSERT INTO dorms (house_name, rent_amount, location, landowner_userid, house_image, description, house_type, number_of_beds, availability, amenities, space_for, cr, payment_terms) VALUES ('$houseName', '$rentAmount', '$location', '$landowner_userid', '$targetFile', '$description', '$houseType', '$numberOfBeds', '$availability', '$amenities', '$spaceFor', '$cr', '$paymentTerms')");
            $mydb->executeQuery();
        } elseif ($houseType == 'Apartment') {
            $mydb->setQuery("INSERT INTO apartments (house_name, rent_amount, location, landowner_userid, house_image, description, house_type, number_of_beds, availability, amenities, space_for, cr, payment_terms) VALUES ('$houseName', '$rentAmount', '$location', '$landowner_userid', '$targetFile', '$description', '$houseType', '$numberOfBeds', '$availability', '$amenities', '$spaceFor', '$cr', '$paymentTerms')");
            $mydb->executeQuery();
        }

        // Redirect to the same page or another page
        echo '<script>window.location.href = "landowners_dashboard_4.php";</script>';
        // You can add further logic, such as redirecting to another page or displaying a success message.
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <link rel="stylesheet" type="text/css" href="..\data_style\styles-dashboard1.css">   
    <!-- Vendor CSS Files -->
    <link href="../data_style/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../data_styleassets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../data_style/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard_sidebar">
        <div>
            <a href="..\data_page\ResiHive.php"><img src="..\data_image\LOGO.png" class="logo" alt="logo"></a>
        </div><hr>  
        <div class="dash1">
            <ul>
                <li style="margin: 10px 0 10px 0"><a href="..\data_page\landowners_dashboard.php">Dashboard</a></li>
            </ul>
        </div><hr>
        <div class="dash1">
            <h6>My Properties</h6>
            <ul>
                <li><a href="..\data_page\landowners_dashboard_2.php">Manage Inquiries</a></li>
                <!-- <li class="active"><a href="..\data_page\Landowners_Dashboard_3.php">Visit Schedules</a></li> -->
                <li class="active"><a href="..\data_page\landowners_dashboard_4.php">Manage Properties</a></li>
            </ul>
        </div><hr>
        <div class="dash1">
            <h6>My Tenants</h6>
            <ul>
                <li><a href="..\data_page\landowners_dashboard_5.php">Manage Tenants</a></li>
                <li><a href="..\data_page\landowners_dashboard_6.php">Monthly Reports</a></li>            
            </ul><hr>
        </div>
        <div class="dash1">
            <ul>
                <li><a href="..\logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="header-wrap">
            <div class="header-title">
                <ol>
                    <li><a href="../data_page/landowners_dashboard.php">Dashboard</a></li>
                    <li><a href="../data_page/landowners_dashboard_4.php">Manage Properties</a></li>
                    <li>Add Rental House</li>
                </ol>
                <h2>Manage Properties</h2>
            </div>
        </div>
        <div class="data_properties">
            <div class="properties">
                <h3>Add Rental House</h3>
                <!-- Rental House Form -->
                <form action="add_prop.php" method="POST" enctype="multipart/form-data">
                    <label for="house_name">House Name:</label>
                    <input type="text" name="house_name" placeholder="House#1" required>

                    <label for="rent_amount">Rent Amount:</label>
                    <input type="number" name="rent_amount" placeholder="1000.00" required>

                    <label for="location">Location:</label>
                    <input type="text" name="location" placeholder="Brgy. Bubukal" required>

                    <!-- New input for image -->
                    <label for="house_image">Insert Image:</label>
                    <input type="file" name="house_image" accept="image/*" required>

                    <!-- New input for description -->
                    <label for="description">Description:</label>
                    <textarea name="description" rows="4" placeholder="Describe house description..." required></textarea>

                    <!-- New input for house type (Dorm) -->
                    <label for="house_type">House Type:</label>
                    <select name="house_type" placeholder="Please select a type" required>
                        <option value="Dorm">Dorm</option>
                        <option value="Apartment">Apartment</option>
                    </select>

                    <!-- New input for number of beds -->
                    <label for="number_of_beds">Number of Beds/Rooms Available:</label>
                    <input type="number" name="number_of_beds" placeholder="Number of beds/rooms" required><br><br>
                    
                    <label for="availability">Space/s Available:</label>
                    <input type="number" name="availability" placeholder="Input Space/s Available" required><br><br>

                    <div style="display: flex; flex-direction: row; justify-content: space-around">
                        <!-- New input for amenities -->
                        <div>
                            <label>Amenities:</label><br>
                            <input style="margin-left: 30px;" type="checkbox" name="amenities[]" value="Parking"> Parking<br>
                            <input style="margin-left: 30px;" type="checkbox" name="amenities[]" value="WiFi"> Wifi/Internet<br>
                            <input style="margin-left: 30px;" type="checkbox" name="amenities[]" value="Canteen"> Canteen
                        </div>

                        <!-- New input for space -->
                        <div style="margin-top: 0;">
                            <label>Space for:</label><br>
                            <input style="margin-left: 30px;" type="radio" name="space_for" value="Male" required> Male only<br>
                            <input style="margin-left: 30px;" type="radio" name="space_for" value="Female" required> Female only<br>
                            <input style="margin-left: 30px;" type="radio" name="space_for" value="Mixed" required> Mixed
                        </div>
                    </div>

                    <!-- New input for CR -->
                    <label>Number of Comfort Rooms:</label>
                    <input type="number" name="cr" required>

                    <!-- New input for payment terms -->
                    <label>Payment Terms:</label>
                    <div style="padding-left: 20px;">
                        <input type="checkbox" name="payment_terms[]" value="Advance Payment"> Advance Payments<br>
                        <input type="checkbox" name="payment_terms[]" value="Security Payment Deposit"> Security Payment Deposit
                    </div>

                    <div style="display: flex; width: 100%; justify-content: center;">
                        <button type="submit">Add Rental House</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
</body>
</html>