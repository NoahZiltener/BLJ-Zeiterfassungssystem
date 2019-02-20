<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

function gethoechsteid($selecteduserstampsID){
  foreach ($selecteduserstampsID as $ID) {
    $ID = $ID['StampID'];
  }
  return $ID;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correctstampsbutton'])){
  $_SESSION['userauswahlcorrectstamps'] = trim($_POST['userauswahlcorrectstamps'] ??'');
  $_SESSION['correctstampsdate'] = trim($_POST['correctstampsdate'] ?? '');
  $stmt1 = $dbh->prepare('SELECT * FROM stamps where UserID = :userauswahlcorrectstamps order by StampDateandTime asc');
  $stmt1->execute([':userauswahlcorrectstamps' => $_SESSION['userauswahlcorrectstamps']]);
  $selecteduserstamps = $stmt1->fetchAll();
  $_SESSION['selecteduserstamps'] = $selecteduserstamps;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aenderbutton'])) {

    $userid = $_SESSION['userauswahlcorrectstamps'];
    $stampdateandtimefromdb = $_POST['stampdateandtimefromdb'];
    $zeit = $_POST['zeit'] . ":00";

    $stmt2 = $dbh->prepare('SELECT * FROM stamps order by StampID asc');
    $stmt2->execute();
    $selecteduserstampsID = $stmt2->fetchAll();

    $höchsteID = gethoechsteid($selecteduserstampsID);

    $stringparts = explode(" ", $stampdateandtimefromdb);

    $zeit = $stringparts[0] . " " . $zeit;

    $stmt = $dbh->prepare("UPDATE `stamps` SET IsIgnored = true WHERE UserID = :UserID AND StampDateandTime = :DayDate");
    $stmt->execute([':DayDate' => $stampdateandtimefromdb, ':UserID' => $userid]);

    $stmt = $dbh->prepare("INSERT INTO `stamps` (StampID, StampDateandTime, StampWorkcode, IsIgnored, UserID) VALUES(:StampID, :StampDateandTime, :StampWorkcode, :IsIgnored, :UserID) ");
    $stmt->execute([':StampID' => $höchsteID + 1, ':StampDateandTime' => $zeit, ':StampWorkcode' => 2, ':IsIgnored' => 0, ':UserID' => $userid]);


  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hinzufuegbutton'])) {

    $userid = $_SESSION['userauswahlcorrectstamps'];
    $stampdateandtimefromdb = $_POST['stampdateandtimefromdb'];
    $zeit = $_POST['zeit'] . ":00";

    $stmt2 = $dbh->prepare('SELECT * FROM stamps order by StampID asc');
    $stmt2->execute();
    $selecteduserstampsID = $stmt2->fetchAll();

    $höchsteID = gethoechsteid($selecteduserstampsID);

    $stringparts = explode(" ", $stampdateandtimefromdb);

    $zeit = $stringparts[0] . " " . $zeit;
    
    $stmt = $dbh->prepare("INSERT INTO `stamps` (StampID, StampDateandTime, StampWorkcode, IsIgnored, UserID) VALUES(:StampID, :StampDateandTime, :StampWorkcode, :IsIgnored, :UserID) ");
    $stmt->execute([':StampID' => $höchsteID + 1, ':StampDateandTime' => $zeit, ':StampWorkcode' => 2, ':IsIgnored' => 0, ':UserID' => $userid]);

    }
 ?>
