<?php
foreach($csv2post_file_profiles as $csvfile_name => $profile){
        
    $csvfile_name_cleaned = csv2post_clean_string($csvfile_name);
   
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = array();
    $panel_array['panel_name'] = 'fileprofile'.$csvfile_name_cleaned;// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Profile for ' . $csvfile_name);// user seen panel header text 
    $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
    $panel_array['tabnumber'] = $csv2post_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('Information about your file named ' . $csvfile_name);
    $panel_array['panel_help'] = __('We build a profile of information for each file for various purposes.');
    $panel_array['help_button'] = csv2post_helpbutton_text(false,true);
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
    $jsform_set['dialoguebox_title'] = 'Dele';
    $jsform_set['noticebox_content'] = 'Dect?';
    // TODO:MEDIUMPRIORITY,add option for default value for null data or option for custom field not to be added at all
    ?>
    <?php csv2post_panel_header( $panel_array );?>

        <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

        <h4>Current Modification Date</h4>
        <?php echo csv2post_date(0,$profile['currentmodtime']);?>
                
        <h4>Profile Updated</h4>
        <?php echo csv2post_date(0,$profile['profileupdated']);?> 
        
        <br />
        
        <?php
        // add the javascript that will handle our form action, prevent submission and display dialogue box
        //csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

        // add end of form - dialogue box does not need to be within the <form>
        //csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

        <?php //csv2post_jquery_form_prompt($jsform_set);?>

    <?php csv2post_panel_footer();
}    
?>
