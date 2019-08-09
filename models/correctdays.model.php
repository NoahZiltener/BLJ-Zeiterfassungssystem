<?php
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correctday-submit-button']) == true){
  $_SESSION['correctday-user-select'] = trim($_POST['correctday-user-select'] ?? '');
  $_SESSION['correctday-date-input'] = trim($_POST['correctday-date-input'] ?? NOW());

  $stmt = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctday-user-select']);
  $stmt->execute();
  $_SESSION['correctdays_selected_user_days'] = $stmt->fetchAll();

  $stmt = $dbh->prepare('SELECT * FROM users where UserID = ' . $_SESSION['correctday-user-select']);
  $stmt->execute();
  $_SESSION['correctdays_selected_user'] = $stmt->fetchAll();

  $stmt = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
  $stmt->execute([':UserID' => $_SESSION['correctday-user-select']]);
  $_SESSION['correctdays_selected_user_stamps'] = $stmt->fetchAll();

  ?><script language="javascript">document.location.reload;</script><?php
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correctday-save-button']) == true){
  $correctdays_selected_user_worktime_corrected = $_POST['correctday-correctedworktime-input'];
  $correctdays_selected_date_corrected = $_SESSION['correctday-date-input'];
  $correctdays_selected_user_id = $_SESSION['correctday-user-select'];
  $correctdays_day_comment_textarea = $_POST['correctdays_day_comment_textarea'] ?? '';

  $correctdays_selected_user_overtime_corrected = 0;
  if($correctdays_selected_user_worktime_corrected > 8){
    $correctdays_selected_user_overtime_corrected = $correctdays_selected_user_worktime_corrected - 8;
  }
  else if ($correctdays_selected_user_worktime_corrected < 8) {
    $correctdays_selected_user_overtime_corrected = $correctdays_selected_user_worktime_corrected - 8;
  }

  $stmt = $dbh->prepare("UPDATE `days` SET worktime = :Worktime WHERE UserID = :UserID AND DayDate = :DayDate");
  $stmt->execute([':Worktime' => $correctdays_selected_user_worktime_corrected, ':DayDate' => $correctdays_selected_date_corrected, ':UserID' => $correctdays_selected_user_id]);

  $stmt = $dbh->prepare("UPDATE `days` SET overtime = :overtime WHERE UserID = :UserID AND DayDate = :DayDate");
  $stmt->execute([':overtime' => $correctdays_selected_user_overtime_corrected, ':DayDate' => $correctdays_selected_date_corrected, ':UserID' => $correctdays_selected_user_id]);

  $stmt = $dbh->prepare("UPDATE `days` SET DayComment = :daycomment WHERE UserID = :UserID AND DayDate = :DayDate");
  $stmt->execute([':daycomment' => $correctdays_day_comment_textarea, ':DayDate' => $correctdays_selected_date_corrected, ':UserID' => $correctdays_selected_user_id]);

  $stmt = $dbh->prepare("UPDATE `days` SET lastchangefrom = :lastchangefrom WHERE UserID = :UserID AND DayDate = :DayDate");
  $stmt->execute([':lastchangefrom' => $_SESSION['login_logedin_user_name'], ':DayDate' => $correctdays_selected_date_corrected, ':UserID' => $correctdays_selected_user_id]);

  $stmt = $dbh->prepare("UPDATE `days` SET lastchangeat = NOW() WHERE UserID = :UserID AND DayDate = :DayDate");
  $stmt->execute([':DayDate' => $correctdays_selected_date_corrected, ':UserID' => $correctdays_selected_user_id]);

  $stmt = $dbh->prepare("UPDATE `days` SET ischanged = :ischanged WHERE UserID = :UserID AND DayDate = :DayDate");
  $stmt->execute([':ischanged' => true, ':DayDate' => $correctdays_selected_date_corrected, ':UserID' => $correctdays_selected_user_id]);

  foreach ($_SESSION['correctdays_selected_user_stamps'] as $stamp) {
    $parts = explode(" ", $stamp['StampDateandTime']);
    if($parts[0] == $_SESSION['correctday-date-input']){
      $stampID = $stamp["StampID"];
      $correctdays_stamp_comment_textarea = $_POST["$stampID"];

      $stmt = $dbh->prepare("UPDATE `stamps` SET StampRemark = :stampremark WHERE UserID = :UserID AND StampID = :stampdateandtime");
      $stmt->execute([':stampremark' => $correctdays_stamp_comment_textarea, ':stampdateandtime' => $stampID, ':UserID' => $correctdays_selected_user_id]);
    }
  }

  $stmt = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctday-user-select']);
  $stmt->execute();
  $_SESSION['correctdays_selected_user_days'] = $stmt->fetchAll();

  $stmt = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
  $stmt->execute([':UserID' => $_SESSION['correctday-user-select']]);
  $_SESSION['correctdays_selected_user_stamps'] = $stmt->fetchAll();

  ?><script language="javascript">document.location.reload;</script><?php
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correctdays_day_add_button']) == true) {

  $correctdays_selected_date_corrected = $_SESSION['correctday-date-input'];
  $correctdays_selected_user_id = $_SESSION['correctday-user-select'];
  $correctdays_selected_user_worktime_corrected = $_POST['correctdays_day_corrected_worktime_input'];
  $correctdays_selected_user_lunchtime_corrected = $_POST['correctdays_day_corrected_lunchtime_input'];
  $correctdays_day_comment_textarea = $_POST['correctdays_day_comment_textarea'] ?? '';

  $correctdays_selected_user_overtime_corrected = 0;
  if($correctdays_selected_user_worktime_corrected > 8){
    $correctdays_selected_user_overtime_corrected = $correctdays_selected_user_worktime_corrected - 8;
  }
  else if ($correctdays_selected_user_worktime_corrected < 8) {
    $correctdays_selected_user_overtime_corrected = $correctdays_selected_user_worktime_corrected - 8;
  }

  $stmt = $dbh->prepare('SELECT * FROM `days` order by DayID ASC');
  $stmt->execute();
  $alldays = $stmt->fetchAll();

  foreach ($alldays as $day) {
    $highestID = $day['DayID'];
  }
  $stmt = $dbh->prepare("INSERT INTO `days` (DayID, DayDate, DayIsValide, UserID, overtime, TimeOfDay, worktime, lunchtime, DayComment) SELECT :DayID, :DayDate, :IsValide, :UserID, :overtime, :TimeOfDay, :worktime, :lunchtime, :DayComment WHERE NOT EXISTS (SELECT * FROM days WHERE DayDate = :DayDate AND :UserID = :UserID)");
  $stmt->execute([':DayID' => 1 + $highestID, ':DayDate' => $correctdays_selected_date_corrected, ':IsValide' => true, ':UserID' => $correctdays_selected_user_id, ':overtime' => $correctdays_selected_user_overtime_corrected, ':TimeOfDay' => $correctdays_selected_user_worktime_corrected + $correctdays_selected_user_lunchtime_corrected, ':worktime' => $correctdays_selected_user_worktime_corrected, ':lunchtime' => $correctdays_selected_user_lunchtime_corrected,
  ':DayComment' => $correctdays_day_comment_textarea]);

  $stmt = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctday-user-select']);
  $stmt->execute();
  $_SESSION['correctdays_selected_user_days'] = $stmt->fetchAll();

  $stmt = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
  $stmt->execute([':UserID' => $_SESSION['correctday-user-select']]);
  $_SESSION['correctdays_selected_user_stamps'] = $stmt->fetchAll();

  ?><script language="javascript">document.location.reload;</script><?php
}

$stmt = $dbh->prepare('SELECT * FROM workcodes');
$stmt->execute();
$workcodes = $stmt->fetchAll();
?>
