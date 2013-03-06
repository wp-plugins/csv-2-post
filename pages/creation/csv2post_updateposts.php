
<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'globalpostupdatesettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Global Post Updating Settings *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Configure how you want the plugin to handle post updating for all projects');
$panel_array['panel_help'] = __('This is a global panel, what you configure here will effect all projects.
You may need to visit other panels to complete the entire configuration involved in post updating i.e. save
settings on the Schedule screen and the Your Project page has a tab named Update Settings. That tab offers
settings on a per project basis. There is a lot of options to configure updating exactly how you need it. It can
all be a little confusing at first so please remember to click on the View More Help buttons.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialogbox_title'] = 'Save Global Post Updating Settings';
$jsform_set['noticebox_content'] = 'Your new post updating settings will apply to all of your projects, do you wish to continue?';
?>
    <?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <h4>Public Post Content Updating</h4>
    <p>Do you want the plugin to update posts as they are opened by visitors and do this outside of the schedule?</p>
    <script>
    $(function() {
        $( "#csv2post_globalpostupdatesettings_constantupdating_content" ).buttonset();
    });
    </script>

    <div id="csv2post_globalpostupdatesettings_constantupdating_content">
        <?php
        $template_value_on = 'checked';
        $template_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['public']) && $csv2post_project_array['updating']['content']['settings']['public'] == 'off'){
            $template_value_on = ''; 
            $template_value_off = 'checked';    
        }?>  
        <input type="radio" id="csv2post_constantcontentupdating_switch_on" name="csv2post_globalpostupdatesettings_constantupdating_content" value="1" <?php echo $template_value_on;?> /><label for="csv2post_constantcontentupdating_switch_on">Yes</label>
        <input type="radio" id="csv2post_constantcontentupdating_switch_off" name="csv2post_globalpostupdatesettings_constantupdating_content" value="0" <?php echo $template_value_off;?> /><label for="csv2post_constantcontentupdating_switch_off">No</label>            
    </div>

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
$panel_array['panel_name'] = 'updatespecificpost';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Update Specific Post');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Enter the post ID of any post to update it. The plugin will do all required 
checks to determine if the post was created by CSV 2 POST and if it has an active project. The term "active 
project" refers to the project settings still being in your blog. Updating will only have an effect if the 
posts record has been updated. Updating will also be done based on all related settings so that the outcome
is the same as if updating is being run on the schedule. This is a great tool for testing updating.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialogbox_title'] = 'Updating Post';
$jsform_set['noticebox_content'] = 'You are about to manually updating a single post based on your projects settings. Custom fields, SEO data and other meta data may be changed. Do you want to continue?';
// TODO: LOWPRIORITY, add a checkbox to allow user to save design for the mapping approach
// TODO: LOWPRIORITY, add the search box ability to the selectables lists
?>
    <?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <input type="text" name="csv2post_update_post_with_id" value="">
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
