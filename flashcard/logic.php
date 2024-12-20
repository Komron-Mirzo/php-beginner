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


if ($get['delete_id']) {
    $getIndex = $get['delete_id'];

    unset($array[$getIndex]);

    $array = array_values($array);


    file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));

    header("Location: flashcard.php");
    exit(); 

}


if ($get['edit_id']) {  
    $getIndex = $_GET['edit_id'];

    header("Location: edit.php?edit_id=" . $getIndex);
    exit();  
}









?>