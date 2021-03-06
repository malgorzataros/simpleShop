<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    
    require_once '../src/connection.php';
    require_once '../src/User.php';

    $email = isset($_POST['email']) ?  $conn->real_escape_string(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? (trim($_POST['password'])) : null;
    
    if (strlen($email) >= 5 && strlen($password) > 0){
        if($userId = User::LogIn($email, $password)){
            var_dump($userId);
            $_SESSION['loggedUserId'] = $userId;
            header("Location: index.php");
        }
        else{
            echo "Wrong login or password";
        }
    }
}


?>
<html>
    <head>
        <title>Log In</title>
    </head>
    <body>
        <form action='#' method="POST">
            <fieldset>
                <legend>Login</legend>
            <label>
                E-mail:
                <input type="text" name='email'/>
            </label><br>
            <label>
                Password:
                <input type="password" name='password'/>
            </label><br>
            <input type='submit' value='Login'>
            </fieldset>
        </form>
        <br>
        <a href='register.php'> Registration </a>
    </body>
</html>