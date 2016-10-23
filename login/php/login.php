<?php
/**
 * Created by PhpStorm.
 * User: Niels
 * Date: 20-9-2016
 * Time: 12:22
 */

function errorMessage($errorMessage) {

        $error = "";
        $error .= "<div class='alert alert-danger'>";
        $error .= $errorMessage;
        $error .="</div>";

        return $error;

        //"Username and password do not match."

}

function login($email, $password) {

    if($email == "" || $password == ""){
        return false;
    }
    $conn = database::connect();
        echo ' 3';
        //turn form value's in variable
        $password = sha1($password);

        //select row where email and password match
        $userInfo = $conn->prepare("SELECT * FROM medewerker WHERE email=? AND wachtwoord=?");
        $userInfo->bindParam(1, $email);
        $userInfo->bindParam(2, $password);
        $userInfo->execute();
        //fetch results
        $user = $userInfo->fetch(PDO::FETCH_ASSOC);
        //check if results are filled
        if(isset($user) AND !empty($user)) {
            echo ' 4';
            //if results are correct set SESSIONS
            $_SESSION['idMedewerker'] = $user['idMedewerker'];
            header('Location: ../urenregistratie/index.php');
        }
        else{
            echo ' 5';
            return false;
        }
}
function whii(){
    return 'lool';
}

function bestaatAl($email){
        $conn = database::connect();
        $userInfo = $conn->prepare("SELECT * FROM medewerker WHERE email=?");
        $userInfo->bindParam(1, $email);
        $userInfo->execute();
        //fetch results
        $user = $userInfo->fetch(PDO::FETCH_ASSOC);

        if(!empty($user)){
            return true;
        }
        else{
            return false;
        }

}
function register() {
    $conn = database::connect();


        $password = sha1($_POST['rpassword']);
        $repassword = sha1($_POST['repassword']);
        $_POST['email'] = $_POST['remail'] . '@branchonline.nl';

        if(bestaatAl($_POST['email'])){
            return false;
        }
        else if($password == $repassword) {

            $adduser = "INSERT INTO medewerker (voornaam, tussenvoegsels, achternaam, email, wachtwoord) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($adduser);
            $stmt->bindParam(1, $_POST['voornaam']);
            $stmt->bindParam(2, $_POST['tussenvoegsel']);
            $stmt->bindParam(3, $_POST['achternaam']);
            $stmt->bindParam(4, $_POST['email']);
            $stmt->bindParam(5, $password);   
            $stmt->execute();
            login($_POST['email'], $_POST['rpassword']);
    }
}


