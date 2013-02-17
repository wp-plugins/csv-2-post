<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'completionbar';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Completion Bar');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Use the links below to view posts created in your project named My Example Project');
$panel_array['panel_help'] = __('This panel allows you to quickly view specific posts created from any project. This is handy if you have multiple projects running at the same time and want to check what each project created.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
csv2post_panel_header( $panel_array );?>


<?php csv2post_panel_footer();?> 
