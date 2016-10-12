// initialize the bootstrapswitch
$("[name='mode']").bootstrapSwitch();

var array = [];
var headerData = [];
var medewerker = [];
//check if any input is changed.
$("#teamMedewerker").on("change paste keyup", function() {
    // fill the array

    array[0] = $("#teamMedewerker option:selected").text();
    setDivForEachMedewerker();
});
$("#teamProject").on("change paste keyup", function() {
    // fill the array
    array[1] = $("#teamProject option:selected").text();
    setValuesOnWeb();
});
$("#teamBegintijd").on("change paste keyup", function() {
    // fill the array
    array[2] = $(this).val();

    setValuesOnWeb();
});
$("#teamEindtijd").on("change paste keyup", function() {
    // fill the array
    array[3] = "-";
    array[4] = $(this).val();
    array[5] = $("#teamUrentotaal").val();

    setValuesOnWeb();
});
$("#teamUrenregulier").on("change paste keyup", function() {
    array[6] = $(this).val();
    array[7] = $("#teamUreninnovatief").val();

    setValuesOnWeb();
});
$("#teamOmschrijving").on("change paste keyup", function() {
    array[8] = $(this).val();

    setValuesOnWeb();
});

//if any input is changed then shows it directly on the webpage behind the modal.
function setValuesOnWeb() {

    //$(".modalHeader").html(headerData.join(" "));
    $(".project").val(array[1]);
    $(".begintijd").val(array[2]);
    $(".eindtijd").val(array[4]);
    $(".urentotaal").val(array[5]);
    $(".urenregulier").val(array[6]);
    $(".ureninnovatief").val(array[7]);
    $(".omschrijving").val(array[8]);
}

function setDivForEachMedewerker(){
    var newHTML = [];


    $('#teamMedewerker :selected').each(function(i, selected){
        headerData = array.slice(1,6);
        medewerker[i] = $(selected).text();

        newHTML.push(
            '<div class="panel panel-default modalPanel">' +
                '<div class="panel-heading modalHeader" data-toggle="collapse" href="#collapse' + i + '">' + medewerker[i] + " " + headerData + '</div>' +
                '<div  class="panel-body collapse" id="collapse' + i + '">' +
                    '<form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data")">' +
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
                                '<td class="field"><input type="time" name="begintijd" class="form-control begintijd" required/></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="description">Eindtijd</td>' +
                                '<td class="field"><input type="time" name="eindtijd" class="form-control eindtijd" required/></td>' +
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

        $("#modalContent").html(newHTML.join(""));
        setValuesOnWeb();
    });
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