<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../src/connection.php';
    require_once '../src/User.php';
    
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : null;
    $psw = isset($_POST['password']) ? $conn->real_escape_string(trim($_POST['psw'])) : null;
    $passwordConfirmation = isset($_POST['password2']) ? trim($_POST['password2']) : null;
    $name = isset($_POST['name']) ? $conn->real_escape_string(trim($_POST['name'])) : null;
    $surname = isset($psw['surname']) ? $conn->real_escape_string(trim($_POST['surname'])) : null;
    
    $user = User::getUserByEmail ($conn, $email);//!ToDo potrzeba npaisać te metode w klasie user
    if($email && $password && $password == $password2 && !$user){
        
        $newUser = new User(null, $name, $surname, $email, $password);
        var_dump($newUser);
        
            if ($newUser->savetoDB($conn)){
                header("Location: login.php");
              
            }
        else{
            echo "Something Went Wrong<br>";
        }
        
    }
    else {
        if($user){
            echo "email adress exists in our service";
        }else{
        echo "Something Went Wrong<br>";
        }
    }
}
         
?>

<html>
    <head>
    </head>
    <body>
        <form method='POST' action='#'>
            <fieldset>
            <label>
                Name:<br>
                <input type ='text' name='name'/>
            </label><br>
            <label>
                Surname:<br>
                <input type ='text' name='surname'/>
            </label><br>
            <label>
                Email:<br>
                <input type="text" name="email"/>
            </label><br>
            <label>
                Password:<br>
                <input type='password' name='password'/>
            </label><br>
            <label>
                Password confirmation:<br>
                <input type='password' name='password2'/>
            </label><br>
            <input type='submit' value='register'/>
        </fieldset>
        </form>
    </body>
</html>