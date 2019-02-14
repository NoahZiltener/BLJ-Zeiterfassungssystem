<?php include 'models/correctstamps.model.php'; ?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correctstampsbutton']) || $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hinzufuegbutton']) || $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aenderbutton'])): ?>
          <h3>Stemplungen:</h3>
          <?php foreach($_SESSION['test'] as $stamp): ?>
              <?php
                  $parts = explode(" ", $stamp['StampDateandTime']);
              ?>
              <?php if($parts[0] == $_SESSION['correctstampsdate']): ?>
            <form name="blog-form" action="index.php?page=timereport" method="post" class="serch-forms">
              <div class="form-actions">
                  <p>
                      <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>
                      <?= htmlspecialchars($stamp['IsIgnored'], ENT_QUOTES, "UTF-8"); ?>
                  </p>
                  <input type="hidden" name="stampdateandtimefromdb" value="<?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>">
                  <input type="datetime-local" name="datumundzeit" required>
                  <input class="btn btn-primary" type="submit" value="Ändern" name="aenderbutton">
                  <input class="btn btn-danger" type="submit" value="Löschen">
              </div>
              <?php endif; ?>
            </form>
          <?php endforeach;?>
          <div class="form-actions">
          <form name="blog-form" action="index.php?page=timereport" method="post" class="serch-forms">
            <input type="datetime-local" name="datumundzeit">
            <input class="btn btn-success" type="submit" value="Hinzufügen" name="hinzufuegbutton">
          </form>
        </div>
<?php endif; ?>
