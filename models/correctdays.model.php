<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tagekorrigierenbutton'])){
        $_SESSION['correctdaysuserauswahl'] = trim($_POST['userauswahl'] ?? '');
        $_SESSION['correctdaysuserTag'] = trim($_POST['userTag'] ?? '');



  }
  $stmt3 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['correctdaysuserauswahl']);
  $stmt3->execute();
  $selecteduserdays = $stmt3->fetchAll();
?>
