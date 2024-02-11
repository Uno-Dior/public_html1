<?php
require_once '../mysql/conn.php';

$connection = new Connection();
$db = $connection->accessConnection();

$rent_id = isset($_GET['rent_id']) ? $_GET['rent_id'] : null;
$land_id = isset($_GET['land_id']) ? $_GET['land_id'] : null;
$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : null;

if ($db->connect_error) {
    echo "database";
} else {
    $stmt = $db->prepare("SELECT * FROM chats WHERE rent_id = ? AND land_id = ? AND item_id = ?");
    $stmt->bind_param("iii", $rent_id, $land_id, $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    while ($row = $result->fetch_assoc()) {
        $message = $row['chat'];
        $isOutgoing = true;

        // Display outgoing messages
        if ($isOutgoing) {
            ?>
            <div class="chat outgoing details">
                <div class="chat-cont-end">
                    <p class="text"><?= $message ?></p>
                </div>
            </div>
            <?php
        } else {
            // Display incoming messages
            ?>
            <div class="chat incoming details">
                <div class="chat-cont-end">
                    <p class="text"><?= $message ?></p>
                </div>
            </div>
            <?php
        }
    }
}
?>