<?php

$host = "localhost";
$db_name = "blog";
$db_user = "root";
$db_pass = "";




try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM posts;");
    
   
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}



?>