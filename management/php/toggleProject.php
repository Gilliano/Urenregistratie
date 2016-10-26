<?php
/**
 * Created by PhpStorm.
 * User: niels
 * Date: 26-10-2016
 * Time: 10:29
 */
//make sure everything we need in here
require_once '../../main/php/main.php';

$conn = database::connect();

projectManager::toggleProjectFromID($_GET['projectid'], $_GET['delete']);

if(!isset($_GET['projectid'])) {
    header('Location: ../?page=projecten');
} else {
    $projecten = projectManager::getAllProjects();

    foreach ($projecten as $project) {
        echo $project['idProject'];
        echo '<br>';
    }
}