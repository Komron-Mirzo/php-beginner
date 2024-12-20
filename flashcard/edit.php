<?php

require('globals.php');


if($get['edit_id']) {

    $editIndex = $_GET['edit_id'];

    $editArrayItem = $array[$editIndex];

    // echo '<pre>';
    // print_r($editArrayItem);
    // echo '</pre>';
}


if ($get['word-edit'] && $get['translation-edit'] && $get['category-edit'] && $get['edit_id-edit']) {
    $editRow = $array[$_GET['edit_id-edit']];

    $editRow['word'] = $_GET['word-edit'];
    $editRow['translation'] = $_GET['translation-edit'];
    $editRow['category'] = $_GET['category-edit'];

    $array[$_GET['edit_id-edit']] = $editRow;


    // echo '<pre>';
    // print_r($array);
    // echo '</pre>';

    file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));
    
    header("Location: flashcard.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="flashcard.css">
    <title>Edit page</title>
</head>
<body>

    <h1>Edit the Table row</h1>

    <form method="get" id="ka-flashcard-form-edit">
        <input type="hidden" name="edit_id-edit" value="<?php echo $editIndex ?>">
        <input type="text" name="word-edit" id="ka-word-edit" placeholder="<?php echo $editArrayItem['word'] ?> ">
        <input type="text" name="translation-edit" id="ka-translation-edit" placeholder="<?php echo $editArrayItem['translation'] ?>">
        <select name="category-edit" id="ka-category-edit">

            <?php

            foreach ($categories as $category) {

                if ($editArrayItem['category'] == $category ) {
                    $selectedOption = '<option selected value="';
                } else {
                    $selectedOption = '<option value="';
                }
                
                

                echo $selectedOption . $category . '">' . $category . '</option>';
            }

            ?>

        </select>

        <input type="submit" value="Save">
    </form>

    
</body>
</html>