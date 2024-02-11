<?php
session_start();
include_once "../mysql/Connection.php";
$connection = new Connection();
$db = $connection->accessConnection();
$land = $_SESSION['land'];
$rent_id = $_POST['userid'];
$email = $land['email'];
if($db->connect_error){
    echo "database";
}
else{
    $land_id = getLandownerID($email);
    $stmt  = $db->prepare("SELECT * FROM  chats WHERE land_id=? AND rent_id=?");
    $stmt->bind_param("ss",$land_id,$rent_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    while($row = $result->fetch_assoc()){
        ?>
            <div class="outgoing details">
                <p><?= $row['chat'] ?></p>
            </div>
        <?php
    }
}
function getLandownerID($email){
    $connection = new Connection();
    $db = $connection->accessConnection();
    
    if($db->connect_error){
        echo "database";
    }
    else{
        $stmt = $db->prepare("SELECT userid FROM tbl_landowner_account WHERE email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
    
        return $id;
    }
    
    
    }