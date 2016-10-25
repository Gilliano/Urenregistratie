<!DOCTYPE html>
<html>
<head>
    <?php
    //make sure everything we need in here
    require_once '../main/php/head.php';
    //make sure everything we need in here
    require_once 'php/management.php';


    ?>
    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/management.css" rel="stylesheet">
</head>

<body>
<header>
    <?php include_once '../main/php/navbar.php'; ?>
</header>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <!--            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>-->
            <br>
            <li>
                <a <a href='?page=dashboard'>Dashboard</a>
            </li>
            <li>
                <a <a href='?page=gebruikers'>Gebruikers</a>
            </li>
            <li>
                <a <a href='?page=projecten'>Projecten</a>
            </li>
            <li>
                <a <a href='?page=uren'>Uren management</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div>
                <?php include($_GET['page'] . '.php'); ?>
            </div>


            <!--            <div>-->
            <!--                <h1>Simple Sidebar</h1>-->
            <!--                <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>-->
            <!--                <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>-->
            <!--            </div>-->

        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>


<?php require_once("../main/php/footer.php"); ?>
<script src="js/switch-div.js"></script>
<script src="js/buttonHandles.js"></script>
<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

<!-- gebruikers inladen-->
<script type="text/javascript">
    $(document).ready(function () {

        $('#results').load('gebruikers_data.php')

    })
</script>
</body>
</html>