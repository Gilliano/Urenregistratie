// initialize the bootstrapswitch
$("[name='mode']").bootstrapSwitch();

//variables
var array = [];
var headerData = [];
var medewerker = [];
var valMedewerker = [];
var bevestigen = 0;

//what to do if the bootstrapswitch changed
$('input[name="mode"]').on('switchChange.bootstrapSwitch', function(event, state) {
    if(state === true){
        // switch is on
        $('#modalFormulier').modal('toggle');
        $('#mainFormulier').hide();

        setValuesOnWeb();
    }else{
        // switch is off
        $("#mainFormulier").show();
        $(".modalPanel").hide();
        $("#teamOpslaan").hide();
    }
});

// Check if button is clicked
$('#bevestigen').click(function () {
    if(!$("#teamMedewerker").val() || !$("#teamProject").val() || !$("#teamDatum").val() || !$("#teamBegintijd").val() || !$("#teamEindtijd").val() || !$("#teamUrenregulier").val() || !$("#teamUreninnovatief").val() || !$("#teamUrentotaal").val() || !$("#teamOmschrijving").val()){
        $("#errorMessage").html("<div class='alert alert-danger'>" +
        "U bent iets vergeten in te vullen! </div>");
    }else{
        $("#errorMessage").html("");
        bevestigen = 1;
    }
});
// Switch the bootstrapswitch back to normal
$('#modalFormulier').on('hide.bs.modal', function () {
    if(bevestigen == 1){
        bevestigen = 0;
    }else{
        $("[name='mode']").bootstrapSwitch('toggleState');
    }
});



//check if any input is changed.
$("#teamMedewerker").on("change paste keyup", function() {
    setValuesOnWeb();
});
$("#teamProject").on("change paste keyup", function() {
    // fill the array
    array[1] = $("#teamProject option:selected").text();
    array[9] = $("#teamProject option:selected").val();
    setValuesOnWeb();
});
$("#teamDatum").on("change paste keyup focus blur", function() {
    // fill the array
    array[8] = $(this).val();

    setValuesOnWeb();
});
$("#teamBegintijd").on("change paste keyup focus blur", function() {
    // fill the array
    array[2] = $(this).val();

    setValuesOnWeb();
});
$("#teamEindtijd").on("change paste keyup focus blur", function() {
    // fill the array
    array[3] = $(this).val();
    array[4] = $("#teamUrentotaal").val();

    setValuesOnWeb();
});
$("#teamUrenregulier").on("change paste keyup focus blur", function() {
    array[5] = $(this).val();
    array[6] = $("#teamUreninnovatief").val();

    setValuesOnWeb();
});
$("#teamOmschrijving").on("change paste keyup focus blur", function() {
    array[7] = $(this).val();
    setValuesOnWeb();
});

//if any input is changed then shows it directly on the webpage behind the modal.
function setValuesOnWeb() {
    if (array[8] == null){
        array[8] = $('#teamDatum').val();
    }
    console.log(array[2]);
    setDivForEachMedewerker();
    $(".project").val(array[1]);
    $(".datum").val(array[8]);
    $(".begintijd").val(array[2]);
    $(".eindtijd").val(array[3]);
    $(".urentotaal").val(array[4]);
    $(".urenregulier").val(array[5]);
    $(".ureninnovatief").val(array[6]);
    $(".omschrijving").val(array[7]);
    $(".idProject").val(array[9]);

    $("#teamOpslaan").show();
}

function setDivForEachMedewerker(){
    var newHTML = [];


    $('#teamMedewerker :selected').each(function(i, selected){
        if(array.length < 5){
            headerData = $(selected).text();
        }else{
            headerData = $(selected).text() + " | " + array[1] + ", " + array[2] + " - " + array[3] + " | " + array[4] + " uren gewerkt";
        }

        medewerker[i] = $(selected).text();
        valMedewerker[i] = $(selected).val();

        newHTML.push(
            '<div class="panel panel-default modalPanel">' +
                '<div class="panel-heading modalHeader" data-toggle="collapse" href="#collapse' + i + '">' + headerData + '</div>' +
                '<div  class="panel-body collapse" id="collapse' + i + '">' +
                    '<form method="post" class="urenformulier" action="" id="urenformulier' + i + '" name="urenformulier' + i + '" enctype="multipart/form-data">' +
                        '<table>' +
                            '<tr>' +
                                    '<td class="description">Medewerker</td>' +
                                    '<input type="hidden" name="idMedewerker" class="form-control medewerker" value="' + valMedewerker[i] + '" readonly required/>' +
                                    '<td class="field"><input type="text" name="medewerker" class="form-control medewerker" value="' + medewerker[i] + '" readonly required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Project</td>' +
                                '<input type="hidden" name="idProject" class="form-control idProject" value="" readonly required/>' +
                                '<td class="field"><input type="text" name="project" class="form-control project" readonly required/></td>' +
                                '</tr>' +
                            '<tr>' +
                                '<td class="description">Datum</td>' +
                                '<td class="field"><input type="date" name="datum" class="form-control datum" required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Begintijd</td>' +
                                '<td class="field"><input type="time" id="begintijd' + i + '" name="begintijd" onblur="timeSplit()" class="form-control begintijd" step="1800" required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Eindtijd</td>' +
                                '<td class="field"><input type="time" id="eindtijd' + i + '" name="eindtijd" onblur="timeSplit()" class="form-control eindtijd" step="1800" required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Totaal aantal uren gewerkt</td>' +
                                '<td class="field"><output readonly type="number" id="urentotaal' + i + '" name="urentotaal" class="form-control urentotaal"/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Reguliere uren</td>' +
                                '<td class="veld"><input type="number" id="urenregulier' + i + '" name="urenregulier" onchange="timeSplit()" class="form-control urenregulier" step="0.5" min="0" required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Innovatieve uren</td>' +
                                '<td class="field"><input type="number" id="ureninnovatief' + i + '" name="ureninnovatief" class="form-control ureninnovatief" step="any" min="0" readonly/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Omschrijving van de uren</td>' +
                                '<td class="field"><textarea name="omschrijving" id="omschrijving" class="form-control omschrijving" required/></textarea></td>' +
                            '</tr>' +
                        '</table>' +
                    '</form>' +
                '</div>' +
            '</div>'
        );

        $("#modalContent").html(newHTML.join("") + "<input style='margin-bottom: 15px;' type='submit' id='teamOpslaan' name='teamurenopslaan' onclick='submitForms();' class='btn btn-success' value='Alles opslaan'>");
    });
}
//submit all forms

function submitForms(){
    $('#teamMedewerker :selected').each(function(i){
        var employee = $("form#urenformulier" + i).serializeArray();
        $.ajax({
            type: "POST",
            data: employee,
            url: "ajax.php",
            success: function(data)
            {
                if(~data.indexOf("true")){
                    $("#errorMessage").html("<div class='alert alert-success'>" +
                        "Het is gelukt, alle uren zijn opgeslagen!</div>");
                }else{
                    $("#errorMessage").html("<div class='alert alert-danger'>" +
                        "Er is iets mis gegaan bij het opslaan van de gegevens.</div>");
                }
            }
        });
    });
}

function timeSplit() {
    $('#teamMedewerker :selected').each(function(i) {
        var Btijd = "#begintijd" + i;
        var Etijd = "#eindtijd" + i;

        if($(Btijd).val() != "" && $(Etijd).val() != "") {
            var begintijd = urenAfronden($(Btijd).val());
            $(Btijd).val(begintijd);
            var eindtijd = urenAfronden($(Etijd).val());
            $(Etijd).val(eindtijd);

            var totaal = urenBerekenen($(Btijd).val(), $(Etijd).val());
            totaal = totaal.toString();
            totaal = totaal.replace(".", ",");
            var uren = "#urentotaal" + i;
            $(uren).val(totaal);
            var regulier = "#urenregulier" + i;
            var ureninnovatief = innovatieveUren(totaal, $(regulier).val(), regulier);
            var innovatief = "#ureninnovatief" + i;
            $(innovatief).val(ureninnovatief);
        }
    });
}

function urenAfronden(tijd) {
    var tijd = tijd.split(":");

    if(tijd[1] < 15) {
        tijd[1] = "00";
        tijd = tijd.toString();
        tijd = tijd.replace(",",":");
        return tijd;
    }
    else if(tijd[1] > 14 && tijd[1] < 45) {
        tijd[1] = "30";
        tijd = tijd.toString();
        tijd = tijd.replace(",",":");
        return tijd;
    }
    else {
        if(tijd[0] < 9) {
            tijd[0] = parseInt(tijd[0]);
            tijd[0] += 1;
            tijd[0] = "0" + tijd[0];
            tijd[0] = tijd[0].toString();
            tijd[1] = "00";
            tijd = tijd.toString();
            tijd = tijd.replace(",", ":");
            return tijd;
        }
        else {
            tijd[0] = parseInt(tijd[0]);
            tijd[0] += 1;
            tijd[0] = tijd[0].toString();
            tijd[1] = "00";
            tijd = tijd.toString();
            tijd = tijd.replace(",", ":");
            return tijd;
        }
    }
}

function urenBerekenen(begintijd, eindtijd) {
    begintijd = begintijd.split(":");
    eindtijd = eindtijd.split(":");

    var begin_seconden = begintijd[0] * 3600 + begintijd[1] * 60;
    var eind_seconden = eindtijd[0] * 3600 + eindtijd[1] * 60;

    var berekening = eind_seconden - begin_seconden;
    var uren = berekening / 3600;

    var totaal = parseFloat(uren.toFixed(1));

    if(totaal < 0) {
        var fout = "Begintijd is groter dan eindtijd";
        return fout;
    }
    else if(totaal == 0) {
        var fout = "U kunt niet 0 uren hebben";
        return fout;
    }
    else {
        return totaal;
    }
}

function innovatieveUren(urentotaal, urenregulier, idRegulier) {
        urentotaal = urentotaal.replace(",", ".");
        urentotaal = parseFloat(urentotaal);
        var regulier = Math.round(urenregulier * 2).toFixed(1);
        urenregulier = regulier / 2;
        $(idRegulier).val(urenregulier);
        var ureninnovatief = urentotaal - urenregulier;
        ureninnovatief = parseFloat(ureninnovatief.toFixed(1));
        return ureninnovatief;
        ureninnovatief = ureninnovatief.replace(".", ",");
}