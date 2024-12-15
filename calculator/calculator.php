<?php


class Calculator {
    public $a;
    public $b;
    public $result;

    public function __construct($a, $b) {
        $this->a = $a;
        $this->b = $b;
    } 

    public function add ($a, $b) {
        $this->result = $a +$b;
        return $this->result;
    }

    public function subtract ($a, $b) {
        $this->result = $a - $b;
        return $this->result;
    }

    public function multiply ($a, $b) {
        $this->result = $a * $b;
        return $this->result;
    }

    public function divide ($a, $b) {
        $this->result = $a / $b;
        return $this->result;
    }


}


$obj = new Calculator(10,25);


// Check if form is submitted and update $obj->a if necessary
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['a']) || isset($_GET['b'])) {
        $obj->a = $_GET['a']; // Update $obj->a with the value from the form
        $obj->b = $_GET['b'];
    }
}




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="calculator.css">
    <title>Document</title>
</head>
<body>

    <h1> Calculator App </h1>

    <div class="calculator">

        <h2 class="screen">
                <?php 

                // if ($_GET['function'] === "add") {
                //     echo $obj->add($obj->a, $obj->b);
                // } else if ($_GET['function'] === "subtract") {
                //     echo $obj->subtract($obj->a, $obj->b);
                // } else if ($_GET['function'] === "multiply") {
                //     echo $obj->multiply($obj->a, $obj->b);
                // } else if ($_GET['function'] === "divide") {
                //     echo $obj->divide($obj->a, $obj->b);
                // }



                switch(isset($_GET['function']) ? $_GET['function'] : "add") {
                    case "subtract":
                        echo $obj->subtract($obj->a, $obj->b);
                        break;
                    case "multiply":
                        echo $obj->multiply($obj->a, $obj->b);
                        break;
                    case "divide":
                        echo $obj->divide($obj->a, $obj->b);
                        break;
                    default:
                            echo $obj->add($obj->a, $obj->b);
                
                }


                ?>
        </h2>

        <form method="GET">

            <input type="number" name="a" value="<?php echo $obj->a; ?>" />

            <select name="function" id="function">
                <option value="add" default>Add</option>
                <option value="subtract">Subtract</option>
                <option value="multiply">Multiply</option>
                <option value="divide">Divide</option>
            </select>
        

            <input type="number" name="b" value="<?php echo $obj->b; ?>" />
            <input type="submit" value="Calculate"> </submit>
            



            

        </form>

    </div>


    
</body>
</html>








