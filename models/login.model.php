<?php 
session_start();
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');
$errors  = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']  ??'';
    $passwd = $_POST['passwd']  ??'';

    $statement = $dbh->prepare("SELECT * FROM users WHERE UserEMail = :email");
    $result = $statement->execute(array(':email' => $email));
    $user = $statement->fetch();
    
 
    if ($user !== false && password_verify($passwd, $user['UserPassword'])) {
        $_SESSION['UserID'] = $user['UserID'];
        header("Location: http://10.20.16.102/Projekt-BLJ/index.php?page=timereport");
        
    } else {
        $errors[] = "E-Mail oder Passwort war ungültig";
    }
}
?>