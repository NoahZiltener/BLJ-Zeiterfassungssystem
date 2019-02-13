<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tagekorrigierenbutton'])){
    $_SESSION['correctdaysuserauswahl'] = trim($_POST['userauswahl'] ?? '');
    $_SESSION['correctdaysuserTag'] = trim($_POST['userTag'] ?? '');

    $stmt3 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctdaysuserauswahl']);
    $stmt3->execute();
    $selecteduserdays = $stmt3->fetchAll();
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['speichernbutton'])) {
    /*if (isset($_POST['Arbeitszeit'])) {*/
      $Arbeitzeituser = $_POST['Arbeitzeit'];
      $userid = $_SESSION['correctdaysuserauswahl'];
      $serchdate = $_SESSION['correctdaysuserTag'];

      if($Arbeitzeituser > 8){
        $überstunden = $Arbeitzeituser - 8;

        $stmt = $dbh->prepare("UPDATE `days` SET worktime = :Worktime WHERE UserID = :UserID AND DayDate = :DayDate");
        $stmt->execute([':Worktime' => $Arbeitzeituser, ':DayDate' => $serchdate, ':UserID' => $userid]);

        $stmt2 = $dbh->prepare("UPDATE `days` SET overtime = :overtime WHERE UserID = :UserID AND DayDate = :DayDate");
        $stmt2->execute([':overtime' => $überstunden, ':DayDate' => $serchdate, ':UserID' => $userid]);

      }
      else if ($Arbeitzeituser < 8) {
          $überstunden = 8 - $Arbeitzeituser;

          $stmt = $dbh->prepare("UPDATE `days` SET worktime = :Worktime WHERE UserID = :UserID AND DayDate = :DayDate");
          $stmt->execute([':Worktime' => $Arbeitzeituser, ':DayDate' => $serchdate, ':UserID' => $userid]);

          $stmt2 = $dbh->prepare("UPDATE `days` SET overtime = :overtime WHERE UserID = :UserID AND DayDate = :DayDate");
          $stmt2->execute([':overtime' => $überstunden, ':DayDate' => $serchdate, ':UserID' => $userid]);
      }
      else {

        $stmt = $dbh->prepare("UPDATE `days` SET worktime = :Worktime WHERE UserID = :UserID AND DayDate = :DayDate");
        $stmt->execute([':Worktime' => $Arbeitzeituser, ':DayDate' => $serchdate, ':UserID' => $userid]);
      }

      $stmt = $dbh->prepare("UPDATE `days` SET worktime = :Worktime WHERE UserID = :UserID AND DayDate = :DayDate");
      $stmt->execute([':Worktime' => $Arbeitzeituser, ':DayDate' => $serchdate, ':UserID' => $userid]);
    /*}*/
  }


?>
