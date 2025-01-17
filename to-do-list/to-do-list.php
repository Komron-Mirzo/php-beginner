<?php

class Tasks {

    public $title;
    public $task;
    public bool $status;

    public function __construct($title, $task, $status){
        $this->title = $title;
        $this->task = $task;
        $this->status = $status;
    }


}


$file = 'todo.json';

if (file_exists($file)) {
    $array = json_decode(file_get_contents($file), true );
} else {
    $array = [];
}

$newTask = new Tasks("Food", "Cooking food", false);



if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['title']) && isset($_POST['task'])) ) {
    $newTask->title = $_POST['title'];
    $newTask->task = $_POST['task'];
    $array[] = [
        "title" => $_POST['title'],
        "task" => $_POST['task'],
        "status" => 'false',
    ];

    file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));
}




if (isset($_GET['delete_id'])) {
    $deleteItem = $_GET['delete_id'];
    unset($array[$deleteItem]);
    file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));
    
    $array = array_values($array);

    header("Location: to-do-list.php");
    exit();
}


if (isset($_GET['edit_id'])) {
    $currentIndex = $_GET['edit_id'];

    $editItem = $array[$currentIndex];
    
    if ($editItem['status'] === false) {
        $editItem['status'] = true;
    } else {
        $editItem['status'] = false;
    }

    $array[$currentIndex] = $editItem;

    // echo '<pre>';
    // print_r($array);
    // print_r($editItem);
    // echo '</pre>';

    file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));

    $array = array_values($array);

    header("Location: to-do-list.php");
    exit();



    
}





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="todo.css">
    <title>Document</title>
</head>
<body>

    <h1>To-Do List App</h1>

    <h2>Add To-Do </h2>

    <form method="post" id="to-do-list">
        <input type="text" name="title" id="title" value="">
        <input type="text" name="task" id="task" value="">
        <input type="submit" value="Add">
    </form>

    <h2> All Tasks</h2>

    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>Task Title</th>
                <th>Task Description</th>
                <th>Status</th>
                <th>Delete</th>           
            </tr>
        </thead>
        <tbody>
          
            
            <?php

            foreach($array as $index => $task) {

                echo '<tr>';


                if (!empty($array)) {

                    $taskTitle = isset($task['title']) ? $task['title'] : '';
                    $taskItem = isset($task['title']) ? $task['task'] : '';

                    if (isset($task['status']) && $task['status'] === true) {
                        $taskEdit = '<a href="?edit_id=' .  $index  .  '">' . '<button class="finished">Finished</button>' .'</a>';
                    } else {
                        $taskEdit =  '<a href="?edit_id=' .  $index  .   '">' . '<button class="planned">Planned</button>' .'</a>';
                    }
    

                }
                
                echo '<td>' . $index . '</td>';
                echo '<td>' . $task['title'] .'</td>';
                echo '<td>' . $task['task'] . '</td>';


                
                echo '<td>' . $taskEdit . '</td>';


                echo '<td><a href="?delete_id=' .  $index   .   '">' . '<button>Delete</button>' .'</a></td>';

                echo '</tr>';

            }

            ?>

            
        </tbody>
    </table>



</body>
</html>