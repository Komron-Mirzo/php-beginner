<!-- menu.php -->

<?php

$logged_in = $_SESSION['author_name'] ?? '';


?>


<nav>
    <ul>
        <li><a href="../views/blog.php">Blog Page</a></li>
        <?php
            if(!empty($logged_in)) {
                echo '<li><a href="../admin/add.php">Admin Page</a></li>';
                echo '<li><a href="?logout=true">Logout</a></li>';
            } else {
                echo '<li><a href="../admin/login.php">Login</a></li>';
            }
        ?>
            
            

    </ul>
</nav>
