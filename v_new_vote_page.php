<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    # Sollte im refactoring optimiert werden
    $username = "andreas";
    $password = "yF1K^R6Jqh8IbK9";
    $dbname = "freepoll";
    $servername = "localhost";

    # Session start muss auf jeder page vorhanden sein. Es reicht nicht wenn es auf einer einzigen ist.
    session_start();
    $id_poll_id = $_SESSION["id_poll"];
    # Display der frage selbst in der aller ersten Zeile
    $die_frage_who = $_SESSION["die_frage"];
    echo "Frage des Tages! : " . $die_frage_who . "<br>" . "<br>";

    $con = mysqli_connect("localhost", "$username", "$password", "$dbname");
    # SELECT * bedeutet select alles
    $sql = "SELECT * FROM poll_option WHERE poll_id = '$id_poll_id'";
    $result = mysqli_query($con, $sql);
    $i = 0;
    $counter = 0;


    ?>
    <form action="vote_result.php" method="post">
        <input type="submit" name="enter" value="Wahl abgeben">
        <?php
        if (mysqli_num_rows($result) > 0) {
            # Ausgabe der inhalte in jeder Zeile
            while ($row = mysqli_fetch_assoc($result)) {
                $i++;
                $counter++;
                echo "<br>";
                # $row[" name der abfrage tabelle "]
                echo "Antwortmöglichkeit " . $i . ": " . $row["option_name"];

                # zur referenz https://stackoverflow.com/questions/17135192/php-how-can-i-create-variable-names-within-a-loop
                # es werden hier variablen mit den namen option 1-n erstellt. Diese werden mit den optionsnamen gefüllt.
                # echo $$whatever gibt $option1-n aus. $whatever gibt option1-n aus.
                $whatever = "option{$i}";
                $$whatever = $row["id"];
                $class = "checkbox";
                ?>
                <input name="<?php echo $whatever ?>" type="<?php echo $class ?>" value="<?php echo $$whatever?>">
                <?php
            }
        }
        $_SESSION['max'] = $counter;

        ?>

    </form>

<?php
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}



?>