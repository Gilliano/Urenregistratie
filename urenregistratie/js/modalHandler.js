// initialize the bootstrapswitch
$("[name='mode']").bootstrapSwitch();

var array = [];
var newHTML;
//if any input is changed then shows it directly on the webpage behind the modal.
function inputchanged() {
    newHTML = $.map(array, function (array) {
        return (array);
    });
    $(".modalHeader").html(newHTML.join(" "));
    $(".begintijd").val(array[2]);
    $(".eindtijd").val(array[4]);
}

//check if any input is changed.
$("#medewerker").on("change paste keyup", function() {
    // fill the array
    array[0] = $("#medewerker option:selected").text();
    inputchanged();
});
$("#project").on("change paste keyup", function() {
    // fill the array
    array[1] = $("#project option:selected").text();
    inputchanged();
});
$("#begintijd").on("change paste keyup", function() {
    // fill the array
    array[2] = $(this).val();
    inputchanged();
});
$("#eindtijd").on("change paste keyup", function() {
    // fill the array
    array[3] = "-";
    array[4] = $(this).val();
    inputchanged();
});


//what to do if the bootstrapswitch changed
$('input[name="mode"]').on('switchChange.bootstrapSwitch', function(event, state) {
    if(state === true){
        // switch is on
        $('#modalFormulier').modal('toggle');
        $('#mainFormulier').hide();

        $("#modalContent").html('<div class="panel panel-default modalPanel">' +
            '<div class="panel-heading modalHeader" data-toggle="collapse" href="#collapse1"></div>' +
            '<div  class="panel-body collapse" id="collapse1">' +
            '<form method="post" action="" id="urenformulier" name="urenformulier" enctype="multipart/form-data" oninput="(urentotaal.value=parseFloat(eindtijd.value)-parseFloat(begintijd.value))(ureninnovatief.value=parseFloat(urentotaal.value)-parseFloat(urenregulier.value))">' +
            '<table>' +
                // ' <tr>' +
                //     '<td class="description">Project</td>' +
                //     '<td class="field">' +
                //         '<select class="selectpicker" name="project" id="project" data-width="" data-live-search="true" title="Kies een project...">' +
                //             '<option value="1">test</option>' +
                //         '</select>' +
                //     '</td>' +
                // '</tr>' +
            '<tr>' +
                '<td class="description">Begintijd</td>' +
                '<td class="field"><input type="time" name="begintijd" class="form-control begintijd" required/></td>' +
            '</tr>' +
            '<tr>' +
                '<td class="description">Eindtijd</td>' +
                '<td class="field"><input type="time" name="eindtijd" class="form-control eindtijd" required/></td>' +
            '</tr>');

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
