<?php

require_once "../src/User.php";
require_once "../src/connection.php";
session_start();

//var_dump($_SESSION['loggedUserId']);
$user = User::getUserById($_SESSION['loggedUserId']);

$userName= $user->getName();
$userSur = $user->getSurname();
$userEmail = $user->getEmail();
$userPassword = $user->getPassword();

?>
<form method="POST">
    Name:
    <input type="text" name="name" value="<?php echo $userName; ?>">
    Surname:
    <input type="text" name="name" value="<?php echo $userSur; ?>">
    Emaile:
    <input type="text" name="name" value="<?php echo $userEmail; ?>">



</form>
