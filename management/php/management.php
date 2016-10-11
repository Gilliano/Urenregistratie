<?php
/**
 * Created by PhpStorm.
 * User: niels
 * Date: 4-10-2016
 * Time: 17:11
 */

function users() {
    $users = userManager::getAllUsers();
    $table = '';
    foreach ($users as $user) {

        $table .= "<tr>";

        $table .=   "<td>".$user['voornaam']."</td>";
        $table .=   '<td>'.$user['tussenvoegsels'].'</td>';
        $table .=   '<td>'.$user['achternaam'].'</td>';
        $table .=   '<td>'.$user['email'].'</td>';
        $table .=   '<td>'.$user['validated'].'</td>';
        $table .=   '<td>'.$user['rol'].'</td>';
        $table .=   '<td>'.$user['state'].'</td>';
        $table .=   "<td> <button type='submit' name='gebruiker_wijzig' value='". $user['idMedewerker'] ."' class='btn btn-default' data-toggle='modal' data-target='#myModal'>Wijzig</button> </td>";
        $table .= '</tr>';

        }

    return $table;
}

function projecten() {
    $projecten = projectManager::getAllProjects();
    $table = '';
    foreach ($projecten as $project) {

        $table .= "<tr>";

        $table .=   "<td>".$project['projectnaam']."</td>";
        if($project['verwijderd'] == 0) {
            $table .=   '<td>Niet verwijderd</td>';
        } else {
            $table .=   '<td>Wel verwijderd</td>';
        }
        $table .=   "<td><button type='submit' name='gebruiker_wijzig' value='". $project['idProject'] ."' class='btn btn-default' data-toggle='modal' data-target='#myModal'>toggle status</button></td>";
        $table .= '</tr>';

    }

    return $table;
}

