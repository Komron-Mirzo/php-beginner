<?php

include('globals.php');


$getGrid = [
    'category-grid' => isset($_GET['category-grid']) ? $_GET['category-grid'] : '',
];






foreach ($categories as $category) {

    if ($getGrid['category-grid'] && $_GET['category-grid'] === $category && $category !== null) {

        $array = array_filter($array, function ($arrayItem) use ($category) {
            return $arrayItem['category'] === $category;
        });    
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grid Flashcards</title>
    <link rel="stylesheet" href="flashcard.css">
</head>
<body>

    <div class="ka-table-button">
        <button onclick="window.location.href='flashcard.php';">Add New Flashcard</button>
        <button onclick="window.location.href='table.php';">Edit Flashcards</button>
    </div>

    <h1>Flashcard Grid List</h1>

    <form method="get" class="ka-grid-category">


        <?php

            foreach($categories as $index => $category) {
                echo '<div class="ka-grid-category-item">';
                echo '<input onchange="this.form.submit()" type="radio" name="category-grid" class="ka-grid-radio"' . 'value="'. $category . '" id="ka-grid-label-'. $index . '">';
                echo '<label for="ka-grid-label-' . $index .  '" class="ka-grid-label">' . $category . '</label>';
                echo '</div>';
            }
            
        ?>

        
    </form>

    <div class="ka-flashcard-grid">
        <?php
        foreach($array as $arrayItem) {

            echo '<div class="ka-flashcard-item">';
            echo '<div class="ka-flashcard-inner">';
            echo '<div class="ka-flashcard-word">' . $arrayItem['word'] . '</div>';
            echo '<div class="ka-flashcard-translation">' . $arrayItem['translation'] . '</div>';
            echo '</div>';
            echo '</div>';

        }
        ?>
    </div>
    
    
</body>
</html>