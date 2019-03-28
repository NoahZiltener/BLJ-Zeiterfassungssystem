<?php
session_start();
if(!isset($_SESSION['UserID'])) {
  header("Location: http://localhost/Projekt-BLJ/index.php?page=login                                                                                                                                                                                  ");
}

$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

$stmt = $dbh->prepare('SELECT * FROM users where UserID = ' . $_SESSION['UserID']);
$stmt->execute();
$timeport_selected_user = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['UserID']);
$stmt->execute();
$timeport_selected_user_days = $stmt->fetchAll();

$stmt = $dbh->prepare('SELECT * FROM users');
$stmt->execute();
$timeport_all_user = $stmt->fetchAll();

$timeport_selected_user_overtime = 0;
foreach($timeport_selected_user_days as $day){
  $timeport_selected_user_overtime = $day['overtime'] + $timeport_selected_user_overtime;
}

$i = 0;
$timeport_selected_user_averageworktime = 0;
foreach($timeport_selected_user_days as $day){
  $timeport_selected_user_averageworktime = $day['worktime'] + $timeport_selected_user_averageworktime;
  $i++;
}
$timeport_selected_user_averageworktime = $timeport_selected_user_averageworktime / $i;

$timeport_selected_user_averagelunchtime = 0;
$i2 = 0;
foreach($timeport_selected_user_days as $day){
  if($day['lunchtime'] > 0.1){
    $timeport_selected_user_averagelunchtime = $day['lunchtime'] + $timeport_selected_user_averagelunchtime;
    $i2++;
  }
}
$timeport_selected_user_averagelunchtime = $timeport_selected_user_averagelunchtime / $i2;

$timeport_selected_user_forgotstamps = 0;
foreach($timeport_selected_user_days as $day){
  if($day['DayIsValide'] == false){
    $timeport_selected_user_forgotstamps++;
  }
}
?>
