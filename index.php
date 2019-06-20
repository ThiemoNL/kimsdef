<?php
require_once 'core/init.php';

if(Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();

if($user->isLoggedIn()){
    ?>

    <p>Hello <a href="profile.php?user=<?= escape($user->data()->username) ?>"><?= escape($user->data()->name) ?></a>!</p>

    <ul>
        <li><a href="logout.php">Log Out</a></li>
        <li><a href="update.php">Update details</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
    </ul>

<?php
    if($user->hasPermission('admin')){
        echo '<p>You are a admin!</p>';

        $users = DB::getInstance()->query("SELECT * FROM users");

        if(Input::get('change')){
            if(!empty(Input::get('password'))){
                DB::getInstance()->update('users', Input::get('id'), [
                   'username' =>  Input::get('username'),
                   'password' =>  Hash::make(Input::get('password')),
                    'email' => Input::get('email')
                ]);
                Session::flash('home', Input::get('username') . " Data has been updated");
                Redirect::to('index.php');
                echo 'wel password';
            }else {
                DB::getInstance()->update('users', Input::get('id'), [
                    'username' => Input::get('username'),
                    'email' => Input::get('email')
                ]);
                echo 'geen password';
                Session::flash('home', Input::get('username') . " Data has been updated");
                Redirect::to('index.php');
            }

        } if (Input::get('delete')){
            echo 'user verwijderen uit database';
            DB::getInstance()->delete('users',['id', '=', Input::get('id')]);
            Session::flash('home', Input::get('username') . " Is now deleted");
            Redirect::to('index.php');
        }

        foreach ($users->results() as $user1){
            ?>

            <form action="" method="post">
                <div class="field">
                    <label for="id">ID:</label>
                    <input type="number" name="id" value="<?= $user1->id ?>">
                </div>
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?= $user1->username ?>">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                        <input type="text" name="password" value="" placeholder="new Password">
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?= $user1->email ?>">
                </div>
                <div class="field">
                    <label for="group">Group</label>
                    <input type="number" name="group" value="<?= $user1->group ?>">
                </div>
                <input type="submit" name="delete" value="delete">
                <input type="submit" name="change" value="change details">
            </form>
            <br>

       <?php }
    }
} else {
    Echo '<p>You need to <a href="login.php">Log in</a> in or <a href="register.php">register</a></p>';
}
