<?php

require('../contact-book/config/connection.php');

//Get total number of rows from mysql database
$sql_total = 'SELECT COUNT(*) AS total FROM contacts';
$result_total = mysqli_query($conn, $sql_total);

if(mysqli_num_rows($result_total)) {
    $result_total_fetch = mysqli_fetch_assoc($result_total);
}

//Pagination Logic
$item_per_page = 5;
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $item_per_page;
$sql = 'SELECT * FROM contacts ORDER BY ID DESC' . ' LIMIT ' . $item_per_page . ' OFFSET ' . $offset;
$result = mysqli_query($conn, $sql);





//Delete logic
$post = [
    'delete' => $_POST['delete'] ?? ''
];

if($post['delete']) {
    echo '<pre>';
    print_r($_POST['delete']);
    echo '</pre>';

    $delete_ids = implode(', ', $_POST['delete']);
    $sql_delete = 'DELETE FROM contacts WHERE ID IN (' . $delete_ids . ' );';
    $delete_rows = mysqli_query($conn, $sql_delete);

    if(mysqli_affected_rows($conn) > 0) {
        
        header('Location: ' .$_SERVER['PHP_SELF']);
        
    } else {
        echo 'mysql failed: ' . mysqli_error($conn);
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/php-beginner/contact-book/main.css">
    <title>Contacts</title>
</head>
<body>

    <h1>Contacts List</h1>

    <div class="ka-contacts-container">

        <a href="logic/add.php" id="add_button">
            <button type="button">Add new</button>
        </a>


        <form method="post">
            <button type="submit" id="delete_button">Delete</button>

            <br>

            <table class="ka-contacts" border="1">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Language</th>
                    <th>Edit</th>
                </tr>
                    <?php
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . '<input type="checkbox" name="delete[]" value="' . $row['ID'] . '"/>' . '</td>';
                                echo '<td>';
                                echo '<img width="60px" height="60px" src="' . $row['img'] . '"/>';
                                echo $row['first_name'] . ' ' . $row['last_name'];
                                echo '</td>';
                                echo '<td>' . $row['email'] . '</td>';
                                echo '<td>' . $row['phone'] . '</td>';
                                echo '<td>' . $row['company'] . '</td>';
                                echo '<td>' . $row['language'] . '</td>';
                                echo '<td>' . '<a class="edit_button" href=logic/edit.php?id='. $row['ID'] . '>' . 'Edit' . '</a>' .  '</td>';
                                echo '</tr>';
                            }
                        }
                    ?>
            </table>

        </form>
        
        <div class="ka-pages">

            <?php 

                for ($i=1; $i<= ceil($result_total_fetch['total']/$item_per_page); $i++) {
                    echo '<a href=?page=' . $i . '>' . $i . '</a>';
                }

            ?>

        </div>

        

    </div>
    
</body>
</html>