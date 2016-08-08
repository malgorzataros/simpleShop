<?php

require_once "../src/User.php";
require_once "../src/connection.php";
session_start();

echo "<a href='index.php'> Main menu </a><br><br>";
//var_dump($_SESSION['loggedUserId']);

$user = User::getUserById($_SESSION['loggedUserId']);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $userName= $user->getName();
    $userSur = $user->getSurname();
    $userEmail = $user->getEmail();
    $userPassword = $user->getPassword();

    $name = isset($_POST['name']) ?  $conn->real_escape_string(trim($_POST['name'])) : $userName;
    $surname = isset($_POST['surname']) ?  $conn->real_escape_string(trim($_POST['surname'])) : $userSur;
    $email = isset($_POST['email']) ?  $conn->real_escape_string(trim($_POST['email'])) : $userEmail;
    $passwordOld = isset($_POST['passwordOld']) ? (trim($_POST['passwordOld'])) : null;
    $passwordNew = isset($_POST['passwordNew']) ? (trim($_POST['passwordNew'])) : null;
    $password2 = isset($_POST['password2']) ? (trim($_POST['password2'])) : null;

    $user->setName($name);
    $user->setSurname($surname);
    $user->setEmail($email);
    //$user->setId($_SESSION['loggedUserId']);



    if(password_verify($passwordOld, $userPassword)){

        if($passwordNew === $password2){
            $user->setHashPassword($passwordNew);
        }
    }
    $user->saveToDB();
}

$userName= $user->getName();
$userSur = $user->getSurname();
$userEmail = $user->getEmail();
$userPassword = $user->getPassword();


?>
<form method="POST">
    Name:
    <input type="text" name="name" value="<?php echo $userName; ?>"><br>
    Surname:
    <input type="text" name="surname" value="<?php echo $userSur; ?>"><br>
    Emaile:
    <input type="text" name="email" value="<?php echo $userEmail; ?>"><br>
    Old Password:
    <input type="password" name="passwordOld"><br>
    New Password:
    <input type="password" name="passwordNew"><br>
    Confirm Password:
    <input type="password" name="password2"><br>

    <input type="submit" value="Save">



</form>


