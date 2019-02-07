<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $_SESSION['UserIDselected'] = trim($_POST['userauswahl'] ?? $_SESSION['UserIDselected']);
        $_SESSION['dateuser'] = trim($_POST['dayserchuser'] ?? $_SESSION['dateuser']);
    }

    $stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = ' . $_SESSION['UserIDselected']);
    $stmt2->execute();
    $selecteduserstamps = $stmt2->fetchAll();

    $stmt3 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['UserIDselected']);
    $stmt3->execute();
    $selectuserdays = $stmt3->fetchAll();
?>
