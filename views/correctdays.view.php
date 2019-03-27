<?php include 'models/correctdays.model.php'; ?>
<?php if (isset($_SESSION['selecteduserdays']) == true): ?>
  <?php $dayfound = false; ?>
  <div class="w3-container">
    <?php foreach($_SESSION['selecteduserdays'] as $day): ?>
      <?php if($day['DayDate'] == $_SESSION['correctdaysuserTag']): ?>
        <?php $dayfound = true; ?>
        <form name="blog-form" action="index.php?page=timereport" method="post" class="w3-display-container">
          <?php if($day['DayIsValide'] == true): ?>
            <h5 class="w3-opacity"><b><?= htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8"); ?></b><i class="fa fa-check-circle fa-fw w3-margin-right w3-text-b w3-text-green"></i></h5>
          <?php else: ?>
            <h5 class="w3-opacity"><b><?= htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8"); ?></b><i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-text-b w3-text-red"></i></h5>
          <?php endif; ?>
          <h6 class="w3-opacity"><b>Arbeitszeit</b></h6>
          <div class="w3-bar">
            <input type="number" class="w3-input w3-bar-item w3-section w3-border-bottom correctdaysinputstunden" step="0.01" style="width:8%" name="correctedworktime" value="<?= round(htmlspecialchars($day['worktime'], ENT_QUOTES, "UTF-8"), 2); ?>" required>
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
          <textarea name="daycommenttxt" rows="5" class="w3-input w3-border"><?= htmlspecialchars($day['DayComment'], ENT_QUOTES, "UTF-8") ?></textarea>
          <h6 class="w3-opacity"><b>Stemplungen</b></h6>
          <?php foreach($_SESSION['selecteduserstamps'] as $stamp): ?>
              <?php
                  $parts = explode(" ", $stamp['StampDateandTime']);
              ?>
              <?php if($parts[0] == $_SESSION['correctdaysuserTag']): ?>
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
          <input class="w3-button w3-green w3-button w3-large w3-display-bottomright" type="submit" value="Speichern" name="daycorrectsavebutton">
      </form>
      <hr>
    <?php endif; ?>
  <?php endforeach; ?>
  <?php if($dayfound == false): ?>
    <form name="blog-form" action="index.php?page=timereport" method="post" class="w3-display-container">
      <h5 class="w3-opacity"><b>Neuer Tag Hinzufügen</b></h5>
      <h6 class="w3-opacity"><b>Datum</b></h6>
      <div class="w3-bar">
          <p class="w3-bar-item correctdaysstunden"><?=$_SESSION['correctdaysuserTag']?></p>
      </div>
      <h6 class="w3-opacity"><b>Arbeitszeit</b></h6>
      <div class="w3-bar">
        <input type="number" class="w3-input w3-bar-item w3-section w3-border-bottom correctdaysinputstunden" step="0.01" style="width:8%" name="dayaddcorrectedworktime" value="8.00" required>
        <p class="w3-bar-item correctdaysstunden">Stunden</p>
      </div>
      <h6 class="w3-opacity"><b>Mittagszeit</b></h6>
      <div class="w3-bar">
        <input type="number" class="w3-input w3-bar-item w3-section w3-border-bottom correctdaysinputstunden" step="0.01" style="width:8%" name="dayaddcorrectedlunchtime" value="0.75" required>
        <p class="w3-bar-item correctdaysstunden">Stunden</p>
      </div>
      <h6 class="w3-opacity"><b>Überstunden</b></h6>
      <p>
        0 Stunden
      </p>
      <h6 class="w3-opacity"><b>Kommentar</b></h6>
      <textarea name="daycommenttxt" rows="5" class="w3-input w3-border"><?= htmlspecialchars($day['DayComment'], ENT_QUOTES, "UTF-8") ?></textarea>
      <br>
      <br>
      <br>
      <input class="w3-button w3-green w3-button w3-large w3-display-bottomright" type="submit" value="Hinzufügen" name="dayaddbutton">
    </form>
    <hr>
  <?php endif; ?>
</div>
<?php endif; ?>
