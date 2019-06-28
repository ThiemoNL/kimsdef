<?php
require_once 'core/init.php';
define('SITE_KEY', '6Lfm3qkUAAAAAEd6KNxSCI_8STpzZV9QCcI0u6-S');
define('SERVER_KEY', '6Lfm3qkUAAAAAB_ZplAV4UlahgCUnR4whd3lpv6w');


$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if(isset($_POST['g-recaptcha-response'])){
    function getCaptcha($secretKey) {
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SERVER_KEY . "&response={$secretKey}");
        $return = json_decode($response, true);
        return $return;
    }

     $return = getCaptcha($_POST['g-recaptcha-response']);


    if ($return['success'] == true) {
        if (Input::exists()) {

            $validate = new Validate();
            $validation = $validate->check($_POST, [
                'name' => [
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                ]
            ]);

            if ($validation->passed()) {
                try {
                    $user->update([
                        'name' => Input::get('name')
                    ]);

                    Session::flash('home', 'Your details have been updated.');
                    Redirect::to('index.php');

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                foreach ($validation->errors() as $error) {
                    echo $error, '<br>';
                }
            }


        }

    } else {
        echo 'Recaptcha gone wrong';
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
    <script src='https://www.google.com/recaptcha/api.js?render=<?= SITE_KEY; ?>'></script>
</head>
<body>
<form action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo escape($user->data()->name) ?>">
        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
        <input type="submit" value="update">
    </div>
</form>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('<?php echo SITE_KEY ?>', {action: 'homepage'}).then(function(token) {
        document.getElementById("g-recaptcha-response").value= token;
        });
    });
</script>

</body>
</html>


