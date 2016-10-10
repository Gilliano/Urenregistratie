function aantalUren(begintijd, eindtijd){

    //split de waardes in een array met 2 gegevens 10:33  is    b[0] = 10 en b[1] = 33
    var b = begintijd.split(':');
    var e = eindtijd.split(':');

    //de tijden worden verandert naar seconden
    var begintijd_seconden = (+b[0]) * 3600  +  (+b[1]) * 60;
    var eindtijd_seconden = (+e[0]) * 3600  +  (+e[1]) * 60;

    //eindtijd min begintijd
    var totale_seconden = eindtijd_seconden - begintijd_seconden;
    // de totale seconden worden omgezet in uren
    var eind = (totale_seconden / 3600);
    //hier maken we een decimaal van de eindcijfer in dit geval 1 getal achter de komma
    var eindcijfer = parseFloat(eind.toFixed(1));

    if(eindcijfer < 0 ) {
        return "begintijd is groter dan eindtijd!";
    }
    else if(eindcijfer == 0){
        return "U mag geen 0 uren hebben";
    }
    else{
        return eindcijfer;
    }

}

//zet de waarde in realtime in de div id="return" haalt de waarde begintijd en eindtijd op van de input velden
function realTimeWaarde() {
    var begintijd = document.getElementById("begintijd");
    var eindtijd = document.getElementById("eindtijd");
    document.getElementById("urentotaal").innerHTML = aantalUren(begintijd.value, eindtijd.value);
}