<!--
To use these functions with JS(jQuery)
follow this template
-----------------------------------------
var action = "FUNCTION_NAME";
var param1 = "PARAM1";
var ajaxurl = "../main/php/ajax.php";
var data = {'action': action, 'params': {'CUSTOM_PARAM_NAME': param1}};
$.post(ajaxurl, data, function(response){
    // Do something with the response
    // Response is everything that the FUNCTION
    // has echoéd
});
-----------------------------------------
-->

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
            getRecordsTable();
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
function getRecordsTable()
{
    require_once("../../overzicht/php/overzicht.php");
    echo createTable($_SESSION['pagenumber']); // From overzicht.php
    exit();
}
?>