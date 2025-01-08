<?php


require('../config/constants.php');


$get_id = $_GET['delete_id'] ?? '';

if (!empty($get_id)) {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare('DELETE FROM posts WHERE post_id = ?');
        $stmt->execute([$get_id]);

        if ($stmt->rowCount() > 0) {
            header('Location: ./add.php');
        }

    }

    catch (PDOException $e) {
        echo 'Connection failed: ' . $e;
    }
}


?>


