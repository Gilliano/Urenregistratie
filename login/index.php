<?php 
session_start();
require_once '../main/php/head.php';
   
if(isset($_POST['email'],$_POST['password'],$_POST['login'])){
   $email = !empty($_POST['email']) ? $_POST['email'] : '';
   $password = !empty($_POST['password']) ? $_POST['password'] : '';
   userManager::login($email,$password);
   if(userManager::login($email,$password) == false){
       $error = userManager::errorMessage("email en wachtwoord komen niet overeen.");
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
                     <img class="loginLogo" src="../main/img/logo.png" alt="" />
                     <input type="text" name="email" placeholder="Email" required class="form-control input-lg" />
                     <input type="password" name="password" class="form-control input-lg" id="password" placeholder="wachtwoord"/>
                     <?php echo isset($error) ? $error : ""; ?>
                     <input type="submit" name="login" value="log in" class="btn btn-lg btn-primary btn-block">
                     <div>
                        <a href="../registreren">maak een account</a> of <a href="../vergeten">wachtwoord vergeten?</a>
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