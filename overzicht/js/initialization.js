/**
 * Created by JohnDoe on 29-9-2016.
 */
$(document).ready(function(){
    console.log("Initializing...");

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
            var deleted = item.verwijderd == 1 ? " (deleted)" : "";
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

        // Step 4: Descriptions list
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

                options.items.view = {name: "Bekijken", disabled: $("#description_list :selected").length>1 ? true : false}; // TODO: Show modal
                options.items.log = {name: "Log"}; // DEBUG: Logs current item info in console
                options.items.sep1 = "---------";
                options.items.cancel = {name: "Cancel"};

                return options;
            }
        });
        console.log("Context menu complete!"); // DEBUG

        $("#filter_row").show();
        console.log("Initialized!");
    });
});

function viewEditModal(selectedItem){
    // Show modal with record info
    var index = $("#description_list :selected").val();
    var record = cache_new_records[index];
    //var readonly = userrole === "medewerker" ? "readonly" : "";
    var disabled = userrole === "medewerker" ? "disabled" : ""; // For checkboxed
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
            case "projectNaam":
                modalHtml += "<input id=edit_modal_" + key + " type='text' class='form-control edit_modal' readonly value='" + value + "' "+disabled+"/>";
                break;
            case "urengewerkt":
                modalHtml += "<input id=edit_modal_" + key + " type='number' class='form-control edit_modal' value='" + value + "' "+disabled+"/>";
                // TODO: Make readonly and calc time with 'begintijd' & 'eindtijd'
                break;
            case "begintijd":
            case "eindtijd":
                modalHtml += "<input id=edit_modal_"+key+" type='text' class='form-control edit_modal' value='"+value+"' "+disabled+"/>";
                break;
            case "omschrijving":
                modalHtml += "<textarea id=edit_modal_"+key+" rows=2 class='form-control edit_modal' "+disabled+">"+value+"</textarea>";
                break;
            case "timestamp":
                modalHtml += "<input id=edit_modal_"+key+" type='text' class='form-control edit_modal' readonly value='"+value+"' "+disabled+"/>";
                break;
            case "innovatief":
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

    // Setup daterangepicker for the 'begintijd' and 'eindtijd'
    $(".edit_modal_datetime").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 15,
        opens: "left",
        locale: {
            format: "YYYY-MM-DD hh:mm:ss",
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

    $("#edit_modal").modal('show');
}