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
        // TODO: Make contextmenu item callback
        $.contextMenu({
            selector: '.context-menu-one',
            callback: function(key, options) {
                var m = "clicked: " + key;
                window.console && console.log(m) || alert(m);
            },
            items: {
                "validate": {name: "Goedkeuren"},
                "view": {name: "Bekijken"},
                "sep1": "---------",
                "cancel": {name: "Cancel"}
            }
        });

        console.log("Initialized!");
    });
});
