<?php session_start(); ?>
<!DOCTYPE html>

<html lang="nl">
    <head>
        <meta name="viewport" content="width=device-width,user-scalable=yes">
        <link href="../main/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Montserrat:400,400italic,700normal,700italic,700"/>
        <link href="../main/css/navbar.css" rel="stylesheet">
        <link href="css/urenregistratie.css" rel="stylesheet">
        <title>Branch</title>

        <?php
            //make sure everything we need in here
            require_once '../main/php/head.php';
        ?>


    </head>
    <body>
        <?php
            include_once '../main/php/navbar.php';
        ?>
        <div class="container"> 
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Kies een project</div>
                    <div class="panel-body">
                        <form method="post" action="" name="project" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td>
                                        <select class="btn btn-default">
                                            <option selected disabled hidden>Kies een project</option>
                                            <option class="btn btn-default">Mustard</option>
                                            <option class="btn btn-default">Ketchup</option>
                                            <option class="btn btn-default">Relish</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Uren invulformulier</div>
                    <div  class="panel-body">
                        <form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data" oninput="(urentotaal.value=parseFloat(eindtijd.value)-parseFloat(begintijd.value))(ureninnovatief.value=parseFloat(urentotaal.value)-parseFloat(urenregulier.value))">
                            <table>
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
                                    <td class="field"><output readonly type="number" name="ureninnovatief" class="form-control" id="ureninnovatief"/></td>
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
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</html>