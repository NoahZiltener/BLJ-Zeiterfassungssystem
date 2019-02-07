<?php
    $page = $_GET['page'] ?? 'login';

    $pages = [
        'login',
        'changepasswd',
        'register',
        'timereport',
        'logout'
    ];
?>
<!DOCTYPE html>
<html ng-app="myApp" ng-controller="AppCtrl">
<head>
    <meta charset="utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <title>Time Counter</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>
<body>
<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Time Counter</h1>
  <p>Zeiterfassungssystem des BLJ</p>
</div>
    <?php
        if (!in_array($page, $pages)) {
            include 'views/404.view.php';
        }
        else {
            include 'views/' . $page . '.view.php';
        }
    ?>
    <div class="jumbotron text-center" style="margin-bottom:0">
        <p>Time Counter</p>
        <p>Made by Noah Ziltner</p>
    </div>
</body>
</html>
