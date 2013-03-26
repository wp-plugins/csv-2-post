<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createddatabasetableslist';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Delete Job Tables');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Delete one or more tables using this panel. This list also helps to monitor the number of tables created by the plugin. It indicates the rows inside each table to help remind us which are being used.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Delete Selected Database Tables';
$jsform_set['noticebox_content'] = 'Do you want to delete the selected database tables and lose all data they contain?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php csv2post_display_jobtables(true);?>
                       
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>

<?php if($csv2post_is_dev){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'jobtablearraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Data Import Job Table Array Dump');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('The purpose of this array is to track database tables created using CSV 2 POST. Users can delete a Data Import Job but that will not remove the database table. To help avoid major loss of data the action of deleting database tables has to be done on its own.');?>
    <?php csv2post_panel_header( $panel_array );?> 

         <pre><?php csv2post_var_dump($csv2post_jobtable_array);?></pre>

    <?php csv2post_panel_footer();
}?>
    
<h1>Imported Data Samples</h1>
<?php
// loop through all database tables created by the plugin and create a panel for each
if(!isset($csv2post_jobtable_array)){
    csv2post_n_incontent('You have not created or setup any Data Import Job tables. If you feel this is not true, please check the installation status and ensure the csv2post_jobtable_array option is installed.','info','Small');    
}elseif(!is_array($csv2post_jobtable_array)){
    csv2post_n_incontent('You have not created or setup any Data Import Job tables. Please create a Data Import Job then import data. You may then view a sample of that data here.','info','Small');
}elseif(count($csv2post_jobtable_array) == 0){
    csv2post_n_incontent('You have not created or setup any Data Import Job tables.','info','Small');    
}else{
    foreach($csv2post_jobtable_array as $key => $jt){

        ++$panel_number;// increase panel counter so this panel has unique ID
        $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
        $panel_array['panel_name'] = 'datasample'.$jt;// slug to act as a name and part of the panel ID 
        $panel_array['panel_title'] = __($jt);// user seen panel header text 
        $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
        $panel_array['panel_help'] = __('This panel shows the columns in your temporary database table,
        the same table that holds your CSV file rows as records once imported. This panel should show you
        a sample of your imported data. We can use this to determine that importing is a success. 
        You can use settings or hacks to configure what this sample of data displays. By default it will display the first 10 records.');?>
        <?php csv2post_panel_header( $panel_array );?> 

             <?php csv2post_display_sample_data($jt);?>

        <?php csv2post_panel_footer();
    }
}
?>
