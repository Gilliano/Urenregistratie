<?php
class database {
    function connect() {
        $servername = "149.210.153.186";
        $username = "adsd4_teamnegg";
        $password = "th3BRPvf4";
        $dbname = "adsd4_negg";

        try{
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo"succes";

            return $conn;
        }
        catch(PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();

            return NULL;
        }
    }
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