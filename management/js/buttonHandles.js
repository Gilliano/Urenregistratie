/**
 * Created by niels on 5-10-2016.
 */
$("button[name='gebruiker_wijzig']").on("click", function(event){

    //get an array from the data from the table
    var array_text = [];
    $(this).parent().parent().children().each(function(){
       array_text.push(this.innerHTML);
    });

    //remove the last item from the array (because it gives us an <button>
    array_text.splice(array_text.length-1, 1);

    //for each array value should be set in the new model that is getting opened.
    array_text.forEach(function () {
        console.log(array_text[0]);

        //basic values are now getting set.
        $( '.id' ).val(array_text[0]);
        $( '.firstname' ).val(array_text[1]);
        $( '.tussenvoegsel' ).val(array_text[2]);
        $( '.lastname' ).val(array_text[3]);
        $( '.email' ).val(array_text[4]);
        $( '.valid' ).val(array_text[5]);
        $( '.rol' ).val(array_text[6]);
        $( '.status' ).val(array_text[7]);
    })
});


$("#save_button").on("click", function(event){
    //get an array from the data from the table
    //console.log($('#gebruiker_wijzig_form').serializeArray('firstname'));

    var data = $('#gebruiker_wijzig_form').serializeArray('firstname');

    $.getScript('../main/js/ajax.js', function () {



        var id = data[0].value;
        var firstname = data[1].value;
        var insertion = data[2].value;
        var lastname  = data[3].value;
        var email  = data[4].value;
        var valide  = data[5].value;
        var rol  = data[6].value;
        var state  = data[7].value;


        var ajaxobj = new AjaxObj('wijzigGebruiker',
            {   'id': id,
                'firstname': firstname,
                'insertion': insertion,
                'lastname': lastname,
                'email': email,
                'valide': valide,
                'rol': rol,
                'state': state
            }, false, '');

        //now close the model
        $('#myModal').modal('hide');



        //$("#allUsersTable").html("<p>okee</p><h1>OKee</h1>");

        //now close the model
        $('#myModal').modal('hide');

        //$("#allUsersTable").html("<?php users(); ?>");

        var ajaxObjUsers = new AjaxObj("getUsers", {}, false, "json");

        //Lets build the table head first
        var htmlList = "";
        htmlList += "<t>";
        htmlList +=     "<td><h4>Voornaam</h4></td>";
        htmlList +=     "<td><h4>Tussenvoegsel</h4></td>";
        htmlList +=     "<td><h4>Achternaam</h4></td>";
        htmlList +=     "<td><h4>Email</h4></td>";
        htmlList +=     "<td><h4>Valide</h4></td>";
        htmlList +=     "<td><h4>Rol</h4></td>";
        htmlList +=     "<td><h4>Status</h4></td>";
        htmlList += "</t>";

        //Now lets add the new items :)
        ajaxObjUsers.result.forEach(function(item){
            console.log(item.voornaam);
            htmlList += "<tr>";
            htmlList += "<td>"+item.voornaam+"</td>";
            htmlList += "<td>"+item.tussenvoegsels+"</td>";
            htmlList += "<td>"+item.achternaam+"</td>";
            htmlList += "<td>"+item.email+"</td>";
            htmlList += "<td>"+item.validated+"</td>";
            htmlList += "<td>"+item.rol+"</td>";
            htmlList += "<td>"+item.state+"</td>";
            htmlList += "<td> <button type='submit' name='gebruiker_wijzig' value='"+item.idMedewerker+"' class='btn btn-default' data-toggle='modal' data-target='#myModal'>Wijzig</button> </td>";
            htmlList += "</tr>";
        });

        $("#allUsersTable").html(htmlList);

        //$("#allUsersTable").html("<tr><td>hello</td></tr>");

    });
    //ajax object  maken

});