
function aantalUren(begintijd, eindtijd){

    //split de waardes in een array met 2 gegevens 10:33  is    b[0] = 10 en b[1] = 33
    var b = splitter(begintijd);
    var e = splitter(eindtijd);


    // Uren afronden specifiek op halve en hele uren
<<<<<<< HEAD
    
=======
    if(b[1] < 15) {

        b[1] = "00";
        var b = b.toString();
        b = b.replace(",", ":");
        document.getElementById("begintijd").value = b;
    }
    else if(b[1] >= 15 && b[1] <= 44) {

        b[1] = "30";
        var b = b.toString();
        b = b.replace(",", ":");
        document.getElementById("begintijd").value = b;
    }
    else {
        if(b[0] < 9) {
            b[0] = parseInt(b[0]);
            b[0] += 1;
            b[0] = "0" + b[0];
            b[0] = b[0].toString();
            b[1] = "00";
            var b = b.toString();
            b = b.replace(",", ":");
            document.getElementById("begintijd").value = b;
        }
        else {
            b[0] = parseInt(b[0]);
            b[0] += 1;
            b[0] = b[0].toString();
            b[1] = "00";
            var b = b.toString();
            b = b.replace(",", ":");
            document.getElementById("begintijd").value = b;
        }
    }

    // Hetzelfde als bovenstaande if statements maar dan voor eindtijd
    if(e[1] < 15) {
        e[1] = "00";
        var e = e.toString();
        e = e.replace(",", ":");
        document.getElementById("eindtijd").value = e;
    }
    else if(e[1] >= 15 && e[1] <= 44) {
        e[1] = "30";
        var e = e.toString();
        e = e.replace(",", ":");
        document.getElementById("eindtijd").value = e;
    }
    else {
        if(e[0] < 9) {
            e[0] = parseInt(e[0]);
            e[0] += 1;
            e[0] = "0" + e[0];
            e[0] = e[0].toString();
            e[1] = "00";
            var e = e.toString();
            e = e.replace(",", ":");
            document.getElementById("eindtijd").value = e;
        }
        else {
            e[0] = parseInt(e[0]);
            e[0] += 1;
            e[0] = b[0].toString();
            e[1] = "00";
            var e = e.toString();
            e = e.replace(",", ":");
            document.getElementById("eindtijd").value = e;
        }
    }
>>>>>>> 886ee1765cd0a36bd9343302b3a535b8cb9edb2e

        var Btijd = b.split(':');
        var Etijd = e.split(':');

        //de tijden worden veranderd naar seconden
        var begintijd_seconden = Btijd[0] * 3600  +  Btijd[1] * 60;
        var eindtijd_seconden = Etijd[0] * 3600  +  Etijd[1] * 60;

<<<<<<< HEAD
    //hier maken we een decimaal van de eindcijfer in dit geval 1 getal achter de komma
    var uren = parseFloat(eind.toFixed(1));

    if(uren < 0 ) {
        return "begintijd is groter dan eindtijd!";
    }
    else if(uren == 0){
        return "U mag geen 0 uren hebben";
    }
    else{
        return uren;
    }
=======
        //eindtijd min begintijd
        var totale_seconden = eindtijd_seconden - begintijd_seconden;
        // de totale seconden worden omgezet in uren
        var eind = (totale_seconden / 3600);

        //hier maken we een decimaal van de eindcijfer in dit geval 1 getal achter de komma
        var uren = parseFloat(eind.toFixed(1));
        var uren = uren.toString();
>>>>>>> 886ee1765cd0a36bd9343302b3a535b8cb9edb2e

        if(uren < 0 ) {
            return "begintijd is groter dan eindtijd!";
        }
        else if(uren == 0){
            return "U mag geen 0 uren hebben";
        }
        else{
            uren = uren.replace(".",",");
            return uren;
        }
}

function splitter(tijd){
    
    var tijd = tijd.split(':');
    return tijd;
}
function tijdAfronden(tijd){

    var tijd = splitter(tijd);

    if(tijd[1] >= 15 && tijd[1] <= 44) {
        tijd[1] = "30";
        var tijd = (tijd[0] + ':' + tijd[1]);
        return tijd;
    }
    else if(tijd[1] >=45 && tijd[1] <=59){
        
        if(parseInt(tijd[0]) < 10){
            tijd[0] = ('0' + (parseInt(tijd[0]) + 1).toString()); 
            console.log(tijd[0]);
        }
        else{
            tijd[0] = (parseInt(tijd[0]) + 1).toString();
            console.log(tijd[0]); 
        } 
        tijd[1] = "00";
        var tijd = (tijd[0] + ':' + tijd[1]);
        return tijd;
    }
    else {
        tijd[1] = "00";
        var tijd = (tijd[0] + ':' + tijd[1]);
        return tijd;
    }

}

//zet de waarde in realtime in de div id="return" haalt de waarde begintijd en eindtijd op van de input velden
function realTimeWaarde() {
<<<<<<< HEAD
    var begintijd = document.getElementById("begintijd").value;
    var eindtijd = document.getElementById("eindtijd").value;   

    if(begintijd != ""){
        document.getElementById("begintijd").value = tijdAfronden(begintijd);
    }
    if(eindtijd != ""){
        document.getElementById("eindtijd").value = tijdAfronden(eindtijd);
    }

    if(begintijd != "" && eindtijd != ""){
    document.getElementById("urentotaal").innerHTML = aantalUren(tijdAfronden(begintijd), tijdAfronden(eindtijd));
    }
}

function ureninnovatief(urentotaal, urenregulier){
        
        uren = urentotaal - urenregulier;

   
    if(!isNumeric(urentotaal)){
        return 'de gegevens kloppen niet';

    }
    else if(uren < 0){
        return 'u heeft teveel uren ingevuld bij reguliere uren';
    }
    else if(uren >= 0){
    return uren;
    }
}
function submitChecker() {
    begintijd = document.getElementById("begintijd").value;
    eindtijd = document.getElementById("eindtijd").value;   
    urenregulier = document.getElementById("urenregulier").value;
    urentotaal = document.getElementById("urentotaal").value;

    if(errorController() == false){
        alert('U heeft verkeerde velden die aangepast moeten worden');
        return false;

    }
    else{
        return true;
    }
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function errorController(){
    // date > vandaag
    // eindtijd > begintijd
    // reguliere uren < totaal
    begintijd = document.getElementById("begintijd").value;
    eindtijd = document.getElementById("eindtijd").value;   
    urenregulier = document.getElementById("urenregulier").value;
    urentotaal = document.getElementById("urentotaal").value;

    //controleer innovatieve uren
    if(!isNumeric(ureninnovatief(urentotaal,urenregulier))){
        return false;
    }
    else if(!isNumeric(aantalUren(begintijd, eindtijd))){
        return false;
    }
    else{
        return true;
    }
    
    //


}

function urenRekenen(){

    urenregulier = document.getElementById("urenregulier").value;
    urentotaal = document.getElementById("urentotaal").value;

    if(urenregulier != "" && urentotaal != ""){
    document.getElementById("ureninnovatief").innerHTML = ureninnovatief(urentotaal,urenregulier);
    }
}

function buttonChecker(bool){
    
    document.getElementById("urenopslaan").disabled = bool; 
}
=======
        var begintijd = document.getElementById("begintijd");
        var eindtijd = document.getElementById("eindtijd");
        var totaal = aantalUren(begintijd.value, eindtijd.value);
        document.getElementById("urentotaal").innerHTML = totaal;
}

function urenInnovatief() {
    var totaaluren = document.getElementById("urentotaal").value;
    totaaluren = totaaluren.replace(",",".");
    totaaluren = parseFloat(totaaluren);
    var urenregulier = document.getElementById("urenregulier").value;
    var ureninnovatief = totaaluren - urenregulier;
    ureninnovatief = parseFloat(ureninnovatief.toFixed(1));
    innovatief = document.getElementById("ureninnovatief").value = ureninnovatief;
    ureninnovatief = ureninnovatief.replace(".", ",");
}
>>>>>>> 886ee1765cd0a36bd9343302b3a535b8cb9edb2e
