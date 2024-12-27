<?php
require('../config/connection.php');
require('../logic/upload-file.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $img_name = '';

    if (isset($_FILES['add-img']) && $_FILES['add-img']['error'] === UPLOAD_ERR_OK) {
        $uploadDirectory = '/php-beginner/contact-book/uploads/';
        $uploadResult = handleFileUpload($_FILES['add-img'], $uploadDirectory);
    
        if ($uploadResult['success']) {
            $img_name = $uploadResult['filepath'];
            echo $img_name;
        } else {
            die($uploadResult['message']);
        }
    }


    $sql = "INSERT INTO contacts (img, first_name, last_name, email, phone, company, language)
            VALUES ('{$img_name}',
                    '{$_POST['add-first-name']}',
                    '{$_POST['add-last-name']}',
                    '{$_POST['add-email']}',
                    '{$_POST['add-phone']}',
                    '{$_POST['add-company']}',
                    '{$_POST['add-language']}');";
   
    $add_contact = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn) > 0){
        
        header('Location: ../contacts.php');

    } else {
        echo 'Failed to add . ' . mysqli_error($conn);
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../main.css">
    <title>Add Page</title>
</head>
<body>

    <div class="ka-edit-header">
        <h1>Add a New Contact</h1>
        <a href="../contacts.php"><button>Back to Contacts</button></a>
    </div>

    <form method="post" id="add-contact" enctype="multipart/form-data">
        <div class="add-field">
            <input type="file" name="add-img" id="add-img" required>
            <label for="add-img">Upload an image</label>
        </div>
        <div class="add-field">
            <input type="text" name="add-first-name" id="add-first-name" required>
            <label for="add-first-name">First name</label>
        </div>
        <div class="add-field">
            <input type="text" name="add-last-name" id="add-last-name" required>
            <label for="add-last-name">Last name</label>
        </div>
        <div class="add-field">
            <input type="email" name="add-email" id="add-email" required>
            <label for="add-email">Email</label>
        </div>
        <div class="add-field">
            <input type="tel" name="add-phone" id="add-phone" required>
            <label for="add-phone">Phone</label>
        </div>
        <div class="add-field">
            <input type="text" name="add-company" id="add-company" required>
            <label for="add-company">Company</label>
        </div>
        <div class="add-field">
            <input type="text" name="add-language" id="add-language" required>
            <label for="add-language">Language</label>
        </div>
        <input type="submit" value="Add">
    </form>
    
</body>
</html>