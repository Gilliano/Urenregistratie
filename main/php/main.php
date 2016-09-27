<?php
// Start session if not started already
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
//Classes
include 'classes/database.php';
include 'classes/userManager.php';
include 'classes/urenManager.php';
include 'classes/projectManager.php';
// TODO: include config.php (create config.php)

// Check if SESSION['idMedewerkers'] isset and not empty, if so it will bring you back to login page
userManager::areYouLoggedIn();
?>
