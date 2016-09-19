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
}
