<h1 style="font-family: 'Montserrat'">Projecten</h1>

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