<?php 
$get = isset($_GET['succes']) ? $_GET['succes'] : "";
if($get != 1){
header("location: ../login");
}
?>
<script>window.alert('u heeft uw wachtwoord succesvol verandert. Klik op ok om verder te gaan.');
window.location.replace("../login");
</script>
u heeft uw wachtwoord succesvol verandert.<br>
als u niet doorgestuurt word klik <a href="../login">hier</a> om verder te gaan

