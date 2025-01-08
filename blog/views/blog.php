<?php

require('../config/constants.php');
include('../views/menu.php');
include_once('../config/session_start.php');

$get = $_GET['post_id'] ?? '';

if (!empty($get)) {
    header('Location: ' . './single.php' . '?post_id=' . $get);
}

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM posts");
    $stmt->execute();
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../blog.css">
    <title>Blog Grid</title>
</head>
<body>

    <h1>Blog</h1>
    <p>A captivating Blog Project</p>

    <div class="ka-blog-grid">
        <?php
            foreach($array as $item) {
                echo '<a class="ka-blog-item" href=?post_id=' . $item['post_id'] . '>';
                echo '<div class="ka-blog-img">';
                echo '<img src="' . $item['post_img'] . '"/>';
                echo '<div class="ka-blog-title">';
                echo '<h2>' . $item['post_title'] . '</h2>';
                echo '<span class="ka-blog-author"> By ' . $_SESSION['author_name'] . ' Date: ' .  $item['post_date'];
                echo '</div>';
                echo '</div>';
                echo '</a>';
            }
        ?>
    </div>

    
</body>
</html>