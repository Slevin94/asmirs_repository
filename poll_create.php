<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
# Anlegung der Polls an der Datenbank mit ID
# Zuerst verbindung aufbauen

# Diese Felder hier dürfen nicht privat gesetzt werden. Sonst funktioniert nichts.
    $username = "andreas";
    $password = "yF1K^R6Jqh8IbK9";
    $dbname = "freepoll";
    $servername = "localhost";

# https://stackoverflow.com/questions/21066386/making-dynamic-straw-poll vorangehende DB logik hier festgelegt mit bsp.
# https://www.w3schools.com/php/php_mysql_insert.asp referenz material fürs einschreiben in die DB
# poll create hat id, poll_name welcher die frage selbst ist und timestamp_create was die Uhrzeit ist

try {
    # Falls nötig, hier timestamp form. DB kann aber timestamps automatisch anlegen was hier passiert
    #   $t=time();
    #   $timestamp = date("Y.m.d-H:i:s");
    # https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string timestamp syntax beispiele für
    # manuelle Formatierung
    #
    # Was fehlt hier ist das anstelle das manuelle eintragen hier das ganze durch felder passiert. Also variablen austauschen etc.
    # Um es zum funktionieren zu bringen.
    # Was noch fehlt hier ist es zu verhindern das der selbe user zu viele umfragen gleichzeitig erstellt ergo if statements

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # Erstellung einer einzigartigen ID für den Poll selbst, abgleichung mit datenbank muss nicht erfolgen
    # da uniqid(); absolut einzigartig ist. Ist zwar vorhersehbar aber einzigartig.
    # Hier kommt noch hin die IP Adressen erkennung welche noch auf dem Heimrechner hinterlegen ist
    $id_poll = uniqid();
    $id_vote = uniqid();
    $content_title = $_POST['title'];
    if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
          } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARD_FOR"];
            } else {
        $ip = $_SERVER["REMOTE_ADDR"];
        }

    # ---------------------------HIER WIRD DER POLL SELBST ERSTELLT----------------------------------------
    # die '  ' nicht vergessen bei den VALUES
    # poll kennt lediglich id, poll_name und timestamp_create
    # Dies muss nur einmal passieren
    $sql = "INSERT INTO poll (id, poll_name)
    VALUES ('$id_poll', '$content_title')";
    $conn->exec($sql);

    # ---------------------------HIER WERDEN DIE OPTIONEN HINZUGEFÜGT----------------------------------------
    # poll_option kennt id, option_name, poll_id und ein placeholder1
    # poll_id referenziert die id von poll_create welche die gleiche sein muss um eine ausgabe sinnig zu machen
    # id ist die option id selbst, diese ist immer gleich für alle optionen.

    for($i = 1; $i <= 30; $i++) {
    if(isset($_POST['question' . $i])) {
         $id_option = uniqid();
         $content_satzfrage = $_POST['question' . $i];
         $sql = "INSERT INTO poll_option (id, option_name, poll_id)
         VALUES ('$id_option', '$content_satzfrage', '$id_poll')";
         $conn->exec($sql);
    }
}

    # ---------------------------HIER WIRD DER VOTE HINTERLEGT----------------------------------------
    # POLL_VOTE kennt id, ip_used und timestamp_vote jedoch wird der timestamp wie bei poll automatisch von der db erstellt
    $sql = "INSERT INTO poll_vote (id, ip_used)
    VALUES ('$id_vote', '$ip')";
    $conn->exec($sql);
    echo "Deine IP Adresse ist: " . $ip . " ";
    echo "Umfrage wurde erstellt. ";

    session_start();
    $_SESSION["id_poll"] = $id_poll;
    $_SESSION["die_frage"] = $content_title;
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>

    <a href="v_new_vote_page.php">Klicke hier um zur Umfragepage zu kommen</a>