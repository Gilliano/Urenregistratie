<?php
// Start session if not started already
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
//classes
include 'classes/database.php';
include 'classes/userManager.php';
include 'classes/urenManager.php';
include 'classes/projectManager.php';
// TODO: include config.php (create config.php)
?>
