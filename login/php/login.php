<?php
/**
 * Created by PhpStorm.
 * User: Niels
 * Date: 20-9-2016
 * Time: 12:22
 */

function errorMessage() {
    //return the results of the login form
    $check = userManager::login();
    //If results returns False then show a message
    if($check === false) {

        $error = "";
        $error .= "<div class='alert alert-danger'>";
        $error .= "Username and password do not match.";
        $error .="</div>";

        return $error;

    }

    return NULL;

}


