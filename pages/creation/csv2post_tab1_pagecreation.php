<?php 
// display messages regarding schedule to give users a quick idea of the current configuration
// this helps to avoid users being confused over why nothing may have happened in any hour or day
csv2post_schedulescreen_notices();
?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'eventsstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Events Status *global panel*');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Details of the last event and actions during the event (times are set by your server)');
$panel_array['panel_help'] = __('Many different types of actions can happen during events but there is only one action per event. There is normally many events, depending on user configuration of the permitted days and hours. This panel tells us if things are running smothly and helps us test the schedule. With this panel we can see that automated things are actually happening without having to check posts, categories, twitter plugins, the database, widgets etc');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
$panel_array['panel_state'] = 1;?>
<?php csv2post_panel_header( $panel_array );?>

    <h4>Events Counter - 60 Minute Period</h4>
    <p>
    <?php 
    if(isset($csv2post_schedule_array['history']['hourcounter'])){
        echo $csv2post_schedule_array['history']['hourcounter']; 
    }else{
        echo 'No events have been done during the current 60 minute period';    
    }?>
    </p> 

    <h4>Events Counter - 24 Hour Period</h4>
    <p>
    <?php 
    if(isset($csv2post_schedule_array['history']['daycounter'])){
        echo $csv2post_schedule_array['history']['daycounter']; 
    }else{
        echo 'No events have been done during the current 24 hour period';    
    }?>
    </p>

    <h4>Last Event Type</h4>
    <p>
    <?php 
    if(isset($csv2post_schedule_array['history']['lasteventtype'])){
        
        if($csv2post_schedule_array['history']['lasteventtype'] == 'dataimport'){
            echo 'Data Import';            
        }elseif($csv2post_schedule_array['history']['lasteventtype'] == 'dataupdate'){
            echo 'Data Update';
        }elseif($csv2post_schedule_array['history']['lasteventtype'] == 'postcreation'){
            echo 'Post Creation';
        }elseif($csv2post_schedule_array['history']['lasteventtype'] == 'postupdate'){
            echo 'Post Update';
        }elseif($csv2post_schedule_array['history']['lasteventtype'] == 'twittersend'){
            echo 'Twitter: New Tweet';
        }elseif($csv2post_schedule_array['history']['lasteventtype'] == 'twitterupdate'){
            echo 'Twitter: Send Update';
        }elseif($csv2post_schedule_array['history']['lasteventtype'] == 'twitterget'){
            echo 'Twitter: Get Reply';
        }
         
    }else{
        echo 'No events have been carried out yet';    
    }?>
    </p>

    <h4>Last Event Action</h4>
    <p>
    <?php 
    if(isset($csv2post_schedule_array['history']['lasteventaction'])){
        echo $csv2post_schedule_array['history']['lasteventaction']; 
    }else{
        echo 'No event actions have been carried out yet';    
    }?>
    </p>
        
    <h4>Last Event Time</h4>
    <p>
    <?php 
    if(isset($csv2post_schedule_array['history']['lasteventtime'])){
        echo date("F j, Y, g:i a",$csv2post_schedule_array['history']['lasteventtime']); 
    }else{
        echo 'No schedule events have ran on this server yet';    
    }?>
    </p>

    <h4>Last Refusal Reason</h4>
    <p>
    <?php 
    if(isset($csv2post_schedule_array['history']['lastreturnreason'])){
        echo $csv2post_schedule_array['history']['lastreturnreason']; 
    }else{
        echo 'No event refusal reason has been set yet';    
    }?>
    </p>
    
    <h4>Last Hourly Reset</h4>
    <p>
    <?php 
    if(isset($csv2post_schedule_array['history']['hour_lastreset'])){
        echo date("F j, Y, g:i a",$csv2post_schedule_array['history']['hour_lastreset']); 
    }else{
        echo 'No hourly reset has been done yet';    
    }?>
    </p>   
        
    <h4>Last 24 Hour Period Reset</h4>
    <p>
    <?php 
    if(isset($csv2post_schedule_array['history']['day_lastreset'])){
        echo date("F j, Y, g:i a",$csv2post_schedule_array['history']['day_lastreset']); 
    }else{
        echo 'No 24 hour reset has been done yet';    
    }?>
    </p> 
       
    <h4>Your Servers Current Data and Time</h4>
    <p><?php echo date("F j, Y, g:i a",time());?></p>
    
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'dripfeedprojects';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Drip Feed Projects *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Assign or remove a projects drip feed status');
$panel_array['panel_help'] = __('Setup projects for drip feeding by moving projects into the Drip Feeding list.
CSV 2 POST will then include that project in the automated process of creating posts at the rate
set within schedule parameters. The schedule is global meaning it will continue running in the same way no matter
how many projects you setup for post drip feeding. Project settings allow you to determine how many posts are created 
per hour. The plugin can do them all at once or try to spread them out through the hour in increments of 1 minute gaps.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialogbox_title'] = 'Saving Drip Feed Status';
$jsform_set['noticebox_content'] = 'You are about to stop or start drip feeding for the selected projects, posts may be created automatically, do you wish to continue?';
// TODO: LOWPRIORITY, add a checkbox to allow user to save design for the mapping approach
// TODO: LOWPRIORITY, add the search box ability to the selectables lists
?>
    <?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php 
    if(!isset($csv2post_projectslist_array) || $csv2post_projectslist_array == false){
        
        echo '<strong>You do not have any projects</strong>';
            
    }else{?>
    
        <script type="text/javascript">
         $(function(){
            $('#csv2post_multiselect_dripfeedprojectsactivation').multiSelect({
                      selectableHeader : '<h3>Manual Only</h3>',
                      selectedHeader : '<h3>Drip Feeding</h3>'
            });
         });
        </script>
                
        <div id="csv2post_multiselect_dripfeedprojectsactivation">
        <?php ### TODO:CRITICAL, this select has two ID?>
            <select multiple='multiple' id="listtestid" id="csv2post_multiselect_dripfeedprojectsactivation" name="csv2post_dripfeedprojects_list[]">
                <?php     
                global $csv2post_projectslist_array;
                foreach($csv2post_projectslist_array as $project_code => $project){
                    
                    $selected = '';
                    if(isset($csv2post_projectslist_array[$project_code]['dripfeeding']) && $csv2post_projectslist_array[$project_code]['dripfeeding'] == 'on'){$selected = 'selected="selected"';}
                    echo '<option value="'.$project_code.'" '.$selected.'>'.$project['name'].'</option>';
                        
                }         
                ?> 
            </select>
        </div>
        
    <?php 
    }?>    

     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>