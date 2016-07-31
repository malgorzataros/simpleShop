
<?php

$psw = 'qwerty';

$hashedPsw = password_hash($psw, PASSWORD_DEFAULT);

var_dump($hashedPsw);

var_dump(is_numeric(null));