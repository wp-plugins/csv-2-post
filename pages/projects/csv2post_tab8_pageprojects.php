<?php     
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'postcontentupdatingsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Post Content Updating Settings');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select your project settings for updating post content, this does not perform the update motions');
$panel_array['panel_help'] = __('Please use the Your Creation page for actual updating processing. This panel allows you to configure how CSV 2 POST should deal with changed records being used by this project.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Save Post Content Update Configuration';
$jsform_set['noticebox_content'] = 'Do you want to change your projects content updating settings, this will take effect straight away whenever updating is processed?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h4>Post Updating Switch</h4>
    <p>Will you be updating your projects data and want to update posts with newer records? This switch will include post updating events in the schedule. You should configure the Schedule Settings to suit your needs.</p>
    <script>
    $(function() {
        $( "#csv2post_updatesettings_postupdating_switch_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_updatesettings_postupdating_switch_objectid"><?php
        $switch_value_on = 'checked';
        $switch_value_off = '';  
        if(isset($csv2post_project_array['updating']['content']['settings']['switch']) && $csv2post_project_array['updating']['content']['settings']['switch'] == 'off'){
            $switch_value_on = '';
            $switch_value_off = 'checked';    
        }?>
        <input type="radio" id="csv2post_postupdating_switch_on" name="csv2post_updatesettings_postupdating_switch_inputname" value="on" <?php echo $switch_value_on;?> /><label for="csv2post_postupdating_switch_on">Yes</label>
        <input type="radio" id="csv2post_postupdating_switch_off" name="csv2post_updatesettings_postupdating_switch_inputname" value="off" <?php echo $switch_value_off;?> /><label for="csv2post_postupdating_switch_off">No</label>            
    </div>                                                  
    
    
    <h4>Automatic Public Updating</h4>
    <p>Do you want to update posts with new records automatically as they are being opened for viewing on the public and admin side? We can update a post as it is being opened, creating more work for Wordpress but it is hardly noticed.</p>
    <script>
    $(function() {
        $( "#csv2post_updatesettings_postupdating_public_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_updatesettings_postupdating_public_objectid">
        <?php
        $public_value_on = 'checked';
        $public_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['public']) && $csv2post_project_array['updating']['content']['settings']['public'] == 'off'){
            $public_value_on = '';
            $public_value_off = 'checked';    
        }?>    
        <input type="radio" id="csv2post_postupdating_public_on" name="csv2post_updatesettings_postupdating_public_inputname" value="on" <?php echo $public_value_on;?> /><label for="csv2post_postupdating_public_on">Yes</label>
        <input type="radio" id="csv2post_postupdating_public_off" name="csv2post_updatesettings_postupdating_public_inputname" value="off" <?php echo $public_value_off;?> /><label for="csv2post_postupdating_public_off">No</label>            
    </div>

    <h4>Apply New Content Templates Automatically</h4>
    <p>Requires "Post Updating Switch" to be on. Switching this on will make the plugin re-build post content using updated content templates.</p>
    <script>
    $(function() {
        $( "#csv2post_updatesettings_postupdating_template_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_updatesettings_postupdating_template_objectid">
        <?php
        $template_value_on = 'checked';
        $template_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['public']) && $csv2post_project_array['updating']['content']['settings']['public'] == 'off'){
            $template_value_on = ''; 
            $template_value_off = 'checked';    
        }?>    
        <input type="radio" id="csv2post_postupdating_template_on" name="csv2post_updatesettings_postupdating_template_inputname" value="on" <?php echo $template_value_on;?> /><label for="csv2post_postupdating_template_on">Yes</label>
        <input type="radio" id="csv2post_postupdating_template_off" name="csv2post_updatesettings_postupdating_template_inputname" value="off" <?php echo $template_value_off;?> /><label for="csv2post_postupdating_template_off">No</label>            
    </div>    
    
    <h4>Prioritize Page Load Speed</h4>
    <p>Do you want to prioritize page load speed over delivering new content while public updating is active?</p>
    <script>
    $(function() {
        $( "#csv2post_updatesettings_postupdating_speed_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_updatesettings_postupdating_speed_objectid">
        <?php
        $speed_value_on = 'checked';
        $speed_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['speed']) && $csv2post_project_array['updating']['content']['settings']['speed'] == 'off'){
            $speed_value_on = ''; 
            $speed_value_off = 'checked';    
        }?>    
        <input type="radio" id="csv2post_postupdating_speed_on" name="csv2post_updatesettings_postupdating_speed_inputname" value="on" <?php echo $speed_value_on;?> /><label for="csv2post_postupdating_speed_on">Yes</label>
        <input type="radio" id="csv2post_postupdating_speed_off" name="csv2post_updatesettings_postupdating_speed_inputname" value="off" <?php echo $speed_value_off;?> /><label for="csv2post_postupdating_speed_off">No</label>            
    </div>

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>  

<?php
### TODO:CRITICAL, this panel is still to be complete and form processing created
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'customfieldupdatingsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Custom Field Updating Settings');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('You can update custom fields and do so on a different schedule from post content updating');
$panel_array['panel_help'] = __('Some users may want to update meta data for posts and never update post content. These settings allow that to be possible. We can add meta data to our post content using shortcodes with the result appearing as if specific content parts are being updated. I should make it clear that these updates, come from the database. CSV 2 POST updates a projects tables first, before doing anything else with it. This allows us to reverse changes, monitor data better and perform other features unique among data import plugins for Wordpress.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Save Custom Field Update Configuration';
$jsform_set['noticebox_content'] = 'Do you want to change your projects custom field updating settings, this will take effect straight away?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>
    
    <p>This panel was added 23th June 2012 and is still under construction.</p> 

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>  

<?php ### TODO: MEDIUMPRIORITY, panel for updating other (titles,publish date) ?>

<?php
if(!$csv2post_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = array();
    $panel_array['panel_name'] = 'postupdatingarraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Post Updating Array Dump');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
    $panel_array['tabnumber'] = $csv2post_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('Dump of arrays related to post updating (including meta data)');
    $panel_array['panel_help'] = __('This array dump shows the stored settings for things like public post updating and the ability to update specific custom fields.');
    $panel_array['help_button'] = csv2post_helpbutton_text(false,true);?>
    <?php csv2post_panel_header( $panel_array );?>
        
        <h4>Entire Array</h4>
        <?php if(isset($csv2post_project_array)){csv2post_var_dump($csv2post_project_array);}else{echo 'No array stored';} ?>
                
    <?php csv2post_panel_footer();
}?> 
