/**
 * Created by niels on 5-10-2016.
 */
$("button[name='project_wijzig']").on("click", function (event) {
    wijzig_button_project($(this));
});

function wijzig_button_project(caller){
    //get an array from the data from the table
    var array_text = [];
    caller.parent().parent().children().each(function () {
        array_text.push(this.innerHTML);
    });

    //remove the last item from the array (because it gives us an <button>
    array_text.splice(array_text.length - 1, 1);

    //for each array value should be set in the new model that is getting opened.
    array_text.forEach(function () {

        //basic values are now getting set.
        $('.id').val(array_text[0]);
        $('.title').val(array_text[1]);
        if(array_text[2] == 0) {
            $('.done').prop('checked', false);
        } else {
            $('.done').prop('checked', true);
        }

        // $('.done').val(array_text[2]);
        // alert(array_text[2]);
    })
}

$("#save_button_project").on("click", function (event) {
    //get an array from the data from the table
    var data = $('#project_wijzig_form').serializeArray();

    //define the id and title
    var id = data[0].value;
    var title = data[1].value;

    //lets check if the checkbox is true or false
    if($('.done').is(':checked') == true) {
        var done = 1;
    } else {
        var done = 0;
    }

    $.getScript('../main/js/ajax.js', function () {
        var ajaxobj = new AjaxObj('updateProject', {
            'id': id,
            'title': title,
            'done': done
        }, false, '');

        $('#myProject').modal('hide');

        getHours();

        $("#allProjects").html(htmlList);

        $("button[name='project_wijzig']").on("click", function (event) {
            wijzig_button_project($(this));
        });
    });

    // $.getScript('../main/js/ajax.js', function () {
    //
    //
    //     var id = data[0].value;
    //     var firstname = data[1].value;
    //     var insertion = data[2].value;
    //     var lastname = data[3].value;
    //     var email = data[4].value;
    //     var valide = data[5].value;
    //     var rol = data[6].value;
    //     var state = data[7].value;
    //
    //
    //     var ajaxobj = new AjaxObj('wijzigGebruiker',
    //         {
    //             'id': id,
    //             'firstname': firstname,
    //             'insertion': insertion,
    //             'lastname': lastname,
    //             'email': email,
    //             'valide': valide,
    //             'rol': rol,
    //             'state': state
    //         }, false, '');
    //
    //     //now close the model
    //     $('#myModal').modal('hide');
    //
    //     var ajaxObjUsers = new AjaxObj("getUsers", {}, false, "json");
    //
    //     //Lets build the table head first
    //     var htmlList = "";
    //     htmlList += "<t>";
    //     htmlList += "<td><h4>Voornaam</h4></td>";
    //     htmlList += "<td><h4>Tussenvoegsel</h4></td>";
    //     htmlList += "<td><h4>Achternaam</h4></td>";
    //     htmlList += "<td><h4>Email</h4></td>";
    //     htmlList += "<td><h4>Valide</h4></td>";
    //     htmlList += "<td><h4>Rol</h4></td>";
    //     htmlList += "<td><h4>Status</h4></td>";
    //     htmlList += "</t>";
    //
    //     //Now lets add the new items :)
    //     ajaxObjUsers.result.forEach(function (item) {
    //         htmlList += "<tr>";
    //         htmlList += "<td style='display: none'>" + item.idMedewerker + "</td>";
    //         htmlList += "<td>" + item.voornaam + "</td>";
    //         htmlList += "<td>" + item.tussenvoegsels + "</td>";
    //         htmlList += "<td>" + item.achternaam + "</td>";
    //         htmlList += "<td>" + item.email + "</td>";
    //         htmlList += "<td>" + item.validated + "</td>";
    //         htmlList += "<td>" + item.rol + "</td>";
    //         htmlList += "<td>" + item.state + "</td>";
    //         htmlList += "<td><button type='submit' id='gebruiker_wijzig' name='gebruiker_wijzig' value='" + item.idMedewerker + "' class='btn btn-default' data-toggle='modal' data-target='#myModal'>Wijzig</button> </td>";
    //         htmlList += "</tr>";
    //     });
    //
    //     $("#allUsersTable").html(htmlList);
    //
    //     $("button[name='gebruiker_wijzig']").on("click", function (event) {
    //         wijzig_button($(this));
    //     });
    //     // location.reload();
    //
    // });

});