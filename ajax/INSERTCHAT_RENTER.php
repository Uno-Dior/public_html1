<?php
session_start();
include_once "../mysql/Connection.php";
$connection = new Connection();
$db = $connection->accessConnection();

$land_id = $_POST['land_id'];
$rent_id = $_SESSION['tenant'];
$email = $rent_id['email'];
$chatmsg = $_POST['chatmsg'];
if($db->connect_error){
    echo "database";
}
else{
    $renterID = getLandownerID($email);
    $stmt  = $db->prepare("INSERT INTO chats(chat,rent_id,land_id) VALUES(?,?,?)");
    $stmt->bind_param("sss",$chatmsg,$renterID,$land_id);
    $stmt->execute();
    $stmt->close();
    echo "success";
}

function getLandownerID($email){
$connection = new Connection();
$db = $connection->accessConnection();

if($db->connect_error){
    echo "database";
}
else{
    $stmt = $db->prepare("SELECT userid FROM tbl_renters_account WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();

    return $id;
}


}