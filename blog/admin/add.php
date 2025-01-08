<?php

require('../config/constants.php');
include_once('../config/session_start.php');
include('../views/menu.php');


try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Adding a new Post Logic
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $post_title = sanitize_string($_POST['add_post_title'] ?? '');
        if (empty($post_title)) {
            echo 'Post title cannot be an empty';
        }

        $post_content = sanitize_ckeditor_content($_POST['add_post_content'] ?? '');
        if (empty($post_content)) {
            echo 'Post content cannot be an empty';
        }

        if (isset($_FILES['add_post_img']) && $_FILES['add_post_img']['error'] === UPLOAD_ERR_OK) {
        $post_img = custom_upload_image($_FILES['add_post_img']);
        }

        $date = date('Y:m:d');

        $stmt= $conn->prepare('INSERT INTO posts (post_title, post_img, post_content, post_date, author_id)
                                VALUES (?, ?, ?, ?, ?)');
        $success = $stmt->execute([$post_title, $post_img, $post_content, $date, $_SESSION['author_id']]);

        if ($success) {
            echo 'Post is saved successfuilly';
        }



    }

    //Author posts display Logic
    $stmt_author_posts = $conn->prepare('SELECT * FROM posts WHERE author_id = ?');
    $stmt_author_posts->execute([$_SESSION['author_id']]);
    $author_posts = $stmt_author_posts->fetchAll(PDO::FETCH_ASSOC);

    //Referring to Edit Post Page

    $edit_id = $_GET['edit_id'] ?? '';
    $delete_id = $_GET['delete_id'] ?? '';

    if (!empty($edit_id)) {
        header('Location:' . '../admin/edit.php' . '?edit_id=' . $_GET['edit_id']);
    } else if (!empty($delete_id)) {
        header('Location:' . '../admin/delete.php' . '?delete_id=' . $_GET['delete_id']);
    }
}
catch (PDOException $error) {
    echo 'Connection failed'. $error;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="../blog.css">
    <title>Add New Post</title>
</head>
<body>

    <div class="main-content-add">
        <div class="author-container">
            <?php echo '<h3>Welcome, ' . $_SESSION['author_name'] . '</h3>'  ?>
            <div class="author-posts">
                <h3>Your Posts</h3>
                <div class="author-inner-posts">
                    
                    <?php
                        foreach($author_posts as $post) {
                            echo '<div class="author-post-item">';
                            echo '<img height="80" width="80" src="' . $post['post_img'] . '"/>';
                            echo '<div class="author-right">';
                            echo '<h5>' . $post['post_title'] . '</h5>';
                            echo '<div class="author-post-date"> Posted: ' . $post['post_date'] . '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '<span>';
                            echo '<a href=?edit_id=' . $post['post_id'] . '>' . 'Edit Post' . '</a>'; 
                            echo '<a class="delete-post" href=?delete_id=' . $post['post_id'] . '>' . 'Delete Post' . '</a>'; 
                            echo '</span>';

                        }
                    ?>
                    
                   
                </div>
            </div>
        </div>
        <div class="add-container">
            <h1>Add a new post</h1>
            <form action="" method="post"  enctype="multipart/form-data">
                <div class="add-post-field">
                    <input type="text" name="add_post_title" id="add_post_title" required>
                    <label for="add_post_title">Post title</label>
                </div>
                <div class="add-post-field">
                    <input type="file" name="add_post_img" id="add_post_img" required>
                    <label for="add_post_img">Add Post Image</label>
                </div>
                <textarea name="add_post_content" id="add_post_content" required></textarea>
                <input type="submit" value="Add Post">

            </form>
        </div>
    </div>
   
    <script>
        CKEDITOR.replace('add_post_content');
    </script>
    
</body>
</html>
