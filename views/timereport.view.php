<?php
include 'models/timereport.model.php';
$userid = $_SESSION['UserID'];
?>
<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-4">
        <h3>Username:</h3>
        <?php foreach($users as $user): ?>
                    <p>
                        <?= htmlspecialchars($user['UserName'], ENT_QUOTES, "UTF-8"); ?>
                    </p>
        <?php endforeach;?>
        <h3>Überstunden:</h3>
        <p><?=round($overtime, 2) . " Stunden"?></p>
        <h3>Durchschnittliche Arbeitzeit:</h3>
        <p><?=round($averageworktime, 2) . " Stunden"?></p>
        <h3>Durchschnittliche Mittagszeit:</h3>
        <p><?=round($averagelunchtime, 2) . " Stunden"?></p>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <form name="blog-form" action="index.php?page=logout" method="post">
                    <div class="form-actions">
                        <input class="btn btn-primary" type="submit" value="Logout">
                        <input class="btn btn-primary" type="submit" value="Passwort ändern">
                    </div>
                </form>
            </li>
        </ul>
        <hr class="d-sm-none">
        </div>
        <div class="col-sm-8">
            <h3>Übersicht:</h3>
            <button class="collapsible">Tages Übersicht</button>
            <div class="content">
                <form name="blog-form" action="index.php?page=timereport" method="post" class="serch-forms">
                    <input type="date" name="dayserch" id="dayserch">
                    <input class="btn btn-primary" type="submit" value="Suchen">
                </form>
                <?php include 'views/serchday.view.php';?>
            </div>
            <?php foreach($users as $user): ?>
              <?php if($user['isAdmin'] == true): ?>
              <button class="collapsible">Stemplungen korrigieren</button>
              <div class="content">
                  <form name="blog-form" action="index.php?page=timereport" method="post" class="serch-forms">
                      <select name="userauswahl" id="userauswahl">
                        <?php foreach($allusers as $user): ?>
                          <?php if($_SESSION['UserIDselected'] == $user['UserID']):?>
                          <option value="<?= htmlspecialchars($user['UserID'], ENT_QUOTES, "UTF-8"); ?>" selected><?= htmlspecialchars($user['UserName'], ENT_QUOTES, "UTF-8"); ?></option>
                        <?php else:?>
                          <option value="<?= htmlspecialchars($user['UserID'], ENT_QUOTES, "UTF-8"); ?>"><?= htmlspecialchars($user['UserName'], ENT_QUOTES, "UTF-8"); ?></option>
                        <?php endif;?>
                        <?php endforeach;?>
                      </select>
                      <input class="btn btn-primary" type="submit" value="Suchen">
                  </form>
                <div class="form-actions">
                  <form name="blog-form" action="index.php?page=timereport" method="post" class="serch-forms">
                      <input type="date" name="dayserchuser" id="dayserchuser">
                      <input class="btn btn-primary" type="submit" value="Suchen">
                  </form>
                </div>
                <?php include 'views/backend.view.php';?>
            </div>
          <?php endif; ?>
        <?php endforeach;?>
        </div>
    </div>
  </div>
</div>
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;
    for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight){
        content.style.maxHeight = null;
        } else {
        content.style.maxHeight = content.scrollHeight + "px";
        }
    });
    }
</script>
