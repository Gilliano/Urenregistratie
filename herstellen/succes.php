<?php 
$get = isset($_GET['succes']) ? $_GET['succes'] : "";
if($get != 1){
header("location: ../login");
}
?>

u heeft uw wachtwoord succesvol verandert.<br>
als u niet doorgestuurt word klik <a href="../login">hier</a> om verder te gaan

