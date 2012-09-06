<?php
// include jQuery for portlets
wtgcsv_jquery_status_list_portlets();

++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'corefilesstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Core Files Status');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Click on the icons to open the portlets and view more information about a file');
$panel_array['panel_help'] = __('Most of the plugins core files and folders can be found in this list. A red bar (default is green) indicates that a file cannot be found, this should be investigated.'); 
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);
?>
<?php wtgcsv_panel_header( $panel_array );?>

    <?php wtgcsv_templatefiles_statuslist();?>

<?php wtgcsv_panel_footer();?> 