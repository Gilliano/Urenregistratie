
function aantalUren(begintijd, eindtijd){

    //split de waardes in een array met 2 gegevens 10:33  is    b[0] = 10 en b[1] = 33
    var b = splitter(begintijd);
    var e = splitter(eindtijd);


    //de tijden worden veranderd naar seconden
    var begintijd_seconden = b[0] * 3600  +  b[1] * 60;
    var eindtijd_seconden = (+e[0]) * 3600  +  (+e[1]) * 60;

    // Uren afronden specifiek op halve en hele uren
    


    //eindtijd min begintijd
    var totale_seconden = eindtijd_seconden - begintijd_seconden;
    // de totale seconden worden omgezet in uren
    var eind = (totale_seconden / 3600);

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
