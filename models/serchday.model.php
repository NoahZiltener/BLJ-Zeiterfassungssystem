<?php
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dayserch-submit-button'])){
  $_SESSION['dayserch_selected_user_date'] = trim($_POST['dayserch-date-input'] ?? '');

  $stmt = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
  $stmt->execute([':UserID' => $_SESSION['login_logedin_user_id']]);
  $_SESSION['dayserch_selected_user_stamps'] = $stmt->fetchAll();

  $stmt = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['login_logedin_user_id']);
  $stmt->execute();
  $_SESSION['dayserch_selected_user_days'] = $stmt->fetchAll();
}

$stmt = $dbh->prepare('SELECT * FROM workcodes');
$stmt->execute();
$dayserch_workcodes = $stmt->fetchAll();
?>
