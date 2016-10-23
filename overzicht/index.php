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
        <header>
            <!-- Alerts -->
            <div id="noRecordsFound" class="alert alert-info">
                <a href="#" class="close" aria-label="close">&times;</a>
                <strong>Info</strong> No records found with the current filters...
            </div>
            <div id="recordSavedSucces" class="alert alert-success">
                <a href="#" class="close" aria-label="close">&times;</a>
                <strong>Succes</strong> Succesfully saved the changes!
            </div>
            <div id="recordSavedFailed" class="alert alert-danger">
                <a href="#" class="close" aria-label="close">&times;</a>
                <strong>Failed</strong> Some records could not be saved! <!-- TODO: Make more detailed -->
            </div>
            <div id="filtersNotSet" class="alert alert-danger">
                <a href="#" class="close" aria-label="close">&times;</a>
                <strong>Failed</strong> Please make sure all filters are supplied with information.
            </div>

            <?php include_once '../main/php/navbar.php'; ?>
        </header>

        <!-- Container -->
        <div class="container">
            <div id="filter_row" class="row">
                <!-- Step 1: Users list -->
                <div class="col-sm-3 col-sm-offset-1">
                    <label for="users_list">Gebruikers</label><br>
                    <select id="users_list" class="selectpicker" data-live-search="true" multiple>
                        <!-- <option>Loading...</option> -->
                    </select>
                </div>

                <!-- Step 2: Projects list -->
                <div class="col-sm-3">
                    <label for="projects_list">Projecten</label><br>
                    <select id="projects_list" class="selectpicker" data-live-search="true" multiple>
                        <!-- <option>Loading...</option> -->
                    </select>
                </div>

                <!-- Step 3: Date range picker -->
                <div class="col-sm-3">
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
                <div id="description_loader" class="loader col-sm-2 col-sm-offset-5"></div>
                <div id="div_description_list" class="col-sm-6 col-sm-offset-3">
                    <label for="description_list">Omschrijvingen</label><br>
                    <select id="description_list" class="form-control" multiple="multiple">
                    </select><br>
                    <button id="save_button" type="button" class="btn btn-success">Opslaan</button>
                    <button id="export_button" type="button" class="btn btn-info">Export</button>
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
                            <h4 class="modal-title">Export to csv</h4>
                        </div>
                        <div class="modal-body">
                            You have unsaved changes to these records, do you want me to save them for you and create
                            an export?
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
    </body>
</html>