<?php
include_once "../mysql/Connection.php";
$connection = new Connection();
$db = $connection->accessConnection();

$chat =  $_POST['chatmsg'];

if($db->connect_error){
    echo "database";
}
else{
    $stmt = $db->prepare("INSERT INTO chats(chat) VALUES(?)");
    $stmt->bind_param("s",$chat);
    $stmt->execute();
    $stmt->close();
    echo "success";
}