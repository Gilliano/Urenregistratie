<!DOCTYPE html>
<html lang="nl">
    <head>
        <?php
        //make sure everything we need in here
        require_once '../main/php/head.php';
        ?>
        <link href="css/urenregistratie.css" rel="stylesheet">
        <link href="css/bootstrap-switch.css" rel="stylesheet">
    </head>

    <?php
    $arraySize = sizeof(projectManager::getAllCurrentProjects());
    $date = date("Y-m-d");
    ?>

    <body>
    <?php
    include_once '../main/php/navbar.php';
    ?>
    <div class="container">
        <div class="col-md-12" style="text-align: center;">
            <p>
                <input type="checkbox" name="mode" id="mode" data-on-text="Advanced" data-off-text="Normal" data-toggle="modal" data-target="#modalFormulier">
            </p>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id="mainFormulier">
                <div class="panel-heading">Uren invulformulier</div>
                <div  class="panel-body">
                    <form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data" oninput="(urentotaal.value=parseFloat(eindtijd.value)-parseFloat(begintijd.value))(ureninnovatief.value=parseFloat(urentotaal.value)-parseFloat(urenregulier.value))">
                        <table>
                            <tr>
                                <?php
                                if(isset($_POST['urenopslaan'])) {
                                    echo urenManager::addUren();
                                }
                                ?>
                                <td class="description">Project</td>
                                <td class="field">

                                    <select class="selectpicker" name="project" data-width="" data-live-search="true" title="Kies een project..." required>
                                        <?php for($i = 0; $i < $arraySize; $i++) { ?>
                                            <option value="<?= projectManager::getAllCurrentProjects()[$i]["idProject"]?>"><?= projectManager::getAllCurrentProjects()[$i]["projectnaam"]?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
 						</tr>
                        <tr>
                            <td class="description">Datum</td>
                            <td class="field"><input type="date" name="datum" class="form-control" id="datum" value="<?= $date ?>"/></td>
                        </tr>
                            <tr>
                                <td class="description">Begintijd</td>
                                <td class="field"><input type="time" name="begintijd" step="1800" class="form-control" id="begintijd" required/></td>
                            </tr>
                            <tr>
                                <td class="description">Eindtijd</td>
                                <td class="field"><input type="time" name="eindtijd" step="1800" class="form-control" id="eindtijd" required/></td>
                            </tr>
                            <tr>
                                <td class="description">Totaal aantal uren gewerkt</td>
                                <td class="field"><output readonly type="number" name="urentotaal" class="form-control" id="urentotaal"/></td>
                            </tr>
                            <tr>
                                <td class="description">Reguliere uren</td>
                                <td class="veld"><input type="number" name="urenregulier" class="form-control" id="urenregulier" required/></td>
                            </tr>
                            <tr>
                                <td class="description">Innovatieve uren</td>
                                <td class="field"><input type="number" name="ureninnovatief" class="form-control" id="ureninnovatief" readonly/></td>
                            </tr>
                            <tr>
                                <td class="description">Omschrijving van de uren</td>
                                <td class="field"><textarea name="omschrijving" class="form-control" id="omschrijving" required/></textarea></td>
                            </tr>
                            <!--submit-->
                            <tr>
                                <td class="submit"></td>
                                <td><input type="submit" name="urenopslaan" class="opslaan btn btn-success" value="Bevestigen"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2" id="modalContent">

    </div>
    <!-- This is a pop-up. When switch to advanced mode this screen will been show -->
    <div class="container">
        <!-- Modal -->
        <div class="modal fade modalFormulier" id="modalFormulier" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Team uren invullen</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data" oninput="(urentotaal.value=parseFloat(eindtijd.value)-parseFloat(begintijd.value))(ureninnovatief.value=parseFloat(urentotaal.value)-parseFloat(urenregulier.value))">
                            <table>
                                <tr>
                                    <td class="description">Medewerkers</td>
                                    <td class="field">
                                        <select class="selectpicker" multiple name="medewerker" data-width="" data-live-search="true" title="Kies medewerkers...">
                                            <?php for($i = 0; $i < $arraySize; $i++) { ?>
                                                <option value="<?= projectManager::getAllCurrentProjects()[$i]["idProject"]?>"><?= projectManager::getAllCurrentProjects()[$i]["projectnaam"]?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Project</td>
                                    <td class="field">
                                        <select class="selectpicker" name="project" data-width="" data-live-search="true" title="Kies een project...">
                                            <?php for($i = 0; $i < $arraySize; $i++) { ?>
                                                <option value="<?= projectManager::getAllCurrentProjects()[$i]["idProject"]?>"><?= projectManager::getAllCurrentProjects()[$i]["projectnaam"]?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Begintijd</td>
                                    <td class="field" style="width: 400px;"><input type="time" name="begintijd" class="form-control" id="begintijd" required/></td>
                                </tr>
                                <tr>
                                    <td class="description">Eindtijd</td>
                                    <td class="field"><input type="time" name="eindtijd" class="form-control" id="eindtijd" required/></td>
                                </tr>
                                <tr>
                                    <td class="description">Totaal aantal uren gewerkt</td>
                                    <td class="field"><output readonly type="number" name="urentotaal" class="form-control" id="urentotaal"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Reguliere uren</td>
                                    <td class="veld"><input type="number" name="urenregulier" class="form-control" id="urenregulier" required/></td>
                                </tr>
                                <tr>
                                    <td class="description">Innovatieve uren</td>
                                    <td class="field"><input type="number" name="ureninnovatief" class="form-control" id="ureninnovatief" readonly/></td>
                                </tr>
                                <tr>
                                    <td class="description">Omschrijving van de uren</td>
                                    <td class="field"><textarea name="omschrijving" class="form-control" id="omschrijving" required/></textarea></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="urenopslaan" class="opslaan btn btn-success" value="Bevestigen">
                        <input type="submit" name="urenopslaan" class="opslaan btn btn-danger" data-dismiss="modal" value="Annuleren">
                    </div>
                </div>

            </div>
        </div>
    </div>
    </body>
    <?php

    //performance increasing not everything in the head, not necessary things in the footer.
    require_once '../main/php/footer.php';
    ?>

    <script src="js/bootstrap-switch.js"></script>
    <script>
        $("[name='mode']").bootstrapSwitch();

        $('input[name="mode"]').on('switchChange.bootstrapSwitch', function(event, state) {
            if(state === true){
                $('#modalFormulier').modal('toggle');
                $('#mainFormulier').hide();

                $("#modalContent").html('<div class="panel panel-default modalPanel">' +
                    '<div class="panel-heading" data-toggle="collapse" href="#collapse1">Hoi</div>' +
                    '<div  class="panel-body collapse" id="collapse1">' +
                    '<form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data" oninput="(urentotaal.value=parseFloat(eindtijd.value)-parseFloat(begintijd.value))(ureninnovatief.value=parseFloat(urentotaal.value)-parseFloat(urenregulier.value))">' +
                    '<table>' +
                    '<tr>' +
                    '<td class="description">Begintijd</td>' +
                    '<td class="field"><input type="time" name="begintijd" class="form-control" id="begintijd" required/></td>' +
                '</tr>' +
                '<tr>' +
                '<td class="description">Eindtijd</td>' +
                    '<td class="field"><input type="time" name="eindtijd" class="form-control" id="eindtijd" required/></td>' +
                '</tr>');
            }else{
                //$("#mainFormulier").show();
                //$(".modalPanel").hide();
            }
        });

        $('#modalFormulier').on('hide.bs.modal', function () {
            $("[name='mode']").bootstrapSwitch('toggleState');
        })
    </script>
</html>