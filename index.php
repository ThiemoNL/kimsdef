<?php
require_once 'core/init.php';

if(Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();

if($user->isLoggedIn()){
    ?>

    <p>Hello <a href="#"><?= escape($user->data()->name) ?></a>!</p>

    <ul>
        <li><a href="logout.php">Log Out</a></li>
        <li><a href="update.php">Update details</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
    </ul>

<?php
    if($user->hasPermission('admin')){
        echo '<p>You are a admin!</p>';
    }
} else {
    Echo '<p>You need to <a href="login.php">Log in</a> in or <a href="register.php">register</a></p>';
}
