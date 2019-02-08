<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tagekorrigierenbutton'])){
    $_SESSION['correctdaysuserauswahl'] = trim($_POST['userauswahl'] ?? '');
    $_SESSION['correctdaysuserTag'] = trim($_POST['userTag'] ?? '');


  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['speichernbutton'])) {
    /*if (isset($_POST['Arbeitszeit'])) {*/
      $Arbeitzeituser = $_POST['Arbeitzeit'];
      $userid = $_SESSION['correctdaysuserauswahl'];
      $serchdate = $_SESSION['correctdaysuserTag'];
echo $serchdate;
      $stmt = $dbh->prepare("UPDATE `days` SET worktime = :Worktime WHERE UserID = :UserID AND DayDate = :DayDate");
      $stmt->execute([':Worktime' => $Arbeitzeituser, ':DayDate' => $serchdate, ':UserID' => $userid]);
    /*}*/
  }
  $stmt3 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctdaysuserauswahl']);
  $stmt3->execute();
  $selecteduserdays = $stmt3->fetchAll();

?>
