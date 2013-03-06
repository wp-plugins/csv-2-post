<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'addcsvfilefolders';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Add CSV File Folder');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Add a new path to the plugins settings to make use of CSV files in that directory');
$panel_array['panel_help'] = __('CSV files within the folder you point the plugin to will be displayed on the plugins interface. At this time I need to ask users to ensure that CSV files in all directories have unique names. I have no yet decided how to handle duplicate file names in different directories as it is a low priority but has still been an issue in the past. If this is an issue for your project please let me know.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Add New CSV File Folder';
$jsform_set['noticebox_content'] = 'All CSV files in the folder being added will be displayed on the interface. Too many files may increase the plugins load speed a lot, do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php 
    // TODO: HIGHPRIORITY: add a csv files folder, use ajax to check that path is correct and is not already stored in plugin
    //http://ocaoimh.ie/2008/11/01/make-your-wordpress-plugin-talk-ajax/
    ?>
   
    <input type="text" name="csv2post_addcsvfilepath" size="50" />
    <br />
             
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

 <?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'deletecsvfilefolders';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Remove CSV File Folder');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Remove the folder and path from the plugins settings. This will not delete the folder or its contents.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Remove CSV File Folder';
$jsform_set['noticebox_content'] = 'If any projects are using a CSV file within the folder, this operation could damage the project. Do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php 
    // TODO: HIGHPRIORITY: delete stored paths to csv files folder, use ajax to display if path is found or not and if it actually exists in stored array
    //http://ocaoimh.ie/2008/11/01/make-your-wordpress-plugin-talk-ajax/
    ?>

    <input type="text" name="csv2post_addcsvfilepath" size="50" />
    <br />
             
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>