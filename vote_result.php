<?php
# Referenz materialien
# https://stackoverflow.com/questions/3866524/mysql-update-column-1
# UPDATE categories SET posts = posts + 1 WHERE category_id = 42;
# Die checkboxen haben die id option1, option2, ...

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    $username = "andreas";
    $password = "yF1K^R6Jqh8IbK9";
    $dbname = "freepoll";
    $servername = "localhost";
    $con=mysqli_connect("localhost","$username","$password","$dbname");
    $counteer = 1;
    if(isset($_POST["option1"])) {
        echo "yeeah";
    } else {
        echo "nooo";
    }



?>


