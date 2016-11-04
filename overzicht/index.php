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
        <?php require_once('php/overzicht.php');
        ?>

        <!-- Date Range picker -->
        <link rel="stylesheet" type="text/css" href="css/daterangepicker.css">
        <!-- Context Menu -->
        <link rel="stylesheet" type="text/css" href="css/jquery.contextMenu.min.css">
        <!-- Fastselect -->
        <link rel="stylesheet" type="text/css" href="css/fastselect.min.css">
        <!-- Overizcht -->
        <link rel="stylesheet" type="text/css" href="css/overzicht.css">
    </head>
    <body>
        <header>
            <?php include_once '../main/php/navbar.php'; ?>
            <!-- Alerts -->
            <div id="noRecordsFound" class="alert alert-info">
                <a href="#" class="close" aria-label="close">&times;</a>
                <strong>Info</strong> Geen records gevonden met deze filters...
            </div>
            <div id="recordSavedSucces" class="alert alert-success">
                <a href="#" class="close" aria-label="close">&times;</a>
                <strong>Succes</strong> Veranderingen zijn opgeslagen!
            </div>
            <div id="recordSavedFailed" class="alert alert-danger">
                <a href="#" class="close" aria-label="close">&times;</a>
                <strong>Error</strong> Sommigen records konden niet opgeslagen worden <!-- TODO: Make more detailed -->
            </div>
            <div id="filtersNotSet" class="alert alert-danger">
                <a href="#" class="close" aria-label="close">&times;</a>
                <strong>Error</strong> Zorg ervoor dat er bij alle filters info is ingevuld!
            </div>
        </header>

        <!-- Container -->
        <div class="container">
            <div class="row">
                <div id="filter_loader" class="loader col-sm-2 col-sm-offset-5"></div>
            </div>
            <div id="filter_row" class="row">
                <div id="filters_1" class="row">
                    <!-- Step 1: Users list -->
                    <div class="col-sm-3 col-sm-offset-2">
                        <label for="users_list">Gebruikers</label><br>
                        <select id="users_list" class="selectpicker" data-live-search=<?php echo $_SESSION['rol']==="medewerker"?"false":"true"?> data-actions-box=<?php echo $_SESSION['rol']==="medewerker"?"false":"true"?> multiple>
                            <!-- <option>Loading...</option> -->
                        </select>
                    </div>

                    <!-- Step 2: Projects list -->
                    <div class="col-sm-3">
                        <label for="projects_list">Projecten</label><br>
                        <select id="projects_list" class="selectpicker" data-live-search="true" data-actions-box="true" multiple>
                            <!-- <option>Loading...</option> -->
                        </select>
                    </div>

                    <!-- Step 3: Date range picker -->
                    <div class="col-sm-3">
                        <label for="daterange_picker">Datum: van .. tot</label><br>
                        <input id="daterange_picker" type="text" class="form-control" name="daterange"/>
                    </div>
                </div>

                <div id="filters_2" class="row">
                    <!-- Step 4: Extra filters (tags) -->
                    <div class="col-sm-7 col-sm-offset-2">
                        <label for="tags_input"></label><br>
                        <select id="tags_input" class="multipleSelect" multiple>
                            <option selected value="innovative">Innovatief</option>
                            <option selected value="regular">Regulier</option>
                            <option selected value="validated">Goedgekeurd</option>
                            <option selected value="invalidated">Niet-Goedgekeurd</option>
                        </select>
                    </div>

                    <!-- Button to show description list -->
                    <div class="col-sm-1">
                        <label for="search_button"></label><br>
                        <button id="search_button" type="button" class="btn btn-primary">Zoeken</button>
                    </div>
                </div>
            </div>
            <div id="description_row" class="row">
                <!-- Step 5: Description list -->
                <div id="description_loader" class="loader col-sm-2 col-sm-offset-5"></div>
                <div id="div_description_list" class="col-sm-6 col-sm-offset-2">
                    <label for="description_list">Omschrijvingen</label><br>
                    <select id="description_list" class="form-control" multiple="multiple">
                    </select><br>
                    <button id="save_button" type="button" class="btn btn-success">Opslaan</button>
                    <button id="export_button" type="button" class="btn btn-info">Export</button>
                </div>
                <div id="div_summary" class="col-sm-3">
                    <br>
                    <label for="innoHours_value">Innovatieve uren: </label>
                    <span id="innoHours_value">--</span><br>
                    <label for="regularHours_value">Reguliere uren: </label>
                    <span id="regularHours_value">--</span><br>
                    <label for="totalHours_value">Totaal uren: </label>
                    <span id="totalHours_value">--</span>
                </div>
            </div>
            <!-- Edit modal -->
            <div id="edit_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Record aanpassen</h4>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button id="edit_modal_closeButton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button id="edit_modal_changeButton" type="button" class="btn btn-success">Change</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Export info message -->
            <div id="csv_message" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Exporteren naar csv</h4>
                        </div>
                        <div class="modal-body">
                            Je hebt verandering die nog niet zijn opgeslagen, wil je dat ik deze wijzigingen
                            voor je ga opslaan?
                        </div>
                        <div class="modal-footer">
                            <button id="csv_message_closeButton" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button id="csv_message_exportButton" type="button" class="btn btn-success">Yes</button>
                        </div>
                    </div>
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
        <!-- Fastselect -->
        <script type="text/javascript" src="js/fastselect.standalone.min.js"></script>
    </body>
</html>