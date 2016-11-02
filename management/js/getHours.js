$(function() {
    $.getScript('../main/js/ajax.js', function () {
        tableHoursBetweenData();
    });
});

$('#daterange_picker_hours').on('apply.daterangepicker', function(ev, picker) {
    $.getScript('../main/js/ajax.js', function () {
        tableHoursBetweenData();
    });
});

function tableHoursBetweenData() {
    //get data from the datepicker
    var datepickerData = $('#daterange_picker_hours').data('daterangepicker');
    //get the start date
    var start = datepickerData.startDate.format('YYYY-MM-DD');
    //get the end date
    var end = datepickerData.endDate.format('YYYY-MM-DD');
    console.log(start);
    console.log(end);


    //Get the new data
    var ajaxobj = new AjaxObj('getAllHoursSimple', {
        'start': start,
        'end': end,
    }, false, "json");

    if(ajaxobj.result == 0) {
        //push the DOM to the table :)

        var htmlList = "";
        htmlList += "<h4>Nothing found</h4>";
        // htmlList += "<tr>";
        // htmlList += "<td><h4>Nothing found</h4></td>";
        // htmlList += "</tr>";

        $("#allHours").html(htmlList);
    } else {
        //Now full table with new data
        //Lets build the table head first
        var htmlList = "";
        htmlList += "<tr>";
        htmlList += "<td><h4>Gebruiker</h4></td>";
        htmlList += "<td><h4>Project</h4></td>";
        htmlList += "<td><h4>Uren gewerkt</h4></td>";
        htmlList += "<td><h4>Begin tijd</h4></td>";
        htmlList += "<td><h4>Eind tijd</h4></td>";
        htmlList += "<td><h4>omschrijving</h4></td>";
        htmlList += "<td><h4>Verwijder</h4></td>";
        htmlList += "</tr>";

        //Now lets add the new items :)
        ajaxobj.result.forEach(function (item) {
            htmlList += "<tr>";
            htmlList += "<td style='display: none;'>" + item.idUur + "</td>";
            htmlList += "<td>" + item.idMedewerker + "</td>";
            htmlList += "<td>" + item.idProject + "</td>";
            htmlList += "<td>" + item.urengewerkt + "</td>";
            htmlList += "<td>" + item.begintijd + "</td>";
            htmlList += "<td>" + item.eindtijd + "</td>";
            htmlList += "<td>" + item.omschrijving + "</td>";
            htmlList += "<td><button type='submit' name='uur_verwijderen' value='" + item.idMedewerker + "' class='btn btn-default' data-toggle='modal' data-target='#myHour'>Verwijder</button> </td>";
            htmlList += "</tr>";
        });

        //push the DOM to the table :)
        $("#allHours").html(htmlList);

        //redefine the button to do hise work
        $("button[name='uur_verwijderen']").on("click", function () {
            get_hours_model($(this));
        });
    }
}