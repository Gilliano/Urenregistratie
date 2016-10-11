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
        $( '.firstname' ).val(array_text[0]);
        $( '.tussenvoegsel' ).val(array_text[1]);
        $( '.lastname' ).val(array_text[2]);
        $( '.email' ).val(array_text[3]);
        $( '.valid' ).val(array_text[4]);
        $( '.rol' ).val(array_text[5]);
        $( '.status' ).val(array_text[6]);
    })
});


$("#save_button").on("click", function(event){
    //get an array from the data from the table
    //console.log($('#gebruiker_wijzig_form').serializeArray('firstname'));

    var data = $('#gebruiker_wijzig_form').serializeArray('firstname');

    $.getScript('../main/js/ajax.js', function () {




        var firstname = data[0].value;
        var insertion = data[1].value;
        var lastname  = data[2].value;
        var email  = data[3].value;
        var valide  = data[4].value;
        var rol  = data[5].value;
        var state  = data[6].value;


        var ajaxobj = new AjaxObj('wijzigGebruiker',
            {   'firstname': firstname,
                'insertion': insertion,
                'lastname': lastname,
                'email': email,
                'valide': valide,
                'rol': rol,
                'state': state
            }, false, '');

        alert(ajaxobj.result);
    });
    //ajax object  maken

});