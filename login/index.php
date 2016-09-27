<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <?php
        //make sure everything we need in here
        require_once '../main/php/head.php';
        //Function for the login screen
        userManager::login();
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
                        <a href="#">Create account</a> or <a href="#">reset password</a>
                    </div>
                </form>
            </section>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>