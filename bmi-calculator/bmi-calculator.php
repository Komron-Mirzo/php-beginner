<?php


$height = 174;
$weight = 67;


function bmi($height, $weight) {
    if ($height <= 0 || $weight <= 0) {
        return null; 
    }
    $result = $weight / (($height * $height) / 10000) ;
    return number_format($result, 1);
}



$bmiRanges = [
    "Underweight" => [
        "range" => "less than 18.5",
        "description" => "Why don't you eat something, look at you you look like bone"
    ],
    "Normal weight" => [
        "range" => "18.5 - 24.9",
        "description" => "Maaan, you are good!"
    ],
    "Overweight" => [
        "range" => "25 - 29.9",
        "description" => "You starting to get fat, get ready for difficulties"
    ],
    "Obesity Class 1 (Moderate)" => [
        "range" => "30 - 34.9",
        "description" => "I told ya not to eat this shit man, You are FAT class 1 now"
    ],
    "Obesity Class 2 (Severe)" => [
        "range" => "35 - 39.9",
        "description" => "I've told ya thousand times, now u became fucking fat class 2"
    ],
    "Obesity Class 3 (Very severe or morbidly obese)" => [
        "range" => "40 or more",
        "description" => "Maan, how many people are you there, like 10? You are dead FAT"
    ]
];


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['weight']) || isset($_GET['height'])) {
    $height = $_GET['height'];
    $weight = $_GET['weight'];
}


$calculate = bmi($height, $weight);


// Initialize variables for category, range, and description
$category = '';
$range = '';
$description = '';

if ($calculate === null) {
    $errorMessage = 'Please enter valid height and weight values!';
} else {
    // Determine the BMI category and its description
    if ($calculate < 18.5) {
        $category = 'Underweight';
        $range = $bmiRanges['Underweight']['range'];
        $description = $bmiRanges['Underweight']['description'];
    } elseif ($calculate >= 18.5 && $calculate <= 24.9) {
        $category = 'Normal weight';
        $range = $bmiRanges['Normal weight']['range'];
        $description = $bmiRanges['Normal weight']['description'];
    } elseif ($calculate >= 25 && $calculate <= 29.9) {
        $category = 'Overweight';
        $range = $bmiRanges['Overweight']['range'];
        $description = $bmiRanges['Overweight']['description'];
    } elseif ($calculate >= 30 && $calculate <= 34.9) {
        $category = 'Obesity Class 1 (Moderate)';
        $range = $bmiRanges['Obesity Class 1 (Moderate)']['range'];
        $description = $bmiRanges['Obesity Class 1 (Moderate)']['description'];
    } elseif ($calculate >= 35 && $calculate <= 39.9) {
        $category = 'Obesity Class 2 (Severe)';
        $range = $bmiRanges['Obesity Class 2 (Severe)']['range'];
        $description = $bmiRanges['Obesity Class 2 (Severe)']['description'];
    } else {
        $category = 'Obesity Class 3 (Very severe or morbidly obese)';
        $range = $bmiRanges['Obesity Class 3 (Very severe or morbidly obese)']['range'];
        $description = $bmiRanges['Obesity Class 3 (Very severe or morbidly obese)']['description'];
    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bmi.css">
    <title>Document</title>
</head>

<body>

    <div class="bmi-main-container">


    <h2> Write your height and weight </h2>

    <form method="get">
        <label for="height">Height</label>
        <input type="number" name="height" id="height" value="<?php echo isset($_GET['height']) ? $_GET['height'] : $height; ?>">
        <label for="weight">Weight</label>
        <input type="number" name="weight" id="weight" value="<?php echo isset($_GET['weight']) ? $_GET['weight'] : $weight; ?>">
        <input type="submit" value="Calculate">


    </form>

    <?php if (isset($errorMessage)): ?>
    <h3><?php echo $errorMessage; ?></h3>
    <?php else: ?>
        <h1>Output: <?php echo $calculate; ?> </h1>
        <h3>Category: <?php echo $category; ?></h3>
        <h3>Range: <?php echo $range; ?></h3>
        <h3>Description: <?php echo $description; ?></h3>
    <?php endif; ?>

    </div>

</body>

</html>