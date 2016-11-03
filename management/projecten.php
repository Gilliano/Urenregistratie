<h1 style="font-family: 'Montserrat'">Projecten <button type='submit' name='project_aanmaken' class='btn btn-default' data-toggle='modal' data-target='#addProject'>Project toevoegen</button></h1>


<div class="wijzigen div-1">
    <table id="allProjects" class="gebruikers_wijzigen table">
        <t>
            <td><h4>Project naam</h4></td>
            <td><h4>Status</h4></td>
            <td><h4>Wijzig</h4></td>
        </t>
        <?php echo projecten();?>
    </table>
</div>


<!-- Modal -->
<div class="modal fade" id="myProject" role="dialog" style="margin-top: 60px">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">wijzig</h4>
            </div>

            <div class="modal-body">
                <form id="project_wijzig_form">

                    <input type="hidden" name="id" autocomplete="false" required class="form-control input-lg id"/>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Title</label>
                        <input type="text" name="title" placeholder="Title" class="form-control title">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Klaar</label>
                        <br>
                        <input type="checkbox" name="done" placeholder="Done" autocomplete="false"
                               class="form-control input-lg done">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" id="save_button_project" class="btn btn-default" value="save">
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addProject" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">wijzig</h4>
            </div>

            <div class="modal-body">
                <form id="add_project">

                    <div class="form-group">
                        <label class="form-control-label">Project naam</label>
                        <input type="text" name="add_project_naam" placeholder="project naam" class="form-control add_project_naam">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button name="add_project" class="btn btn-default">Aanmaken</button>
            </div>
        </div>
    </div>
</div>