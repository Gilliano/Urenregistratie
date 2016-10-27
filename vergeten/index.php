<?php session_start();
   require_once '../main/php/head.php';
         userManager::alIngelogd();


         if(isset($_POST['herstellen'])){
         	$message = 'u heeft een email ontvangen van ons waardoor u uw wachtwoord kunt veranderen. Bekijk eventueel uw spam. Mocht de email niet zijn ontvangen probeer het opnieuw.';
         	if(userManager::emailBestaatAl($_POST['remail'])){
         		userManager::verzendMail($_POST['remail']);
         		echo $message;
         	}
         	else{
         		echo $message;
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
                     <h4 class="modal-title">wachtwoord vergeten</h4>
                     <input type="text" name="remail" id="remail" placeholder="Email" autocomplete="false" required class="form-control input-lg" />
                     <div>
                        <button type="submit" name="herstellen" class="btn btn-lg btn-primary btn-block">wachtwoord herstellen</button>
                     </div>
                     <div>
                        <p>klik <a href="../login">hier</a> om in te loggen.</p>
                     </div>
            </div>
            <?php echo isset($error) ? $error : ""; ?>
            </form>
            </section>
         </div>
         <div class="col-md-4"></div>
      </div>
      </div>
      <?php require_once("../main/php/footer.php"); ?>
   </body>
</html>