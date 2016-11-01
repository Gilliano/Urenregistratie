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
<div class="modal fade" id="myProject" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">wijzig</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="project_wijzig_form" style="margin: auto" role="login">
                    <h4 class="modal-title">Wijzigen</h4>
                    <input type="hidden" name="id" autocomplete="false" required class="form-control input-lg id"/>

                    <input type="text" name="title" placeholder="Title" autocomplete="false" required
                           class="form-control input-lg title"/>

                    <h4>Klaar</h4>
                    <input type="checkbox" name="done" placeholder="Done" autocomplete="false"
                           class="form-control input-lg done">
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" id="save_button_project" class="btn btn-default" value="save">
            </div>
        </div>
    </div>
</div>