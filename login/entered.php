<?php

session_start();

$get = $_GET['exit'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset();
    session_destroy();

    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'] ?? 'No user';

echo $user;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entered</title>
</head>
<body>
    
    <h1>Hi there, <?php echo $_SESSION['user'] ?>! Welcome to your account</h1>

    <form action="" method="POST">
        <button type="submit">Exit</button>
    </form>

</body>
</html>