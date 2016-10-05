/**
 * Created by JohnDoe on 29-9-2016.
 */
// TODO: Change for non-admins
$(document).ready(function(){
    console.log("Initializing...");

    $.getScript("../main/js/ajax.js", function() {
        // Step 1: Initialize users list
        var ajaxObj = new AjaxObj("getUsers", {}, false, "json");
        var htmlList = "";
        ajaxObj.result.forEach(function(item){
            // TODO: Only allow your own name if not admin
            htmlList += "<option value=" + item.email + ">" + item.email + "</option>"; // FEATURE: Set data-tokens equal to user's project names
        });
        $("#users_list").html(htmlList);
        $(".selectpicker").selectpicker('refresh');
        console.log("Users list complete!"); // DEBUG

        // TODO: Step 2: Initialize projects list
        ajaxObj = new AjaxObj("getAllProjects", {}, false, "json");
        htmlList = "";
        ajaxObj.result.forEach(function(item){
            var deleted = item.verwijderd == 1 ? " (deleted)" : "";
            htmlList += "<option value=" + item.projectnaam + ">" + item.projectnaam + deleted + "</option>";
        });

        // DEBUG: Hardcoded version of the above code
        // var htmlList = "";
        // htmlList += "<option value='Apple'>Apple</option>";
        // htmlList += "<option value='Samsung'>Samsung</option>";
        $("#projects_list").html(htmlList);
        $(".selectpicker").selectpicker('refresh');
        console.log("Projects list complete!"); // DEBUG

        // Step 3: Initialize date range picker
        $("#daterange_picker").daterangepicker({
            showDropdowns: true,
            showWeekNumbers: true,
            opens: "left",
            locale: {
                format: "DD/MM/YYYY",
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
                        }
                    },
                    items: {}
                };
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

                if ($("#description_list :selected").length >= 1 && ((!validFound && invalidFound) ||
                    (validFound && !invalidFound)))
                {
                    if (validFound)
                        options.items.invalidate = {name: "Afkeuren"};
                    else if(invalidFound)
                        options.items.validate = {name: "Goedkeuren"};
                }
                else
                    options.items.multiple = {name: "Kan niet kiezen", disabled: true}; // TODO: Rename to something better

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
