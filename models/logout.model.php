<?php
    session_start();
    session_destroy();
    header("Location: http://localhost/Projekt-BLJ/index.php?page=timereport");
?>