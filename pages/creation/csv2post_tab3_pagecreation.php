<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'undoposts';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Undo Posts');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Delete posts and reset their records in project database tables');
$panel_array['panel_help'] = __('A big purpose of the undo ability is to reverse changes made during testing.
It makes testing far easier because project database tables and project history is also reversed. Essentially
bring projects back to their original state. Be aware that this feature was added 30th August 2012. There is a lot
of changes that happen in Wordpress when creating posts. Tags and other post meta values may not be reversed at this
time. Please remind us if you need further ability on this undo screen.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Delete Projects Posts';
$jsform_set['noticebox_content'] = 'You are about to delete project posts, possibly on a mass scale. Do you want to continue?';
// TODO:MEDIUMPRIORITY, add optional date criteria to restrict deletion to a publish date range ?>

<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <script>
    $(function() {
        $( "#csv2post_undo" ).buttonset();
    });
    </script>

    <div id="csv2post_undo">
        <input type="radio" id="csv2post_undo_currentproject" name="csv2post_undo" value="currentproject" /><label for="csv2post_undo_currentproject">Current Project</label> 
        <input type="radio" id="csv2post_undo_allprojects" name="csv2post_undo" value="allprojects" /><label for="csv2post_undo_allprojects">All Projects</label>
    </div>
    
    <?php /* TODO:LOWPRIORITY, allow different ranges for quickly rolling back recently created posts but not all
    <div id="csv2post_undo">
        <h4>100% Undo</h4>
        <input type="radio" id="csv2post_undo_currentproject" name="csv2post_undo" value="currentproject" /><label for="csv2post_undo_currentproject">Current Project</label> 
        <input type="radio" id="csv2post_undo_allprojects" name="csv2post_undo" value="allprojects" /><label for="csv2post_undo_allprojects">All Projects</label>
        
        <h4>Current Project Partial Reversal</h4>
        <input type="radio" id="csv2post_undo_last10minutes" name="csv2post_undo" value="last10minutes" /><label for="csv2post_undo_last10minutes">Last 10 Minutes</label>        
        <input type="radio" id="csv2post_undo_last60minutes" name="csv2post_undo" value="last60minutes" /><label for="csv2post_undo_last60minutes">Last 60 Minutes</label>
        <input type="radio" id="csv2post_undo_last24hours" name="csv2post_undo" value="last24hours" /><label for="csv2post_undo_last24hours">Last 24 Hours</label>
    </div>  */
    ?>  
    
     <?php 
    // add js for dialogue on form submission and the dialogue <div> itself
    if(csv2post_SETTINGS_form_submit_dialogue($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
                
<?php csv2post_panel_footer();?> 