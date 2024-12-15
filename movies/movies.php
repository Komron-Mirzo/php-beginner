<?php

$file = 'movies.json';



if (file_exists($file)) {
    $fileArray = file_get_contents($file);
    $movies = json_decode($fileArray, true);
}







    $filter = [
        'year' => isset($_GET['year']) ? $_GET['year'] : 'All years',
        'genres' => isset($_GET['genres']) ? $_GET['genres'] : 'All genres',
    ];



    $filteredMovies = array_filter($movies['movies'], function($filteredMovie ) use ($filter){

           $matchesYear = $filter['year'] == "All years" || $filteredMovie['year'] == $filter['year'];

           $matchesGenres = $filter['genres'] == "All genres" || in_array($filter['genres'], $filteredMovie['genres']);

           return $matchesGenres && $matchesYear;
        
    });
        











?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="movies.css">
    <title>Movies</title>
</head>

<body>


    <h1 class="ka-movies-title">Movies</h1>

    <form method="get" class="ka-movies-form">
        <select name="genres" id="ka-genres" class="ka-genres">
            <?php
            
            echo '<option value="All genres" class="ka-genre"> All Genres </option>';

            foreach ($movies['genres'] as $genre) {
                echo '<option value="' . $genre .  '" class="ka-genre">' .  $genre  .  '</option>';
            }

            ?>
        </select>
        <select name="year" id="ka-years" class="ka-years">

            <?php
            $currentYear = date('Y');

            echo '<option value="All years" class="ka-year"> All Years </option>';

            for ($i = 1930; $i <= $currentYear; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }

            ?>

        </select>
        <input type="submit" value="Filter" class="ka-submit">
    </form>


    <div class="ka-movies">

        <?php

            foreach ($filteredMovies as $index => $movie) {

                echo '<div class="ka-movie-item">';
                echo '<img src="' .  $movie['posterUrl'] . '" class="ka-image" />';
                echo '<div class="ka-movie-content">';
                echo '<span class="ka-movie-title">' . $movie['title'] . '</span>';
                echo '<span class="ka-movie-year">' . $movie['year'] . '</span>';
                echo '<span class="ka-movie-genres">' . implode(', ', $movie['genres']) . '</span>'; 
                echo '</div>';
                echo '</div>';

            }

            if (empty($filteredMovies)) {
                echo '<h3 class="ka-no-movies"> No movies found </h3>';
            }

        ?>

    </div>




</body>

</html>