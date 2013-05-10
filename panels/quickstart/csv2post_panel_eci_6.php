<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreeconfirmformat';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 6: SEO');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );
csv2post_n_incontent('We provide intelligent SEO forms and functionality such as text spinning which
helps to generate unique content for high Google ranking. These services are provided in our 
premium package.','success','Small','Premium step');
csv2post_panel_footer();?>
