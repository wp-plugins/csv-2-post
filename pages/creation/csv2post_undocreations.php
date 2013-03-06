<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'undopostscurrentproject';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Undo Posts: Current Project');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Delete posts and reset their records in project database tables');
$panel_array['panel_help'] = __('Not only deletes posts for the current project but statistics
and other counters are reset. This allows us to run post creation again, important if we find we need
to change the projects configuration.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Delete Projects Posts';
$jsform_set['noticebox_content'] = 'You are about to delete project posts, possibly on a mass scale. Do you want to continue?';?>

<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 

    <?php 
    ### TODO:MEDIUMPRIORITY, add date range and update processing function to use it
    ?>

    <?php if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }?>
        
    <?php csv2post_formend_standard('Delete Posts',$jsform_set['form_id']);?>
                
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'undocategoriescurrentproject';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Undo Categories: Current Project');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('This undo tool will delete all categories created using the current project.
It does this by querying the category ID that have been stored in the csv2post_catid column in the project
database table. Once the process is complete, all values in the csv2post_catid column are deleted also. This
allows us to run category creation again.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Delete Projects Categories';
$jsform_set['noticebox_content'] = 'You are about to delete project categories. Do you want to continue?';?>

<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 

    <?php 
    // TODO:LOWPRIORITY, add some information about the categories created for the current project else indicate none created
    ?>
    
    <?php if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }?>
        
    <?php csv2post_formend_standard('Delete Categories',$jsform_set['form_id']);?>
                
<?php csv2post_panel_footer();?> 