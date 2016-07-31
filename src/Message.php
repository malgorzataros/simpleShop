<?php

require_once 'connection.php';

class Message{
    
    static private $conn;
    
    private $id;
    private $text;
    private $userId;
    
    static public function setConnection($newConnection){
        Message::$conn = $newConnection;
    }
    
    public static function loadAllReceivedMessages(mysqli $conn, $userId){//!ToDo dodac do klasy User wywoalnie tej metody
        $sql = "SELCECT * FROM Messages WHERE user_id = $userId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $allMsg = array();
            foreach ($result as $row){
                $newMsg = new Message($row['id'], $row['text'], $row['user_id']);
                $allMsg[] = $newMsg;
            }
            return $allMsg;
        }
        return [];        
    }
    
    public function __construct($newId, $newText, $newUserId) {
        $this->id = -1;
        $this->setText($newText);
        $this->setUserId($newUserId);
    }
    
    public function setId($newId){
        if(isset($newId) && is_integer($newId)){
            $this->id = $newId;
        }
        else{
            $this->id = 0;
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
    
    public function getId(){
        return $this->id;
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function getUserId(){
        return $this->userId;
    }
    
    public function createMessage(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Messages (text, user_id) VALUES ($this->text, $this->user_id)";
            if($conn->query($sql)){
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        }
    }
}