<?php
include 'models/serchperiod.model.php';
?>
<?php if(sizeof($error) !== 0):?>
  <?php foreach($error as $error): ?>
    <p class="w3-red"><?= $error ?></p>
  <?php endforeach; ?>
<?php else: ?>
  <?php if (isset($_SESSION['periodserch_selected_user_days']) == true): ?>
  <div class="w3-container">
    <h6 class="w3-opacity"><b>User</b></h6>
    <p>
      <?php foreach ($_SESSION['periodserch_selected_user'] as $User): ?>
        <?=$User['UserName']?>
      <?php endforeach; ?>
    </p>
    <h6 class="w3-opacity"><b>Überstunden</b></h6>
    <p>
      <?= round(htmlspecialchars($_SESSION['periodserch_Overtime'], ENT_QUOTES, "UTF-8"), 2); ?>
      Stunden
    </p>
    <h6 class="w3-opacity"><b>Totale Überstunden</b></h6>
    <p>
      <?= round(htmlspecialchars($_SESSION['periodserch_Overtime_all'], ENT_QUOTES, "UTF-8"), 2); ?>
      Stunden
    </p>
    <?php if ($_SESSION['periodserch_selected_user_days']): ?>
      <h6 class="w3-opacity"><b>Tage</b></h6>
      <div class="w3-bar">
        <?php foreach($_SESSION['periodserch_selected_user_days'] as $day): ?>
          <div class="w3-card w3-bar-item w3-margin">
            <h5><?=htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8")?></h5>
            <h6 class="w3-opacity"><b>Arbeitszeit</b></h6>
            <p>
              <?= round(htmlspecialchars($day['worktime'], ENT_QUOTES, "UTF-8"), 2); ?>
              Stunden
            </p>
            <h6 class="w3-opacity"><b>Überstunden</b></h6>
            <p>
              <?= round(htmlspecialchars($day['overtime'], ENT_QUOTES, "UTF-8"), 2); ?>
              Stunden
            </p>
            <h6 class="w3-opacity"><b>Kommentar</b></h6>
            <textarea name="dayserch_day_comment_textarea" rows="2" class="w3-input w3-border" readonly><?= htmlspecialchars($day['DayComment'], ENT_QUOTES, "UTF-8") ?></textarea>
          </div>
        <?php endforeach;?>
      </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>
<?php endif; ?>
