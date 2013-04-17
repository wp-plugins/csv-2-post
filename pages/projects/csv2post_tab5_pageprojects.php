<?php       

/*
    TODO:MEDIUMPRIORITY, add options to populate these post values using pre-made data
  'post_date'      => [ Y-m-d H:i:s ] //The time post was made.
  'post_date_gmt'  => [ Y-m-d H:i:s ] //The time post was made, in GMT.

*/

if(isset($csv2post_project_array['dates']['currentmethod'])){
        
    if($csv2post_project_array['dates']['currentmethod'] == 'data'){
        echo csv2post_notice('You selected a column in your project database tables for populating the publish dates of your posts.
        Please ensure the date formats in your data is suitable if your dates do not turn out as expected.','info','Small','Current Date Method: Your Data','','return');        
          
    }
            
    if($csv2post_project_array['dates']['currentmethod'] == 'random'){
        echo csv2post_notice('Your project is currently setup to create random publish dates. Your 
        random dates will be generated using the giving start and end dates. All publish dates will fall
        between those giving dates and will not be created with any increment or in order.','info','Small','Current Date Method: Random Dates','','return');        
       
    }
    
    if($csv2post_project_array['dates']['currentmethod'] == 'increment'){
        echo csv2post_notice('The current project is setup to use the incremental publish dates method.
        The first publish date will be the Start date you submitted. The increment will then be used to 
        create the next publish date.','info','Small','Current Date Method: Incremental Dates','','return');           
    }

}else{   
    echo csv2post_notice('Your project is set to use your blogs default publish date.','info','Small','Current Date Method: Wordpress Default','','return');
}  
?> 

<?php      
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'postdatescolumn';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = 'Set Publish Dates Column (currently ' .  csv2post_get_project_datecolumn($csv2post_currentproject_code).')';// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('The creation page allows you to configure dates and allow the plugin to set dates for posts. However if you have a column of pre-set dates you can over-ride all other date settings by selecting the dates column in this panel.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);                
$jsform_set['dialogbox_title'] = 'Save Data Column';
$jsform_set['noticebox_content'] = 'You are saving your dates column so that posts are published with the dates in your data. Do you wish to continue?';
// TODO: HIGHPRIORITY, write function to test dates, display on this panel and use in processing?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <label for="csv2post_datecolumn_select_columnandtable_formid">Select Column: </label>
    <select name="csv2post_datecolumn_select_columnandtable" id="csv2post_datecolumn_select_columnandtable_formid" class="csv2post_multiselect_menu">
        
        <?php
        $table = ''; 
        if(isset($csv2post_project_array['dates']['date_column']['table_name'])){
            $table = $csv2post_project_array['dates']['date_column']['table_name'];    
        }
        
        $column = ''; 
        if(isset($csv2post_project_array['dates']['date_column']['column_name'])){
            $column = $csv2post_project_array['dates']['date_column']['column_name'];    
        }        
        ?>
        
        <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$table,$column);?>                                                                                                                     
    </select>
  
    <br>
  
    <label for="csv2post_datecolumn_format_objectid">Select Date Format: </label>
    <select name="csv2post_datecolumn_format" id="csv2post_datecolumn_format_objectid" class="csv2post_multiselect_menu">
        
        <?php
        $format = ''; 
        if(isset($csv2post_project_array['dates']['date_column']['format'])){
            $format = $csv2post_project_array['dates']['date_column']['format'];    
        }     
        ?>
        
        <option value="unsure">Unsure</option>
        <option value="noformat">Do Not Format (use date data as it is)</option>        
        <option value="uk">UK (will be formatted to MySQL standard)</option>
        <option value="us">US (will be formatted to MySQL standard)</option>
        <option value="mysql">MySQL (will still be formatted to be sure)</option>
        <option value="custom">Custom/Other (contact us)</option> 
                                                                                                                           
    </select>
        
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
$panel_array['panel_name'] = 'incrementalpublishdatessettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Incremental Publish Date Settings');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Incremental will apply a different post date per post and increase the date as posts are created. The start date is updated with the latest used date and time everytime a post is created. A slider allows you to set the increment value. You can create a random increment range, allowing you to force a short and long increment size for more natural publish dates. The increment values are in minutes. You can position the sliders so that the shortest and longest times match so fixing the exact number of minutes between each publish date.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Save Incremental Publish Date Settings';
$jsform_set['noticebox_content'] = 'You are about to switch your project to incremental publish dates, do you want to continue?';
### TODO: LOWPRIORITY, displays hours,days,week on slider
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <script>
    $(function() {
        $( "#csv2post_publishdateincrement_start" ).datepicker();
    });
    </script>
    
    <?php
    $inc_start = '';
    if(isset($csv2post_project_array['dates']['increment']['start'])){
        $inc_start = $csv2post_project_array['dates']['increment']['start'];   
    }   
    ?>
              
    <p>Start Date: <input type="text" name="csv2post_publishdateincrement_start" id="csv2post_publishdateincrement_start" value="<?php echo $inc_start;?>"></p>

    <script>
    $(function() {
        $( "#csv2post_increment_slider" ).slider({
            range: true,
            min: 0,
            max: 50000,
            values: [ 0, 1440 ],
            slide: function( event, ui ) {
                $( "#csv2post_increment_range" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
            }
        });
        $( "#csv2post_increment_range" ).val( "" + $( "#csv2post_increment_slider" ).slider( "values", 0 ) +
            " - " + $( "#csv2post_increment_slider" ).slider( "values", 1 ) );
    });
    </script>

    <p>
        <label for="csv2post_increment_range">Increment range:</label>
        <input type="text" name="csv2post_increment_range" id="csv2post_increment_range" style="border:0; color:#f6931f; font-weight:bold;" readonly />
    </p>

    <div id="csv2post_increment_slider"></div>

     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
   
<?php csv2post_panel_footer();
}?> 

<?php
if(!$csv2post_is_free){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'randompublishdatesettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Random Publish Date Settings');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('If you want your blog posts to seem very natural this could be the option for you. You can set a start date and an end date. CSV 2 POST will only make post dates within your set range. That includes saving a future date as your end date and causing posts to become schedule by Wordpress if CSV 2 POST randomly creates a publish date set in the future. Wordpress handles that and publishes your post as scheduled.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Save Random Publish Date Settings';
$jsform_set['noticebox_content'] = 'You are about to change your random publish date settings, this will only effect new posts. Do you want to continue?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <script>
    $(function() {
        $( "#csv2post_randompublishdate_start" ).datepicker();
    });

    $(function() {
        $( "#csv2post_randompublishdate_end" ).datepicker();
    });
    </script>

    <?php
    $ran_start = '';
    if(isset($csv2post_project_array['dates']['random']['start'])){
        $ran_start = $csv2post_project_array['dates']['random']['start'];    
    }
    
    $ran_end = '';
    if(isset($csv2post_project_array['dates']['random']['end'])){
        $ran_end = $csv2post_project_array['dates']['random']['end'];    
    }    
    ?>
                  
    <p>Start Date: <input type="text" name="csv2post_randompublishdate_start" id="csv2post_randompublishdate_start" value="<?php echo $ran_start;?>"></p>
    <p>End Date: <input type="text" name="csv2post_randompublishdate_end" id="csv2post_randompublishdate_end" value="<?php echo $ran_end;?>"></p>
    
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
   
<?php csv2post_panel_footer();
}?> 

<?php  
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'projectdatemethod';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Set Wordpress Default Dates Method');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);                
// TODO: HIGHPRIORITY, write function to test dates, display on this panel and use in processing?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);

    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard('Click To Use Wordpress Default Publish Dates',$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>