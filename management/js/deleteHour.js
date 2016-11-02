// $("button[name='uur_verwijder']").on("click", function (event) {
//     //get_hours_model($(this));
//     console.log('hello');
// });

function get_hours_model(caller){
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
        $('.idHour').val(array_text[0]);
        $('.idGebruiker').val(array_text[1]);
        $('.idProject').val(array_text[2]);
        $('.hourSpend').val(array_text[3]);
        $('.Begin').val(array_text[4]);
        $('.End').val(array_text[5]);
        $('.Description').val(array_text[6]);
    })
}

$("#delete_hour").on("click", function (event) {

    //get an array from the data from the table
    var data = $('#hour_delete_form').serializeArray();
    //now call the ajaxObject
    $.getScript('../main/js/ajax.js', function () {
        //get id 'idHour' from the array
        var id = data[0].value;
        console.log(id);
        //now delete the record where id is 'idHour'
        var ajaxobj = new AjaxObj('deleteHourByID', {
            'idHour': id
        }, false, '');

        //now close the model
        $('#myHour').modal('hide');
        //refill the table
        tableHoursBetweenData();
    });
});