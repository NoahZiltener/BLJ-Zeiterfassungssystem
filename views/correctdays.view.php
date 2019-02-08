<?php include 'models/correctdays.model.php'; ?>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($selecteduserdays) > 0): ?>
  <?php foreach($selecteduserdays as $day): ?>
    <?php if($day['DayDate'] == $_SESSION['correctdaysuserTag']): ?>
      <form name="blog-form" action="index.php?page=timereport" method="post">
        <h3>Arbeitszeit:</h3>
        <p>
          <?= round(htmlspecialchars($day['worktime'], ENT_QUOTES, "UTF-8"), 2); ?>
          Stunden
        </p>
        <input type="number" name="Arbeitzeit">
        <div class="form-actions">
          <h3>Mittagszeit:</h3>
          <p>
            <?= round(htmlspecialchars($day['lunchtime'], ENT_QUOTES, "UTF-8"), 2); ?>
            Stunden
          </p>
          <input type="number" name="Mittagszeit">
        </div>
        <div class="form-actions">
        <h3>Überstunden:</h3>
        <p>
          <?= round(htmlspecialchars($day['overtime'], ENT_QUOTES, "UTF-8"), 2); ?>
          Stunden
        </p>
        <input type="number" name="Überstunden">
      </div>
      <div class="form-actions">
        <input class="btn btn-primary" type="submit" value="Speichern" name="speichernbutton">
      </div>
    </form>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>
