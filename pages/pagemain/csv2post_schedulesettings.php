<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'scheduletimes';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Schedule Times *global panel*');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Green indicates posts will be created on that day or time');
$panel_array['panel_help'] = __('A simple approach to controlling when your projects drip feeding is allowed to happen. These settings/times are global and effect all projects with drip feeding applied above.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialoguebox_title'] = 'Saving Schedule Times';
$jsform_set['noticebox_content'] = 'You are about to change the schedule times, do you want to continue?';
// TODO: LOWPRIORITY, add a checkbox to allow user to save design for the mapping approach
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h4>Allowed Days</h4>    
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
        if(isset($csv2post_schedule_array['times']['days'][$day])){
            $day_checked = 'checked';
        }else{
            $day_checked = '';            
        }
        
        echo '<input type="checkbox" name="csv2post_scheduleday_list[]" id="daycheck'.$days_counter.'" value="'.$day.'" '.$day_checked.' /><label for="daycheck'.$days_counter.'">'.ucfirst($day).'</label>';    
        ++$days_counter;
    }
    ?>
    </div>
    
    <h4>Allowed Hours</h4>    
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
        if(isset($csv2post_schedule_array['times']['hours'][$i])){
            $hour_checked = ' checked'; 
        }else{
            $hour_checked = '';
        }
        
        echo '<input type="checkbox" name="csv2post_schedulehour_list[]" id="hourcheck'.$i.'"  value="'.$i.'" '.$hour_checked.' /><label for="hourcheck'.$i.'">'.$i.'</label>';    
    }
    ?>                                                                                     
    </div>  
                       
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'schedulelimits';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Schedule Limits *global panel*');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Quick and easy controls to apply the general rate of post creation during drip feeding sessions');
$panel_array['panel_help'] = __('These controls tell the plugin how many posts to create during a drip feed session. It is a quick and easy approach to applying the rate of post creation. The plugin strictly avoids going over limits, this is considered higher priority than reaching the limit. The plugin will only begin a drip feed session when someone visits the blog; Wordpress loading triggers the schedule to be checked. The plugin will avoid doing this too often so that users do not get a negative experience. A cooldown between drip feed sessions also helps to avoid triggering server problems and using up too much bandwidth within a very short time which can also cause hosting to raise concerns.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialoguebox_title'] = 'Save Drip Feeding Limits';
$jsform_set['noticebox_content'] = 'These are global settings and will take effect on all projects straight away. Do you wish to continue?';
?>
<?php csv2post_panel_header( $panel_array );?>

<?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h4>Maximum Per Day</h4>
    <script>
    $(function() {
        $( "#csv2post_dripfeedrate_maximumperday" ).buttonset();
    });
    </script>

    <div id="csv2post_dripfeedrate_maximumperday">
        <input type="radio" id="csv2post_radio1_dripfeedrate_maximumperday" name="day" value="1" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_dripfeedrate_maximumperday">1</label>
        <input type="radio" id="csv2post_radio2_dripfeedrate_maximumperday" name="day" value="5" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 5){echo 'checked';} ?> /><label for="csv2post_radio2_dripfeedrate_maximumperday">5</label>
        <input type="radio" id="csv2post_radio3_dripfeedrate_maximumperday" name="day" value="10" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 10){echo 'checked';} ?> /><label for="csv2post_radio3_dripfeedrate_maximumperday">10</label>  
        <input type="radio" id="csv2post_radio9_dripfeedrate_maximumperday" name="day" value="24" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 24){echo 'checked';} ?> /><label for="csv2post_radio9_dripfeedrate_maximumperday">24</label>                    
        <input type="radio" id="csv2post_radio4_dripfeedrate_maximumperday" name="day" value="50" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 50){echo 'checked';} ?> /><label for="csv2post_radio4_dripfeedrate_maximumperday">50</label>
        <input type="radio" id="csv2post_radio5_dripfeedrate_maximumperday" name="day" value="250" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 250){echo 'checked';} ?> /><label for="csv2post_radio5_dripfeedrate_maximumperday">250</label>
        <input type="radio" id="csv2post_radio6_dripfeedrate_maximumperday" name="day" value="1000" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 1000){echo 'checked';} ?> /><label for="csv2post_radio6_dripfeedrate_maximumperday">1000</label>                                                                                                                       
        <input type="radio" id="csv2post_radio7_dripfeedrate_maximumperday" name="day" value="2000" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 2000){echo 'checked';} ?> /><label for="csv2post_radio7_dripfeedrate_maximumperday">2000</label> 
        <input type="radio" id="csv2post_radio8_dripfeedrate_maximumperday" name="day" value="5000" <?php if(isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['limits']['day'] == 5000){echo 'checked';} ?> /><label for="csv2post_radio8_dripfeedrate_maximumperday">5000</label>   
    </div>
                
    <h4>Maximum Per Hour</h4>
    <script>
    $(function() {
        $( "#csv2post_dripfeedrate_maximumperhour" ).buttonset();
    });
    </script>

    <div id="csv2post_dripfeedrate_maximumperhour">
        <input type="radio" id="csv2post_radio1_dripfeedrate_maximumperhour" name="hour" value="1" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_dripfeedrate_maximumperhour">1</label>
        <input type="radio" id="csv2post_radio2_dripfeedrate_maximumperhour" name="hour" value="5" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 5){echo 'checked';} ?> /><label for="csv2post_radio2_dripfeedrate_maximumperhour">5</label>
        <input type="radio" id="csv2post_radio3_dripfeedrate_maximumperhour" name="hour" value="10" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 10){echo 'checked';} ?> /><label for="csv2post_radio3_dripfeedrate_maximumperhour">10</label>
        <input type="radio" id="csv2post_radio9_dripfeedrate_maximumperhour" name="hour" value="24" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 24){echo 'checked';} ?> /><label for="csv2post_radio9_dripfeedrate_maximumperhour">24</label>                    
        <input type="radio" id="csv2post_radio4_dripfeedrate_maximumperhour" name="hour" value="50" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 50){echo 'checked';} ?> /><label for="csv2post_radio4_dripfeedrate_maximumperhour">50</label>
        <input type="radio" id="csv2post_radio5_dripfeedrate_maximumperhour" name="hour" value="100" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 100){echo 'checked';} ?> /><label for="csv2post_radio5_dripfeedrate_maximumperhour">100</label>
        <input type="radio" id="csv2post_radio6_dripfeedrate_maximumperhour" name="hour" value="250" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 250){echo 'checked';} ?> /><label for="csv2post_radio6_dripfeedrate_maximumperhour">250</label>
        <input type="radio" id="csv2post_radio7_dripfeedrate_maximumperhour" name="hour" value="500" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 500){echo 'checked';} ?> /><label for="csv2post_radio7_dripfeedrate_maximumperhour">500</label>        
        <input type="radio" id="csv2post_radio8_dripfeedrate_maximumperhour" name="hour" value="1000" <?php if(isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['limits']['hour'] == 1000){echo 'checked';} ?> /><label for="csv2post_radio8_dripfeedrate_maximumperhour">1000</label>                                                                                                                        
    </div>
                    
    <h4>Maximum Per Session</h4>
    <script>
    $(function() {
        $( "#csv2post_dripfeedrate_maximumpersession" ).buttonset();
    });
    </script>                
    <div id="csv2post_dripfeedrate_maximumpersession">
        <input type="radio" id="csv2post_radio1_dripfeedrate_maximumpersession" name="session" value="1" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_dripfeedrate_maximumpersession">1</label>
        <input type="radio" id="csv2post_radio2_dripfeedrate_maximumpersession" name="session" value="5" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 5){echo 'checked';} ?> /><label for="csv2post_radio2_dripfeedrate_maximumpersession">5</label>
        <input type="radio" id="csv2post_radio3_dripfeedrate_maximumpersession" name="session" value="10" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 10){echo 'checked';} ?> /><label for="csv2post_radio3_dripfeedrate_maximumpersession">10</label>
        <input type="radio" id="csv2post_radio9_dripfeedrate_maximumpersession" name="session" value="25" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 25){echo 'checked';} ?> /><label for="csv2post_radio9_dripfeedrate_maximumpersession">25</label>                    
        <input type="radio" id="csv2post_radio4_dripfeedrate_maximumpersession" name="session" value="50" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 50){echo 'checked';} ?> /><label for="csv2post_radio4_dripfeedrate_maximumpersession">50</label>
        <input type="radio" id="csv2post_radio5_dripfeedrate_maximumpersession" name="session" value="100" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 100){echo 'checked';} ?> /><label for="csv2post_radio5_dripfeedrate_maximumpersession">100</label>
        <input type="radio" id="csv2post_radio6_dripfeedrate_maximumpersession" name="session" value="200" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 200){echo 'checked';} ?> /><label for="csv2post_radio6_dripfeedrate_maximumpersession">200</label>                                                                                                                        
        <input type="radio" id="csv2post_radio7_dripfeedrate_maximumpersession" name="session" value="300" <?php if(isset($csv2post_schedule_array['limits']['session']) && $csv2post_schedule_array['limits']['session'] == 300){echo 'checked';} ?> /><label for="csv2post_radio7_dripfeedrate_maximumpersession">300</label>    
    </div>
    
     <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'eventtypes';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Event Types *global panel*');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Activate or disabled specific automated event types used by the plugins schedule system');
$panel_array['panel_help'] = __('Event types are the names giving to different things CSV 2 POST can do during automated processing. You should only activate event types you actually want to use. The more you activate, the less priority each event type has i.e. if you activate 10 different event types, each event type will be run 10 or more minutes apart as there is a 60 second cooldown between all events of any type. Many event types require you to complete configuration elsewhere. Please ensure you have done that before activation. The plugin will try to avoid error where configuration is not complete but it is not an easy task.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
$panel_array['panel_url'] = 'http://www.csv2post.com/hacking/event-types';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialoguebox_title'] = 'Save Event Types';
$jsform_set['noticebox_content'] = 'You are about to change the permitted event types to be run as part of the automated schedule system, do you want to continue?';
?>
<?php csv2post_panel_header( $panel_array );?>

<?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h1>Posts</h1>                                                                                                                            
    <h4>Post Creation</h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_postcreation" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_postcreation">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_postcreation" name="csv2post_eventtype_postcreation" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['postcreation']) && $csv2post_schedule_array['eventtypes']['postcreation'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_eventtypeactivation_postcreation">Enabled</label>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_postcreation" name="csv2post_eventtype_postcreation" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['postcreation']) && $csv2post_schedule_array['eventtypes']['postcreation'] == 0 || !isset($csv2post_schedule_array['eventtypes']['postcreation'])){echo 'checked';} ?> /><label for="csv2post_radio2_eventtypeactivation_postcreation">Disabled</label>    
    </div>    
 
    <h4>Post Update</h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_postupdate" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_postupdate">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_postupdate" name="csv2post_eventtype_postupdate" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['postupdate']) && $csv2post_schedule_array['eventtypes']['postupdate'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_eventtypeactivation_postupdate">Enabled</label>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_postupdate" name="csv2post_eventtype_postupdate" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['postupdate']) && $csv2post_schedule_array['eventtypes']['postupdate'] == 0 || !isset($csv2post_schedule_array['eventtypes']['postupdate'])){echo 'checked';} ?> /><label for="csv2post_radio2_eventtypeactivation_postupdate">Disabled</label>    
    </div> 
    
     
    <br />
    <h1>Data</h1>    
    <h4>Data Import</h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_dataimport" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_dataimport">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_dataimport" name="csv2post_eventtype_dataimport" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['dataimport']) && $csv2post_schedule_array['eventtypes']['dataimport'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_eventtypeactivation_dataimport">Enabled</label>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_dataimport" name="csv2post_eventtype_dataimport" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['dataimport']) && $csv2post_schedule_array['eventtypes']['dataimport'] == 0 || !isset($csv2post_schedule_array['eventtypes']['dataimport'])){echo 'checked';} ?> /><label for="csv2post_radio2_eventtypeactivation_dataimport">Disabled</label>    
    </div>

    <h4>Data Update</h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_dataupdate" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_dataupdate">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_dataupdate" name="csv2post_eventtype_dataupdate" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['dataupdate']) && $csv2post_schedule_array['eventtypes']['dataupdate'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_eventtypeactivation_dataupdate">Enabled</label>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_dataupdate" name="csv2post_eventtype_dataupdate" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['dataupdate']) && $csv2post_schedule_array['eventtypes']['dataupdate'] == 0 || !isset($csv2post_schedule_array['eventtypes']['dataupdate'])){echo 'checked';} ?> /><label for="csv2post_radio2_eventtypeactivation_dataupdate">Disabled</label>    
    </div> 
 
 
    <br />
    <h1>Twitter</h1>
    <p><strong>Experimental only. Our plan is to allow posts to be tweeted automatically.</strong></p>
 
    <h4>Twitter Send</h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_twittersend" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_twittersend">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_twittersend" name="csv2post_eventtype_twittersend" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['twittersend']) && $csv2post_schedule_array['eventtypes']['twittersend'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_eventtypeactivation_twittersend">Enabled</label>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_twittersend" name="csv2post_eventtype_twittersend" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['twittersend']) && $csv2post_schedule_array['eventtypes']['twittersend'] == 0 || !isset($csv2post_schedule_array['eventtypes']['twittersend'])){echo 'checked';} ?> /><label for="csv2post_radio2_eventtypeactivation_twittersend">Disabled</label>    
    </div>

    <h4>Twitter Update</h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_twitterupdate" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_twitterupdate">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_twitterupdate" name="csv2post_eventtype_twitterupdate" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['twitterupdate']) && $csv2post_schedule_array['eventtypes']['twitterupdate'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_eventtypeactivation_twitterupdate">Enabled</label>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_twitterupdate" name="csv2post_eventtype_twitterupdate" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['twitterupdate']) && $csv2post_schedule_array['eventtypes']['twitterupdate'] == 0 || !isset($csv2post_schedule_array['eventtypes']['twitterupdate'])){echo 'checked';} ?> /><label for="csv2post_radio2_eventtypeactivation_twitterupdate">Disabled</label>    
    </div>   
    
    <h4>Twitter Get Replies</h4>
    <script>
    $(function() {
        $( "#csv2post_eventtypeactivation_twitterget" ).buttonset();
    });
    </script>                
    <div id="csv2post_eventtypeactivation_twitterget">
        <input type="radio" id="csv2post_radio1_eventtypeactivation_twitterget" name="csv2post_eventtypes_twitterget" value="1" <?php if(isset($csv2post_schedule_array['eventtypes']['twitterget']) && $csv2post_schedule_array['eventtypes']['twitterget'] == 1){echo 'checked';} ?> /><label for="csv2post_radio1_eventtypeactivation_twitterget">Enabled</label>
        <input type="radio" id="csv2post_radio2_eventtypeactivation_twitterget" name="csv2post_eventtypes_twitterget" value="0" <?php if(isset($csv2post_schedule_array['eventtypes']['twitterget']) && $csv2post_schedule_array['eventtypes']['twitterget'] == 0 || !isset($csv2post_schedule_array['eventtypes']['twitterget'])){echo 'checked';} ?> /><label for="csv2post_radio2_eventtypeactivation_twitterget">Disabled</label>    
    </div>    

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>

<?php
if(!$csv2post_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = array();
    $panel_array['panel_name'] = 'dripfeedprojectsarraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Drip Feed Project Array Dump');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
    $panel_array['tabnumber'] = $csv2post_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('Dump of project list array, also holds settings for drip feed activation');
    $panel_array['panel_help'] = __('A dump of the array that holds all projects. It also holds the value that causes a project to be included in automatic post creation. Automatic post creation is also known as drip feeding posts into Wordpress or auto-blogging. In CSV 2 POST drip-feeding events are triggered when the blog is visited on both public and admin side. During the loading of Wordpress, this plugin is also loaded and any due events are processed.');
    $panel_array['help_button'] = csv2post_helpbutton_text(false,true);?>
    <?php csv2post_panel_header( $panel_array );?>
        
        <pre><?php var_dump($csv2post_projectslist_array); ?></pre>
        
    <?php csv2post_panel_footer();
}?> 

<?php
if(!$csv2post_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = array();
    $panel_array['panel_name'] = 'schedulearraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Schedule Array Dump');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
    $panel_array['tabnumber'] = $csv2post_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('Dump of schedule and limits array used for drip-feeding events');
    $panel_array['panel_help'] = __('This array dump shows the permitted days of the week and hours per day for drip-feed events to happen. The values apply to all projects, contact us if you need projects to run different schedules.');
    $panel_array['help_button'] = csv2post_helpbutton_text(false,true);?>
    <?php csv2post_panel_header( $panel_array );?>
        
        <h4>Event</h4>
        <pre><?php if(isset($csv2post_schedule_array['history'])){var_dump($csv2post_schedule_array['history']);}else{echo 'No schedule history recorded';} ?></pre>
               
        <h4>Days</h4>
        <pre><?php if(isset($csv2post_schedule_array['times']['days'])){var_dump($csv2post_schedule_array['times']['days']);}else{echo 'No days settings stored';} ?></pre>
        
        <h4>Hours</h4>
        <pre><?php if(isset($csv2post_schedule_array['times']['hours'])){var_dump($csv2post_schedule_array['times']['hours']);}else{echo 'No hours settings stored';} ?></pre>

        <h4>Creation Limits</h4>
        <p>These are used to avoid over processing on the server</p>
        <pre><?php if(isset($csv2post_schedule_array['limits'])){var_dump($csv2post_schedule_array['limits']);}else{echo 'No limits/target settings stored';} ?></pre>
        
        <h4>Entire Array</h4>
        <pre><?php if(isset($csv2post_schedule_array)){var_dump($csv2post_schedule_array);}else{echo 'No array stored';} ?></pre>
                
    <?php csv2post_panel_footer();
}?> 