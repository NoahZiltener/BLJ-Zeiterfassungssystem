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
$users = $stmt->fetchAll();

$stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = ' . $_SESSION['UserID']);
$stmt2->execute();
$alluserstamps = $stmt2->fetchAll();


?>