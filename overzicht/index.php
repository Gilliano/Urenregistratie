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

        <!-- Date Range picker -->
        <link rel="stylesheet" type="text/css" href="css/daterangepicker.css">
        <!-- Context Menu -->
        <link rel="stylesheet" type="text/css" href="css/jquery.contextMenu.min.css">
        <!-- Overizcht -->
        <link href="css/overzicht.css" rel="stylesheet">
    </head>
    <body>
        <!-- Alerts -->
        <div id="noRecordsFound" class="alert alert-info">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Info</strong> No records found with the current filters...
        </div>

        <header>
            <?php include_once '../main/php/navbar.php'; ?>
        </header>

        <!-- Container -->
        <div class="container">
            <div id="filter_row" class="row">
                <!-- Step 1: Users list -->
                <div class="col-sm-3 col-sm-offset-1">
                    <label for="users_list">Gebruikers</label><br>
                    <select id="users_list" class="selectpicker" data-live-search="true">
                        <option>Loading...</option>
                    </select>
                </div>

                <!-- Step 2: Projects list -->
                <div class="col-sm-3">
                    <label for="projects_list">Projecten</label><br>
                    <select id="projects_list" class="selectpicker" data-live-search="true">
                        <option>Loading...</option>
                    </select>
                </div>

                <!-- Step 3: Date range picker -->
                <div class="col-sm-2">
                    <label for="daterange_picker">Datum: van .. tot</label><br>
                    <input id="daterange_picker" type="text" class="form-control" name="daterange"/>
                </div>

                <!-- Button to show description list -->
                <div class="col-sm-1">
                    <label for="search_button"></label><br>
                    <button id="search_button" type="button" class="btn btn-primary">Zoeken</button>
                </div>
            </div>
            <div id="description_row" class="row">
                <!-- Step 4: Description list -->
                <div id="div_description_list" class="col-sm-6 col-sm-offset-3">
                    <label for="description_list">Omschrijvingen</label><br>
                    <select id="description_list" class="form-control" multiple="multiple">
                        <option class="context-menu-one">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vitae bibendum libero.</option>
                        <option class="context-menu-one">Proin sed aliquam lectus.</option>
                    </select><br>
                    <button id="save_button" type="button" class="btn btn-success">Opslaan</button>
                </div>
            </div>
        </div>

        <!--  Apply main scripts  -->
        <?php require_once("../main/php/footer.php"); ?>
        <!-- Initializer script -->
        <script type="text/javascript" src="js/initialization.js"></script>
        <!-- Button handlers -->
        <script type="text/javascript" src="js/buttonHandlers.js"></script>
        <!-- Utilities -->
        <script type="text/javascript" src="js/utilities.js"></script>
        <!-- Date Range picker prerequisites -->
        <script type="text/javascript" src="js/moment.min.js"></script>
        <!-- Include Date Range picker -->
        <script type="text/javascript" src="js/daterangepicker.js"></script>
        <!-- Include Context Menu -->
        <script type="text/javascript" src="js/jquery.contextMenu.min.js"></script>
    </body>
</html>