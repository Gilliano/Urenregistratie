<?php
/**
 * Created by PhpStorm.
 * User: niels
 * Date: 4-10-2016
 * Time: 17:11
 */

function users()
{
    $users = userManager::getAllUsers();
    $table = '';
    foreach ($users as $user) {

        $table .= "<tr>";
        $table .= "<td style='display: none'>" . $user['idMedewerker'] . "</td>";
        $table .= "<td>" . $user['voornaam'] . "</td>";
        $table .= '<td>' . $user['tussenvoegsels'] . '</td>';
        $table .= '<td>' . $user['achternaam'] . '</td>';
        $table .= '<td>' . $user['email'] . '</td>';
        $table .= '<td>' . $user['rol'] . '</td>';
        $table .= '<td>' . $user['state'] . '</td>';
        $table .= "<td> <button type='submit' id='gebruiker_wijzig' name='gebruiker_wijzig' value='" . $user['idMedewerker'] . "' class='btn btn-default' data-toggle='modal' data-target='#myModal'>Wijzig</button> </td>";
        $table .= '</tr>';

    }

    return $table;
}

function projecten()
{
    $projecten = projectManager::getAllProjectsStatusSort();
    $table = '';
    foreach ($projecten as $project) {

        $table .= "<tr>";
        $table .= "<td style='display: none'>" . $project['idProject'] . "</td>";

        $table .= "<td>" . $project['projectnaam'] . "</td>";
        $table .= "<td style='display: none'>" . $project['verwijderd'] . "</td>";
        if ($project['verwijderd'] == 0) {
            $table .= '<td>Niet afgerond</td>';
        } else {
            $table .= '<td>Afgerond</td>';
        }
        $table .= "<td><button type='submit' name='project_wijzig' value='" . $project['idProject'] . "' class='btn btn-default' data-toggle='modal' data-target='#myProject'>Wijzig</button> </td>";

        $table .= '</tr>';


    }

    return $table;
}



function registerOtherUser() {
    if(isset($_POST['registreren'])){


        if(userManager::emailBestaatAl($_POST['remail']."@branchonline.nl") === true){
            $error = 'de ingevoerde email adress bestaat al';
        }
        else if($_POST['rpassword'] != $_POST['repassword']){
            $error = 'uw wachtwoorden komen niet overeen';
        }
        else if(strlen($_POST['rpassword']) < 3 || strlen($_POST['repassword']) < 3){
            $error = 'uw wachtwoord moet minimaal 3 tekens bevatten';
        }
        else if($_POST['rpassword'] == $_POST['repassword']){
            userManager::registreren($_POST['voornaam'],$_POST['tussenvoegsel'],$_POST['achternaam'],$_POST['remail']."@branchonline.nl",$_POST['rpassword']);
            $voornaam = "";
            $tussenvoegsel = "";
            $achternaam = "";
            $remail = "";
        }

        if(!empty($error)){
           return $error = userManager::Message($error,'danger');

        }
    }
}

