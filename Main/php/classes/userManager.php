<?php
/**
 * Created by PhpStorm.
 * User: Niels
 * Date: 19-9-2016
 * Time: 10:40
 */

class userManager {
        function login() {

        $conn = database::connect();

        if(isset($_POST['login'])) {
            $userInfo = $conn->prepare("SELECT * FROM medewerker");
            $userInfo->execute();
            while($user = $userInfo->fetch(PDO::FETCH_ASSOC)) {
                echo $user['voornaam'];
            }
        }
    }
    
        
    // Returns all email from table `medewerker`
    function getAllEmails()
    {
        $records = [];
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT email FROM medewerker");
        $stmt->execute();
        while($record = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($records, $record);
        }
        
        return $records;
    }
    
    // Returns email from table `medewerker`
    // for a specific ID
    // params: idMedewerker
    function getEmailFromID($userID)
    {
        $email = "";
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT email FROM medewerker WHERE idMedewerker = $userID");
        $stmt->execute();
        while($record = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $email = $record;
        }
        
        return $email;
    }
}
