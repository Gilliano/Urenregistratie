// initialize the bootstrapswitch
$("[name='mode']").bootstrapSwitch();

var array = [];
var headerData = [];
var medewerker = [];
var tijd = [];

//check if any input is changed.
$("#teamMedewerker").on("change paste keyup", function() {
    // fill the array

    array[0] = $("#teamMedewerker option:selected").text();
    setValuesOnWeb();
});
$("#teamProject").on("change paste keyup", function() {
    // fill the array
    array[1] = $("#teamProject option:selected").text();
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
$("#teamUrenregulier").on("change paste keyup", function() {
    array[5] = $(this).val();
    array[6] = $("#teamUreninnovatief").val();

    setValuesOnWeb();
});
$("#teamOmschrijving").on("change paste keyup", function() {
    array[7] = $(this).val();
    setValuesOnWeb();
});

//if any input is changed then shows it directly on the webpage behind the modal.
function setValuesOnWeb() {
    setDivForEachMedewerker();
    $(".project").val(array[1]);
    $(".begintijd").val(array[2]);
    $(".eindtijd").val(array[3]);
    $(".urentotaal").val(array[4]);
    $(".urenregulier").val(array[5]);
    $(".ureninnovatief").val(array[6]);
    $(".omschrijving").val(array[7]);
}

function timeSplit() {
    tijd = urenAfronden($(".begintijd").val());
    $(".begintijd").val(tijd);
    tijd = urenAfronden($(".eindtijd").val());
    $(".eindtijd").val(tijd);
    var totaal = urenBerekenen($(".begintijd").val(), $(".eindtijd").val());
    $(".urentotaal").vall(totaal);
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

        newHTML.push(
            '<div class="panel panel-default modalPanel">' +
                '<div class="panel-heading modalHeader" data-toggle="collapse" href="#collapse' + i + '">' + headerData + '</div>' +
                '<div  class="panel-body collapse" id="collapse' + i + '">' +
                    '<form method="post" class="urenformulier" action="" id="urenformulier' + i + '" name="urenformulier' + i + '" enctype="multipart/form-data">' +
                        '<table>' +
                            '<tr>' +
                                    '<td class="description">Medewerker</td>' +
                                    '<td class="field"><input type="text" name="medewerker" class="form-control medewerker" value="' + medewerker[i] + '" readonly required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Project</td>' +
                                '<td class="field"><input type="text" name="project" class="form-control project" readonly required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Begintijd</td>' +
                                '<td class="field"><input type="time" name="begintijd" onblur="//timeSplit();" class="form-control begintijd" step="1800" required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Eindtijd</td>' +
                                '<td class="field"><input type="time" name="eindtijd" onblur="//timeSplit();" class="form-control eindtijd" step="1800" required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Totaal aantal uren gewerkt</td>' +
                                '<td class="field"><output readonly type="number" name="urentotaal" class="form-control urentotaal"/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Reguliere uren</td>' +
                                '<td class="veld"><input type="number" name="urenregulier" class="form-control urenregulier" required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Innovatieve uren</td>' +
                                '<td class="field"><input type="number" name="ureninnovatief" class="form-control ureninnovatief" readonly/></td>' +
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

        $("#modalContent").html(newHTML.join("") + "<input style='margin-bottom: 15px;' type='submit' name='teamurenopslaan' onclick='submitForms();' class='btn btn-success' value='Alles opslaan'>");
    });
}
//submit all forms
function submitForms(){
    $('#teamMedewerker :selected').each(function(i){
        var employee = $("form#urenformulier" + i).serializeArray();
        $.ajax({
            type: "POST",
            data: employee,
            url: "test.php",
            success: function(data)
            {
                console.log(data);
            }
        });
    });

    // var arrayOfEmployees = $('#teamMedewerker :selected').map(function(i){
    //     return [$("form#urenformulier" + i).serializeArray()];
    // }).get();
    //
    // arrayOfEmployees.forEach(function(employee){
    //
    //     $.ajax({
    //         type: "POST",
    //         data: employee,
    //         url: "test.php",
    //         success: function(data)
    //         {
    //             console.log(data);
    //         }
    //     });
    //
    //     // employee.forEach(function(field){
    //     //     //console.log(field.name + " : " + field.value);
    //     // });
    // });
}

//what to do if the bootstrapswitch changed
$('input[name="mode"]').on('switchChange.bootstrapSwitch', function(event, state) {
    if(state === true){
        // switch is on
        $('#modalFormulier').modal('toggle');
        $('#mainFormulier').hide();
    }else{
        // switch is off
        //$("#mainFormulier").show();
        //$(".modalPanel").hide();
    }
});

// Switch the bootstrapswitch back to normal
$('#modalFormulier').on('hide.bs.modal', function () {
    $("[name='mode']").bootstrapSwitch('toggleState');
});

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
        if(tijd[0] < 10) {
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
    totaal = totaal.toString();

    if(totaal < 0) {
        return "Begintijd is groter dan eindtijd";
    }
    else if(totaal === 0) {
        return "U kunt niet 0 uren hebben";
    }
    else {
        return totaal;
    }
}