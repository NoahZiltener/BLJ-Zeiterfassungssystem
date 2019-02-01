<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $_SESSION['date'] = $_POST['dayserch'];
    }

    $stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = ' . $_SESSION['UserID']);
    $stmt2->execute();
    $userstamps = $stmt2->fetchAll();

    $stmt3 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['UserID']);
    $stmt3->execute();
    $userdays = $stmt3->fetchAll();

?>