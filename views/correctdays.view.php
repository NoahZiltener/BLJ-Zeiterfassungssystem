<?php include 'models/correctdays.model.php'; ?>
<?php if (isset($_SESSION['selecteduserdays']) == true): ?>
  <?php $dayfound = false; ?>
  <div class="w3-container">
    <?php foreach($_SESSION['selecteduserdays'] as $day): ?>
      <?php if($day['DayDate'] == $_SESSION['correctdaysuserTag']): ?>
        <?php $dayfound = true; ?>
        <form name="blog-form" action="index.php?page=timereport" method="post" class="w3-display-container">
          <?php $dayfound = true; ?>
          <?php if($day['DayIsValide'] == true): ?>
            <h5 class="w3-opacity"><b><?= htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8"); ?></b><i class="fa fa-check-circle fa-fw w3-margin-right w3-text-b w3-text-green"></i></h5>
          <?php else: ?>
            <h5 class="w3-opacity"><b><?= htmlspecialchars($day['DayDate'], ENT_QUOTES, "UTF-8"); ?></b><i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-text-b w3-text-red"></i></h5>
          <?php endif; ?>
          <h6 class="w3-opacity"><b>Arbeitszeit</b></h6>
          <div class="w3-bar">
            <input type="number" class="w3-input w3-bar-item w3-section w3-border-bottom" step="0.01" style="width:8%" name="correctedworktime" id="correctdaysinputstunden" value="<?= round(htmlspecialchars($day['worktime'], ENT_QUOTES, "UTF-8"), 2); ?>" name="correctedworktime" required>
            <p class="w3-bar-item" id="correctdaysstunden">Stunden</p>
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
                      <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>
                      <i class="fa fa-check-circle fa-fw w3-margin-right w3-text-b w3-text-green"></i>
                  </p>
                  <textarea name="<?= $stamp['StampDateandTime']?>" rows="3" class="w3-input w3-border"><?= $stamp['StampDateandTime']?></textarea>
                <?php else: ?>
                  <p>
                      <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>
                      <i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-text-b w3-text-red"></i>
                  </p>
                  <textarea name="<?= $stamp['StampDateandTime']?>" rows="3" class="w3-input w3-border"><?= htmlspecialchars($stamp['StampRemark'], ENT_QUOTES, "UTF-8"); ?></textarea>
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
    <h6 class="w3-opacity"><b>Kein Eintrag gefunden</b></h6>
  <?php endif; ?>
</div>
<?php endif; ?>
