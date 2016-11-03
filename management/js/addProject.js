$("button[name='add_project']").on("click", function (event) {

    $.getScript('../main/js/ajax.js', function () {

        var project_title = $( ".add_project_naam" ).val();

        if(project_title.length >= 1) {
            var ajaxobj = new AjaxObj('createProject', {
                'projectname': project_title
            }, false, '');

            $('#addProject').modal('hide');

            getHours();

        } else {
            console.log('Empty');
        }
    });
});