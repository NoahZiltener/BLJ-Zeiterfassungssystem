<?php
include 'models/serchday.model.php';
?>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($userdays) > 0 && isset($_POST['dayserchbuttom'])): ?>
  <?php $dayfound = false; ?>
  <div class="w3-container">
            <?php foreach($userdays as $day): ?>
                <?php if($day['DayDate'] == $_SESSION['date']): ?>
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
                    <h6 class="w3-opacity"><b>Stemplungen</b></h6>
            <?php foreach($userstamps as $stamp): ?>
                <?php
                    $parts = explode(" ", $stamp['StampDateandTime']);
                ?>
                <?php if($parts[0] == $_SESSION['date'] && $stamp['IsIgnored'] == 0): ?>
                    <p>
                        <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>
                    </p>
                    <p>
                        <?= htmlspecialchars($stamp['StampRemark'], ENT_QUOTES, "UTF-8"); ?>
                    </p>

                <?php endif; ?>
            <?php endforeach;?>
                <?php endif; ?>
            <?php endforeach;?>
            <?php if($dayfound == false): ?>
              <h6 class="w3-opacity"><b>Kein Eintrag gefunden</b></h6>
            <?php endif; ?>
            <hr>
          </div>
        <?php endif; ?>
