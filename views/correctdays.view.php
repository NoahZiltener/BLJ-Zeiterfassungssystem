<?php include 'models/correctdays.model.php'; ?>
<?php if (isset($_SESSION['correctdays_selected_user_days']) == true): ?>
  <?php $correctday_selected_day_found = false; ?>
  <div class="w3-container">
    <?php foreach($_SESSION['correctdays_selected_user_days'] as $day): ?>
      <?php if($day['DayDate'] == $_SESSION['correctday-date-input']): ?>
        <?php $correctday_selected_day_found = true; ?>
        <form name="correctday-form" action="index.php?page=timereport" method="post" class="w3-display-container">
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
          <h6 class="w3-opacity"><b>User</b></h6>
          <p>
            <?php foreach ($_SESSION['correctdays_selected_user'] as $User): ?>
              <?=$User['UserName']?>
            <?php endforeach; ?>
          </p>
          <h6 class="w3-opacity"><b>Arbeitszeit</b></h6>
          <div class="w3-bar">
            <input type="number" class="w3-input w3-bar-item w3-section w3-border-bottom correctdaysinputstunden" step="0.01" style="width:8%" name="correctday-correctedworktime-input" value="<?= round(htmlspecialchars($day['worktime'], ENT_QUOTES, "UTF-8"), 2); ?>" required>
            <p class="w3-bar-item correctdaysstunden">Stunden</p>
          </div>
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
          <textarea name="correctdays_day_comment_textarea" rows="5" class="w3-input w3-border"><?= htmlspecialchars($day['DayComment'], ENT_QUOTES, "UTF-8") ?></textarea>
          <h6 class="w3-opacity"><b>Stemplungen</b></h6>
          <?php foreach($_SESSION['correctdays_selected_user_stamps'] as $stamp): ?>
            <?php
            $parts = explode(" ", $stamp['StampDateandTime']);
            ?>
            <?php if($parts[0] == $_SESSION['correctday-date-input']): ?>
              <?php if($stamp['IsIgnored'] == 0): ?>
                <p>
                  <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8") . ": " ?>
                  <?php if ($stamp['StampDateandTime'] > 0): ?>
                    <?php foreach ($workcodes as $workcode): ?>
                      <?php if ($stamp['StampWorkcode'] == $workcode['WorkcodeID']): ?>
                        <?= htmlspecialchars($workcode['WorkcodeName'], ENT_QUOTES, "UTF-8") ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  <i class="fa fa-check-circle fa-fw w3-margin-right w3-text-b w3-text-green"></i>
                </p>
                <textarea name="<?= $stamp['StampID']?>" rows="3" class="w3-input w3-border"><?= $stamp['StampRemark']?></textarea>
              <?php else: ?>
                <p>
                  <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>
                  <i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-text-b w3-text-red"></i>
                </p>
                <textarea name="<?= $stamp['StampID']?>" rows="3" class="w3-input w3-border"><?=$stamp['StampRemark']?></textarea>
              <?php endif; ?>
            <?php endif; ?>
          <?php endforeach;?>
          <br>
          <br>
          <br>
          <input class="w3-button w3-green w3-button w3-large w3-display-bottomright" type="submit" value="Speichern" name="correctday-save-button">
        </form>
        <hr>
      <?php endif; ?>
    <?php endforeach; ?>
    <?php if($correctday_selected_day_found == false): ?>
      <form name="dayadd-form" action="index.php?page=timereport" method="post" class="w3-display-container">
        <h5 class="w3-opacity"><b>Neuer Tag Hinzufügen</b></h5>
        <h6 class="w3-opacity"><b>User</b></h6>
        <p>
          <?php foreach ($_SESSION['correctdays_selected_user'] as $User): ?>
            <?=$User['UserName']?>
          <?php endforeach; ?>
        </p>
        <h6 class="w3-opacity"><b>Datum</b></h6>
        <div class="w3-bar">
          <p class="w3-bar-item correctdaysstunden"><?=$_SESSION['correctday-date-input']?></p>
        </div>
        <h6 class="w3-opacity"><b>Arbeitszeit</b></h6>
        <div class="w3-bar">
          <input type="number" class="w3-input w3-bar-item w3-section w3-border-bottom correctdaysinputstunden" step="0.01" style="width:8%" name="correctdays_day_corrected_worktime_input" value="0.00" required>
          <p class="w3-bar-item correctdaysstunden">Stunden</p>
        </div>
        <h6 class="w3-opacity"><b>Mittagszeit</b></h6>
        <div class="w3-bar">
          <input type="number" class="w3-input w3-bar-item w3-section w3-border-bottom correctdaysinputstunden" step="0.01" style="width:8%" name="correctdays_day_corrected_lunchtime_input" value="0.75" required>
          <p class="w3-bar-item correctdaysstunden">Stunden</p>
        </div>
        <h6 class="w3-opacity"><b>Überstunden</b></h6>
        <p>
          0 Stunden
        </p>
        <h6 class="w3-opacity"><b>Kommentar</b></h6>
        <textarea name="correctdays_day_comment_textarea" rows="5" class="w3-input w3-border"><?= htmlspecialchars($day['DayComment'], ENT_QUOTES, "UTF-8") ?></textarea>
        <br>
        <br>
        <br>
        <input class="w3-button w3-green w3-button w3-large w3-display-bottomright" type="submit" value="Hinzufügen" name="correctdays_day_add_button">
      </form>
      <hr>
    <?php endif; ?>
  </div>
<?php endif; ?>
