<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'importdatahistory';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Import Data History');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('A record of import events and actions taking by admin record importing data');
$panel_array['panel_help'] = __('If you manually import records, the events details will be logged in one of the plugins .txt log files. The plugin extracts the log entries related to data import then displays the latest here. This panel is for quick reference of the most recent actions and events. It will also display a general outcome although the complexity of your projects settings will now show in the statistics within log messages.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);?>
<?php csv2post_panel_header( $panel_array );?> 

    <p>This feature has not yet been requested by a user and so is still in testing due to it being low priority.</p>
    
    <?php echo csv2post_notice( '98 Rows Imported Successfully From filexample.csv','success','Tiny','','','return');?>
    <?php echo csv2post_notice( '1 Row Import Failure fileexample.csv','error','Tiny','','','return');?>
    <?php echo csv2post_notice( '1 Row Import Warning: your data import rules have blackmarked the row','warning','Tiny','','','return');?>
    <?php echo csv2post_notice( '2000 Rows Imported Successfully','success','Tiny','','','return');?> 
    <?php echo csv2post_notice( '677 Rows Imported Successfully','success','Tiny','','','return');?> 

<?php csv2post_panel_footer();?>