<?php
require_once 'core/init.php';



    if (Input::exists()) {
        if(Token::check(Input::get('token'))){

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
                'email' => true,
                'unique' => 'users'
            ],
        ]);

        if ($validation->passed()) {
            $user = new User();


            try {

                $user->create([
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password')),
                    'name' => Input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1,
                    'email' => Input::get('email')
                ]);

                Session::flash('home', 'You have been registered and can now log in!');
                Redirect::to(404);
            } catch (Exception $e){
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
        }
    }

?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars(Input::get('username')) ?>" autocomplete="off">
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
        <input type="text" name="name" id="name" value="<?= htmlspecialchars(Input::get('name')) ?>">
    </div>

    <div class="field">
        <label for="email">Enter your email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars(Input::get('email'))?>">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

    <input type="submit" value="Register">
    
</form>
