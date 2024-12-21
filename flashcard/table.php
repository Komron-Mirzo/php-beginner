<?php

include('globals.php');


$getSort = [
    'word_sort' => isset($_GET['word_sort']) ? $_GET['word_sort'] : '',
    'translation_sort' => isset($_GET['translation_sort']) ? $_GET['translation_sort'] : '',
    'category_sort' => isset($_GET['category_sort']) ? $_GET['category_sort'] : '',
];


// Simple if-else version of usort
if($getSort['word_sort'] && $_GET['word_sort'] == 'asc'){

    usort($array, function($a, $b) {
        return strcasecmp($a['word'], $b['word']);
    });

} else if ($getSort['word_sort'] && $_GET['word_sort'] == 'desc') {
    usort($array, function($a, $b) {
        return strcasecmp($b['word'], $a['word']);
    });
}


// Enhanced version of above's if-else usort
if ($getSort['translation_sort']) {

    $translationSort = ($_GET['translation_sort'] == 'desc') ? -1 : 1;

    usort($array, function ($a, $b) use ($translationSort){
        return $translationSort * strcasecmp($a['translation'], $b['translation']);
    }); 

}


foreach ($categories as $category) {

    if ($getSort['category_sort'] && $_GET['category_sort'] === $category && $category !== null) {

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
    <link rel="stylesheet" href="flashcard.css">
    <title>Table</title>
</head>
<body>

    <div class="ka-table-button">
        <button onclick="window.location.href='flashcard.php';">Go to Homepage</button>
    </div>

    <h1>All Flashcards List</h1>

   
        <table border="1">
            <tr>
                <th> ID </th>
                <th> <a href="?word_sort=<?php echo $getSort['word_sort'] && $_GET['word_sort'] =="asc" ? "desc" : "asc" ?> " style="color: inherit"> Word </a> </th>
                <th> <a href="?translation_sort=<?php echo $getSort['translation_sort'] && $_GET['translation_sort'] =="asc" ? "desc" : "asc" ?> " style="color: inherit"> Translation </a> </th>
                <th>
                    <form method="get" id="category_sort_form">
                        <select name="category_sort" id="category_sort" onchange="this.form.submit()">
                            <?php

                                

                                echo '<option value="All categories"> All categories </option>';

                                foreach ($categories as $category) {

                                    $selected = $getSort['category_sort'] && $_GET['category_sort'] === $category ? 'selected' : '';

                                    echo '<option value="' . $category . '"' .  $selected .  '>'. $category . '</option>';
                                }
                            ?>
                        </select>
                    </form>
                </th>
                <th> Delete </th>
                <th> Edit </th>
            </tr>

            <?php
            
            if (!empty($array)) {
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
            } else {
                echo '<tr>';
                echo '<td>' . 'No' . '</td>';
                echo '<td>' . 'Flashcards' . '</td>';
                echo '<td>' . 'Found' . '</td>';
                echo '<td>' . '</td>';
                echo '<td>' . '</td>';
                echo '<td>' . '</td>';
                echo '</tr>';
            }
          

            ?>

        </table>



</body>
</html>