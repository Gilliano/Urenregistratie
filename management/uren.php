<h1 style="font-family: 'Montserrat'">Uren</h1>


    <div class="col-sm-3" style="margin-bottom: 10px;">
        <label for="daterange_picker">Datum: van .. tot</label><br>
        <input id="daterange_picker_hours" type="text" class="form-control" name="daterange"/>
    </div>



<div class="wijzigen div-1">
    <table id="allHours" class="gebruikers_wijzigen table">

    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="myHour" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">wijzig</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="hour_delete_form" style="margin: auto" role="login">
                    <h4 class="modal-title">Wijzigen</h4>
                    <input type="hidden" name="idHour" autocomplete="false" required class="form-control input-lg idHour"/>

                    <input type="text" disabled name="idGebruiker" class="form-control input-lg idGebruiker"/>

                    <input type="text" disabled name="idProject" class="form-control input-lg idProject"/>

                    <input type="text" disabled name="hourSpend" class="form-control input-lg hourSpend"/>

                    <input type="text" disabled name="Begin" class="form-control input-lg Begin"/>

                    <input type="text" disabled name="End" class="form-control input-lg End"/>

                    <input type="text" disabled name="Description" class="form-control input-lg Description"/>

                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" id="delete_hour" class="btn btn-default" value="save">
            </div>
        </div>
    </div>
</div>