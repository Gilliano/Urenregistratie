<?php

$email = isset($_GET['email']) ? $_GET['email'] : false;
$token = isset($_GET['id']) ? $_GET['id'] : false;

if(!$email && !$token){
	header('Location: ../login');
}
require_once '../main/php/head.php';

if(userManager::tokenBestaatAl($token) && userManager::emailBestaatAl($email) && userManager::checkDisabled($email)){

	userManager::accountBevestigen($email);
?>
<script>window.alert('u heeft uw account succesvol bevestigd. klik op oke om verder te gaan.');
window.location.replace("../login");
</script>
<?php


}
else{

	header('Location: ../login');

}

?>

