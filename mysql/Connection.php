<?php
class Connection{
    private $host = "localhost";
    private $username = "u620982390_dbroot";
    private $password = "Resihive23";
    private $database = "u620982390_dbresihive";
    private $connection;
    public function accessConnection(){
        $link = new mysqli($this->host, $this->username, $this->password, $this->database);
        return $link;
    }
}
?>