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
                                rol=?,
                                state=?
                                WHERE idMedewerker=?";
            $stmt       = $conn->prepare($updateUser);
            $stmt->bindParam(1, $params['firstname']);
            $stmt->bindParam(2, $params['insertion']);
            $stmt->bindParam(3, $params['lastname']);
            $stmt->bindParam(4, $params['rol']);
            $stmt->bindParam(5, $params['state']);
            $stmt->bindParam(6, $params['id']);
            $stmt->execute();
            
            return self::getAllUsers();
        }
        catch (PDOException $e) {
            return $e->getMessage();
        }
        
    }
    
    //// Check if SESSION['idMedewerkers'] isset and not empty, if so it will bring you back to login page
    //// This funtion is used in the main.php
    public static function areYouLoggedIn($medewerker){
        if (strpos($_SERVER['REQUEST_URI'], 'login') === false && strpos($_SERVER['REQUEST_URI'], 'registreren') === false && strpos($_SERVER['REQUEST_URI'], 'vergeten') === false && strpos($_SERVER['REQUEST_URI'], 'herstellen') === false && strpos($_SERVER['REQUEST_URI'], 'bevestigen') === false) {
            if (!isset($_SESSION['idMedewerker']) && empty($_SESSION['idMedewerker'] && $_SERVER['REQUEST_URI'])) {
                header("location: ../login");
            }
        }
        if(!empty($medewerker) && strpos($_SERVER['REQUEST_URI'], 'login')){
            header("location: ../urenregistratie");
        }
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
        $stmt = $conn->prepare("SELECT * FROM medewerker ORDER BY voornaam");
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
    public static function Message($message,$type)
    {   
        $message = "<div class='alert alert-{$type}'>{$message}</div>";    
        return $message;
        
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
        if(userManager::checkDisabled($email)){
            return 'disabled';
        }
        else if (isset($user) AND !empty($user)) {
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
    //checkt of de email al bestaat als je registreert.
    public static function tokenBestaatAl($hash)
    {
        $conn     = database::connect();
        $userInfo = $conn->prepare("SELECT * FROM medewerker WHERE token=?");
        $userInfo->bindParam(1, $hash);
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
    
    public static function registreren($voornaam, $tussenvoegsel, $achternaam, $email, $password, $pending)
    {
        
        $conn = database::connect();
        
        $encrypted_password = sha1($password);  
        
        if (userManager::emailBestaatAl($email)) {
            return false;
        }
        
        $adduser = "INSERT INTO medewerker (voornaam, tussenvoegsels, achternaam, email, wachtwoord,validated) VALUES (?,?,?,?,?,?)";
        $stmt    = $conn->prepare($adduser);
        $stmt->bindParam(1, $voornaam);
        $stmt->bindParam(2, $tussenvoegsel);
        $stmt->bindParam(3, $achternaam);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $encrypted_password);
        $stmt->bindParam(6, $pending);
        $stmt->execute();
    }
    
    public static function wachtwoordHerstellen($email,$wachtwoord){
        $encrypted_password = sha1($wachtwoord);
        if(userManager::emailBestaatAl($email) && strlen($encrypted_password) == 40) {
            $conn = database::connect();
            $herstellen = "UPDATE medewerker SET wachtwoord=:wachtwoord where email=:email";
            $stmt    = $conn->prepare($herstellen);
            $stmt->bindParam("wachtwoord", $encrypted_password);
            $stmt->bindParam("email", $email);
            $stmt->execute();
        }
    }

    public static function tokenControleren($email,$hash){
        $conn = database::connect();
        $controleertoken = "SELECT email,token FROM medewerker WHERE email=:email AND token=:hash ";
        $stmt    = $conn->prepare($controleertoken);
        $stmt->bindParam("hash", $hash);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $controleer = $stmt->fetch();

        if(!empty($controleer)){
            return true;
        }
        else{
            return false;
        }

    }

    public static function tokenAanmaken($email,$hash){

        if(userManager::emailBestaatAl($email) && strlen($hash) == 40) {
            $conn = database::connect();
            $addhash = "UPDATE medewerker SET token=:hash where email=:email";
            $stmt    = $conn->prepare($addhash);
            $stmt->bindParam("hash", $hash);
            $stmt->bindParam("email", $email);
            $stmt->execute();
        }
    }
    public static function tokenVerwijderen($email){

        if(userManager::emailBestaatAl($email)) {
            $legeString = "";
            $conn = database::connect();
            $removeHash = "UPDATE medewerker SET token=:hash where email=:email";
            $stmt    = $conn->prepare($removeHash);
            $stmt->bindParam("hash", $legeString);
            $stmt->bindParam("email", $email);
            $stmt->execute();
        }
    }

    public static function getNaam($email){
        $conn = database::connect();
        $getnaam = "SELECT voornaam,tussenvoegsels,achternaam FROM medewerker WHERE email=:email";
        $stmt    = $conn->prepare($getnaam);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $get = $stmt->fetch();

        if(!empty($get)){
            if(!$get['tussenvoegsels']){
                return "{$get['voornaam']} {$get['achternaam']}";
            }
            else if($get['tussenvoegsels']){
                return "{$get['voornaam']} {$get['tussenvoegsels']} {$get['achternaam']}";
            }
        }
        else{
            return false;
        }
    }

    public static function tokenHash($email){
        return sha1(sha1(rand()).$email);
    }

    public static function checkDisabled($email){
        $conn     = database::connect();
        $userInfo = $conn->prepare("SELECT validated FROM medewerker WHERE email=? and validated='pending'");
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

    public static function accountBevestigen($email){
            $conn = database::connect();
            $herstellen = "UPDATE medewerker SET token='', validated='validated' where email=:email";
            $stmt    = $conn->prepare($herstellen);
            $stmt->bindParam("email", $email);
            $stmt->execute();
    }

    function url(){
      return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],'/'
      );
    }
    public static function verzendMail($email){
        require('phpmailer/PHPMailerAutoload.php');

        $hash = userManager::tokenHash($email);
        $naam = userManager::getNaam($email);
        userManager::tokenAanmaken($email,$hash);

        $url = userManager::url()."herstellen?id={$hash}&email={$email}";
        $herstelLink = '<a href="'.$url.'">hier</a>';

        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "smtpserver088@gmail.com";
        $mail->Password = "Mailserver88";
        $mail->SetFrom("smtpserver088@gmail.com");
        $mail->Subject = "Uw wachtwoord herstellen Branchonline";
        $mail->Body = "<font face=\"verdana\">Geachte {$naam}, <br/><br/> U heeft opgevraagd om uw wachtwoord te herstellen. Klik {$herstelLink} om uw wachtwoord te herstellen. <br/><br/>Met vriendelijke groet,<br/><br/> Branchonline team <br/><img src='http://imgur.com/OGCpbK4.jpg'></font>";

        $mail->AddAddress($email);

        //dit moet erbij nders werkt het niet
         if(!$mail->Send()) {
         } else {
         }

    }
    public static function verzendVerificatieMail($email){
        require('phpmailer/PHPMailerAutoload.php');

        $hash = userManager::tokenHash($email);
        $naam = userManager::getNaam($email);
        userManager::tokenAanmaken($email,$hash);

        $url = userManager::url()."bevestigen?id={$hash}&email={$email}";
        $herstelLink = '<a href="'.$url.'">hier</a>';

        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "smtpserver088@gmail.com";
        $mail->Password = "Mailserver88";
        $mail->SetFrom("smtpserver088@gmail.com");
        $mail->Subject = "Uw account bevestigen Branchonline";
        $mail->Body = "<font face=\"verdana\">Geachte {$naam}, <br/><br/> Klik {$herstelLink} om uw account te bevestigen. <br/><br/>Met vriendelijke groet,<br/><br/> Branchonline team <br/><img src='http://imgur.com/OGCpbK4.jpg'></font>";

        $mail->AddAddress($email);

        //dit moet erbij nders werkt het niet
         if(!$mail->Send()) {
         } else {
         }

    }
}