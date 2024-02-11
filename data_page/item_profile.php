<?php
session_start(); // Start the session
// print_r($_SESSION);
require_once '../mysql/conn.php';
$mydb = new Database();

// Check if 'id' parameter is set in the URL
if (!isset($_GET['id'])) {
    // Redirect to a default page if 'id' is not provided
    header("Location: default_page.php");
    exit();
}

$houseId = $_GET['id'];

// Check if 'tenant' is set in the session and has the 'userid' key
if (isset($_SESSION['tenant']) && isset($_SESSION['tenant']['userid'])) {
    $tenantUserId = $_SESSION['tenant']['userid'];

    // Fetch data from the rental_houses table for the specific item
    $fetchQuery = "SELECT * FROM house_rentals WHERE house_id = ?";
    $stmt = $mydb->getConnection()->prepare($fetchQuery);
    $stmt->bind_param("i", $houseId);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Redirect to a login page or handle the session absence
    header("Location: ../data_page/signup_page.php");
    exit();
}

// Check if there are rows returned
if ($result->num_rows > 0) {
    $itemDetails = $result->fetch_assoc();

    // Close PHP tag to start HTML
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
            <p>Are you sure you want to inquire about this rental?</p>
            <button onclick="confirmInquiry()">Yes</button>
            <button onclick="closeModal()">No</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="WarningModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>You have already inquired in this rental.</p>
            <button onclick="checkExistingInquiryRedirect()">Check</button>
            <button onclick="closeModal()">Okay</button>
        </div>
    </div>

    <?php include 'navbar.php'; ?>


    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="../data_page/renters_dashboard_1.php">Home</a></li>
                <li>House Details</li>
            </ol>
            <h2>Rental House Details</h2>
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
                            <button class="btn_inquire" onclick="openModal()">Inquire</button>
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
        var modal = document.getElementById('confirmationModal');
        modal.style.display = 'flex';

        // Assuming you have a variable houseId containing the house ID
        var houseId = <?php echo json_encode($houseId); ?>;
        var tenantUserId = <?php echo json_encode($tenantUserId); ?>;

        // Check if the user has already inquired about this house
        checkExistingInquiry(houseId, tenantUserId)
            .then(function (hasInquired) {
                if (hasInquired) {
                    // Display the WarningModal
                    var warningModal = document.getElementById('WarningModal');
                    if (!warningModal.style.display || warningModal.style.display === 'none') {
                        warningModal.style.display = 'flex';
                    }
                }
            });
    }

    function closeModal() {
        var modal = document.getElementById('confirmationModal');
        modal.style.display = 'none';

        var warningModal = document.getElementById('WarningModal');
        warningModal.style.display = 'none';
    }

    function checkExistingInquiryRedirect() {
        var houseId = <?php echo json_encode($houseId); ?>;
        var tenantUserId = <?php echo json_encode($tenantUserId); ?>;

        // Redirect to renters_dashboard.php with necessary data
        window.location.href = '../data_page/renters_dashboard_2.php?house_id=' + encodeURIComponent(houseId) + '&tenant_user_id=' + encodeURIComponent(tenantUserId);
    }

    function confirmInquiry() {
        // Assuming you have a variable houseId containing the house ID
        var houseId = <?php echo json_encode($houseId); ?>;

        // Check if the user has already inquired about this house
        checkExistingInquiry(houseId, <?php echo json_encode($tenantUserId); ?>)
            .then(function (hasInquired) {
                if (hasInquired) {
                    // Display the WarningModal
                    var warningModal = document.getElementById('WarningModal');
                    if (!warningModal.style.display || warningModal.style.display === 'none') {
                        warningModal.style.display = 'flex';
                    }
                } else {
                    // Proceed with the inquiry
                    sendInquiry(houseId);
                }
            });
    }

    function checkExistingInquiry(houseId, tenantUserId) {
        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();

            xhr.open('GET', 'check_existing_inquiry.php?house_id=' + encodeURIComponent(houseId) + '&renter_user_id=' + encodeURIComponent(tenantUserId), true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    resolve(response.exists);
                } else {
                    reject('Error checking existing inquiry: ' + xhr.statusText);
                }
            };

            xhr.onerror = function () {
                reject('Network error');
            };

            xhr.send();
        });
    }

    function sendInquiry(houseId) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('POST', 'inquire_house.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Define what happens on successful data submission
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Parse the response from the server
                var response = JSON.parse(xhr.responseText);

                // Check if the inquiry was confirmed successfully
                if (response.success) {
                    // Display a success message
                    alert('Inquiry confirmed!');
                    closeModal(); // Close the modal after confirming

                    // Redirect to the confirmation page with necessary data
                    window.location.href = '../data_page/renters_dashboard_2.php?house_id=' + encodeURIComponent(houseId);
                } else {
                    // Display an error message
                    alert('Error confirming inquiry: ' + response.message);
                }
            }
        };

        // Get the data from the form (if needed) and send it to the server
        var formData = 'house_id=' + encodeURIComponent(houseId);
        xhr.send(formData);
    }
</script>


<!-- <script>
    function openModal() {
        var modal = document.getElementById('confirmationModal');
        modal.style.display = 'flex';
    }

    function closeModal() {
        var modal = document.getElementById('confirmationModal');
        modal.style.display = 'none';
    }

    function confirmInquiry() {
        // Assuming you have a variable houseId containing the house ID
        var houseId = <?php echo json_encode($houseId); ?>;
    
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();
    
        // Set up the request
        xhr.open('POST', 'inquire_house.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
        // Define what happens on successful data submission
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Parse the response from the server
                var response = JSON.parse(xhr.responseText);
    
                // Check if the inquiry was confirmed successfully
                if (response.success) {
                    // Display a success message
                    alert('Inquiry confirmed!');
                    closeModal(); // Close the modal after confirming
    
                    // Redirect to the confirmation page with necessary data
                    window.location.href = '../data_page/renters_dashboard_2.php?house_id=' + encodeURIComponent(houseId);
                } else {
                    // Display an error message
                    alert('Error confirming inquiry: ' + response.message);
                }
            }
        };
    
        // Get the data from the form (if needed) and send it to the server
        var formData = 'house_id=' + encodeURIComponent(houseId);
        xhr.send(formData);
    }
</script> -->


    </body>
    </html>

    <?php
} else {
    echo "<p>Item not found.</p>";
}

$stmt->close();
$mydb->closeConnection();
?>
