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
            html += "<option name='description_item' class='context-menu-one "+validateClass+"' value='"+index+"'>"+item.urengewerkt+" uren gewerkt"+" | "+item.omschrijving+"</option>";
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

        // Setup dubble click handler for option items
        $('#description_list').find('option').each(function(){
            $(this).dblclick(function (event) {
                // alert($(event.target).val());
                viewEditModal($(event.target));
            });
        });

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

// Handler for modal save button
$("#edit_modal_changeButton").on("click", function(event){
    var currentRecord = jQuery.grep(cache_new_records, function(element, index){ return (element.idUur == $("#edit_modal_idUur").val()); })[0];

    $("[id^='edit_modal_']").each(function(index, item){
        if(!$(item).is("button") && $(item).attr('type') !== "hidden" && !$(item).is("[readonly]")){  // Ignore buttons, hidden inputs and readonly's
            // Update local record
            var propertyName = $(item).attr('id').replace('edit_modal_', '');
            var value = $(item).val();
            if ($("#"+$(item).attr('id')).attr('type') === "checkbox"){
                if ($("#"+$(item).attr('id')).is(":checked")) // For checkboxes
                    value = "1";
                else
                    value = "0";
            }
            currentRecord[propertyName] = value;
        }
    });

    // Update selected list item with new values
    var itemID = $("[id='edit_modal_itemID']").val(); // List item id
    var listItem_handle = $("option[name='description_item'][value='"+itemID+"']");
    listItem_handle.html(currentRecord.omschrijving); // list item text
    if(currentRecord.goedgekeurd == 1)
        $(listItem_handle).addClass("validated");
    else
        $(listItem_handle).removeClass("validated");
    $("#edit_modal").modal('toggle');
});