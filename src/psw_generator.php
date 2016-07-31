
<?php

$psw = 'qwerty';

$hashedPsw = password_hash($psw, PASSWORD_DEFAULT);

var_dump($hashedPsw);