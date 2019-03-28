<?php
session_start();
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');
$errors  = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $UserName = $_POST['login_username_input']  ??'';
    $passwd = $_POST['login_password_input']  ??'';

    $statement = $dbh->prepare("SELECT * FROM users WHERE UserName = :UserName");
    $result = $statement->execute(array(':UserName' => $UserName));
    $user = $statement->fetch();


    if ($user !== false && password_verify($passwd, $user['UserPassword'])) {
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['UserName'] = $user['UserName'];
        header("Location: http://localhost/Projekt-BLJ/index.php?page=timereport");
    } else {
        $errors[] = "E-Mail oder Passwort war ungültig";
    }
}
?>
