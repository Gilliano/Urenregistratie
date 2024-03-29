<?php
//zorgt ervoor dat de waardes opgeslagen worden op de regisratie pagina 
$voornaam = isset($_POST['voornaam']) ? $_POST['voornaam'] : '';
$tussenvoegsel = isset($_POST['tussenvoegsel']) ? $_POST['tussenvoegsel'] : '';  
$achternaam = isset($_POST['achternaam']) ? $_POST['achternaam'] : '';
$remail = isset($_POST['remail']) ? $_POST['remail'] : '';
    
   if(isset($_POST['registreren'])){


            if(userManager::emailBestaatAl($_POST['remail']."@branchonline.nl") === true){
                $error = 'de ingevoerde email adress bestaat al';
            }
            else if($_POST['rpassword'] != $_POST['repassword']){
                $error = 'uw wachtwoorden komen niet overeen';
            }
            else if(strlen($_POST['rpassword']) < 3 || strlen($_POST['repassword']) < 3){
                $error = 'uw wachtwoord moet minimaal 3 tekens bevatten';
            }
            else if($_POST['rpassword'] == $_POST['repassword']){
                userManager::registreren($_POST['voornaam'],$_POST['tussenvoegsel'],$_POST['achternaam'],$_POST['remail'],$_POST['rpassword']);
                $voornaam = "";
                $tussenvoegsel = "";
                $achternaam = "";
                $remail = "";
            }
            
            if(!empty($error)){
                $error = userManager::errorMessage($error);
            }
    }

   ?>
<h1 style="font-family: 'Montserrat'">Gebruikers</h1>
<td colspan="3" valign="top" class='tabbed-content-container ui-corner-all'>
<tr>
   <td>
      <button id="wijzigen" class="btn btn-secondary btn-sm wijzigen" value="1">Wijzigen</button>
      <button id="registreren" class="btn btn-secondary btn-sm registreren" value="1">Registreren</button>
      <!--            <button id= "Close-open-button-1" class="btn btn-secondary btn-sm Close-open-button-1" value =  "1">Nog iets</button>-->
   </td>
</tr>
<div class="wijzigen div-1">
   <table id="allUsersTable" class="gebruikers_wijzigen table">
      <t>
         <td>
            <h4>Voornaam</h4>
         </td>
         <td>
            <h4>Tussenvoegsel</h4>
         </td>
         <td>
            <h4>Achternaam</h4>
         </td>
         <td>
            <h4>Email</h4>
         </td>
         <td>
            <h4>Valide</h4>
         </td>
         <td>
            <h4>Rol</h4>
         </td>
         <td>
            <h4>Status</h4>
         </td>
      </t>
      <?php echo users(); ?>
   </table>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">wijzig</h4>
         </div>
         <div class="modal-body">
            <form method="post" id="gebruiker_wijzig_form" style="margin: auto" role="login">
               <h4 class="modal-title">Wijzigen</h4>
               <input type="hidden" name="id" autocomplete="false" required class="form-control input-lg id"/>
               <input type="text" name="firstname" placeholder="Voornaam" autocomplete="false" required
                  class="form-control input-lg firstname"/>
               <input type="text" name="insertion" placeholder="Tussenvoegsel" autocomplete="false"
                  class="form-control input-lg tussenvoegsel"/>
               <input type="text" name="lastname" placeholder="Achternaam" autocomplete="false" required
                  class="form-control input-lg lastname"/>
               <input type="text" name="email" placeholder="Email" autocomplete="false" required
                  class="form-control input-lg email"/>
               <input type="text" name="valid" placeholder="Valid" autocomplete="false" required
                  class="form-control input-lg valid"/>
               <input type="text" name="rol" placeholder="Rol" autocomplete="false" required
                  class="form-control input-lg rol"/>
               <input type="text" name="status" placeholder="status" autocomplete="false" required
                  class="form-control input-lg status"/>
            </form>
         </div>
         <div class="modal-footer">
            <input type="submit" id="save_button" class="btn btn-default" value="save">
         </div>
      </div>
   </div>
</div>
<div class="registreren" style="display: none">
   <form id="management_register_user" method="post" role="login">
      <h4 class="modal-title">Registreren</h4>
      <input type="text" value="<?= $voornaam; ?>" name="voornaam" placeholder="Voornaam" autocomplete="false" class="form-control input-lg" required/>
      <input type="text" value="<?= $tussenvoegsel; ?>" name="tussenvoegsel" placeholder="Tussenvoegsel" autocomplete="false" class="form-control input-lg" />
      <input type="text" value="<?= $achternaam; ?>" name="achternaam" placeholder="Achternaam" autocomplete="false" required class="form-control input-lg" />
      <div class="row">
         <div class="col-sm-6 startmail">
            <input type="text" value="<?= $remail; ?>" name="remail" id="remail" placeholder="Email" autocomplete="false" required class="form-control input-lg" />
         </div>
         <div class="col-sm-6 endmail">
            <p>@branchonline.nl</p>
         </div>
      </div>
      <input type="password" required name="rpassword" class="form-control input-lg" autocomplete="off" id="rpassword" placeholder="Wachtwoord"/>
      <input type="password" required name="repassword" class="form-control input-lg" autocomplete="off" id="repassword" placeholder="Herhaal wachtwoord"/>
      <?php echo isset($error) ? $error : ""; ?>
      <button type="submit" name="registreren" class="btn btn-lg btn-primary btn-block">Registreer</button>
</form>
</div>
<!--    <div style="display: none" class="Close-div-1 div-1">-->
<!--        <p> Close - TBC</p>-->
<!--        <button id="Hide-1"    class=" Hide-1">hide</button>-->
<!--    </div>-->