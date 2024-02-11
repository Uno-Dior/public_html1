<?php
session_start();
require_once '../mysql/conn.php';
// print_r($_SESSION);

// Check if the user is already logged in
if (empty($_SESSION["tenant"])) {
    header("Location: ../data_page/renters_login.php");
    exit();
 }

$mydb = new Database();

// Get distinct rent_amount values from house_rentals in descending order
$amountOptionsQuery = "SELECT DISTINCT rent_amount FROM house_rentals ORDER BY rent_amount ASC";
$amountOptionsResult = $mydb->getConnection()->query($amountOptionsQuery);

// Default values for min and max amounts
$defaultMinAmount = $amountOptionsResult->num_rows > 0 ? $amountOptionsResult->fetch_assoc()['rent_amount'] : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResiHive - Renters</title>
    <link rel="icon" type="image/x-icon" href="../data_image/favicon.png">
    <link rel="stylesheet" type="text/css" href="../data_style/styles-renters.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="bg_icons">
        <div class="hive_icon"></div>
        <div class="hexagon_icon"></div>
        <div class="sphere_icon"></div>
        <div class="comb_icon"></div>
    </div>

    <section>
        <div class="cont_rentals">
            <div class="switch-container">
                <button class="switch-button active" data-house-type="All" onclick="filterRentals('All')">All</button>
                <button class="switch-button" data-house-type="Dorm" onclick="filterRentals('Dorm')">Dorms</button>
                <button class="switch-button" data-house-type="Apartment" onclick="filterRentals('Apartment')">Apartments</button>
            </div>
            <h2>Featured Rentals</h2>
            <div class="filter-container">
                <label for="amountRange">Amount Range: </label>
                <div class="filter-dropdown">
                    <select id="minAmount" class="minAmount" placeholder="Minimum">
                        <?php
                        $amountOptionsResult->data_seek(0);
                        while ($row = $amountOptionsResult->fetch_assoc()) {
                            echo "<option value='{$row['rent_amount']}'>{$row['rent_amount']}</option>";
                        }
                        ?>
                    </select>
                    <select id="maxAmount" class="maxAmount" placeholder="Maximum">
                        <?php
                        $amountOptionsQuery = "SELECT DISTINCT rent_amount FROM house_rentals ORDER BY rent_amount DESC";
                        $amountOptionsResult = $mydb->getConnection()->query($amountOptionsQuery);

                        $amountOptionsResult->data_seek(0);
                        while ($row = $amountOptionsResult->fetch_assoc()) {
                            echo "<option value='{$row['rent_amount']}'>{$row['rent_amount']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button onclick="applyFilters()">Apply</button>
            </div>
            <div class="cont_items" id="rentalsContainer">
                <!-- Container to load rentals dynamically -->
            </div>
        </div>
    </section>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            by &copy;<strong><span>ResiHive 2023</span></strong>
        </div>
        <div class="credits"></div>
    </footer><!-- End Footer -->

    <script src="../jscripts/dropdownfeat.js"></script>

    <script>
    window.onload = function () {
        // Set the default values for min and max amounts
        <?php
        $amountOptionsResult->data_seek(0);
        while ($row = $amountOptionsResult->fetch_assoc()) {
            echo "document.getElementById('minAmount').options.add(new Option('{$row['rent_amount']}','{$row['rent_amount']}'));";
        }
        ?>

        <?php
        $amountOptionsResult->data_seek(0);
        while ($row = $amountOptionsResult->fetch_assoc()) {
            echo "document.getElementById('maxAmount').options.add(new Option('{$row['rent_amount']}','{$row['rent_amount']}'));";
        }
        ?>

        // Fetch all rentals when the page loads
        filterRentals('All');
    };

    function filterRentals(houseType) {
        const container = document.getElementById('rentalsContainer');
        const buttons = document.querySelectorAll('.switch-button');
        const minAmount = document.getElementById('minAmount').value;
        const maxAmount = document.getElementById('maxAmount').value;

        // Remove 'active' class from all buttons
        buttons.forEach(btn => btn.classList.remove('active'));

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up the request
        if (houseType === 'All') {
            // If 'All' is selected, fetch rentals for both 'Dorm' and 'Apartment'
            xhr.open('GET', `../includes/load_rentals.php?houseType=${houseType}&minAmount=${minAmount}&maxAmount=${maxAmount}`, true);
        } else {
            // Fetch rentals based on the selected house type
            xhr.open('GET', `../includes/load_rentals.php?houseType=${houseType}&minAmount=${minAmount}&maxAmount=${maxAmount}`, true);
        }

        // Define what happens on successful data submission
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the container with the fetched HTML
                container.innerHTML = xhr.responseText;
                
                // Add click event listeners to the loaded items
                const rentalItems = document.querySelectorAll('.rental-item');
                rentalItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const itemId = this.getAttribute('data-id');
                        const sessionData = '<?php echo $_SESSION['your_session_variable'];?>';
                        window.location.href = `next_page.php?id=${itemId}&session=${sessionData}`;
                    });
                });
            }
        };

        // Send the request to the server
        xhr.send();

        // Add 'active' class to the clicked button
        const clickedButton = document.querySelector(`.switch-button[data-house-type="${houseType}"]`);
        clickedButton.classList.add('active');
    }
    </script>

    <script>
    // Fetch all rentals when the page loads
    window.onload = function() {
        filterRentals('All');
    };

    function filterRentals(houseType) {
        const container = document.getElementById('rentalsContainer');
        const buttons = document.querySelectorAll('.switch-button');
        const minAmount = document.getElementById('minAmount').value;
        const maxAmount = document.getElementById('maxAmount').value;

        // Remove 'active' class from all buttons
        buttons.forEach(btn => btn.classList.remove('active'));

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up the request
        if (houseType === 'All') {
            // If 'All' is selected, fetch rentals for both 'Dorm' and 'Apartment'
            xhr.open('GET', `../includes/load_rentals.php?houseType=${houseType}&minAmount=${minAmount}&maxAmount=${maxAmount}`, true);
        } else {
            // Fetch rentals based on the selected house type
            xhr.open('GET', `../includes/load_rentals.php?houseType=${houseType}&minAmount=${minAmount}&maxAmount=${maxAmount}`, true);
        }

        // Define what happens on successful data submission
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the container with the fetched HTML
                container.innerHTML = xhr.responseText;
            }
        };

        // Send the request to the server
        xhr.send();

        // Add 'active' class to the clicked button
        const clickedButton = document.querySelector(`.switch-button[data-house-type="${houseType}"]`);
        clickedButton.classList.add('active');
    }

    function applyFilters() {
        // This function remains unchanged
        const container = document.getElementById('rentalsContainer');
        const minAmount = document.getElementById('minAmount').value;
        const maxAmount = document.getElementById('maxAmount').value;

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('GET', `../includes/load_rentals.php?houseType=All&minAmount=${minAmount}&maxAmount=${maxAmount}`, true);

        // Define what happens on successful data submission
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the container with the fetched HTML
                container.innerHTML = xhr.responseText;
            }
        };

        // Send the request to the server
        xhr.send();
    }
</script>

</body>
</html>
