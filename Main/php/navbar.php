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
        
        <a class="navbar-brand" href="urenregistratie.php"><img src='Main/img/logo.png' style='height: 45px; margin-top: -13px;'></a>
        <a class="navbar-brand" href="urenregistratie.php">| Erwin Wernars<?php //print_r(ucfirst($_SESSION['Gebruiker'][1])) ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <!--<ul class="nav navbar-nav">
        <li><a href="dashboard.php">Dashboard</a></li>
      </ul>-->
        <ul class="nav navbar-nav navbar-left">
            <li><a href="uitloggen.php">Urenregistratie</a></li>
            <li><a href="uitloggen.php">Overzicht</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a class="navbar-brand" href="urenregistratie.php"><img src='Main/img/exit.png' style='height: 45px; margin-right: -15px; margin-top: -13px;'></a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>