<?php

class User {
    
    public static function SetConnection($newConnection){
        User::$conn = $newConnection;
    }
    
    public function LogIn($email, $password){
        $sql = "SELECT * FROM User WHERE User.email = '$email'";
        $result = User::$conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->felch_assoc();
            if(password_verify($password, $row['password'])){
                return $row['id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
        
    }
    
    static private $conn;

    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    
    public function __construct($id, $name, $surname, $email, $password) {
        $this->setId($id);
        $this->setName($name);
        $this->setSurname($surname);
        $this->setEmail($email);
        $this->setPassword($password);
    }
    
    public function setId($id){
        $this->id = is_numeric($id) ? $id : -1;
    }
    
    public function setName($name){
        $this->name = is_string($name) ? $name:'';
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setSurname($surname){
        $this->surname = is_string($surname) ? $surname:'';
    }
    
    public function getSurname(){
        return $this->surname;
    }
    
    public function setEmail($email){
        $this->email = is_string($email) ? $email:'';
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setPassword($password){
        $this->password = is_string($password) ? password_hash($password, PASSWORD_DEFAULT) : '';
    }
    
    public function getPassword(){
        return $this->password;
    }
    
    
    
}
