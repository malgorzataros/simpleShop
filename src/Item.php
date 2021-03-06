<?php

require_once 'connection.php';

class Item {

    static public function setConnection($newConnection){
        Item::$conn = $newConnection;
    }
    
    static public function loadAllItems(){
        $sql = "SELECT * FROM Item";
        $result = Item::$conn->query($sql);
        if($result->num_rows > 0){
            $allItems = array();
            foreach ($result as $row){
                var_dump($row);
            $newItem = new Item($row['id'], $row['name'], $row['price'], $row['description'], $row['stored'], $row['category_id']);
            $allItems[] = $newItem;
            }
            return $allItems;
        }
        return [];
    }
    
    static public function loadItemFromDBById($id){
        $sql = "SELECT * FROM Item WHERE id = $id";
        $result = Item::$conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $newItem = new Item($row['id'], $row['name'], $row['price'], $row['description'], $row['stored'], $row['category_id']);
            return $newItem;
        }
        return false; 
    }
    
    static public function loadItemsByCategory($categoryId){
        $sql = "SELECT * FROM Item WHERE category_id = $categoryId";
        $result = Item::$conn->query($sql);
        if ($result->num_rows > 0){
            $selectedItems = [];
            foreach ($result as $row){
            $newItem = new Item($row['id'], $row['name'], $row['price'], $row['description'], $row['stored'], $row['category_id']);
            $selectedItems[] = $newItem;
            }
            return $selectedItems;
        }
        return [];
    }
    
    private static $conn;
    
    private $id;
    private $name;
    private $price;
    private $description;
    private $stored;
    private $categoryId;
    
    
    public function __construct($newId, $newName, $newPrice, $newDescription, $newStored, $newCategoryId) {
        $this->setId($newId);    //Dlaczego tu było ustawione -1? NIe lepiej to załatwić w seterze?
        $this->setName($newName);
        $this->setPrice($newPrice);
        $this->setDescription($newDescription);
        $this->setStored($newStored);
        $this->setCategoryId($newCategoryId);
    }
    
    public function setId($newId){
        if($newId !== -1){
            $this->id = $newId;
        } 
        else {
            $this->id = -1;
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
    
    public function setCategoryId($newCategoryId){
        if (isset($newCategoryId) && is_numeric($newCategoryId)){
            $this->categoryId = $newCategoryId;
        }
        else{
            $this->categoryId = 0;
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
    
    public function getCategoryId(){
        return $this->categoryId;
    }
    
    public function createItem(){
        if($this->id == -1){
            $sql = "INSERT INTO Item (name, price, description, stored, category_id) VALUES ('$this->name', $this->price, '$this->description', $this->stored, $this->categoryId)";
            if (Item::$conn->query($sql)){
                $this->id = Item::$conn->insert_id;
                return TRUE;
            }
            else{
                echo Item::$conn->error;
                return false;
            }
        }   
    }
    
    public function showItem(){
        echo "Id: $this->id Name: $this->name Price: $this->price PLN Description: $this->description In store: $this->stored Category: $this->categoryId<br>"; // poki co showItem w prosty sposob pozniej bedziemy to zmieniac
    }
    
    public function editItem (){
        if ($this->id != -1){
            $sql = "UPDATE Item SET name = '$this->name', price = $this->price, description = '$this->description', stored = $this->stored, category_id = $this->categoryId ";
            if(Item::$conn->query($sql && Item::$conn->affected_rows)){
                return true;
            }
        }
        return false;
    }
}