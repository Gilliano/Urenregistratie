<?php session_start() ?>
<?php if(isset($_SESSION['idMedewerker'])) {header('Location: ../urenregistratie');}?>
<!DOCTYPE html>
<html>
<head>
    <?php
        //make sure everything we need in here
        require_once '../main/php/head.php';
        require_once 'php/login.php';
        //Function for the login screen
        $error = '';
        $errorR = '';
        if(isset($_POST['email'],$_POST['password'],$_POST['login'])){
            $email = !empty($_POST['email']) ? $_POST['email'] : '';
            $password = !empty($_POST['password']) ? $_POST['password'] : '';
            login($email,$password);
            if(login($email,$password) == false){
                $error = errorMessage("Username and password do not match.");
            }
        }
        
        //function to register
        
        //Function for this page
        if(isset($_POST['register'])){
            register();
        }
    ?>
    <link href="css/login.css" rel="stylesheet">

    <script>function registerChecker(){
        password = document.getElementById("rpassword").value;
        repassword = document.getElementById("repassword").value;

        if(password != repassword){
            alert('uw wachtwoord komt niet overeen');
            return false;
        }
        else if(password.length < 3 || repassword.length < 3){
            alert('uw wachtwoord moet minimaal 3 tekens bevatten');
            return false;
        }
        else if(password == repassword){
        return true;
        }
    }

    </script>
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

                    <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password"/>
                    <!-- If something is wrong after you submit, show message -->
                    <?php echo $error; ?>

                    <input type="submit" name="login" value="Sign In" class="btn btn-lg btn-primary btn-block">

                    <div>
                        <a href="#" data-toggle="modal" data-target="#createAccount">Create account</a> or <a href="vergeten">reset password</a>
                    </div>
                </form>
            </section>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

<!-- This is a pop-up. When pressed on create account this screen will been show -->
<div class="container">
    <!-- Modal -->
    <div class="modal fade logOut" id="createAccount" role="dialog">
        <div class="modal-dialog createAccount">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <img class="registerLogo" src="../main/img/logo.png" alt="" />
                </div>

                    <form method="post" role="login" onsubmit="return registerChecker()">
                        <h4 class="modal-title">Registreren</h4>
                        <input type="text" name="voornaam" placeholder="Voornaam" autocomplete="false" class="form-control input-lg" />

                        <input type="text" name="tussenvoegsel" placeholder="Tussenvoegsel" autocomplete="false" class="form-control input-lg" />

                        <input type="text" name="achternaam" placeholder="Achternaam" autocomplete="false" required class="form-control input-lg" />

                        <div class="row">
                            <div class="col-sm-6 startmail">
                                <input type="text" name="remail" placeholder="Email" autocomplete="false" required class="form-control input-lg" />
                            </div>
                            <div class="col-sm-6 endmail">
                                <p>@branchonline.nl</p>
                            </div>
                        </div>

                        <input type="password" required name="rpassword" class="form-control input-lg" autocomplete="off" id="rpassword" placeholder="Wachtwoord"/>
                        <input type="password" required name="repassword" class="form-control input-lg" autocomplete="off" id="repassword" placeholder="Herhaal wachtwoord"/>

                        <input type="submit" name="register" value="Registreer" class="btn btn-lg btn-primary btn-block">

                    </form>

            </div>

        </div>
    </div>

</div> <!-- end model -->

<?php require_once("../main/php/footer.php"); ?>
</body>
</html>