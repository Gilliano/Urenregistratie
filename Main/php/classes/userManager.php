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
                //if results are filled
                echo 'correct';
                echo '<br>';
                echo $user['voornaam'];
                echo '<br>';
                echo $user['tussenvoegsels'] . ' ' . $user['achternaam'];

                //$_SESSION['firstname'] = $user['voornaam'];
                //$_SESSION['lastname'] = $user['tussenvoegsel'] . ' ' . $user['achternaam'];

                return true;

            } else {
                //if fetch is empty then return a message
                return false;
            }

        }

    }
}