<?php
require_once 'core/init.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';



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
            $mail = new PHPMailer(true);

            try {

                $user->create([
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password')),
                    'name' => Input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'groups' => 1,
                    'email' => Input::get('email')
                ]);

                $mail->SMTPDebug = 1;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host       = 'mail.creativestorm.nl';  // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'tim@creativestorm.nl';                     // SMTP username
                $mail->Password   = 'sch00ltas123';                               // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom(Input::get('email'), 'Tim Oskam');
                $mail->addAddress('tim_oskam@outlook.com', 'Tim Oskam');     // Add a recipient

                // Attachments

                $mailadress = Input::get('email');

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body    = "Uw mail adress is: " . $mailadress;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



                $mail->send();
                Session::flash('home', 'You have been registered and can now log in!');
                Redirect::to('index.php');
            } catch (Exception $e){
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= escape(Input::get('username')) ?>" autocomplete="off">
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
        <input type="text" name="name" id="name" value="<?= escape(Input::get('name')) ?>">
    </div>

    <div class="field">
        <label for="email">Enter your email</label>
        <input type="email" name="email" id="email" value="<?= escape(Input::get('email'))?>">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

    <input type="hidden" name="token1" id="token1">

    <input type="submit" value="Register">

</form>
</body>
</html>
