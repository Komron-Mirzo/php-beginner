<?php

$file = 'flashcard.json';

class Flashcard
{
    public string $word;
    public string $translation;
    public string $category;

    public function __construct(string $word, string $translation, string $category)
    {
        $this->word = $word;
        $this->translation = $translation;
        $this->category = $category;
    }
}


$categories = [
    "Greetings & Introductions",
    "Numbers",
    "Colors",
    "Days of the Week",
    "Months & Seasons",
    "Time",
    "Family",
    "Food & Drink",
    "Common Verbs",
    "Adjectives",
    "Weather",
    "Common Phrases",
    "Places",
    "Travel Vocabulary",
    "Shopping"
];


if (file_exists($file)) {
    $array = json_decode(file_get_contents($file), true);
}


$get = [
    'word' => isset($_GET['word']) ? $_GET['word'] : '',
    'translation' => isset($_GET['translation']) ? $_GET['translation'] : '',
    'category' => isset($_GET['category']) ? $_GET['category'] : '',
    'delete_id' => isset($_GET['delete_id']) ? $_GET['delete_id'] : '',
];



if ($get['word'] && $get['translation'] && $get['category']) {

    $newFlashCard = new Flashcard($get['word'], $get['translation'], $get['category']);

    $array[] = $newFlashCard;

    file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));

    $array = array_values($array);

    header("Location: flashcard.php");
    exit();
}


if ($get['delete_id']) {
    $getIndex = $get['delete_id'];

    unset($array[$getIndex]);

    $array = array_values($array);


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
        </tr>

        <?php

        foreach ($array as $index => $item) {
            echo '<tr>';
            echo '<td>' . $index + 1 . '</td>';
            echo '<td>' . $item['word'] . '</td>';
            echo '<td>' . $item['translation'] . '</td>';
            echo '<td>' . $item['category'] . '</td>';
            echo '<td>' . '<a href="?delete_id=' . $index . '">' . '<button> Delete </button>' . '</a>' . '</td>';
            echo '</tr>';
        }

        ?>


    </table>



</body>

</html>