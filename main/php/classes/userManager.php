<?php
/**
 * Created by PhpStorm.
 * User: Niels
 * Date: 19-9-2016
 * Time: 10:40
 */

class userManager
{
    
    function __construct()
    {
        print "In BaseClass constructor\n";
    }
    
    
    
    //update user in the management part
    //$params comes from the ajax.php
    public static function userChange($params)
    {
        $conn = database::connect();
        try {
            $updateUser = " UPDATE medewerker 
                                SET 
                                voornaam=?, 
                                tussenvoegsels=?, 
                                achternaam=?, 
                                email=?, 
                                validated=?, 
                                rol=?,
                                state=?
                                WHERE idMedewerker=?";
            $stmt       = $conn->prepare($updateUser);
            $stmt->bindParam(1, $params['firstname']);
            $stmt->bindParam(2, $params['insertion']);
            $stmt->bindParam(3, $params['lastname']);
            $stmt->bindParam(4, $params['email']);
            $stmt->bindParam(5, $params['valide']);
            $stmt->bindParam(6, $params['rol']);
            $stmt->bindParam(7, $params['state']);
            $stmt->bindParam(8, $params['id']);
            $stmt->execute();
            
            return self::getAllUsers();
        }
        catch (PDOException $e) {
            return $e->getMessage();
        }
        
    }
    
    //// Check if SESSION['idMedewerkers'] isset and not empty, if so it will bring you back to login page
    //// This funtion is used in the main.php
    //@TODO: fix this function
    public static function areYouLoggedIn()
    {
        // $url = $_SERVER['REQUEST_URI'];
        // if(!strpos($url, 'login' || !strpos($url, 'register'))) {
        //     if(!isset($_SESSION['idMedewerker']) || empty($_SESSION['idMedewerker'])) {
        //         header("location: ../login/");
        //     }
        // }
    }
    
    
    public static function getNameFromID($idMedewerker)
    {
        $conn     = database::connect();
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
    public static function getAllUsers()
    {
        $records = [];
        $conn = database::connect();
        $stmt = $conn->prepare("SELECT * FROM medewerker");
        $stmt->execute();
        $records = $stmt->fetchAll();
        
        return $records;
    }
    
    // Returns email from table `medewerker`
    // for a specific ID
    // params: idMedewerker
    public static function getEmailFromID($userID)
    {
        $email = "";
        $conn  = database::connect();
        $stmt  = $conn->prepare("SELECT email FROM medewerker WHERE idMedewerker = ?");
        $stmt->bindParam(1, $userID);
        $stmt->execute();
        $email = $stmt->fetch();
        
        return $email;
    }
    
    public static function getIDFromEmail($userEmail)
    {
        $userID = -1;
        $conn   = database::connect();
        $stmt   = $conn->prepare("SELECT idMedewerker FROM medewerker WHERE email = ?");
        $stmt->bindParam(1, $userEmail, PDO::PARAM_STR);
        $stmt->execute();
        $userID = $stmt->fetch();
        
        return $userID;
    }
    
    public static function logout()
    {
        session_unset();
        session_destroy();
        
        header('Location: ../login');
    }
    
    
    //maakt van de gestuurde error text een div alert aan zodat je op de pagina rode error balk kan zien
    public static function errorMessage($errorMessage)
    {
        
        $error = "";
        $error .= "<div class='alert alert-danger'>";
        $error .= $errorMessage;
        $error .= "</div>";
        
        return $error;
        
    }
    public static function rolManager(){

    }


    //login heeft een email en een wachtwoord nodig om te kijken of je kan inloggen.
    public static function login($email, $password)
    {
        
        if ($email == "" || $password == "") {
            return false;
        }
        $conn  = database::connect();
        //turn form value's in variable
        $encrypted_password = sha1($password);
        
        //select row where email and password match
        $userInfo = $conn->prepare("SELECT * FROM medewerker WHERE email=? AND wachtwoord=?");
        $userInfo->bindParam(1, $email);
        $userInfo->bindParam(2, $encrypted_password);
        $userInfo->execute();
        //fetch results
        $user = $userInfo->fetch(PDO::FETCH_ASSOC);
        //check if results are filled
        if (isset($user) AND !empty($user)) {
            //if results are correct set SESSIONS
            $_SESSION['idMedewerker'] = $user['idMedewerker'];
            $_SESSION['rol'] = $user['rol'];

            header('Location: ../urenregistratie/index.php');
        } 
        else {
            return false;
        }
    }
    
    //checkt of de email al bestaat als je registreert.
    public static function emailBestaatAl($email)
    {
        $conn     = database::connect();
        $userInfo = $conn->prepare("SELECT * FROM medewerker WHERE email=?");
        $userInfo->bindParam(1, $email);
        $userInfo->execute();
        //fetch results
        $user = $userInfo->fetch(PDO::FETCH_ASSOC);
        
        if (!empty($user)) {
            return true;
        } else {
            return false;
        }
        
    }
    //registreer een account aan en logt je gelijk in
    
    public static function registerCheck()
    {
        if (isset($_POST['registreren'])) {
            register();
        }
    }
    
    public static function registreren($voornaam, $tussenvoegsel, $achternaam, $email, $password)
    {
        
        $conn = database::connect();
        
        $encrypted_password = sha1($password);
        $email              = $email . '@branchonline.nl';
        
        if (userManager::emailBestaatAl($email)) {
            return false;
        }
        
        $adduser = "INSERT INTO medewerker (voornaam, tussenvoegsels, achternaam, email, wachtwoord) VALUES (?,?,?,?,?)";
        $stmt    = $conn->prepare($adduser);
        $stmt->bindParam(1, $voornaam);
        $stmt->bindParam(2, $tussenvoegsel);
        $stmt->bindParam(3, $achternaam);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $encrypted_password);
        $stmt->execute();
    }
    
    public static function alIngelogd()
    {
        if (isset($_SESSION['idMedewerker'])) {
            header('Location: ../urenregistratie');
        }
    }
}