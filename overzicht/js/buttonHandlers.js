// TODO: Make the AJAX connections into a class object
// Onclick for the page buttons
$(".pageButton").on("click", function(event){
    // Quit if pagenumber = 1 when clicking previous button
    if(parseInt($("#pageLabel").html()) <= 1 && $(this).attr('name') == "previousButton")
        return;
    
    global_this = this;
    
    // Disable pageButtons
    $(".pageButton").each(function(){
        this.disabled = true;
    });

    // Load AJAX js "class"
    $.getScript('../main/js/ajax.js', function(){
        var ajaxObj = new AjaxObj("getRecordsTable", {'method' : $(global_this).attr('name')});
        ajaxObj.callback = function(response){
            // Set the content of the recordsTable
            // to the new html code
            $("#recordsTable").html(response);
            // Update page label
            var old_labelValue = parseInt($("#pageLabel").html());
            var incrementValue = $(global_this).attr('name') == "nextButton" ? 1 : -1;
            $("#pageLabel").text(old_labelValue + incrementValue);
            // Enable pageButtons
            $(".pageButton").each(function(){
                this.disabled = false;
            });
        };
        ajaxObj.post();
    });
});