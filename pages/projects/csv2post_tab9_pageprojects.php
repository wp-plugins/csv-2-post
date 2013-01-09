<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'featuredimages';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Featured Images');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Configure featured images if required');
$panel_array['panel_help'] = __('This feature has not been added yet. If you are interested in it being added please feel free to provide feedback on any very unique abilities you would like to be considered before development begins on this panel.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
// TODO: add ability to crop images by trimming all sides not just one side and bottom or top.
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Save Featured Image Settings';
$jsform_set['noticebox_content'] = 'Your changes will take effect on all posts created afterwards. Do you want to continue saving?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <p>        
        Table Column: 
        <select name="csv2post_featuredimage_columnandtable" id="csv2post_featuredimage_columnandtable" class="csv2post_multiselect_menu">
            <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);?>                                                                                                                     
        </select>
    </p>
    
    <script>
    $("#csv2post_featuredimage_columnandtable").multiselect({
       multiple: false,
       header: "Select Database Column (table - column)",
       noneSelectedText: "Select Database Table",
       selectedList: 1
    });
    </script>
    
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?> 
