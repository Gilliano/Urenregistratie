function getHours() {
    var ajaxObjProjects = new AjaxObj("allProjects", {}, false, "json");
    //Lets build the table head first
    var htmlList = "";
    htmlList += "<t>";
    htmlList += "<td><h4>Project naam</h4></td>";
    htmlList += "<td><h4>Status</h4></td>";
    htmlList += "<td><h4>Wijzig</h4></td>";
    htmlList += "</t>";

    //Now lets add the new items :)
    ajaxObjProjects.result.forEach(function (item) {
        htmlList += "<tr>";
        htmlList += "<td style='display:none'>" + item.idProject + "</td>";
        htmlList += "<td>" + item.projectnaam + "</td>";
        htmlList += "<td style='display: none'>" + item.verwijderd + "</td>";
        if(item.verwijderd == 0) {
            htmlList += "<td>Niet afgerond</td>";
        } else {
            htmlList += "<td>Afgerond</td>";
        }
        htmlList += "<td><button type='submit' name='project_wijzig' value='" + item.idProject + "' class='btn btn-default' data-toggle='modal' data-target='#myProject'>Wijzig</button> </td>";
        htmlList += "</tr>";
    });

    $("#allProjects").html(htmlList);

    $("button[name='project_wijzig']").on("click", function (event) {
        wijzig_button_project($(this));
    });
}