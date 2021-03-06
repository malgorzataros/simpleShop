<?php

class User {
    
    public static function SetConnection($newConnection){
        User::$conn = $newConnection;
    }
    
    public static function LogIn($email, $password){
        $sql = "SELECT * FROM User WHERE User.email = '$email'";
        $result = USER::$conn->query($sql);
        //var_dump($result);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])){
                return $row['id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
        
    }

    public static function getUserByEmail($email){
        $sql = "SELECT * FROM User WHERE User.email = '$email'";
        $result = USER::$conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $user = new User();

            return $user;
        } else {
            return false;
        }
    }

    public static function getUserById($id){
        $sql = "SELECT * FROM User WHERE id = '$id'";
        $result = USER::$conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $user = new User($row['id'], $row['name'], $row['surname'], $row['email'], $row['password']);

            return $user;
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
        $this->password = is_string($password) ? $password : '';
    }

    public function setHashPassword($password){
        $this->password = is_string($password) ? password_hash($password, PASSWORD_DEFAULT) : '';
    }
    
    public function getPassword(){
        return $this->password;
    }

    public function saveToDB(){
        if($this->id == -1) {
            $sql = "INSERT INTO User(name, surname, email, password) VALUE ('$this->name', 
                   '$this->surname', '$this->email', '$this->password')";
            var_dump($sql);
            if(User::$conn->query($sql)) {
                $this->id = User::$conn->insert_id;
                return $this;
            } else {
                echo User::$conn->error;
                return false;
            }
        }
        else {
            $sql = "UPDATE User SET 
                   name = '$this->name',
                   surname = '$this->surname', 
                   email = '$this->email',
                   password = '$this->password'
                   WHERE id = $this->id";
            if(User::$conn->query($sql)){
                return $this;
            } else {
                echo User::$conn->error;
                return false;
            }
        }
    }
    
    
}
