<?php
/**
 * Created by PhpStorm.
 * User: Niels
 * Date: 19-9-2016
 * Time: 10:40
 */

class userManager {
        public static function login() {

        $conn = database::connect();

        //if submit from login form get pressed
        if(isset($_POST['login'])) {

            //turn form value's in variable
            $email = $_POST['email'];
            $password = sha1($_POST['password']);

            //select row where email and password match
            $userInfo = $conn->prepare("SELECT * FROM medewerker WHERE email=? AND wachtwoord=?");
            $userInfo->bindParam(1, $email);
            $userInfo->bindParam(2, $password);
            $userInfo->execute();
            //fetch results
            $user = $userInfo->fetch(PDO::FETCH_ASSOC);

            //check if results are filled
            if(isset($user) AND !empty($user)) {
                //if results are correct set SESSIONS
                $_SESSION['idMedewerker']   = $user['idMedewerker'];
                $_SESSION['voornaam']       = $user['voornaam'];
                $_SESSION['lastname']       = $user['tussenvoegsel'] . ' ' . $user['achternaam'];
                $_SESSION['geboortedatum']  = $user['geboortedatum'];
                $_SESSION['email']          = $user['email'];
                $_SESSION['validated']      = $user['validated'];
                $_SESSION['rol']            = $user['rol'];
                $_SESSION['state']          = $user['state'];

                header('Location: ../urenregistratie/index.php');

                return true;

            } else {
                //if fetch is empty then return a message
                return false;
            }

        }

        return NULL;
    }
    
        
    // Returns all email from table `medewerker`
    public static function getAllEmails()
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
    public static function getEmailFromID($userID)
    {
        $email = "";
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT email FROM medewerker WHERE idMedewerker = ?");
        $stmt->bindParam(1, $userID);
        $stmt->execute();
        $email = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $email;
    }
}