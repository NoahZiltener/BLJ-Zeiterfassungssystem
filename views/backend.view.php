<?php include 'models/backend.model.php'; ?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
  <?php foreach($selectuserdays as $day): ?>
      <?php if($day['DayDate'] == $_SESSION['dateuser']): ?>
        <form name="blog-form" action="index.php?page=timereport" method="post" class="serch-forms">
          <div class="form-actions">
            <h3>Arbeitszeit:</h3>
            <p>
                <?= round(htmlspecialchars($day['worktime'], ENT_QUOTES, "UTF-8"), 2); ?>
                Stunden
            </p>
            <input id="groesse" type="number" step="1" >
            <input class="btn btn-primary" type="submit" value="Ändern">
          </div>
          <div class="form-actions">
          <h3>Mittagszeit:</h3>
          <p>
              <?= round(htmlspecialchars($day['lunchtime'], ENT_QUOTES, "UTF-8"), 2); ?>
              Stunden
          </p>
          <input id="groesse" type="number" step="1" >
          <input class="btn btn-primary" type="submit" value="Ändern">
        </div>
        <div class="form-actions">
          <h3>Überstunden:</h3>
          <p>
              <?= round(htmlspecialchars($day['overtime'], ENT_QUOTES, "UTF-8"), 2); ?>
              Stunden
          </p>
          <input id="groesse" type="number" step="1" >
          <input class="btn btn-primary" type="submit" value="Ändern">
        </div>
          <h3>Stemplungen:</h3>
          <?php foreach($selecteduserstamps as $stamp): ?>

              <?php
                  $parts = explode(" ", $stamp['StampDateandTime']);
              ?>
              <?php if($parts[0] == $_SESSION['dateuser'] && $stamp['IsIgnored'] == 0): ?>
              <div class="form-actions">
                  <p>
                      <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>
                  </p>
                  <input type="datetime-local" name="geburtsdatum">
                  <input class="btn btn-primary" type="submit" value="Ändern">
              </div>
              <?php endif; ?>

          <?php endforeach;?>
          </form>
      <?php endif; ?>
  <?php endforeach;?>
<?php endif; ?>
