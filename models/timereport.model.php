<?php

session_start();
if(!isset($_SESSION['UserID'])) {
    header("Location: http://localhost/Projekt-BLJ-neu/index.php?page=login                                                                                                                                                                                  ");
}

$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

$stmt = $dbh->prepare('SELECT * FROM users where UserID = ' . $_SESSION['UserID']);
$stmt->execute();
$users = $stmt->fetchAll();

$stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = ' . $_SESSION['UserID']);
$stmt2->execute();
$alluserstamps = $stmt2->fetchAll();

$stmt3 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['UserID']);
$stmt3->execute();
$alluserdays = $stmt3->fetchAll();

$stmt4 = $dbh->prepare('SELECT * FROM users');
$stmt4->execute();
$allusers = $stmt4->fetchAll();

$overtime = 0;
foreach($alluserdays as $day){
    $overtime = $day['overtime'] + $overtime;
}
$i = 0;
$averageworktime = 0;
foreach($alluserdays as $day){
    $averageworktime = $day['worktime'] + $averageworktime;
    $i++;
}
$averageworktime = $averageworktime / $i;
$averagelunchtime = 0;
$i2 = 0;
foreach($alluserdays as $day){
    if($day['lunchtime'] > 0.1){
        $averagelunchtime = $day['lunchtime'] + $averagelunchtime;
    $i2++;
    }
}
$averagelunchtime = $averagelunchtime / $i2;
$forgotstamps = 0;
foreach($alluserdays as $day){
    if($day['DayIsValide'] == false){
        $forgotstamps++;
    }
}
?>
