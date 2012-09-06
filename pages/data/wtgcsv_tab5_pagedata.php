<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'importdatahistory';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Import Data History');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('A record of import events and actions taking by admin record importing data');
$panel_array['panel_help'] = __('If you manually import records, the events details will be logged in one of the plugins .txt log files. The plugin extracts the log entries related too data import then displays the latest here. This panel is for quick reference of the most recent actions and events. It will also display a general outcome although the complexity of your projects settings will now show in the statistics within log messages.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(true,false);?>
<?php wtgcsv_panel_header( $panel_array );?> 

    <?php echo wtgcsv_notice('98 Rows Imported Successfully From filexample.csv','success','Tiny','','','return');?>
    <?php echo wtgcsv_notice('1 Row Import Failure fileexample.csv','error','Tiny','','','return');?>
    <?php echo wtgcsv_notice('1 Row Import Warning: your data import rules have blackmarked the row','warning','Tiny','','','return');?>
    <?php echo wtgcsv_notice('2000 Rows Imported Successfully','success','Tiny','','','return');?> 
    <?php echo wtgcsv_notice('677 Rows Imported Successfully','success','Tiny','','','return');?> 

<?php wtgcsv_panel_footer();?>