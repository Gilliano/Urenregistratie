<?php session_start();
require_once '../main/php/head.php';

userManager::alIngelogd();

//zorgt ervoor dat de waardes opgeslagen worden op de regisratie pagina 
$voornaam = isset($_POST['voornaam']) ? $_POST['voornaam'] : '';
$tussenvoegsel = isset($_POST['tussenvoegsel']) ? $_POST['tussenvoegsel'] : '';  
$achternaam = isset($_POST['achternaam']) ? $_POST['achternaam'] : '';
$remail = isset($_POST['remail']) ? $_POST['remail'] : '';  

//waarde voor checks

//$email = 'm.belhaj_zakelijk@hotmail.com';

$email = $remail."@branchonline.nl";

if(isset($_POST['registreren'])){
  if(userManager::emailBestaatAl($email) === true){
    $error = 'de ingevoerde email adress bestaat al';
  }
  else if($_POST['rpassword'] != $_POST['repassword']){
    $error = 'uw wachtwoorden komen niet overeen';
  }
  else if(strlen($_POST['rpassword']) < 3 || strlen($_POST['repassword']) < 3){
    $error = 'uw wachtwoord moet minimaal 3 tekens bevatten';
  }
  else if($_POST['rpassword'] == $_POST['repassword']){
    userManager::registreren($_POST['voornaam'],$_POST['tussenvoegsel'],$_POST['achternaam'],$email,$_POST['rpassword']);
    $voornaam = "";
    $tussenvoegsel = "";
    $achternaam = "";
    $remail = "";
    $message = userManager::Message('uw account is succesvol aangemaakt. We hebben een email naar toe gestuurd om uw account te bevestigen','success');
    userManager::verzendVerificatieMail($email);
  }

  if(!empty($error)){
    $message = userManager::Message($error,'danger');
  }
}

   ?>
<!DOCTYPE html>
<html>
   <head>
      <link href="css/login.css" rel="stylesheet">
   </head>
   <body>
      <div class="container">
         <div class="row" id="pwd-container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
               <section class="login-form">
                  <form method="post" role="login">
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
                     <?php echo isset($message) ? $message : ""; ?>
                     <button type="submit" name="registreren" class="btn btn-lg btn-primary btn-block">Registreer</button>
                     <div>
                        <p>klik <a href="../login">hier</a> om in te loggen.</p>
                     </div>
                  </form>
               </section>
            </div>
            <div class="col-md-4"></div>
         </div>
      </div>
      <?php require_once("../main/php/footer.php"); ?>
   </body>
</html>