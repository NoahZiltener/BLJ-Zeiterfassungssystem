<?php
session_start();
if(!isset($_SESSION['UserID'])) {
    header("Location: http://10.20.16.102/Projekt-BLJ/index.php?page=login");
}
?>