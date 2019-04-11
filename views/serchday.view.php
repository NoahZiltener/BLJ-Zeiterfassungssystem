<?php
include 'models/serchday.model.php';
?>
<?php if (isset($_SESSION['dayserch_selected_user_stamps']) == true): ?>
  <?php $dayfound = false; ?>
  <div class="w3-container">
    <?php foreach($_SESSION['dayserch_selected_user_days'] as $day): ?>
      <?php if($day['DayDate'] == $_SESSION['dayserch_selected_user_date']): ?>
        <?php $dayfound = true; ?>
        <?php if($day['DayIsValide'] == true): ?>
          <h5 class="w3-opacity"><b><?= htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8"); ?></b><i class="fa fa-check-circle fa-fw w3-margin-right w3-text-b w3-text-green"></i></h5>
        <?php else: ?>
          <h5 class="w3-opacity"><b><?= htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8"); ?></b><i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-text-b w3-text-red"></i></h5>
        <?php endif; ?>
        <h6 class="w3-opacity"><b>Arbeitszeit</b></h6>
        <p>
          <?= round(htmlspecialchars($day['worktime'], ENT_QUOTES, "UTF-8"), 2); ?>
          Stunden
        </p>
        <h6 class="w3-opacity"><b>Mittagszeit</b></h6>
        <p>
          <?= round(htmlspecialchars($day['lunchtime'], ENT_QUOTES, "UTF-8"), 2); ?>
          Stunden
        </p>
        <h6 class="w3-opacity"><b>Überstunden</b></h6>
        <p>
          <?= round(htmlspecialchars($day['overtime'], ENT_QUOTES, "UTF-8"), 2); ?>
          Stunden
        </p>
        <h6 class="w3-opacity"><b>Kommentar</b></h6>
        <textarea name="dayserch_day_comment_textarea" rows="5" class="w3-input w3-border" readonly><?= htmlspecialchars($day['DayComment'], ENT_QUOTES, "UTF-8") ?></textarea>
        <h6 class="w3-opacity"><b>Stemplungen</b></h6>
        <?php foreach($_SESSION['dayserch_selected_user_stamps'] as $stamp): ?>
          <?php
          $parts = explode(" ", $stamp['StampDateandTime']);
          ?>
          <?php if($parts[0] == $_SESSION['dayserch_selected_user_date'] && $stamp['IsIgnored'] == 0): ?>
            <p>
              <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8") . ": "?>
              <?php if ($stamp['StampDateandTime'] > 0): ?>
                <?php foreach ($dayserch_workcodes as $workcode): ?>
                  <?php if ($stamp['StampWorkcode'] == $workcode['WorkcodeID']): ?>
                    <?= htmlspecialchars($workcode['WorkcodeName'], ENT_QUOTES, "UTF-8") ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </p>
            <textarea name="<?= $stamp['StampID']?>" rows="3" class="w3-input w3-border" readonly><?= $stamp['StampRemark']?></textarea>
            <hr>
          <?php endif; ?>
        <?php endforeach;?>
      <?php endif; ?>
    <?php endforeach;?>
    <?php if($dayfound == false): ?>
      <h6 class="w3-opacity"><b>Kein Eintrag gefunden</b></h6>
      <hr>
    <?php endif; ?>
  </div>
<?php endif; ?>
