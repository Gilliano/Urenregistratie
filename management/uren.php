<h1 style="font-family: 'Montserrat'">Uren</h1>


    <div class="col-sm-3" style="margin-bottom: 10px;">
        <label for="daterange_picker">Datum: van .. tot</label><br>
        <input id="daterange_picker_hours" type="text" class="form-control" name="daterange"/>
    </div>

<br><br><br><br><br>
<div class="row">
    <div class="col-sm-1" style="width: 25px">
        <div style="width: 20px; height: 20px; background: #34b449;"></div>
    </div>
    <div class="col-sm-1">
        <p>= innovatief</p>
    </div>
</div>

<br>
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
                <h4 class="modal-title">Verwijder</h4>
            </div>

            <div class="modal-body">
                <form id="hour_delete_form">

                    <input type="hidden" name="id" autocomplete="false" required class="form-control input-lg idHour"/>

                    <div class="form-group">
                        <label class="form-control-label">Gebruiker</label>
                        <input type="text" name="idGebruiker" disabled class="form-control idGebruiker">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Project</label>
                        <input type="text" name="idProject" disabled class="form-control idProject">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Uren spendeert</label>
                        <input type="text" name="hourSpend" disabled class="form-control hourSpend">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Begin tijd</label>
                        <input type="text" name="Begin" disabled class="form-control Begin">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Eind tijd</label>
                        <input type="text" name="End" disabled class="form-control End">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Beschrijving</label>
                        <input type="text" name="Description" disabled class="form-control Description">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" id="delete_hour" class="btn btn-default" value="Verwijder">
            </div>
        </div>
    </div>
</div>