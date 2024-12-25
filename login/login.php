<?php 

session_start();

$file = 'login.json';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post = [
        'login' => htmlspecialchars($_POST['login'] ?? '', ENT_QUOTES, 'UTF-8'),
        'password' => $_POST['password'] ?? '',
    ];

    if(file_exists($file) ) {
        $array = json_decode(file_get_contents($file), true);
    
        foreach($array as $item) {
            if ($post['login'] && $post['password']) {
                
                if ($_POST['login'] === $item['login'] && password_verify($_POST['password'], $item['password'])) {

                    $_SESSION['user'] = $item['login'];

                    header('Location: entered.php');
                    exit();
                }
                
            }
        }
    }
    
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h1>Login</h1>

    <form action="" method="post">

        <div class="login">
            <input type="text" name="login" id="login" required>
            <label for="login">Login</label>
        </div>

        <div class="password">
            <input type="password" name="password" id="password" required>
            <label for="password"></label>
        </div>
        
        <button type="submit">Login</button>
    </form>

    <a href="signup.php">Don't have an account? Signup</a>
    
</body>
</html>