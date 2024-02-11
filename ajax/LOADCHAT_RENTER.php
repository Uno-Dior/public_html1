<?php
session_start();
require_once '../mysql/conn.php';

$database = new Database();
$db = $database->getConnection();

$land_id = $_POST['land_id'];
$rent_id = $_SESSION['tenant'];
$email = $rent_id['email'];

if ($db->connect_error) {
    echo "database";
} else {
    $renter_con = [];
    $landowner = [];
    $rent_id = getRenterID($email);
    $stmt = $db->prepare("SELECT * FROM  chats WHERE rent_id=? AND land_id=?");
    $stmt->bind_param("ss", $rent_id, $land_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="incoming details">
            <p><?= $row["chat"] ?></p>
        </div>
        <?php
    }
}

function getRenterID($email)
{
    $database = new Database();
    $db = $database->getConnection();

    if ($db->connect_error) {
        echo "database";
    } else {
        $stmt = $db->prepare("SELECT userid FROM tbl_renters_account WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();

        return $id;
    }
}
