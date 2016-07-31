<?php

require_once 'connection.php';

class Item {
    
    private static $conn;
    
    private $id;
    private $name;
    private $price;
    private $description;
    private $stored;
    
    static public function setConnection($newConnection){
        Item::$conn = $newConnection;
    }
    
    static public function loadAllItems(mysqli $conn){
        $sql = "SELECT * FROM Item";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $allItems = array();
            foreach ($result as $row){
            $newItem = new Item($row['id'], $row['name'], $row['price'], $row['description'], $row['stored']);
            $allItems[] = $newItem;
            }
            return $allItems;
        }
        return [];
    }
    
    static public function loadItemFromDBById(mysqli $conn, $id){
        $sql = "SELECT * FROM Item WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $newItem = new Item($row['id'], $row['name'], $row['price'], $row['description'], $row['stored']);
            return $newItem;
        }
        return false; 
    }


    public function __construct($newId, $newName, $newPrice, $newDescription, $newStored) {
        $this->id = -1;
        $this->setName($newName);
        $this->setPrice($newPrice);
        $this->setDescription($newDescription);
        $this->setStored($newStored);
    }
    
    public function setId($newId){
        if($newId !== -1){
            $this->id = $newId;
        } 
    }
    
    public function setName($newName){
        if (isset($newName) && is_string(trim($newName))){
            $this->name = $newName;
        }
        else{
            $this->name = '';
        }
    }
    
    public function setPrice($newPrice){
        if (isset($newPrice) && is_numeric($newPrice)){
            $this->price = $newPrice;
        }
        else{
            $this->price = 0;
        }
    }
    
    public function setDescription($newDescription){
       if (isset($newDescription) && is_string(trim($newDescription))){ 
            $this->description = $newDescription;
       }
       else{
           $this->description = '';
       }
    }
    
    public function setStored($newStored){
        if (isset($newStored) && is_numeric($newStored)){
            $this->stored = $newStored;
        }
        else{
            $this->stored = 0;
        }
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getPrice(){
        return $this->price;
    }
    
    public function getDescription(){
        return $this->description;
    }

    public function getStored(){
        return $this->stored;
    }
    
    public function createItem(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Item (name, price, description, stored) VALUES ('$this->name', $this->price, '$this->description', $this->stored)";
            if ($conn->query($sql)){
                $this->id = $conn->insert_id;
                return TRUE;
            }
            else{
                echo $conn->error;
                return false;
            }
        }   
    }
    
    public function showItem(){
        echo $this->id, $this->name, $this->price, $this->description, $this->stored; // poki co showItem w prosty sposob pozniej bedziemy to zmieniac
    }
    
    public function editItem (mysqli $conn){
        if ($this->id != -1){
            $sql = "UPDATE Item SET name = $this->name, price = $this->price, description = $this->description, stored = $this->stored";
            if($conn->query($sql && $conn->affected_rows)){
                return true;
            }
        }
        return false;
    }
}