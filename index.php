<?php
require_once 'core/init.php';

if(Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
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


echo '<br>';
$user = new User();

if($user->isLoggedIn()){
    ?>

    <p>Hello <a href="#"><?= htmlentities($user->data()->username) ?></a>!</p>

    <ul>
        <li><a href="logout.php">Log Out</a></li>
    </ul>

<?php
} else {
    Echo '<p>You need to <a href="login.php">Log in</a> in or <a href="register.php">register</a></p>';
}
