<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Urenregistratie</title>

        <!-- For PHP classes -->
        <?php require_once('../main/php/head.php'); ?>
        <!-- PHP code for overzicht page -->
        <?php require_once('php/overzicht.php'); ?>
        
        <!-- Overizcht -->
        <link href="css/overzicht.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <?php include_once '../main/php/navbar.php'; ?>
        </header>
        
        <!-- Data list -->
        <div class="container">
            <table id="datalist" class="table table-bordered">
                <thead>
                    <th>
                        <select class="form-control"> <!-- TODO: get mails from dbase -->
                            <?php echo createMailDropdown(); ?>
<!--
                            <option value="JohnDoe">JohnDoe@branchonline.nl</option>
                            <option value="Berry">Berry@branchonline.nl</option>
                            <option value="Anotherone">Anotherone@branchonline.nl</option>
-->
                        </select>
                    </th>
                    <th>
                        <input class="form-control" type="number" name="hours_filter" min="0">
                    </th>
                    <th>
                        <textarea class="form-control" type="text" name="description_filter" rows=1 style="height: 35px;">gewerkt aan</textarea>
                    </th>
                    <th style="text-align: center; vertical-align: middle;">
                        <input class="checkbox-inline" type="checkbox" name="innovative_filter" value="Innovatief">
                    </th>
                    <th style="text-align: center; vertical-align: middle;">
                        <input class="checkbox-inline" type="checkbox" name="validated_filter" value="Goedgekeurd">
                    </th>
                </thead>
                <thead>
                    <tr>
                        <th style="text-align: center;">Email</th>
                        <th style="text-align: center;">Uren</th>
                        <th style="text-align: center;">Omschrijving</th>
                        <th style="text-align: center;">Innovatief</th>
                        <th style="text-align: center;">Goedgekeurd</th>    
                    </tr>
                </thead>
                <tbody>
                    <?php echo createTable(); ?>
                </tbody>
            </table>
        </div>
    </body>
</html>