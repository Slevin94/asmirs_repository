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

    $con=mysqli_connect("localhost","$username","$password","$dbname");
    # SELECT * bedeutet select alles
    $sql = "SELECT * FROM poll_option WHERE poll_id = '$id_poll_id'";
    $result = mysqli_query($con, $sql);
    $i = 0;
    if (mysqli_num_rows($result) > 0) {
        # Ausgabe der inhalte in jeder Zeile
        while($row = mysqli_fetch_assoc($result)) {
            $i++;
            # Code beispiel zur Ausgabe der
            # echo "Die ID der Frage selbst: " . $row["poll_id"] . "<br>";
            # echo "Die ID der Antwortmöglichkeit selbst: " . $row["id"] . "<br>";
            echo "<br>";
            echo "Antwortmöglichkeit " .$i .  ": " . $row["option_name"];

            # zur referenz https://stackoverflow.com/questions/17135192/php-how-can-i-create-variable-names-within-a-loop
            # es werden hier variablen mit den namen option 1-n erstellt. Diese werden mit den optionsnamen gefüllt.
            # echo $$whatever gibt $option1-n aus. $whatever gibt option1-n aus.
            $whatever = "option{$i}";
            $$whatever = $row["option_name"];
            #
            $class = "checkbox";
            ?>
            <!-- name enthält die ID der frage selbst. id wird mit optionN deklariert. D.h otpion1, option2, ...
                type="radio" sind die runden buttons. Man kann checkbox mit class = "radio" die eigentschaften von
                radio buttons verpassen.
                WICHTIG: der name="..." entscheidet ob radio gruppen so funktionieren wie sie gedacht sind.
                Falls die namen unterschiedlich sind werden radio buttons nicht hier so funktionieren.
            -->
            <input type="<?php echo $class ?>"  name="<?php echo $row["id"]?>" id="<?php echo $whatever ?>"
            <?php
            echo "<br>";
        }
    } else {
        echo "No Results for your Query";
}
    ?>
    <form action="vote_result.php" method="post">
    <input type="submit" value="Wahl abgeben">
    </form>
    <?php
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}



?>