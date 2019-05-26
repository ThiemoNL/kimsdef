<?php
require_once 'core/init.php';


//$user = DB::getInstance()->get('users', ['username', '=', 'alex']);
$user = DB::getInstance()->insert('table', [
    'username' => 'test',
    'password' => 'password',
    'salt' => 'salt'
]);


