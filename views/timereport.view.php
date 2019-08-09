<?php
include 'models/timereport.model.php';
$userid = $_SESSION['login_logedin_user_id'];
?>
<div class="w3-third">
  <div class="w3-white w3-text-grey w3-card-4">
    <div class="w3-container">
      <?php foreach($timeport_selected_user as $user): ?>
        <p><i class="fa fa-user fa-fw w3-margin-right w3-large w3-text-black"></i><?= htmlspecialchars($user['UserName'], ENT_QUOTES, "UTF-8"); ?></p>
        <p><i class="fa fa-male fa-fw w3-margin-right w3-large w3-text-black"></i><?= htmlspecialchars($user['UserFirstName'], ENT_QUOTES, "UTF-8") . " " . htmlspecialchars($user['UserLastName'], ENT_QUOTES, "UTF-8"); ?></p>
        <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-black"></i><?= htmlspecialchars($user['UserEMail'], ENT_QUOTES, "UTF-8"); ?></p>
        <hr>
      <?php endforeach;?>
      <p class="w3-large"><b><i class="fa fa-address-card fa-fw w3-margin-right w3-text-black"></i>Übersicht</b></p>
      <h5 class="w3-opacity"><b>Überstunden</b></h5>
      <p><?=round($timeport_selected_user_overtime, 2) . " Stunden"?></p>
      <h5 class="w3-opacity"><b>Durchschnittliche Arbeitzeit</b></h5>
      <p><?=round($timeport_selected_user_averageworktime, 2) . " Stunden"?></p>
      <h5 class="w3-opacity"><b>Durchschnittliche Mittagszeit</b></h5>
      <p><?=round($timeport_selected_user_averagelunchtime, 2) . " Stunden"?></p>
      <h5><b class="w3-opacity">Vergessene Stempelung </b><span class="w3-badge w3-red w3-small"><?=sizeof($timeport_selected_user_forgotstamps)?></span></h5>
      <?php foreach($timeport_selected_user_forgotstamps as $forgotstamp): ?>
        <p><?= $forgotstamp ?></p>
      <?php endforeach; ?>
      <hr>
      <p class="w3-large w3-text-theme"><b><i class="fa fa-user fa-fw w3-margin-right w3-text-b"></i>Profil</b></p>
      <div class="w3-container">
        <form name="logout-form" action="index.php?page=logout" method="post">
          <button class="w3-button w3-red w3-wide w3-margin-bottom w3-button w3-small"><i class="fas fa-sign-out-alt"></i>Logout</button>
        </form>
        <form name="changepassword-form" action="index.php?page=changepassword" method="post">
          <button class="w3-button w3-black w3-wide w3-button w3-small"><i class="fas fa-exchange-alt"></i>Change Password</button>
        </form>
      </div>
      <hr>
      <p class="w3-large"><b><i class="fa fa-question fa-fw w3-margin-right w3-text-black"></i>Support & Kontakt</b></p>
      <h5 class="w3-opacity"><b>Emailadresse</b></h5>
      <p>noahziltener@yahoo.com</p>
      <hr>
    </div>
  </div>
  <br>
</div>
<div class="w3-twothird">
  <?php if($user['isAdmin'] == false): ?>
    <div class="w3-container w3-card w3-white w3-margin-bottom">
      <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-calendar-alt fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Tages Übersicht</h2>
      <div class="w3-container">
        <h5 class="w3-opacity"><b>Tages Suche</b></h5>
        <form name="serchday-form" action="index.php?page=timereport" method="post" class="serch-forms">
          <div class="w3-bar w3-display-container" style="height: 80px; margin-top: 20px;">
            <p class="w3-bar-item" style="margin: 0px; padding-top: 0px;">
              <label class="">Datum</label>
              <input class="w3-input w3-border w3-margin-right" type="date" value="" style="margin-top: 0px; padding-top: 0px;" name="dayserch-date-input" required>
            </p>
            <p class="w3-bar-item w3-display-bottommiddle" style="left:270px">
              <input class="w3-button w3-black w3-bar-item w3-button w3-large" type="submit" value="Suchen" name="dayserch-submit-button">
            </p>
          </div>
        </form>
        <hr>
      </div>
      <?php include 'views/serchday.view.php';?>
    </div>
  <?php elseif($user['isAdmin'] == true): ?>
    <div class="w3-container w3-card w3-white w3-margin-bottom">
      <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-cogs fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Tage korrigieren</h2>
      <div class="w3-container">
        <form name="correctday-form" action="index.php?page=timereport" method="post" class="serch-forms">
          <div class="w3-bar w3-display-container" style="height: 80px; margin-top: 20px;">
            <p class="w3-bar-item" style="margin: 0px; padding-top: 0px;">
              <label class="">User</label>
              <select class="w3-input w3-border w3-margin-right w3-large" name="correctday-user-select">
                <?php foreach($timeport_all_user as $user): ?>
                  <option value="<?= htmlspecialchars($user['UserID'], ENT_QUOTES, "UTF-8"); ?>"><?= htmlspecialchars($user['UserName'], ENT_QUOTES, "UTF-8"); ?></option>
                <?php endforeach;?>
              </select>
            </p>
            <p class="w3-bar-item" style="margin: 0px; padding-top: 0px;">
              <label class="">Datum</label>
              <input class="w3-input w3-border" type="date" style="width:70%" name="correctday-date-input" required>
            </p>
            <p class="w3-bar-item w3-display-bottommiddle" style="left:390px; top: -1px;">
              <input class="w3-button w3-black w3-bar-item w3-button w3-large" type="submit" value="Suchen" name="correctday-submit-button">
            </p>
          </div>
        </form>
        <hr>
        <?php include 'views/correctdays.view.php';?>
      </div>
    </div>
    <div class="w3-container w3-card w3-white w3-margin-bottom">
      <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-calendar-alt fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Zeitraum Übersicht</h2>
      <div class="w3-container">
        <form name="serchday-form" action="index.php?page=timereport" method="post" class="serch-forms">
          <div class="w3-bar w3-display-container" style="height: 80px; margin-top: 20px;">
            <p class="w3-bar-item" style="margin: 0px; padding-top: 0px;">
              <label class="">User</label>
              <select class="w3-input w3-border w3-margin-right w3-large" name="periodserch-user-select">
                <?php foreach($timeport_all_user as $user): ?>
                  <option value="<?= htmlspecialchars($user['UserID'], ENT_QUOTES, "UTF-8"); ?>"><?= htmlspecialchars($user['UserName'], ENT_QUOTES, "UTF-8"); ?></option>
                <?php endforeach;?>
              </select>
            </p>
            <p class="w3-bar-item" style="margin: 0px; padding-top: 0px;">
              <label class="">Start Datum</label>
              <input class="w3-input w3-border" type="date" style="margin: 0px;" name="periodserch-start-date-input" required>
            </p>
            <p class="w3-bar-item" style="margin: 0px; padding-top: 0px;">
              <label class="">Schluss Datum</label>
              <input class="w3-input w3-border" type="date" style="margin: 0px;" name="periodserch-end-date-input" required>
            </p>
            <p class="w3-bar-item w3-display-bottommiddle" style="left:650px; top: -1px;">
              <input class="w3-button w3-black w3-button w3-large" type="submit" value="Suchen" name="periodserch-submit-button">
            </p>
          </div>
        </form>
        <hr>
      </div>
      <?php include 'views/serchperiod.view.php';?>
    </div>
    <div class="w3-container w3-card w3-white w3-margin-bottom">
      <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-calendar-alt fa-fw w3-margin-right w3-xxlarge w3-text-black"></i>Monate Abschliessen</h2>
      <div class="w3-container">
        <?php include 'views/completemonth.view.php';?>
      </div>
    </div>
  <?php endif; ?>
</div>
