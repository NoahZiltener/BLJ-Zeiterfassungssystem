<?php
  $user = 'root';
  $pass = '';
  $dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tageskorrigierbutton']) == true){
    $_SESSION['correctdaysuserauswahl'] = trim($_POST['correctdaysuserauswahl'] ?? '');
    $_SESSION['correctdaysuserTag'] = trim($_POST['dayserch'] ?? '');

    $stmt1 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctdaysuserauswahl']);
    $stmt1->execute();
    $_SESSION['selecteduserdays'] = $stmt1->fetchAll();

    $stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
    $stmt2->execute([':UserID' => $_SESSION['correctdaysuserauswahl']]);
    $_SESSION['selecteduserstamps'] = $stmt2->fetchAll();

    ?><script language="javascript">document.location.reload;</script><?php
  }
  if (isset($_POST['daycorrectsavebutton']) == true){
    $Worktime = $_POST['correctedworktime'];
    $serchdate = $_SESSION['correctdaysuserTag'];
    $userid = $_SESSION['correctdaysuserauswahl'];
    $daycommenttxt = $_POST['daycommenttxt'] ?? '';
    $Overtime = 0;
    if($Worktime > 8){
      $Overtime = $Worktime - 8;
    }
    else if ($Worktime < 8) {
      $Overtime = $Worktime - 8;
    }
    $stmt1 = $dbh->prepare("UPDATE `days` SET worktime = :Worktime WHERE UserID = :UserID AND DayDate = :DayDate");
    $stmt1->execute([':Worktime' => $Worktime, ':DayDate' => $serchdate, ':UserID' => $userid]);

    $stmt2 = $dbh->prepare("UPDATE `days` SET overtime = :overtime WHERE UserID = :UserID AND DayDate = :DayDate");
    $stmt2->execute([':overtime' => $Overtime, ':DayDate' => $serchdate, ':UserID' => $userid]);

    $stmt3 = $dbh->prepare("UPDATE `days` SET DayComment = :daycomment WHERE UserID = :UserID AND DayDate = :DayDate");
    $stmt3->execute([':daycomment' => $daycommenttxt, ':DayDate' => $serchdate, ':UserID' => $userid]);

    foreach ($variable as $key) {
      $stmt4 = $dbh->prepare("UPDATE `days` SET DayComment = :daycomment WHERE UserID = :UserID AND DayDate = :DayDate");
      $stmt4->execute([':daycomment' => $daycommenttxt, ':DayDate' => $serchdate, ':UserID' => $userid]);
    }

    $stmt5 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctdaysuserauswahl']);
    $stmt5->execute();
    $_SESSION['selecteduserdays'] = $stmt5->fetchAll();

    $stmt6 = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
    $stmt6->execute([':UserID' => $_SESSION['correctdaysuserauswahl']]);
    $_SESSION['selecteduserstamps'] = $stmt6->fetchAll();

    ?><script language="javascript">document.location.reload;</script><?php
  }
?>
