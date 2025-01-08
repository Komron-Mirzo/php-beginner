<?php

include('../views/menu.php');
include('../config/session_start.php');
require('../config/constants.php');


$get_id = $_GET['edit_id'] ?? '';

if (!empty($get_id)) {
    
    try{
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Displaying current post content from database
        $stmt = $conn->prepare('SELECT * FROM posts WHERE post_id = ?');
        $stmt->execute([$get_id]);
        $array = $stmt->fetch();

        //Editing Logic
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post_title = sanitize_string($_POST['edit_post_title'] ?? '');
            if (empty($post_title)) {
                echo 'Post title cannot be an empty';
            }
    
            $post_content = sanitize_ckeditor_content($_POST['edit_post_content'] ?? '');
            if (empty($post_content)) {
                echo 'Post content cannot be an empty';
            }
    
            if (isset($_FILES['edit_post_img']) && $_FILES['edit_post_img']['error'] === UPLOAD_ERR_OK) {
                $post_img = custom_upload_image($_FILES['edit_post_img']);
            } else {
                $post_img = $array['post_img'];
            }
    
            $stmt= $conn->prepare('UPDATE posts SET post_title = ?, post_img = ?, post_content = ?
                                   WHERE author_id = ? AND post_id = ?');
            $success = $stmt->execute([$post_title, $post_img, $post_content, $_SESSION['author_id'], $get_id]);
    
            if ($success) {
                header("Location: ?post_id=$get_id");
                exit();
            }
        }

    }
    catch (PDOException $e) {
        echo 'Connection failed ' . $e;
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="../blog.css">
    <title>Edit Post</title>
</head>
<body>

<div class="main-content-add">
        <div class="author-container">
            <?php echo '<h3>Welcome, ' . $_SESSION['author_name'] . '</h3>'  ?>
            <div class="author-posts">
                <div class="author-inner-posts">
                    <a href="../admin/add.php">
                        <button>
                            Add new post
                        </button>
                    </a>
                    
                </div>
            </div>
        </div>
        <div class="add-container">
            <h1>Edit the Post</h1>
            <form action="" method="post"  enctype="multipart/form-data">
                <div class="edit-post-field">
                    <input type="text" name="edit_post_title" id="post_title" required value="<?php echo $array['post_title'] ?>">
                    <label for="edit_post_title">Edit Post title</label>
                </div>
                <div class="edit-post-field">
                    <input type="file" name="edit_post_img" id="edit_post_img" value="<?php echo $array['post_img'] ?>">
                    <img height="150" width="150" src="<?php echo $array['post_img'] ?>" />
                    <label for="edit_post_img">Upload Post Image</label>
                </div>
                <textarea name="edit_post_content" id="edit_post_content" required></textarea>
                <input type="submit" value="Edit Post">

            </form>
        </div>
    </div>
   
    <script>
        CKEDITOR.replace('edit_post_content');

        // Dynamically set the content for CKEditor
        const postContent = <?php echo json_encode(html_entity_decode($array['post_content'])); ?>;
        CKEDITOR.instances.edit_post_content.setData(postContent);
    </script>



    
</body>
</html>