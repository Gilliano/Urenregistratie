function urenAfronden(tijd) {
    var tijd = tijd.split(':');

    if(tijd[1] < 15) {

        tijd[1] = "00";
        var tijd = tijd.toString();
        tijd = tijd.replace(",", ":");
        return tijd;
    }
    else if(tijd[1] >= 15 && tijd[1] <= 44) {

        tijd[1] = "30";
        var tijd = tijd.toString();
        tijd = tijd.replace(",", ":");
        return tijd;
    }
    else if(tijd[0] > 22 && tijd[1] > 44) {
        tijd[1] = "30";
        var tijd = tijd.toString();
        tijd = tijd.replace(",", ":");
        return tijd;
    }
    else {
        if(tijd[0] < 9) {
            tijd[0] = parseInt(tijd[0]);
            tijd[0] += 1;
            tijd[0] = "0" + tijd[0];
            tijd[0] = tijd[0].toString();
            tijd[1] = "00";
            var tijd = tijd.toString();
            tijd = tijd.replace(",", ":");
            return tijd;
        }
        else {
            tijd[0] = parseInt(tijd[0]);
            tijd[0] += 1;
            tijd[0] = tijd[0].toString();
            tijd[1] = "00";
            var tijd = tijd.toString();
            tijd = tijd.replace(",", ":");
            return tijd;
        }
    }
}

function time() {
    if(document.getElementById("begintijd").value != "" && document.getElementById("eindtijd") != "") {
        var begin = document.getElementById("begintijd").value;
        var begintijd = urenAfronden(begin);
        document.getElementById("begintijd").value = begintijd;
        var eind = document.getElementById("eindtijd").value;
        var eindtijd = urenAfronden(eind);
        document.getElementById("eindtijd").value = eindtijd;
    }
    else if(document.getElementById("teamBegintijd").value != "" && document.getElementById("teamEindtijd").value != "") {
        var begin = document.getElementById("teamBegintijd").value;
        var begintijd = urenAfronden(begin);
        document.getElementById("teamBegintijd").value = begintijd;
        var eind = document.getElementById("teamEindtijd").value;
        var eindtijd = urenAfronden(eind);
        document.getElementById("teamEindtijd").value = eindtijd;
    }
}

function aantalUren(begintijd, eindtijd){

    //split de waardes in een array met 2 gegevens 10:33  is    b[0] = 10 en b[1] = 33
        var Btijd = begintijd.split(':');
        var Etijd = eindtijd.split(':');

        //de tijden worden veranderd naar seconden
        var begintijd_seconden = Btijd[0] * 3600  +  Btijd[1] * 60;
        var eindtijd_seconden = Etijd[0] * 3600  +  Etijd[1] * 60;

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
    if(document.getElementById("begintijd").value != "" && document.getElementById("eindtijd").value != "") {
        var begintijd = document.getElementById("begintijd").value;
        var eindtijd = document.getElementById("eindtijd").value;
        var totaal = aantalUren(begintijd, eindtijd);
        document.getElementById("urentotaal").innerHTML = totaal;
    }
    else if(document.getElementById("teamBegintijd").value != "" && document.getElementById("teamEindtijd").value != "") {
        var begintijd = document.getElementById("teamBegintijd").value;
        var eindtijd = document.getElementById("teamEindtijd").value;
        var totaal = aantalUren(begintijd, eindtijd);
        document.getElementById("teamUrentotaal").innerHTML = totaal;
    }
}

function urenInnovatief() {
    var totaaluren = document.getElementById("urentotaal").value;
    totaaluren = totaaluren.replace(",",".");
    totaaluren = parseFloat(totaaluren);
    var urenregulier = document.getElementById("urenregulier").value;
    var regulier = Math.round(urenregulier * 2).toFixed(1);
    urenregulier = regulier / 2;
    var ureninnovatief = totaaluren - urenregulier;
    document.getElementById("urenregulier").value = urenregulier;
    ureninnovatief = parseFloat(ureninnovatief.toFixed(1));
    document.getElementById("ureninnovatief").value = ureninnovatief;
    ureninnovatief = ureninnovatief.replace(".", ",");
}

function teamUrenInnovatief() {
    var totaaluren = document.getElementById("teamUrentotaal").value;
    totaaluren = totaaluren.replace(",",".");
    totaaluren = parseFloat(totaaluren);
    var urenregulier = document.getElementById("teamUrenregulier").value;
    var regulier = Math.round(urenregulier * 2).toFixed(1);
    urenregulier = regulier / 2;
    var ureninnovatief = totaaluren - urenregulier;
    document.getElementById("teamUrenregulier").value = urenregulier;
    ureninnovatief = parseFloat(ureninnovatief.toFixed(1));
    document.getElementById("teamUreninnovatief").value = ureninnovatief;
    ureninnovatief = ureninnovatief.replace(".",",");
}