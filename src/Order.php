<?php

require_once 'connection.php';

class Order {
    
    private static $conn;
    
    private $id;
    private $status;
    private $userId;
    private $total;
    
    static public function setConnection($newConnection){
        Order::$conn = $newConnection;
    }
    
    
    static public function loadOrderById(mysqli $conn, $id){
        $sql = "SELECT `Order`.*, Item.* FROM `Order`
                JOIN Item_Order ON `Order`.id = Item_Order.order_id 
                JOIN Item ON Item.id=Item_Order.item_id
                WHERE `Order`.id = $id";
        
        $result = $conn->query($sql);
        if ($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $newOrder = new Order($row['id'], $row['status'], $row['user_id'], $row['total']);
            return $newOrder;
        }
        else{
            return false;
        }

    }
    
    static public function loadAllOrdersByUserId(mysqli $conn, $userId){//!ToDo tutaj trzeba jeszcze wymyslic jak z tych danych wybrac dane o statusie 1 (niezlone - zakladam ze to koszyk) i pozostale zamowienia zapytanie do bazy SELECT * FROM `Order` WHERE staus IN (2,3,4)
        $sql = "SELECT `Order`.*, Item.* FROM `Order`
                JOIN Item_Order ON `Order`.id = Item_Order.order_id 
                JOIN Item ON Item.id = Item_Order.item_id
                JOIN User ON `Order`.user_id = User.id 
                WHERE `Order`.user_id = $userId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $allUserOrders = array();
            foreach($result as $row){
                $newOrder = new Order($row['id'], $row['status'], $row['user_id'], $row['total']);
                $allUserOrders[] = $newOrder;
            }
            return $allUserOrders;
        }
        return []; 
    }
    
    public function __construct($newId, $newStatus, $newUserId, $newTotal){
        $this->id = -1;
        $this->setStatus($newStatus);
        $this->setUserId($newUserId);
        $this->setTotal($newTotal);
    }
    
    public function setId($newId){
        if (isset($newId) && is_integer($newId)){
            $this->id = $newId;
        }
        else{
            $this->id = 0;
        }
    }
    
    public function setStatus($newStatus){
        if(isset($newStatus) && is_integer($newStatus)){
            $this->status = $newStatus;
        }
        else{
            $this->status = 0;
        }
    }
    
    public function setUserId($newUserId){
        if(isset($newUserId) && is_integer($newUserId)){
            $this->userId = $newUserId;
        }
        else{
            $this->userId = 0;
        }
    }
    
    public function setTotal($newTotal){
        if(isset($newTotal) && is_integer($newTotal)){
            $this->total = $newTotal;
        }
        else{
            $this->total = 0;
        }     
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function getUserId(){
        return $this->userId;
    }
    
    public function getTotal(){
        return $this->total;
    }
    
    public function createOrder(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO `Order` (status, user_id, total) VALUES ($this->status, $this->userId, $this->total)";
            if ($conn->query($sql)){
                $this->id = $conn->insert_id;
                return true;
            }
            else{
                echo $conn->error;
                return false;
            }
        }
    }
    // @ToDO zastanawiam sie czy dac mozliwosc edycji badz usuniecia zamowienia?  poniewaz jak sie cos zle doda do zamowienia, to powinna byc taka mozliwosc,
    //albo edycja, ablo usuwanie i tworzenie nowego. Chyba ze pozostanie tylko mail do admina.
    //EDIT: Na pewno trzeba dac mozliwosc usunieci zamowienia o id = 1 czlyi koszyka.
}

