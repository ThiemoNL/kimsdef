<?php
require_once 'core/init.php';

if(Input::exists()) {
   $validate = new Validate();
   $validation = $validate->check($_POST, [
       'username' => [
           'required' => true,
           'min' => 2,
           'max' => 20,
           'unique' => 'users'
       ],
       'password' => [
           'required' => true,
           'min' => 6,
       ],
       'password_again' => [
           'required' => true,
           'matches' => 'password'
       ],
       'name' => [
           'required' => true,
           'min' => 2,
           'max' => 50
       ],
       'email' => [
           'required' => true,
           'min' => 6,
           'max' => 255,
           'must have' => ['@', '.']
       ],
   ]);

   if($validation->passed()) {
       echo 'Passed';
   } else {
       print_r($validation->errors());
   }

}

?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo Input::get('username') ?>" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Repeat your password</label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <div class="field">
        <label for="name">Enter your name</label>
        <input type="text" name="name" id="name" value="<?php echo Input::get('name') ?>">
    </div>

    <div class="field">
        <label for="email">Enter your email</label>
        <input type="email" name="email" id="email">
    </div>

    <input type="submit" value="Register">
    
</form>
