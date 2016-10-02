<<<<<<< HEAD
/**
 * Created by JohnDoe on 1-10-2016.
 */
// Handler for search button
$("#search_button").on("click", function(event){
   $.getScript("../main/js/ajax.js", function(){
       console.log("Starting search..");

       // Get records matching filters
       var user = $("#users_list").val();
       var project = "Samsung";//$("#projects_list").val(); //TODO: Change back to val()
       var daterange = $("#daterange_picker").val();
       daterange = daterange.split(" - ");
       var date1 = daterange[0].split("/");
       date1 = date1[2] + "-" + date1[1] + "-" + date1[0] + " 00:00:00"; // Date format = YYYY-MM-DD HH:MM:SS
       var date2 = daterange[1].split("/");
       date2 = date2[2] + "-" + date2[1] + "-" + date2[0] + " 23:59:59"; // Date format = YYYY-MM-DD HH:MM:SS

       console.log("user: " + user + "\nProject: " + project + "\nDaterange: " + date1 + " - " + date2);
       var ajaxObj = new AjaxObj("getUrenBetweenDate", {'userEmail': user, 'projectName': project, 'date1': date1, 'date2': date2});
       ajaxObj.dataType = "json";
       ajaxObj.callback = function(response){
           // Fill the description list
           var html = "";
           response.forEach(function(item){
               var validateClass = item.goedgekeurd==1?'validated':'';
               html += "<option class='context-menu-one "+validateClass+"' value='"+item.idUur+"'>"+item.omschrijving+"</option>";
           });

           $("#description_list").html(html);
           $("#description_row").show();
       };
       ajaxObj.call();
   });
});

// Handler for save button
$("#save_button").on("click", function(event){
    // TODO: Save all 'changed' records
    alert("TODO: Save all 'changed' records");
=======
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
>>>>>>> parent of 1124438... Basic functionality works (only 2nd filter not yet (project 1 = samsung) and context menu for description items doesnt do anything yet)
});