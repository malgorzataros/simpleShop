<?php

class User {
    
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    
    public function __construct() {
        $this->id = -1;
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->password = '';
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    //public function set
    
    
    
    
}
