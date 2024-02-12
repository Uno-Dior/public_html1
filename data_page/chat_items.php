<?php
include_once "../mysql/conn.php"; // Adjust the path as needed

// Fetch data from the chat_users table
$userId = $_SESSION['tenant']['userid'];
$sql = mysqli_query($conn, "SELECT * FROM chat_users WHERE user_id = '$userId'");

if ($sql && mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        // Fetch username from tbl_landowner_account
        $usernameSql = mysqli_query($conn, "SELECT CONCAT(f_name, ' ', s_name) AS username FROM tbl_landowner_account WHERE userid = '{$row['owner_user_id']}'");
        $usernameRow = mysqli_fetch_assoc($usernameSql);

        // Add the username to the $row array
        $row['username'] = !empty($usernameRow['username']) ? $usernameRow['username'] : '';

        // Display user details with hidden input fields
        echo "<a class='btn-user' data-id='{$row['id']}' onclick='showChatDetails({$row['id']})'>"; // Include data-id attribute
        echo "<div class='user-details'>";
                echo "<input type='hidden' id='user-id-{$row['id']}' value='{$row['id']}'>";
                echo "<input type='hidden' id='house-id-{$row['id']}' value='{$row['house_id']}'>";
                echo "<input type='hidden' id='owner-user-id-{$row['id']}' value='{$row['owner_user_id']}'>";
                echo "<input type='hidden' id='renter-user-id-{$row['id']}' value='{$row['user_id']}'>";
                echo "<img src='../data_style/assets/img/profile_icon.png' alt='logo'>";
                echo "<div class='user-name'>";
                    if (!empty($row['username'])) {
                        echo "<span style='color:white;'>{$row['username']}</span>";
                        echo "<p>Last active: " . (!empty($row['last_active']) ? $row['last_active'] : '') . "</p>";
                    } else {
                        echo "<p style='color:white'>No Chats</p>";
                    }
                echo "</div>";
            echo "</div>";
        echo "</a>"; // Close anchor tag
    }
} else {
    // Handle the case where no rows are returned
    echo "<p style='color:white' class='no_chats'>No Available Chats</p>";
}
?>
