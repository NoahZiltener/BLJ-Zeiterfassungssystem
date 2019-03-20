<?php include 'models/login.model.php'; ?>
<div class="w3-quarter">
  <p> </p>
</div>
<div class="w3-half">
      <div class="w3-container w3-card w3-white w3-margin">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-sign-in-alt fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Login</h2>
        <div class="w3-container">
          <form name="blog-form" action="index.php?page=login" method="post" class="serch-forms">
            <div class="w3-bar">
              <input class="w3-input w3-border w3-margin-right w3-bar-item w3-margin-top" type="text" style="width:35%" name="loginusername" id="loginusername" placeholder="Benutzername">
              <input class="w3-input w3-border w3-margin-right w3-bar-item w3-margin-top" type="password" style="width:35%" name="loginpassword" id="loginpassword" placeholder="Passwort">
              <input class="w3-button w3-black w3-bar-item w3-button w3-large w3-margin-top" type="submit" value="Login" name="tagessuchebutton">
              </div>
          </form>
          <?php if(sizeof($errors) !== 0):?>
                  <ul class="w3-panel w3-red">
                      <?php foreach($errors as $error): ?>
                          <li><?= $error ?></li>
                      <?php endforeach; ?>
                  </ul>
              <?php endif; ?>
          <hr>
        </div>
      </div>
    </div>
