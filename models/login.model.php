<?php
session_start();
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');
$errors  = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_user_username = $_POST['login_username_input']  ??'';
    $login_user_password = $_POST['login_password_input']  ??'';

    $stmt = $dbh->prepare("SELECT * FROM users WHERE UserName = :UserName");
    $stmt->execute(array(':UserName' => $login_user_username));
    $login_user = $stmt->fetch();


    if ($login_user !== false && password_verify($login_user_password, $login_user['UserPassword'])) {
        $_SESSION['login_logedin_user_id'] = $login_user['UserID'];
        header("Location: http://localhost/Projekt-BLJ/index.php?page=timereport");
    } else {
        $errors[] = "E-Mail oder Passwort war ungültig";
    }
}
?>
