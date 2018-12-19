<?php 
session_start();
$dbh = new PDO('mysql:host=localhost;dbname=timecounterdb', 'root', '');
$errors  = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $UserName = $_POST['UserName']  ??'';
    $passwd = $_POST['passwd']  ??'';

    $statement = $dbh->prepare("SELECT * FROM users WHERE UserName = :UserName");
    $result = $statement->execute(array(':UserName' => $UserName));
    $user = $statement->fetch();
    
 
    if ($user !== false && password_verify($passwd, $user['UserPassword'])) {
        $_SESSION['UserID'] = $user['UserID'];
        header("Location: http://10.20.16.104/Projekt-BLJ/index.php?page=timereport");
        
    } else {
        $errors[] = "E-Mail oder Passwort war ungültig";
    }
}
?>