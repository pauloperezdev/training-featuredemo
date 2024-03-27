<?php

function getDynamicCascadingComboboxPageDescription() {
    $smarty = new Smarty();
    $smarty->assign('Title', 'Table structures and relationships');
    $contents = '<img src="external_data/images/mla_schema.png">';
    $smarty->assign('Contents', $contents);
    $smarty->template_dir = 'external_data/doc';
    $html = $smarty->fetch('editors_dynamic_cascading_combobox.tpl');

    return $html;
}
