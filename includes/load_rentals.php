<?php
// Include the database.php file
require_once '../mysql/conn.php';

$mydb = new Database();

// Get the house type from the query string
$houseType = $_GET['houseType'];
$minAmount = isset($_GET['minAmount']) ? $_GET['minAmount'] : null;
$maxAmount = isset($_GET['maxAmount']) ? $_GET['maxAmount'] : null;

// Initialize the WHERE clause for filtering by rent amount
$whereClause = '';
$parameters = [];

// Adjust the WHERE clause based on the provided minimum and maximum amounts
if ($minAmount !== null) {
    $whereClause .= " AND rent_amount >= ?";
    $parameters[] = $minAmount;
}

if ($maxAmount !== null) {
    $whereClause .= " AND rent_amount <= ?";
    $parameters[] = $maxAmount;
}

// Fetch data based on the house type and amount range
switch ($houseType) {
    case 'All':
        // For 'All', include both 'Dorm' and 'Apartment' types
        $fetchQuery = "SELECT * FROM house_rentals WHERE house_type IN ('Dorm', 'Apartment') {$whereClause}";
        break;
    case 'Dorm':
        $fetchQuery = "SELECT * FROM house_rentals WHERE house_type = 'Dorm' {$whereClause}";
        break;
    case 'Apartment':
        $fetchQuery = "SELECT * FROM house_rentals WHERE house_type = 'Apartment' {$whereClause}";
        break;
    default:
        echo "<p>No rentals available.</p>";
        exit();
}

// Debugging
// echo $fetchQuery;


$stmt = $mydb->getConnection()->prepare($fetchQuery);

// Bind parameters if any
if (!empty($parameters)) {
    $types = str_repeat('s', count($parameters)); // Assuming all parameters are strings
    $stmt->bind_param($types, ...$parameters);
}

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are rows returned
if ($result->num_rows > 0) {
    $rentalHouses = $result->fetch_all(MYSQLI_ASSOC);

    // Display each fetched rental in a separate container
    foreach ($rentalHouses as $rental) {
        echo "<div class='items'>";
        echo "<a href='item_profile.php?id={$rental['house_id']}&" . http_build_query($_GET) . "' class='item'>";
        echo "<div class='posted-rental' data-house-type='{$rental['house_type']}'>";
                    echo "<img src='{$rental['house_image']}' alt='{$rental['house_name']}' class='house-image'><br><br>";
                    echo "<h1 style='margin-bottom: 3px'>{$rental['house_name']}</h1>";
                    echo "<label class='item-loc'>{$rental['location']}<    /label><br>";
                    echo "<div class='item-bottom_cont'>";
                        echo "<div class='item-price'>Price Starts At";
                            echo "<label for='price'>";
                                echo "<p>&#8369;{$rental['rent_amount']}</p>";
                            echo "</label>";
                        echo "</div>";
                        echo "<div class='item-features'>Available Space/s:";
                            echo "<label for='keyfeat'>";
                                echo "<p>{$rental['number_of_beds']}</p>";
                            echo "</label>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</a>";
            echo "<div class='btn-foritems'>";
                echo "<button class='btn_inquire' onclick='openModal()'>Inquire</button>";
                echo "<button class='btn_apply' onclick='openModal()'>Apply</button>";
            echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No rentals available.</p>";
}
?>
