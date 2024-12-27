<?php
function handleFileUpload($file, $uploadDirectory, $maxFileSize = 3145728, $allowedTypes = ['image/png' => 'png', 'image/jpeg' => 'jpg'])
{
    if (!isset($file) || $file['error'] !== 0) {
        return ['success' => false, 'message' => "No file uploaded or an error occurred."];
    }

    $filepath = $file['tmp_name'];
    $filename = $file['name'];
    $fileSize = filesize($filepath);
    $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
    $filetype = finfo_file($fileinfo, $filepath);

    if ($fileSize === 0) {
        return ['success' => false, 'message' => "The file is empty."];
    }

    if ($fileSize > $maxFileSize) {
        return ['success' => false, 'message' => "The file is too large."];
    }

    if (!in_array($filetype, array_keys($allowedTypes))) {
        return ['success' => false, 'message' => "File type not allowed."];
    }

    $extension = $allowedTypes[$filetype];
    $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . $uploadDirectory;
    $newFilepath = $targetDirectory . $filename;

    if (!move_uploaded_file($filepath, $newFilepath)) {
        return ['success' => false, 'message' => "Unable to move the uploaded file."];
    }

    return ['success' => true, 'filepath' => $uploadDirectory . $filename];
}
?>