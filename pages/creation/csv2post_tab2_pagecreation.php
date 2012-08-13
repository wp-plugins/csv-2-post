<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'updatespecificpost';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Update Specific Post');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Enter the ID of a post you would like to update');
$panel_array['panel_help'] = __('Enter the post ID of any post to update it. The plugin will do all required checks to determine if the post was created by CSV 2 POST and if it has an active project. The term "active project" refers to the project settings still being in your blog. Updating will only have an effect if the posts record has been updated.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialoguebox_title'] = 'Updating Post';
$jsform_set['noticebox_content'] = 'You are about to manually updating a single post based on your projects settings. Custom fields, SEO data and other meta data may be changed. Do you want to continue?';
// TODO: LOWPRIORITY, add a checkbox to allow user to save design for the mapping approach
// TODO: LOWPRIORITY, add the search box ability too the selectables lists
?>
    <?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <input type="text" name="csv2post_update_post_with_id" value="">
    <br />

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>