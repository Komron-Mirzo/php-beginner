<?php 

$file = 'login.json';

$post = [
    'login' => htmlspecialchars($_POST['signup-login'] ?? '', ENT_QUOTES, 'UTF-8'),
    'password' => (isset($_POST['signup-pass']) && isset($_POST['signup-pass-confirm'])) && $_POST['signup-pass'] === $_POST['signup-pass-confirm'] ? $_POST['signup-pass'] : '',
];


if (file_exists($file)) {

    $array = json_decode(file_get_contents($file), true);
}



if ($post['login'] && $post['password']) {

    $login = htmlspecialchars($_POST['signup-login'] ?? '', ENT_QUOTES, 'UTF-8');

    $hashed_password = password_hash($_POST['signup-pass'], PASSWORD_DEFAULT);

    $single_array =  ["login" => $login, "password" => $hashed_password];

    array_push($array, $single_array);

    // echo '<pre>';
    // print_r($array);
    // echo '</pre>';

    if (file_exists($file)) {
        file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));

        echo 'You are signed up successfully. Please login!';

        if (file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT)) === false) {
            echo 'Error in writing to JSON';
        }
    }

    array_values($array);


    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>

    <h1>Signup</h1>

    <form action="" method="post">

        <div class="login">
            <input type="text" name="signup-login" id="signup-login" required>
            <label for="signup-login">Login</label>
        </div>

        <div class="password">
            <input type="password" name="signup-pass" id="signup-pass" required>
            <label for="signup-pass">Password</label>
        </div>
        <div class="password">
            <input type="password" name="signup-pass-confirm" id="signup-pass-confirm" required>
            <label for="signup-pass-confirm">Confirm Password</label>
        </div>
        
        <button type="submit">Signup</button>
    </form>

    <a href="login.php">Have an account? Login</a>

    <h2></h2>
    
</body>
</html>