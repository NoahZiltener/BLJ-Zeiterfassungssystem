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
  $stmt1 = $dbh->prepare('SELECT * FROM stamps where UserID = ' . $_SESSION['userauswahlcorrectstamps']);
  $stmt1->execute();
  $selecteduserstamps = $stmt1->fetchAll();
  $_SESSION['test'] = $selecteduserstamps;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aenderbutton'])) {

    $userid = $_SESSION['userauswahlcorrectstamps'];
    $stampdateandtimefromdb = $_POST['stampdateandtimefromdb'];
    $datumundzeit = $_POST['datumundzeit'];
    $datumundzeit = $datumundzeit . ":00";
    $parts = explode("T", $datumundzeit);
    $datumundzeit = $parts[0] . " " . $parts[1];

    $stmt2 = $dbh->prepare('SELECT * FROM stamps order by StampID asc');
    $stmt2->execute();
    $selecteduserstampsID = $stmt2->fetchAll();

    $höchsteID = gethoechsteid($selecteduserstampsID);
    $stmt = $dbh->prepare("UPDATE `stamps` SET IsIgnored = true WHERE UserID = :UserID AND StampDateandTime = :DayDate");
    $stmt->execute([':DayDate' => $stampdateandtimefromdb, ':UserID' => $userid]);

    $stmt = $dbh->prepare("INSERT INTO `stamps` (StampID, StampDateandTime, StampWorkcode, IsIgnored, UserID) VALUES(:StampID, :StampDateandTime, :StampWorkcode, :IsIgnored, :UserID) ");
    $stmt->execute([':StampID' => $höchsteID + 1, ':StampDateandTime' => $datumundzeit, ':StampWorkcode' => 2, ':IsIgnored' => 0, ':UserID' => $userid]);

  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hinzufuegbutton'])) {


    }


 ?>
