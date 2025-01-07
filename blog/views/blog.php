<?php

require('../config/constants.php');



try {
    $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,  DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM posts");
    $stmt->execute();
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// echo '<pre>';
// print_r($array);
// echo '</pre>';


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Grid</title>
</head>
<body>

    <h1>Blog</h1>
    <p>A captivating Blog Project</p>

    <div class="ka-blog-grid">
        <?php
            foreach($array as $item) {
                echo '<div class="ka-blog-item">';
                echo '<div class="ka-blog-img"';
                echo '<img src="' . $item['post_img'] . '"/>';
                echo '<div class="ka-blog-title"';
                echo '<h2>' . $item['post_title'] . '</h2>';
                echo '<span class="ka-blog-author"> By ' . $item['post_date'];
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        ?>
    </div>

    
</body>
</html>