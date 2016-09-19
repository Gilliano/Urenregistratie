<?php
$_SESSION['userrole'] = "admin";

// Creates the complete table with all the records
// from the database
function createTable()
{
    $urenManager = new urenManager;
    $userManager = new userManager;
    
    $records = $urenManager->getAllRecords();
    $table_row = "";
    $userrole = $_SESSION['userrole'];
    foreach($records as $record)
    {
        $table_row .= "<tr>";
        $table_row .= "<th class='col-xs-2'>".$userManager->getEmailFromID($record['idMedewerker'])['email']."</th>";
        $table_row .= "<th class='col-xs-1'><input class='form-control editable $userrole' type='number' min='0' value='".$record['urengewerkt']."' readonly></th>";
        $table_row .= "<th class='col-xs-3'><textarea class='form-control editable $userrole' rows='1' readonly>".$record['omschrijving']."</textarea></th>";
        $table_row .= "<th class='col-xs-1' style='text-align: center; vertical-align: middle;'><input class='checkbox-inline editable $userrole' type='checkbox' name='innovative' value='Innovatief' checked=".($record['innovatief'] == 1 ? "true" : "false")."></th>";
        $table_row .= "<th class='col-xs-1' style='text-align: center; vertical-align: middle;'><input class='checkbox-inline editable $userrole' type='checkbox' name='validated' value='Goedgekeurd' checked='true'></th>"; // TODO: Get 'checked' from dbase record
        $table_row .= "</tr>";
        
        echo $table_row;
        $table_row = "";
    }
?>

    <script type="text/javascript">
    // Onclick event handler for controls
    // that have class 'editable'
    $(".editable").on("click", function(event) {
        var userrole = "<?php echo $_SESSION['userrole']; ?>"; // Current user's userrole

        // Check if this userrole can edit
        if (userrole === "admin")
        {
            $(event.target).removeAttr("readonly"); // Enable the clicked control
        }
        else
        {
            return false; // For handling checkboxes
        }
    });
    </script>

<?php
}

// Creates the option values for
// the mail filter dropdown
function createMailDropdown()
{
    $userManager = new userManager;
    
    $records = $userManager->getAllEmails();
    $option = "";
    foreach($records as $record)
    {
        $option .= "<option value=".substr($record['email'], 0, strpos($record['email'], "@")).">".$record['email']."</option>";
        echo $option;
        $option = "";
    }
}
?>