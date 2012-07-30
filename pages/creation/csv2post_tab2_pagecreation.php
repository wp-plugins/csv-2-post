<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'recentupdateevents';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Recent Update Events');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Statistics of the most recent post update events');
$panel_array['panel_help'] = __('Post updating can be done automaticall and systematically, much of which is triggered simply by opening a page on your blog. These events happen without our knowledge so we need panels like this so we can check and ensure things are actually running smoothly.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);?>

<?php csv2post_panel_header( $panel_array );?>

<?php csv2post_panel_footer();?> 
