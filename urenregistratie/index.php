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
    $allCurrentProjects = projectManager::getAllCurrentProjects();
    $projectsArraySize = sizeof($allCurrentProjects);

    $allUsers = userManager::getAllUsers();
    $alleMedewerkers = sizeof($allUsers);

    $date = date("Y-m-d");
    ?>
    
    <body>
<<<<<<< HEAD
   <?php
      include_once '../main/php/navbar.php';
      ?>
   <div class="container">
      <div class="col-md-12 switch">
         <p>
            <!--                <input type="checkbox" class="hidden" name="mode" id="mode" data-on-text="Advanced" data-off-text="Normal" data-toggle="modal" data-target="#modalFormulier">-->
         </p>
      </div>
      <div class="col-md-8 col-md-offset-2">
         <div class="panel panel-default" id="mainFormulier">
            <div class="panel-heading">Uren invulformulier</div>
            <div  class="panel-body">
               <form method="post" action="" onsubmit="return submitChecker()" id="urenformulier" name="urenformulier" enctype="multipart/form-data">
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
                              <option value="<?= $allCurrentProjects[$i]["idProject"]?>"><?= $allCurrentProjects[$i]["projectnaam"]?></option>
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
                        <td class="field"><input type="time" onblur="realTimeWaarde()" name="begintijd" id="begintijd" step="1800" class="form-control" required/></td>
                     </tr>
                     <tr>
                        <td class="description">Eindtijd</td>
                        <td class="field"><input type="time" onblur="realTimeWaarde()" name="eindtijd" id="eindtijd" step="1800" class="form-control" required/></td>
                     </tr>
                     <tr>
                        <td class="description">Totaal aantal uren gewerkt</td>
                        <td class="field"><output readonly type="text" name="urentotaal" id="urentotaal" class="form-control"/></td>
                     </tr>
                     <tr>
                        <td class="description">Reguliere uren</td>
                        <td class="field"><input type="number" onkeyup="" name="urenregulier" id="urenregulier" onblur="urenRekenen()"  class="form-control" required/></td>
                     </tr>
                     <tr>
                        <td class="description">Innovatieve uren</td>
                        <td class="field"><output readonly type="text" name="ureninnovatief" id="ureninnovatief" value="3" class="form-control"/></td>
                     </tr>
                     <tr>
                        <td class="description">Omschrijving van de uren</td>
                        <td class="field"><textarea name="omschrijving" class="form-control" required/></textarea></td>
                     </tr>
                     <!--submit-->
                     <tr>
                        <td class="submit"></td>
                        <td><input type="submit" name="urenopslaan" id="urenopslaan" class="opslaan btn btn-success" value="Bevestigen"></td>
                     </tr>
                  </table>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- Here comes the jQuery model output -->
   <div class="col-md-8 col-md-offset-2" id="modalContent">
   </div>
</body>
=======
    <?php
    include_once '../main/php/navbar.php';
    ?>
    <div class="container">
        <div class="col-md-12 switch">
            <p>
                <input type="checkbox" class="hidden" name="mode" id="mode" data-on-text="Advanced" data-off-text="Normal" data-toggle="modal" data-target="#modalFormulier">
            </p>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id="mainFormulier">
                <div class="panel-heading">Uren invulformulier</div>
                <div  class="panel-body">
                    <form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data"">
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
                                        <?php for($i = 0; $i < $projectsArraySize; $i++) { ?>
                                            <option value="<?= $allCurrentProjects[$i]["idProject"]?>"><?= $allCurrentProjects[$i]["projectnaam"]?></option>
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
                                <td class="field"><input type="time" onblur="realTimeWaarde(); urenInnovatief()" name="begintijd" id="begintijd" step="1800" class="form-control" required/></td>
                            </tr>
                            <tr>
                                <td class="description">Eindtijd</td>
                                <td class="field"><input type="time" onblur="realTimeWaarde(); urenInnovatief()" name="eindtijd" id="eindtijd" step="1800" class="form-control" required/></td>
                            </tr>
                            <tr>
                                <td class="description">Totaal aantal uren gewerkt</td>
                                <td class="field"><output readonly type="number" name="urentotaal" id="urentotaal" class="form-control"/></td>
                            </tr>
                            <tr>
                                <td class="description">Reguliere uren</td>
                                <td class="field"><input type="number" oninput="urenInnovatief()" id="urenregulier" name="urenregulier" step="0.1" class="form-control" required/></td>
                            </tr>
                            <tr>
                                <td class="description">Innovatieve uren</td>
                                <td class="field"><input type="number" id="ureninnovatief" name="ureninnovatief" class="form-control" readonly/></td>
                            </tr>
                            <tr>
                                <td class="description">Omschrijving van de uren</td>
                                <td class="field"><textarea name="omschrijving" class="form-control" required/></textarea></td>
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

    <!-- Here comes the jQuery model output -->
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
                        <form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data" oninput="(teamUrentotaal.value=parseFloat(teamEindtijd.value)-parseFloat(teamBegintijd.value))(teamUreninnovatief.value=parseFloat(teamUrentotaal.value)-parseFloat(teamUrenregulier.value))">
                            <table>
                                <tr>
                                    <td class="description">Medewerkers</td>
                                    <td class="field">
                                        <select class="selectpicker" multiple name="medewerker" id="teamMedewerker" data-width="" data-live-search="true" title="Kies medewerkers...">
                                            <?php for($i = 0; $i < $alleMedewerkers; $i++) { ?>
                                                <?php if(empty($allUsers[$i]["tussenvoegsel"])) { ?>
                                                    <option value="<?= $allUsers[$i]["idMedewerker"] ?>"><?= $allUsers[$i]["voornaam"] . " "  . $allUsers[$i]["achternaam"]?></option>
                                                <?php } else{  ?>
                                                    <option value="<?= $allUsers[$i]["idMedewerker"] ?>"><?= $allUsers[$i]["voornaam"] . " " . $allUsers[$i]["tussenvoegsel"] . " " . $allUsers[$i]["achternaam"]?></option>
                                                <?php } } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Project</td>
                                    <td class="field">
                                        <select class="selectpicker" name="project" id="teamProject" data-width="" data-live-search="true" title="Kies een project...">
                                            <?php for($i = 0; $i < $projectsArraySize; $i++) { ?>
                                                <option value="<?= $allCurrentProjects[$i]["idProject"]?>"><?= $allCurrentProjects[$i]["projectnaam"]?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="description">Begintijd</td>
                                    <td class="field"><input type="time" name="teamBegintijd" id="teamBegintijd" class="form-control" required/></td>
                                </tr>
                                <tr>
                                    <td class="description">Eindtijd</td>
                                    <td class="field"><input type="time" name="teamEindtijd" id="teamEindtijd" class="form-control"  required/></td>
                                </tr>
                                <tr>
                                    <td class="description">Totaal aantal uren gewerkt</td>
                                    <td class="field"><output readonly type="number" name="teamUrentotaal" id="teamUrentotaal" class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td class="description">Reguliere uren</td>
                                    <td class="veld"><input type="number" name="teamUrenregulier" id="teamUrenregulier" class="form-control" required/></td>
                                </tr>
                                <tr>
                                    <td class="description">Innovatieve uren</td>
                                    <td class="field"><input type="number" name="teamUreninnovatief" id="teamUreninnovatief" class="form-control" readonly/></td>
                                </tr>
                                <tr>
                                    <td class="description">Omschrijving van de uren</td>
                                    <td class="field"><textarea name="omschrijving" id="teamOmschrijving"  class="form-control" required/></textarea></td>
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
>>>>>>> 886ee1765cd0a36bd9343302b3a535b8cb9edb2e
    <?php

    //performance increasing not everything in the head, not necessary things in the footer.
    require_once '../main/php/footer.php';
    ?>
    <!-- Load the bootstrap switch -->
    <script src="js/bootstrap-switch.js"></script>
    <!-- Load the modal -->
    <script src="js/modalHandler.js"></script>
    <!-- Load hour calculating -->
    <script src="js/urenAfronden.js"></script>
</html>