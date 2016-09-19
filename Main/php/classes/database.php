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

            return $conn;
        }
        catch(PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();

            return NULL;
        }
    }
}

?>