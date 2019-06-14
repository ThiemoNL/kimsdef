<?php
require_once 'core/init.php';

if(Session::exists('succes')) {
    echo Session::flash('succes');
}

//$user = DB::getInstance()->get('users', ['username', '=', 'alex']);
//$userInsert = DB::getInstance()->update('users', 1, [
//    'username' => 'test',
//    'password' => 'newwpassword',
//    'salt' => 'mewsalt'
//    ]);
//
//if(!$userInsert) {
//    echo "niet gelukt";} else{
//
//    echo "het is gelukt";
//}


