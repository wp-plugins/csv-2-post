<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'corefilesstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Core Files Status');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Click on the icons to open the portletcsv2posts and view more information about a file');
$panel_array['panel_help'] = __('Most of the plugins core files and folders can be found in this list. A red bar (default is green) indicates that a file cannot be found, this should be investigated.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    csv2post_n_incontent('This panel has been disabled while the plugins files are re-structured. We consider
    this part of the diagnostic system and will be improving that system in general also.','info','Small','Temporary Disabled');
    
    //csv2post_templatefiles_statuslist();?>

<?php csv2post_panel_footer();?> 