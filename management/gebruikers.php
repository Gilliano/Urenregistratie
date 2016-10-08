<?php
/**
 * Created by PhpStorm.
 * User: niels
 * Date: 4-10-2016
 * Time: 17:07
 */

?>

<h1 style="font-family: 'Montserrat'">Gebruikers</h1>


<td colspan="3" valign="top" class='tabbed-content-container ui-corner-all'>
    <tr>
        <td>
            <button id= "registreren" class="btn btn-secondary btn-sm registreren" value =  "1">Registreren</button>
            <button id= "wijzigen" class="btn btn-secondary btn-sm wijzigen" value =  "1">Wijzigen</button>
<!--            <button id= "Close-open-button-1" class="btn btn-secondary btn-sm Close-open-button-1" value =  "1">Nog iets</button>-->
        </td>
    </tr>

    <div class="registreren">
        <form id="management_register_user" method="post" role="login">
            <h4 class="modal-title">Registreren</h4>

            <input type="text" name="firstname" placeholder="Voornaam" autocomplete="false" required class="form-control input-lg" />

            <input type="text" name="insertion" placeholder="Tussenvoegsel" autocomplete="false" class="form-control input-lg" />

            <input type="text" name="lastname" placeholder="Achternaam" autocomplete="false" required class="form-control input-lg" />

            <div class="row">
                <div class="col-sm-6 startmail">
                    <input type="text" name="email" placeholder="Email" autocomplete="false" required class="form-control input-lg" />
                </div>
                <div class="col-sm-6 endmail">
                    <p>@branchonline.nl</p>
                </div>
            </div>

            <input type="password" name="password" class="form-control input-lg" autocomplete="off" id="password" placeholder="Wachtwoord"/>
            <input type="password" name="repassword" class="form-control input-lg" autocomplete="off" id="password" placeholder="Herhaal wachtwoord"/>

            <input type="submit" name="user_register" value="Registreer" class="btn btn-lg btn-primary btn-block">

            <?php
            if(userManager::register() === false) {
                $error = "";
                $error .= "<div class='alert alert-danger'>";
                $error .= "Er is iets mis gegaan";
                $error .="</div>";

                echo $error;
            }
            ?>
        </form>
    </div>

    <div style="display: none" class="wijzigen div-1">
        <table class="gebruikers_wijzigen table">
            <t>
                <td><h4>Voornaam</h4></td>
                <td><h4>Tussenvoegsel</h4></td>
                <td><h4>Achternaam</h4></td>
                <td><h4>Email</h4></td>
                <td><h4>Valide</h4></td>
                <td><h4>Rol</h4></td>
                <td><h4>Status</h4></td>
            </t>
            <?php echo users();?>
        </table>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <form method="post" style="margin: auto" role="login">
                        <h4 class="modal-title">Registreren</h4>
                        <input type="text" name="firstname" placeholder="Voornaam" autocomplete="false" required class="form-control input-lg firstname" />

                        <input type="text" name="insertion" placeholder="Tussenvoegsel" autocomplete="false" class="form-control input-lg tussenvoegsel" />

                        <input type="text" name="lastname" placeholder="Achternaam" autocomplete="false" required class="form-control input-lg lastname" />

                        <input type="text" name="email" placeholder="Email" autocomplete="false" required class="form-control input-lg email" />

                        <input type="text" name="valid" placeholder="Valid" autocomplete="false" required class="form-control input-lg valid" />

                        <input type="text" name="rol" placeholder="Rol" autocomplete="false" required class="form-control input-lg rol" />

                        <input type="text" name="status" placeholder="status" autocomplete="false" required class="form-control input-lg status" />

                    </form>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="save_button" class="btn btn-default" value="save">
                </div>

            </div>

        </div>
    </div>

<!--    <div style="display: none" class="Close-div-1 div-1">-->
<!--        <p> Close - TBC</p>-->
<!--        <button id="Hide-1"    class=" Hide-1">hide</button>-->
<!--    </div>-->






