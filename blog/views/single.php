<?php

require('../config/constants.php');
include('../views/menu.php');



$get_id = $_GET['post_id'] ?? '';




try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM posts WHERE post_id = ?');

    if (!empty($get_id)) {
        $stmt->execute([$get_id]);
        $post_item = $stmt->fetch();
    }


}

catch (PDOException $e) {
    echo 'Connection failed: ' . $e;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../blog.css">
    <title>Single Blog</title>
</head>
<body>

    <img class="single-post" src="<?php echo $post_item['post_img'] ?>" alt="">
    <h1><?php echo $post_item['post_title'] ?></h1>
    <?php echo html_entity_decode($post_item['post_content']) ?>

    <a class="single-button" href="../views/blog.php"> <button>Go back to Blog</button> </a>
    
</body>
</html>