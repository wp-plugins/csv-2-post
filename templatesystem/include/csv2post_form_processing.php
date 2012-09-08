<?php 
// Instructions
// 1. csv2post_include_form_processing_php() calls this file, used in the same functions that include page files 
// 2. csv2post_form_submission_processing() requires $_POST[WTG_C2P_ABB.'post_processing_required']
// 3. This file does initial validation of values before processing i.e. database changes or file changes
// 4. csv2post_form_submission_processing also requires user to be logged in
// 5. This file can avoid calling processing functions using $e, importing when a $_POST is part of a long process

// exit validation function calls variable - use to avoid calling functions once $_POST processing done 
$cont = true;   
global $csv2post_notice_result;

# TODO: add hidden input with value uses in these arguments to skip more function calls i.e. one per screen

// Data Screen Form Submissions
if($cont){
    
    // create a new data import job
    $cont = csv2post_form_createdataimportjob();
        
    // Delete Data Import Jobs
    $cont = csv2post_form_delete_dataimportjobs();
         
    // Process CSV file upload    
    $cont = csv2post_form_upload_csv_file(); 
        
    // Delete one or more database tables
    $cont = csv2post_form_drop_database_tables(); 
         
    // Manual data import
    $cont = csv2post_form_importdata();
                    
    // Delete CSV file
    $cont = csv2post_form_delete_csvfile();  
}

// Project Screen Form Submissions (project creation and configuration)
if($cont){

    // Create post creation project
    $cont = csv2post_form_create_post_creation_project();
                    
    // Multiple file project relationship settings panel
    $cont = csv2post_form_save_multiplefilesproject();
                              
    // Delete one or more post creation projects
    $cont = csv2post_form_delete_post_creation_projects();
                             
    // Change current project
    $cont = csv2post_form_change_current_project();
                           
    // Save template
    $cont = csv2post_form_save_contenttemplate();

    // Dynamic content rule (by value)
    $cont = csv2post_form_save_contenttemplatedesign_condition_byvalue();
    
    // Update the default content template design for current project
    $cont = csv2post_form_change_default_contenttemplate();
    
    // Update the default 
    $cont = csv2post_form_change_default_titletemplate();    
    
    // Insert new wtgcsvtitle post as a title template
    $cont = csv2post_form_insert_title_template();
    
    // Update title templates
    $cont = csv2post_form_update_titletemplates();
    
    // Update projects default custom post type
    $cont = csv2post_form_update_defaultposttype();
    
    // Insert new post type value condition (apply post types based on value in table column)
    $cont = csv2post_form_save_posttype_condition_byvalue();
    
    // Reset date method to Wordpress default
    $cont = csv2post_form_set_datemethod_default();
    
    // Save date column
    $cont = csv2post_form_update_datecolumn();
    
    // Save random publish date settings (also activates this method)
    $cont = csv2post_form_save_randompublishdate_settings();
    
    // Save incremental publish date settings (also activates this method)
    $cont = csv2post_form_save_incrementalpublishdate_settings();
    
    // Save default tags column
    $cont = csv2post_form_save_default_tags_column();
    
    // Save tag generator settings (full edition only)
    $cont = csv2post_form_save_tag_generator_settings();    
                               
    // Adds a basic post meta rule - custom field
    $cont = csv2post_form_add_basic_custom_field();
    
    // Deletes basic custom field rules
    $cont = csv2post_form_delete_basiccustomfields();

    // Adds a advanced post meta rule - custom field
    $cont = csv2post_form_add_advanced_custom_field();
        
    // Deletes advanced custom field rules
    $cont = csv2post_form_delete_advancedcustomfields();        
        
    // Save standard category configuration
    $cont = csv2post_form_save_categories_standard();
    
    // Save advanced category configuration
    $cont = csv2post_form_save_categories_advanced();
    
    // Save category mapping (data values too)
    $cont = csv2post_form_save_category_mapping();
    
    // Save project post content update settings
    $cont = csv2post_form_save_projectupdatesettings();
    
    // Save default category
    $cont = csv2post_form_save_default_category();
    
    // Save tag creation rules
    $cont = csv2post_form_save_tag_rules();
    
    // Save a new HTML shortcode - this one offers a shortcode showing shortcode name (no need for user to enter values in shortcode)
    $cont = csv2post_form_save_htmlshortcode();
    
    // Deletes random advanced shortcode rules
    $cont = csv2post_form_delete_randomadvanced_shortcoderules();
    
    // Save basic SEO options
    $cont = csv2post_form_save_basic_seo_options();
    
    // Save post titles data column
    $cont = csv2post_form_save_title_data_column();
    
    // Save Ultimate Taxonomy Manager category custom field settings
    $cont = csv2post_form_save_ultimatetaxonomymanager_categories();
    
    // Save default author
    $cont = csv2post_form_save_default_author();
    
    // Save featured image table and column
    $cont = csv2post_form_featuredimage();
}

// Creation Screen
if($cont){  
    $cont = csv2post_form_save_dripfeedprojects_switch();
    
    // Save global allowed days and hours
    $cont = csv2post_form_save_scheduletimes_global();
    
    // Save drip feed limits
    $cont = csv2post_form_save_schedulelimits();
    
    // Start post creation even manually
    $cont = csv2post_form_start_post_creation();
    
    // Save event types
    $cont = csv2post_form_save_eventtypes();
    
    // Creates categories
    $cont = csv2post_form_create_categories(); 
    
    // Updates a single giving post using post ID                         
    $cont = csv2post_form_update_post();
    
    // Save global updating settings
    $cont = csv2post_form_save_globalupdatesettings();  
    
    // Undo posts
    $cont = csv2post_form_undo_posts();
    
    // Delete flags
    $cont = csv2post_form_delete_flags();         
}


// Install and Settings
if($cont){

    // Save easy configuration questions
    $cont = csv2post_form_save_easyconfigurationquestions();
        
    // Log File Installation Post Validation
    $cont = csv2post_form_logfileinstallation();

    // Delete Log File Post Validation
    $cont = csv2post_form_deletelogfile();
    
    // Disable Log File Post Validation  
    $cont = csv2post_form_disablelogfile();
    
    // Activate Log File Post Validation
    $cont = csv2post_form_activatelogfile();
    
    // View Log File Post Validation
    $cont = csv2post_form_viewlogfile();
    
    // Contact Form Submission Post Validation
    $cont = csv2post_form_contactformsubmission();
    
    // Hide Tab Post Validation
    $cont = csv2post_form_hidetab();

    // Tab Display Settings Post Validation  
    $cont = csv2post_form_tabdisplay();
    
    // Test CSV File 
    $cont = csv2post_form_test_csvfile();
    
    // Create a data rule for replacing specific values after import 
    $cont = csv2post_form_create_datarule_replacevalue(); 
}

// rare used forms      
if($cont){
    $cont = csv2post_form_changetheme();  
    $cont = csv2post_form_installplugin();   
    $cont = csv2post_form_reinstallplugin();    
    $cont = csv2post_form_uninstallplugin();
    $cont = csv2post_form_createcontentfolder();
    $cont = csv2post_form_deletecontentfolder();    
}

/**
* Create users in post creation project
*/
function csv2post_form_save_createusers_postproject(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createauthors'){

        global $csv2post_project_array,$csv2post_currentproject_code;

        // if email column not submitted
        if(!isset($_POST['csv2post_createusers_emailcolumn'])){
            csv2post_notice('Email address data is always required for creating Wordpress users. Please select your email address column.',
            'error','Large','No Email Data Selected','','echo');
            return false; 
        }
        
        ### TODO:LOWPRIORITY, check the email address data and ensure it is valid email address. This is to avoid issues during post creation
        
        // store email column and table
        $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_createusers_emailcolumn']);
        $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_createusers_emailcolumn']);
                    
        $csv2post_project_array['authors']['createusers']['emails']['table'] = $table_name;            
        $csv2post_project_array['authors']['createusers']['emails']['column'] = $column_name;
                
        // if username column submitted (optional)
        if(isset($_POST['csv2post_createusers_usernamecolumn'])){
            
            $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_createusers_usernamecolumn']);
            $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_createusers_usernamecolumn']);
                        
            $csv2post_project_array['authors']['createusers']['usernames']['table'] = $table_name;            
            $csv2post_project_array['authors']['createusers']['usernames']['column'] = $column_name;
        }        
            
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        csv2post_notice('Yourates.',
        'success','Large','Answers Saved','','echo');
           
        return false;
    }else{
        return true;
    }       
}  

/**
* Saves easy configuration questions
*/
function csv2post_form_save_easyconfigurationquestions(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'easyconfigurationquestions'){
        global $csv2post_adm_set,$csv2post_easyquestions_array;
        
        // loop through questions, answers are in order of questions are in array and we need to know question type
        foreach($csv2post_easyquestions_array as $key => $q){
            
            // if $_POST value for this question
            if($_POST['csv2post_'.$key]){
                $csv2post_adm_set['easyconfigurationquestions'][$key] = $_POST['csv2post_'.$key];  
            }
                
        }
        
        csv2post_update_option_adminsettings($csv2post_adm_set);
   
        csv2post_notice('Your answers for the Easy Configuration Questions have been saved. Please remember
        that this may hide features, display new features or change the way a feature operates.',
        'success','Large','Answers Saved','','echo');
           
        return false;
    }else{
        return true;
    }       
}

/**
* Deletes flags (post meta for flagged posts)   
*/
function csv2post_form_delete_flags(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'latestten'){

        // if no flags selected
        if(!isset($_POST['csv2post_delete_flag'])){
            csv2post_notice('No flags were selected, please select the flags you would like to delete.','error','Large','No Flags Selected','','echo');    
            return false;
        }
        
        // loop through selected flags
        foreach($_POST['csv2post_delete_flag'] as $key => $metaid){
            delete_meta($metaid);        
        }

        csv2post_notice('All selected flags deleted','success','Large','Flags Deleted','','echo');#
        
        return false;
    }else{
        return true;
    }       
}         

/**
* Deletes one or more CSV files 
*/
function csv2post_form_delete_csvfile(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deletecsvfiles'){
        
        // if no csv file selected
        if(!isset($_POST['csv2post_delete_csvfiles']) || count($_POST['csv2post_delete_csvfiles']) == 0){
            csv2post_notice('No CSV files were selected, please try again.','error','Large','No CSV File Selected','','echo');
            return false;
        }

        $file_is_in_use = false;
        
        // loop through selected CSV files
        foreach($_POST['csv2post_delete_csvfiles'] as $key => $csv_file_name){
            $file_is_in_use = csv2post_is_csvfile_in_use($csv_file_name);
            
            // if file is in use
            if($file_is_in_use){
                csv2post_notice('The file named ' . $csv_file_name .' is in use. Please delete any data import job or project using the file before attempting to delete it.','warning','Small','File In Use','','echo');
            }else{
                unlink(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_file_name); 
                csv2post_notice( $csv_file_name .' Deleted','success','Small','','','echo');
            }
        }

        return false;
    }else{
        return true;
    }       
}      


/**
* Saves featured image table and column
*/
function csv2post_form_featuredimage(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'featuredimages'){

        global $csv2post_project_array,$csv2post_currentproject_code;

        $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_featuredimage_columnandtable']);
        $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_featuredimage_columnandtable']);            

        $csv2post_project_array['images']['featuredimage']['table'] = $table_name;            
        $csv2post_project_array['images']['featuredimage']['column'] = $column_name;
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 

        csv2post_notice('Your featured image column has been saved.','success','Large','Featured Images','','echo');
                 
        return false;
    }else{
        return true;
    }       
}      
  
/**
* Saves easy configuration questions
*/
function csv2post_form_undo_posts(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'undoposts'){
        global $csv2post_currentproject_code;
        
        $number_of_posts_deleted = 0;
        
        // if no range selected
        if(!isset($_POST['csv2post_undo'])){
            csv2post_notice('You did not select the range/group of posts you would like to undo.',
            'error','Large','No Range Selected','','echo');
            return false;
        }
        
        // if current project options selected but no posts made with project
        if($_POST['csv2post_undo'] == 'currentproject' 
        || $_POST['csv2post_undo'] == 'last10minutes' 
        || $_POST['csv2post_undo'] == 'last60minutes' 
        || $_POST['csv2post_undo'] == 'last24hours'){
            $postscreated = csv2post_does_project_have_posts($csv2post_currentproject_code);
            if(!$postscreated){
                csv2post_notice('The current project does not have any posts according to the projects main table',
                'error','Large','No Posts','','echo');
                return false;        
            } 
        }
        
        // delete posts
        $number_of_posts_deleted = csv2post_delete_project_posts_byrange($csv2post_currentproject_code,$_POST['csv2post_undo']);
        
        if($number_of_posts_deleted > 0){
            
            $plural = "'s";
            if($number_of_posts_deleted == 1){
                $plural = '';    
            }
            
            csv2post_notice('You deleted ' . $number_of_posts_deleted .' posts. The post ID have also been removed from their
            project table so that the records are ready to use again.'
            ,'success','Large',$number_of_posts_deleted . " Post".$plural." Deleted",'','echo'); 
        }else{
            csv2post_notice('No posts were deleted as there are no post ID in the project tables checked.',
            'info','Large','No Posts Deleted','','echo');
        }        
           
        return false;
    }else{
        return true;
    }       
}     

/**
* Saves default author 
*/
function csv2post_form_save_globalupdatesettings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'globalpostupdatesettings'){
        global $csv2post_schedule_array;
        
        // if is set constant updating for content
        if(isset($_POST['csv2post_globalpostupdatesettings_constantupdating_content'])){
            // if value is 1 then use is activing constant post content updating
            if($_POST['csv2post_globalpostupdatesettings_constantupdating_content'] == 1){
                csv2post_notice('Constant post content updating has been activated. CSV 2 POST will now do more
                processing to ensure posts are updated quickly. Rather than following the schedule.',
                'success','Large','Constant Content Updating Activated','','echo');
                $csv2post_schedule_array['constantupdating']['content'] = true;    
            }else{
                // user wants constant updating off so we remove the setting to make the array as small as possible
                if(isset($csv2post_schedule_array['constantupdating']['content'])){
                    unset($csv2post_schedule_array['constantupdating']['content']);
                    csv2post_notice('Constant post content updating has been disabled. CSV 2 POST will now
                    update posts based on the schedule, if the schedule has been configured and project
                    update settings saved. Otherwise no post content updating will be carried out.',
                    'success','Large','Constant Content Updating Disabled','','echo');
                }
            }
        }
        
        csv2post_update_option_schedule_array($csv2post_schedule_array);
        
        return false;
    }else{
        return true;
    }       
} 
  
/**
* Saves default author 
*/
function csv2post_form_save_default_author(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'defaultauthor'){
        global $csv2post_project_array,$csv2post_currentproject_code;

        if($_POST['csv2post_defaultauthor_select'] == 'notselected' || !is_numeric($_POST['csv2post_defaultauthor_select'])){
            csv2post_notice('You did not select an author, please try again.','error','Large','No Author Selected','','echo');
            return false;
        }
        
        $csv2post_project_array['authors']['defaultauthor'] = $_POST['csv2post_defaultauthor_select'];
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 

        csv2post_notice('Your default author has been saved.','success','Large','Default Author Saved','','echo');
         
        return false;
    }else{
        return true;
    }       
} 
  
/**
* Save Ultimate Taxonomy Manager category settings
*/
function csv2post_form_save_ultimatetaxonomymanager_categories(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ultimatetaxonomymanagercategories'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        // get and loop through ultimate taxonomy manager taxonomy fields 
        ### TODO:LOWPRIORITY, change this to only cycle through category related custom fields and do the same with the interface in categories screen        
        $catfields = csv2post_sql_ultimatetaxonomymanager_taxonomyfield();### TODO:LOWPRIORITY, change this too a function that gets category related custom fields only
        if(!$catfields){
            
            echo csv2post_notice('You do not appear to have used Ultimate Taxonomy Manager to create any custom taxonomy fields yet.','info','Large','No Custom Taxonomy Fields','','return');
            return false;
            
        }else{    
          
            // loop 5 times for five levels of categories
            for($i = 1; $i < 6; $i++){
                
                // now loop through category fields
                foreach ($catfields as $catfield){
                    
                    // did user make selection for current field and current category level
                    if(isset($_POST['csv2post_utm_categorylevel'.$i.'_myfieldone'])){
                    
                        $csv2post_project_array['categories']['level'.$i]['utm'][$catfield->field_name]['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_utm_categorylevel'.$i.'_'.$catfield->field_name]);
                        $csv2post_project_array['categories']['level'.$i]['utm'][$catfield->field_name]['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_utm_categorylevel'.$i.'_'.$catfield->field_name]);            
   
                    }
                }
            } 
        
        }  

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 

        csv2post_notice('You have saved category taxonomy settings for using with Ultimate Taxonomy Manager plugin.',
        'success','Large','Ultimate Taxonomy Manager Category Settings Saved','','echo');
        
        return false;
    }else{
        return true;
    }       
}       
  

/**
* Save title data column
*/
function csv2post_form_save_title_data_column(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'titlecolumn'){
        global $csv2post_project_array,$csv2post_currentproject_code;

        $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_titlecolumn_menu']);
        $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_titlecolumn_menu']);            

        $csv2post_project_array['posttitles']['table'] = $table_name;            
        $csv2post_project_array['posttitles']['column'] = $column_name;       

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('The column holding post titles data has been saved. The plugin will only use this
        column and will not use any title templates you may have setup.','success','Large','Post Titles Column Saved','','echo');
                
        return false;
    }else{
        return true;
    }       
}      
 
/**
* Updates a single giving post using post ID                         
*/
function csv2post_form_update_post(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'updatespecificpost'){

        // if post id not set
        if(!isset($_POST['csv2post_update_post_with_id'])){
            csv2post_notice('You did not enter a post ID. You must enter the ID for the post you want to apply updating too.','error','Large','No Post ID','','echo');
            return false;
        }
        
        // if post id value is not numeric
        if(!is_numeric($_POST['csv2post_update_post_with_id'])){
            csv2post_notice('You appear to have submitted an invalid post ID value. It must be a number/numeric value only.','error','Large','Not A Numberic Value','','echo');
            return false;    
        }
        
        // if post does not exist
        $the_post = get_post( $_POST['csv2post_update_post_with_id'], ARRAY_A );
        if(!$the_post){
            csv2post_notice('There is no post with the ID you submitted.','warning','Large','No Matching Post','','echo');
            return false;
        }
        
        // get project code
        $project_code = get_post_meta($_POST['csv2post_update_post_with_id'], 'csv2post_project_code',true);
        
        // if not a csv2post created post
        if(!$project_code){
            csv2post_notice('The post ID you submitted does not belong too a post created using CSV 2 POST. 
            There are advanced functions to adopt none CSV 2 POST created posts that this plugin can manage them,
            please search the plugins website for more information.','info','Large','Not A CSV 2 POST Post','','echo');
            return false;    
        }
        
        // get project data
        $project_array = csv2post_get_project_array($project_code);
        
        // if no project data
        if(!$project_array){
            csv2post_notice('It appears that the project data for the post you have submitted no longer exists. A
            user of CSV 2 POST must have deleted the project that created the post. Updating cannot be done by
            CSV 2 POST in this way. You may be able to use another project to adopt the post if the posts
            data is still stored in the original project database table.','info','Large','No Project Data','','echo');
            return false;
        }
        
        // get the posts project record for further validation only
        $post_record = csv2post_sql_get_posts_record($project_array,$_POST['csv2post_update_post_with_id']);
        
        if(!$post_record){
            csv2post_notice('The record that was used to create your post no longer exists in the project database table.','error','Large','Record No Longer Exists','','echo');
            return false;
        }
        
        // if record id held in post does not retrieve a record (this confirms both record id in post is right and exists)
        $record_id = get_post_meta($_POST['csv2post_update_post_with_id'], 'csv2post_record_id', true); 
        if($record_id == false){
            csv2post_notice('The giving post does not have its record ID stored in meta. CSV 2 POST stores the
            record ID in meta to aid validation of the correct data record to be used for updating.'
            ,'error','Large','No Record ID','','echo');
            return false;
        }

        // now update post
        csv2post_post_updatepost($_POST['csv2post_update_post_with_id'],$record_id,$project_code);
        
        csv2post_notice('Your post with ID:'.$_POST['csv2post_update_post_with_id'].' has been updated.','success','Large','Post '.$_POST['csv2post_update_post_with_id'].' Updated','','echo');
                
        return false;
    }else{
        return true;
    }       
}   
 
/**
* Creates categories 
*/
function csv2post_form_create_categories(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createcategories'){
        global $csv2post_is_free;
        
        // if is premium/paid edition 
        if(!$csv2post_is_free){
            csv2post_create_categories_advanced();
        }else{
            csv2post_create_categories_basic();
        }
        
        csv2post_notice('Category creation has finished. This notification does not take the 
        result into account, it is only to let you know that processing categories has ended.',
        'info','Large','Category Creation Ended','','echo');
                
        return false;
    }else{
        return true;
    }       
}      
  
/**
* Manual data import
*/
function csv2post_form_importdata(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_importdatarequest_postmethod']) && $_POST['csv2post_importdatarequest_postmethod'] == 'true'){
        global $csv2post_is_free;
        
        // if job code not in $_POST
        if(!isset($_POST['csv2post_importdatarequest_jobcode']) || $_POST['csv2post_importdatarequest_jobcode'] == NULL || !is_string($_POST['csv2post_importdatarequest_jobcode'])){
            csv2post_notice('A data import job code was not found in the submitted form data, no import could be started.','error','Large','No Job Code Submitted','','echo');
            return false;
        }
        
        $job_code = $_POST['csv2post_importdatarequest_jobcode'];
        
        // if no csv file value in $_POST
        if(!isset($_POST['csv2post_importselection_csvfiles'])){
            csv2post_notice('No CSV file name could be found in the submitted post data, no import could be carried out.','error','Large','No CSV Filename Found','','echo');    
            return false;
        }
        
        // get filename (currently preparing for multiple file import at once so we are submitting an array) 
        $file_name = $_POST['csv2post_importselection_csvfiles'][0];

        // set row number
        $row_number = 1;
        if($csv2post_is_free){
            $row_number = 9999999;    
        }elseif(!isset($_POST['csv2post_dataimport_rownumber_'.$job_code]) || !is_numeric($_POST['csv2post_dataimport_rownumber_'.$job_code])){
            csv2post_notice('No row number for import was submitted so only 1 record will be imported from '.$file_name.'.csv.','warning','Large','No Rows Number Submitted','','echo');    
        }elseif(isset($_POST['csv2post_dataimport_rownumber_'.$job_code]) && is_numeric($_POST['csv2post_dataimport_rownumber_'.$job_code])){
            $row_number = $_POST['csv2post_dataimport_rownumber_'.$job_code];        
        }
 
        // perform data import
        $overall_result = 'success';
        $dataimportjob_array = csv2post_data_import_from_csvfile_basic($file_name,'csv2post_'.$job_code,$row_number,$job_code);
        
        // determine new $overall_result and apply styling to the main notice to suit it
        if($dataimportjob_array == false){
            $overall_result = 'error';
        }
        
        // decide message text
        if($csv2post_is_free){
            $intromes = '';
        }else{
            $intromes = '<p>You requested '.$row_number.' row/s to be imported from '.$file_name.'.</p>';    
        }
        
        // display result    
        csv2post_notice( '<h4>Data Import Result<h4>'.$intromes.'
        '.csv2post_notice( 'New Records: '.$dataimportjob_array["stats"]["lastevent"]['inserted'],'success','Small',false,'www.csv2post.com/notifications/new-records-count','return').'
        '.csv2post_notice( 'Void Records: '.$dataimportjob_array["stats"]["lastevent"]['void'],'info','Small',false,'www.csv2post.com/notifications/void-records-counter','return').'
        '.csv2post_notice( 'Dropped Rows: '.$dataimportjob_array["stats"]["lastevent"]['dropped'],'warning','Small',false,'www.csv2post.com/notifications/dropped-rows-counter','return').'
        '.csv2post_notice( 'Rows Processed: '.$dataimportjob_array["stats"]["lastevent"]['processed'],'info','Small',false,'www.csv2post.com/notifications/rows-processed-counter','return').'     
        '.csv2post_notice( 'Job Progress: '.$dataimportjob_array["stats"]["allevents"]['progress'],'info','Small',false,'www.csv2post.com/notifications/job-progress-counter','return').'    
        ',$overall_result,'Extra','','','echo'); 

        return false;
    }else{
        return true;
    }     
}
                          
/**
* Saves basic seo options          
*/
function csv2post_form_save_basic_seo_options(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'advancedseooptions'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        // title
        if(isset($_POST['csv2post_seo_titlekey_advanced']) && $_POST['csv2post_seo_titlekey_advanced'] != '' && is_string($_POST['csv2post_seo_titlekey_advanced'])){
            $csv2post_project_array['seo']['advanced']['title_key'] = $_POST['csv2post_seo_titlekey_advanced'];
            if(!isset($_POST['csv2post_seo_title_advanced'])){
                csv2post_notice('No SEO title template was selected and it is required if you want your posts
                to have meta title values.','error','Large','Please Select Title Template','','echo');
            }     
        }

        if(isset($_POST['csv2post_seo_title_advanced']) && $_POST['csv2post_seo_title_advanced'] != '' && is_numeric($_POST['csv2post_seo_title_advanced'])){
            $csv2post_project_array['seo']['advanced']['title_template'] = $_POST['csv2post_seo_title_advanced'];     
            if(!isset($_POST['csv2post_seo_titlekey_advanced'])){
                csv2post_notice('You selected a title template but did not select your SEO plugin that will be handling
                your meta titles. You must select the SEO plugin so that the proper meta key is used.','error','Large','Please Select Title Plugin','','echo');
            }        
        }        
        
        // description
        if(isset($_POST['csv2post_seo_descriptionkey_advanced']) && $_POST['csv2post_seo_descriptionkey_advanced'] != '' && is_string($_POST['csv2post_seo_descriptionkey_advanced'])){
            $csv2post_project_array['seo']['advanced']['description_key'] = $_POST['csv2post_seo_descriptionkey_advanced'];
            if(!isset($_POST['csv2post_seo_description_advanced'])){
                csv2post_notice('No SEO description template was selected and it is required if you want your posts
                to have meta description values.','error','Large','Please Select Description Template','','echo');
            }     
        }

        if(isset($_POST['csv2post_seo_description_advanced']) && $_POST['csv2post_seo_description_advanced'] != '' && is_numeric($_POST['csv2post_seo_description_advanced'])){
            $csv2post_project_array['seo']['advanced']['description_template'] = $_POST['csv2post_seo_description_advanced'];     
            if(!isset($_POST['csv2post_seo_descriptionkey_advanced'])){
                csv2post_notice('You selected a description template but did not select your SEO plugin that will be handling
                your meta description. You must select the SEO plugin so that the proper meta key is used.','error','Large','Please Select Description Plugin','','echo');
            }        
        }         
         
        // keywords
        if(isset($_POST['csv2post_seo_keywordskey_advanced']) && $_POST['csv2post_seo_keywordskey_advanced'] != '' && is_string($_POST['csv2post_seo_keywordskey_advanced'])){
            $csv2post_project_array['seo']['advanced']['keywords_key'] = $_POST['csv2post_seo_keywordskey_advanced'];
            if(!isset($_POST['csv2post_seo_keywords_advanced'])){
                csv2post_notice('No SEO keywords template was selected and it is required if you want your posts
                to have meta keywords values.','error','Large','Please Select Keywords Template','','echo');
            }     
        }

        if(isset($_POST['csv2post_seo_keywords_advanced']) && $_POST['csv2post_seo_keywords_advanced'] != '' && is_numeric($_POST['csv2post_seo_keywords_advanced'])){
            $csv2post_project_array['seo']['advanced']['keywords_template'] = $_POST['csv2post_seo_keywords_advanced'];     
            if(!isset($_POST['csv2post_seo_keywordskey_advanced'])){
                csv2post_notice('You selected a keywords template but did not select your SEO plugin that will be handling
                your meta keywords. You must select the SEO plugin so that the proper meta key is used.','error','Large','Please Select Keywords Plugin','','echo');
            }        
        }          
          
        // update $csv2post_project_array
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        csv2post_notice('Advanced SEO options have been saved.','success','Large','SEO Options Saved','','echo',false,false); 
                                 
        return false;
    }else{
        return true;
    }       
}    

/**
* Deletes random advanced shortcode rules
*/
function csv2post_form_delete_randomadvanced_shortcoderules(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deleterandomvalueshortcodes'){
        
        if(isset($_POST['csv2post_shortcodeadvanced_delete'])){
            global $csv2post_textspin_array;
            if(is_array($_POST['csv2post_shortcodeadvanced_delete'])){
                foreach($_POST['csv2post_shortcodeadvanced_delete'] as $key => $shortcode_name){
                    if(isset($csv2post_textspin_array['randomvalue'][ $shortcode_name ])){
                        unset($csv2post_textspin_array['randomvalue'][ $shortcode_name ]);
                    }        
                }
                csv2post_update_option_textspin($csv2post_textspin_array);
                csv2post_notice('All selected advanced random value shortcode rules have been deleted.','success','Large','Shortcode Rules Deleted','','echo');
                return false;    
            }else{
                if(isset($csv2post_textspin_array['randomvalue'][ $_POST['csv2post_shortcodeadvanced_delete'] ])){
                    unset($csv2post_textspin_array['randomvalue'][ $_POST['csv2post_shortcodeadvanced_delete'] ]);
                    csv2post_update_option_textspin($csv2post_textspin_array);
                    csv2post_notice('The selected advanced random value shortcode rule has been deleted.','success','Large','Shortcode Rules Deleted','','echo');
                    return false;
                }    
            }    
        }
        
        // we do a return on success - arriving here means no shortcode rules were deleted
        csv2post_notice('No shortcode rules have been deleted, please try again then seek support.','error','Large','Shortcode Rules Not deleted','','echo');
        return false;
    }else{
        return true;
    }       
}  
  
/**
* Save a new HTML shortcode - this one offers a shortcode showing shortcode name (no need for user to enter values in shortcode) 
*/
function csv2post_form_save_htmlshortcode(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createrandomvalueshortcodes'){
        
        // error if name not entered
        if(!isset($_POST['csv2post_shortcodename']) || $_POST['csv2post_shortcodename'] == '' || $_POST['csv2post_shortcodename'] == ' '){
            csv2post_notice('You did not enter a shortcode name, please enter a name that will help you remember what values you have setup.','error','Large','No Shortcode Name Submitted','','echo',false);    
            return false;// stops further post processing
        }
        
        // ensure at least one value has been set
        $values_set = 0;
        for ($i = 1; $i <= 8; $i++) {
            if(isset($_POST['csv2post_textspin_v' . $i]) && $_POST['csv2post_textspin_v' . $i] != NULL && $_POST['csv2post_textspin_v' . $i] != ''){
                ++$values_set;    
            }
        }
        
        if($values_set < 2){
            csv2post_notice('You must enter at least two values. Please populate two or more of the text fields.','error','Large','More Values Required','','echo');
            return false;// stops further post processing
        }
        
        // if name already exists
        global $csv2post_textspin_array;
        if(isset($csv2post_textspin_array['randomvalue'][ $_POST['csv2post_shortcodename'] ])){
            csv2post_notice('The shortcode name you submitted already exists, please use a different name or delete the existing shortcode.','warning','Large','Shortcode Name Exists Already','','echo');
            return false;
        }
                
        // cant assume user filled out text fields in order so go through all of them
        for ($i = 1; $i <= 8; $i++) {
            if(isset($_POST['csv2post_textspin_v' . $i]) && $_POST['csv2post_textspin_v' . $i] != NULL && $_POST['csv2post_textspin_v' . $i] != ''){
                // dont use for loop $i as key because some values may not be set
                $csv2post_textspin_array['randomvalue'][ $_POST['csv2post_shortcodename'] ]['values'][] = $_POST['csv2post_textspin_v' . $i];   
            }
        }        
        
        csv2post_update_option_textspin($csv2post_textspin_array);      

        csv2post_notice('You saved a new Random Value Shortcode named ' . $_POST['csv2post_shortcodename'] . '. You
        can use this shortcode by copying and pasting this bold text: <br />
        <strong>[csv2post_random_advanced name="'.$_POST['csv2post_shortcodename'].'"]</strong>','success','Large','Random Value Shortcode Created','','echo');

        return false;
    }else{
        return true;
    }       
}
  
/**
* Saves Multiple File Project panel - the configuration options that create relationships between tables
*/
function csv2post_form_save_multiplefilesproject(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'multipletableproject'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        // ensure there are not too many "notrequired" values submitted
        foreach($csv2post_project_array['tables'] as $key => $table_name){
            
            // set tables own key column
            if(isset($_POST["csv2post_multitable_columns_" . $table_name])){
                if($_POST["csv2post_multitable_pairing_" . $table_name] != 'notrequired'){
                    $csv2post_project_array['multipletableproject']['relationships'][$table_name]['primarykey'] = $_POST["csv2post_multitable_columns_" . $table_name];    
                }else{
                    $csv2post_project_array['multipletableproject']['relationships'][$table_name]['primarykey'] = false;                    
                }
            }    

            // set the table and column (foreign key) that the current tables primary key has a relationship with
            if(isset($_POST["csv2post_multitable_pairing_" . $table_name])){
                
                if($_POST["csv2post_multitable_pairing_" . $table_name] != 'notrequired'){
                    // extract table and column name from $_POST value
                    $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST["csv2post_multitable_pairing_" . $table_name]); 
                    $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST["csv2post_multitable_pairing_" . $table_name]);    
                }else{
                    $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_table'] = false; 
                    $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_column'] = false;                    
                }
            }
                   
        } 
        
        // update $csv2post_project_array
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);        
             
        csv2post_notice('Your configuration for the current multiple files project has been saved. 
        If done properly the relationship setup should allow CSV 2 POST to query records 
        properly during post creation.','success','Large','Multiple Files Project','','echo');
        
        ### TODO:LOWPRIORITY, add tests here if there is data in all of the tables, check that primary key columns have matching data in foreign key columns 
        
        return false;
    }else{
        return true;
    }          
} 
  
/**
* Create a data rule for replacing specific values after import 
*/
function csv2post_form_save_eventtypes(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'eventtypes'){
        global $csv2post_schedule_array;   

        $csv2post_schedule_array['eventtypes']["postcreation"] = $_POST["csv2post_eventtype_postcreation"];
        $csv2post_schedule_array['eventtypes']["postupdate"] = $_POST["csv2post_eventtype_postupdate"];
        $csv2post_schedule_array['eventtypes']["dataimport"] = $_POST["csv2post_eventtype_dataimport"];
        $csv2post_schedule_array['eventtypes']["dataupdate"] = $_POST["csv2post_eventtype_dataupdate"];
        $csv2post_schedule_array['eventtypes']["twittersend"] = $_POST["csv2post_eventtype_twittersend"];
        $csv2post_schedule_array['eventtypes']["twitterupdate"] = $_POST["csv2post_eventtype_twitterupdate"];
        $csv2post_schedule_array['eventtypes']["twitterget"] = $_POST["csv2post_eventtypes_twitterget"];
        
        csv2post_update_option_schedule_array($csv2post_schedule_array);
        
        csv2post_notice('Schedule event types have been saved, the changes will have an effect on the types of events run, straight away.','success','Large','Schedule Event Types Saved','','echo');
        return false;
    }else{
        return true;
    }          
} 
    
/**
* Create a data rule for replacing specific values after import 
*/
function csv2post_form_create_datarule_replacevalue(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'replacevalues'){
        global $csv2post_currentjob_code;

        echo '<p>UNDER CONSTRUCTION</p>';

        return false;
    }else{
        return true;
    }          
} 

/**
* Saves tag rules submission
*/
function csv2post_form_save_tag_rules(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'tagrules'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        // save numeric allow/disallow setting
        if(isset($_POST['csv2post_numerics'])){
            $csv2post_project_array['tags']['rules']['numericterms'] = $_POST['csv2post_numerics'];    
        }
        
        // save excluded terms
        if(isset($_POST['csv2post_excludedtag']) && is_string($_POST['csv2post_excludedtag'])){
            
            // if there are already excluded terms, we need to put them into string for joining to new submission
            $old_string = '';
            if(isset($csv2post_project_array['tags']['rules']['excluded']) && is_array($csv2post_project_array['tags']['rules']['excluded'])){
                $old_string = implode($csv2post_project_array['tags']['rules']['excluded']);
            }
            
            $new_string = $_POST['csv2post_excludedtag'] . ',' . $old_string;
            
            $csv2post_project_array['tags']['rules']['excluded'] = explode(',',$new_string);   
        }
        
        // save tags per post
        if(isset($_POST['csv2post_tagsperpost']) && is_numeric($_POST['csv2post_tagsperpost'])){
            $csv2post_project_array['tags']['rules']['tagsperpost'] = $_POST['csv2post_tagsperpost'];    
        }
        
        // save tag string length
        if(isset($_POST['csv2post_tagstringlength']) && is_numeric($_POST['csv2post_tagstringlength'])){
            $csv2post_project_array['tags']['rules']['tagstringlength'] = $_POST['csv2post_tagstringlength'];    
        }
        
        // delete tags
        if(isset($_POST['csv2post_tagslist_delete'])){
            foreach($_POST['csv2post_tagslist_delete'] as $key => $delete_tag){
                ### TODO:HIGHPRIORITY, establish the best way to locate the tags in array and unset them    
            }
        }       

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Tag rules have been saved.','success','Large','Tag Rules/Settings Saved','','echo');
                
        return false;
    }else{
        return true;
    }          
} 
 
  
/**
* Saves advanced tag generator settings 
*/
function csv2post_form_save_tag_generator_settings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'generatetags'){
        global $csv2post_project_array,$csv2post_currentproject_code;
      
        if(!isset($_POST["csv2post_taggenerator_columns"])){
            csv2post_notice('No columns were selected. You must select data columns that hold suitable values for generating tags with.','error','Large','Please Select Columns','','echo');    
            return false;
        }
        
        // loop through selected columns
        foreach($_POST["csv2post_taggenerator_columns"] as $key => $table_column ){
            $csv2post_project_array['tags']['generator']['data'][$key]['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$table_column);
            $csv2post_project_array['tags']['generator']['data'][$key]['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$table_column);            
        }
        
        $csv2post_project_array['tags']['method'] = 'generator';       
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Tag generator settings have been saved and CSV 2 POST will generator tags from your selected columns for all posts.','success','Large','Tag Generator Settings Saved','','echo');
        
        return false;
    }else{
        return true;
    }          
}

/**
* Resets publish date method to Wordpress default by deleting the "dates" value in project array 
*/
function csv2post_form_set_datemethod_default(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'projectdatemethod'){
        global $csv2post_currentproject_code,$csv2post_project_array;

        unset($csv2post_project_array['dates']['currentmethod']); 
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('The current projects publish dates will be controlled by Wordpress default.','success','Large','Publish Date Method Reset','','echo');      
  
        return false;
    }else{
        return true;
    }          
}

/**
* Deletes one or more database tables
*/
function csv2post_form_drop_database_tables(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createddatabasetableslist'){

        if(!isset($_POST["csv2post_table_array"])){
            csv2post_notice('You did not select any database tables. Check the boxes for the tables you want to delete.','warning','Large','No Tables Deleted','','echo');
            return false;
        }else{
            
            global $wpdb,$csv2post_jobtable_array,$csv2post_dataimportjobs_array;
   
            foreach($_POST["csv2post_table_array"] as $key => $table_name){
                
                // if table is in use by a data import job we do not delete it, the job must be deleted first
                $code = str_replace('csv2post_','',$table_name);   
                
                if(isset($csv2post_dataimportjobs_array[$code])){
                    csv2post_notice('Table named '.$table_name.' is still used by Data Import Job named '.$csv2post_dataimportjobs_array[$code]['name'].'. Please delete the job first then delete the database table.','warning','Large','Cannot Delete ' . $table_name,'','echo');
                }else{
                    
                    // drop table
                    ### TODO:LOWPRIORITY, put statement in here to handle failed DROP TABLE should user attempt to drop none existing tables
                    $wpdb->query( 'DROP TABLE '. $table_name );
                    
                    // remove table from $csv2post_jobtable_array
                    foreach($csv2post_jobtable_array as $key => $jobtable_name){
                        if($table_name == $jobtable_name){

                            unset($csv2post_jobtable_array[ $key ]);
                            csv2post_update_option_jobtables_array($csv2post_jobtable_array);
                            break;
                        }
                    } 
                                            
                    csv2post_notice('','success','Small','Database Table Deleted: '.$table_name,'','echo');
                }  
            }
        }

        return false;
    }else{
        return true;
    }          
}

/**
* Deletes basic custom field rules
* @todo HIGHPRIORITY, change to delete many checked boxes at once not just one
*/
function csv2post_form_delete_basiccustomfields(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deletebasiccustomfieldrules'){
        global $csv2post_currentproject_code,$csv2post_project_array;
   
        unset($csv2post_project_array['custom_fields']['basic'][$_POST['csv2post_customfield_rule_arraykey']]);                        
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('You have deleted a basic custom field rule, one less meta value will be added to all posts from here on in this project.','success','Large','Basic Custom Field Rule Deleted','','echo');      

        return false;
    }else{
        return true;
    }          
}
  
/**
* Deletes advanced custom field rules
* @todo HIGHPRIORITY, change to delete many checked boxes at once not just one 
*/
function csv2post_form_delete_advancedcustomfields(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deleteadvancedcustomfieldrules'){
        global $csv2post_currentproject_code,$csv2post_project_array;
   
        unset($csv2post_project_array['custom_fields']['advanced'][$_POST['csv2post_customfield_rule_arraykey']]);                        
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('You have deleted an advanced custom field rule, one less meta value will be added to all posts from here on in this project.','success','Large','Advanced Custom Field Rule Deleted','','echo');      

        return false;
    }else{
        return true;
    }    
} 
    
/**
* Saves and activates incremental publish date settings
* @todo LOWPRIORITY, validate dates 
*/
function csv2post_form_save_incrementalpublishdate_settings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'incrementalpublishdatessettings'){
        global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;
   
        // do not allow save if free edition (bypassing this will cause problems during post creation)
        if($csv2post_is_free){
            csv2post_notice('The data method you submitted can only be used in the paid editions advanced post creation scripts. Your post publish dates will always default to the current time and date when they are created.','warning','Large','Date Method Not Available','','echo');
            return false;
        }
        
        // replace spaces in minutes increment string
        $minutes_increment = str_replace(' ','',$_POST['csv2post_increment_range']);
        $explode = explode('-',$minutes_increment);

        $csv2post_project_array['dates']['currentmethod'] = 'increment'; 
        $csv2post_project_array['dates']['increment']['start'] = $_POST['csv2post_publishdateincrement_start'];
        $csv2post_project_array['dates']['increment']['short'] = $explode[0];
        $csv2post_project_array['dates']['increment']['long'] = $explode[1];                
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Increment publish date settings have been saved. This method of applying publish dates has also been activated. Submit another form if you do not want to activate the incremental publish date method.','success','Large','Incremental Publish Date Settings Saved','','echo');      

        return false;
    }else{
        return true;
    }     
}

/**
* Saves and activates random publish date method settings
* @todo LOWPRIORITY, validate submitted dates, ensure end date is not before start  
*/
function csv2post_form_save_randompublishdate_settings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'randompublishdatesettings'){
        global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;
      
        // do not allow save if free edition (bypassing this will cause problems during post creation)
        if($csv2post_is_free){
            csv2post_notice('The data method you submitted can only be used in the paid editions advanced post creation scripts. Your post publish dates will always default to the current time and date when they are created.','warning','Large','Date Method Not Available','','echo');
            return false;
        }
              
        $csv2post_project_array['dates']['currentmethod'] = 'random'; 
        $csv2post_project_array['dates']['random']['start'] = $_POST['csv2post_randompublishdate_start'];
        $csv2post_project_array['dates']['random']['end'] = $_POST['csv2post_randompublishdate_end'];

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Random publish date settings have been saved. This method of applying publish dates has also been activated. Submit another form if you do not want to activate the random publish date method.','success','Large','Random Publish Date Settings Saved','','echo');      
  
        return false;
    }else{
        return true;
    }      
}      
  
// Save category mapping (data values too)
function csv2post_form_save_category_mapping(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createcategorymappingrules'){
        global $csv2post_currentproject_code,$csv2post_project_array;
        
        // loop number of set category levels 
        for($lev = 1; $lev <= $_POST['csv2post_category_levels']; $lev++){

            // loop the number of distinct values in the current level i.e. 8 times for 8 distinct values in column
            for($dis = 1; $dis <= $_POST['csv2post_distinct_values_count_lev'.$lev]; $dis++){

                // this holds distinct value
                $_POST['csv2post_distinct_value_lev'.$lev.'_inc'.$dis];    
                // i.e. $_POST['csv2post_distinct_value_lev3_inc8']

                // ensure menu option is not "notselected" and the expected DISTINCT value is not null
                if(isset($_POST['csv2post_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select']) && $_POST['csv2post_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select'] != 'notselected' ){

                    $csv2post_project_array['categories']['level'.$lev]['mapping'][ $_POST['csv2post_distinct_value_lev'.$lev.'_inc'.$dis] ] = $_POST['csv2post_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select'];

                }

            }
   
        }   
 
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Your category mapping has been saved','success','Large','Category Mapping Saved','','echo');

        return false;
    }else{
        return true;
    }      
}     
     
/**
* Saves advanced category submission 
*/
function csv2post_form_save_categories_advanced(){
    global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'advancedcategories'){
        
        // ensure the previous column has been selected for every column user submits
        $required_column_missing = false;// set to true if a required column has not been selected
        $required_column_level = false;// change too level 1,2,3 or 4 to indicate which column has not been selected but should be
        
        // check for level 1 - always required
        if( $_POST['csv2post_categorylevel1_advanced'] == 'notselected' ){
            csv2post_notice('You did not select a level one data table and column, you must always use level one if you want to create categories using this panel.','error','Large','Level One Not Selected');
            return false;//discontinue post function processing
        }
        
        // check if 3 is set - requires 2
        if( $_POST['csv2post_categorylevel3_advanced'] != 'notselected' && $_POST['csv2post_categorylevel2_advanced'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 2;
        }
        
        // check if 4 is set - requires 3
        if( !$csv2post_is_free && $_POST['csv2post_categorylevel4_advanced'] != 'notselected' && $_POST['csv2post_categorylevel3_advanced'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 3;
        }       
        
        // check if 5 is set - requires 4
        if( !$csv2post_is_free && $_POST['csv2post_categorylevel5_advanced'] != 'notselected' && $_POST['csv2post_categorylevel4_advanced'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 4;
        }        
        
        // only continue if all required columns have been selected
        if($required_column_missing){
            $column_above_missing_level = $required_column_level + 1;
            csv2post_notice('You did not appear to select all required columns. You selected a column for category level '.$column_above_missing_level.' but did not select one for category level '.$required_column_level.'. You must select category columns in order as displayed i.e. use 1,2 and 3 for three levels not 1,2 and 4.','error','Large','Missing Category Column Selection');
            return false;// discontinues post functions processing        
        }else{
    
            $csv2post_project_array = csv2post_get_project_array($csv2post_currentproject_code);   
            
            // add level 1 
            $csv2post_project_array['categories']['level1']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel1_advanced']);
            $csv2post_project_array['categories']['level1']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel1_advanced']);            

            // save level 1 description template id if selected
            if(isset($_POST['csv2post_categorylevel1_description'])){
                $csv2post_project_array['categories']['level1']['description'] = $_POST['csv2post_categorylevel1_description'];        
            }
            
            // add level 2
            if($_POST['csv2post_categorylevel2_advanced'] != 'notselected'){
                $csv2post_project_array['categories']['level2']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel2_advanced']);
                $csv2post_project_array['categories']['level2']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel2_advanced']);                     
            
                // save level 2 description template id if selected
                if(isset($_POST['csv2post_categorylevel2_description'])){
                    $csv2post_project_array['categories']['level2']['description'] = $_POST['csv2post_categorylevel2_description'];        
                }            
            }
            
            // add level 3
            if($_POST['csv2post_categorylevel3_advanced'] != 'notselected'){
                $csv2post_project_array['categories']['level3']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel3_advanced']);
                $csv2post_project_array['categories']['level3']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel3_advanced']);                     
            
                // save level 3 description template id if selected
                if(isset($_POST['csv2post_categorylevel2_description'])){
                    $csv2post_project_array['categories']['level3']['description'] = $_POST['csv2post_categorylevel3_description'];        
                }            
            }                

            // add level 4
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel4_advanced'] != 'notselected'){
                $csv2post_project_array['categories']['level4']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel4_advanced']);
                $csv2post_project_array['categories']['level4']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel4_advanced']);                     

                // save level 4 description template id if selected
                if(isset($_POST['csv2post_categorylevel4_description'])){
                    $csv2post_project_array['categories']['level4']['description'] = $_POST['csv2post_categorylevel4_description'];        
                }            
            }
            
            // add level 5
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel5_advanced'] != 'notselected'){
                $csv2post_project_array['categories']['level5']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel5_advanced']);
                $csv2post_project_array['categories']['level5']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel5_advanced']);                     
            
                // save level 5 description template id if selected
                if(isset($_POST['csv2post_categorylevel5_description'])){
                    $csv2post_project_array['categories']['level5']['description'] = $_POST['csv2post_categorylevel5_description'];        
                }       
            }            
  
            // update project option         
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
            
            csv2post_notice('Your advanced category configuration has been saved and categories will be created during post creation. Posts will be assigned to their proper category.','success','Large','Standard Category Settings Saved');    

        }

        return false;
    }else{
        return true;
    }      
}

/**
* Saves default category (ID only)  
*/
function csv2post_form_save_default_category(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'defaultcategory'){
        
        $csv2post_project_array['categories']['default'] = $_POST['csv2post_defaultcategory_select'];

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Your default category has been saved','success','Large','Default Category Saved','','echo');

        return false;
    }else{
        return true;
    }      
} 
 
/**
* Save default tags column and table 
*/
function csv2post_form_save_default_tags_column(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'premadetagscolumn'){
        
        $csv2post_project_array['tags']['default']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_defaulttagsdata_select_columnandtable']);
        $csv2post_project_array['tags']['default']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_defaulttagsdata_select_columnandtable']);                       
        $csv2post_project_array['tags']['method'] = 'premade';
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        csv2post_notice('Your default tags column has been saved and if the tags are formatted as required by Wordpress they will be added to your posts.','success','Large','Default Tags Column Saved');    
                 
        return false;
    }else{
        return true;
    }      
}

/**
* Process post creation for giving project 
*/
function csv2post_form_start_post_creation(){
    global $csv2post_projectslist_array,$csv2post_schedule_array,$csv2post_is_free,$csv2post_project_array,$csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createpostsproject'){
        
        // store post type in project array
        if(isset($_POST['csv2post_radio_poststatus'])){
            $csv2post_project_array['poststatus'] = $_POST['csv2post_radio_poststatus'];
        }
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
          
        // free edition processes all records at once, $_POST['csv2post_postsamount'] will not be set
        $target_posts = 999999;
        if(!$csv2post_is_free){
            $target_posts = $_POST['csv2post_postsamount'];    
        }
    
        // call create posts function     
        $post_id = csv2post_create_posts($_POST['csv2post_project_code'],$target_posts,'manual');
        if($post_id){
            
            // no false returned (false indicates a failure)
            // $post_id will be the last post ID created
            csv2post_notice('Post creation went smoothly, no problems were detected. The last post ID created was <strong>'.$post_id.'</strong>.','success','Large','Post Creation Complete','','echo');
            ### TODO:LOWPRIORITY, add link and url too last created post to the output
                
        }else{
           
           // must be a failure, if multiple posts were requests the failure is big enough to output it to the user
           csv2post_notice('A problem was detected during the post creation process. The severity can only be established by checking logs and any posts created or expected to have been created.','error','Large','Problem Detected During Post Creation','','echo');
        
        }
         
        return false;
    }else{
        return true;
    }      
}

/**
* Process CSV file upload      
*/
function csv2post_form_upload_csv_file(){
    global $csv2post_projectslist_array,$csv2post_schedule_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'uploadcsvfile'){

        $upload = $_FILES['file'];  

        // check error
        if($upload['error'] != 0){
            csv2post_notice('Could not upload file, error code: ' . $upload['error'],'error','Large','Upload Failed');
            return false;// not returning false due to failure, only returning false to indicate end of processing            
        }     
        
        // ensure file destination exists
        $open_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        if(!$open_result){
            csv2post_notice('File was not uploaded. Could not open the destination folder. The folder is named wpcsvimportercontent and should be in the wp-content directory. Please fix this before trying again.','error','Large','File Not Upload');
            return false;
        }

        // check if filename already exists in destination - we will let the user know they wrote over an existing file
        $target_file_path =  WTG_C2P_CONTENTFOLDER_DIR . '/' . $upload['name'];
        $target_file_path_exists = file_exists( $target_file_path );
        if($target_file_path_exists){
            // get existing files datestamp - we use it to ensure the new file is newer/changed and trigger data update
            $oldtime = filemtime( $target_file_path );
                    
            // delete the existing file
            unlink( $target_file_path );
            
            if ( file_exists( $target_file_path )){
                csv2post_notice('The name of your file being uploaded already exists in the target folder. CSV 2 POST could not remove the existing file, but it should have. It may be because the existing file is in use, please investigate this then try again if required. If some sort of permissions problem is causing this, you may delete the existing file using FTP also.','error','Large','Existing File Not Removed');    
                // return now due to not being able to remove the existing file
                return false;
            }
            
            // file must not exist, unlink was success, let user know this was done
            csv2post_notice('The file name being uploaded existed already. The existing file was replaced.','info','Large','File Replaced');        
        }
        
        // now move temp file into target path
        $move_result = move_uploaded_file( $upload['tmp_name'], $target_file_path );
        
        // did the move fail
        if(!$move_result){
            csv2post_notice('Failed to upload file, there was a problem moving the temporary file into the target directory, please investigate this issue.','error','Large','Upload Failed');
            return false;
        }
        
        // check that file is now in place
        if(!file_exists($target_file_path)){
            csv2post_notice('The server confirmed that the file was uploaded and put into the target directory but it does not appear to be there. Please report this problem.','error','Large','Uploaded File Missing');
            return;
        }
        
        // upload is a success
        csv2post_notice('CSV file has been uploaded, you should now create a Data Import Job and select your new uploaded file.','success','Large','CSV File Uploaded');

        return false;
    }else{
        return true;
    }      
}  
  
/**
* Save drip feed limits  
*/
function csv2post_form_save_schedulelimits(){
    global $csv2post_projectslist_array,$csv2post_schedule_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'schedulelimits'){

        // if any required values are not in $_POST set them to zero
        if(!isset($_POST['day'])){
            $csv2post_schedule_array['limits']['day'] = 0;        
        }else{
            $csv2post_schedule_array['limits']['day'] = $_POST['day'];            
        }
        
        if(!isset($_POST['hour'])){
            $csv2post_schedule_array['limits']['hour'] = 0;
        }else{
            $csv2post_schedule_array['limits']['hour'] = $_POST['hour'];            
        }
        
        if(!isset($_POST['session'])){
            $csv2post_schedule_array['limits']['session'] = 0;
        }else{
            $csv2post_schedule_array['limits']['session'] = $_POST['session'];            
        }
        
        csv2post_update_option_schedule_array($csv2post_schedule_array);
        
        csv2post_notice('Your drip-feed limits have been set and will take effect on all projects right now.','success','Large','Drip-Feeding Limits Saved');        
        
        return false;
    }else{
        return true;
    }      
}
   
/**
* Saves global allowed days and hours
*/
function csv2post_form_save_scheduletimes_global(){
    global $csv2post_projectslist_array,$csv2post_schedule_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'scheduletimes'){

        // ensure $csv2post_schedule_array is an array, it may be boolean false if schedule has never been set
        if(isset($csv2post_schedule_array) && is_array($csv2post_schedule_array)){
            
            // if times array exists, unset the [times] array
            if(isset($csv2post_schedule_array['times']['days'])){
                unset($csv2post_schedule_array['times']['days']);    
            }
            
            // if hours array exists, unset the [hours] array
            if(isset($csv2post_schedule_array['times']['hours'])){
                unset($csv2post_schedule_array['times']['hours']);    
            }
            
        }else{
            
            // $schedule_array value is not array, this is first time it is being set
            $csv2post_schedule_array = array();
        }
        
        // loop through all days and set each one to true or false
        if(isset($_POST['csv2post_scheduleday_list'])){

            foreach($_POST['csv2post_scheduleday_list'] as $key => $submitted_day){
                $csv2post_schedule_array['times']['days'][$submitted_day] = true;        
            }
               
        } 
        
        // loop through all hours and add each one too the array, any not in array will not be permitted                              
        if(isset($_POST['csv2post_schedulehour_list'])){
            
            foreach($_POST['csv2post_schedulehour_list'] as $key => $submitted_hour){
                $csv2post_schedule_array['times']['hours'][$submitted_hour] = true;        
            }            
            
        }    

        csv2post_update_option_schedule_array($csv2post_schedule_array);
        
        csv2post_notice('You permitted days and hours for scheduled drip-feeding have been saved.','success','Large','Schedule Times Saved');

        return false;
    }else{
        return true;
    }    
}

/**
* Save drip feeding project switch, makes drip feeding for projects on or off, globaly   
*/
function csv2post_form_save_dripfeedprojects_switch(){
    global $csv2post_projectslist_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'dripfeedprojects'){

        // if no project codes submitted then this project (all projects) is off on drip feeding
        if(!isset($_POST['csv2post_dripfeedprojects_list'])){

            // user has set all posts to manual only - loop through all projects and set them to off
            foreach( $csv2post_projectslist_array as $code => $project ){
                $csv2post_projectslist_array[$code]['dripfeeding'] = 'off';
            }           
 
        }else{
            
            // loop through submitted codes - those projects are to be on for drip feeding        
            foreach( $_POST['csv2post_dripfeedprojects_list'] as $key => $project_code ){
                $csv2post_projectslist_array[$project_code]['dripfeeding'] = 'on';
            }            
        }
        
        csv2post_update_option_postcreationproject_list($csv2post_projectslist_array);
        
        csv2post_notice('Drip feed settings have been saved.','success','Large','Drip Feed Settings Saved');
        
        return false;
    }else{
        return true;
    }    
}   
   
/**
* Save project update settings
*/
function csv2post_form_save_projectupdatesettings(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'postcontentupdatingsettings'){

        $csv2post_project_array['updating']['content']['settings']['switch'] = $_POST['csv2post_updatesettings_postupdating_switch_inputname'];
        $csv2post_project_array['updating']['content']['settings']['public'] = $_POST['csv2post_updatesettings_postupdating_public_inputname'];
        $csv2post_project_array['updating']['content']['settings']['speed'] = $_POST['csv2post_updatesettings_postupdating_speed_inputname'];
        $csv2post_project_array['updating']['content']['settings']['old'] = $_POST['csv2post_updatesettings_postupdating_old_inputname'];
        $csv2post_project_array['updating']['content']['settings']['oldmethod'] = $_POST['csv2post_updatesettings_postupdating_oldmethod_inputname'];

        // update project option         
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        csv2post_notice('Your post content updating settings have been saved and will take effect straight away.','success','Large','Content Updating Settings Saved');    
                
        return false;
    }else{
        return true;
    }    
}      
    
/**
* Saves basic categories form
*/
function csv2post_form_save_categories_standard(){
    global $csv2post_currentproject_code,$csv2post_is_free,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'standardcategories'){

        // ensure the previous column has been selected for every column user submits
        $required_column_missing = false;// set to true if a required column has not been selected
        $required_column_level = false;// change too level 1,2,3 or 4 to indicate which column has not been selected but should be
        
        // check for level 1 - always required
        if( $_POST['csv2post_categorylevel1_select_columnandtable'] == 'notselected' ){
            csv2post_notice('You did not select a level one data table and column, you must always use level one if you want to create categories using this panel.','error','Large','Level One Not Selected');
            return false;//discontinue post function processing
        }
        
        // check if 3 is set - requires 2
        if( $_POST['csv2post_categorylevel3_select_columnandtable'] != 'notselected' && $_POST['csv2post_categorylevel2_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 2;
        }
        
        // check if 4 is set - requires 3
        if( !$csv2post_is_free && $_POST['csv2post_categorylevel4_select_columnandtable'] != 'notselected' && $_POST['csv2post_categorylevel3_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 3;
        }       
        
        // check if 5 is set - requires 4
        if( !$csv2post_is_free && $_POST['csv2post_categorylevel5_select_columnandtable'] != 'notselected' && $_POST['csv2post_categorylevel4_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 4;
        }        
        
        // only continue if all required columns have been selected
        if($required_column_missing){
            $column_above_missing_level = $required_column_level + 1;
            csv2post_notice('You did not appear to select all required columns. You selected a column for category level '.$column_above_missing_level.' but did not select one for category level '.$required_column_level.'. You must select category columns in order as displayed i.e. use 1,2 and 3 for three levels not 1,2 and 4.','error','Large','Missing Category Column Selection');
            return false;// discontinues post functions processing        
        }else{
    
            $csv2post_project_array = csv2post_get_project_array($csv2post_currentproject_code);   
            
            // add level 1 
            $csv2post_project_array['categories']['level1']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel1_select_columnandtable']);
            $csv2post_project_array['categories']['level1']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel1_select_columnandtable']);            

            // add level 2
            if($_POST['csv2post_categorylevel2_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level2']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel2_select_columnandtable']);
                $csv2post_project_array['categories']['level2']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel2_select_columnandtable']);                     
            }
            
            // add level 3
            if($_POST['csv2post_categorylevel3_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level3']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel3_select_columnandtable']);
                $csv2post_project_array['categories']['level3']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel3_select_columnandtable']);                     
            }                

            // add level 4
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel4_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level4']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel4_select_columnandtable']);
                $csv2post_project_array['categories']['level4']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel4_select_columnandtable']);                     
            }
            
            // add level 5
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel5_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level5']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel5_select_columnandtable']);
                $csv2post_project_array['categories']['level5']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel5_select_columnandtable']);                     
            }            
  
            // update project option         
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
            
            csv2post_notice('Your basic type category configuration has been saved and categories will be created during post creation. Posts will be assigned to their proper category.','success','Large','Standard Category Settings Saved');    

        }
            
        return false;
    }else{
        return true;
    }    
}    
    
/**
* Adds basic custom fields
*/
function csv2post_form_add_basic_custom_field(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createbasiccustomfieldrules'){

        // ensure meta-key was entered ### TODO:LOWPRIORITY, validate meta-key
        if(!isset($_POST['csv2post_key'])){
        
            csv2post_notice('You did not enter a meta-key for your custom field rule, please try again.','error','Large','No Meta-Key Entered');
            
        }else{ 
            
            // extract table name and column name from the string which holds both of them
            $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_customfield_select_columnandtable']);
            $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_customfield_select_columnandtable']);            

            // get last array key for current custom fields if they exist
            if(isset($csv2post_project_array['custom_fields']['basic'])){
                $last_array_key = csv2post_get_array_nextkey($csv2post_project_array['custom_fields']['basic']);
            }else{
                $last_array_key = 0;
            }
            
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['table_name'] = $table_name;
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['column_name'] = $column_name;
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['meta_key'] = $_POST['csv2post_key'];                        

            // update project option         
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

            csv2post_notice('Your your basic custom field rule has been saved and another meta value will be added to all posts created in this project.','success','Large','Basic Custom Field Rule Saved');    
        }    

        return false;
    }else{
        return true;
    }    
}

/**
* Save advanced post meta (custom field) rule.
* Full edition only. Only the full edition has the functions for processing these rules during post creation.
*  
*/
function csv2post_form_add_advanced_custom_field(){
    global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createadvancedcustomfieldrules'){

        if($csv2post_is_free){
            csv2post_notice('Advanced custom fields are not supported in the free edition. The advanced scripts required to process them are only provided in the paid edition and are supported with it.','warning','Large','Paid Edition Only','','echo');        
        }elseif(!isset($_POST['csv2post_key'])){
            // ensure meta-key was entered
            csv2post_notice('You did not enter a meta-key for your custom field rule, please try again.','error','Large','No Meta-Key Entered');
        }else{ 
            
            // extract table name and column name from the string which holds both of them
            $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_customfield_select_columnandtable']);
            $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_customfield_select_columnandtable']);            

            // get last array key for current custom fields if they exist
            if(isset($csv2post_project_array['custom_fields']['advanced'])){
                $last_array_key = csv2post_get_array_nextkey($csv2post_project_array['custom_fields']['basic']);
            }else{
                $last_array_key = 0;
            }
                  
            // only save one of each value method - priority goes to templates
            if(isset($_POST['csv2post_customfields_selecttemplate'])){
                $csv2post_project_array['custom_fields']['advanced'][$last_array_key]['template_id'] = $_POST['csv2post_customfields_selecttemplate'];
            }else{
                $csv2post_project_array['custom_fields']['advanced'][$last_array_key]['column_name'] = $column_name;
                $csv2post_project_array['custom_fields']['advanced'][$last_array_key]['table_name'] = $table_name;    
            }

            $csv2post_project_array['custom_fields']['advanced'][$last_array_key]['meta_key'] = $_POST['csv2post_key'];                        
            $csv2post_project_array['custom_fields']['advanced'][$last_array_key]['update'] = $_POST['csv2post_updatesettings_metaupdating_switch_inputname'];
            
            // update project option         
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

            csv2post_notice('Your your advanced post-meta/custom-field rule has been saved and another meta value will be added to all posts created in this project.','success','Large','Date Column Saved');    
        }    

        return false;
    }else{
        return true;
    }    
}    
  
/**
* Updates the main date table and column   
*/
function csv2post_form_update_datecolumn(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'postdatescolumn'){
        global $csv2post_currentproject_code,$csv2post_project_array;
        
        // extract table name and column name from the string which holds both of them
        $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_datecolumn_select_columnandtable']);
        $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_datecolumn_select_columnandtable']);            

        // check if the submitted column is the same as already set - first check if the values have been set before
        if(isset($csv2post_project_array['dates']['date_column']['table_name']) && isset($csv2post_project_array['dates']['date_column']['column_name'])){
            if($csv2post_project_array['dates']['date_column']['table_name'] == $table_name && $csv2post_project_array['dates']['date_column']['column_name'] == $column_name){
                csv2post_notice('You selected the same database table and column as already saved. No changes were required.','warning','Large','No Changes Required');    
            }    
        }
        
        // the selected table-column values have not already been set        
        $csv2post_project_array['dates']['date_column']['table_name'] = $table_name;            
        $csv2post_project_array['dates']['date_column']['column_name'] = $column_name;
        $csv2post_project_array['dates']['currentmethod'] = 'data';

        // update project option         
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        csv2post_notice('Your date column has been saved and posts publish date will be set using your data.','success','Large','Date Column Saved');    

        return false;
    }else{
        return true;
    }    
}
  
  
/**
* Inserts a new post type condition (value trigger) 
*/
function csv2post_form_save_posttype_condition_byvalue(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'dynamicposttype'){

        // ensure trigger value has been entered, currently a text box, eventually it will be a menu and always set so this step can be removed
        // TODO: LOWPRIORITY, when trigger value is set using menu, remove this step (add menu of selected columns unique values using ajax)
        if( !isset($_POST['csv2post_dynamicposttype_text_trigger']) ){
            csv2post_notice('You must enter a trigger value. A trigger value is the value that will cause a different content template design to be used in a post rather than the default.','error','Large','Could Not Save New Rule');    
        }else{
        
            global $csv2post_currentproject_code,$csv2post_project_array;
            
            // check if we already have template rules by value saved, count how many we have for applying array key value
            $keyvalue = 0;
            if( isset($csv2post_project_array['posttyperules']['byvalue']) && is_array($csv2post_project_array['posttyperules']['byvalue']) ){
                $keyvalue = count($csv2post_project_array['posttyperules']['byvalue']);    
            }
            
            // extract table name and column name from the string which holds both of them
            $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['multiselect_csv2post_dynamicposttype_select_columnandtable_formid']);
            $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['multiselect_csv2post_dynamicposttype_select_columnandtable_formid']);            

            $csv2post_project_array['posttyperules']['byvalue'][$keyvalue]['table_name'] = $table_name;            
            $csv2post_project_array['posttyperules']['byvalue'][$keyvalue]['column_name'] = $column_name;
            $csv2post_project_array['posttyperules']['byvalue'][$keyvalue]['trigger_value'] = $_POST['csv2post_dynamicposttype_text_trigger'];            
            $csv2post_project_array['posttyperules']['byvalue'][$keyvalue]['post_type'] = $_POST['csv2post_dynamicposttype_select_posttype'];
            
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

            csv2post_notice('Your new rule for applying post type based on a specific value has been saved.','success','Large','Content Template Rule Saved');    
        }
        
        return false;
    }else{
        return true;
    }    
}  
  
/**
* Updates title template designs (post type wtgcsvtitle is updated)
*/
function csv2post_form_update_defaultposttype(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'defaultposttype'){
   
        if( $_POST['csv2post_defaultpostype_original'] == $_POST['csv2post_radio_defaultpostype']){
            csv2post_notice('You appear to have selected the post type that is already set as your projects default, no changes were required.','info','Large','No Changes Required');    
        }else{
            $csv2post_project_array['defaultposttype'] = $_POST['csv2post_radio_defaultpostype'];
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 
            csv2post_notice('Your projects default post type is now '.$csv2post_project_array['defaultposttype'].' and all posts created from here on will be this type.','success','Large','Default Post Type Changed');    
        }

        return false;
    }else{
        return true;
    }    
}

/**
* Updates title template designs (post type wtgcsvtitle is updated)
*/
function csv2post_form_update_titletemplates(){
    global $csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'edittitletemplates'){
 
        if( !isset($_POST['csv2post_titletemplate_total']) || $_POST['csv2post_titletemplate_total'] == 0){
            csv2post_notice('No changes have been made as you do not appear to have any title templates. You must use the Create Title Template panel before using the update feature.','warning','Large','No Changes Made');
            return false;
        }
        
        for ($i = 1; $i <= $_POST['csv2post_titletemplate_total']; $i++) {
            
            // only update the posts for which values have been changed
            if( $_POST['csv2post_titletemplate_design_'.$i] != $_POST['csv2post_titletemplate_design_original_'.$i] ){

                // Update title template post
                $my_post = array();
                $my_post['ID'] = $_POST['csv2post_titletemplate_postid_'.$i];
                $my_post['post_content'] = $_POST['csv2post_titletemplate_design_'.$i];
                $my_post['post_type'] = 'wtgcsvtitle';            
                $my_post['post_category'] = array(0);
                
                // Update the post into the database
                $update_result = wp_update_post( $my_post ); 
                if( csv2post_is_WP_Error($update_result)){
                    csv2post_notice('Wordpress function wp_update_post returns a Wordpress error (WP_Error). This should not happen even if an update was not carried out due to no changes made, that would return 0. Please report this issue. The post ID (custom post type wtgcsvtitle) is '.$_POST['csv2post_titletemplate_postid_'.$i].' and is a Title Template.','error','Large','Error Updating Title Template Named ' . $_POST['csv2post_titletemplate_posttitle_'.$i]);
                }elseif( $update_result == 0){
                    csv2post_notice('Wordpress function wp_update_post returned 0, meaning no update was required as no changes were made. This should not happen, the plugin is meant to avoid attempting an update if the user has not edited a Title Template. Please report this issue.','error','Large','Possible Error Updating Template Title Named ' . $_POST['csv2post_titletemplate_posttitle_'.$i]);                    
                }else{
                    csv2post_notice('Wordpress function wp_update_post updated your Title Template named '.$_POST['csv2post_titletemplate_posttitle_'.$i].' and all projects using the template will continue to use the updated version.','success','Large','Title Template Updated');
                }               
            }
        }
              
        return false;
    }else{
        return true;
    }    
} 
  
/**
* Inserts a new title template (post type wtgcsvtitle)
*/
function csv2post_form_insert_title_template(){
    global $csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createtitletemplates'){
 
        // validate template name
        if(!isset($_POST['csv2post_titletemplate_name']) || $_POST['csv2post_titletemplate_name'] == null || $_POST['csv2post_titletemplate_name'] == ' '){
            csv2post_notice('Please enter a name for your title template so that you can identify it properly','error','Large','Content Template Name Required');        
            return false;// tells this file that $_POST processing is complete
        }

        // validate template design
        if(!isset($_POST['csv2post_titletemplate_title']) || $_POST['csv2post_titletemplate_title'] == null || $_POST['csv2post_titletemplate_title'] == ' '){
            csv2post_notice('Please enter a title template design, you must use column replacement tokens for it to work','error','Large','Content Template Name Required');        
            return false;// tells this file that $_POST processing is complete
        }
         
        // save title template
        $save_result = csv2post_insert_titletemplate($_POST['csv2post_titletemplate_name'],$_POST['csv2post_titletemplate_title']);
        if(csv2post_is_WP_Error($save_result)){
            csv2post_notice('No changes were saved, you did not appear to make new changes before your submission','warning','Large','No Changes Made');    
        }else{
                     
            // if current project does not yet have a default content template
            $setasdefault = '';
            $template_id = csv2post_get_default_titletemplate_id($csv2post_currentproject_code);
            if(!$template_id){
                // current project has no default content template so we will save the new one as it
                csv2post_update_default_titletemplate($csv2post_currentproject_code,$save_result);
                // link the template to the project by adding csv2post_project_id custom meta field 
                add_post_meta($save_result, 'csv2post_project_id', $csv2post_currentproject_code, false);
                // extend output message to confirm default also set                    
                $setasdefault = ' and it has been set as your current projects default title template.';
            }
                
            csv2post_notice('Your new title template has been saved'.$setasdefault.'.','success','Large','New Title Template Saved');
        }
              
        return false;
    }else{
        return true;
    }    
} 

/**
* Updates current projects default template
*/
function csv2post_form_change_default_contenttemplate(){
    global $csv2post_currentproject_code;
    if(isset($_POST['csv2post_change_default_contenttemplate']) && isset($_POST['csv2post_templatename_and_id'])){
  
        // extract template id from string
        $template_id = csv2post_extract_value_from_string_between_two_values('(',')',$_POST['csv2post_templatename_and_id']);        

        if(!is_numeric($template_id)){
            csv2post_notice('The template ID could not be extracted from the submission, please try again then report this issue.','error','Large','Error Saving Default Content Template');
        }else{
            csv2post_update_default_contenttemplate($csv2post_currentproject_code,$template_id);
            csv2post_notice('The template you selected has been saved as your current projects default template design.','success','Large','Default Content Template Saved');
        }
        
        return false;
    }else{
        return true;
    }    
}

function csv2post_form_change_default_titletemplate(){
    global $csv2post_currentproject_code;
    if(isset($_POST['csv2post_change_default_titletemplate']) && isset($_POST['csv2post_templatename_and_id'])){
  
        // extract template id from string
        $template_id = csv2post_extract_value_from_string_between_two_values('(',')',$_POST['csv2post_templatename_and_id']);        

        if(!is_numeric($template_id)){
            csv2post_notice('The title template ID (also post id) could not be extracted from the submission, please try again then report this issue.','error','Large','Error Saving Default Title Template');
        }else{
            csv2post_update_default_titletemplate($csv2post_currentproject_code,$template_id);
            csv2post_notice('The title template you selected has been saved as your current projects default template design.','success','Large','Default Title Template Saved');
        }
        
        return false;
    }else{
        return true;
    }    
}    
 
/**
* Save a new dynamic content template rule based on column value
*/
function csv2post_form_save_contenttemplatedesign_condition_byvalue(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'dynamiccontentdesignrulesbyvalue'){

        // ensure trigger value has been entered, currently a text box, eventually it will be a menu and always set so this step can be removed
        // TODO: LOWPRIORITY, when trigger value is set using menu, remove this step
        if( !isset($_POST['csv2post_dynamiccontentdesignrules_text_triggervalue']) ){
            csv2post_notice('You must enter a trigger value. A trigger value is the value that will cause a different content template design to be used in a post rather than the default.','error','Large','Could Not Save New Rule');
        }else{
        
            // check if we already have template rules by value saved, count how many we have for applying array key value
            $keyvalue = 0;
            if( isset($csv2post_project_array['contenttemplaterules']['byvalue']) && is_array($csv2post_project_array['contenttemplaterules']['byvalue']) ){
                $keyvalue = count($csv2post_project_array['contenttemplaterules']['byvalue']);    
            }
            
            // extract table name and column name from the string which holds both of them
            $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_dynamiccontentdesignrules_select_columnandtable']);
            $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_dynamiccontentdesignrules_select_columnandtable']);            

            $csv2post_project_array['contenttemplaterules']['byvalue'][$keyvalue]['table_name'] = $table_name;            
            $csv2post_project_array['contenttemplaterules']['byvalue'][$keyvalue]['column_name'] = $column_name;
            $csv2post_project_array['contenttemplaterules']['byvalue'][$keyvalue]['trigger_value'] = $_POST['csv2post_dynamiccontentdesignrules_text_triggervalue'];            
            $csv2post_project_array['contenttemplaterules']['byvalue'][$keyvalue]['template_id'] = $_POST['csv2post_dynamiccontentdesignrules_select_templateid'];
            
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

            csv2post_notice('Your new rule for applying content has been saved and all records with the giving trigger value will use the selected template design.','success','Large','Content Template Rule Saved');    
        }
        
        return false;
    }else{
        return true;
    }    
}    
  
/**
* Saves content template design - new or old (update or insert), will create new post or update existing one.
* Design ID is also Wordpress post ID 
* @todo LOWPRIORITY, consider using custom taxonomies (categories) for applying template types
*/
function csv2post_form_save_contenttemplate(){  
    global $csv2post_currentproject_code;// TODO ADD THIS TOO POST IN CUSTOM FIELD
    
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'templateeditor'){
        
        // if we change this variable it causes new wtgcsvtemplate post to be created
        $create_new_wtgcsvtemplate_post = false;
                              
        // has a template design id been submitted, if so then the user is editing an existing design after opening it                                                                                                                                                                                                                                                 
        if(isset($_POST['csv2post_templateid']) && is_numeric($_POST['csv2post_templateid'])){
          
            // the user may want a design to be created from the previous, this is done by changing the template design name
            if($_POST["csv2post_templatename"] == $_POST["csv2post_templatename_previous"]){
             
                // update existing design using design ID (post_id for wtgcsvcontent custom post type)
                $my_post = array();
                $my_post['ID'] = $_POST['csv2post_templateid'];
                $my_post['post_type'] = 'wtgcsvcontent';
                $my_post['post_title'] = $_POST['csv2post_templatename'];            
                $my_post['post_content'] = $_POST['csv2post_wysiwyg_editor'];
                $my_post['post_category'] = array(0);
                
                // Update the post into the database
                $wp_update_post_result = wp_update_post( $my_post );

                // nothing further needs to be done
                return false;                
                
            }else{
           
                // the user has changed the template name, this is how the user forces new template to be created
                $create_new_wtgcsvtemplate_post = true;                  
            }
            
        }else{       
            // no existing id in the $_POST, create new template
            $create_new_wtgcsvtemplate_post = true;            
        }
              
        if($create_new_wtgcsvtemplate_post){   
                  
            $wpinsertpost_result = csv2post_insert_post_contenttemplate();// returns post ID
              
            if(!$wpinsertpost_result || csv2post_is_WP_Error($wpinsertpost_result) || $wpinsertpost_result == 0 ){
                csv2post_notice('Could not create new content template design. It requires the insertion of a new post record but Wordpress returned an error. Please try again then report further problems.','error','Large','Could Not Save Template');
            }elseif(is_numeric($wpinsertpost_result)){
                
                // link the template to the project by adding csv2post_project_id custom meta field 
                add_post_meta($wpinsertpost_result, 'csv2post_project_id', $csv2post_currentproject_code, false);
        
                // add design type/s to posts meta
                if(isset($_POST["csv2post_designtype"]) && is_array($_POST["csv2post_designtype"])){

                    $count = count($_POST["csv2post_designtype"]);
                    if($count > 1){
                        
                        $first = true;
                        foreach($_POST["csv2post_designtype"] as $key => $type){
                            add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', $type, false);   
                        }
    
                    }else{   
                      
                        add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', $_POST["csv2post_designtype"][0], false);

                        // if a single post type selected, set template as the default for the type selected
                        // excerpt
                        if($_POST["csv2post_designtype"][0] == 'postexcerpt'){
                                                 
                            $setasdefault = '';
                            $template_id = csv2post_get_default_excerpttemplate_id($csv2post_currentproject_code);
                            if(!$template_id){

                                // current project has no default content template so we will save the new one as it
                                csv2post_update_default_excerpttemplate($csv2post_currentproject_code,$wpinsertpost_result);
                                                   
                                // extend output message to confirm default also set                    
                                $setasdefault = ' and it has been set as your current projects default excerpt template.';
                            }                                
                        }                
                    }
             
                }else{
                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'postcontent',false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'customfieldvalue', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'categorydescription', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'postexcerpt', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'keywordstring', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'dynamicwidgetcontent', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'seovalue', false);
                }
           
                // if current project does not yet have a default content template we will use this one
                $setasdefault = '';
                $template_id = csv2post_get_default_contenttemplate_id($csv2post_currentproject_code);
                if(!$template_id){
                     
                    // current project has no default content template so we will save the new one as it
                    csv2post_update_default_contenttemplate($csv2post_currentproject_code,$wpinsertpost_result);
                                       
                    // extend output message to confirm default also set                    
                    $setasdefault = ' and it has been set as your current projects default content template.';
                }
                                
                csv2post_notice('Your new content template has been saved'.$setasdefault.'. You can select it in your projects settings and edit it using the same editor as you created it with.','success','Large','New Template Saved');
            }            
        }
        
        return false;
    }else{
        return true;
    }    
}  
    
/**
* Changes the CURRENT PROJECT so that the user may change settings
*/
function csv2post_form_change_current_project(){
    global $csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'selectcurrentproject'){
        if( $_POST['csv2post_radio_projectcode'] == $csv2post_currentproject_code){
            csv2post_notice('You submitted the same project as the one already set as your Current Project. No changes were made.','info','Large','No Changes Made');    
        }else{
            csv2post_update_currentproject($_POST['csv2post_radio_projectcode']);
            csv2post_notice('Your current project has been changed and you will not be working on project '.$_POST['csv2post_radio_projectcode'].'.','success','Large','Project Changed');            
        }
        return false;
    }else{
        return true;
    }    
}    

/**
* Deletes one or more post creation projects from $_POST submission
*/
function csv2post_form_delete_post_creation_projects(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deleteprojects'){
        global $csv2post_is_free,$csv2post_currentproject_code;
        
        if(!$csv2post_is_free && !isset($_POST['csv2post_projectcodes_array'])){
            csv2post_notice('You did not appear to select any projects, no projects have been deleted.','info','Large','No Projects Deleted');    
        }else{
            
            if($csv2post_is_free){
                
                //free edition has one project, so we can use $csv2post_currentproject_code
                // Do not try to get around this limitation, required functions for later processes are not included with the free download
                csv2post_delete_postcreationproject($csv2post_currentproject_code);
                csv2post_delete_option_currentprojectcode();
                csv2post_notice('Your project with code '.$csv2post_currentproject_code.' has been deleted.','success','Large','Project ('.$csv2post_currentproject_code.') Deleted');                

            }else{
                
                foreach($_POST['csv2post_projectcodes_array'] as $key => $project_code){
                    
                    // if  $csv2post_currentprojectcode equals the project being deleted, then delete current project option
                    if($csv2post_currentproject_code == $project_code){
                        csv2post_delete_option_currentprojectcode();   
                    }
                    
                    csv2post_delete_postcreationproject($project_code);
                    csv2post_notice('Your project with code '.$project_code.' has been deleted.','success','Large','Project '.$project_code.' Deleted');    
                }
                
            }
        }
        return false;
    }else{
        return true;
    }    
}    

/**
* Processes request to make new post creation project
*/
function csv2post_form_create_post_creation_project(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createpostcreationproject'){
        
        global $csv2post_currentproject_code,$csv2post_is_free;
        
        // if no project name
        if(!isset($_POST['csv2post_projectname_name']) || $_POST['csv2post_projectname_name'] == NULL || $_POST['csv2post_projectname_name'] == '' || $_POST['csv2post_projectname_name'] == ' '){
            csv2post_notice('No project name was entered, please try again','error','Large','Project Name Required','','echo');    
        }
        
        // if no database table selected
        if(!isset($_POST['csv2post_databasetables_array'])){
            csv2post_notice('You did not appear to select any database tables for taking data from and putting into posts. Project was not created.','info','Large','Database Table Selection Required','','echo');    
            return false;
        }else{
            
            // carry out project table resets
            if(isset($_POST['csv2post_databasetables_resettable_array'])){

                if($csv2post_is_free){
                    
                    // does user want posts deleted also? Requires the same table to be selected 
                    if(isset($_POST['csv2post_databasetables_resetposts_array']) && $_POST['csv2post_databasetables_resetposts_array'] == $_POST['csv2post_databasetables_resettable_array']){
                        $reset_posts = true;
                        $reset_posts_notice = ' All posts related to the project table have been deleted also.';    
                    }else{
                        $reset_posts = false;
                    }
    
                    csv2post_sql_reset_project($_POST['csv2post_databasetables_resettable_array'],$reset_posts);
                    csv2post_notice('The table named '.$_POST['csv2post_databasetables_resettable_array'].' was reset as requested.'.$reset_posts_notice,'success','Large','Table Reset','','echo');                    
                
                }else{
                    foreach($_POST['csv2post_databasetables_resettable_array'] as $key => $table_name){
                        
                        // does user also want this tables posts deleted
                        if(isset($_POST['csv2post_databasetables_resetposts_array'])){
                            $reset_posts = false;
                            foreach($_POST['csv2post_databasetables_resetposts_array'] as $key => $t){
                                if($t == $_POST['csv2post_databasetables_resettable_array']){
                                    $reset_posts = true;    
                                }    
                            }
                        }
                        
                        csv2post_sql_reset_project($table_name,$reset_posts);
                        csv2post_notice('The table named '.$table_name.' was reset as requested.','success','Large','Table Reset','','echo');    
                    }  
                } 
            }
            
            // free edition does not allow mapping method selection on form
            if(isset($_POST['csv2post_projecttables_mappingmethod_inputname']) && !$csv2post_is_free){
                $mapping_method = $_POST['csv2post_projecttables_mappingmethod_inputname'];    
            }else{
                $mapping_method = 'defaultorder';
            }
            
            // free edition will submit selected database table as string, not array, make array for rest of plugins use
            if(!is_array($_POST['csv2post_databasetables_array'])){
                $tables_array = array($_POST['csv2post_databasetables_array']);// we add the single table name to an array in free edition                                
            }else{
                $tables_array = $_POST['csv2post_databasetables_array'];// paid edition value will already be an array
            }

            // create project function will return project code on success
            $createproject_result_code = csv2post_create_post_creation_project($_POST['csv2post_projectname_name'],$tables_array,$mapping_method);
            if($createproject_result_code){
                
                // now set the new project as the Current Project ($csv2post_currentproject_code)               
                $csv2post_currentproject_code = $createproject_result_code;
                csv2post_update_currentproject($createproject_result_code);
                
                // do notification
                csv2post_notice('Your new Post Creation Project has been made. Please click on the Content Designs tab and create your main content layout for this project or select an existing one.','success','Large','Post Creation Project Created');
            
                // display next step message
                if(!$csv2post_is_free){
                    $table_count = count($_POST['csv2post_databasetables_array']);
                    if($table_count != 1){
                        csv2post_notice('You must now complete the Multiple Tables Project panel on the Projects screen.','step','Large','Next Step','','echo');    
                    }
                }
            
            }else{
                
                if($csv2post_is_free){
                
                    csv2post_notice('You appear to have already created your project. The free edition allows one project at a time, please complete your post creation then delete the project. You may then create another project with a new database table that holds different data.','warning','Large','Post Creation Project Not Created','','echo');    
               
                }else{
                    
                    csv2post_notice('A problem was detected when making the new Post Creation Project. It is recommended that you attempt to make the project again and report this problem if it continues to happen.','error','Large','Post Creation Project Not Created');    
                
                }
            }  
        }
        return false;
    }else{
        return true;
    }     
} 

/**
* Processes request to delete multiple data import jobs selected on Start tab 
*/
function csv2post_form_delete_dataimportjobs(){
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'data' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'deletedataimportjob'){
        if(!isset($_POST['csv2post_jobcode_array'])){
            csv2post_notice('You did not appear to select any data import jobs for deletion, no changes have been made.','info','Small');    
        }else{
            global $csv2post_currentjob_code;
            
            // loop through submitted job codes 
            foreach( $_POST['csv2post_jobcode_array'] as $jobcode ){
                
                // if job being deleted equals the current job, delete the option record for current job
                if($jobcode == $csv2post_currentjob_code){
                    csv2post_delete_option_currentjobcode();
                }
                
                $deletejob_result = csv2post_delete_dataimportjob_postrequest($jobcode,true);
            }
        }
        return false;
    }else{
        return true;
    }     
}  

/**
* Creates data import job
* @todo HIGHPRIORITY, failure still shows SUCCESS GREEN notification, improve the failure line to show RED ERROR notification
*/
function csv2post_form_createdataimportjob(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createdataimportjobcsvfiles'){
        global $csv2post_is_free;
        
        // warn user when they do not submit parts of the profile
        if(!isset($_POST['csv2post_jobname_name'])){
            csv2post_notice('You did not enter a Job Name, please try again.','error','Large','No Job Name Entered','','echo');
            return false;    
        }
    
        if(isset($_POST['csv2post_newjob_included_csvfiles'])){
            foreach($_POST['csv2post_newjob_included_csvfiles'] as $key => $csvfile_name){ 
            
                // remove .csv from filename
                $filename = str_replace('.csv','',$csvfile_name);
                                       
                // if user did not enter field count
                if(!isset($_POST['csv2post_csvfile_fieldcount_' . $filename]) || $_POST['csv2post_csvfile_fieldcount_' . $filename] == ''){
                    csv2post_notice('You did not enter your CSV file column/field number. CSV 2 POST will attempt to 
                    count them but if you experience problems please enter the number manually.','warning','Large','Column Count Not Entered','','echo');    
                }
                
                // if user did not select separator
                if(!isset($_POST['csv2post_newjob_separators' . $filename])){
                    csv2post_notice('You never selected a separator. The plugin will attempt to guess it but if you
                    experience problems you should select it manually.','warning','Large','No Separator Selected','','echo');
                }
                
                // if user did not select quote
                if(!isset($_POST['csv2post_newjob_quote' . $filename])){
                    csv2post_notice('You never selected a quote. The plugin will attempt to guess it but if you
                    experience problems please select it manually.','warning','Large','No Quote Selected','','echo');
                }            
            }      
        }

        // set variable for building output html
        $extendednotice = '';
        
        // set function boolean outcome (used at end to display notification for success or fail)
        $functionoutcome = false;
        
        $importjobname_validate_result = csv2post_validate_dataimportjob_name($_POST['csv2post_jobname_name']);
        
        if($importjobname_validate_result){
            
            if(isset($_POST['csv2post_newjob_included_csvfiles'])){
                
                // generate job code (used to name database table and option record for job history) 
                $code = csv2post_create_code(6); 
        
                // create an array for the job, to be stored in an option record of its own
                $jobarray = csv2post_create_jobarray($_POST['csv2post_jobname_name'],$code);
                $jobarray['jobname'] = $_POST['csv2post_jobname_name'];

                // determine if this is a multi file job or single
                if($csv2post_is_free){
                    $job_file_group = 'single';// free edition does not allow multiple files    
                }else{
                    // count the number of files submitted
                    $numbers_of_files = count($_POST['csv2post_newjob_included_csvfiles']);
                    if($numbers_of_files > 1){
                        $job_file_group = 'multiple';    
                    }else{
                        $job_file_group = 'single';
                    }
                }

                // add established file group type too the array (no use for it as I add it but adding it just in case)                
                $jobarray['filegrouping'] = $job_file_group;
                                   
                // count files, counter acts as file id within the job array, it is also appended to column names 
                $fileid = 1;
                 
                // add each csv file too the jobarray
                // we add more default stats here, while we are doing the                            
                foreach($_POST['csv2post_newjob_included_csvfiles'] as $key => $csvfile_name){
                    
                    // add the file with the $fileid as key, $fileid is simple integer number beginning from 1
                    $jobarray['files'][$fileid] = $csvfile_name;
                                        
                    // we need first part of filename for appending in $_POST submissions
                    $fileChunks = explode(".", $csvfile_name);

                    // establish separator
                    if(isset($_POST['csv2post_newjob_separators' . $fileChunks[0]])){
                        $jobarray[$csvfile_name]['separator'] = $_POST['csv2post_newjob_separators' . $fileChunks[0]];        
                    }else{
                        $jobarray[$csvfile_name]['separator'] = csv2post_get_file_separator($csvfile_name,$fileid);
                    }
                    
                    // establish quote
                    if(isset($_POST['csv2post_newjob_quote' . $fileChunks[0]])){
                        
                        if($_POST['csv2post_newjob_quote' . $fileChunks[0]] == 'doublequote'){
                            $jobarray[$csvfile_name]['quote'] = '"';    
                        }elseif($_POST['csv2post_newjob_quote' . $fileChunks[0]] == 'singlequote'){
                            $jobarray[$csvfile_name]['quote'] = "'";
                        }else{
                            $jobarray[$csvfile_name]['quote'] = '"';
                        }
                                
                    }else{
                        $jobarray[$csvfile_name]['quote'] = csv2post_get_file_quote($csvfile_name,$fileid,'PEAR');
                    }                     
   
                    // establish number of fields/columns - we need seperator at least to do this if user never submitted integer value
                    if(isset($_POST['csv2post_csvfile_fieldcount_'.$fileChunks[0]]) && is_numeric($_POST['csv2post_csvfile_fieldcount_'.$fileChunks[0]])){
                        $jobarray[$csvfile_name]['fields'] = $_POST['csv2post_csvfile_fieldcount_'.$fileChunks[0]];    
                    }else{
                        $jobarray[$csvfile_name]['fields'] = csv2post_establish_csvfile_fieldnumber($csvfile_name,$jobarray[$csvfile_name]['separator']);
                    }   
                    
                    // add job stats for the file, required for multiple file jobs
                    $jobarray['stats'][$csvfile_name]['progress'] = 0;
                    $jobarray['stats'][$csvfile_name]['inserted'] = 0;    
                    $jobarray['stats'][$csvfile_name]['updated'] = 0;
                    $jobarray['stats'][$csvfile_name]['deleted'] = 0;
                    $jobarray['stats'][$csvfile_name]['void'] = 0;    
                    $jobarray['stats'][$csvfile_name]['dropped'] = 0;    
                    $jobarray['stats'][$csvfile_name]['duplicates'] = 0;                    
                    $jobarray['stats'][$csvfile_name]['rows'] = csv2post_count_csvfilerows($csvfile_name);                    

                    // also add an array of each files headers with the file as key
                    $jobarray[$csvfile_name]['headers'] = csv2post_get_file_headers_formatted($csvfile_name,$fileid,$jobarray[$csvfile_name]['separator'],$jobarray[$csvfile_name]['quote'],$jobarray[$csvfile_name]['fields']);
                     
                    // count total rows
                    $jobarray['totalrows'] = $jobarray['totalrows'] + $jobarray['stats'][$csvfile_name]['rows'];
                    ++$fileid;                        
                }

                $result = csv2post_save_dataimportjob($jobarray,$code);
                if($result){
                    
                    // set global $csv2post_currentjob_code as new code and set global $csv2post_job_array
                    global $csv2post_currentjob_code,$csv2post_job_array;
                    $csv2post_currentjob_code = $code;
                    $csv2post_job_array = $jobarray;
                    
                    // create a database table - multiple file jobs are put into a single table, column names are giving appended values to prevent conflict with shared names    
                    $createtable_result = csv2post_create_dataimportjob_table($code,$job_file_group);

                    if(!$createtable_result){
                        $functionoutcome = false;
                        $extendednotice .= csv2post_notice('The data import jobs database table could not be created, it is required for storing your data and was to be named csv2post_'.$code.'. Please try again then seek support.','warning','Extra','','','return');        
                    }else{
                        
                        // update csv2post_current_job option record
                        csv2post_update_option_currentjob_code($code);
                        
                        // update the Data Import Jobs Array (the list of all job ID)
                        global $csv2post_dataimportjobs_array;
                        
                        // if data import jobs array is not already set then this must be the first job - set it as an array
                        if(!$csv2post_dataimportjobs_array){
                            $csv2post_dataimportjobs_array = array();    
                        }

                        // add job to the array that only holds a list of jobs not job statistics
                        csv2post_add_dataimportjob_to_list($code,$_POST['csv2post_jobname_name']);
                        
                        $functionoutcome = true;
                        $extendednotice .= csv2post_notice('A new database table named csv2post_' . $code.' was created for storing your data for the new Data Import Job.','info','Extra','','','return');    
                    
                    }
                }else{
                    $functionoutcome = false;
                    $extendednotice .= csv2post_notice('Could not create data import task, reason unknown. Please try again then report this problem if it continues.','warning','Extra','','','return');                    
                }
            }else{
                $functionoutcome = false;
                $extendednotice .= csv2post_notice('You did not appear to select any CSV files for your new Data Import Job. Please try again.','warning','Extra','','','return');
            }
        }else{
            $functionoutcome = false;
            $extendednotice .= csv2post_notice('Your Data Import Job name is invalid, please do not include special characters or use more than 30 characters.','info','Extra','','','return');
        }
        
        // decide the initial notice
        if($functionoutcome){
            $initialnotice = 'Your new data import job named '.$_POST['csv2post_jobname_name'].' has been created and no problems were detected. You can now go to the Import tab and begin importing rows from your CSV file/s into your database as records.';    
        }else{
            $initialnotice = 'Sorry your new data import job named '.$_POST['csv2post_jobname_name'].' was NOT created, a problem was detected. More details should be provided below this message.';
        }
        
        // undo changes that were made too the blog despite an overall fail
        ### TODO:HIGHPRIORITY, remove database table and job entry too the job array if an overall failure is reached
        
        // display result
        csv2post_notice('<h4>Create New Data Import Job Results</h4>' . $initialnotice . $extendednotice);

        if($functionoutcome){
            if($csv2post_is_free){
                csv2post_notice('You should now click on the Import Jobs screen and begin importing your data manually.','step','Large','Next Step',false,'echo');    
            }else{
                csv2post_notice('You should now click on the Import Jobs screen and begin importing your data manually. If
                you want automated import, click on 3. Your Creations in the main menu, then click on the Schedule tab to continue.','step','Large','Next Step',false,'echo');                
            }        
        }
        
        return false;
    }else{
        return true;
    }     
}  

/**
* Runs tests on $_POST submitted CSV file and outputs overall success or individual problems
* @todo MEDIUMPRIORITY, count number of spaces and special charactors on row 1, warn about lack of header if a lot found or the fact that the header is not appropriate  
*/
function csv2post_form_test_csvfile(){
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'data' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'testcsvfiles'){

        // TEST 1: fgets separator - standard fgets method and counting each possible separator
        $sep_test_one = csv2post_establish_csvfile_separator_fgetmethod($_POST['multiselect_csv2post_multiselecttestcsvfiles'],true );
        
        // TEST 2: PEAR CSV separator - PEAR method which returns its decision     
        $sep_test_two = csv2post_establish_csvfile_separator_PEARCSVmethod($_POST['multiselect_csv2post_multiselecttestcsvfiles'],true );

        // TEST 3: PEAR CSV quote       
        $quote_test_two = csv2post_establish_csvfile_quote_PEARCSVmethod( $_POST['multiselect_csv2post_multiselecttestcsvfiles'],true);
       
        // if user submitted separator, use that from here on
        if(isset($_POST['csv2post_testcsvfile_separator_radiogroup'])){
            $sep_test_two = $_POST['csv2post_testcsvfile_separator_radiogroup'];    
        }
       
        // TEST 4: using established separator and quote, count column titles using fget method as priority
        csv2post_test_csvfile_countfields_fgetpriority( $_POST['multiselect_csv2post_multiselecttestcsvfiles'], $sep_test_two, $quote_test_two );

        // TEST 5: using established separator and quote, count column titles using PEAR CSV method as priority
        csv2post_test_csvfile_countfields_pearcsvpriority( $_POST['multiselect_csv2post_multiselecttestcsvfiles'], $sep_test_two, $quote_test_two );

        // TEST 6: compare Separators from all methods and display error notice if no match
        $separators_match = true;
        if($sep_test_one != $sep_test_two){
            $separators_match = false;        
        }
        
        if(isset($_POST['csv2post_testcsvfile_separator_radiogroup']) && $_POST['csv2post_testcsvfile_separator_radiogroup'] != $sep_test_one){
            $separators_match = false;    
        }

        if(isset($_POST['csv2post_testcsvfile_separator_radiogroup']) && $_POST['csv2post_testcsvfile_separator_radiogroup'] != $sep_test_two){
            $separators_match = false;    
        }
                    
        if(!$separators_match){            
            csv2post_notice('Separator values from all methods used to establish the correct character, including the 
            separator you submitted (if any), do not match each other. This is very common when working with CSV files.
             You may always need to use manual separator options. This message is to make you aware that
             not all methods of reading CSV files will work with your file.','warning','Large','Test 6: Compare Separator Sources','','echo');    
        }else{
            csv2post_notice('Separator values from all methods used to establish the correct character, including the separator you submitted (if any), do not match each other. This is very common when working with CSV files. You may always need to use manual separator options.','warning','Large','Test 6: Compare Separator Sources','','echo');            
        }
        
        csv2post_notice('
        <p>A well created CSV file can get a positive/tick notification for each test but it is not required. The
        tests do not decide if you can use the plugin or not, they help to determine what methods should be used for
        handling your file.</p>
        <p>
            <ul>
                <li>1. Green (tick) indicates no problems or simply information for you to review and make decisions yourself</li>
                <li>2. Yellow (caution/warning) caution means one or more methods for handling has not worked and you should use the methods that do work</li>
                <li>3. Red (cross/error) notifications mean there was a total failure in one of the tests, could indicate a badly formatted CSV file</li>
            </ul>
        </p>','info','Large','Test Notifications Explained','','echo');
                
        return false;
    }else{
        return true;
    }     
}
                                                    
/**
* Creates the csv file folder in the wp-content path
*/
function csv2post_form_deletecontentfolder(){
    if(isset($_POST[WTG_C2P_ABB.'contentfolder_delete'])){ 
        // this function does the output when set to true for 2nd parameter
        csv2post_delete_contentfolder(WTG_C2P_CONTENTFOLDER_DIR,true);    
        return false; 
    }else{
        return true;
    }    
} 

/**
* Creates the csv file folder in the wp-content path
*/
function csv2post_form_createcontentfolder(){
    if(isset($_POST[WTG_C2P_ABB.'contentfolder_create'])){ 
        // this function does the output when set to true for 2nd parameter
        csv2post_install_contentfolder(WTG_C2P_CONTENTFOLDER_DIR,true);    
        return false;
    }else{
        return true;
    }    
} 

/**
* Install Plugin - initial post submission validation  
*/
function csv2post_form_installplugin(){   
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'install' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'premiumuseractivation'){

        if(!current_user_can('activate_plugins')){
            csv2post_notice(__('You do not have the required permissions to activate '.WTG_C2P_PLUGINTITLE.'. The Wordpress role required is activate_plugins, usually granted to Administrators.'), 'warning', 'Large', false);
        }else{                  
            csv2post_process_full_install();                
        }
        
        return false;
    }else{
        return true;
    }       
}    

/**
* Re-install Plugin Post Validation
* 
*/
function csv2post_form_reinstallplugin(){ 
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'install' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'reinstall'){
        if(current_user_can('activate_plugins')){
            csv2post_process_full_reinstall();    
        }else{
            csv2post_notice(__('You do not have the required permissions to perform a re-install of '.WTG_C2P_PLUGINTITLE.'. The Wordpress role required is activate_plugins, usually granted to Administrators.'), 'warning', 'Large', false);
        }
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function 
       
    }else{
        return true;
    } 
}

/**
* Un-install Plugin Post Validation 
*/
function csv2post_form_uninstallplugin(){
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'install' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'uninstall'){  
        if(current_user_can('delete_plugins')){
           
           $uninstall_outcome = csv2post_uninstall();
           if($uninstall_outcome){
                csv2post_notice('CSV 2 POST has been uninstalled. Please be aware at this time the plugin does not
                remove every element created i.e. some database tables may be left in your database for future use.',
                'success','Large','CSV 2 POST Uninstalled','','echo');    
           }else{
                csv2post_notice('There was a problem running the uninstallation, please try again then seek support.',
                'error','Large','CSV 2 POST Not Uninstalled','','echo');    
           }
           
        }else{
            csv2post_notice(__('You do not have the required permissions to un-install '.WTG_C2P_PLUGINTITLE.'. The Wordpress role required is delete_plugins, usually granted to Administrators.'), 'warning', 'Large','No Permission To Uninstall CSV 2 POST','','echo');
        }
        
        // return false to stop all further post validation function calls
        return false;// must go inside $_POST validation, not at end of function 
        
    }else{
        return true;
    } 
}
     
/**
* Log File Installation Post Validation
*/
function csv2post_form_logfileinstallation(){
    if(isset($_POST[WTG_C2P_ABB.'createlogfile'])){

        $logfileexists_result = csv2post_logfile_exists($_POST[WTG_C2P_ABB.'logtype']);
        if($logfileexists_result){?>      
            <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Exists">
                <?php  csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file already exists, no changes have been made too your blog.'),'info','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Exists');?>
            </div><?php                 
            csv2post_jquerydialogue_results();
        }else{
             $createlogfile_result = csv2post_create_logfile($_POST[WTG_C2P_ABB.'logtype']);
             if($createlogfile_result){?>
                <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Created">
                    <?php  csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file was created, please now ensure logging for this file is active.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Created');?>
                </div><?php
                csv2post_jquerydialogue_results(); 
    
                // make first log entry
                $logatt = array();      
                $logatt['projectname'] = 'NA';
                $logatt['line'] = __LINE__;
                $logatt['file'] = __FILE__;
                $logatt['function'] = __FUNCTION__;
                $logatt['logtype'] = 'admin';
                $logatt['comment'] = 'The '.$logatt['logtype'].' log file was created';
                $logatt['style'] = 'success';
                $logatt['category'] = 'install';// TODO: MEDIUM PRIORITY, ensure the log viewer expects upper and lower case for category

                csv2post_log($logatt);
                              
             }else{?>
                <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Creation Failed">
                    <?php  csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log could not be created, please check the plugins FAQ for help on what to do next.'),'error','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Creation Failed');?>
                </div><?php
                csv2post_jquerydialogue_results();               
             }
        }
        
        // return false to stop all further post validation function calls
        return false;// must go inside $_POST validation, not at end of function 
        
    }else{
        return true;
    } 
}

/**
* Delete Log File Post Validation
*/
function csv2post_form_deletelogfile(){
    if(isset($_POST[WTG_C2P_ABB.'deletelogfile'])){ 
        $logfileexists_result = csv2post_logfile_exists($_POST[WTG_C2P_ABB.'logtype']);
        if(!$logfileexists_result){?>      
            <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Not Found">
                <?php  csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file could not be located, no changes have been made.'),'info','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Not Found');?>
            </div><?php
            csv2post_jquerydialogue_results();
        }else{
             $deletelogfile_result = csv2post_delete_logfile($_POST[WTG_C2P_ABB.'logtype']);
             if($deletelogfile_result){?>
                <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Removed">
                    <?php  csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file was deleted, please now ensure logging for this file is disabled or it may be re-created.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Removed');?>
                </div><?php
                csv2post_jquerydialogue_results();               
             }else{?>
                <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Not Removed">
                    <?php  csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log could not be deleted, reason unknown. Please try again, ensure the log exists then seek support.'),'error','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Not Removed');?>
                </div><?php
                csv2post_jquerydialogue_results();               
             }
        } 
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    } 
}

/**
* Disable Log File Post Validation
*/
function csv2post_form_disablelogfile(){
    if(isset($_POST[WTG_C2P_ABB.'disablelogfile'])){
        $logfile_result = csv2post_disable_logfile($_POST[WTG_C2P_ABB.'logtype']);
        if($logfile_result){?>      
            <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Disabled">
                <?php  csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file has been Disabled.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Disabled');?>
            </div><?php
            csv2post_jquerydialogue_results();
        }
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    } 
}

/**
* Activate Log File Post Validation
*/
function csv2post_form_activatelogfile(){
    if(isset($_POST[WTG_C2P_ABB.'activatelogfile'])){
        $logfile_result = csv2post_activate_logfile($_POST[WTG_C2P_ABB.'logtype']);
        if($logfile_result){?>      
            <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Activated">
                <?php  csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file has been activated.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Activated');?>
            </div><?php
            csv2post_jquerydialogue_results();
        }
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    } 
}

/**
* View Log File Post Validation
*/
function csv2post_form_viewlogfile(){
    if(isset($_POST[WTG_C2P_ABB.'viewlogfile'])){?> 
        <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Activated">
            <?php 
            csv2post_notice(__('the '.$_POST[WTG_C2P_ABB.'logtype'].' log file has been retrieved and displayed below.'),'success','Small',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log: ');
            
            // create array of key words to filter entries from the general log
            $install_filter_array = array();
            $install_filter_array['logfile'] = $_POST[WTG_C2P_ABB.'logtype'];// use logfile to open specific log file
            $install_filter_array['action'] = 'install';// use this action for uninstall,reinstall etc
            $install_filter_array['priority'] = 'all';// all (default),low,high,critical
            // add panel details too array, used for forms in notices       
            $install_filter_array['panel_title'] = 'View '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File';            
            $install_filter_array['panel_name'] = WTG_C2P_ABB.'postsubmit_viewlogfile';
            $install_filter_array['panel_number'] = '1';  
                                                 
            csv2post_viewhistory($install_filter_array); ?>
        </div><?php
        csv2post_jquerydialogue_results();  
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    } 
}

/**
* Contact Form Submission Post Validation 
*/
function csv2post_form_contactformsubmission(){     
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'more' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'contact'){
        
        // result and control variables
        $failed = false;
        $failurereason = 'Unknown';
        
        // email output list - a simple unordered list to add entries to regarding the output of this contact
        $email_list_start = '<h4>Contact Outcome</h4><ul>'; 
        
        // email template - the main template for all details
        $email_template = '<strong>Contact Reason:</strong>stringreplace_contactreasons <br />
        <strong>Contact Methods:</strong> stringreplace_contactmethods <br />
        <strong>Contact Priority:</strong> stringreplace_priority <br />
        <h4>Description</h4>
        <strong>Contact Description:</strong> stringreplace_description <br />
        <h4>Links</h4>
        <strong>Link 1:</strong> stringreplace_linkone <br />
        <strong>Link 2:</strong> stringreplace_linktwo <br />
        <strong>Link 3:</strong> stringreplace_linkthree <br />
        <strong>Contact Methods:</strong> stringreplace_contactmethods <br />
        <strong>Contact Methods:</strong> stringreplace_contactmethods <br />'; 
        
        // add $_POST values too email template
        if(isset($_POST['multiselect_'.WTG_C2P_ABB.'contactmethods'])){
            // loop through contact methods and create comma seperated list    
        }
          
        if(isset($_POST['multiselect_'.WTG_C2P_ABB.'contactreason'])){
            // loop through contact reasons and create comma seperated list    
        }
         
        ### @todo HIGH PRIORITY  check the contact description post value here, it has wtg does it match with form ???   
        $stringreplace_result = str_replace('stringreplace_description',$_POST['wtg_contactdescription'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linkone',$_POST[WTG_C2P_ABB.'linkone'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linktwo',$_POST[WTG_C2P_ABB.'linktwo'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linkthree',$_POST[WTG_C2P_ABB.'linkthree'],$email_template);          
        if(!stringreplace_result){
            ### @todo log that a failure happened, if ever detected we'll need to add individual log entries       
        }
            
        // arrays holding expected values
        $methods_array = array('email','ticket','forum','testimonial');
        $apimethods_array = array('ticket','forum','testimonial');
        $reason_array = array('hire','pluginhelp','testimonial','bug','generaladvice','requestchanges','requestfeature','requesttutorial','affiliateenquiry','provideftp','provideadmin','providemysql','providehosting');
        $priority_array = array('low','medium','high');
                     
        // ensure all submitted values are in expected value arrays (will be done again on the server as required security)
        // we also check values to decide if we need to use the WebTechGlobal Contact Web Service
        foreach($_POST['multiselect_csv2post_contactmethods'] as $amethod){
            if(!is_string($amethod) || !in_array($methods_array)){
                $failed = true;
                $failurereason = 'the giving contact method '.$methods_array.' is invalid.';   
            }  
        }
        
        foreach($_POST['multiselect_csv2post_contactreason'] as $areason){
            if(!is_string($areason) || !in_array($reason_array)){
                $failed = true;
                $failurereason = 'the giving contact reason '.$areason.' is invalid.';   
            }  
        }

        foreach($_POST['multiselect_csv2post_contactpriority'] as $apriority){
            if(!is_string($apriority) || !in_array($priority_array)){
                $failed = true;
                $failurereason = 'a submitted priority value,'.$apriority.', is invalid.';   
            }  
        }
        
        // output result if $failed so far
        if($failed == true){
            csv2post_notice('Contact attempt failed. This has happened because '.$failurereason);
        }
        
        ######################################## Contact method for gold users only
        ####      CONTACT WEB SERVICE      ##### Stores sensitive information in WebTechGlobal database
        ######################################## Ticket, Forum and sending data requires this else it is all sent by email
        
        /*  @todo Contact Web Services to be complete on server
        if($failed == true){
            
            // is the api required, did user selected contact methods that require it?
            // compare each contact method that requires the api against those submitted in POST
            foreach($_POST['multiselect_csv2post_contactmethods'] as $amethod){
                if(in_array($apimethods_array,$_POST['multiselect_csv2post_contactmethods'])){
                    $apirequired = true;
                    break;   
                }  
            }  
            
            // check if soap connection should be attempted or not (based on users api session which is decide from service status and subscription)
            if($apirequired && csv2post_api_canIconnect()){
            
                // decide which web service to use (ticket takes priority)
                if(in_array('ticket',$_POST['multiselect_csv2post_contactmethods'])){
                
                    // is none in the contact include, is so we do not send any sensitive data
                    if(in_array('none',$_POST['multiselect_csv2post_contactinclude'])){
                        $email_list_start .= '<li>You had the None option selected, no login details or sensitive data will be sent to the Ticket Web Service</li>';                                
                    }else{

                        // do SOAP call too WebTechGlobal Ticket Web Service and create ticket
                        $ticket_array = array();
                        
                        if(in_array('admin',$_POST['multiselect_csv2post_contactinclude'])){
                            // ensure user has permission to edit users and maybe other permission
                            // they may have plugin access but not permission to be sending details via email
                            if(USER HAS REQUIRED PERMISSION){
                                $email_list_start .= '<li>You will send login details for '.PUT USERNAME HERE.', the password will be included (not shown here for security)</li>';                    
                                // get current users admin details else get the default admin user details
                                $ticket_array['adminusername'] = 'TO BE COMPLETE';
                                $ticket_array['adminpassword'] = 'TO BE COMPLETE';
                            }else{
                                // add entry to output to tell user they are not allowed to send login details
                                $email_list_start .= '<li>You do not have the require permission to send login details</li>';
                            }
                        }  
                        
                        if(in_array('ftp',$_POST['multiselect_csv2post_contactinclude'])){  
                            // include ftp details, can we get them from Wordpress or Server automatically???
                            // if not auto, user must enter ftp details in settings (may be used for other features) 
                            if(csv2post_contact_ftpstored() || csv2post_contact_ftpsubmitted()){
                                $email_list_start .= '<li>FTP login are being sent to help support access your Wordpress</li>';
                            }else{
                                $email_list_start .= '<li>FTP details canot be sent, they have not been provided</li>';                        
                            }
                        }   
                                                
                        if(in_array('hosting',$_POST['multiselect_csv2post_contactinclude'])){  
                            // include hosting details - user must enter them in settings
                            // if not already in settings, display more form fields for this
                        }    
                                             
                        if(in_array('mysql',$_POST['multiselect_csv2post_contactinclude'])){  
                            // include mysql database login details
                        }     
                    }// end if none in contact include - user must uncheck the none option to send data               
                                  
                    // call the ticket web service function which validates values first before using soapcall function     
                    csv2post_api_webservice_ticket('create',null,$ticket_array,true);   
                }         
            }
        }  */
        
        ######################### Send email last so we can include information about Contact
        ####                 ####
        ####   SEND EMAIL    ####
        ####                 ####
        ######################### 
        
        $emailmessage_start = '<html><body>
        
        <p>Sent from ' . WTG_C2P_PLUGINTITLE .'</p>
        
        <p><strong>Reason:</strong> ' . WTG_C2P_PLUGINTITLE .'</p>   
            
        <p><strong>Priority:</strong> unknown tbc @todo</p>

        <h3>Description</h3>
        <p>DESCRIPTION HERE</p>';
        
        // add further details depending on the reason for contact and fields completed
        ### @todo LOW PRIORITY complete email layout
        $emailmessage_middle = '';
              
        $emailmessage_end = '</body></html>';    
     
        $finalemailmessage = $emailmessage_start . $emailmessage_middle . $emailmessage_end;
        
        wp_mail('help@csv2post.com','Contact From '.WTG_C2P_PLUGINTITLE,$emailmessage); 
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    } 
}

/**
* Hide Tab Post Validation
*/
function csv2post_form_hidetab(){

    if(isset( $_POST[WTG_C2P_ABB.'hidetab_request'] ) && $_POST[WTG_C2P_ABB.'hidetab_request'] == true){ 
        
        global $csv2post_mpt_arr;

        // update local tab menu array
        $csv2post_mpt_arr_updateresult = csv2post_hideshow_tab(false,$_POST[WTG_C2P_ABB . 'hidden_pageid'],$_POST[WTG_C2P_ABB . 'hidden_tabnumber']);
             
        if($csv2post_mpt_arr_updateresult){

            $tabscreen_name = $csv2post_mpt_arr[ $_POST[WTG_C2P_ABB . 'hidden_pageid'] ]['tabs'][ $_POST[WTG_C2P_ABB . 'hidden_tabnumber'] ]['label'];
            
            $tabscreen_pagename = $csv2post_mpt_arr[ $_POST[WTG_C2P_ABB . 'hidden_pageid'] ]['menu'];             

            csv2post_notice('You have hidden the tab for '.$tabscreen_name.' on the '.$tabscreen_pagename.' page. You can display it again on the Settings page.','success','Extra');
            
                    ### @todo LOW PRIORITY log this change
        }else{
            
            csv2post_notice('Failed to hide the tab, please report this issue if it continues to happen.','error','Extra');
            ### @todo LOW PRIORITY log this as error
        }              
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    } 
}

/**
* Tab Display Settings Post Validation
*/
function csv2post_form_tabdisplay(){
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'settings' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'tabsdisplay'){
                       
        global $csv2post_mpt_arr; 

        // original array item:  $csv2post_mpt_arr['main']['tabs'][0]['display'] = true; 

        // loop through page array
        // we need to get the page id first, in the example it is main
        foreach($csv2post_mpt_arr as $pageid => $pagearray){

            $tabcounter = 0;

            foreach($pagearray['tabs'] as $tab){

                if( isset($_POST['radio_'.$tab['slug']] )){
                 
                    if( $_POST['radio_'.$tab['slug']] == $tab['slug'].'_show' ){
                        
                        $csv2post_mpt_arr[ $pageid ]['tabs'][ $tabcounter ]['display'] = true;
                                 
                    }elseif($_POST['radio_'.$tab['slug']] == $tab['slug'].'_hide'){
                        
                        $csv2post_mpt_arr[ $pageid ]['tabs'][ $tabcounter ]['display'] = false;                        
                    }
                      
                }
                
                ++$tabcounter;   
            }
        }

        $update_tabmenu_result = csv2post_update_tabmenu($csv2post_mpt_arr);
          
        csv2post_notice('Tab settings have been saved. The plugins interface may change as a result of the new settings.','success','Extra','');
              
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    } 
}

function csv2post_form_changetheme(){
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'settings' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'plugintheme'){
        
        $themeupdate_result = update_option(WTG_C2P_ABB.'theme',$_POST['radio']);?>
        
        <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="Theme Changed">
        <?php  csv2post_notice(__('Your new theme selection for '.WTG_C2P_PLUGINTITLE.' will take effect when you refresh the page.'),'success','Extra','Plugin Theme Changed');?>
        </div><?php
        csv2post_jquerydialogue_results();    
        
        // return false to stop all further post validation function calls
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    }                 
}

/**
 * Creates a new directory (folder) using giving path, validation is expected to have been done already
 * @param uri $pathdir
 * @param numeric $per (chmod permissions)
 * @todo this needs to be improved to make a log and report errors for viewing in history
 */
function csv2post_form_createfolder($path,$chmod = 0755){
    if(mkdir($path,0755,true)){ 
        return true;
    }else{
        return false;
    }
}

/**
 * Processes FREE Reinstalls of the plugin, does output (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function csv2post_process_free_reinstall(){
    
    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)               
    $atts['date'] = csv2post_date();// csv2post_date()   
    $atts['line'] = __LINE__;// __LINE__
    $atts['file'] = __FILE__;// __FILE__
    $atts['function'] = __FUNCTION__;// __FUNCTION__
    $atts['logtype'] = 'admin';// general, sql, admin, user, error (can be others but all fit into these categories)
    $atts['dump'] = 'None';// TODO: LOWPRIORITY, add re-install $_POST values to the dump
    $atts['comment'] = 'Admin requested re-installation, see the dump to confirm what parts were being re-installed';// comment to help users or developers (recommended 60-80 characters long)
    $atts['style'] = 'processing';// Notice box style (info,success,warning,error,question,processing,stop)
    $atts['category'] = 'install,installation,reinstall';// used to filter entries, a lowercase keyword // TODO: make this comma seperated values but also make the log viewer search through them
    csv2post_log($atts);
    
    csv2post_jquerydialogue_results();?>
    <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="Outcome For <?php echo $_POST[WTG_C2P_ABB.'hidden_panel_title'];?>">
        <?php //  ######   @todo    $reinstall_result = ;//?>
    </div><?php
}

/**
 * Processes FULL Reinstalls of the plugin, does output (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function csv2post_process_full_reinstall(){
    
    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)               
    $atts['date'] = csv2post_date();// csv2post_date()   
    $atts['line'] = __LINE__;// __LINE__
    $atts['file'] = __FILE__;// __FILE__
    $atts['function'] = __FUNCTION__;// __FUNCTION__
    $atts['logtype'] = 'admin';// general, sql, admin, user, error (can be others but all fit into these categories)
    $atts['dump'] = 'None';// TODO: LOWPRIORITY, add re-install $_POST values to the dump
    $atts['comment'] = 'Admin requested re-installation, see the dump to confirm what parts were being re-installed';// comment to help users or developers (recommended 60-80 characters long)
    $atts['style'] = 'processing';// Notice box style (info,success,warning,error,question,processing,stop)
    $atts['category'] = 'install,installation,reinstall';// used to filter entries, a lowercase keyword // TODO: make this comma seperated values but also make the log viewer search through them
    csv2post_log($atts);
    
    csv2post_jquerydialogue_results();?>
    <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="Outcome For <?php echo $_POST[WTG_C2P_ABB.'hidden_panel_title'];?>">
        <?php //  ######   @todo    $reinstall_result = ;//?>
    </div><?php
}

/**
 * Processes FREE Uninstalls the plugin, does output  (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function csv2post_process_free_uninstall(){

    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)               
    $atts['date'] = csv2post_date();// csv2post_date()   
    $atts['line'] = __LINE__;
    $atts['file'] = __FILE__;
    $atts['function'] = __FUNCTION__;
    $atts['logtype'] = 'admin';// general, sql, admin, user, error (can be others but all fit into these categories)
    $atts['dump'] = 'None';// anything, variable, text, url, html, php // TODO: LOWPRIORITY, 
    $atts['comment'] = 'None';// comment to help users or developers (recommended 60-80 characters long)
    $atts['sql_result'] = 'NA';// wordpress sql result value
    $atts['sql_query'] = 'NA';// wordpress sql query value
    $atts['style'] = 'processing';// Notice box style (info,success,warning,error,question,processing,stop)
    $atts['category'] = 'install,installation,uninstall';// used to filter entries, a lowercase keyword // TODO: make this comma seperated values but also make the log viewer search through them
    csv2post_log($atts);
            
    csv2post_jquerydialogue_results(csv2post_link_toadmin(WTG_C2P_ABB.'install'),'Click Here');?>
    <div id="<?php echo WTG_C2P_ABB;?>dialogueoutcome" title="Outcome For <?php echo $_POST[WTG_C2P_ABB.'hidden_panel_title'];?>">
        <?php csv2post_uninstall();?>
    </div><?php
}

/**
 * Processes Uninstalls the plugin, does output  (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function csv2post_process_full_uninstall(){

    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)               
    $atts['date'] = csv2post_date();// csv2post_date()   
    $atts['line'] = __LINE__;
    $atts['file'] = __FILE__;
    $atts['function'] = __FUNCTION__;
    $atts['logtype'] = 'admin';// general, sql, admin, user, error (can be others but all fit into these categories)
    $atts['dump'] = 'None';// anything, variable, text, url, html, php // TODO: LOWPRIORITY, 
    $atts['comment'] = 'None';// comment to help users or developers (recommended 60-80 characters long)
    $atts['sql_result'] = 'NA';// wordpress sql result value
    $atts['sql_query'] = 'NA';// wordpress sql query value
    $atts['style'] = 'processing';// Notice box style (info,success,warning,error,question,processing,stop)
    $atts['category'] = 'install,installation,uninstall';// used to filter entries, a lowercase keyword // TODO: make this comma seperated values but also make the log viewer search through them
    csv2post_log($atts);
            
    csv2post_jquerydialogue_results(csv2post_link_toadmin(WTG_C2P_ABB.'install'),'Click Here');?>
    <div id="csv2post_dialogueoutcome" title="Outcome For <?php echo $_POST[WTG_C2P_ABB.'hidden_panel_title'];?>">
        <?php csv2post_uninstall();?>
    </div><?php
}

/**
 * Processes FULL installation request
 *
 * @uses csv2post_jquerydialogue_results(), adds jquery dialogue script for result output
 * @uses csv2post_install(), this is the actual installation process
 */
function csv2post_process_full_install(){?>
    <div id="csv2post_dialogueoutcome" title="Outcome For <?php echo $_POST['csv2post_hidden_panel_title'];?>">
        <p>Welcome to the CSV 2 POST import plugin for Wordpress. Installation results are below, please
        report any notifications that are not green (green notifications equal 100% success). Please click
        Continue. You will be taking to the Easy Configuration Questions screen. The questions act like settings,
        allowing CSV 2 POST to adapt to your needs by hiding or displaying features.</p>
      <?php csv2post_install();?>     
    </div><?php
   csv2post_jquerydialogue_results(csv2post_link_toadmin('csv2post','#tabs-0'),'Continue');
}
?>