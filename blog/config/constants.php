<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'blog');
define('DB_USER', 'root');
define('DB_PASS', '');

$dsn = 'mysql:host=' . DB_HOST . '; dbname=' . DB_NAME;
$conn = new PDO( $dsn, DB_USER, DB_PASS);

// Custom Sanitize String
function sanitize_string($input) {
    $input = trim($input);
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}



function sanitize_ckeditor_content($input) {
    // Define allowed tags
    $allowed_tags = '<p><a><strong><em><u><ul><ol><li><br><h1><h2><h3><h4><h5><h6>';

    // Remove unwanted tags but keep allowed ones
    $input = strip_tags($input, $allowed_tags);

    // Decode any existing HTML entities (to prevent double escaping)
    $input = htmlspecialchars_decode($input, ENT_QUOTES);

    // Re-escape only necessary characters for safety
    $input = htmlentities($input, ENT_NOQUOTES, 'UTF-8');

    return $input;
}




// Custom Upload File function
function custom_upload_image($file) {
    // Define the target directory for image uploads
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/php-beginner/blog/uploads/images/"; 
    
    // Check if the directory exists and create it if not
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory with appropriate permissions
    }
    
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is a valid image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return "File is not an image.";
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        return "Sorry, file already exists.";
    }

    // Check file size (e.g., max 5MB)
    if ($file["size"] > 5000000) { // 5MB
        return "Sorry, your file is too large.";
    }

    // Allow only certain file formats (e.g., jpg, png, gif)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    // Try to upload the file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        // Return the URL to the uploaded image
        return "/php-beginner/blog/uploads/images/" . basename($file["name"]);
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}



?>