<!DOCTYPE html>
<html lang="nl">
    <head>
        <link href="css/urenregistratie.css" rel="stylesheet">

        <?php
            //make sure everything we need in here
            require_once '../main/php/head.php';
        ?>
    </head>

    <?php
    $projectManager = new projectManager();
    $size = sizeof($projectManager::getAllCurrentProject());
    $urenManager = new urenManager();
    
    if(isset($_POST['urenopslaan'])) {
        $urenManager::addUren();
    }
    ?>

    <body>
        <?php
            include_once '../main/php/navbar.php';
        ?>
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Uren invulformulier</div>
                    <div  class="panel-body">
                        <form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data" oninput="(urentotaal.value=parseFloat(eindtijd.value)-parseFloat(begintijd.value))(ureninnovatief.value=parseFloat(urentotaal.value)-parseFloat(urenregulier.value))">
                            <table>
                                <tr>
                                    <p>
                                        <select class="selectpicker" name="project" data-width="700px" data-live-search="true" title="Kies een project...">
                                            <?php for($i = 0; $i < $size; $i++) { ?>
                                            <option value="<?= $projectManager::getAllCurrentProject()[$i]["idProject"]?>"><?= $projectManager::getAllCurrentProject()[$i]["projectnaam"]?></option>
                                            <?php } ?>
                                        </select>
                                    </p>
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
    </body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript
    <?php
    //performance increasing not everything in the head, not necessary things in the footer.
    require_once '../main/php/footer.php';
    ?>
</html>