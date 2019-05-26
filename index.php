<?php
require_once 'core/init.php';


//$user = DB::getInstance()->get('users', ['username', '=', 'alex']);
$userInsert = DB::getInstance()->insert('users', [
    'username' => 'test',
    'password' => 'newwpassword',
    'salt' => 'mewsalt'
    ]);

if(!$userInsert) {
    echo "niet gelukt";} else{

    echo "het is gelukt";
}


