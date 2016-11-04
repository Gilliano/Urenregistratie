// Global vars
var edit_modal_begintijd;
var edit_modal_eindtijd;

$(document).ready(function(){
    console.log("Initializing...");
    $("#filter_loader").show();

    $.getScript("../main/js/ajax.js", function() {
        // Get current userrole
        var ajaxObj = new AjaxObj("getSessionVariable", {'sessionVariable': "rol"}, false);
        userrole = ajaxObj.result;
        ajaxObj = new AjaxObj("getSessionVariable", {'sessionVariable': "idMedewerker"}, false);
        userid = ajaxObj.result;

        // Step 1: Initialize users list
        ajaxObj = new AjaxObj("getUsers", {}, false, "json");
        var htmlList = "";
        ajaxObj.result.forEach(function(item){
            var user_name = item.voornaam + " " + (typeof item.tussenvoegsel != 'undefined'?item.tussenvoegsel:"") + " " + item.achternaam;
            // Only allow your own name if not admin
            if(userrole === "medewerker" && item.idMedewerker == userid)
                htmlList += "<option value=" + item.email + ">" + user_name + "</option>"; // FEATURE: Set data-tokens equal to user's project names
            else if(userrole === "admin")
                htmlList += "<option value=" + item.email + ">" + user_name + "</option>"; // FEATURE: Set data-tokens equal to user's project names
        });
        $("#users_list").html(htmlList);
        $(".selectpicker").selectpicker('refresh');
        console.log("Users list complete!"); // DEBUG

        // Step 2: Initialize projects list
        // Only show the projects that the user is assigned to
        ajaxObj = new AjaxObj("getAllProjects", {}, false, "json");
        htmlList = "";
        ajaxObj.result.forEach(function(item){
            var deleted = item.verwijderd == 1 ? " (afgerond)" : "";
            htmlList += "<option value=" + item.projectnaam + ">" + item.projectnaam + deleted + "</option>";
        });
        $("#projects_list").html(htmlList);
        $(".selectpicker").selectpicker('refresh');
        console.log("Projects list complete!"); // DEBUG

        // Step 3: Initialize date range picker
        $("#daterange_picker").daterangepicker({
            showDropdowns: true,
            showWeekNumbers: true,
            opens: "left",
            locale: {
                format: "YYYY-MM-DD",
                separator: " t/m ",
                daysOfWeek: [
                    "Ma",
                    "Di",
                    "Wo",
                    "Do",
                    "Vr",
                    "Za",
                    "Zo"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maart",
                    "April",
                    "Mei",
                    "Juni",
                    "July",
                    "Augustus",
                    "September",
                    "Oktober",
                    "November",
                    "December"
                ],
                "startDate": getCurrentDate(),
                "endDate": ""
            },
        });
        console.log("Daterange picker complete!"); // DEBUG

        // Step 4: Fastselect
        $(".multipleSelect").fastselect({
            placeholder: "Kies extra filters"
        });

        // Step 5: Descriptions list
        $.contextMenu({
            selector: '.context-menu-one',
            build: function($trigger) {
                var options = {
                    callback: function (key, options) {
                        switch (key) {
                            case "validate":
                                // Get all selected items
                                // in description list
                                $("#description_list :selected").each(function(i, selected){
                                    // Add 'validated' class
                                    $(selected).addClass("validated");
                                    cache_new_records[$(selected).val()].goedgekeurd = "1";
                                });
                                break;
                            case "invalidate":
                                // Get all selected items
                                // in description list
                                $("#description_list :selected").each(function(i, selected){
                                    // Remove class 'validated'
                                    $(selected).removeClass("validated");
                                    cache_new_records[$(selected).val()].goedgekeurd = "0";
                                });
                                break;
                            case "log": // DEBUG: Logs current item info in console
                                console.log("\n---BEGIN---");
                                $("#description_list :selected").each(function(i, selected){
                                    console.log(cache_new_records[$(selected).val()]);
                                    console.log(cache_old_records[$(selected).val()]);
                                });
                                console.log("---END---");
                                break;
                            case "view":
                                viewEditModal($(this));
                                break;
                        }
                    },
                    items: {}
                };

                // Check what items are selected
                var validFound = false;
                var invalidFound = false;
                $("#description_list :selected").each(function(i, selected){
                    if(validFound && invalidFound)
                        return;
                    if($(selected).hasClass("validated"))
                        validFound = true;
                    else
                        invalidFound = true;
                });

                if(userrole !== "medewerker")
                {
                    // If multiple items are selected
                    // and they consist of 'validated' and 'not validated' items
                    // then the option you get is "Goedkeuren"
                    if ($("#description_list :selected").length > 1 && (validFound || invalidFound)) {
                        if (validFound && !invalidFound)
                            options.items.invalidate = {name: "Afkeuren"};
                        else if(!validFound && invalidFound)
                            options.items.validate = {name: "Goedkeuren"};
                        else if(validFound && invalidFound)
                            options.items.validate = {name: "Goedkeuren"};
                    }
                    else{
                        if ($("#description_list :selected").hasClass("validated"))
                            options.items.invalidate = {name: "Afkeuren"};
                        else
                            options.items.validate = {name: "Goedkeuren"};
                    }

                    options.items.log = {name: "Log"}; // DEBUG: Logs current item info in console
                }

                options.items.view = {name: "Bekijken", disabled: $("#description_list :selected").length>1 ? true : false};
                options.items.sep1 = "---------";
                options.items.cancel = {name: "Cancel"};

                return options;
            }
        });
        console.log("Context menu complete!"); // DEBUG

        $("#filter_loader").parent().remove();
        $("#filter_row").fadeIn();
        console.log("Initialized!");
    });
});

function viewEditModal(selectedItem){
    // Show modal with record info
    var index = $("#description_list :selected").val();
    var record = cache_new_records[index];
    //var readonly = userrole === "medewerker" ? "readonly" : "";
    var disabled = userrole === "medewerker" ? "disabled" : ""; // For checkboxes
    var type = userrole === "medewerker" ? "text" : "number"; // For urengewerkt
    var modalHtml = "";
    modalHtml += "<input id=edit_modal_itemID type='hidden' value='" + index + "'>";
    $.each(record, function(key, value){ // Different type of input for different info type
        // Ignore this for id's because they are hidden
        if(key != "idUur" &&
            key != "idMedewerker" &&
            key != "idProject")
        {
            modalHtml += "<div class='form-group row edit_modal'>";
            modalHtml += "<label for=edit_modal_" + key + " class='col-xs-3 col-form-label'>" + key + ": " + "</label>";
            modalHtml += "<div class='col-xs-9'>";
        }
        switch (key) {
            case "idUur":
            case "idMedewerker":
            case "idProject":
                modalHtml += "<input id=edit_modal_" + key + " type='hidden' value='" + value + "' disabled>";
                break;
            case "medewerkerNaam":
                modalHtml += "<input id=edit_modal_" + key + " type='text' class='form-control edit_modal' readonly value='" + value + "'/>";
                break;
            case "projectNaam":
                modalHtml += "<select id=edit_modal_"+key+" class='selectpicker' data-live-search='true' value='"+value+"'>";
                modalHtml += $("#projects_list").html();
                modalHtml += "</select>";
                break;
            case "urengewerkt":
                modalHtml += "<input id=edit_modal_" + key + " type='"+type+"' class='form-control edit_modal' readonly value='" + value + "'/>";
                break;
            case "begintijd":
            case "eindtijd":
                modalHtml += "<input id=edit_modal_"+key+" type='text' class='form-control edit_modal edit_modal_datetime' value='"+value+"'/>";
                break;
            case "omschrijving":
                modalHtml += "<textarea id=edit_modal_"+key+" rows=2 class='form-control edit_modal'>"+value+"</textarea>";
                break;
            case "timestamp":
                modalHtml += "<input id=edit_modal_"+key+" type='text' class='form-control edit_modal' readonly value='"+value+"' "+disabled+"/>";
                break;
            case "innovatief":
                var checked = value=="1"?'checked':'';
                modalHtml += "<input id=edit_modal_"+key+" type='checkbox' class='form-control edit_modal checkbox' "+checked+">";
                break;
            case "goedgekeurd":
                var checked = value=="1"?'checked':'';
                modalHtml += "<input id=edit_modal_"+key+" type='checkbox' class='form-control edit_modal checkbox' "+checked+" "+disabled+">";
                break;
            default:
                modalHtml += "<input id=edit_modal_"+key+" type='text' class='form-control edit_modal' value='"+value+"' "+disabled+"/>";
                break;
        }
        modalHtml += "</div></div>";
    });

    $("#edit_modal").find(".modal-body").html(modalHtml);
    $(".selectpicker").selectpicker('refresh');

    // Setup daterangepicker for the 'begintijd' and 'eindtijd'
    $(".edit_modal_datetime").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 30,
        opens: "left",
        locale: {
            format: "YYYY-MM-DD HH:mm:ss",
            daysOfWeek: [
                "Ma",
                "Di",
                "Wo",
                "Do",
                "Vr",
                "Za",
                "Zo"
            ],
            "monthNames": [
                "Januari",
                "Februari",
                "Maart",
                "April",
                "Mei",
                "Juni",
                "July",
                "Augustus",
                "September",
                "Oktober",
                "November",
                "December"
            ],
            "startDate": $(selectedItem).val()
        },
    });

    // Setup onchange event for daterangepicker
    edit_modal_begintijd = $("#edit_modal_begintijd").val().split(" ")[1];
    $("#edit_modal_begintijd").on("change", function(){
        edit_modal_begintijd = $(this).val().split(" ")[1];
        calcTotalHours();
    });
    edit_modal_eindtijd = $("#edit_modal_eindtijd").val().split(" ")[1];
    $("#edit_modal_eindtijd").on("change", function(){
        edit_modal_eindtijd = $(this).val().split(" ")[1];
        calcTotalHours();
    });

    function calcTotalHours(){
        if(edit_modal_begintijd != null && edit_modal_eindtijd != null)
        {
            if(edit_modal_begintijd >= edit_modal_eindtijd)
            {
                // console.log("begintijd is greater then eindtijd!");
                $("#edit_modal_urengewerkt").val("invalid");
            }
            else
            {
                // console.log("begintijd is less then eindtijd.");
                var hours_begintijd = parseFloat(edit_modal_begintijd.split(":")[0]);
                var minutes_begintijd = parseFloat(edit_modal_begintijd.split(":")[1])/60;
                hours_begintijd += minutes_begintijd;
                var hours_eindtijd = parseFloat(edit_modal_eindtijd.split(":")[0]);
                var minutes_eindtijd = parseFloat(edit_modal_eindtijd.split(":")[1])/60;
                hours_eindtijd += minutes_eindtijd;
                console.log("begin: " + hours_begintijd + ", eind: " + hours_eindtijd);
                var totalHours = hours_eindtijd - hours_begintijd;
                $("#edit_modal_urengewerkt").val(totalHours);
            }
        }
    }

    // Override 'change' button if record is already validated
    if(userrole === "medewerker" && record.goedgekeurd == "1")
    {
        $("#edit_modal_changeButton").prop('disabled', true);
        alert("Dit record is al goedgekeurd en kan dus niet meer aangepast worden.");
    }
    else
        $("#edit_modal_changeButton").prop('disabled', false);

    $("#edit_modal").modal('show');
}