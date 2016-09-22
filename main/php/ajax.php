<?php
include 'main.php';

if(isset($_POST['action']))
{
    switch($_POST['action'])
    {
        case 'getSessionVariable':
            getSessionVariable($_POST['params']);
            break;
        case 'setSessionVariable':
            setSessionVariable($_POST['params']);
            break;
        case 'getRecordsTable':
            getRecordsTable($_POST['params']);
            break;
        default:
            echo $_POST['action']." not found!";
            break;
    }
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
            $_SESSION['pagenumber'] -= $_SESSION['pagenumber'] > 1 ? 1 : 0;
            break;
    }
    echo createTable($_SESSION['pagenumber']); // From overzicht.php
    exit();
}
?>