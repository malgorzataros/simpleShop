<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/connection.php';

class UserTest extends PHPUnit_Extensions_Database_TestCase {

    public function getConnection(){
        $conn = new PDO (
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']

        );
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    public function getDataSet(){
        return $this->createFlatXMLDataSet(__DIR__.'/../datasets/simple_shop.xml');
    }
    
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

