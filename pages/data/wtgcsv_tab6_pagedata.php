<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'addcsvfilefolders';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Add CSV File Folder');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Add a new path to the plugins settings to make use of CSV files in that directory');
$panel_array['panel_help'] = __('CSV files within the folder you point the plugin too will be displayed on the plugins interface. At this time I need to ask users to ensure that CSV files in all directories have unique names. I have no yet decided how to handle duplicate file names in different directories as it is a low priority but has still been an issue in the past. If this is an issue for your project please let me know.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Add New CSV File Folder';
$jsform_set['noticebox_content'] = 'All CSV files in the folder being added will be displayed on the interface. Too many files may increase the plugins load speed a lot, do you wish to continue?';?>
<?php wtgcsv_panel_header( $panel_array );?> 

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');

    // TODO: HIGHPRIORITY: add a csv files folder, use ajax to check that path is correct and is not already stored in plugin
    //http://ocaoimh.ie/2008/11/01/make-your-wordpress-plugin-talk-ajax/
    ?>
   
    <input type="text" name="wtgcsv_addcsvfilepath" size="50" />
    <br />
             
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

 <?php wtgcsv_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'deletecsvfilefolders';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Remove CSV File Folder');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Remove a stored path so that the folders contents are no longer included by the plugin');
$panel_array['panel_help'] = __('Remove the folder and path from the plugins settings. This will not delete the folder or its contents.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Remove CSV File Folder';
$jsform_set['noticebox_content'] = 'If any projects are using a CSV file within the folder, this operation could damage the project. Do you wish to continue?';?>
<?php wtgcsv_panel_header( $panel_array );?> 

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');

    // TODO: HIGHPRIORITY: delete stored paths too csv files folder, use ajax to display if path is found or not and if it actually exists in stored array
    //http://ocaoimh.ie/2008/11/01/make-your-wordpress-plugin-talk-ajax/
    ?>

    <input type="text" name="wtgcsv_addcsvfilepath" size="50" />
    <br />
             
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

<?php wtgcsv_panel_footer();?>