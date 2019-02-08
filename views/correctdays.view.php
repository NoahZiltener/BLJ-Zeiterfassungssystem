<?php include 'models/correctdays.model.php'; ?>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
  <?php foreach($selecteduserdays as $day): ?>
    <?php if($day['DayDate'] == $_SESSION['correctdaysuserTag']): ?>
      <h3>Arbeitszeit:</h3>
      <p>
        <?= round(htmlspecialchars($day['worktime'], ENT_QUOTES, "UTF-8"), 2); ?>
        Stunden
      </p>
      <h3>Mittagszeit:</h3>
      <p>
        <?= round(htmlspecialchars($day['lunchtime'], ENT_QUOTES, "UTF-8"), 2); ?>
        Stunden
      </p>
      <h3>Überstunden:</h3>
      <p>
        <?= round(htmlspecialchars($day['overtime'], ENT_QUOTES, "UTF-8"), 2); ?>
        Stunden
      </p>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>
