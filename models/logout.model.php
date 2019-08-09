<?php
    session_start();
    session_destroy();
    header("Location: http://localhost/TimeCounter/Projekt-BLJ/index.php?page=timereport");
?>
