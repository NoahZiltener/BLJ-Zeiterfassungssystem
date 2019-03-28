<?php
    $page = $_GET['page'] ?? 'timereport';
    $pages = [
        'login',
        'timereport',
        'logout',
        'changepassword'
    ];
?>
<!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta charset="utf-8">
    <title>Time Counter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-camo.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <style>
      html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
    </style>
</head>
<body class="w3-light-grey">
  <header class="w3-bar w3-camo-black w3-center w3-margin-bottom">
    <h1>Time Counter</h1>
    <h2>Zeiterfassungssystem des Basislehrjahr</h2>
  </header>
  <div class="w3-content w3-margin-top" style="max-width:1400px;">
    <div class="w3-row-padding">
    <?php
        if (!in_array($page, $pages)) {
            include 'views/404.view.php';
        }
        else {
            include 'views/' . $page . '.view.php';
        }
    ?>
    </div>
  </div>
  <footer class="w3-bar w3-camo-black w3-center w3-margin-top">
  <p>Find me on social media.</p>
  <i class="fab fa-github w3-hover-opacity" onclick="document.getElementById('id01').style.display='block'"></i>
  <i class="fab fa-instagram w3-hover-opacity" onclick="document.getElementById('id02').style.display='block'"></i>
  <i class="fab fa-snapchat w3-hover-opacity" onclick="document.getElementById('id03').style.display='block'"></i>
  <i class="fab fa-discord w3-hover-opacity" onclick="document.getElementById('id04').style.display='block'"></i>
  <i class="fas fa-at w3-hover-opacity" onclick="document.getElementById('id05').style.display='block'"></i>
  <p>Made by Noah Ziltener</p>
</footer>

<div id="id01" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
        <div class="w3-container w3-white w3-margin-bottom">
          <h2 class="w3-text-grey w3-padding-16"><i class="fab fa-github fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Github</h2>
          <div class="w3-container">
            <h5 class="w3-opacity"><a href="https://github.com/SwissPvP2003" class="w3-xlarge">SwissPvP2003</a></h5>
          </div>
        </div>
      </div>
    </div>
  </div>
<div id="id02" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id02').style.display='none'" class="w3-button w3-display-topright">&times;</span>
      <div class="w3-container w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fab fa-instagram fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Instagram</h2>
        <div class="w3-container">
          <h5 class="w3-opacity">pvpswiss</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="id03" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id03').style.display='none'" class="w3-button w3-display-topright">&times;</span>
      <div class="w3-container w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fab fa-snapchat fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Snapchat</h2>
        <div class="w3-container">
          <h5 class="w3-opacity">swisspvp03</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="id04" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id04').style.display='none'" class="w3-button w3-display-topright">&times;</span>
      <div class="w3-container w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fab fa-discord fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Discord</h2>
        <div class="w3-container">
          <h5 class="w3-opacity">SwissPvP#0977</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="id05" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id05').style.display='none'" class="w3-button w3-display-topright">&times;</span>
      <div class="w3-container w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fas fa-at fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>E-Mail</h2>
        <div class="w3-container">
          <h5 class="w3-opacity">noahziltener@yahoo.com</h5>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
