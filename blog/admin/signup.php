<?php

require('../config/constants.php');



try {   
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = sanitize_string($_POST['author_name'] ?? '');
        if (empty($name) || strlen($name) < 2) {
            echo 'Name should be at least 2 characters';
        }

        $email = filter_var($_POST['author_email'] ?? '', FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email is written';
        }

        $password = $_POST['author_password'] ?? '';
        if (empty($password) && strlen($password) < 8 ) {
            echo 'Password should be at least 8 characters';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }

        $stmt = $conn->prepare('INSERT INTO author (author_name, author_email, author_password)
                                VALUES (?,?,? );');
        $success = $stmt->execute([$name, $email, $hashed_password]);

        if ($success) {
            echo 'Records saved successfuilly';
        }

    }



}
catch (PDOException $error) {
    echo 'Connection is failed:' . $error->getMessage();
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

    <h1>Signup as Author</h1>

    <form action="" method="post">
        <div class="author-field">
            <input type="text" name="author_name" id="author_name" required>
            <label for="author_name">Enter Your Name</label>
        </div>
        <div class="author-field">
            <input type="email" name="author_email" id="author_email" required>
            <label for="author_email">Email</label>
        </div>
        <div class="author-field">
            <input type="password" name="author_password" id="author_password" required>
            <label for="author_password">Enter Password</label>
        </div>
        <div class="author-field">
            <input type="password" name="author_password_confirm" id="author_password_confirm" required>
            <label for="author_password_confirm">Confirm Password</label>
        </div>
        <input type="submit" value="Register">
    </form>

    <h2>Already have an account? Login instead</h2>
    <a href="login.php"> Login</a>
    
</body>
</html>