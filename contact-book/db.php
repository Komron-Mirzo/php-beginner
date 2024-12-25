<?php


$conn = mysqli_connect('localhost', 'root', '', 'contact_book');

if (!$conn) {
    die('Connection failed'. mysqli_connect_error());
}


$sql = "INSERT INTO contacts (name, email, phone) VALUES ('FakeName', 'fake@email.com', '+12345678910')";



$selectAll = "SELECT * FROM contacts";


if($conn) {
    $data = mysqli_query($conn, $selectAll);


    if (mysqli_num_rows($data) > 0) {

        while($dataRow = mysqli_fetch_assoc($data)) {
            echo 'Name: ' . $dataRow['name'] . '<br>' . 'Email: ' . $dataRow['email'] . '<br>' . 'Phone: ' . $dataRow['phone'];
        }

    } else {
        echo 'No contacts exist';
    }

    echo '<pre>';
    print_r($data);
    echo '</pre>';

} 



mysqli_close($conn);


?>