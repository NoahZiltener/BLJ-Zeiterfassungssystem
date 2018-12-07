<?php
    session_start();
    session_destroy();
    header("Location: http://10.20.16.102/Projekt-BLJ/index.php?page=timereport");
?>