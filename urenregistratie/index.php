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
    $arraySize = sizeof(projectManager::getAllCurrentProject());
    ?>

    <body>
        <?php
            include_once '../main/php/navbar.php';
        ?>
        <div class="container">
            <div class="col-md-12" style="text-align: center;">
                <p>
                    <input type="checkbox" name="mode" id="mode" data-on-text="Advanced" data-off-text="Normal" data-toggle="modal" data-target="#logOut">
                </p>

            </div>
            <div class="col-md-8 col-md-offset-2" id="main-formulier">
                <div class="panel panel-default">
                    <div class="panel-heading">Uren invulformulier</div>
                    <div  class="panel-body">
                        <form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data" oninput="(urentotaal.value=parseFloat(eindtijd.value)-parseFloat(begintijd.value))(ureninnovatief.value=parseFloat(urentotaal.value)-parseFloat(urenregulier.value))">
                            <?php
                                    if(isset($_POST['urenopslaan'])) {
                                        echo urenManager::addUren();
                                    }
                            ?>
                            <table>
<!--                                <tr>-->
<!--                                    <p style="text-align: center;">-->
<!--                                        <input type="checkbox" name="my-checkbox" data-on-text="Advanced" data-off-text="Normal">-->
<!--                                    </p>-->
<!--                                </tr>-->
                                <tr>
                                    <td class="description">Project</td>
                                        <td class="field">
                                            <select class="selectpicker" name="project" data-width="" data-live-search="true" title="Kies een project...">
                                                <?php for($i = 0; $i < $arraySize; $i++) { ?>
                                                    <option value="<?= projectManager::getAllCurrentProject()[$i]["idProject"]?>"><?= projectManager::getAllCurrentProject()[$i]["projectnaam"]?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                </tr>
                                <tr>
                                    <td class="description">Begintijd</td>
                                    <td class="field"><input type="time" name="begintijd" class="form-control" id="begintijd"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Eindtijd</td>
                                    <td class="field"><input type="time" name="eindtijd" class="form-control" id="eindtijd"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Totaal aantal uren gewerkt</td>
                                    <td class="field"><output readonly type="number" name="urentotaal" class="form-control" id="urentotaal"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Reguliere uren</td>
                                    <td class="veld"><input type="number" name="urenregulier" class="form-control" id="urenregulier"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Innovatieve uren</td>
                                    <td class="field"><input type="number" name="ureninnovatief" class="form-control" id="ureninnovatief" readonly/></td>
                                </tr>
                                <tr>
                                    <td class="description">Omschrijving van de uren</td>
                                    <td class="field"><textarea name="omschrijving" class="form-control" id="omschrijving"/></textarea></td>
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
        <!-- This is a pop-up. When switch to advanced mode this screen will been show -->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade logOut" id="modalFormulier" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Team uren invullen</h4>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td class="description" style="width: 150px">Medewerkers</td>
                                    <td class="field">
                                        <select class="selectpicker" multiple name="medewerker" data-width="" data-live-search="true" title="Kies medewerkers...">
                                            <?php for($i = 0; $i < $arraySize; $i++) { ?>
                                                <option value="<?= projectManager::getAllCurrentProject()[$i]["idProject"]?>"><?= projectManager::getAllCurrentProject()[$i]["projectnaam"]?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description" style="width: 150px">Project</td>
                                    <td class="field">
                                        <select class="selectpicker" name="project" data-width="" data-live-search="true" title="Kies een project...">
                                            <?php for($i = 0; $i < $arraySize; $i++) { ?>
                                                <option value="<?= projectManager::getAllCurrentProject()[$i]["idProject"]?>"><?= projectManager::getAllCurrentProject()[$i]["projectnaam"]?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Begintijd</td>
                                    <td class="field" style="width: 400px;"><input type="time" name="begintijd" class="form-control" id="begintijd"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Eindtijd</td>
                                    <td class="field"><input type="time" name="eindtijd" class="form-control" id="eindtijd"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Totaal aantal uren gewerkt</td>
                                    <td class="field"><output readonly type="number" name="urentotaal" class="form-control" id="urentotaal"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Reguliere uren</td>
                                    <td class="veld"><input type="number" name="urenregulier" class="form-control" id="urenregulier"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Innovatieve uren</td>
                                    <td class="field"><input type="number" name="ureninnovatief" class="form-control" id="ureninnovatief" readonly/></td>
                                </tr>
                                <tr>
                                    <td class="description">Omschrijving van de uren</td>
                                    <td class="field"><textarea name="omschrijving" class="form-control" id="omschrijving"/></textarea></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer logout-footer">
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
                $( "#main-formulier" ).hide();
            }else{
                $( "#main-formulier" ).show();
            }
        });

        $('#modalFormulier').on('hide.bs.modal', function () {
            $("[name='mode']").bootstrapSwitch('toggleState');
        })
    </script>

</html>