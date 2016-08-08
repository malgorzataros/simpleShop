<a href="index.php">Powrot do strony glownej</a> <br><br>
<?php
session_start();
require_once "../src/Message.php";


$message = Message::loadAllReceivedMessages($_SESSION['loggedUserId']);
foreach($message as $row){
    $row->showMessage();
    echo "<br>";
}

