<?php
$_SESSION['userrole'] = "admin"; // DEBUG: This should be done after login
if(!isset($_SESSION['pagenumber']))
    $_SESSION['pagenumber'] = 1;

// Creates the complete table with all the records
// from the database
// TODO: Get the first (100 records)
// and cache those for performance
function createTable($pageNumber)
{
    $records = urenManager::getAllRecords($pageNumber);
    $projects = projectManager::getAllProjects();
    $table_row = "";
    $userrole = $_SESSION['userrole'];
    foreach($records as $record)
    {
        $table_row .= "<tr>";
        $table_row .= "<th class='col-xs-2'>".userManager::getEmailFromID($record['idMedewerker'])['email']."</th>";
        $table_row .= "<th class='col-xs-2'><select class='form-control'>";
        $projectnaam = projectManager::getProjectNameFromID($record['idProject'])['projectnaam'];
        $table_row .= "<option value=".$projectnaam.">".$projectnaam."</option>";
        foreach($projects as $project)
        {
            if ($project['projectnaam'] != $projectnaam)
                $table_row .= "<option value=".$project['projectnaam'].">".$project['projectnaam']."</option>";   
        }
        $table_row .= "</select></th>";
        $table_row .= "<th class='col-xs-1'><input class='form-control editable $userrole' type='number' min='0' value='".$record['urengewerkt']."' readonly></th>";
        $table_row .= "<th class='col-xs-3'><textarea class='form-control editable $userrole' rows='1' readonly>".$record['omschrijving']."</textarea></th>";
        $table_row .= "<th class='col-xs-1' style='text-align: center; vertical-align: middle;'><input class='checkbox-inline editable $userrole' type='checkbox' name='innovative' value='Innovatief' checked=".($record['innovatief'] == 1 ? "true" : "false")."></th>";
        $table_row .= "<th class='col-xs-1' style='text-align: center; vertical-align: middle;'><input class='checkbox-inline editable $userrole' type='checkbox' name='validated' value='Goedgekeurd' checked=".($record['goedgekeurd'] == 1 ? "true" : "false")."></th>"; 
        $table_row .= "</tr>";
    }
    
    return $table_row;
}

// Creates the option values for
// the mail filter dropdown
function createMailDropdown()
{    
    $records = userManager::getAllEmails();
    $option = "";
    foreach($records as $record)
    {
        $option .= "<option value=".substr($record['email'], 0, strpos($record['email'], "@")).">".$record['email']."</option>";
    }
    
    return $option;
}

// Creates the option values for
// the project filter dropdown
function createProjectDropdown()
{
    $records = projectManager::getAllProjects();
    $option = "";
    foreach($records as $record)
    {
        $option .= "<option value=".$record['projectnaam'].">".$record['projectnaam']."</option>";
    }
    
    return $option;
}
?>