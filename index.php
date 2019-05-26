<?php
require_once 'core/init.php';


//$user = DB::getInstance()->get('users', ['username', '=', 'alex']);
$userInsert = DB::getInstance()->update('users', 1, [
    'password' => 'newpassword',
    'salt' => 'mewsalt'
    ]);

if(!$userInsert) {
    echo "niet gelukt";} else{

    echo "het is gelukt";
}


