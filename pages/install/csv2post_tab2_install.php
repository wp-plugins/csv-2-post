<?php      
// include premium services status panel
if(!$csv2post_is_free){include(WTG_C2P_PANELFOLDER_PATH.'premiumservicesstatus'.'.php');}

++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'optionrecordtrace';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Option Record Trace');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Displays all records in the Wordpress options table created by CSV 2 POST';
$panel_array['panel_help'] = 'This feature does a search for records that begin with "csv2post_". We can use it to fully cleanup the Wordpress option table.'; 
### TODO:MEDIUMPRIORITY, merge the critical options record panel with this sort of, display option record 
### notifications in a table, also add columns for displaying smaller notifications indicating important and status
?>
<?php csv2post_panel_header( $panel_array );?>
    <?php csv2post_list_optionrecordtrace(); ?>       
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'contentfolderstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Content Folder Status');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = 'It is important that CSV files are not stored within the plugins own folder, currently named '.WTG_C2P_FOLDERNAME.' in order to prevent deletion of files. The plugin allows you to store CSV files in custom file paths but the default path and folder is created when installing '.$csv2post_plugintitle.'. The folder should be named '.WTG_C2P_CONTENTFOLDER_DIR.' and you will find it in the wp-content folder. If it is missing for any reason, you may create it manually.'; ?>
<?php csv2post_panel_header( $panel_array );?>
    <?php csv2post_contentfolder_display_status(); ?>       
<?php csv2post_panel_footer();?>