<?php

require_once __DIR__.'/../vendor/autoload.php';

class UserTest extends PHPUnit_Framework_TestCase {
    
    public function testConstructWithCorrectData(){
        $a = new User();
        $this->assertInstanceOf('User', $a);
    }
    
    public function testSetIdWithCorrectData() {
        $user = new User();
        $this->assertInstanceOf('User', $user->setId(5));
    }
    
    public function testSetIdSetsIdWithCorrectData(){
        $user = new User();
        $user->setId(5);
        $this->assertAttributeEquals(5, 'id', $user);
    }
    
    public function testIfSetIdSetsIdWithIncorrectId(){
        $user = new User();
        $user->setId('dfs');
        $this->assertAttributeEquals(-1, 'id', $user);
    }
    
}
