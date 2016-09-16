<?php
/**
* Begin datum: 30-01-2015
* Laatst bewerkt: 03-02-2015
*
* Navigatie balk
*
* 
 * Bewerk log *
* 03-02-2015 aangepast door Erwin Wernars
* 02-02-2015 aangepast door Erwin Wernars
*/
/*if(empty($_SESSION['Gebruiker'])){
    header("location:index.php");
}*/
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
                <a class="navbar-brand" id="gebruiker" href="../urenregistratie">| Henk van den Broek<?php //print_r(ucfirst($_SESSION['Gebruiker'][1])) ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!--<ul class="nav navbar-nav">
                  <li><a href="dashboard.php">Dashboard</a></li>
                </ul>-->
                <ul class="nav navbar-nav navbar-left">

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="../urenregistratie">Urenregistratie</a></li>
                    <li><a href="../overzicht">Overzicht</a></li>
                    <li><a href="../uitloggen" id="logout">Uitloggen</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
