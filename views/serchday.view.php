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
          <h5 class=""><b><?= htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8"); ?></b><i class="fa fa-check-circle fa-fw w3-text-b w3-text-green"></i><i class="fas fa-info-circle w3-hover-opacity w3-text-indigo" onclick="document.getElementById('id06').style.display='block'"></i></h5>
        <?php else: ?>
          <h5 class=""><b><?= htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8"); ?></b><i class="fa fa-exclamation-triangle fa-fw w3-text-b w3-text-red"></i><i class="fas fa-info-circle w3-hover-opacity w3-text-indigo" onclick="document.getElementById('id06').style.display='block'"></i></h5>
        <?php endif; ?>
        <div id="id06" class="w3-modal">
          <div class="w3-modal-content">
            <div class="w3-container">
              <span onclick="document.getElementById('id06').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <div class="w3-container w3-white w3-margin-bottom">
                <h2 class="w3-text-grey w3-padding-16"><i class="fas fa-info-circle w3-hover-opacity w3-text-indigo"></i>Infos</h2>
                <div class="w3-container">
                  <h6 class="w3-opacity"><b>zuletzt geändert von</b></h6>
                  <?php if ($day['ischanged'] == true): ?>
                    <p>
                      <?= htmlspecialchars($day['lastchangefrom'], ENT_QUOTES, "UTF-8") ?>
                    </p>
                  <?php else: ?>
                    <?="-"?>
                  <?php endif; ?>
                  <h6 class="w3-opacity"><b>zuletzt geändert am</b></h6>
                  <?php if ($day['ischanged'] == true): ?>
                    <p>
                      <?= htmlspecialchars($day['lastchangeat'], ENT_QUOTES, "UTF-8") ?>
                    </p>
                  <?php else: ?>
                    <?="-"?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
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
    <?php endif; ?>
  </div>
<?php endif; ?>
