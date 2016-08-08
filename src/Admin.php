<?php

require_once 'connection.php';

class Admin {

    static public function setConnection($newConnection){
        Admin::$conn = $newConnection;
    }
    
    static public function logIn ($email, $password){
        $sql = "SELECT * FROM Admin WHERE email = '$email'";
        $result = Admin::$conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])){
                return $row['id'];
            }
            else {
                echo Admin::$conn->error;
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    private static $conn;
    
    private $id;
    private $adminName;
    private $email;
    private $password;
    
       
    // !Info Nie dajemy mozlwiosci zarestrowania sie nowego Admina, konto bedzie tworzone bezposredno w bazie danych, za pomoca phpMyAdmin. 
    

    
    public function __construct($newAdminName, $newEmail, $newPassword) {
        $this->id = -1;
        $this->setAdminName($newAdminName);
        $this->setEmail($newEmail);
        $this->setPassword($newPassword);
    }
    
    public function setId($newId){
        if (isset($newId) && is_integer($newId)){
            $this->id = $newId;
        }
        else {
            $this->id = 0;
        }
    }
    
    public function setAdminName($newAdminName){
        if (isset($newAdminName) && is_string(trim($newAdminName))){
            $this->adminName = $newAdminName;
        }
        else{
            $this->adminName = '';
        }
    }
    
    public function setEmail($newEmail){
        if (isset($newEmail) && filter_var(trim($newEmail, FILTER_VALIDATE_EMAIL) == trim($newEmail))){
            $this->email = $newEmail;
        }
        else {
        $this->email = '';
        }
    }
    
    public function setHashedPassword($newPassword){
        if(isset($newPassword) && is_string($newPassword)){
            $this->password = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        else{
            return false;
        }
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getAdminName(){
        return $this->adminName;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getPassword(){
        return $this->password;
    }
    
    public function saveToDB(){
        if($this->id == -1){
            $sql = "INSERT INTO Admin (name, email, password) VALUES ('$this->adminName', '$this->email', '$this->password')";
            
            if(Admin::$conn->quer($sql)){
                $this->id = $conn->insert_id;
                return $this;
            }
            else{
                return false;
            }
        }
        else{
            $sql = "UPDATE Admin SET
                    name = '$this->adminName',
                    email = '$this->email',
                    passwors = '$this->password',
                    WHERE id = $this->id";
        }
        if (Admin::$conn->query($sql) && Admin::$conn->affected_rows){
            return $this;
        }
        else{
            return false;
        }
    }
    
    
}