<?php
session_start();
// print_r($_GET);

require_once '../mysql/conn.php';
$mydb = new Database();

// Check if 'id' parameter is set in the URL
if (!isset($_GET['id'])) {
    // Redirect to a default page if 'id' is not provided
    header("Location: default_page.php");
    exit();
}

$id = $_GET['id'];

// Check if 'tenant' is set in the session and has the 'userid' key
if (isset($_SESSION['tenant']) && isset($_SESSION['tenant']['userid'])) {
    $tenantUserId = $_SESSION['tenant']['userid'];

    // Fetch data from the rental_options table for the specific item
    $fetchQuery = "SELECT hr.*, ro.id as rent_option_id
                   FROM house_rentals hr
                   JOIN rental_options ro ON hr.house_id = ro.house_id
                   WHERE ro.id = ?";
    $stmt = $mydb->getConnection()->prepare($fetchQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        $itemDetails = $result->fetch_assoc();

        // Check if the user has completed their personal data
        $userDataCheckQuery = "SELECT * FROM tbl_renters_account WHERE userid = ? AND (f_name IS NULL OR s_name IS NULL OR age IS NULL OR num IS NULL OR birthdate IS NULL OR citizenship IS NULL OR civil_status IS NULL OR gender IS NULL OR education_status IS NULL OR social_media_link IS NULL OR profile_img IS NULL)";
        $userDataCheckStmt = $mydb->getConnection()->prepare($userDataCheckQuery);
        $userDataCheckStmt->bind_param("i", $tenantUserId);
        $userDataCheckStmt->execute();
        $userDataCheckResult = $userDataCheckStmt->get_result();

        if ($userDataCheckResult->num_rows > 0) {
            // User has incomplete data, display an alert message
            echo "<script>
                    alert('Fill up the personal information first.');
                    window.location.href = '../data_page/renters_dashboard_3.php';
                  </script>";
        } else {
            // User has completed data, proceed with the application process

            // Check specific columns in tbl_renters_account before proceeding with the update
            $userDataQuery = "SELECT * FROM tbl_renters_account WHERE userid = ?";
            $userDataStmt = $mydb->getConnection()->prepare($userDataQuery);
            $userDataStmt->bind_param("i", $tenantUserId);
            $userDataStmt->execute();
            $userDataResult = $userDataStmt->get_result();

            // Assuming columns to check are 'f_name', 's_name', and 'birthdate'
            while ($row = $userDataResult->fetch_assoc()) {
                if (empty($row['f_name']) || empty($row['s_name']) || empty($row['birthdate'])) {
                    // Display an alert if any of the specified columns are empty
                    echo "<script>
                            alert('Fill up the required personal information first.');
                            window.location.href = '../data_page/renters_dashboard_3.php';
                          </script>";
                } else {
                    // Update the rental_options table to change the status column to Pending
                    $updateQuery = "UPDATE rental_options SET status = 'Pending' WHERE id = ?";
                    $updateStmt = $mydb->getConnection()->prepare($updateQuery);
                    $updateStmt->bind_param("i", $id);
                    $updateStmt->execute();
                }
            }

            $userDataStmt->close();
        }

        $userDataCheckStmt->close();
    } else {
        echo "<p>Item not found.</p>";
    }

    $stmt->close();

    // Close $updateStmt only if it's not null
    if ($updateStmt !== null) {
        $updateStmt->close();
    }

    $mydb->closeConnection();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Profile</title>
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <link rel="stylesheet" type="text/css" href="..\data_style\style-item.css">
    <script src="https://kit.fontawesome.com/4d86b94a8a.js" crossorigin="anonymous"></script>
</head>
<body>

<!-- Modal -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <?php if (isset($incompleteData) && $incompleteData): ?>
            <!-- Display modal informing user to complete personal data -->
            <p></p>
            <button onclick="redirectDashboard()">OK</button>
        <?php else: ?>
            <p>Are you sure you want to APPLY for this rental?</p>
            <button onclick="confirmInquiry()">Yes</button>
            <button onclick="closeModal()">No</button>
        <?php endif; ?>
    </div>
</div>

    <?php include 'navbar.php'; ?>

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="../data_page/renters_dashboard_3.php">Back</a></li>
                <li>House Details</li>
            </ol>
            <h2>View Prefered Rental House</h2>
        </div>
    </section>
    <!-- End Breadcrumbs -->

    <!-- ======= Items ======= -->
    <section class="items">
        <div class="item-container">
            <div class="wrapper">
                <div class="main-item">
                    <div class="image-area">
                        <img src='<?php echo $itemDetails['house_image']; ?>' alt='<?php echo $itemDetails['house_name']; ?>'>
                    </div>
                    <div class="details">
                        <h2><?php echo $itemDetails['house_name']; ?></h2>
                        <ul>
                            <li><strong style="margin-right: 10px;">LOCATION:</strong> <?php echo $itemDetails['location']; ?></li>
                            <li><strong style="margin-right: 46px;">PRICE:</strong> &#8369;<?php echo $itemDetails['rent_amount']; ?></li>
                            <li><strong style="margin-right: 54px;">TYPE:</strong> <?php echo $itemDetails['house_type']; ?></li>
                            <li><strong style="margin-right: 1px;">SPACE FOR:</strong> <?php echo $itemDetails['space_for']; ?></li>
                            <li><strong style="margin-right: 54px;">BEDS:</strong> <?php echo $itemDetails['number_of_beds']; ?></li>
                            <li><strong style="margin-right: 38px;">COMFORT<br> ROOMS:</strong> <?php echo $itemDetails['number_of_beds']; ?></li>
                            <li><strong style="margin-right: 0px;">AMENITIES:</strong><br><br>
                                <?php
                                    $amenities = $itemDetails['amenities'];

                                    // Check if the value is a string
                                    if (is_string($amenities)) {
                                        // Split the string into an array using the comma as the delimiter
                                        $termsArray = explode(', ', $amenities);

                                        // Loop through the array and display each term
                                        foreach ($termsArray as $term) {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-check" style="margin-right: 15px;"></i>' . htmlspecialchars($term) . '<br>';
                                        }
                                    } else {
                                        echo 'Payment terms not available or invalid format.';
                                    }
                                ?>
                            </li>
                            <li><strong style="margin-right: 0px;">PAYMENT TERMS:</strong><br><br>
                                <?php
                                    $paymentTerms = $itemDetails['payment_terms'];

                                    // Check if the value is a string
                                    if (is_string($paymentTerms)) {
                                        // Split the string into an array using the comma as the delimiter
                                        $termsArray = explode(', ', $paymentTerms);

                                        // Loop through the array and display each term
                                        foreach ($termsArray as $term) {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-money-bill" style="margin-right: 15px;"></i>' . htmlspecialchars($term) . '<br>';
                                        }
                                    } else {
                                        echo 'Payment terms not available or invalid format.';
                                    }
                                ?>
                            </li>
                            <li><strong style="margin-right: 0px;">DESCRIPTION:</strong><br><br>
                            &nbsp&nbsp&nbsp&nbsp&nbsp</i><?php echo $itemDetails['description']; ?>
                            </li>
                        </ul>
                        
                        <!-- Rental option form -->
                        <div class="btn-foritems">
                            <button class="btn_apply" onclick="openModal()">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======= End of Items ======= -->

<script>
    function openModal() {
        // Extract the 'id' parameter from the URL and pass it to checkUserData()
        var urlParams = new URLSearchParams(window.location.search);
        var rentOptionId = urlParams.get('id');
    
        // Check if 'id' is present in the URL
        if (!rentOptionId) {
            console.error('Error: ID not found in the URL');
            return;
        }
    
        console.log('rentOptionId in openModal:', rentOptionId); // Add this line
    
        var modal = document.getElementById('confirmationModal');
        modal.style.display = 'flex';
    
        checkUserData(rentOptionId);
    }

    function closeModal() {
        var modal = document.getElementById('confirmationModal');
        modal.style.display = 'none';
    }
    
     function confirmInquiry() {
        // Extract the 'id' parameter from the URL
        var urlParams = new URLSearchParams(window.location.search);
        var rentOptionId = urlParams.get('id');
    
        // Check if 'id' is present in the URL
        if (!rentOptionId) {
            console.error('Error: ID not found in the URL');
            return;
        }
    
        console.log('Rent Option ID:', rentOptionId);  // Add this line
    
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();
    
        // Set up the request
        xhr.open('POST', 'rent_house.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
        // Define what happens on successful data submission
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Parse the response from the server
                var response = JSON.parse(xhr.responseText);
    
                // Check if the inquiry was confirmed successfully
                if (response.success) {
                    // Display a success message
                    alert('Application Confirmed!');
    
                    // Close the modal after confirming
                    closeModal();
    
                    // Redirect to the confirmation page with necessary data
                    window.location.href = '../data_page/renters_dashboard_3.php?rent_option_id=' + encodeURIComponent(rentOptionId);
                } else {
                    // Display an error message
                    alert('Error confirming inquiry: ' + response.message);
                }
            }
        };
    
        // Get the data from the form (if needed) and send it to the server
        var formData = 'rent_option_id=' + encodeURIComponent(rentOptionId);
        xhr.send(formData);
    }


    /// Function to check user data and update modal content
    function checkUserData(rentOptionId) {
        var modalContent = document.querySelector('.modal-content p');

        // Assuming you have a variable incompleteData containing the user data check result
        var incompleteData = <?php echo json_encode($incompleteData ?? false); ?>;

        if (incompleteData) {
            // User has incomplete data
            modalContent.innerHTML = 'Please make sure that you have completed your Profile Details:<br>Profile Picture<br>Personal Information<br>Parent\'s Details';
        } else {
            // User has completed data
            modalContent.innerHTML = 'Are you sure you want to APPLY for this rental?';
        }

        // You can use rentOptionId in your logic here if needed
    }
</script>



<script>
    function redirectDashboard() {
        window.location.href = '../data_page/renters_dashboard_3.php';
    }
</script>


</body>
</html>
