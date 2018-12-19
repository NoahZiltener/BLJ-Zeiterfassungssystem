<?php
session_start();
if(!isset($_SESSION['UserID'])) {
    header("Location: http://10.20.16.104/Projekt-BLJ/index.php?page=login                                                                                                                                                                                  ");
}

$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

$stmt = $dbh->prepare('SELECT * FROM post users where UserID = ' . $_SESSION['UserID']);
$stmt->execute();
$user = $stmt->fetchAll();

$stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = ' . $_SESSION['UserID']);
$stmt2->execute();
$alluserstamps = $stmt2->fetchAll();


?>