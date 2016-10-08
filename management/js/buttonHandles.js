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
    //record updaten in database

    //table live updates
});