/**
 * Created by JohnDoe on 1-10-2016.
 */
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
                html += "<option class='context-menu-one' value='"+item.idUur+"'>"+item.omschrijving+"</option>";
               //TODO: When clicked on option show modal with all info
           });

           $("#description_list").html(html);
           $("#div_description_list").show();
       };
       ajaxObj.call();
   });
});