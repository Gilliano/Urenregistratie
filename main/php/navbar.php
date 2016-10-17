<?php
//this is for the logout function, I dont know where to put it....
if(isset($_POST['logout'])) {
    userManager::logout();
}

function adminTab() {
    if(isset($_SESSION['rol'])) {
        $tab = "<li><a href='../management?page=dashboard'>Management</a></li>";
        return $tab;
    }
    return NULL;
}
?>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand afnd toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../urenregistratie"><img src='../main/img/logo.png'></a>
                <span class="navbar-brand" id="gebruiker">| <?= userManager::getNameFromID($_SESSION['idMedewerker']); ?></span>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!--<ul class="nav navbar-nav">
                  <li><a href="dashboard.php">Dashboard</a></li>
                </ul>-->
                <ul class="nav navbar-nav navbar-left">

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php echo adminTab() ?>
                    <li><a href="../urenregistratie">Urenregistratie</a></li>
                    <li><a href="../overzicht">Overzicht</a></li>
                    <li><div id="logout" data-toggle="modal" data-target="#logOut">Uitloggen</div></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>


<!-- This is a pop-up. When pressed on logout this screen will been show -->
<div class="container">
    <!-- Modal -->
    <div class="modal fade logOut" id="logOut" role="dialog">
        <div class="modal-dialog logOut">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Uitloggen</h4>
                </div>
                <div class="modal-body">
                    <p>Weet u zeker dat u wilt uitloggen</p>
                </div>
                <div class="modal-footer logout-footer">
                    <form method="post">
                        <button type="submit" name="logout" class="btn btn-danger">Ja</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal">Nee</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
