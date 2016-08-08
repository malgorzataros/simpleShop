<?php

require_once __DIR__.'/../vendor/autoload.php';

class ItemTests extends PHPUnit_Extensions_Database_TestCase{
    
    private static $connection;
    
    public function getConnection(){//polaczenie testowe do bazy danych
        $conn = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
        );
        
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }
    
    public function getDataSet(){ //wczytanie i zwrocenie pliku XML z danymi
        return $this->createFlatXmlDataSet(__DIR__.'/../datasets/simple_shop.xml');         
    }
    
    public static function setUpBeforeClass(){

        parent::setUpBeforeClass();

        $servername = 'localhost';//nazwa servera
        $username = 'root';//nazwa uzytkownika
        $password = 'coderslab';//haslo
        $baseName = 'simple_shop';//nazwa bazy
        //tworzenie nowego polaczenia
        self::$connection = new mysqli ($servername, $username, $password, $baseName); //nowy obiekt mysqli oznacza nawizanie polaczenia

        //sprawdzanie poprawnosci polaczenia
        if (self::$connection->connect_error){//jezeli podczas ustanawiania polaczenia wystapil blad
            die("Blad przy polaczeniu do bazy danych:" .self::$connection-->connect_error);//konczy dzialanie skryptu i wysiwietla napis
        }
        self::$connection->set_charset("utf8");
    }
 
    
    public function testIfMethodLoadsAllObjects(){
        var_dump(Item::loadAllItems());
        $this->assertArrayHasKey(0, Item::loadAllItems());
    }
}
    
    
    