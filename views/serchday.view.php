<?php
include 'models/serchday.model.php';
?>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <?php foreach($userdays as $day): ?>
                <?php if($day['DayDate'] == $_SESSION['date']): ?>
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
                    <h3>Stemplungen:</h3>
            <?php foreach($userstamps as $stamp): ?>
                <?php
                    $parts = explode(" ", $stamp['StampDateandTime']);
                ?>
                <?php if($parts[0] == $_SESSION['date'] && $stamp['IsIgnored'] == 0): ?>
                    <p>
                        <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>
                    </p>
                <?php endif; ?>
            <?php endforeach;?>
                <?php endif; ?>
            <?php endforeach;?>

        <?php endif; ?>
