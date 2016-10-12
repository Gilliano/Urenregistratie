<?php session_start() ?>
<?php if(isset($_SESSION['idMedewerker'])) {header('Location: /project/urenregistratie/index.php');}?>
<!DOCTYPE html>
<html>
<head>
    <?php
        //make sure everything we need in here
        require_once '../main/php/head.php';
        //Function for the login screen
        userManager::login();
        //function to register
        userManager::register();
        //Function for this page
        require_once 'php/login.php';
    ?>
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

                    <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password"/>
                    <!-- If something is wrong after you submit, show message -->
                    <?php echo errorMessage(); ?>

                    <input type="submit" name="login" value="Sign In" class="btn btn-lg btn-primary btn-block">

                    <div>
                        <a href="#" data-toggle="modal" data-target="#createAccount">Create account</a> or <a href="#">reset password</a>
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

                    <form method="post" role="login">
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

                        <input type="submit" name="register" value="Registreer" class="btn btn-lg btn-primary btn-block">

                    </form>

            </div>

        </div>
    </div>

</div> <!-- end model -->

<?php require_once("../main/php/footer.php"); ?>
</body>
</html>