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
<html>
<head>
    <meta charset="utf-8" />
    <title>Time Counter 4000</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>
<body>
<?php
    if (!in_array($page, $pages)) {
        include 'views/404.view.php';
    }
    else { 
        include 'views/' . $page . '.view.php';
    }
?>  
</body>
</html>