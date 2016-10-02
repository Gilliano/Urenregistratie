/**
 * Created by JohnDoe on 29-9-2016.
 */
$(document).ready(function(){
    console.log("Initializing...");

    $.getScript("../main/js/ajax.js", function() {
        // Step 1: Initialize users list
        var ajaxObj = new AjaxObj("getUsers");
        ajaxObj.dataType = "json";
        ajaxObj.callback = function (response) {
            var htmlList = "";
            response.forEach(function(item){
                htmlList += "<option value=" + item.email + ">" + item.email + "</option>"; // FEATURE: Set data-tokens equal to user's project names
            });
            $("#users_list").html(htmlList);
            $(".selectpicker").selectpicker('refresh');
        };
        ajaxObj.call();

        // TODO: Step 2: Initialize projects list
        // ajaxObj.action = "getProjects";
        // ajaxObj.params = {'userID': }
        // ajaxObj.callback = function(response){
        //     var htmlList = "";
        //     response.forEach(function(item){
        //         htmlList += "<option value=" + item.projectnaam + ">" + item.projectnaam + "</option>";
        //     });
        // };

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
                                });
                                break;
                            case "invalidate":
                                // Get all selected items
                                // in description list
                                $("#description_list :selected").each(function(i, selected){
                                    // Remove class 'validated'
                                    $(selected).removeClass("validated");
                                });
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
                options.items.sep1 = "---------";
                options.items.cancel = {name: "Cancel"};

                return options;
            }
        });

        console.log("Initialized!");
    });
});
