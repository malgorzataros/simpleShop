<?php

require_once 'connection.php';

class Message{
    
    static public function setConnection($newConnection){
        Message::$conn = $newConnection;
    }
    
    public static function loadAllReceivedMessages($userId){//!ToDo dodac do klasy User wywoalnie tej metody
        $sql = "SELCECT * FROM Messages WHERE user_id = $userId";
        $result = Message::$conn->query($sql);
        if ($result->num_rows > 0) {
            $allMsg = array();
            foreach ($result as $row){
                $newMsg = new Message($row['id'], $row['text'], $row['user_id'], $row['admin_id']);
                $allMsg[] = $newMsg;
            }
            return $allMsg;
        }
        return [];        
    }
    
    static private $conn;
    
    private $id;
    private $text;
    private $userId;
    private $adminId;
    
    
    
    public function __construct($newId, $newText, $newUserId, $newAdminId) {
        $this->setId($newId);
        $this->setText($newText);
        $this->setUserId($newUserId);
        $this->setAdminId($newAdminId);
    }
    
    public function setId($newId){
        if(isset($newId) && is_integer($newId)){
            $this->id = $newId;
        }
        else{
            $this->id = -1;
        }
    }
    
    public function setText($newText){
        if(isset($newText) && is_string($newText)){
            $this->text = $newText;
        }
        else {
            $this->text = '';
        }
    }
    
    public function setUserId($newUserId){
        if(isset($newUserId) && is_integer($newUserId)){
            $this->userId = $newUserId;
        }
        else{
            $this->id = 0;
        }
    }
    
    public function setAdminId($newAdminId){
        if(isset($newAdminId) && is_integer($newAdminId)){
            $this->userId = $newAdminId;
        }
        else{
            $this->id = 0;
        }
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function getUserId(){
        return $this->userId;
    }
    
    public function createMessage(){
        if($this->id == -1){
            $sql = "INSERT INTO Messages (text, user_id) VALUES ('$this->text', $this->user_id)";
            if(Message::$conn->query($sql)){
                $this->id = Message::$conn->insert_id;
                return true;
            }
            return false;
        }
    }
    
    public function showMessage(){
        echo $this->text;
    }
}