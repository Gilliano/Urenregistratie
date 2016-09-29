<?php
/**
 * Created by PhpStorm.
 * User: Niels
 * Date: 19-9-2016
 * Time: 10:40
 */

class userManager {

    function __construct() {
        print "In BaseClass constructor\n";
    }

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
                $_SESSION['lastname']       = $user['tussenvoegsels'] . ' ' . $user['achternaam'];
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

    public static function register() {

        $conn = database::connect();

        if(isset($_POST['register'])) {

            if($_POST['password'] == $_POST['repassword']) {
                $adduser = "INSERT INTO medewerker (voornaam, tussenvoegsels, achternaam, email, wachtwoord) VALUES (?,?,?,?,?)";
                $stmt = $conn->prepare($adduser);
                $stmt->bindParam(1, $_POST['firstname']);
                $stmt->bindParam(2, $_POST['insertion']);
                $stmt->bindParam(3, $_POST['lastname']);
                $stmt->bindParam(4, $_POST['email']);
                $stmt->bindParam(5, $_POST['password']);
                $stmt->execute();
            } else {
                header("location: ../login/index.php?error=error");
            }

        }
    }

    //// Check if SESSION['idMedewerkers'] isset and not empty, if so it will bring you back to login page
    //// This funtion is used in the main.php
    public static function areYouLoggedIn() {
        $url = $_SERVER['REQUEST_URI'];
        if(!strpos($url, 'login')) {
            if(!isset($_SESSION['idMedewerker']) || empty($_SESSION['idMedewerker'])) {
                header("location: ../login/");
            }
        }
    }


    public static function getNameFromID($idMedewerker) {
        $conn = database::connect();
        $userInfo = $conn->prepare("SELECT voornaam, tussenvoegsels, achternaam FROM medewerker WHERE idMedewerker=?");
        $userInfo->bindParam(1, $idMedewerker);
        $userInfo->execute();

        $user = $userInfo->fetch(PDO::FETCH_ASSOC);

        $userName = $user['voornaam'] . " ";
        if ($user['tussenvoegsels'] != NULL) {
            $userName .= $user['tussenvoegsels'] . " ";
        }
        $userName .= $user['achternaam'];

        echo $userName;
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

    public static function logout() {
        session_unset();
        session_destroy();

        header('Location: ../login');
    }
}