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
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Save Post Content Update Configuration';
$jsform_set['noticebox_content'] = 'Do you want to change your projects content updating settings, this will take effect straight away whenever updating is processed?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h4>Post Updating Switch</h4>
    <p>Will you be updating your projects data and want to update posts with changed records?</p>
    <script>
    $(function() {
        $( "#csv2post_updatesettings_postupdating_switch_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_updatesettings_postupdating_switch_objectid">
        <?php
        $switch_value_on = '';
        $switch_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['switch']) && $csv2post_project_array['updating']['content']['settings']['switch'] == 'on'){
            $switch_value_on = 'checked'; 
        }else{
            $switch_value_off = 'checked';    
        }?>
        <input type="radio" id="csv2post_postupdating_switch_on" name="csv2post_updatesettings_postupdating_switch_inputname" value="on" <?php echo $switch_value_on;?> /><label for="csv2post_postupdating_switch_on">Yes</label>
        <input type="radio" id="csv2post_postupdating_switch_off" name="csv2post_updatesettings_postupdating_switch_inputname" value="off" <?php echo $switch_value_off;?> /><label for="csv2post_postupdating_switch_off">No</label>            
    </div>
    
    
    <h4>Automatic Public Updating</h4>
    <p>Do you want to update posts automatically as they are being opened for viewing on the public side?</p>
    <script>
    $(function() {
        $( "#csv2post_updatesettings_postupdating_public_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_updatesettings_postupdating_public_objectid">
        <?php
        $switch_value_on = '';
        $switch_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['public']) && $csv2post_project_array['updating']['content']['settings']['public'] == 'on'){
            $public_value_on = 'checked'; 
        }else{
            $public_value_off = 'checked';    
        }?>    
        <input type="radio" id="csv2post_postupdating_public_on" name="csv2post_updatesettings_postupdating_public_inputname" value="on" <?php echo $public_value_on;?> /><label for="csv2post_postupdating_public_on">Yes</label>
        <input type="radio" id="csv2post_postupdating_public_off" name="csv2post_updatesettings_postupdating_public_inputname" value="off" <?php echo $public_value_off;?> /><label for="csv2post_postupdating_public_off">No</label>            
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
        $switch_value_on = '';
        $switch_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['speed']) && $csv2post_project_array['updating']['content']['settings']['speed'] == 'on'){
            $speed_value_on = 'checked'; 
        }else{
            $speed_value_off = 'checked';    
        }?>    
        <input type="radio" id="csv2post_postupdating_speed_on" name="csv2post_updatesettings_postupdating_speed_inputname" value="on" <?php echo $speed_value_on;?> /><label for="csv2post_postupdating_speed_on">Yes</label>
        <input type="radio" id="csv2post_postupdating_speed_off" name="csv2post_updatesettings_postupdating_speed_inputname" value="off" <?php echo $speed_value_off;?> /><label for="csv2post_postupdating_speed_off">No</label>            
    </div>
 
    <h4>Backup Old Content</h4>
    <p>Do you want to backup old content?</p>
    <script>
    $(function() {
        $( "#csv2post_updatesettings_postupdating_old_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_updatesettings_postupdating_old_objectid">
        <?php
        $switch_value_on = '';
        $switch_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['old']) && $csv2post_project_array['updating']['content']['settings']['old'] == 'on'){
            $old_value_on = 'checked'; 
        }else{
            $old_value_off = 'checked';    
        }?>    
        <input type="radio" id="csv2post_postupdating_old_on" name="csv2post_updatesettings_postupdating_old_inputname" value="on" <?php echo $old_value_on;?> /><label for="csv2post_postupdating_old_on">Yes</label>
        <input type="radio" id="csv2post_postupdating_old_off" name="csv2post_updatesettings_postupdating_old_inputname" value="off" <?php echo $old_value_off;?> /><label for="csv2post_postupdating_old_off">No</label>            
    </div>

    <h4>Backup Old Content Method</h4>
    <p>Do you want to backup old content?</p>
    <script>
    $(function() {
        $( "#csv2post_updatesettings_postupdating_oldmethod_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_updatesettings_postupdating_oldmethod_objectid">
        <?php
        $switch_value_on = '';
        $switch_value_off = '';
        if(isset($csv2post_project_array['updating']['content']['settings']['oldmethod']) && $csv2post_project_array['updating']['content']['settings']['oldmethod'] == 'on'){
            $oldmethod_value_on = 'checked'; 
        }else{
            $oldmethod_value_off = 'checked';    
        }?>    
        <input type="radio" id="csv2post_postupdating_oldmethod_on" name="csv2post_updatesettings_postupdating_oldmethod_inputname" value="customfield" <?php echo $old_value_on;?> /><label for="csv2post_postupdating_oldmethod_on">Custom Field</label>
        <input type="radio" id="csv2post_postupdating_oldmethod_off" name="csv2post_updatesettings_postupdating_oldmethod_inputname" value="projecttable" <?php echo $old_value_off;?> /><label for="csv2post_postupdating_oldmethod_off">Project Database Table</label>            
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
