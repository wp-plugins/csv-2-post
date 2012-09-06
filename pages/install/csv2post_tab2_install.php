<?php      
// include premium services status panel
include(WTG_C2P_PANELFOLDER_PATH.'premiumservicesstatus'.'.php');   

++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'optionrecordsstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Critical Option Records (settings) Status');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'View the status of option records and database tables';
$panel_array['panel_help'] = 'Wordpress allows us to store settings/options in the options table. Multiple option values can be held in a single record. This panel allows us to quickly view the status of individual option records and any database tables your current configuration requires.';
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);?>
<?php csv2post_panel_header( $panel_array );?>
    <?php csv2post_install_optionstatus_list();?>
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'optionrecordtrace';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Option Record Trace');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Displays all records in the Wordpress options table created by CSV 2 POST';
$panel_array['panel_help'] = 'This feature does a search for records that begin with "csv2post_". We can use it to fully cleanup the Wordpress option table.'; 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
### TODO:MEDIUMPRIORITY, merge the critical options record panel with this sort of, display option record 
### notifications in a table, also add columns for displaying smaller notifications indicating important and status
?>
<?php csv2post_panel_header( $panel_array );?>
    <?php csv2post_display_optionrecordtrace(); ?>       
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'contentfolderstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Content Folder Status');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Status of the folder created to store CSV files within the Wordpress content directory';
$panel_array['panel_help'] = 'It is important that CSV files are not stored within the plugins own folder, currently named '.WTG_C2P_FOLDERNAME.' in order to prevent deletion of files. The plugin allows you to store CSV files in custom file paths but the default path and folder is created when installing '.WTG_C2P_PLUGINTITLE.'. The folder should be named '.WTG_C2P_CONTENTFOLDER_DIR.' and you will find it in the wp-content folder. If it is missing for any reason, you may create it manually.'; 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);?>
<?php csv2post_panel_header( $panel_array );?>
    <?php csv2post_contentfolder_display_status(); ?>       
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'logfilesstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Log Files Status');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Check what files exist or not and the log recording status.';
$panel_array['panel_help'] = 'Log files are not required for the plugin to operate but they can help you monitor your projects activity or for troubleshooting should your project settings not be as you need them yet. '.WTG_C2P_PLUGINTITLE.' has multiple log files, each containing rows of information from different aspects of the plugin. You do not need to have all of them active or any of them. Some may not mean a lot to you especially if your not a developer i.e. the sql log file. These files are great for sending by email when requesting support.';
$panel_array['help_button'] = csv2post_helpbutton_text(false,false); 
?>
<?php csv2post_panel_header( $panel_array );?>
    <?php csv2post_logfile_exists_notice('general');?>
    <?php csv2post_logfile_exists_notice('sql');?>
    <?php csv2post_logfile_exists_notice('admin');?>
    <?php csv2post_logfile_exists_notice('user');?>
    <?php csv2post_logfile_exists_notice('error');?>
<?php csv2post_panel_footer();?> 