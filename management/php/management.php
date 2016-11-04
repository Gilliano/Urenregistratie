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
            $error = 'De ingevoerde e-mailadres bestaat al.';
        }
        else if($_POST['rpassword'] != $_POST['repassword']){
            $error = 'Uw wachtwoorden komen niet overeen.';
        }
        else if(!$_POST['voornaam'] || !$_POST['achternaam']){
            $error = 'U bent vergeten uw voornaam en/of achternaam in te vullen.';
        }else if(!$_POST['remail']){
            $error = 'U bent vergeten om een e-mailadres in te vullen.';
        }
        else if(strpos($_POST['voornaam'], ' ') || strpos($_POST['achternaam'], ' ') || strpos($_POST['remail'], ' ')){
            $error = 'U mag geen witte characters zetten bij voornaam,achternaam of email.';
        }
        else if(strlen($_POST['rpassword']) <= 5 || strlen($_POST['repassword']) <= 5){
            $error = 'Uw wachtwoord moet minimaal 5 tekens bevatten.';
        }
        else if($_POST['rpassword'] == $_POST['repassword']){
            userManager::registreren($_POST['voornaam'],$_POST['tussenvoegsel'],$_POST['achternaam'],$_POST['remail']."@branchonline.nl",$_POST['rpassword'],'validated');
            $voornaam = "";
            $tussenvoegsel = "";
            $achternaam = "";
            $remail = "";
            return  userManager::Message('de account is succesvol aangemaakt','success');
        }

    if(!empty($error)){
       return userManager::Message($error,'danger');

    }
}
}

