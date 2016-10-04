/**
 * Created by JohnDoe on 1-10-2016.
 */
// Global vars
var cache_old_records;
var cache_new_records;

// Handler for search button
$("#search_button").on("click", function(event){
    $("#search_button").prop("disabled",true);
    $("#description_row").hide();
    $("#noRecordsFound").hide();

    $.getScript("../main/js/ajax.js", function(){
       console.log("Starting search..");

       // Get records matching filters
       var user = $("#users_list").val();
       var project = $("#projects_list").val(); //TODO: Change back to val()
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
           // Cache response
           cache_old_records = $.extend(true, [], response);
           cache_new_records = $.extend(true, [], response);

           // Fill the description list
           var html = "";
           response.forEach(function(item, index){
               var validateClass = item.goedgekeurd==1?'validated':'';
               html += "<option class='context-menu-one "+validateClass+"' value='"+index+"'>"+item.omschrijving+"</option>";
           });

           if(html.length > 0){
               $("#description_list").html(html);
               $("#description_row").show();
           }
           else{
               $("#noRecordsFound").show();
           }
           $("#search_button").prop("disabled",false);
       };
       ajaxObj.call();
   });
});

// Handler for save button
$("#save_button").on("click", function(event){
    var changed_records = [];
    cache_new_records.forEach(function(item,index){
        for(var propertyname in item){
            if(item[propertyname] !== cache_old_records[index][propertyname]) {
                changed_records.push(item);
                break;
            }
        }
    });

    // DEBUG: Shows wich records are "edited"
    console.log("RECORDS TO SEND TO SERVER:");
    changed_records.forEach(function(item, index){
        console.log("idUur: " + item.idUur);
    });

    // Save all 'changed' records
    $.getScript("../main/js/ajax.js", function(){
        var ajaxObj = new AjaxObj("saveUurRecord", changed_records); // TODO: Is this really safe??
        ajaxObj.callback = function(response){
            console.log(response);
        };
        ajaxObj.call();
    });
});