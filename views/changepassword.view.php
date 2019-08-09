<?php include 'models/changepassword.model.php'; ?>
<div class="w3-quarter">
  <p> </p>
</div>
<div class="w3-half">
  <div class="w3-container w3-card w3-white w3-margin">
    <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-exchange-alt fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Passwort ändern</h2>
    <div class="w3-container">
      <form name="blog-form" action="index.php?page=changepassword" method="post" class="w3-display-container">
        <input class="w3-input w3-border w3-margin-right w3-margin-top" type="text" style="width:40%" value="<?=$_SESSION['login_logedin_user_name']?>" readonly required>
        <input class="w3-input w3-border w3-margin-right w3-margin-top" type="password" style="width:40%" name="newpassword" id="newpassword" placeholder="Neues Passwort" required>
        <input class="w3-input w3-border w3-margin-right w3-margin-top" type="password" style="width:40%" name="newpasswordconfirm" id="newpasswordconfirm" placeholder="Bestätige Neues Passwort" required>
        <?php if(sizeof($errors) !== 0):?>
          <?php foreach($errors as $error): ?>
            <p class="w3-red"><?= $error ?></p>
          <?php endforeach; ?>
        <?php endif; ?>
        <br>
        <br>
        <input class="w3-display-bottomright w3-button w3-black w3-button w3-large" type="submit" value="Ändern" name="changepasswordbutton">
        <input class="w3-display-bottomright w3-button w3-black w3-button w3-large" style="right:105px" type="button" value="Abbrechen" name="changepasswordbutton" onclick="window.location.href = 'http://www.041er-blj.ch/zeit/index.php?page=timereport';">
      </form>
      <br>
    </div>
  </div>
</div>
