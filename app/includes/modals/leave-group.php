<?php
    if(!function_exists('chargerClasses'))
    {
        include realpath(__DIR__).'/../../controller/MainController.php';
    }

    $manager = new GroupManager(DB_GROUPS);
    $group = $manager->get($_POST['id_group']);

    $user = $_SESSION['user'];
?>
<div class="u-panel_content">
    <header class="u-panel_header">
        <p class="u-title_small">
            Quitter ce groupe
        </p>
    </header>
    <p>
        Tu es sur le point de quitter le groupe <strong><?=$group->title()?></strong>
        <br><br>
        Es-tu sûr de vouloir quitter ce groupe ?
    </p>
    <form action="<?=SITE_MAIN_BASE.'groups/delete-user/'?>" method="POST" class="c-form" is-checked enctype="multipart/form-data">
        <input type="hidden" name="id_group" value="<?=$group->id_group()?>">
        <input type="hidden" name="id_user" value="<?=$user->id_user()?>">
        <div class="c-form_field c-form_submit">
            <button class="u-button--primary" type="sumbit">
                <span class="icon-check"></span> Quitter le groupe
            </button>
            <button class="u-button--secondary-dark" data-close-panel type="button">
                <span class="icon-cancel"></span> Annuler
            </button>
        </div>
    </form>
</div>