<?php
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['periodserch-submit-button'])){

  $_SESSION['periodserch-start-date-input'] = trim($_POST['periodserch-start-date-input'] ?? '');
  $_SESSION['periodserch-end-date-input'] = trim($_POST['periodserch-end-date-input'] ?? '');
  $_SESSION['periodserch-user-select'] = trim($_POST['periodserch-user-select'] ?? '');

  if($_SESSION['periodserch-start-date-input'] < $_SESSION['periodserch-end-date-input']) {

    $stmt = $dbh->prepare('SELECT * FROM days where UserID = :UserID AND DayDate > :periodserch_starting AND DayDate < :periodserch_ending');
    $stmt->execute([':UserID' => $_SESSION['periodserch-user-select'], ':periodserch_starting' => strval($_SESSION['periodserch-start-date-input']) , ':periodserch_ending' => strval($_SESSION['periodserch-end-date-input'])]);
    $_SESSION['periodserch_selected_user_days'] = $stmt->fetchAll();

    $_SESSION['periodserch_Overtime'] = 0;
    foreach ($_SESSION['periodserch_selected_user_days'] as $day) {
      $_SESSION['periodserch_Overtime'] = $day['overtime'] + $_SESSION['periodserch_Overtime'];
    }

    $stmt = $dbh->prepare('SELECT * FROM days where UserID = :UserID');
    $stmt->execute([':UserID' => $_SESSION['periodserch-user-select']]);
    $_SESSION['periodserch_selected_user_days_all'] = $stmt->fetchAll();

    $_SESSION['periodserch_Overtime_all'] = 0;
    foreach ($_SESSION['periodserch_selected_user_days_all'] as $day) {
      $_SESSION['periodserch_Overtime_all'] = $day['overtime'] + $_SESSION['periodserch_Overtime_all'];
    }

    $stmt = $dbh->prepare('SELECT * FROM users where UserID = ' . $_SESSION['periodserch-user-select']);
    $stmt->execute();
    $_SESSION['periodserch_selected_user'] = $stmt->fetchAll();
  }
  else {
    $error[] = "Schluss Datum muss grösser sein als Start Datum";
  }
}
?>
