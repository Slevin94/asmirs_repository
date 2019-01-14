<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
#Diese page sollte optimalerweiße nicht seperat sein sondern teil von vote-result werden
$username = "andreas";
$password = "yF1K^R6Jqh8IbK9";
$dbname = "freepoll";
$servername = "localhost";
$con=mysqli_connect("localhost","$username","$password","$dbname");

session_start();
$id_des_polls = $_SESSION["poll-id"];

$sql = "SELECT * FROM poll_option WHERE poll_id = '$id_des_polls'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["option_name"] . " hat " . $row["count"] . " Stimmen " . "<br>";
    }
} else {
    echo "No Results for your Query";
}
?>