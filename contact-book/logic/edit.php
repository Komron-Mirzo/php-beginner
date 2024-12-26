<?php
require('../config/connection.php');

$get = $_GET['id'] ?? '';
$img_directory = 'uploads/';  

if ($get) {
    $sql = 'SELECT * FROM contacts WHERE ID =' . $_GET['id'] . ';';
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $current_row = mysqli_fetch_assoc($result);
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $img_name = $current_row['img'];
    
    // Check if the image is uploaded.
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $filepath = $_FILES['img']['tmp_name'];
        $filename = $_FILES['img']['name'];
        $fileSize = filesize($filepath);
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $filetype = finfo_file($fileinfo, $filepath);

        // Check if the file size and type are valid.
        if ($fileSize === 0) {
            die("The file is empty.");
        }

        if ($fileSize > 3145728) {  // Max size 3 MB.
            die("The file is too large.");
        }

        $allowedTypes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg'
        ];

        if (!in_array($filetype, array_keys($allowedTypes))) {
            die("File not allowed.");
        }

        $extension = $allowedTypes[$filetype];
        $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/php-beginner/contact-book/' . $img_directory;  // Full local path.
        $newFilepath = $targetDirectory . $filename;



        // Move the uploaded file to the desired directory.
        if (!move_uploaded_file($filepath, $newFilepath)) {
            die("Can't move file.");
        }


        $img_name = "/php-beginner/contact-book/uploads/" . $filename; 
    }

    // Update the database with new values.
    $sql = "UPDATE contacts 
            SET img = '{$img_name}', 
                first_name = '{$_POST['first_name']}', 
                last_name = '{$_POST['last_name']}', 
                email = '{$_POST['email']}', 
                phone = '{$_POST['phone']}', 
                company = '{$_POST['company']}', 
                language = '{$_POST['language']}' 
            WHERE ID = {$_GET['id']}";

    $edit_row = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {

        header('Location:' . $_SERVER['PHP_SELF'] . '?id=' . $current_row['ID']);
    } else {
        echo 'Edit failed: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/php-beginner/contact-book/main.css">
    <title>Edit Page</title>
</head>
<body>

    <div class="ka-edit-header">
        <h1>Edit Address Info</h1>
        <a href="../contacts.php"><button>Back to Contacts</button></a>
    </div>

    <form method="post" id="edit-form" enctype="multipart/form-data">
        <div class="edit-field">
            <input type="file" name="img" id="img">
            <label for="img"> <img src="<?php echo $current_row['img']; ?>" alt="Current Image" /> </label>
        </div>
        <div class="edit-field">
            <input type="text" name="first_name" id="first_name" value="<?php echo $current_row['first_name']; ?>">
            <label for="first_name">First name</label>
        </div>

        <div class="edit-field">
            <input type="text" name="last_name" id="last_name" value="<?php echo $current_row['last_name']; ?>">
            <label for="last_name"> Last Name</label>
        </div>
        <div class="edit-field">
            <input type="email" name="email" id="email" value="<?php echo $current_row['email']; ?>">
            <label for="email">Email</label>
        </div>
        <div class="edit-field">
            <input type="tel" name="phone" id="phone" value="<?php echo $current_row['phone']; ?>">
            <label for="phone">Phone</label>
        </div>
        <div class="edit-field">
            <input type="text" name="company" id="company" value="<?php echo $current_row['company']; ?>">
            <label for="company">Company</label>
        </div>
        <div class="edit-field">
            <input type="text" name="language" id="language" value="<?php echo $current_row['language']; ?>">
            <label for="language">Language</label>
        </div>
        <div class="edit-field">
            <input type="submit" value="Edit">
        </div>
    </form>

</body>
</html>
