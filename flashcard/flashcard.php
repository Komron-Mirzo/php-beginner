
<?php 

require('logic.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="flashcard.css">
    <title>Flashcards</title>
</head>

<body>

    <h1>Add Flashcard</h1>
    <form method="get" id="ka-flashcard-form">
        <input type="text" name="word" id="ka-word">
        <input type="text" name="translation" id="ka-translation">
        <select name="category" id="ka-category">

            <?php

            foreach ($categories as $category) {
                echo '<option value="' . $category . '">' . $category . '</option>';
            }

            ?>

        </select>

        <input type="submit" value="Add">
    </form>

    <h2>Flashcards List</h2>

   
        <table border="1">
            <tr>
                <th> ID </th>
                <th> Word </th>
                <th> Translation </th>
                <th> Category </th>
                <th> Delete </th>
                <th> Edit </th>
            </tr>

            <?php

            

            foreach ($array as $index => $item) {
                echo '<tr>';
                echo '<td>' . $index + 1 . '</td>';
                echo '<td>' . $item['word'] . '</td>';
                echo '<td>' . $item['translation'] . '</td>';
                echo '<td>' . $item['category'] . '</td>';
                echo '<td>' . '<a href="?delete_id=' . $index . '">' . '<button> Delete </button>' . '</a>' . '</td>';
                echo '<td>' . '<a href="?edit_id=' . $index . '">' . '<button> Edit </button>' . '</a>' . '</td>';
                echo '</tr>';
            }

            ?>

        </table>




    
    <!-- 
    1) Display All flashCards in separate php file with button it opens this page;
    2) Add filter for flashcard by category;
    3) For Add/Delete Table:
        - Change the simple table into Form->table version;
        - Add Edit inline rows functionality;
        - Add Table filter by category;
    -->


</body>

</html>



