<?php
  $user = 'root';
  $pass = '';
  $dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

  if (isset($_POST['correctday-submit-button']) == true){
    $_SESSION['correctday-user-select'] = trim($_POST['correctday-user-select'] ?? '');
    $_SESSION['correctdaysuserTag'] = trim($_POST['correctday-date-input'] ?? '');

    $stmt1 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctday-user-select']);
    $stmt1->execute();
    $_SESSION['selecteduserdays'] = $stmt1->fetchAll();

    $stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
    $stmt2->execute([':UserID' => $_SESSION['correctday-user-select']]);
    $_SESSION['selecteduserstamps'] = $stmt2->fetchAll();

    ?><script language="javascript">document.location.reload;</script><?php
  }

  if (isset($_POST['daycorrectsavebutton']) == true){
    $Worktime = $_POST['correctedworktime'];
    $serchdate = $_SESSION['correctdaysuserTag'];
    $userid = $_SESSION['correctday-user-select'];
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

    foreach ($_SESSION['selecteduserstamps'] as $stamp) {
      $parts = explode(" ", $stamp['StampDateandTime']);
      if($parts[0] == $_SESSION['correctdaysuserTag']){
        $stampID = $stamp["StampID"];
        $stampremarktxt = $_POST["$stampID"];

        $stmt4 = $dbh->prepare("UPDATE `stamps` SET StampRemark = :stampremark WHERE UserID = :UserID AND StampID = :stampdateandtime");
        $stmt4->execute([':stampremark' => $stampremarktxt, ':stampdateandtime' => $stampID, ':UserID' => $userid]);
      }
    }

    $stmt5 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctday-user-select']);
    $stmt5->execute();
    $_SESSION['selecteduserdays'] = $stmt5->fetchAll();

    $stmt6 = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
    $stmt6->execute([':UserID' => $_SESSION['correctday-user-select']]);
    $_SESSION['selecteduserstamps'] = $stmt6->fetchAll();

    ?><script language="javascript">document.location.reload;</script><?php
  }
  if (isset($_POST['dayaddbutton']) == true) {

    $serchdate = $_SESSION['correctdaysuserTag'];
    $userid = $_SESSION['correctday-user-select'];
    $Worktime = $_POST['dayaddcorrectedworktime'];
    $lunchtime = $_POST['dayaddcorrectedlunchtime'];
    $daycommenttxt = $_POST['daycommenttxt'] ?? '';

    $Overtime = 0;
    if($Worktime > 8){
      $Overtime = $Worktime - 8;
    }
    else if ($Worktime < 8) {
      $Overtime = $Worktime - 8;
    }

    $stmt1 = $dbh->prepare('SELECT * FROM `days` order by DayID ASC');
    $stmt1->execute();
    $alldays = $stmt1->fetchAll();

    foreach ($alldays as $day) {
        $highestID = $day['DayID'];
    }

    $stmt2 = $dbh->prepare("INSERT INTO `days` (DayID, DayDate, DayIsValide, UserID, overtime, TimeOfDay, worktime, lunchtime, DayComment) VALUES(:DayID, :DayDate, :IsValide, :UserID, :overtime, :TimeOfDay, :worktime, :lunchtime, :DayComment) ");
    $stmt2->execute([':DayID' => 1 + $highestID, ':DayDate' => $serchdate, ':IsValide' => true, ':UserID' => $userid, ':overtime' => $Overtime, ':TimeOfDay' => $Worktime + $lunchtime, ':worktime' => $Worktime, ':lunchtime' => $lunchtime, ':DayComment' => $daycommenttxt]);

    $stmt5 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctday-user-select']);
    $stmt5->execute();
    $_SESSION['selecteduserdays'] = $stmt5->fetchAll();

    $stmt6 = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
    $stmt6->execute([':UserID' => $_SESSION['correctday-user-select']]);
    $_SESSION['selecteduserstamps'] = $stmt6->fetchAll();

    ?><script language="javascript">document.location.reload;</script><?php

  }
  $stmt4 = $dbh->prepare('SELECT * FROM workcodes');
  $stmt4->execute();
  $workcodes = $stmt4->fetchAll();
?>
