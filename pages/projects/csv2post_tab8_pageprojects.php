<?php     
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'postcontentupdatingsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Post Content Updating Settings');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique 
$panel_array['panel_help'] = __('Please use the Your Creation page for actual updating processing. This panel allows you to configure how CSV 2 POST should deal with changed records being used by this project.');
$panel_array['video'] = 'http://www.youtube.com/embed/5Dm-LbywiE0';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Save Post Content Update Configuration';
$jsform_set['noticebox_content'] = 'Do you want to change your projects content updating settings, this will take effect straight away whenever updating is processed?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <?php csv2post_formobjects_postupdate_options();?>

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
if(!$csv2post_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'postupdatingarraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Post Updating Array Dump');// user seen panel header text  
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('This array dump shows the stored settings for things like public post updating and the ability to update specific custom fields.');?>
    <?php csv2post_panel_header( $panel_array );?>
        
        <h4>Entire Array</h4>
        <?php if(isset($csv2post_project_array)){csv2post_var_dump($csv2post_project_array);}else{echo 'No array stored';} ?>
                
    <?php csv2post_panel_footer();
}?> 
