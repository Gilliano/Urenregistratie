<?php
require_once '../main/php/head.php';
userManager::alIngelogd();

$id = isset($_GET['id']) ? $_GET['id'] : "";
$email = isset($_GET['email']) ? $_GET['email'] : "";
if(userManager::tokenBestaatAl($id) && userManager::emailBestaatAl($email)){

}
else{
	header('Location: ../login');
}


if(isset($_POST['herstellen'])){
	$wachtwoord = $_POST['wachtwoord'];
	if($_POST['wachtwoord'] != $_POST['herwachtwoord']){
	    $error = 'uw wachtwoorden komen niet overeen';
	}
	else if(strlen($_POST['wachtwoord']) < 3 || strlen($_POST['herwachtwoord']) < 3){
	    $error = 'uw wachtwoord moet minimaal 3 tekens bevatten';
	}
	else if($_POST['wachtwoord'] == $_POST['herwachtwoord']){
		$succes = 'u heeft uw wachtwoord sucessvol veranderd u word nu naar de login pagina gestuurd';
		userManager::wachtwoordHerstellen($email,$wachtwoord);
		userManager::tokenVerwijderen($email);
      userManager::verzendMail($email);
		$message = "<div class=\"alert alert-success\" role=\"alert\">{$succes}</div>";
		header('Location: ./succes.php?succes=1');
	}
	if(!empty($error)){
	    $error = userManager::errorMessage($error);
	}
}



?>
<!DOCTYPE html>
<html>
   <head>
      <link href="css/herstellen.css" rel="stylesheet">
   </head>
   <body>
      <div class="container">
         <div class="row" id="pwd-container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
               <section class="login-form">
                  <form method="post" role="login">
                     <img class="loginLogo" src="../main/img/logo.png" alt="" />
                     <input type="text" class="form-control input-lg" value="<?php echo isset($email) ? $email : ""; ?>" disabled>
                     <input type="password" name="wachtwoord" required class="form-control input-lg" placeholder="nieuwe wachtwoord" required/>
                     <input type="password" name="herwachtwoord" class="form-control input-lg" id="herwachtwoord" placeholder="herhaal nieuwe wachtwoord" required/>
                     <?php echo isset($error) ? $error : ""; echo isset($message) ? $message : ""; ?>
                     <input type="submit" name="herstellen" value="wachtwoord Herstellen" class="btn btn-lg btn-primary btn-block">
                  </form>
               </section>
            </div>
            <div class="col-md-4"></div>
         </div>
      </div>
      <?php require_once("../main/php/footer.php"); ?>
   </body>
</html>