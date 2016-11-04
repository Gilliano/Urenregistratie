<?php
require_once 'main.php';

// Call method by string
if(isset($_POST['action']))
{
    if(is_callable($_POST['action']))
    {
        if(isset($_POST['params']))
            call_user_func($_POST['action'], $_POST['params']);
        else
            call_user_func($_POST['action']);
    }
    else
        echo $_POST['action']." not found!";
}

// Returns the userrole for this session
function getSessionVariable($params)
{
    if(isset($_SESSION[$params['sessionVariable']]))
        echo $_SESSION[$params['sessionVariable']];
    else
        echo "SessionVariable: ".$params['sessionVariable'].", not found!";
    exit();
}

// Sets the session variable to the given
// value
function setSessionVariable($params)
{   
    $_SESSION[$params['sessionVariable']] = $params['value'];
    echo "\$_SESSION['".$params['sessionVariable']."'] = ". is_array($params['value'])?var_dump($params['value']):$params['value'];
    exit();
}

// Gets the html code for the new table
function getRecordsTable($params)
{
    require_once("../../overzicht/php/overzicht.php");
    switch($params['method'])
    {
        case "nextButton":
            $_SESSION['pagenumber'] ++;
            break;
        case "previousButton":
            $_SESSION['pagenumber'] -= intval($_SESSION['pagenumber']) > 1 ? 1 : 0;
            break;
    }
    echo createTable($_SESSION['pagenumber']); // From overzicht.php
    exit();
}

// Gets the record(s) from the cache
// params['id']: id of the record to return
// note: if id is not set, whole cache
// will be returned
function getRecordsCache($params)
{
    if($params['id'] != null)
    {
        foreach($_SESSION['records_cache'] as $record)
        {
            if($record['idUur'] == $params['id'])
            {
                echo json_encode($record);
                return;
            }
        }
        echo "No records found";
    }
    else
        echo json_encode($_SESSION['records_cache']);
}

// Gets all projects
function getAllProjects()
{
    echo json_encode(projectManager::getAllProjects());
}

// Gets all users
function getUsers()
{
    echo json_encode(userManager::getAllUsers());
}

// Returns uren records between date
function getUrenBetweenDate($params)
{
    // Get ID's for names/emails
    if(isset($params['userEmails']))
    {
        $params['userIDs'] = [];
        foreach($params['userEmails'] as $userEmail)
        {
            $userID = userManager::getIDFromEmail($userEmail)['idMedewerker'];
            array_push($params['userIDs'], $userID);
        }
    }

    if(isset($params['projectNames']))
    {
        $params['projectIDs'] = [];
        foreach($params['projectNames'] as $projectName)
        {
            $projectID = projectManager::getProjectIDFromName($projectName)['idProject'];
            array_push($params['projectIDs'], $projectID);
        }
    }

    $records = urenManager::getRecordsForUserProjectDaterange($params['userIDs'], $params['projectIDs'], $params['date1'], $params['date2'], $params['extra']);
    echo json_encode($records);
}

// Saves the uur record(s) into the database
function saveUurRecord($params)
{
    foreach(urenManager::UpdateUren($params) as $result)
        echo $result . "\n";
}

//this wil update the user
function wijzigGebruiker($params) {
    echo json_encode(userManager::userChange($params));
}

function updateProject($params) {
    $conn = database::connect();
    try {
        $updateUser = " UPDATE project
                                SET
                                projectnaam=?,
                                verwijderd=?
                                WHERE idProject=?";
        $stmt       = $conn->prepare($updateUser);
        $stmt->bindParam(1, $params['title']);
        $stmt->bindParam(2, $params['done']);
        $stmt->bindParam(3, $params['id']);
        $stmt->execute();

        header('Location: ../?page=projecten');
        echo "succes";
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function allProjects() {
    echo json_encode(projectManager::getAllProjectsStatusSort());
}

function getAllHoursSimple($params) {

    $params['end'] = $params['end'] . ' ' . '23:59:59';

    $conn = database::connect();
    $stmt = $conn->prepare("SELECT 
      medewerker.voornaam,
      medewerker.tussenvoegsels,
      medewerker.achternaam,
      project.projectnaam,
      uur.*
      FROM uur
      INNER JOIN project ON project.idProject = uur.idProject
      INNER JOIN medewerker ON medewerker.idMedewerker = uur.idMedewerker WHERE (uur.begintijd BETWEEN ? AND ?)");
    $stmt->bindParam(1, $params['start']);
    $stmt->bindParam(2, $params['end']);
    $stmt->execute();
    $records = $stmt->fetchAll();

    echo json_encode($records);
}

function deleteHourByID($params) {
    $conn = database::connect();
    $stmt = $conn->prepare("DELETE FROM uur WHERE idUur=?");
    $stmt->bindParam(1, $params['idHour']);
    $stmt->execute();
}

function createProject($params) {
    $conn = database::connect();
    $stmt = $conn->prepare("INSERT INTO project (projectnaam)VALUES (?)");
    $stmt->bindParam(1, $params['projectname']);
    $stmt->execute();
}