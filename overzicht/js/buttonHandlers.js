/**
 * Created by JohnDoe on 1-10-2016.
 */
// Global vars
var cache_old_records;
var cache_new_records;

// For hiding alerts
$(document).on('click', '.alert .close', function(){
    $(this).closest('.alert').fadeOut();
});

// Handler for search button
$("#search_button").on("click", function(event){
    $("#search_button").prop("disabled",true);
    $("#div_description_list").hide();
    $(".loader").fadeIn(100);
    $(".alert").each(function(index, item){
        if($(item).css('display') != 'none')
            $(item).hide();
    });

    $.getScript("../main/js/ajax.js", function(){
        console.log("Starting search..");

        // Get records matching filters
        var user = $("#users_list").val();
        var project = $("#projects_list").val();
        var daterange = $("#daterange_picker").val();
        daterange = daterange.split(" t/m ");
        var date1 = daterange[0] + " 00:00:00";
        var date2 = daterange[1] + " 23:59:59";

        var ajaxObj = new AjaxObj("getUrenBetweenDate", {'userEmail': user, 'projectName': project, 'date1': date1, 'date2': date2}, false, "json");
        var response = ajaxObj.result;
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
            $(".loader").hide();
            $("#div_description_list").fadeIn();
        }
        else{
            $(".loader").fadeOut();
            $("#noRecordsFound").fadeIn();
        }
        $("#search_button").prop("disabled",false);
   });
});

// Handler for save button
$("#save_button").on("click", function(event){
    // Hide description list
    $("#div_description_list").fadeOut();
    $(".loader").fadeIn();

    var changed_records = [];
    cache_new_records.forEach(function(item,index){
        for(var propertyname in item){
            if(item[propertyname] !== cache_old_records[index][propertyname]) {
                changed_records.push(item);
                break;
            }
        }
    });

    // Save all 'changed' records
    $.getScript("../main/js/ajax.js", function(){
        var ajaxObj = new AjaxObj("saveUurRecord", changed_records, true, "", function(response){
            $(".loader").fadeOut();
            if(jQuery.inArray("Failed", response) != -1)
                $("#recordSavedFailed").fadeIn();
            else
                $("#recordSavedSucces").fadeIn();
            cache_old_records = $.extend(true, [], cache_new_records);
        }); // TODO: Is this really safe??
    });
});