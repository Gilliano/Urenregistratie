<?php
    $servername = "149.210.153.186";
    $username = "adsd4_teamnegg";
    $password = "NGf0c4raM";
    $dbname = "adsd4_negg";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected succesfully";
    }
    catch(PDOException $e) {
        echo "Connection Failed: " . $e->getMessage();
    }
?>

<?php
//    $db_host = "149.210.153.186";
//    $db_username = "adsd4";
//    $db_pass = "NGf0c4raM";
//    $db_name = "adsd4_negg";
//
//    try {
//        $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_pass);
//        echo "succes";
//    }
//    catch (PDOExeption $e) {
//        echo $e->getMessage();
//    }
?>