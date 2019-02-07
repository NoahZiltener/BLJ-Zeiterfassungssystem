<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $_SESSION['month'] = $_POST['monthserch'];
    }

    $stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = ' . $_SESSION['UserID']);
    $stmt2->execute();
    $userstamps = $stmt2->fetchAll();

    $stmt3 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['UserID']);
    $stmt3->execute();
    $userdays = $stmt3->fetchAll();





$overtimemonth = 0;
foreach($userdays as $day){
  $dateaufgeteilt = explode("-", $day['DayDate']);
  $month = $dateaufgeteilt[0] . "-" . $dateaufgeteilt[1];
  if($month == $_SESSION['month']){
    $overtimemonth = $day['overtime'] + $overtimemonth;
  }

}
$i = 0;
$averageworktimemonth = 0;
foreach($userdays as $day){
  $dateaufgeteilt = explode("-", $day['DayDate']);
  $month = $dateaufgeteilt[0] . "-" . $dateaufgeteilt[1];
  if($month == $_SESSION['month']){
    $averageworktimemonth = $day['worktime'] + $averageworktimemonth;
    $i++;
  }
}
$averageworktimemonth = $averageworktimemonth / $i;
$averagelunchtimemonth = 0;
$i2 = 0;
foreach($userdays as $day){
  $dateaufgeteilt = explode("-", $day['DayDate']);
  $month = $dateaufgeteilt[0] . "-" . $dateaufgeteilt[1];
  if($month == $_SESSION['month']){
    if($day['lunchtime'] > 0.1){
        $averagelunchtimemonth = $day['lunchtime'] + $averagelunchtimemonth;
    $i2++;
    }
  }
}
$averagelunchtimemonth = $averagelunchtimemonth / $i2;

?>
