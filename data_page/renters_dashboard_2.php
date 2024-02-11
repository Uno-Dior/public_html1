<?php
session_start();
// print_r($_SESSION);
require_once '../mysql/conn.php';

// Check if the user is already logged in
if (empty($_SESSION["tenant"])) {
    header("Location: ../data_page/renters_login.php");
    exit();
}

// Get the user ID (userid)
$userid = $_SESSION["tenant"]["userid"];

// Get the ID and house ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
$houseId = isset($_GET['house_id']) ? $_GET['house_id'] : null;

// Fetch data from chat_users and house_rentals based on the house ID
$sqlFetchData = "
    SELECT cu.*, hr.*
    FROM chat_users cu
    LEFT JOIN house_rentals hr ON cu.house_id = hr.house_id
    WHERE cu.id = ?
    LIMIT 1
";

$stmtFetchData = $conn->prepare($sqlFetchData);

if ($stmtFetchData === false) {
    die('Error in SQL query: ' . $conn->error);
}

$stmtFetchData->bind_param('s', $id);
$stmtFetchData->execute();
$resultFetchData = $stmtFetchData->get_result();

if ($resultFetchData === false) {
    die('Error in SQL result: ' . $stmtFetchData->error);
}

if ($resultFetchData->num_rows > 0) {
    $userData = $resultFetchData->fetch_assoc();

    // Use $userData as needed
    $houseImage = $userData['house_image'];
    $houseName = $userData['house_name'];
    $houseType = $userData['house_type'];

    // Display the user details
    echo '
        <div class="user-detail">
            <img src="' . $houseImage . '" alt="' . $houseName . '">
            <div class="details">
                <span><a style="color:black">' . $houseName . '</a></span>
                <p>' . $houseType . '</p>
            </div>
        </div>
    ';
} else {
    // Handle the case where no rows are returned
    echo 'User not found';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResiHive - Contact</title>
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <link rel="stylesheet" type="text/css" href="..\data_style\styles-renters.css">
    <script src="https://kit.fontawesome.com/4d86b94a8a.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
    <body>

        <?php include 'navbar.php'; ?>

        <section class="main">
            <div class="wrapper" id="container">
                <header>
                    <div class="title">
                        <h1>Chat</h1>
                    </div>
                    <div class="content">
                        <?php include 'chat_items.php'; ?>
                    </div>
                </header>
                    <!-- <section class="users">
                        <div class="search">
                            <span class="text">Select a user to start chat</span>
                            <input type="text" placeholder="Enter name to search...">
                            <button><i class="#"></i></button>
                        </div>
                        <div class="users-list">
                            
                        </div>
                    </section> -->

                    <section class="chatBox">
                        <div class="user-content">
                            <div class="user-detail">
                            <img src="<?php echo $_SESSION['houseOptionsData']['house_image']; ?>" alt="<?php echo $_SESSION['houseOptionsData']['house_name']; ?>">
                            <div class="details">
                                <span><a style="color:black"><?php echo $_SESSION['houseOptionsData']['house_name']; ?></a></span>
                                <p><?php echo $_SESSION['houseOptionsData']['house_type']; ?></p>
                            </div>
                            </div>
                        </div>
                        
                        <div class="chat-cont"  id="loadchat">
                    
                        </div>

                        <div class="typing-area">
                            <input type="text" name="chatmsg" id="chatmsg" class="input-field" placeholder="Type a message here..." autocomplete="off">
                            <button type="button" id="btnSend" title="Send Message"><i class="fab fa-telegram-plane"></i></button>
                        </div>       
                    </section>

            </div>
        </section>

 



        <footer>
        <div class="watermark">
               <p>by &copy;ResiHive 2023</p>
           </div>
        </footer>

        <!-- <script src="/jscripts/users.js"></script> -->

        <!-- <script src="../jscripts/chat.js"></script> -->

        <!-- <script src="../jscripts/chat copy.js"></script> -->

        <script src="/jscripts/dropdownfeat.js"></script>
        
        <script src="/jscripts/chatBoxFeat.js"></script>
        
        <script>
    $(document).ready(function () {
        let land_id = '<?= $_SESSION['rentalOptionsData']["owner_user_id"] ?>';

        // Function to send a message
        function sendMessage() {
            let chatmsg = $('#chatmsg').val();

            $.post({
                url: "../ajax/INSERTCHAT_RENTER.php",
                data: { land_id: land_id, chatmsg: chatmsg }
            }).done(function (data) {
                if (data == "success") {
                    $('#chatmsg').val('');
                }
                console.log(data);
            });
        }

        // Click event for the send button
        $('#btnSend').click(function () {
            sendMessage();
        });

        // Keypress event for the Enter key in the input field
        $('#chatmsg').keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Periodic function to load chat messages
        function loadChat() {
            $.post({
                url: "../ajax/LOADCHAT_RENTER.php",
                data: { land_id: land_id }
            }).done(function (data) {
                // Reverse the order of chat messages before inserting
                $('#loadchat').html(data).scrollTop($('#loadchat')[0].scrollHeight);
                console.log(data);
            });
        }

        // Initial load of chat messages
        loadChat();

        // Periodic function to load chat messages
        setInterval(function () {
            loadChat();
        }, 1000);
    });
</script>

<script>
    function showChatDetails(id) {
    // Access the hidden input fields for the selected user
    var userIdInput = document.querySelector(`.user-details #user-id-${id}`);
    var houseIdInput = document.querySelector(`.user-details #house-id-${id}`);
    var ownerUserIdInput = document.querySelector(`.user-details #owner-user-id-${id}`);
    var renterUserIdInput = document.querySelector(`.user-details #renter-user-id-${id}`);

    // Access the values from the hidden input fields
    var userId = userIdInput.value;
    var houseId = houseIdInput.value;
    var ownerUserId = ownerUserIdInput.value;
    var renterUserId = renterUserIdInput.value;

    // Display an alert with the values
    // alert("User ID: " + userId + "\nHouse ID: " + houseId + "\nOwner User ID: " + ownerUserId + "\nRenter User ID: " + renterUserId);

    // Update the URL to include the parameters
    var url = `../data_page/renters_dashboard_2.php?id=${encodeURIComponent(id)}`;

    // Redirect to the updated URL
    window.location.href = url;
}

</script>



<?php

?>
    </body>
</html>