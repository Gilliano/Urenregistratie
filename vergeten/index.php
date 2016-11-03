<?php 
session_start();
require_once '../main/php/head.php';

if(isset($_POST['herstellen'])){
	$message = '<div class="alert alert-success">
   als dit email adres gebonden is aan een account in ons systeem, dan ontvangt u een email.
   </div>';

	if(userManager::emailBestaatAl($_POST['remail'])){
		userManager::verzendMail($_POST['remail']);
	}
	else{

	}
}
   
   
   ?>
<!DOCTYPE html>
<html>
   <head>
      <link href="css/vergeten.css" rel="stylesheet">
   </head>
   <body>
      <div class="container">
         <div class="row" id="pwd-container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
               <section class="login-form">
                  <form method="post" role="login">
                  <img class="loginLogo" src="../main/img/logo.png" alt="" />
                     <h4 class="modal-title">wachtwoord vergeten</h4>
                     <input type="text" name="remail" id="remail" placeholder="Email" autocomplete="false" required class="form-control input-lg" />
                     <div>
                        <?php echo isset($message) ? $message : ""; ?>
                        <button type="submit" name="herstellen" class="btn btn-lg btn-primary btn-block">wachtwoord herstellen</button>
                     </div>
                     <div>
                        <p>klik <a href="../login">hier</a> om in te loggen.</p>
                     </div>
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

