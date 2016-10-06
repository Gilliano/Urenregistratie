// initialize the bootstrapswitch
$("[name='mode']").bootstrapSwitch();

// Switch the bootstrapswitch back to normal
$('#modalFormulier').on('hide.bs.modal', function () {
    $("[name='mode']").bootstrapSwitch('toggleState');
})
var array = [];
var changed = 0;
var newHTML;


function inputchanged() {
    if(changed === 1) {
        newHTML = $.map(array, function (array) {
            return (array + ' - ');
        });
        $(".modalHeader").html(newHTML.join(""));
        changed == 0;
    }
}

$("#medewerker").on("change paste keyup", function() {
    // check if input is changed
    changed = 1;
    // fill the array
    array[0] = $("#medewerker option:selected").text();
    inputchanged();
});
$("#project").on("change paste keyup", function() {
    // check if input is changed
    changed = 1;
    // fill the array
    array[1] = $("#project option:selected").text();
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
            '<tr>' +
            '<td class="description">Begintijd</td>' +
            '<td class="field"><input type="time" name="begintijd" class="form-control" id="begintijd" required/></td>' +
            '</tr>' +
            '<tr>' +
            '<td class="description">Eindtijd</td>' +
            '<td class="field"><input type="time" name="eindtijd" class="form-control" id="eindtijd" required/></td>' +
            '</tr>');

    }else{
        // switch is off
        //$("#mainFormulier").show();
        //$(".modalPanel").hide();
    }
});
