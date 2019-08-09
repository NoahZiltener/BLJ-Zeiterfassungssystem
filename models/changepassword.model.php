<?php
session_start();
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changepasswordbutton'])) {
    $newpassword_hash = password_hash($_POST['newpassword']  ??'', PASSWORD_DEFAULT);
    $newpasswordconfirm_hash = password_hash($_POST['newpasswordconfirm']  ??'', PASSWORD_DEFAULT);
    $newpassword = $_POST['newpassword']  ??'';
    $newpasswordconfirm = $_POST['newpasswordconfirm']  ??'';
    $errors = [];

    if($newpassword != $newpasswordconfirm){
        $errors[] = "Passwörter stimmen nicht überein";
    }
    if(strlen($newpassword) < 8){
        $errors[] = "Passwort muss mindestens 8 Zeichen lang sein";
    }
    if(!preg_match("#[0-9]+#",$newpassword)){
        $errors[] = "Passwort muss mindestens eine Nummer beinhalten";
    }
    if(!preg_match("#[A-Z]+#",$newpassword)){
        $errors[] = "Passwort muss mindestens einen Grossen Buchstaben beinhalten";
    }
    if(!preg_match("#[a-z]+#",$newpassword)){
        $errors[] = "Passwort muss mindestens einen kleinen Buchstaben beinhalten";
    }
    if( sizeof($errors) === 0){
      $stmt = $dbh->prepare("UPDATE `users` SET UserPassword = :newpassword WHERE UserID = :UserID");
      $stmt->execute([':newpassword' => $newpassword_hash, ':UserID' => $_SESSION['login_logedin_user_id']]);
      header("Location:http://localhost/TimeCounter/Projekt-BLJ/index.php?page=timereport");
    }
}
?>
