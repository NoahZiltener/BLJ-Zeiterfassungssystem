<?php
session_start();
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');
$changepassworderrors  = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changepasswordbutton'])) {
    $newpassword_hash = password_hash($_POST['newpassword']  ??'', PASSWORD_DEFAULT);
    $newpasswordconfirm_hash = password_hash($_POST['newpasswordconfirm']  ??'', PASSWORD_DEFAULT);
    $newpassword = $_POST['newpassword']  ??'2';
    $newpasswordconfirm = $_POST['newpasswordconfirm']  ??'1';
    if ($newpassword == $newpasswordconfirm) {
      $stmt = $dbh->prepare("UPDATE `users` SET UserPassword = :newpassword WHERE UserID = :UserID");
      $stmt->execute([':newpassword' => $newpassword_hash, ':UserID' => $_SESSION['login_logedin_user_id']]);
      header("Location: http://localhost/Projekt-BLJ/index.php?page=timereport");
    } else {
        $changepassworderrors[] = "Passwörter stimmen nicht überein";
    }
}
?>
