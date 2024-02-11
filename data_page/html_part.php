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
<button onclick="confirmInquiry(<?php echo $itemDetails['rent_option_id']; ?>)">Yes</button>
            <button onclick="closeModal()">No</button>
        <?php endif; ?>
    </div>
</div>

<!-- Breadcrumbs -->
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">
        <ol>
            <li><a href="../data_page/renters_dashboard_3.php">Back</a></li>
            <li>House Details</li>
        </ol>
        <h2>View Preferred Rental House</h2>
    </div>
</section>
<!-- End Breadcrumbs -->

<!-- Items -->
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
                    <div class="btn-inquire">
<button onclick="openModal()" data-rent-option-id="<?php echo $itemDetails['rent_option_id']; ?>">Apply</button>
                        <!-- Additional form fields can be added as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Items -->

<script>
    function openModal() {
        var modal = $('#confirmationModal');
        modal.css('display', 'flex');

        // Retrieve the rent_option_id from the button's data attribute
        var rentOptionId = $('.btn-inquire button').data('rent-option-id');

        // Check if 'rentOptionId' is present
        if (!rentOptionId) {
            console.error('Error: rent_option_id not found');
            return;
        }

        console.log('rentOptionId in openModal:', rentOptionId);

        // Pass rentOptionId to checkUserData()
        checkUserData(rentOptionId);
    }

    function closeModal() {
        var modal = $('#confirmationModal');
        modal.css('display', 'none');
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

        console.log('Rent Option ID:', rentOptionId);

        // For testing purposes, alert the 'id' before proceeding
        // alert('Rent Option ID: ' + rentOptionId);

        // Create a new FormData object and append the 'id' parameter
        var formData = new FormData();
        formData.append('id', rentOptionId);

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('POST', 'rent_house.php', true);

        // Define what happens on successful data submission
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Parse the response from the server
                var response = JSON.parse(xhr.responseText);

                // Check if the inquiry was confirmed successfully
                if (response.success) {
                    // Display a success message
                    alert('Inquiry confirmed!');

                    // Close the modal after confirming
                    closeModal();

                    // Redirect to the confirmation page with necessary data
                    window.location.href = '../data_page/renters_dashboard_3.php?rent_option_id=' + encodeURIComponent(rentOptionId);
                } else {
                    // Display an error message
                    alert('!' + response.message);
                    window.location.href = '../data_page/renters_dashboard_3.php';
                }
            }
        };

        // Send the FormData object to the server
        xhr.send(formData);
    }

    /// Function to check user data and update modal content
    function checkUserData(rentOptionId) {
        var modalContent = $('.modal-content p');

        // Assuming you have a variable incompleteData containing the user data check result
        var incompleteData = <?php echo json_encode($incompleteData ?? false); ?>;

        if (incompleteData) {
            // User has incomplete data
            modalContent.html('Please make sure that you have completed your Profile Details:<br>Profile Picture<br>Personal Information<br>Parent\'s Details');
        } else {
            // User has completed data
            modalContent.html('Are you sure you want to APPLY for this rental?');
        }

        // Display the modal
        openModal();
    }

    function redirectDashboard() {
        window.location.href = '../data_page/renters_dashboard_3.php';
    }
</script>

</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</body>
</html>
