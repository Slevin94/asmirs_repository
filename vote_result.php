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
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
error_reporting( error_reporting() & ~E_NOTICE );
# die ?? '' beseitigen die fehlermeldung die aufkommt wenn option1 nicht gewählt wurde.
# $i = 1;
# echo $_POST['option' . $i] ?? '';




if(isset($_POST['enter'])) {
    for($i = 1; $i <= $_SESSION['max']; $i++) {
        $neu = $_POST['option' . $i];
        if(isset($neu)) {
            $sql = "UPDATE poll_option SET count = count + 1 WHERE id = '$neu'";
            $conn->query($sql);
            echo "successfully updated" . "<br>";
            echo $_POST['option1'] . "<br>";
      }
   }
}





?>


