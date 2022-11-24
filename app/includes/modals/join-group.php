<?php
    if(!function_exists('chargerClasses'))
    {
        include realpath(__DIR__).'/../../controller/MainController.php';
    }

    $manager = new GroupManager(DB_GROUPS);
    $list = $manager->lists();

    $user = $_SESSION['user'];
?>
<div class="u-panel_content">
    <header class="u-panel_header">
        <p class="u-title_small">
            Rejoindre un groupe
        </p>
        <p>
            Retrouve ci-dessous la liste des groupes d'utilisateurs existant.<br/>
            Sélectionne le(s) groupe(s) que tu souhaites rejoindre puis valide ton choix.
        </p>
    </header>
    <form action="<?=SITE_MAIN_BASE.'groups/edit-user/'?>" method="POST" class="c-form" is-checked enctype="multipart/form-data">
<?php
    foreach($list as $group)
    {
?>
        <div class="c-form_field c-form_field--flex">
            <strong class="c-form_switch_label"><?=$group->title()?></strong>
            <label class="c-form_switch">
                <input type="checkbox" name="groups[]" value="<?=$group->id_group()?>" <?=($group->is_member($user->id_user())) ? "checked" : ""?>/>
                <span class="slider"></span>
            </label>
        </div>
<?php
    }
?>
        <div class="c-form_field c-form_submit">
            <input type="hidden" name="id_user" value="<?=$user->id_user()?>">
            <button type="submit" class="u-button"><span class="icon-check"></span>Enregistrer</button>
            <button type="button" class="u-button--primary" data-close-panel><span class="icon-cancel"></span>Annuler</button>
        </div>
    </form>
</div>