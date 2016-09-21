// Onclick for the page buttons
$(".pageButton").on("click", function(event){
    global_this = this;
    
    // Get page number from session variable
    var action = "getSessionVariable";
    var param1 = "pagenumber";
    var ajaxurl = "../main/php/ajax.php";
    var data = {'action': action, 'params': {'sessionVariable': param1}};
    $.post(ajaxurl, data, function(response){
        console.log("Current page number: " + response);
        var pagenumber = parseInt(response);
        
        // Check if previous or next button
        var buttonName = $(global_this).attr("name");
        console.log("Clicked button: " + buttonName);
        switch(buttonName){
            case "previousButton":
                pagenumber--;
                break;
            case "nextButton":
                pagenumber++;
                break;
        }

        // Set new pagenumber session variable
        var action = "setSessionVariable";
        var param1 = "pagenumber";
        var param2 = pagenumber;
        var ajaxurl = "../main/php/ajax.php";
        var data = {'action': action, 'params': {'sessionVariable': param1, 'value': param2}};
        $.post(ajaxurl, data, function(response){
            console.log(response);
        });
        console.log("New page number (should be): " + pagenumber);
        
        // Get the new table html code
        var action = "getRecordsTable";
        var ajaxurl = "../main/php/ajax.php";
        var data = {'action': action};
        $.post(ajaxurl, data, function(response){
            // Set the content of the recordsTable
            // to the new html code
            $("#recordsTable").replaceWith(response);
            // Update page label
            $("#pageLabel").replaceWith(pagenumber);
        });
        
        // FIXME: Returns 1 when it should return the
        // new value set in "setSessionVariable"
        var action = "getSessionVariable";
        var param1 = "pagenumber";
        var ajaxurl = "../main/php/ajax.php";
        var data = {'action': action, 'params': {'sessionVariable': param1}};
        $.post(ajaxurl, data, function(response){
            console.log("New page number is really: " + response);
        });
    });
});