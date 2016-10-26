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
        $table .= '<td>' . $user['validated'] . '</td>';
        $table .= '<td>' . $user['rol'] . '</td>';
        $table .= '<td>' . $user['state'] . '</td>';
        $table .= "<td> <button type='submit' id='gebruiker_wijzig' name='gebruiker_wijzig' value='" . $user['idMedewerker'] . "' class='btn btn-default' data-toggle='modal' data-target='#myModal'>Wijzig</button> </td>";
        $table .= '</tr>';

    }

    return $table;
}

function projecten()
{
    $projecten = projectManager::getAllProjects();
    $table = '';
    foreach ($projecten as $project) {

        $table .= "<tr>";

        $table .= "<td>" . $project['projectnaam'] . "</td>";
        if ($project['verwijderd'] == 0) {
            $table .= '<td>Niet verwijderd</td>';
        } else {
            $table .= '<td>Wel verwijderd</td>';
        }
        //$table .= '<td><input type="hidden" value=\'" . $project[\'idProject\'] . "\'></td>';

        $table .= "<td><a href='php/toggleProject.php?projectid=" . $project['idProject'] . "&delete=". $project['verwijderd'] ."' type='submit' name='project_toggle' class='btn btn-default'>toggle status</a></td>";
        $table .= '</tr>';


    }

    return $table;
}

function toggleProject() {
    if(isset($_GET['projectid'])) {
        echo $_GET['projectid'];
    }
}

