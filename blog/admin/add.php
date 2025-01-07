<?php

require('../config/constants.php');




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
        selector: '#add_post_content', // Target the textarea by its ID or class
        plugins: 'advlist autolink link image lists charmap print preview',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
        menubar: false // Disable the top menu if not needed
    });
</script>

    <title>Add New Post</title>
</head>
<body>

    <h1>Add a new post</h1>

    <form action="" method="post">
        <div class="add-post-field">
            <input type="text" name="add_post_title" id="add_post_title">
            <label for="add_post_title">Post title</label>
        </div>
        <div class="add-post-field">
            <input type="text" name="add_post_content" id="add_post_content">
            <label for="add_post_content">Post Content</label>
        </div>
    </form>
    
</body>
</html>

<!-- post_title	post_content	post_date	post_img -->