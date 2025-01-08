<?php

require('../config/constants.php');
include_once('../config/session_start.php');

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $stmt= $conn->prepare("SELECT author_id, author_password, author_name FROM author WHERE author_email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0){
            $author = $stmt->fetch();

            echo '<pre>';
            print_r($author);
            echo '</pre>';

            if(password_verify($password, $author['author_password'])) {
                $_SESSION['author_id'] = $author['author_id'];
                $_SESSION['author_name'] = $author['author_name'];
                
                header('Location: add.php');
                
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "Author not found";
        }

    }
    
}

catch (PDOException $error) {
    echo 'Connection failed: ' . $error;
}








?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../blog.css">
    <title>Login</title>
</head>
<body>

    <h1>Login</h1>
    <form action="" method="post">
        <div class="login-field">
            <input type="text" name="email" id="email" required>
            <label for="email">Email</label>
        </div>
        <div class="login-field">
            <input type="password" name="password" id="password" required>
            <label for="password">Password</label>
        </div>
        <input type="submit" value="Login">
    </form>

    <a href="signup.php" target="_blank" rel="noopener noreferrer">Signup</a>
    
</body>
</html>