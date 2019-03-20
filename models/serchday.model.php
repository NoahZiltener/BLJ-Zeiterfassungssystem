<?php
$user = 'root';
$pass = '';
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', $user, $pass);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dayserchbuttom'])){
        $_SESSION['date'] = trim($_POST['dayserchdate'] ?? '');


    }

    $stmt2 = $dbh->prepare('SELECT * FROM stamps where UserID = :UserID order by StampDateandTime');
    $stmt2->execute([':UserID' => $_SESSION['UserID']]);
    $userstamps = $stmt2->fetchAll();

    $stmt3 = $dbh->prepare('SELECT * FROM days where UserID = ' . $_SESSION['UserID']);
    $stmt3->execute();
    $userdays = $stmt3->fetchAll();

?>
