<?php
/**
 * Created by PhpStorm.
 * User: niels
 * Date: 4-10-2016
 * Time: 17:09
 */
toggleProject();
?>

<h1 style="font-family: 'Montserrat'">Projecten</h1>



<div class="wijzigen div-1">
    <form method="post">
        <table class="gebruikers_wijzigen table">
            <t>
                <td><h4>Project naam</h4></td>
                <td><h4>Status</h4></td>
                <td><h4>Wijzig</h4></td>
            </t>
            <?php echo projecten();?>
        </table>
    </form>
</div>
