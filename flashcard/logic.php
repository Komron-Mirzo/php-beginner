<?php

require('globals.php');



if ($get['word'] && $get['translation'] && $get['category']) {

    $newFlashCard = new Flashcard($get['word'], $get['translation'], $get['category']);

    $array[] = $newFlashCard;

    file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));

    $array = array_values($array);

    header("Location: flashcard.php");
    exit();
}












?>