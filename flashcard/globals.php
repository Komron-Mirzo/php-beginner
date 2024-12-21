<?php


$file = 'flashcard.json';

if (file_exists($file)) {
    $array = json_decode(file_get_contents($file), true);
}


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


$get = [
    'word' => isset($_GET['word']) ? $_GET['word'] : '',
    'translation' => isset($_GET['translation']) ? $_GET['translation'] : '',
    'category' => isset($_GET['category']) ? $_GET['category'] : '',
    'word-edit' => isset($_GET['word-edit']) ? $_GET['word-edit'] : '',
    'translation-edit' => isset($_GET['translation-edit']) ? $_GET['translation-edit'] : '',
    'category-edit' => isset($_GET['category-edit']) ? $_GET['category-edit'] : '',
    'edit_id-edit' => isset($_GET['edit_id-edit']) && $_GET['edit_id-edit'] !== '',
    'delete_id' => isset($_GET['delete_id']) ? $_GET['delete_id'] : '',
    'edit_id' => isset($_GET['edit_id']) && $_GET['edit_id'] !== ''
];



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





if ($get['delete_id'] && !$get['edit_id']) {
    $getIndex = $get['delete_id'];

    unset($array[$getIndex]);

    $array = array_values($array);


    file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));

    
    // $queryString = $_SERVER['QUERY_STRING'] && in_array($_SERVER['QUERY_STRING'], $categories) ? '?' . $_SERVER['QUERY_STRING'] : '';

    // echo '<pre>';
    // print_r($_SERVER);
    // echo '</pre>';



    header("Location: " . $_SERVER['PHP_SELF'] . $queryString);
    exit();

}


if ($get['edit_id'] && !$get['delete_id'] && $_SERVER['PHP_SELF'] !== '/php-beginner/flashcard/edit.php') {  
    $getIndex = $_GET['edit_id'];

    header("Location: edit.php?edit_id=" . $getIndex);
    exit();  
}



?>