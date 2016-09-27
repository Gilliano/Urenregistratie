// Onclick event handler for controls
// that have class 'editable'
$(".editable").on("click", function(event) {
    // Get userrole from php
    var userrole = "guest"; // Default value
    var action = "getSessionVariable";
    var param1 = "userrole";
    var ajaxurl = "../main/php/ajax.php";
    var data = {'action': action, 'params': {'sessionVariable': param1}};
    $.post(ajaxurl, data, function (response){
        userrole = response;
        
        // Check if this userrole can edit
        if (userrole == "admin")
        {
            $(event.target).removeAttr("readonly"); // Enable the clicked control
        }
        else
        {
            return false; // For handling checkboxes
        }
    });
});