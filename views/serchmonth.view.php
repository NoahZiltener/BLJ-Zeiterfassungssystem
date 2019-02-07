<?php
include 'models/serchmonth.model.php';
?>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

  <h3>Arbeitszeit:</h3>
  <p>
      <?= round($averageworktimemonth,2); ?>
      Stunden
  </p>
  <h3>Mittagszeit:</h3>
  <p>
      <?= round($averagelunchtimemonth,2); ?>
      Stunden
  </p>
  <h3>Überstunden:</h3>
  <p>
      <?= round($averagelunchtimemonth,2); ?>
      Stunden
  </p>
  <h3>Stemplungen:</h3>
<?php endif; ?>
