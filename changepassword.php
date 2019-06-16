<?php
require_once 'core/init.php';

$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){

        $validate = new Validate();
        $validation = $validate->check($_POST,[
            'password_current' => [
                'required' => true,
                'min' => 6
             ],
            'password_new' => [
                'required' => true,
                'min' => 6,
            ],
            'password_new_again' => [
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            ]

        ]);

        if($validation->passed()){



            if(!password_verify(Input::get('password_current'), $user->data()->password)){
                echo 'Your curerent password is wrong';
            } else {
                $user->update([
                    'password' => Hash::make(Input::get('password_new'))
                ]);

                Session::flash('home', 'Your password have been changed');
                Redirect::to('index.php');
            }
        } else {
            foreach ($validation->errors() as $error){
                echo $error, '<br>';
            }
        }

    }
}
?>



<form action="" method="post">
    <div class="field">
        <label for="password_current">Currenct password</label>
        <input type="password" name="password_current" id="password_current">
    </div>

    <div class="field">
        <label for="password_new">New Password</label>
        <input type="password" name="password_new" id="password_new">
    </div>

    <div class="field">
        <label for="password_new_again">New Password again</label>
        <input type="password" name="password_new_again" id="password_new_again">
    </div>

    <input type="submit" value="Change">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>
