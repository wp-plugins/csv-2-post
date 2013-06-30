<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'scheduletimes';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Schedule Times *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('The schedule system automates more than just post creation but the popular requirement is to auto-blog posts and pages. These settings/times are global and effect all projects with drip feeding applied above.');
$panel_array['video'] = 'http://www.youtube.com/embed/ngx6tVNCIck';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialogbox_title'] = 'Saving Schedule Times';
$jsform_set['noticebox_content'] = 'You are about to change the schedule times, do you want to continue?';
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 

    <h4><?php c2p_tt('Allowed Days','These settings can be used to make your auto-blogging more natural by decided which days auto-blogging does and does not happen on');?></h4>   
     
    <script>
    $(function() {
        $( "#csv2post_dripfeed_days_format" ).buttonset();
    });
    </script>
    
    <style>
    #csv2post_dripfeed_days_format { margin-top: 2em; }
    </style>

    <div id="csv2post_dripfeed_days_format">    
        <?php 
        $days_array = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
        $days_counter = 1;
        foreach($days_array as $key => $day){
            
            // set checked status
            if(isset($csv2post_schedule_array['days'][$day])){
                $day_checked = 'checked';
            }else{
                $day_checked = '';            
            }
                 
            echo '<input type="checkbox" name="csv2post_scheduleday_list[]" id="daycheck'.$days_counter.'" value="'.$day.'" '.$day_checked.' />
            <label for="daycheck'.$days_counter.'">'.ucfirst($day).'</label>'.csv2post_GUI_br();    
            ++$days_counter;
        }
        ?>
    </div>
    
    <h4><?php c2p_tt('Allowed Hours','Most people do not blog 24 hours a day, use these settings to make your blog appear more natural and avoid posting constantly while your sleeping');?></h4>    
    <script>
    $(function() {
        $( "#csv2post_dripfeed_hours_format" ).buttonset();
    });
    </script>
    <style>
    #csv2post_dripfeed_hours_format { margin-top: 2em; }
    </style>

    <div id="csv2post_dripfeed_hours_format">    
    <?php
    // loop 24 times and create a checkbox for each hour
    for($i=0;$i<24;$i++){
        
        // check if the current hour exists in array, if it exists then it is permitted, if it does not exist it is not permitted
        if(isset($csv2post_schedule_array['hours'][$i])){
            $hour_checked = ' checked'; 
        }else{
            $hour_checked = '';
        }
        
        echo '<input type="checkbox" name="csv2post_schedulehour_list[]" id="hourcheck'.$i.'"  value="'.$i.'" '.$hour_checked.' />
        <label for="hourcheck'.$i.'">'.$i.'</label>'.csv2post_GUI_nbsp().csv2post_GUI_nbsp();    
    }
    ?>                                                                                     
    </div>  
                       
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_promptdiv($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'schedulelimits';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Schedule Limits *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('These controls tell the plugin how many posts to create during a drip feed session. It is a quick and easy approach to applying the rate of post creation. The plugin strictly avoids going over limits, this is considered higher priority than reaching the limit. The plugin will only begin a drip feed session when someone visits the blog; Wordpress loading triggers the schedule to be checked. The plugin will avoid doing this too often so that users do not get a negative experience. A cooldown between drip feed sessions also helps to avoid triggering server problems and using up too much bandwidth within a very short time which can also cause hosting to raise concerns.');
$panel_array['video'] = 'http://www.youtube.com/embed/PR99KwLB4b4';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Save Drip Feeding Limits';
$jsform_set['noticebox_content'] = 'These are global settings and will take effect on all projects straight away. Do you wish to continue?';
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 

    <h4><?php c2p_tt('Maximum Per Day','This controls the maximum posts created and update per day. We have predefined daily limits for speed but they are easily cutomized should you need more specific limits');?></h4>
    <script>
    $(function() {
        $( "#csv2post_dripfeedrate_maximumperday" ).buttonset();
    });
    </script>

    <div id="csv2post_dripfeedrate_maximumperday">
        <input type="radio" id="csv2post_radio1_dripfeedrate_maximumperday" name="day" value="1" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_dripfeedrate_maximumperday"> 1 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio2_dripfeedrate_maximumperday" name="day" value="5" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 5){echo 'checked';} ?> /><label for="csv2post_radio2_dripfeedrate_maximumperday"> 5 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio3_dripfeedrate_maximumperday" name="day" value="10" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 10){echo 'checked';} ?> /><label for="csv2post_radio3_dripfeedrate_maximumperday"> 10 </label><?php csv2post_GUI_nbsp();?>  
        <input type="radio" id="csv2post_radio9_dripfeedrate_maximumperday" name="day" value="24" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 24){echo 'checked';} ?> /><label for="csv2post_radio9_dripfeedrate_maximumperday"> 24 </label><?php csv2post_GUI_nbsp();?>                    
        <input type="radio" id="csv2post_radio4_dripfeedrate_maximumperday" name="day" value="50" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 50){echo 'checked';} ?> /><label for="csv2post_radio4_dripfeedrate_maximumperday"> 50 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio5_dripfeedrate_maximumperday" name="day" value="250" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 250){echo 'checked';} ?> /><label for="csv2post_radio5_dripfeedrate_maximumperday"> 250 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio6_dripfeedrate_maximumperday" name="day" value="1000" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 1000){echo 'checked';} ?> /><label for="csv2post_radio6_dripfeedrate_maximumperday"> 1000 </label><?php csv2post_GUI_nbsp();?>                                                                                                                       
        <input type="radio" id="csv2post_radio7_dripfeedrate_maximumperday" name="day" value="2000" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 2000){echo 'checked';} ?> /><label for="csv2post_radio7_dripfeedrate_maximumperday"> 2000 </label><?php csv2post_GUI_nbsp();?> 
        <input type="radio" id="csv2post_radio8_dripfeedrate_maximumperday" name="day" value="5000" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 5000){echo 'checked';} ?> /><label for="csv2post_radio8_dripfeedrate_maximumperday"> 5000 </label><?php csv2post_GUI_nbsp();?>   
    </div>
                
    <h4><?php c2p_tt('Maximum Per Hour','The hourly limit helps to control processing a little more especially in busy Wordpress sites. This is a strict limit, not a goal and neither is the daily limit. The plugin will not try to reach your daily number if the hourly limit number is lower per 24 hours than your daily limit');?></h4>
    <script>
    $(function() {
        $( "#csv2post_dripfeedrate_maximumperhour" ).buttonset();
    });
    </script>

    <div id="csv2post_dripfeedrate_maximumperhour">
        <input type="radio" id="csv2post_radio1_dripfeedrate_maximumperhour" name="hour" value="1" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_dripfeedrate_maximumperhour"> 1 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio2_dripfeedrate_maximumperhour" name="hour" value="5" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 5){echo 'checked';} ?> /><label for="csv2post_radio2_dripfeedrate_maximumperhour"> 5 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio3_dripfeedrate_maximumperhour" name="hour" value="10" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 10){echo 'checked';} ?> /><label for="csv2post_radio3_dripfeedrate_maximumperhour"> 10 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio9_dripfeedrate_maximumperhour" name="hour" value="24" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 24){echo 'checked';} ?> /><label for="csv2post_radio9_dripfeedrate_maximumperhour"> 24 </label><?php csv2post_GUI_nbsp();?>                    
        <input type="radio" id="csv2post_radio4_dripfeedrate_maximumperhour" name="hour" value="50" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 50){echo 'checked';} ?> /><label for="csv2post_radio4_dripfeedrate_maximumperhour"> 50 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio5_dripfeedrate_maximumperhour" name="hour" value="100" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 100){echo 'checked';} ?> /><label for="csv2post_radio5_dripfeedrate_maximumperhour"> 100 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio6_dripfeedrate_maximumperhour" name="hour" value="250" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 250){echo 'checked';} ?> /><label for="csv2post_radio6_dripfeedrate_maximumperhour"> 250 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio7_dripfeedrate_maximumperhour" name="hour" value="500" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 500){echo 'checked';} ?> /><label for="csv2post_radio7_dripfeedrate_maximumperhour"> 500 </label><?php csv2post_GUI_nbsp();?>        
        <input type="radio" id="csv2post_radio8_dripfeedrate_maximumperhour" name="hour" value="1000" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 1000){echo 'checked';} ?> /><label for="csv2post_radio8_dripfeedrate_maximumperhour"> 1000 </label><?php csv2post_GUI_nbsp();?>                                                                                                                        
    </div>
                    
    <h4><?php c2p_tt('Maximum Per Session/Event','Sessions/events are triggered by visits to the blog. On loading Wordpress loads all plugins and while this plugin loads it checks your schedule. If something needs done the procedure is referred to as an event. You get to determine how many posts are created during a single event. Use this to avoid your blog loading time slowing down a lot or sacrifice a quick loading blog for some speedy auto-blogging');?></h4>
    <script>
    $(function() {
        $( "#csv2post_dripfeedrate_maximumpersession" ).buttonset();
    });
    </script>                
    <div id="csv2post_dripfeedrate_maximumpersession">
        <input type="radio" id="csv2post_radio1_dripfeedrate_maximumpersession" name="session" value="1" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_dripfeedrate_maximumpersession"> 1 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio2_dripfeedrate_maximumpersession" name="session" value="5" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 5){echo 'checked';} ?> /><label for="csv2post_radio2_dripfeedrate_maximumpersession"> 5 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio3_dripfeedrate_maximumpersession" name="session" value="10" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 10){echo 'checked';} ?> /><label for="csv2post_radio3_dripfeedrate_maximumpersession"> 10 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio9_dripfeedrate_maximumpersession" name="session" value="25" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 25){echo 'checked';} ?> /><label for="csv2post_radio9_dripfeedrate_maximumpersession"> 25 </label><?php csv2post_GUI_nbsp();?>                    
        <input type="radio" id="csv2post_radio4_dripfeedrate_maximumpersession" name="session" value="50" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 50){echo 'checked';} ?> /><label for="csv2post_radio4_dripfeedrate_maximumpersession"> 50 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio5_dripfeedrate_maximumpersession" name="session" value="100" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 100){echo 'checked';} ?> /><label for="csv2post_radio5_dripfeedrate_maximumpersession"> 100 </label><?php csv2post_GUI_nbsp();?>
        <input type="radio" id="csv2post_radio6_dripfeedrate_maximumpersession" name="session" value="200" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 200){echo 'checked';} ?> /><label for="csv2post_radio6_dripfeedrate_maximumpersession"> 200 </label><?php csv2post_GUI_nbsp();?>                                                                                                                        
        <input type="radio" id="csv2post_radio7_dripfeedrate_maximumpersession" name="session" value="300" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 300){echo 'checked';} ?> /><label for="csv2post_radio7_dripfeedrate_maximumpersession"> 300 </label><?php csv2post_GUI_nbsp();?>    
    </div>
    
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_promptdiv($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'eventtypes';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Event Types *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Event types are the names giving to different things CSV 2 POST can do during automated processing. You should only activate event types you actually want to use. The more you activate, the less priority each event type has i.e. if you activate 10 different event types, each event type will be run 10 or more minutes apart as there is a 60 second cooldown between all events of any type. You can override the schedules process of cycling through multiple different event types and force it to focus on one selected event type using the Focus settings.');
$panel_array['panel_url'] = 'http://www.csv2post.com/hacking/event-types';
$panel_array['video'] = 'http://www.youtube.com/embed/VViRp6Ggw94';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Save Event Types';
$jsform_set['noticebox_content'] = 'You are about to change the permitted event types to be run as part of the automated schedule system, do you want to continue?';
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <h4><?php c2p_tt('Focus','Make the plugin focus on a specific type of event. If you would like it to tweet auto-blogged posts that have not yet been tweeted before making even more posts than you would select Twitter Send');?></h4>                                                                                                                           

    <script>
    $(function() {
        $( "#csv2post_focus_eventtype_postcreation" ).buttonset();
    });
    </script>                
    <div id="csv2post_focus_eventtype_postcreation">
        <?php   
        $default = true;
        foreach($csv2post_schedule_array['eventtypes'] as $eventtype => $eventtype_array){
                      
            $checked = '';
            if(isset(${'focus'.$eventtype}) && ${'focus'.$eventtype} == 1){
                $checked = 'checked="checked"';
                $default = false;
            }?>
            
            <input type="radio" id="csv2post_focus_event_<?php echo $eventtype;?>" name="csv2post_focus_event" value="1" <?php echo $checked;?>  />
            <label for="csv2post_focus_event_<?php echo $eventtype;?>"><?php echo $eventtype_array['name'];?></label><?php csv2post_GUI_br();?><?php           
        }
        ?>
        
        <input type="radio" id="csv2post_focus_event_none" name="csv2post_focus_event" value="1" <?php if($default){echo 'checked="checked"';}?>  />
        <label for="csv2post_focus_event_none">No Focus</label>        
                              
    </div> 
    
    <br />
                                                                                                                                
    <h4><?php c2p_tt('Post Creation','Enable or disable automatic post creation, also known as drip-feeding, within this plugins schedule');?></h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_postcreation" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_postcreation">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_postcreation" name="csv2post_eventtype_postcreation" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['postcreation']['switch']) && $csv2post_schedule_array['eventtypes']['postcreation']['switch'] == 1){echo 'checked';} ?> />
        <label for="csv2post_radio1_eventtypeactivation_postcreation"> Enabled</label>
        <?php csv2post_GUI_br();?>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_postcreation" name="csv2post_eventtype_postcreation" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['postcreation']['switch']) && $csv2post_schedule_array['eventtypes']['postcreation']['switch'] == 0 || !isset($csv2post_schedule_array['eventtypes']['postcreation']['switch'])){echo 'checked';} ?> />
        <label for="csv2post_radio2_eventtypeactivation_postcreation"> Disabled</label>    
    </div>    
 
    <h4><?php c2p_tt('Post Update','Enable or disable automatic post updating controlled by the plugins schedule');?></h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_postupdate" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_postupdate">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_postupdate" name="csv2post_eventtype_postupdate" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['postupdate']['switch']) && $csv2post_schedule_array['eventtypes']['postupdate']['switch'] == 1){echo 'checked';} ?> />
        <label for="csv2post_radio1_eventtypeactivation_postupdate"> Enabled</label>
        <?php csv2post_GUI_br();?>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_postupdate" name="csv2post_eventtype_postupdate" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['postupdate']['switch']) && $csv2post_schedule_array['eventtypes']['postupdate']['switch'] == 0 || !isset($csv2post_schedule_array['eventtypes']['postupdate']['switch'])){echo 'checked';} ?> />
        <label for="csv2post_radio2_eventtypeactivation_postupdate"> Disabled</label>    
    </div> 
    
    <h4><?php c2p_tt('Data Import','Enable or disable automatic data import controlled by the plugins schedule');?></h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_dataimport" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_dataimport">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_dataimport" name="csv2post_eventtype_dataimport" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['dataimport']['switch']) && $csv2post_schedule_array['eventtypes']['dataimport']['switch'] == 1){echo 'checked';} ?> />
        <label for="csv2post_radio1_eventtypeactivation_dataimport"> Enabled</label>
        <?php csv2post_GUI_br();?>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_dataimport" name="csv2post_eventtype_dataimport" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['dataimport']['switch']) && $csv2post_schedule_array['eventtypes']['dataimport']['switch'] == 0 || !isset($csv2post_schedule_array['eventtypes']['dataimport']['switch'])){echo 'checked';} ?> />
        <label for="csv2post_radio2_eventtypeactivation_dataimport"> Disabled</label>    
    </div>

    <h4><?php c2p_tt('Data Update','Enable or disable automatic data updating controlled by the plugins own schedule system');?></h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_dataupdate" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_dataupdate">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_dataupdate" name="csv2post_eventtype_dataupdate" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['dataupdate']['switch']) && $csv2post_schedule_array['eventtypes']['dataupdate']['switch'] == 1){echo 'checked';} ?> />
        <label for="csv2post_radio1_eventtypeactivation_dataupdate"> Enabled</label>
        <?php csv2post_GUI_br();?>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_dataupdate" name="csv2post_eventtype_dataupdate" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['dataupdate']['switch']) && $csv2post_schedule_array['eventtypes']['dataupdate']['switch'] == 0 || !isset($csv2post_schedule_array['eventtypes']['dataupdate']['switch'])){echo 'checked';} ?> />
        <label for="csv2post_radio2_eventtypeactivation_dataupdate"> Disabled</label>    
    </div> 

    <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_promptdiv($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>

<?php
if(!$csv2post_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'dripfeedprojectsarraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Drip Feed Project Array Dump');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('A dump of the array that holds all projects. It also holds the value that causes a project to be included in automatic post creation. Automatic post creation is also known as drip feeding posts into Wordpress or auto-blogging. In CSV 2 POST drip-feeding events are triggered when the blog is visited on both public and admin side. During the loading of Wordpress, this plugin is also loaded and any due events are processed.');?>
    <?php csv2post_panel_header( $panel_array );?>
        
        <pre><?php csv2post_var_dump($csv2post_projectslist_array); ?></pre>
        
    <?php csv2post_panel_footer();
}?> 

<?php
if(!$csv2post_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'schedulearraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Schedule Array Dump');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('This array dump shows the permitted days of the week and hours per day for drip-feed events to happen. The values apply to all projects, contact us if you need projects to run different schedules.');?>
    <?php csv2post_panel_header( $panel_array );?>
        
        <h4>Event</h4>
        <?php if(isset($csv2post_schedule_array['history'])){csv2post_var_dump($csv2post_schedule_array['history']);}else{echo 'No schedule history recorded';} ?>
               
        <h4>Days</h4>
        <?php if(isset($csv2post_schedule_array['days'])){csv2post_var_dump($csv2post_schedule_array['days']);}else{echo 'No days settings stored';} ?>
        
        <h4>Hours</h4>
        <?php if(isset($csv2post_schedule_array['hours'])){csv2post_var_dump($csv2post_schedule_array['hours']);}else{echo 'No hours settings stored';} ?>

        <h4>Creation Limits</h4>
        <p>These are used to avoid over processing on the server</p>
        <?php if(isset($csv2post_schedule_array['limits'])){csv2post_var_dump($csv2post_schedule_array['limits']);}else{echo 'No limits/target settings stored';} ?>
        
        <h4>Entire Array</h4>
        <?php if(isset($csv2post_schedule_array)){csv2post_var_dump($csv2post_schedule_array);}else{echo 'No array stored';} ?>
                
    <?php csv2post_panel_footer();
}?> 