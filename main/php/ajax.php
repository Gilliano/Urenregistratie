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
    echo "\$_SESSION['".$params['sessionVariable']."'] = ".$params['value'];
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
    if(isset($params['userEmail']))
        $params['userID'] = userManager::getIDFromEmail($params['userEmail'])['idMedewerker'];
    if(isset($params['projectName']))
        $params['projectID'] = projectManager::getProjectIDFromName($params['projectName'])['idProject'];

    $records = urenManager::getRecordsForUserProjectDaterange($params['userID'], $params['projectID'], $params['date1'], $params['date2']);
    echo json_encode($records);
}

// Saves the uur record(s) into the database
function saveUurRecord($params)
{
    foreach(urenManager::UpdateUren($params) as $result)
        echo $result . "\n";
}

function wijzigGebruiker($params) {
    echo $params['firstname'];
    echo $params['insertion'];
    echo $params['lastname'];
    echo $params['email'];
    echo $params['valide'];
    echo $params['rol'];
    echo $params['state'];
}
