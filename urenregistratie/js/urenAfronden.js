function aantalUren(begintijd, eindtijd){

    //split de waardes in een array met 2 gegevens 10:33  is    b[0] = 10 en b[1] = 33
    var b = begintijd.split(':');
    var e = eindtijd.split(':');

    //de tijden worden veranderd naar seconden
    var begintijd_seconden = b[0] * 3600  +  b[1] * 60;
    var eindtijd_seconden = (+e[0]) * 3600  +  (+e[1]) * 60;

    // Uren afronden specifiek op halve en hele uren
    if(b[1] < 15) {
        b[0] = parseInt(b[0]);
        b[0] = b[0].toString();
        b[1] = "00";
        var b = b.toString();
        b = b.replace(",", ":");
        document.getElementById("begintijd").value = b;
    }
    else if(b[1] >= 15 && b[1] <= 44) {
        b[0] = parseInt(b[0]);
        b[0] = b[0].toString();
        b[1] = "30";
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

    // Hetzelfde als bovenstaande if statements maar dan voor eindtijd
    if(e[1] < 15) {
        e[0] = parseInt(e[0]);
        e[0] = e[0].toString();
        e[1] = "00";
        var e = e.toString();
        e = e.replace(",", ":");
        document.getElementById("eindtijd").value = e;
    }
    else if(e[1] >= 15 && e[1] <= 44) {
        e[0] = parseInt(e[0]);
        e[0] = e[0].toString();
        e[1] = "30";
        var e = e.toString();
        e = e.replace(",", ":");
        document.getElementById("eindtijd").value = e;
    }
    else {
        e[0] = parseInt(e[0]);
        e[0] += 1;
        e[0] = e[0].toString();
        e[1] = "00";
        var e = e.toString();
        e = e.replace(",", ":");

        document.getElementById("eindtijd").value = e;
    }


    //eindtijd min begintijd
    var totale_seconden = eindtijd_seconden - begintijd_seconden;
    // de totale seconden worden omgezet in uren
    var eind = (totale_seconden / 3600);

    //hier maken we een decimaal van de eindcijfer in dit geval 1 getal achter de komma
    var uren = parseFloat(eind.toFixed(1));
    var uren = uren.toString();

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

//zet de waarde in realtime in de div id="return" haalt de waarde begintijd en eindtijd op van de input velden
function realTimeWaarde() {
    var begintijd = document.getElementById("begintijd");
    var eindtijd = document.getElementById("eindtijd");
    document.getElementById("urentotaal").innerHTML = aantalUren(begintijd.value, eindtijd.value);
}