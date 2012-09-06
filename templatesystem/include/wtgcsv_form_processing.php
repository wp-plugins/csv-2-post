<?php 
// Instructions
// 1. wtgcsv_include_form_processing_php() calls this file, used in the same functions that include page files 
// 2. wtgcsv_form_submission_processing() requires $_POST[WTG_CSV_ABB.'post_processing_required']
// 3. This file does initial validation of values before processing i.e. database changes or file changes
// 4. wtgcsv_form_submission_processing also requires user to be logged in
// 5. This file can avoid calling processing functions using $e, importing when a $_POST is part of a long process

// exit validation function calls variable - use to avoid calling functions once $_POST processing done 
$cont = true;   
global $wtgcsv_notice_result;

# TODO: add hidden input with value uses in these arguments to skip more function calls i.e. one per screen

// Data Screen Form Submissions
if($cont){
    
    // create a new data import job
    $cont = wtgcsv_form_createdataimportjob();
        
    // Delete Data Import Jobs
    $cont = wtgcsv_form_delete_dataimportjobs();
    
    // Process CSV file upload    
    $cont = wtgcsv_form_upload_csv_file(); 
    
    // Delete one or more database tables
    $cont = wtgcsv_form_drop_database_tables();   
}

// Project Screen Form Submissions (project creation and configuration)
if($cont){

    // Create post creation project
    $cont = wtgcsv_form_create_post_creation_project();
    
    // Multiple file project relationship settings panel
    $cont = wtgcsv_form_save_multiplefilesproject();
    
    // Delete one or more post creation projects
    $cont = wtgcsv_form_delete_post_creation_projects();
    
    // Change current project
    $cont = wtgcsv_form_change_current_project();
    
    // Save template
    $cont = wtgcsv_form_save_contenttemplate();
    
    // Dynamic content rule (by value)
    $cont = wtgcsv_form_save_contenttemplatedesign_condition_byvalue();
    
    // Update the default content template design for current project
    $cont = wtgcsv_form_change_default_contenttemplate();
    
    // Update the default 
    $cont = wtgcsv_form_change_default_titletemplate();    
    
    // Insert new wtgcsvtitle post as a title template
    $cont = wtgcsv_form_insert_title_template();
    
    // Update title templates
    $cont = wtgcsv_form_update_titletemplates();
    
    // Update projects default custom post type
    $cont = wtgcsv_form_update_defaultposttype();
    
    // Insert new post type value condition (apply post types based on value in table column)
    $cont = wtgcsv_form_save_posttype_condition_byvalue();
    
    // Reset date method to Wordpress default
    $cont = wtgcsv_form_set_datemethod_default();
    
    // Save date column
    $cont = wtgcsv_form_update_datecolumn();
    
    // Save random publish date settings (also activates this method)
    $cont = wtgcsv_form_save_randompublishdate_settings();
    
    // Save incremental publish date settings (also activates this method)
    $cont = wtgcsv_form_save_incrementalpublishdate_settings();
    
    // Save default tags column
    $cont = wtgcsv_form_save_default_tags_column();
    
    // Save tag generator settings (full edition only)
    $cont = wtgcsv_form_save_tag_generator_settings();    
                               
    // Adds a basic post meta rule - custom field
    $cont = wtgcsv_form_add_basic_custom_field();
    
    // Deletes basic custom field rules
    $cont = wtgcsv_form_delete_basiccustomfields();

    // Adds a advanced post meta rule - custom field
    $cont = wtgcsv_form_add_advanced_custom_field();
        
    // Deletes advanced custom field rules
    $cont = wtgcsv_form_delete_advancedcustomfields();        
        
    // Save standard category configuration
    $cont = wtgcsv_form_save_categories_standard();
    
    // Save advanced category configuration
    $cont = wtgcsv_form_save_categories_advanced();
    
    // Save category mapping (data values too)
    $cont = wtgcsv_form_save_category_mapping();
    
    // Save project post content update settings
    $cont = wtgcsv_form_save_projectupdatesettings();
    
    // Save default category
    $cont = wtgcsv_form_save_default_category();
    
    // Save tag creation rules
    $cont = wtgcsv_form_save_tag_rules();
    
    // Save a new HTML shortcode - this one offers a shortcode showing shortcode name (no need for user to enter values in shortcode)
    $cont = wtgcsv_form_save_htmlshortcode();
    
    // Deletes random advanced shortcode rules
    $cont = wtgcsv_form_delete_randomadvanced_shortcoderules();
    
    // Save basic SEO options
    $cont = wtgcsv_form_save_basic_seo_options();
    
    // Save easy configuration questions
    $cont = wtgcsv_form_save_easyconfigurationquestions();
}

// Creation Screen
if($cont){  
    $cont = wtgcsv_form_save_dripfeedprojects_switch();
    
    // Save global allowed days and hours
    $cont = wtgcsv_form_save_scheduletimes_global();
    
    // Save drip feed limits
    $cont = wtgcsv_form_save_schedulelimits();
    
    // Start post creation even manually
    $cont = wtgcsv_form_start_post_creation();
    
    // Save event types
    $cont = wtgcsv_form_save_eventtypes();        
}

if($cont){
    
    // Log File Installation Post Validation
    $cont = wtgcsv_form_logfileinstallation();

    // Delete Log File Post Validation
    $cont = wtgcsv_form_deletelogfile();
    
    // Disable Log File Post Validation  
    $cont = wtgcsv_form_disablelogfile();
    
    // Activate Log File Post Validation
    $cont = wtgcsv_form_activatelogfile();
    
    // View Log File Post Validation
    $cont = wtgcsv_form_viewlogfile();
    
    // Contact Form Submission Post Validation
    $cont = wtgcsv_form_contactformsubmission();
    
    // Hide Tab Post Validation
    $cont = wtgcsv_form_hidetab();

    // Tab Display Settings Post Validation  
    $cont = wtgcsv_form_tabdisplay();
    
    // Test CSV File 
    $cont = wtgcsv_form_test_csvfile();
    
    // Create a data rule for replacing specific values after import 
    $cont = wtgcsv_form_create_datarule_replacevalue(); 
}

// rare used forms      
if($cont){
    $cont = wtgcsv_form_changetheme();  
    $cont = wtgcsv_form_installplugin();   
    $cont = wtgcsv_form_reinstallplugin();    
    $cont = wtgcsv_form_uninstallplugin();
    $cont = wtgcsv_form_createcontentfolder();
    $cont = wtgcsv_form_deletecontentfolder();    
}

/**
* Saves easy configuration questions
*/
function wtgcsv_form_save_easyconfigurationquestions(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'easyconfigurationquestions'){

        ### TODO:HIGHPRIORITY
                
        return false;
    }else{
        return true;
    }       
}                    
                
/**
* Saves basic seo options          
*/
function wtgcsv_form_save_basic_seo_options(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'advancedseooptions'){
        global $wtgcsv_project_array,$wtgcsv_currentproject_code;
        
        // title
        if(isset($_POST['wtgcsv_seo_titlekey_advanced']) && $_POST['wtgcsv_seo_titlekey_advanced'] != '' && is_string($_POST['wtgcsv_seo_titlekey_advanced'])){
            $wtgcsv_project_array['seo']['advanced']['title_key'] = $_POST['wtgcsv_seo_titlekey_advanced'];
            if(!isset($_POST['wtgcsv_seo_title_advanced'])){
                wtgcsv_notice('No SEO title template was selected and it is required if you want your posts
                to have meta title values.','error','Large','Please Select Title Template','','echo');
            }     
        }

        if(isset($_POST['wtgcsv_seo_title_advanced']) && $_POST['wtgcsv_seo_title_advanced'] != '' && is_numeric($_POST['wtgcsv_seo_title_advanced'])){
            $wtgcsv_project_array['seo']['advanced']['title_template'] = $_POST['wtgcsv_seo_title_advanced'];     
            if(!isset($_POST['wtgcsv_seo_titlekey_advanced'])){
                wtgcsv_notice('You selected a title template but did not select your SEO plugin that will be handling
                your meta titles. You must select the SEO plugin so that the proper meta key is used.','error','Large','Please Select Title Plugin','','echo');
            }        
        }        
        
        // description
        if(isset($_POST['wtgcsv_seo_descriptionkey_advanced']) && $_POST['wtgcsv_seo_descriptionkey_advanced'] != '' && is_string($_POST['wtgcsv_seo_descriptionkey_advanced'])){
            $wtgcsv_project_array['seo']['advanced']['description_key'] = $_POST['wtgcsv_seo_descriptionkey_advanced'];
            if(!isset($_POST['wtgcsv_seo_description_advanced'])){
                wtgcsv_notice('No SEO description template was selected and it is required if you want your posts
                to have meta description values.','error','Large','Please Select Description Template','','echo');
            }     
        }

        if(isset($_POST['wtgcsv_seo_description_advanced']) && $_POST['wtgcsv_seo_description_advanced'] != '' && is_numeric($_POST['wtgcsv_seo_description_advanced'])){
            $wtgcsv_project_array['seo']['advanced']['description_template'] = $_POST['wtgcsv_seo_description_advanced'];     
            if(!isset($_POST['wtgcsv_seo_descriptionkey_advanced'])){
                wtgcsv_notice('You selected a description template but did not select your SEO plugin that will be handling
                your meta description. You must select the SEO plugin so that the proper meta key is used.','error','Large','Please Select Description Plugin','','echo');
            }        
        }         
         
        // keywords
        if(isset($_POST['wtgcsv_seo_keywordskey_advanced']) && $_POST['wtgcsv_seo_keywordskey_advanced'] != '' && is_string($_POST['wtgcsv_seo_keywordskey_advanced'])){
            $wtgcsv_project_array['seo']['advanced']['keywords_key'] = $_POST['wtgcsv_seo_keywordskey_advanced'];
            if(!isset($_POST['wtgcsv_seo_keywords_advanced'])){
                wtgcsv_notice('No SEO keywords template was selected and it is required if you want your posts
                to have meta keywords values.','error','Large','Please Select Keywords Template','','echo');
            }     
        }

        if(isset($_POST['wtgcsv_seo_keywords_advanced']) && $_POST['wtgcsv_seo_keywords_advanced'] != '' && is_numeric($_POST['wtgcsv_seo_keywords_advanced'])){
            $wtgcsv_project_array['seo']['advanced']['keywords_template'] = $_POST['wtgcsv_seo_keywords_advanced'];     
            if(!isset($_POST['wtgcsv_seo_keywordskey_advanced'])){
                wtgcsv_notice('You selected a keywords template but did not select your SEO plugin that will be handling
                your meta keywords. You must select the SEO plugin so that the proper meta key is used.','error','Large','Please Select Keywords Plugin','','echo');
            }        
        }          
          
        // update $wtgcsv_project_array
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        wtgcsv_notice('Advanced SEO options have been saved.','success','Large','SEO Options Saved','','echo',false,false); 
                                 
        return false;
    }else{
        return true;
    }       
}    

/**
* Deletes random advanced shortcode rules
*/
function wtgcsv_form_delete_randomadvanced_shortcoderules(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'deleterandomvalueshortcodes'){
        
        if(isset($_POST['wtgcsv_shortcodeadvanced_delete'])){
            global $wtgcsv_textspin_array;
            if(is_array($_POST['wtgcsv_shortcodeadvanced_delete'])){
                foreach($_POST['wtgcsv_shortcodeadvanced_delete'] as $key => $shortcode_name){
                    if(isset($wtgcsv_textspin_array['randomvalue'][ $shortcode_name ])){
                        unset($wtgcsv_textspin_array['randomvalue'][ $shortcode_name ]);
                    }        
                }
                wtgcsv_update_option_textspin($wtgcsv_textspin_array);
                wtgcsv_notice('All selected advanced random value shortcode rules have been deleted.','success','Large','Shortcode Rules Deleted','','echo');
                return false;    
            }else{
                if(isset($wtgcsv_textspin_array['randomvalue'][ $_POST['wtgcsv_shortcodeadvanced_delete'] ])){
                    unset($wtgcsv_textspin_array['randomvalue'][ $_POST['wtgcsv_shortcodeadvanced_delete'] ]);
                    wtgcsv_update_option_textspin($wtgcsv_textspin_array);
                    wtgcsv_notice('The selected advanced random value shortcode rule has been deleted.','success','Large','Shortcode Rules Deleted','','echo');
                    return false;
                }    
            }    
        }
        
        // we do a return on success - arriving here means no shortcode rules were deleted
        wtgcsv_notice('No shortcode rules have been deleted, please try again then seek support.','error','Large','Shortcode Rules Not deleted','','echo');
        return false;
    }else{
        return true;
    }       
}  
  
/**
* Save a new HTML shortcode - this one offers a shortcode showing shortcode name (no need for user to enter values in shortcode) 
*/
function wtgcsv_form_save_htmlshortcode(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createrandomvalueshortcodes'){
        
        // error if name not entered
        if(!isset($_POST['wtgcsv_shortcodename']) || $_POST['wtgcsv_shortcodename'] == '' || $_POST['wtgcsv_shortcodename'] == ' '){
            wtgcsv_notice('You did not enter a shortcode name, please enter a name that will help you remember what values you have setup.','error','Large','No Shortcode Name Submitted','','echo',false);    
            return false;// stops further post processing
        }
        
        // ensure at least one value has been set
        $values_set = 0;
        for ($i = 1; $i <= 8; $i++) {
            if(isset($_POST['wtgcsv_textspin_v' . $i]) && $_POST['wtgcsv_textspin_v' . $i] != NULL && $_POST['wtgcsv_textspin_v' . $i] != ''){
                ++$values_set;    
            }
        }
        
        if($values_set < 2){
            wtgcsv_notice('You must enter at least two values. Please populate two or more of the text fields.','error','Large','More Values Required','','echo');
            return false;// stops further post processing
        }
        
        // if name already exists
        global $wtgcsv_textspin_array;
        if(isset($wtgcsv_textspin_array['randomvalue'][ $_POST['wtgcsv_shortcodename'] ])){
            wtgcsv_notice('The shortcode name you submitted already exists, please use a different name or delete the existing shortcode.','warning','Large','Shortcode Name Exists Already','','echo');
            return false;
        }
                
        // cant assume user filled out text fields in order so go through all of them
        for ($i = 1; $i <= 8; $i++) {
            if(isset($_POST['wtgcsv_textspin_v' . $i]) && $_POST['wtgcsv_textspin_v' . $i] != NULL && $_POST['wtgcsv_textspin_v' . $i] != ''){
                // dont use for loop $i as key because some values may not be set
                $wtgcsv_textspin_array['randomvalue'][ $_POST['wtgcsv_shortcodename'] ]['values'][] = $_POST['wtgcsv_textspin_v' . $i];   
            }
        }        
        
        wtgcsv_update_option_textspin($wtgcsv_textspin_array);      

        wtgcsv_notice('You saved a new Random Value Shortcode named ' . $_POST['wtgcsv_shortcodename'] . '. You
        can use this shortcode by copying and pasting this bold text: <br />
        <strong>[wtgcsv_random_advanced name="'.$_POST['wtgcsv_shortcodename'].'"]</strong>','success','Large','Random Value Shortcode Created','','echo');

        return false;
    }else{
        return true;
    }       
}
  
/**
* Saves Multiple File Project panel - the configuration options that create relationships between tables
*/
function wtgcsv_form_save_multiplefilesproject(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'multipletableproject'){
        global $wtgcsv_project_array,$wtgcsv_currentproject_code;
        
        // ensure there are not too many "notrequired" values submitted
        foreach($wtgcsv_project_array['tables'] as $key => $table_name){
            
            // set tables own key column
            if(isset($_POST["wtgcsv_multitable_columns_" . $table_name])){
                if($_POST["wtgcsv_multitable_pairing_" . $table_name] != 'notrequired'){
                    $wtgcsv_project_array['multipletableproject']['relationships'][$table_name]['primarykey'] = $_POST["wtgcsv_multitable_columns_" . $table_name];    
                }else{
                    $wtgcsv_project_array['multipletableproject']['relationships'][$table_name]['primarykey'] = false;                    
                }
            }    

            // set the table and column (foreign key) that the current tables primary key has a relationship with
            if(isset($_POST["wtgcsv_multitable_pairing_" . $table_name])){
                
                if($_POST["wtgcsv_multitable_pairing_" . $table_name] != 'notrequired'){
                    // extract table and column name from $_POST value
                    $wtgcsv_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST["wtgcsv_multitable_pairing_" . $table_name]); 
                    $wtgcsv_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST["wtgcsv_multitable_pairing_" . $table_name]);    
                }else{
                    $wtgcsv_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_table'] = false; 
                    $wtgcsv_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_column'] = false;                    
                }
            }
                   
        } 
        
        // update $wtgcsv_project_array
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);        
             
        wtgcsv_notice('Your configuration for the current multiple files project has been saved. 
        If done properly the relationship setup should allow Wordpress CSV Importer to query records 
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
function wtgcsv_form_save_eventtypes(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'creation' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'eventtypes'){
        global $wtgcsv_schedule_array;   

        $wtgcsv_schedule_array['eventtypes']["postcreation"] = $_POST["postcreation"];
        $wtgcsv_schedule_array['eventtypes']["postupdate"] = $_POST["postupdate"];
        $wtgcsv_schedule_array['eventtypes']["dataimport"] = $_POST["dataimport"];
        $wtgcsv_schedule_array['eventtypes']["dataupdate"] = $_POST["dataupdate"];
        $wtgcsv_schedule_array['eventtypes']["twittersend"] = $_POST["twittersend"];
        $wtgcsv_schedule_array['eventtypes']["twitterupdate"] = $_POST["twitterupdate"];
        $wtgcsv_schedule_array['eventtypes']["twitterget"] = $_POST["twitterget"];
      
        wtgcsv_update_option_schedule_array($wtgcsv_schedule_array);
        
        wtgcsv_notice('Schedule event types have been saved, the changes will have an effect on the types of events run, straight away.','success','Large','Schedule Event Types Saved','','echo');
        return false;
    }else{
        return true;
    }          
} 
    
/**
* Create a data rule for replacing specific values after import 
*/
function wtgcsv_form_create_datarule_replacevalue(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'data' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'replacevalues'){
        global $wtgcsv_currentjob_code;

        echo '<p>UNDER CONSTRUCTION</p>';

        return false;
    }else{
        return true;
    }          
} 

/**
* Saves tag rules submission
*/
function wtgcsv_form_save_tag_rules(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'tagrules'){
        global $wtgcsv_project_array,$wtgcsv_currentproject_code;
        
        // save numeric allow/disallow setting
        if(isset($_POST['wtgcsv_numerics'])){
            $wtgcsv_project_array['tags']['rules']['numericterms'] = $_POST['wtgcsv_numerics'];    
        }
        
        // save excluded terms
        if(isset($_POST['wtgcsv_excludedtag']) && is_string($_POST['wtgcsv_excludedtag'])){
            
            // if there are already excluded terms, we need to put them into string for joining to new submission
            $old_string = '';
            if(isset($wtgcsv_project_array['tags']['rules']['excluded']) && is_array($wtgcsv_project_array['tags']['rules']['excluded'])){
                $old_string = implode($wtgcsv_project_array['tags']['rules']['excluded']);
            }
            
            $new_string = $_POST['wtgcsv_excludedtag'] . ',' . $old_string;
            
            $wtgcsv_project_array['tags']['rules']['excluded'] = explode(',',$new_string);   
        }
        
        // save tags per post
        if(isset($_POST['wtgcsv_tagsperpost']) && is_numeric($_POST['wtgcsv_tagsperpost'])){
            $wtgcsv_project_array['tags']['rules']['tagsperpost'] = $_POST['wtgcsv_tagsperpost'];    
        }
        
        // save tag string length
        if(isset($_POST['wtgcsv_tagstringlength']) && is_numeric($_POST['wtgcsv_tagstringlength'])){
            $wtgcsv_project_array['tags']['rules']['tagstringlength'] = $_POST['wtgcsv_tagstringlength'];    
        }
        
        // delete tags
        if(isset($_POST['wtgcsv_tagslist_delete'])){
            foreach($_POST['wtgcsv_tagslist_delete'] as $key => $delete_tag){
                ### TODO:HIGHPRIORITY, establish the best way to locate the tags in array and unset them    
            }
        }       

        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('Tag rules have been saved.','success','Large','Tag Rules/Settings Saved','','echo');
                
        return false;
    }else{
        return true;
    }          
} 
 
  
/**
* Saves advanced tag generator settings 
*/
function wtgcsv_form_save_tag_generator_settings(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'generatetags'){
        global $wtgcsv_project_array,$wtgcsv_currentproject_code;
      
        if(!isset($_POST["wtgcsv_taggenerator_columns"])){
            wtgcsv_notice('No columns were selected. You must select data columns that hold suitable values for generating tags with.','error','Large','Please Select Columns','','echo');    
            return false;
        }
        
        // loop through selected columns
        foreach($_POST["wtgcsv_taggenerator_columns"] as $key => $table_column ){
            $wtgcsv_project_array['tags']['generator']['data'][$key]['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$table_column);
            $wtgcsv_project_array['tags']['generator']['data'][$key]['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$table_column);            
        }
        
        $wtgcsv_project_array['tags']['method'] = 'generator';       
        
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('Tag generator settings have been saved and Wordpress CSV Importer will generator tags from your selected columns for all posts.','success','Large','Tag Generator Settings Saved','','echo');
        
        return false;
    }else{
        return true;
    }          
}

/**
* Resets publish date method to Wordpress default by deleting the "dates" value in project array 
*/
function wtgcsv_form_set_datemethod_default(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'projectdatemethod'){
        global $wtgcsv_currentproject_code,$wtgcsv_project_array;

        unset($wtgcsv_project_array['dates']['currentmethod']); 
                
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('The current projects publish dates will be controlled by Wordpress default.','success','Large','Publish Date Method Reset','','echo');      
  
        return false;
    }else{
        return true;
    }          
}

/**
* Deletes one or more database tables
*/
function wtgcsv_form_drop_database_tables(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'data' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createddatabasetableslist'){

        if(!isset($_POST["wtgcsv_table_array"])){
            wtgcsv_notice('You did not select any database tables. Check the boxes for the tables you want to delete.','warning','Large','No Tables Deleted','','echo');
            return false;
        }else{
            
            global $wpdb,$wtgcsv_jobtable_array,$wtgcsv_dataimportjobs_array;
            
            foreach($_POST["wtgcsv_table_array"] as $key => $table_name){
                
                // if table is in use by a data import job we do not delete it, the job must be deleted first
                $code = str_replace('wtgcsv_','',$table_name);   
                
                if(isset($wtgcsv_dataimportjobs_array[$code])){
                    wtgcsv_notice('Table named '.$table_name.' is still used by Data Import Job named '.$wtgcsv_dataimportjobs_array[$code]['name'].'. Please delete the job first then delete the database table.','warning','Large','Cannot Delete ' . $table_name,'','echo');
                }else{
                    // drop table
                    $wpdb->query( 'DROP TABLE '. $table_name );
                    
                    // remove table from $wtgcsv_jobtable_array
                    foreach($wtgcsv_jobtable_array as $key => $jobtable_name){
                        if($table_name == $jobtable_name){
                            unset($wtgcsv_jobtable_array[ $key ]);
                            wtgcsv_update_option_jobtables_array($wtgcsv_jobtable_array);
                            break;
                        }
                    } 
                
                    wtgcsv_notice('Selected database tables have been deleted (dropped) from your database. This change cannot be reversed.','success','Large','Database Tables Deleted','','echo');
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
function wtgcsv_form_delete_basiccustomfields(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'deletebasiccustomfieldrules'){
        global $wtgcsv_currentproject_code,$wtgcsv_project_array;
   
        unset($wtgcsv_project_array['custom_fields']['basic'][$_POST['wtgcsv_customfield_rule_arraykey']]);                        
                
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('You have deleted a basic custom field rule, one less meta value will be added to all posts from here on in this project.','success','Large','Basic Custom Field Rule Deleted','','echo');      

        return false;
    }else{
        return true;
    }          
}
  
/**
* Deletes advanced custom field rules
* @todo HIGHPRIORITY, change to delete many checked boxes at once not just one 
*/
function wtgcsv_form_delete_advancedcustomfields(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'deleteadvancedcustomfieldrules'){
        global $wtgcsv_currentproject_code,$wtgcsv_project_array;
   
        unset($wtgcsv_project_array['custom_fields']['advanced'][$_POST['wtgcsv_customfield_rule_arraykey']]);                        
                
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('You have deleted an advanced custom field rule, one less meta value will be added to all posts from here on in this project.','success','Large','Advanced Custom Field Rule Deleted','','echo');      

        return false;
    }else{
        return true;
    }    
} 
    
/**
* Saves and activates incremental publish date settings
* @todo LOWPRIORITY, validate dates 
*/
function wtgcsv_form_save_incrementalpublishdate_settings(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'incrementalpublishdatessettings'){
        global $wtgcsv_currentproject_code,$wtgcsv_project_array,$wtgcsv_is_free;
   
        // do not allow save if free edition (bypassing this will cause problems during post creation)
        if($wtgcsv_is_free){
            wtgcsv_notice('The data method you submitted can only be used in the paid editions advanced post creation scripts. Your post publish dates will always default to the current time and date when they are created.','warning','Large','Date Method Not Available','','echo');
            return false;
        }
        
        // replace spaces in minutes increment string
        $minutes_increment = str_replace(' ','',$_POST['wtgcsv_increment_range']);
        $explode = explode('-',$minutes_increment);

        $wtgcsv_project_array['dates']['currentmethod'] = 'increment'; 
        $wtgcsv_project_array['dates']['increment']['start'] = $_POST['wtgcsv_publishdateincrement_start'];
        $wtgcsv_project_array['dates']['increment']['short'] = $explode[0];
        $wtgcsv_project_array['dates']['increment']['long'] = $explode[1];                
        
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('Increment publish date settings have been saved. This method of applying publish dates has also been activated. Submit another form if you do not want to activate the incremental publish date method.','success','Large','Incremental Publish Date Settings Saved','','echo');      

        return false;
    }else{
        return true;
    }     
}

/**
* Saves and activates random publish date method settings
* @todo LOWPRIORITY, validate submitted dates, ensure end date is not before start  
*/
function wtgcsv_form_save_randompublishdate_settings(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'randompublishdatesettings'){
        global $wtgcsv_currentproject_code,$wtgcsv_project_array,$wtgcsv_is_free;
      
        // do not allow save if free edition (bypassing this will cause problems during post creation)
        if($wtgcsv_is_free){
            wtgcsv_notice('The data method you submitted can only be used in the paid editions advanced post creation scripts. Your post publish dates will always default to the current time and date when they are created.','warning','Large','Date Method Not Available','','echo');
            return false;
        }
              
        $wtgcsv_project_array['dates']['currentmethod'] = 'random'; 
        $wtgcsv_project_array['dates']['random']['start'] = $_POST['wtgcsv_randompublishdate_start'];
        $wtgcsv_project_array['dates']['random']['end'] = $_POST['wtgcsv_randompublishdate_end'];

        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('Random publish date settings have been saved. This method of applying publish dates has also been activated. Submit another form if you do not want to activate the random publish date method.','success','Large','Random Publish Date Settings Saved','','echo');      
  
        return false;
    }else{
        return true;
    }      
}      
  
// Save category mapping (data values too)
function wtgcsv_form_save_category_mapping(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createcategorymappingrules'){
        global $wtgcsv_currentproject_code,$wtgcsv_project_array;
        
        // loop number of set category levels 
        for($lev = 1; $lev <= $_POST['wtgcsv_category_levels']; $lev++){

            // loop the number of distinct values in the current level i.e. 8 times for 8 distinct values in column
            for($dis = 1; $dis <= $_POST['wtgcsv_distinct_values_count_lev'.$lev]; $dis++){

                // this holds distinct value
                $_POST['wtgcsv_distinct_value_lev'.$lev.'_inc'.$dis];    
                // i.e. $_POST['wtgcsv_distinct_value_lev3_inc8']

                // ensure menu option is not "notselected" and the expected DISTINCT value is not null
                if(isset($_POST['wtgcsv_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select']) && $_POST['wtgcsv_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select'] != 'notselected' ){

                    $wtgcsv_project_array['categories']['level'.$lev]['mapping'][ $_POST['wtgcsv_distinct_value_lev'.$lev.'_inc'.$dis] ] = $_POST['wtgcsv_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select'];

                }

            }
   
        }   
 
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('Your category mapping has been saved','success','Large','Category Mapping Saved','','echo');

        return false;
    }else{
        return true;
    }      
}     
    
    
/**
* Saves advanced category submission 
*/
function wtgcsv_form_save_categories_advanced(){
    global $wtgcsv_currentproject_code,$wtgcsv_project_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'advancedcategories'){
        
        // ensure the previous column has been selected for every column user submits
        $required_column_missing = false;// set to true if a required column has not been selected
        $required_column_level = false;// change too level 1,2,3 or 4 to indicate which column has not been selected but should be
        
        // check for level 1 - always required
        if( $_POST['wtgcsv_categorylevel1_advanced'] == 'notselected' ){
            wtgcsv_notice('You did not select a level one data table and column, you must always use level one if you want to create categories using this panel.','error','Large','Level One Not Selected');
            return false;//discontinue post function processing
        }
        
        // check if 3 is set - requires 2
        if( $_POST['wtgcsv_categorylevel3_advanced'] != 'notselected' && $_POST['wtgcsv_categorylevel2_advanced'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 2;
        }
        
        // check if 4 is set - requires 3
        if( !$wtgcsv_is_free && $_POST['wtgcsv_categorylevel4_advanced'] != 'notselected' && $_POST['wtgcsv_categorylevel3_advanced'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 3;
        }       
        
        // check if 5 is set - requires 4
        if( !$wtgcsv_is_free && $_POST['wtgcsv_categorylevel5_advanced'] != 'notselected' && $_POST['wtgcsv_categorylevel4_advanced'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 4;
        }        
        
        // only continue if all required columns have been selected
        if($required_column_missing){
            $column_above_missing_level = $required_column_level + 1;
            wtgcsv_notice('You did not appear to select all required columns. You selected a column for category level '.$column_above_missing_level.' but did not select one for category level '.$required_column_level.'. You must select category columns in order as displayed i.e. use 1,2 and 3 for three levels not 1,2 and 4.','error','Large','Missing Category Column Selection');
            return false;// discontinues post functions processing        
        }else{
    
            $wtgcsv_project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);   
            
            // add level 1 
            $wtgcsv_project_array['categories']['level1']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel1_advanced']);
            $wtgcsv_project_array['categories']['level1']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel1_advanced']);            

            // save level 1 description template id if selected
            if(isset($_POST['wtgcsv_categorylevel1_description'])){
                $wtgcsv_project_array['categories']['level1']['description'] = $_POST['wtgcsv_categorylevel1_description'];        
            }
            
            // add level 2
            if($_POST['wtgcsv_categorylevel2_advanced'] != 'notselected'){
                $wtgcsv_project_array['categories']['level2']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel2_advanced']);
                $wtgcsv_project_array['categories']['level2']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel2_advanced']);                     
            
                // save level 2 description template id if selected
                if(isset($_POST['wtgcsv_categorylevel2_description'])){
                    $wtgcsv_project_array['categories']['level2']['description'] = $_POST['wtgcsv_categorylevel2_description'];        
                }            
            }
            
            // add level 3
            if($_POST['wtgcsv_categorylevel3_advanced'] != 'notselected'){
                $wtgcsv_project_array['categories']['level3']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel3_advanced']);
                $wtgcsv_project_array['categories']['level3']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel3_advanced']);                     
            
                // save level 3 description template id if selected
                if(isset($_POST['wtgcsv_categorylevel2_description'])){
                    $wtgcsv_project_array['categories']['level3']['description'] = $_POST['wtgcsv_categorylevel3_description'];        
                }            
            }                

            // add level 4
            if(!$wtgcsv_is_free && $_POST['wtgcsv_categorylevel4_advanced'] != 'notselected'){
                $wtgcsv_project_array['categories']['level4']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel4_advanced']);
                $wtgcsv_project_array['categories']['level4']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel4_advanced']);                     

                // save level 4 description template id if selected
                if(isset($_POST['wtgcsv_categorylevel4_description'])){
                    $wtgcsv_project_array['categories']['level4']['description'] = $_POST['wtgcsv_categorylevel4_description'];        
                }            
            }
            
            // add level 5
            if(!$wtgcsv_is_free && $_POST['wtgcsv_categorylevel5_advanced'] != 'notselected'){
                $wtgcsv_project_array['categories']['level5']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel5_advanced']);
                $wtgcsv_project_array['categories']['level5']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel5_advanced']);                     
            
                // save level 5 description template id if selected
                if(isset($_POST['wtgcsv_categorylevel5_description'])){
                    $wtgcsv_project_array['categories']['level5']['description'] = $_POST['wtgcsv_categorylevel5_description'];        
                }       
            }            
  
            // update project option         
            wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
            
            wtgcsv_notice('Your advanced category configuration has been saved and categories will be created during post creation. Posts will be assigned to their proper category.','success','Large','Standard Category Settings Saved');    

        }

        return false;
    }else{
        return true;
    }      
}

/**
* Saves default category (ID only)  
*/
function wtgcsv_form_save_default_category(){
    global $wtgcsv_currentproject_code,$wtgcsv_project_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'defaultcategory'){
        
        $wtgcsv_project_array['categories']['default'] = $_POST['wtgcsv_defaultcategory_select'];

        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        
        wtgcsv_notice('Your default category has been saved','success','Large','Default Category Saved','','echo');

        return false;
    }else{
        return true;
    }      
} 
 
/**
* Save default tags column and table 
*/
function wtgcsv_form_save_default_tags_column(){
    global $wtgcsv_currentproject_code,$wtgcsv_project_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'premadetagscolumn'){
        
        $wtgcsv_project_array['tags']['default']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_defaulttagsdata_select_columnandtable']);
        $wtgcsv_project_array['tags']['default']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_defaulttagsdata_select_columnandtable']);                       
        $wtgcsv_project_array['tags']['method'] = 'premade';
        
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
        wtgcsv_notice('Your default tags column has been saved and if the tags are formatted as required by Wordpress they will be added to your posts.','success','Large','Default Tags Column Saved');    
                 
        return false;
    }else{
        return true;
    }      
}

/**
* Process post creation for giving project 
*/
function wtgcsv_form_start_post_creation(){
    global $wtgcsv_projectslist_array,$wtgcsv_schedule_array,$wtgcsv_is_free;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'creation' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createpostsproject'){
        
        // free edition processes all records at once, $_POST['wtgcsv_postsamount'] will not be set
        $target_posts = 999999;
        if(!$wtgcsv_is_free){
            $target_posts = $_POST['wtgcsv_postsamount'];    
        }
    
        // call create posts function     
        $post_id = wtgcsv_create_posts($_POST['wtgcsv_project_code'],$target_posts,'manual');
        if($post_id){
            
            // no false returned (false indicates a failure)
            // $post_id will be the last post ID created
            wtgcsv_notice('Post creation went smoothly, no problems were detected. The last post ID created was <strong>'.$post_id.'</strong>.','success','Large','Post Creation Complete','','echo');
            ### TODO:LOWPRIORITY, add link and url too last created post to the output
                
        }else{
           
           // must be a failure, if multiple posts were requests the failure is big enough to output it to the user
           wtgcsv_notice('A problem was detected during the post creation process. The severity can only be established by checking logs and any posts created or expected to have been created.','error','Large','Problem Detected During Post Creation','','echo');
        
        }
         
        return false;
    }else{
        return true;
    }      
}

/**
* Process CSV file upload      
*/
function wtgcsv_form_upload_csv_file(){
    global $wtgcsv_projectslist_array,$wtgcsv_schedule_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'data' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'uploadcsvfile'){

        $upload = $_FILES['file'];  

        // check error
        if($upload['error'] != 0){
            wtgcsv_notice('Could not upload file, error code: ' . $upload['error'],'error','Large','Upload Failed');
            return false;// not returning false due to failure, only returning false to indicate end of processing            
        }     
        
        // ensure file destination exists
        $open_result = opendir( WTG_CSV_CONTENTFOLDER_DIR );
        if(!$open_result){
            wtgcsv_notice('File was not uploaded. Could not open the destination folder. The folder is named wpcsvimportercontent and should be in the wp-content directory. Please fix this before trying again.','error','Large','File Not Upload');
            return false;
        }

        // check if filename already exists in destination - we will let the user know they wrote over an existing file
        $target_file_path =  WTG_CSV_CONTENTFOLDER_DIR . '/' . $upload['name'];
        $target_file_path_exists = file_exists( $target_file_path );
        if($target_file_path_exists){
            // get existing files datestamp - we use it to ensure the new file is newer/changed and trigger data update
            $oldtime = filemtime( $target_file_path );
                    
            // delete the existing file
            unlink( $target_file_path );
            
            if ( file_exists( $target_file_path )){
                wtgcsv_notice('The name of your file being uploaded already exists in the target folder. Wordpress CSV Importer could not remove the existing file, but it should have. It may be because the existing file is in use, please investigate this then try again if required. If some sort of permissions problem is causing this, you may delete the existing file using FTP also.','error','Large','Existing File Not Removed');    
                // return now due to not being able to remove the existing file
                return false;
            }
            
            // file must not exist, unlink was success, let user know this was done
            wtgcsv_notice('The file name being uploaded existed already. The existing file was replaced.','info','Large','File Replaced');        
        }
        
        // now move temp file into target path
        $move_result = move_uploaded_file( $upload['tmp_name'], $target_file_path );
        
        // did the move fail
        if(!$move_result){
            wtgcsv_notice('Failed to upload file, there was a problem moving the temporary file into the target directory, please investigate this issue.','error','Large','Upload Failed');
            return false;
        }
        
        // check that file is now in place
        if(!file_exists($target_file_path)){
            wtgcsv_notice('The server confirmed that the file was uploaded and put into the target directory but it does not appear to be there. Please report this problem.','error','Large','Uploaded File Missing');
            return;
        }
        
        // upload is a success
        wtgcsv_notice('CSV file has been uploaded, you should now create a Data Import Job and select your new uploaded file.','success','Large','CSV File Uploaded');

        return false;
    }else{
        return true;
    }      
}  
  
/**
* Save drip feed limits  
*/
function wtgcsv_form_save_schedulelimits(){
    global $wtgcsv_projectslist_array,$wtgcsv_schedule_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'creation' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'schedulelimits'){

        // if any required values are not in $_POST set them to zero
        if(!isset($_POST['day'])){
            $wtgcsv_schedule_array['limits']['day'] = 0;        
        }else{
            $wtgcsv_schedule_array['limits']['day'] = $_POST['day'];            
        }
        
        if(!isset($_POST['hour'])){
            $wtgcsv_schedule_array['limits']['hour'] = 0;
        }else{
            $wtgcsv_schedule_array['limits']['hour'] = $_POST['hour'];            
        }
        
        if(!isset($_POST['session'])){
            $wtgcsv_schedule_array['limits']['session'] = 0;
        }else{
            $wtgcsv_schedule_array['limits']['session'] = $_POST['session'];            
        }
        
        wtgcsv_update_option_schedule_array($wtgcsv_schedule_array);
        
        wtgcsv_notice('Your drip-feed limits have been set and will take effect on all projects right now.','success','Large','Drip-Feeding Limits Saved');        
        
        return false;
    }else{
        return true;
    }      
}
   
/**
* Saves global allowed days and hours
*/
function wtgcsv_form_save_scheduletimes_global(){
    global $wtgcsv_projectslist_array,$wtgcsv_schedule_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'creation' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'scheduletimes'){

        // ensure $wtgcsv_schedule_array is an array, it may be boolean false if schedule has never been set
        if(isset($wtgcsv_schedule_array) && is_array($wtgcsv_schedule_array)){
            
            // if times array exists, unset the [times] array
            if(isset($wtgcsv_schedule_array['times']['days'])){
                unset($wtgcsv_schedule_array['times']['days']);    
            }
            
            // if hours array exists, unset the [hours] array
            if(isset($wtgcsv_schedule_array['times']['hours'])){
                unset($wtgcsv_schedule_array['times']['hours']);    
            }
            
        }else{
            
            // $schedule_array value is not array, this is first time it is being set
            $wtgcsv_schedule_array = array();
        }
        
        // loop through all days and set each one to true or false
        if(isset($_POST['wtgcsv_scheduleday_list'])){

            foreach($_POST['wtgcsv_scheduleday_list'] as $key => $submitted_day){
                $wtgcsv_schedule_array['times']['days'][$submitted_day] = true;        
            }
               
        } 
        
        // loop through all hours and add each one too the array, any not in array will not be permitted                              
        if(isset($_POST['wtgcsv_schedulehour_list'])){
            
            foreach($_POST['wtgcsv_schedulehour_list'] as $key => $submitted_hour){
                $wtgcsv_schedule_array['times']['hours'][$submitted_hour] = true;        
            }            
            
        }    

        wtgcsv_update_option_schedule_array($wtgcsv_schedule_array);
        
        wtgcsv_notice('You permitted days and hours for scheduled drip-feeding have been saved.','success','Large','Schedule Times Saved');

        return false;
    }else{
        return true;
    }    
}

/**
* Save drip feeding project switch, makes drip feeding for projects on or off, globaly   
*/
function wtgcsv_form_save_dripfeedprojects_switch(){
    global $wtgcsv_projectslist_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'creation' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'dripfeedprojects'){

        // if no project codes submitted then this project (all projects) is off on drip feeding
        if(!isset($_POST['wtgcsv_dripfeedprojects_list'])){

            // user has set all posts to manual only - loop through all projects and set them to off
            foreach( $wtgcsv_projectslist_array as $code => $project ){
                $wtgcsv_projectslist_array[$code]['dripfeeding'] = 'off';
            }           
 
        }else{
            
            // loop through submitted codes - those projects are to be on for drip feeding        
            foreach( $_POST['wtgcsv_dripfeedprojects_list'] as $key => $project_code ){
                $wtgcsv_projectslist_array[$project_code]['dripfeeding'] = 'on';
            }            
        }
        
        wtgcsv_update_option_postcreationproject_list($wtgcsv_projectslist_array);
        
        wtgcsv_notice('Drip feed settings have been saved.','success','Large','Drip Feed Settings Saved');
        
        return false;
    }else{
        return true;
    }    
}   
   

/**
* Save project update settings
*/
function wtgcsv_form_save_projectupdatesettings(){
    global $wtgcsv_currentproject_code,$wtgcsv_project_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'postcontentupdatingsettings'){

        $wtgcsv_project_array['updating']['content']['settings']['switch'] = $_POST['wtgcsv_updatesettings_postupdating_switch_inputname'];
        $wtgcsv_project_array['updating']['content']['settings']['public'] = $_POST['wtgcsv_updatesettings_postupdating_public_inputname'];
        $wtgcsv_project_array['updating']['content']['settings']['speed'] = $_POST['wtgcsv_updatesettings_postupdating_speed_inputname'];
        $wtgcsv_project_array['updating']['content']['settings']['old'] = $_POST['wtgcsv_updatesettings_postupdating_old_inputname'];
        $wtgcsv_project_array['updating']['content']['settings']['oldmethod'] = $_POST['wtgcsv_updatesettings_postupdating_oldmethod_inputname'];

        // update project option         
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);

        wtgcsv_notice('Your post content updating settings have been saved and will take effect straight away.','success','Large','Content Updating Settings Saved');    
                
        return false;
    }else{
        return true;
    }    
}      
    
/**
* Saves basic categories form
*/
function wtgcsv_form_save_categories_standard(){
    global $wtgcsv_currentproject_code,$wtgcsv_is_free,$wtgcsv_project_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'standardcategories'){

        // ensure the previous column has been selected for every column user submits
        $required_column_missing = false;// set to true if a required column has not been selected
        $required_column_level = false;// change too level 1,2,3 or 4 to indicate which column has not been selected but should be
        
        // check for level 1 - always required
        if( $_POST['wtgcsv_categorylevel1_select_columnandtable'] == 'notselected' ){
            wtgcsv_notice('You did not select a level one data table and column, you must always use level one if you want to create categories using this panel.','error','Large','Level One Not Selected');
            return false;//discontinue post function processing
        }
        
        // check if 3 is set - requires 2
        if( $_POST['wtgcsv_categorylevel3_select_columnandtable'] != 'notselected' && $_POST['wtgcsv_categorylevel2_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 2;
        }
        
        // check if 4 is set - requires 3
        if( !$wtgcsv_is_free && $_POST['wtgcsv_categorylevel4_select_columnandtable'] != 'notselected' && $_POST['wtgcsv_categorylevel3_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 3;
        }       
        
        // check if 5 is set - requires 4
        if( !$wtgcsv_is_free && $_POST['wtgcsv_categorylevel5_select_columnandtable'] != 'notselected' && $_POST['wtgcsv_categorylevel4_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 4;
        }        
        
        // only continue if all required columns have been selected
        if($required_column_missing){
            $column_above_missing_level = $required_column_level + 1;
            wtgcsv_notice('You did not appear to select all required columns. You selected a column for category level '.$column_above_missing_level.' but did not select one for category level '.$required_column_level.'. You must select category columns in order as displayed i.e. use 1,2 and 3 for three levels not 1,2 and 4.','error','Large','Missing Category Column Selection');
            return false;// discontinues post functions processing        
        }else{
    
            $wtgcsv_project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);   
            
            // add level 1 
            $wtgcsv_project_array['categories']['level1']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel1_select_columnandtable']);
            $wtgcsv_project_array['categories']['level1']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel1_select_columnandtable']);            

            // add level 2
            if($_POST['wtgcsv_categorylevel2_select_columnandtable'] != 'notselected'){
                $wtgcsv_project_array['categories']['level2']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel2_select_columnandtable']);
                $wtgcsv_project_array['categories']['level2']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel2_select_columnandtable']);                     
            }
            
            // add level 3
            if($_POST['wtgcsv_categorylevel3_select_columnandtable'] != 'notselected'){
                $wtgcsv_project_array['categories']['level3']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel3_select_columnandtable']);
                $wtgcsv_project_array['categories']['level3']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel3_select_columnandtable']);                     
            }                

            // add level 4
            if(!$wtgcsv_is_free && $_POST['wtgcsv_categorylevel4_select_columnandtable'] != 'notselected'){
                $wtgcsv_project_array['categories']['level4']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel4_select_columnandtable']);
                $wtgcsv_project_array['categories']['level4']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel4_select_columnandtable']);                     
            }
            
            // add level 5
            if(!$wtgcsv_is_free && $_POST['wtgcsv_categorylevel5_select_columnandtable'] != 'notselected'){
                $wtgcsv_project_array['categories']['level5']['table'] = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_categorylevel5_select_columnandtable']);
                $wtgcsv_project_array['categories']['level5']['column'] = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_categorylevel5_select_columnandtable']);                     
            }            
  
            // update project option         
            wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);
            
            wtgcsv_notice('Your basic type category configuration has been saved and categories will be created during post creation. Posts will be assigned to their proper category.','success','Large','Standard Category Settings Saved');    

        }
            
        return false;
    }else{
        return true;
    }    
}    
    
/**
* Adds basic custom fields
*/
function wtgcsv_form_add_basic_custom_field(){
    global $wtgcsv_currentproject_code,$wtgcsv_project_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createbasiccustomfieldrules'){

        // ensure meta-key was entered ### TODO:LOWPRIORITY, validate meta-key
        if(!isset($_POST['wtgcsv_key'])){
        
            wtgcsv_notice('You did not enter a meta-key for your custom field rule, please try again.','error','Large','No Meta-Key Entered');
            
        }else{ 
            
            // extract table name and column name from the string which holds both of them
            $table_name = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_customfield_select_columnandtable']);
            $column_name = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_customfield_select_columnandtable']);            

            // get last array key for current custom fields if they exist
            if(isset($wtgcsv_project_array['custom_fields']['basic'])){
                $last_array_key = wtgcsv_get_array_nextkey($wtgcsv_project_array['custom_fields']['basic']);
            }else{
                $last_array_key = 0;
            }
            
            $wtgcsv_project_array['custom_fields']['basic'][$last_array_key]['table_name'] = $table_name;
            $wtgcsv_project_array['custom_fields']['basic'][$last_array_key]['column_name'] = $column_name;
            $wtgcsv_project_array['custom_fields']['basic'][$last_array_key]['meta_key'] = $_POST['wtgcsv_key'];                        

            // update project option         
            wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);

            wtgcsv_notice('Your your basic custom field rule has been saved and another meta value will be added to all posts created in this project.','success','Large','Basic Custom Field Rule Saved');    
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
function wtgcsv_form_add_advanced_custom_field(){
    global $wtgcsv_currentproject_code,$wtgcsv_project_array,$wtgcsv_is_free;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createadvancedcustomfieldrules'){

        if($wtgcsv_is_free){
            wtgcsv_notice('Advanced custom fields are not supported in the free edition. The advanced scripts required to process them are only provided in the paid edition and are supported with it.','warning','Large','Paid Edition Only','','echo');        
        }elseif(!isset($_POST['wtgcsv_key'])){
            // ensure meta-key was entered
            wtgcsv_notice('You did not enter a meta-key for your custom field rule, please try again.','error','Large','No Meta-Key Entered');
        }else{ 
            
            // extract table name and column name from the string which holds both of them
            $table_name = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_customfield_select_columnandtable']);
            $column_name = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_customfield_select_columnandtable']);            

            // get last array key for current custom fields if they exist
            if(isset($wtgcsv_project_array['custom_fields']['advanced'])){
                $last_array_key = wtgcsv_get_array_nextkey($wtgcsv_project_array['custom_fields']['basic']);
            }else{
                $last_array_key = 0;
            }
                  
            // only save one of each value method - priority goes to templates
            if(isset($_POST['wtgcsv_customfields_selecttemplate'])){
                $wtgcsv_project_array['custom_fields']['advanced'][$last_array_key]['template_id'] = $_POST['wtgcsv_customfields_selecttemplate'];
            }else{
                $wtgcsv_project_array['custom_fields']['advanced'][$last_array_key]['column_name'] = $column_name;
                $wtgcsv_project_array['custom_fields']['advanced'][$last_array_key]['table_name'] = $table_name;    
            }

            $wtgcsv_project_array['custom_fields']['advanced'][$last_array_key]['meta_key'] = $_POST['wtgcsv_key'];                        
            $wtgcsv_project_array['custom_fields']['advanced'][$last_array_key]['update'] = $_POST['wtgcsv_updatesettings_metaupdating_switch_inputname'];
            
            // update project option         
            wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);

            wtgcsv_notice('Your your advanced post-meta/custom-field rule has been saved and another meta value will be added to all posts created in this project.','success','Large','Date Column Saved');    
        }    

        return false;
    }else{
        return true;
    }    
}    
  
/**
* Updates the main date table and column   
*/
function wtgcsv_form_update_datecolumn(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'postdatescolumn'){
        global $wtgcsv_currentproject_code,$wtgcsv_project_array;
        
        // extract table name and column name from the string which holds both of them
        $table_name = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_datecolumn_select_columnandtable']);
        $column_name = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_datecolumn_select_columnandtable']);            

        // check if the submitted column is the same as already set - first check if the values have been set before
        if(isset($wtgcsv_project_array['dates']['date_column']['table_name']) && isset($wtgcsv_project_array['dates']['date_column']['column_name'])){
            if($wtgcsv_project_array['dates']['date_column']['table_name'] == $table_name && $wtgcsv_project_array['dates']['date_column']['column_name'] == $column_name){
                wtgcsv_notice('You selected the same database table and column as already saved. No changes were required.','warning','Large','No Changes Required');    
            }    
        }
        
        // the selected table-column values have not already been set        
        $wtgcsv_project_array['dates']['date_column']['table_name'] = $table_name;            
        $wtgcsv_project_array['dates']['date_column']['column_name'] = $column_name;
        $wtgcsv_project_array['dates']['currentmethod'] = 'data';

        // update project option         
        wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);

        wtgcsv_notice('Your date column has been saved and posts publish date will be set using your data.','success','Large','Date Column Saved');    

        return false;
    }else{
        return true;
    }    
}
  
  
/**
* Inserts a new post type condition (value trigger) 
*/
function wtgcsv_form_save_posttype_condition_byvalue(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'dynamicposttype'){

        // ensure trigger value has been entered, currently a text box, eventually it will be a menu and always set so this step can be removed
        // TODO: LOWPRIORITY, when trigger value is set using menu, remove this step (add menu of selected columns unique values using ajax)
        if( !isset($_POST['wtgcsv_dynamicposttype_text_trigger']) ){
            wtgcsv_notice('You must enter a trigger value. A trigger value is the value that will cause a different content template design to be used in a post rather than the default.','error','Large','Could Not Save New Rule');    
        }else{
        
            global $wtgcsv_currentproject_code,$wtgcsv_project_array;
            
            // check if we already have template rules by value saved, count how many we have for applying array key value
            $keyvalue = 0;
            if( isset($wtgcsv_project_array['posttyperules']['byvalue']) && is_array($wtgcsv_project_array['posttyperules']['byvalue']) ){
                $keyvalue = count($wtgcsv_project_array['posttyperules']['byvalue']);    
            }
            
            // extract table name and column name from the string which holds both of them
            $table_name = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['multiselect_wtgcsv_dynamicposttype_select_columnandtable_formid']);
            $column_name = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['multiselect_wtgcsv_dynamicposttype_select_columnandtable_formid']);            

            $wtgcsv_project_array['posttyperules']['byvalue'][$keyvalue]['table_name'] = $table_name;            
            $wtgcsv_project_array['posttyperules']['byvalue'][$keyvalue]['column_name'] = $column_name;
            $wtgcsv_project_array['posttyperules']['byvalue'][$keyvalue]['trigger_value'] = $_POST['wtgcsv_dynamicposttype_text_trigger'];            
            $wtgcsv_project_array['posttyperules']['byvalue'][$keyvalue]['post_type'] = $_POST['wtgcsv_dynamicposttype_select_posttype'];
            
            wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);

            wtgcsv_notice('Your new rule for applying post type based on a specific value has been saved.','success','Large','Content Template Rule Saved');    
        }
        
        return false;
    }else{
        return true;
    }    
}  
  
/**
* Updates title template designs (post type wtgcsvtitle is updated)
*/
function wtgcsv_form_update_defaultposttype(){
    global $wtgcsv_currentproject_code;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'defaultposttype'){
   
        if( $_POST['wtgcsv_defaultpostype_original'] == $_POST['wtgcsv_radio_defaultpostype']){
            wtgcsv_notice('You appear to have selected the post type that is already set as your projects default, no changes were required.','info','Large','No Changes Required');    
        }else{
            wtgcsv_update_project_defaultposttype($wtgcsv_currentproject_code,$_POST['wtgcsv_radio_defaultpostype']);
            wtgcsv_notice('Your projects default post type is now '.$_POST['wtgcsv_radio_defaultpostype'].' and all posts created from here on will be this type.','success','Large','Default Post Type Changed');    
        }

        return false;
    }else{
        return true;
    }    
}

/**
* Updates title template designs (post type wtgcsvtitle is updated)
*/
function wtgcsv_form_update_titletemplates(){
    global $wtgcsv_currentproject_code;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'edittitletemplates'){
 
        if( !isset($_POST['wtgcsv_titletemplate_total']) || $_POST['wtgcsv_titletemplate_total'] == 0){
            wtgcsv_notice('No changes have been made as you do not appear to have any title templates. You must use the Create Title Template panel before using the update feature.','warning','Large','No Changes Made');
            return false;
        }
        
        for ($i = 1; $i <= $_POST['wtgcsv_titletemplate_total']; $i++) {
            
            // only update the posts for which values have been changed
            if( $_POST['wtgcsv_titletemplate_design_'.$i] != $_POST['wtgcsv_titletemplate_design_original_'.$i] ){

                // Update title template post
                $my_post = array();
                $my_post['ID'] = $_POST['wtgcsv_titletemplate_postid_'.$i];
                $my_post['post_content'] = $_POST['wtgcsv_titletemplate_design_'.$i];
                $my_post['post_type'] = 'wtgcsvtitle';            
                $my_post['post_category'] = array(0);
                
                // Update the post into the database
                $update_result = wp_update_post( $my_post ); 
                if( wtgcsv_is_WP_Error($update_result)){
                    wtgcsv_notice('Wordpress function wp_update_post returns a Wordpress error (WP_Error). This should not happen even if an update was not carried out due to no changes made, that would return 0. Please report this issue. The post ID (custom post type wtgcsvtitle) is '.$_POST['wtgcsv_titletemplate_postid_'.$i].' and is a Title Template.','error','Large','Error Updating Title Template Named ' . $_POST['wtgcsv_titletemplate_posttitle_'.$i]);
                }elseif( $update_result == 0){
                    wtgcsv_notice('Wordpress function wp_update_post returned 0, meaning no update was required as no changes were made. This should not happen, the plugin is meant to avoid attempting an update if the user has not edited a Title Template. Please report this issue.','error','Large','Possible Error Updating Template Title Named ' . $_POST['wtgcsv_titletemplate_posttitle_'.$i]);                    
                }else{
                    wtgcsv_notice('Wordpress function wp_update_post updated your Title Template named '.$_POST['wtgcsv_titletemplate_posttitle_'.$i].' and all projects using the template will continue to use the updated version.','success','Large','Title Template Updated');
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
function wtgcsv_form_insert_title_template(){
    global $wtgcsv_currentproject_code;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createtitletemplates'){
 
        // validate template name
        if(!isset($_POST['wtgcsv_titletemplate_name']) || $_POST['wtgcsv_titletemplate_name'] == null || $_POST['wtgcsv_titletemplate_name'] == ' '){
            wtgcsv_notice('Please enter a name for your title template so that you can identify it properly','error','Large','Content Template Name Required');        
            return false;// tells this file that $_POST processing is complete
        }

        // validate template design
        if(!isset($_POST['wtgcsv_titletemplate_title']) || $_POST['wtgcsv_titletemplate_title'] == null || $_POST['wtgcsv_titletemplate_title'] == ' '){
            wtgcsv_notice('Please enter a title template design, you must use column replacement tokens for it to work','error','Large','Content Template Name Required');        
            return false;// tells this file that $_POST processing is complete
        }
         
        // save title template
        $save_result = wtgcsv_insert_titletemplate($_POST['wtgcsv_titletemplate_name'],$_POST['wtgcsv_titletemplate_title']);
        if(wtgcsv_is_WP_Error($save_result)){
            wtgcsv_notice('No changes were saved, you did not appear to make new changes before your submission','warning','Large','No Changes Made');    
        }else{
                     
            // if current project does not yet have a default content template
            $setasdefault = '';
            $template_id = wtgcsv_get_default_titletemplate_id($wtgcsv_currentproject_code);
            if(!$template_id){
                // current project has no default content template so we will save the new one as it
                wtgcsv_update_default_titletemplate($wtgcsv_currentproject_code,$save_result);
                // link the template to the project by adding wtgcsv_project_id custom meta field 
                add_post_meta($save_result, 'wtgcsv_project_id', $wtgcsv_currentproject_code, false);
                // extend output message to confirm default also set                    
                $setasdefault = ' and it has been set as your current projects default title template.';
            }
                
            wtgcsv_notice('Your new title template has been saved'.$setasdefault.'.','success','Large','New Title Template Saved');
        }
              
        return false;
    }else{
        return true;
    }    
} 

/**
* Updates current projects default template
*/
function wtgcsv_form_change_default_contenttemplate(){
    global $wtgcsv_currentproject_code;
    if(isset($_POST['wtgcsv_change_default_contenttemplate']) && isset($_POST['wtgcsv_templatename_and_id'])){
  
        // extract template id from string
        $template_id = wtgcsv_extract_value_from_string_between_two_values('(',')',$_POST['wtgcsv_templatename_and_id']);        

        if(!is_numeric($template_id)){
            wtgcsv_notice('The template ID could not be extracted from the submission, please try again then report this issue.','error','Large','Error Saving Default Content Template');
        }else{
            wtgcsv_update_default_contenttemplate($wtgcsv_currentproject_code,$template_id);
            wtgcsv_notice('The template you selected has been saved as your current projects default template design.','success','Large','Default Content Template Saved');
        }
        
        return false;
    }else{
        return true;
    }    
}

function wtgcsv_form_change_default_titletemplate(){
    global $wtgcsv_currentproject_code;
    if(isset($_POST['wtgcsv_change_default_titletemplate']) && isset($_POST['wtgcsv_templatename_and_id'])){
  
        // extract template id from string
        $template_id = wtgcsv_extract_value_from_string_between_two_values('(',')',$_POST['wtgcsv_templatename_and_id']);        

        if(!is_numeric($template_id)){
            wtgcsv_notice('The title template ID (also post id) could not be extracted from the submission, please try again then report this issue.','error','Large','Error Saving Default Title Template');
        }else{
            wtgcsv_update_default_titletemplate($wtgcsv_currentproject_code,$template_id);
            wtgcsv_notice('The title template you selected has been saved as your current projects default template design.','success','Large','Default Title Template Saved');
        }
        
        return false;
    }else{
        return true;
    }    
}    
 
/**
* Save a new dynamic content template rule based on column value
*/
function wtgcsv_form_save_contenttemplatedesign_condition_byvalue(){
    global $wtgcsv_currentproject_code,$wtgcsv_project_array;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'dynamiccontentdesignrulesbyvalue'){

        // ensure trigger value has been entered, currently a text box, eventually it will be a menu and always set so this step can be removed
        // TODO: LOWPRIORITY, when trigger value is set using menu, remove this step
        if( !isset($_POST['wtgcsv_dynamiccontentdesignrules_text_triggervalue']) ){
            wtgcsv_notice('You must enter a trigger value. A trigger value is the value that will cause a different content template design to be used in a post rather than the default.','error','Large','Could Not Save New Rule');
        }else{
        
            // check if we already have template rules by value saved, count how many we have for applying array key value
            $keyvalue = 0;
            if( isset($wtgcsv_project_array['contenttemplaterules']['byvalue']) && is_array($wtgcsv_project_array['contenttemplaterules']['byvalue']) ){
                $keyvalue = count($wtgcsv_project_array['contenttemplaterules']['byvalue']);    
            }
            
            // extract table name and column name from the string which holds both of them
            $table_name = wtgcsv_explode_tablecolumn_returnnode(',',0,$_POST['wtgcsv_dynamiccontentdesignrules_select_columnandtable']);
            $column_name = wtgcsv_explode_tablecolumn_returnnode(',',1,$_POST['wtgcsv_dynamiccontentdesignrules_select_columnandtable']);            

            $wtgcsv_project_array['contenttemplaterules']['byvalue'][$keyvalue]['table_name'] = $table_name;            
            $wtgcsv_project_array['contenttemplaterules']['byvalue'][$keyvalue]['column_name'] = $column_name;
            $wtgcsv_project_array['contenttemplaterules']['byvalue'][$keyvalue]['trigger_value'] = $_POST['wtgcsv_dynamiccontentdesignrules_text_triggervalue'];            
            $wtgcsv_project_array['contenttemplaterules']['byvalue'][$keyvalue]['template_id'] = $_POST['wtgcsv_dynamiccontentdesignrules_select_templateid'];
            
            wtgcsv_update_option_postcreationproject($wtgcsv_currentproject_code,$wtgcsv_project_array);

            wtgcsv_notice('Your new rule for applying content has been saved and all records with the giving trigger value will use the selected template design.','success','Large','Content Template Rule Saved');    
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
function wtgcsv_form_save_contenttemplate(){  
    global $wtgcsv_currentproject_code;// TODO ADD THIS TOO POST IN CUSTOM FIELD
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'templateeditor'){
        
        // if we change this variable it causes new wtgcsvtemplate post to be created
        $create_new_wtgcsvtemplate_post = false;
        
        // has a template design id been submitted, if so then the user is editing an existing design after opening it                                                                                                                                                                                                                                                 
        if(isset($_POST['wtgcsv_templateid']) && is_numeric($_POST['wtgcsv_templateid'])){
            
            // the user may want a design to be created from the previous, this is done by changing the template design name
            if($_POST["wtgcsv_templatename"] == $_POST["wtgcsv_templatename_previous"]){

                // update existing design using design ID (post_id for wtgcsvcontent custom post type)
                $my_post = array();
                $my_post['ID'] = $_POST['wtgcsv_templateid'];
                $my_post['post_type'] = 'wtgcsvcontent';
                $my_post['post_title'] = $_POST['wtgcsv_templatename'];            
                $my_post['post_content'] = $_POST['wtgcsv_wysiwyg_editor'];
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
            
            $wpinsertpost_result = wtgcsv_insert_post_contenttemplate();// returns post ID
            
            if(wtgcsv_is_WP_Error($wpinsertpost_result)){
                wtgcsv_notice('Could not create new content template design. It requires the insertion of a new post record but Wordpress returned an error. Please try again then report further problems.','error','Large','Could Not Save Template');
            }elseif(is_numeric($wpinsertpost_result)){
                
                // add design type to meta
                if(isset($_POST["wtgcsv_designtype"])){
                    if(is_array($_POST["wtgcsv_designtype"])){
                        $first = true;
                        foreach($_POST["wtgcsv_designtype"] as $key => $type){
                            add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', $type, false);   
                        }
    
                    }else{    
                        add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', $_POST["wtgcsv_designtype"], false);
                    }
                }else{
                    
                    add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', 'postcontent',false);                    
                    add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', 'customfieldvalue', false);                    
                    add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', 'categorydescription', false);                    
                    add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', 'postexcerpt', false);                    
                    add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', 'keywordstring', false);                    
                    add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', 'dynamicwidgetcontent', false);                    
                    add_post_meta($wpinsertpost_result, '_wtgcsv_templatetypes', 'seovalue', false);
                }
                
                /* OLD METHOD
                $design_types = '';
                if(isset($_POST["wtgcsv_designtype"])){
                    if(is_array($_POST["wtgcsv_designtype"])){
                        $first = true;
                        foreach($_POST["wtgcsv_designtype"] as $key => $type){
                            if($first == false){
                                $design_types .= ',';    
                            }
                            $design_types .= $type;
                            $first = false;    
                        }
                    }else{
                        $design_types = $_POST["wtgcsv_designtype"];    
                    }
                }else{
                    // by default we will apply all types
                    $design_types = 'postcontent,customfieldvalue,categorydescription,postexcerpt,keywordstring,dynamicwidgetcontent,seovalue';
                }

                $result = add_metadata('post', $wpinsertpost_result, '_wtgcsv_templatetypes', $design_types);
                */
                
                
                
                // if current project does not yet have a default content template
                $setasdefault = '';
                $template_id = wtgcsv_get_default_contenttemplate_id($wtgcsv_currentproject_code);
                if(!$template_id){
                     
                    // current project has no default content template so we will save the new one as it
                    wtgcsv_update_default_contenttemplate($wtgcsv_currentproject_code,$wpinsertpost_result);
                    
                    // link the template to the project by adding wtgcsv_project_id custom meta field 
                    add_post_meta($wpinsertpost_result, 'wtgcsv_project_id', $wtgcsv_currentproject_code, false); 
                    
                    // extend output message to confirm default also set                    
                    $setasdefault = ' and it has been set as your current projects default content template.';
                }
                
                wtgcsv_notice('Your new content template has been saved'.$setasdefault.'. You can select it in your projects settings and edit it using the same editor as you created it with.','success','Large','New Template Saved');
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
function wtgcsv_form_change_current_project(){
    global $wtgcsv_currentproject_code;
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'selectcurrentproject'){
        if( $_POST['wtgcsv_radio_projectcode'] == $wtgcsv_currentproject_code){
            wtgcsv_notice('You submitted the same project as the one already set as your Current Project. No changes were made.','info','Large','No Changes Made');    
        }else{
            wtgcsv_update_currentproject($_POST['wtgcsv_radio_projectcode']);
            wtgcsv_notice('Your current project has been changed and you will not be working on project '.$_POST['wtgcsv_radio_projectcode'].'.','success','Large','Project Changed');            
        }
        return false;
    }else{
        return true;
    }    
}    

/**
* Deletes one or more post creation projects from $_POST submission
*/
function wtgcsv_form_delete_post_creation_projects(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'deleteprojects'){
        global $wtgcsv_is_free,$wtgcsv_currentproject_code;
        
        if(!$wtgcsv_is_free && !isset($_POST['wtgcsv_projectcodes_array'])){
            wtgcsv_notice('You did not appear to select any projects, no projects have been deleted.','info','Large','No Projects Deleted');    
        }else{
            
            if($wtgcsv_is_free){
                
                //free edition has one project, so we can use $wtgcsv_currentproject_code
                // Do not try to get around this limitation, required functions for later processes are not included with the free download
                wtgcsv_delete_postcreationproject($wtgcsv_currentproject_code);
                wtgcsv_delete_option_currentprojectcode();
                wtgcsv_notice('Your project with code '.$wtgcsv_currentproject_code.' has been deleted.','success','Large','Project ('.$wtgcsv_currentproject_code.') Deleted');                

            }else{
                
                foreach($_POST['wtgcsv_projectcodes_array'] as $key => $project_code){
                    
                    // if  $wtgcsv_currentprojectcode equals the project being deleted, then delete current project option
                    if($wtgcsv_currentproject_code == $project_code){
                        wtgcsv_delete_option_currentprojectcode();   
                    }
                    
                    wtgcsv_delete_postcreationproject($project_code);
                    wtgcsv_notice('Your project with code '.$project_code.' has been deleted.','success','Large','Project '.$project_code.' Deleted');    
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
function wtgcsv_form_create_post_creation_project(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'projects' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createpostcreationproject'){
        
        global $wtgcsv_currentproject_code,$wtgcsv_is_free;
        
        if(!isset($_POST['wtgcsv_databasetables_array'])){
            
            wtgcsv_notice('You did not appear to select any database tables for taking data from and putting into posts. Project was not created.','info','Large','Database Table Selection Required','','echo');    
            return false;
            
        }else{
            
            // free edition does not allow mapping method selection on form
            if(isset($_POST['wtgcsv_projecttables_mappingmethod_inputname']) && !$wtgcsv_is_free){
                $mapping_method = $_POST['wtgcsv_projecttables_mappingmethod_inputname'];    
            }else{
                $mapping_method = 'defaultorder';
            }
            
            // free edition will submit selected database table as string, not array, make array for rest of plugins use
            if(!is_array($_POST['wtgcsv_databasetables_array'])){
                $tables_array = array($_POST['wtgcsv_databasetables_array']);// we add the single table name to an array in free edition                                
            }else{
                $tables_array = $_POST['wtgcsv_databasetables_array'];// paid edition value will already be an array
            }

            // create project function will return project code on success
            $createproject_result_code = wtgcsv_create_post_creation_project($_POST['wtgcsv_projectname_name'],$tables_array,$mapping_method);
            if($createproject_result_code){
                
                // now set the new project as the Current Project                
                $wtgcsv_currentproject_code = $createproject_result_code;
                wtgcsv_update_currentproject($createproject_result_code);
                
                // do notification
                wtgcsv_notice('Your new Post Creation Project has been made. Please click on the Content Designs tab and create your main content layout for this project or select an existing one.','success','Large','Post Creation Project Created');
            
                // display next step message
                if(!$wtgcsv_is_free){
                    $table_count = count($_POST['wtgcsv_databasetables_array']);
                    if($table_count != 1){
                        wtgcsv_notice('You must now complete the Multiple Tables Project panel on the Projects screen.','step','Large','Next Step','','echo');    
                    }
                }
            
            }else{
                
                if($wtgcsv_is_free){
                
                    wtgcsv_notice('You appear to have already created your project. The free edition allows one project at a time, please complete your post creation then delete the project. You may then create another project with a new database table that holds different data.','warning','Large','Post Creation Project Not Created','','echo');    
               
                }else{
                    
                    wtgcsv_notice('A problem was detected when making the new Post Creation Project. It is recommended that you attempt to make the project again and report this problem if it continues to happen.','error','Large','Post Creation Project Not Created');    
                
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
function wtgcsv_form_delete_dataimportjobs(){
    if(isset( $_POST[WTG_CSV_ABB.'hidden_pageid'] ) && $_POST[WTG_CSV_ABB.'hidden_pageid'] == 'data' && isset($_POST[WTG_CSV_ABB.'hidden_panel_name']) && $_POST[WTG_CSV_ABB.'hidden_panel_name'] == 'deletedataimportjob'){
        if(!isset($_POST['wtgcsv_jobcode_array'])){
            wtgcsv_notice('You did not appear to select any data import jobs for deletion, no changes have been made.','info','Small');    
        }else{
            global $wtgcsv_currentjob_code;
            
            // loop through submitted job codes 
            foreach( $_POST['wtgcsv_jobcode_array'] as $jobcode ){
                
                // if job being deleted equals the current job, delete the option record for current job
                if($jobcode == $wtgcsv_currentjob_code){
                    wtgcsv_delete_option_currentjobcode();
                }
                
                $deletejob_result = wtgcsv_delete_dataimportjob_postrequest($jobcode,true);
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
function wtgcsv_form_createdataimportjob(){
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'data' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'createdataimportjobcsvfiles'){
        global $wtgcsv_is_free;
        
        // set variable for building output html
        $extendednotice = '';
        
        // set function boolean outcome (used at end to display notification for success or fail)
        $functionoutcome = false;
        
        $importjobname_validate_result = wtgcsv_validate_dataimportjob_name($_POST['wtgcsv_jobname_name']);
        
        if($importjobname_validate_result){
            
            if(isset($_POST['wtgcsv_newjob_included_csvfiles'])){
                
                // generate job code (used to name database table and option record for job history) 
                $code = wtgcsv_create_code(6); 
        
                // create an array for the job, to be stored in an option record of its own
                $jobarray = wtgcsv_create_jobarray($_POST['wtgcsv_jobname_name'],$code);
                $jobarray['jobname'] = $_POST['wtgcsv_jobname_name'];

                // determine if this is a multi file job or single
                if($wtgcsv_is_free){
                    $job_file_group = 'single';// free edition does not allow multiple files    
                }else{
                    // count the number of files submitted
                    $numbers_of_files = count($_POST['wtgcsv_newjob_included_csvfiles']);
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
                foreach($_POST['wtgcsv_newjob_included_csvfiles'] as $key => $csvfile_name){
                    
                    // add the file with the $fileid as key, $fileid is simple integer number beginning from 1
                    $jobarray['files'][$fileid] = $csvfile_name;
                                        
                    // we need first part of filename for appending in $_POST submissions
                    $fileChunks = explode(".", $csvfile_name);

                    // establish separator
                    if(isset($_POST['wtgcsv_newjob_separators' . $fileChunks[0]])){
                        $jobarray[$csvfile_name]['separator'] = $_POST['wtgcsv_newjob_separators' . $fileChunks[0]];        
                    }else{
                        $jobarray[$csvfile_name]['separator'] = wtgcsv_get_file_separator($csvfile_name,$fileid);
                    }
                    
                    // establish quote
                    if(isset($_POST['wtgcsv_newjob_quote' . $fileChunks[0]])){
                        
                        if($_POST['wtgcsv_newjob_quote' . $fileChunks[0]] == 'doublequote'){
                            $jobarray[$csvfile_name]['quote'] = '"';    
                        }elseif($_POST['wtgcsv_newjob_quote' . $fileChunks[0]] == 'singlequote'){
                            $jobarray[$csvfile_name]['quote'] = "'";
                        }else{
                            $jobarray[$csvfile_name]['quote'] = '"';
                        }
                                
                    }else{
                        $jobarray[$csvfile_name]['quote'] = wtgcsv_get_file_quote($csvfile_name,$fileid,'PEAR');
                    }                     
   
                    // establish number of fields/columns - we need seperator at least to do this if user never submitted integer value
                    if(isset($_POST['wtgcsv_csvfile_fieldcount_'.$fileChunks[0]]) && is_numeric($_POST['wtgcsv_csvfile_fieldcount_'.$fileChunks[0]])){
                        $jobarray[$csvfile_name]['fields'] = $_POST['wtgcsv_csvfile_fieldcount_'.$fileChunks[0]];    
                    }else{
                        $jobarray[$csvfile_name]['fields'] = wtgcsv_establish_csvfile_fieldnumber($csvfile_name,$separator);
                    }   
                    
                    // add job stats for the file, required for multiple file jobs
                    $jobarray['stats'][$csvfile_name]['progress'] = 0;
                    $jobarray['stats'][$csvfile_name]['inserted'] = 0;    
                    $jobarray['stats'][$csvfile_name]['updated'] = 0;
                    $jobarray['stats'][$csvfile_name]['deleted'] = 0;
                    $jobarray['stats'][$csvfile_name]['void'] = 0;    
                    $jobarray['stats'][$csvfile_name]['dropped'] = 0;    
                    $jobarray['stats'][$csvfile_name]['duplicates'] = 0;                    
                    $jobarray['stats'][$csvfile_name]['rows'] = wtgcsv_count_csvfilerows($csvfile_name);                    

                    // also add an array of each files headers with the file as key
                    $jobarray[$csvfile_name]['headers'] = wtgcsv_get_file_headers_formatted($csvfile_name,$fileid,$jobarray[$csvfile_name]['separator'],$jobarray[$csvfile_name]['quote'],$jobarray[$csvfile_name]['fields']);
                     
                    // count total rows
                    $jobarray['totalrows'] = $jobarray['totalrows'] + $jobarray['stats'][$csvfile_name]['rows'];
                    ++$fileid;                        
                }

                $result = wtgcsv_save_dataimportjob($jobarray,$code);
                if($result){
                    
                    // set global $wtgcsv_currentjob_code as new code and set global $wtgcsv_job_array
                    global $wtgcsv_currentjob_code,$wtgcsv_job_array;
                    $wtgcsv_currentjob_code = $code;
                    $wtgcsv_job_array = $jobarray;
                    
                    // create a database table - multiple file jobs are put into a single table, column names are giving appended values to prevent conflict with shared names    
                    $createtable_result = wtgcsv_create_dataimportjob_table($code,$job_file_group);

                    if(!$createtable_result){
                        $functionoutcome = false;
                        $extendednotice .= wtgcsv_notice('The data import jobs database table could not be created, it is required for storing your data and was to be named wtgcsv_'.$code.'. Please try again then seek support.','warning','Extra','','','return');        
                    }else{
                        
                        // update wtgcsv_current_job option record
                        wtgcsv_update_option_currentjob_code($code);
                        
                        // update the Data Import Jobs Array (the list of all job ID)
                        global $wtgcsv_dataimportjobs_array;
                        
                        // if data import jobs array is not already set then this must be the first job - set it as an array
                        if(!$wtgcsv_dataimportjobs_array){
                            $wtgcsv_dataimportjobs_array = array();    
                        }

                        // add job to the array that only holds a list of jobs not job statistics
                        wtgcsv_add_dataimportjob_to_list($code,$_POST['wtgcsv_jobname_name']);
                        
                        $functionoutcome = true;
                        $extendednotice .= wtgcsv_notice('A new database table named wtgcsv_' . $code.' was created for storing your data for the new Data Import Job.','info','Extra','','','return');    
                    
                    }
                }else{
                    $functionoutcome = false;
                    $extendednotice .= wtgcsv_notice('Could not create data import task, reason unknown. Please try again then report this problem if it continues.','warning','Extra','','','return');                    
                }
            }else{
                $functionoutcome = false;
                $extendednotice .= wtgcsv_notice('You did not appear to select any CSV files for your new Data Import Job. Please try again.','warning','Extra','','','return');
            }
        }else{
            $functionoutcome = false;
            $extendednotice .= wtgcsv_notice('Your Data Import Job name is invalid, please do not include special characters or use more than 30 characters.','info','Extra','','','return');
        }
        
        // decide the initial notice
        if($functionoutcome){
            $initialnotice = 'Your new data import job named '.$_POST['wtgcsv_jobname_name'].' has been created and no problems were detected. You can now go to the Import tab and begin importing rows from your CSV file/s into your database as records.';    
        }else{
            $initialnotice = 'Sorry your new data import job named '.$_POST['wtgcsv_jobname_name'].' was NOT created, a problem was detected. More details should be provided below this message.';
        }
        
        // undo changes that were made too the blog despite an overall fail
        ### TODO:HIGHPRIORITY, remove database table and job entry too the job array if an overall failure is reached
        
        // display result
        wtgcsv_notice('<h4>Create New Data Import Job Results</h4>' . $initialnotice . $extendednotice);

        if($functionoutcome){
            if($wtgcsv_is_free){
                wtgcsv_notice('You should now click on the Import Jobs screen and begin importing your data manually.','step','Large','Next Step',false,'echo');    
            }else{
                wtgcsv_notice('You should now click on the Import Jobs screen and begin importing your data manually. If
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
function wtgcsv_form_test_csvfile(){
    if(isset( $_POST[WTG_CSV_ABB.'hidden_pageid'] ) && $_POST[WTG_CSV_ABB.'hidden_pageid'] == 'data' && isset($_POST[WTG_CSV_ABB.'hidden_panel_name']) && $_POST[WTG_CSV_ABB.'hidden_panel_name'] == 'testcsvfiles'){

        // TEST 1: fgets separator - standard fgets method and counting each possible separator
        $sep_test_one = wtgcsv_establish_csvfile_separator_fgetmethod($_POST['multiselect_wtgcsv_multiselecttestcsvfiles'],true );
        
        // TEST 2: PEAR CSV separator - PEAR method which returns its decision     
        $sep_test_two = wtgcsv_establish_csvfile_separator_PEARCSVmethod($_POST['multiselect_wtgcsv_multiselecttestcsvfiles'],true );

        // TEST 3: PEAR CSV quote       
        $quote_test_two = wtgcsv_establish_csvfile_quote_PEARCSVmethod( $_POST['multiselect_wtgcsv_multiselecttestcsvfiles'],true);
       
        // if user submitted separator, use that from here on
        if(isset($_POST['wtgcsv_testcsvfile_separator_radiogroup'])){
            $sep_test_two = $_POST['wtgcsv_testcsvfile_separator_radiogroup'];    
        }
       
        // TEST 4: using established separator and quote, count column titles using fget method as priority
        wtgcsv_test_csvfile_countfields_fgetpriority( $_POST['multiselect_wtgcsv_multiselecttestcsvfiles'], $sep_test_two, $quote_test_two );

        // TEST 5: using established separator and quote, count column titles using PEAR CSV method as priority
        wtgcsv_test_csvfile_countfields_pearcsvpriority( $_POST['multiselect_wtgcsv_multiselecttestcsvfiles'], $sep_test_two, $quote_test_two );

        // TEST 6: compare Separators from all methods and display error notice if no match
        $separators_match = true;
        if($sep_test_one != $sep_test_two){
            $separators_match = false;        
        }
        
        if(isset($_POST['wtgcsv_testcsvfile_separator_radiogroup']) && $_POST['wtgcsv_testcsvfile_separator_radiogroup'] != $sep_test_one){
            $separators_match = false;    
        }

        if(isset($_POST['wtgcsv_testcsvfile_separator_radiogroup']) && $_POST['wtgcsv_testcsvfile_separator_radiogroup'] != $sep_test_two){
            $separators_match = false;    
        }
                    
        if(!$separators_match){            
            wtgcsv_notice('Separator values from all methods used to establish the correct character, including the 
            separator you submitted (if any), do not match each other. This is very common when working with CSV files.
             You may always need to use manual separator options. This message is to make you aware that
             not all methods of reading CSV files will work with your file.','warning','Large','Test 6: Compare Separator Sources','','echo');    
        }else{
            wtgcsv_notice('Separator values from all methods used to establish the correct character, including the separator you submitted (if any), do not match each other. This is very common when working with CSV files. You may always need to use manual separator options.','warning','Large','Test 6: Compare Separator Sources','','echo');            
        }
        
        wtgcsv_notice('
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
function wtgcsv_form_deletecontentfolder(){
    if(isset($_POST[WTG_CSV_ABB.'contentfolder_delete'])){ 
        // this function does the output when set to true for 2nd parameter
        wtgcsv_delete_contentfolder(WTG_CSV_CONTENTFOLDER_DIR,true);    
        return false; 
    }else{
        return true;
    }    
} 

/**
* Creates the csv file folder in the wp-content path
*/
function wtgcsv_form_createcontentfolder(){
    if(isset($_POST[WTG_CSV_ABB.'contentfolder_create'])){ 
        // this function does the output when set to true for 2nd parameter
        wtgcsv_install_contentfolder(WTG_CSV_CONTENTFOLDER_DIR,true);    
        return false;
    }else{
        return true;
    }    
} 

/**
* Install Plugin - initial post submission validation  
*/
function wtgcsv_form_installplugin(){   
    if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'install' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'premiumuseractivation'){

        if(!current_user_can('activate_plugins')){
            wtgcsv_notice(__('You do not have the required permissions to activate '.WTG_CSV_PLUGINTITLE.'. The Wordpress role required is activate_plugins, usually granted to Administrators.'), 'warning', 'Large', false);
        }else{                  
            wtgcsv_process_full_install();                
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
function wtgcsv_form_reinstallplugin(){ 
    if(isset($_POST[WTG_CSV_ABB.'hidden_pageid']) && $_POST[WTG_CSV_ABB.'hidden_pageid'] == 'install' && isset($_POST[WTG_CSV_ABB.'hidden_panel_name']) && $_POST[WTG_CSV_ABB.'hidden_panel_name'] == 'reinstall'){
        if(current_user_can('activate_plugins')){
            wtgcsv_process_full_reinstall();    
        }else{
            wtgcsv_notice(__('You do not have the required permissions to perform a re-install of '.WTG_CSV_PLUGINTITLE.'. The Wordpress role required is activate_plugins, usually granted to Administrators.'), 'warning', 'Large', false);
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
function wtgcsv_form_uninstallplugin(){
    if(isset($_POST[WTG_CSV_ABB.'hidden_pageid']) && $_POST[WTG_CSV_ABB.'hidden_pageid'] == 'install' && isset($_POST[WTG_CSV_ABB.'hidden_panel_name']) && $_POST[WTG_CSV_ABB.'hidden_panel_name'] == 'uninstall'){  
        if(current_user_can('delete_plugins')){
           wtgcsv_uninstall();
        }else{
            wtgcsv_notice(__('You do not have the required permissions to un-install '.WTG_CSV_PLUGINTITLE.'. The Wordpress role required is delete_plugins, usually granted to Administrators.'), 'warning', 'Large', false);
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
function wtgcsv_form_logfileinstallation(){
    if(isset($_POST[WTG_CSV_ABB.'createlogfile'])){

        $logfileexists_result = wtgcsv_logfile_exists($_POST[WTG_CSV_ABB.'logtype']);
        if($logfileexists_result){?>      
            <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Exists">
                <?php  wtgcsv_notice(__('The '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' log file already exists, no changes have been made too your blog.'),'info','Extra',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File Exists');?>
            </div><?php                 
            wtgcsv_jquerydialogue_results();
        }else{
             $createlogfile_result = wtgcsv_create_logfile($_POST[WTG_CSV_ABB.'logtype']);
             if($createlogfile_result){?>
                <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Created">
                    <?php  wtgcsv_notice(__('The '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' log file was created, please now ensure logging for this file is active.'),'success','Extra',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File Created');?>
                </div><?php
                wtgcsv_jquerydialogue_results(); 
    
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

                wtgcsv_log($logatt);
                              
             }else{?>
                <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Creation Failed">
                    <?php  wtgcsv_notice(__('The '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' log could not be created, please check the plugins FAQ for help on what to do next.'),'error','Extra',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File Creation Failed');?>
                </div><?php
                wtgcsv_jquerydialogue_results();               
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
function wtgcsv_form_deletelogfile(){
    if(isset($_POST[WTG_CSV_ABB.'deletelogfile'])){ 
        $logfileexists_result = wtgcsv_logfile_exists($_POST[WTG_CSV_ABB.'logtype']);
        if(!$logfileexists_result){?>      
            <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Not Found">
                <?php  wtgcsv_notice(__('The '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' log file could not be located, no changes have been made.'),'info','Extra',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File Not Found');?>
            </div><?php
            wtgcsv_jquerydialogue_results();
        }else{
             $deletelogfile_result = wtgcsv_delete_logfile($_POST[WTG_CSV_ABB.'logtype']);
             if($deletelogfile_result){?>
                <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Removed">
                    <?php  wtgcsv_notice(__('The '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' log file was deleted, please now ensure logging for this file is disabled or it may be re-created.'),'success','Extra',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File Removed');?>
                </div><?php
                wtgcsv_jquerydialogue_results();               
             }else{?>
                <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Not Removed">
                    <?php  wtgcsv_notice(__('The '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' log could not be deleted, reason unknown. Please try again, ensure the log exists then seek support.'),'error','Extra',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File Not Removed');?>
                </div><?php
                wtgcsv_jquerydialogue_results();               
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
function wtgcsv_form_disablelogfile(){
    if(isset($_POST[WTG_CSV_ABB.'disablelogfile'])){
        $logfile_result = wtgcsv_disable_logfile($_POST[WTG_CSV_ABB.'logtype']);
        if($logfile_result){?>      
            <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Disabled">
                <?php  wtgcsv_notice(__('The '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' log file has been Disabled.'),'success','Extra',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File Disabled');?>
            </div><?php
            wtgcsv_jquerydialogue_results();
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
function wtgcsv_form_activatelogfile(){
    if(isset($_POST[WTG_CSV_ABB.'activatelogfile'])){
        $logfile_result = wtgcsv_activate_logfile($_POST[WTG_CSV_ABB.'logtype']);
        if($logfile_result){?>      
            <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Activated">
                <?php  wtgcsv_notice(__('The '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' log file has been activated.'),'success','Extra',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File Activated');?>
            </div><?php
            wtgcsv_jquerydialogue_results();
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
function wtgcsv_form_viewlogfile(){
    if(isset($_POST[WTG_CSV_ABB.'viewlogfile'])){?> 
        <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="<?php ucfirst($_POST[WTG_CSV_ABB.'logtype']);?> Log File Activated">
            <?php 
            wtgcsv_notice(__('the '.$_POST[WTG_CSV_ABB.'logtype'].' log file has been retrieved and displayed below.'),'success','Small',ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log: ');
            
            // create array of key words to filter entries from the general log
            $install_filter_array = array();
            $install_filter_array['logfile'] = $_POST[WTG_CSV_ABB.'logtype'];// use logfile to open specific log file
            $install_filter_array['action'] = 'install';// use this action for uninstall,reinstall etc
            $install_filter_array['priority'] = 'all';// all (default),low,high,critical
            // add panel details too array, used for forms in notices       
            $install_filter_array['panel_title'] = 'View '.ucfirst($_POST[WTG_CSV_ABB.'logtype']).' Log File';            
            $install_filter_array['panel_name'] = WTG_CSV_ABB.'postsubmit_viewlogfile';
            $install_filter_array['panel_number'] = '1';  
                                                 
            wtgcsv_viewhistory($install_filter_array); ?>
        </div><?php
        wtgcsv_jquerydialogue_results();  
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    } 
}

/**
* Contact Form Submission Post Validation 
*/
function wtgcsv_form_contactformsubmission(){     
    if(isset( $_POST[WTG_CSV_ABB.'hidden_pageid'] ) && $_POST[WTG_CSV_ABB.'hidden_pageid'] == 'more' && isset($_POST[WTG_CSV_ABB.'hidden_panel_name']) && $_POST[WTG_CSV_ABB.'hidden_panel_name'] == 'contact'){
        
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
        if(isset($_POST['multiselect_'.WTG_CSV_ABB.'contactmethods'])){
            // loop through contact methods and create comma seperated list    
        }
          
        if(isset($_POST['multiselect_'.WTG_CSV_ABB.'contactreason'])){
            // loop through contact reasons and create comma seperated list    
        }
         
        ### @todo HIGH PRIORITY  check the contact description post value here, it has wtg does it match with form ???   
        $stringreplace_result = str_replace('stringreplace_description',$_POST['wtg_contactdescription'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linkone',$_POST[WTG_CSV_ABB.'linkone'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linktwo',$_POST[WTG_CSV_ABB.'linktwo'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linkthree',$_POST[WTG_CSV_ABB.'linkthree'],$email_template);          
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
        foreach($_POST['multiselect_wtgcsv_contactmethods'] as $amethod){
            if(!is_string($amethod) || !in_array($methods_array)){
                $failed = true;
                $failurereason = 'the giving contact method '.$methods_array.' is invalid.';   
            }  
        }
        
        foreach($_POST['multiselect_wtgcsv_contactreason'] as $areason){
            if(!is_string($areason) || !in_array($reason_array)){
                $failed = true;
                $failurereason = 'the giving contact reason '.$areason.' is invalid.';   
            }  
        }

        foreach($_POST['multiselect_wtgcsv_contactpriority'] as $apriority){
            if(!is_string($apriority) || !in_array($priority_array)){
                $failed = true;
                $failurereason = 'a submitted priority value,'.$apriority.', is invalid.';   
            }  
        }
        
        // output result if $failed so far
        if($failed == true){
            wtgcsv_notice('Contact attempt failed. This has happened because '.$failurereason);
        }
        
        ######################################## Contact method for gold users only
        ####      CONTACT WEB SERVICE      ##### Stores sensitive information in WebTechGlobal database
        ######################################## Ticket, Forum and sending data requires this else it is all sent by email
        
        /*  @todo Contact Web Services to be complete on server
        if($failed == true){
            
            // is the api required, did user selected contact methods that require it?
            // compare each contact method that requires the api against those submitted in POST
            foreach($_POST['multiselect_wtgcsv_contactmethods'] as $amethod){
                if(in_array($apimethods_array,$_POST['multiselect_wtgcsv_contactmethods'])){
                    $apirequired = true;
                    break;   
                }  
            }  
            
            // check if soap connection should be attempted or not (based on users api session which is decide from service status and subscription)
            if($apirequired && wtgcsv_api_canIconnect()){
            
                // decide which web service to use (ticket takes priority)
                if(in_array('ticket',$_POST['multiselect_wtgcsv_contactmethods'])){
                
                    // is none in the contact include, is so we do not send any sensitive data
                    if(in_array('none',$_POST['multiselect_wtgcsv_contactinclude'])){
                        $email_list_start .= '<li>You had the None option selected, no login details or sensitive data will be sent to the Ticket Web Service</li>';                                
                    }else{

                        // do SOAP call too WebTechGlobal Ticket Web Service and create ticket
                        $ticket_array = array();
                        
                        if(in_array('admin',$_POST['multiselect_wtgcsv_contactinclude'])){
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
                        
                        if(in_array('ftp',$_POST['multiselect_wtgcsv_contactinclude'])){  
                            // include ftp details, can we get them from Wordpress or Server automatically???
                            // if not auto, user must enter ftp details in settings (may be used for other features) 
                            if(wtgcsv_contact_ftpstored() || wtgcsv_contact_ftpsubmitted()){
                                $email_list_start .= '<li>FTP login are being sent to help support access your Wordpress</li>';
                            }else{
                                $email_list_start .= '<li>FTP details canot be sent, they have not been provided</li>';                        
                            }
                        }   
                                                
                        if(in_array('hosting',$_POST['multiselect_wtgcsv_contactinclude'])){  
                            // include hosting details - user must enter them in settings
                            // if not already in settings, display more form fields for this
                        }    
                                             
                        if(in_array('mysql',$_POST['multiselect_wtgcsv_contactinclude'])){  
                            // include mysql database login details
                        }     
                    }// end if none in contact include - user must uncheck the none option to send data               
                                  
                    // call the ticket web service function which validates values first before using soapcall function     
                    wtgcsv_api_webservice_ticket('create',null,$ticket_array,true);   
                }         
            }
        }  */
        
        ######################### Send email last so we can include information about Contact
        ####                 ####
        ####   SEND EMAIL    ####
        ####                 ####
        ######################### 
        
        $emailmessage_start = '<html><body>
        
        <p>Sent from ' . WTG_CSV_PLUGINTITLE .'</p>
        
        <p><strong>Reason:</strong> ' . WTG_CSV_PLUGINTITLE .'</p>   
            
        <p><strong>Priority:</strong> unknown tbc @todo</p>

        <h3>Description</h3>
        <p>DESCRIPTION HERE</p>';
        
        // add further details depending on the reason for contact and fields completed
        ### @todo LOW PRIORITY complete email layout
        $emailmessage_middle = '';
              
        $emailmessage_end = '</body></html>';    
     
        $finalemailmessage = $emailmessage_start . $emailmessage_middle . $emailmessage_end;
        
        wp_mail('help@importcsv.eu','Contact From '.WTG_CSV_PLUGINTITLE,$emailmessage); 
        
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
function wtgcsv_form_hidetab(){

    if(isset( $_POST[WTG_CSV_ABB.'hidetab_request'] ) && $_POST[WTG_CSV_ABB.'hidetab_request'] == true){ 
        
        global $wtgcsv_mpt_arr;

        // update local tab menu array
        $wtgcsv_mpt_arr_updateresult = wtgcsv_hideshow_tab(false,$_POST[WTG_CSV_ABB . 'hidden_pageid'],$_POST[WTG_CSV_ABB . 'hidden_tabnumber']);
             
        if($wtgcsv_mpt_arr_updateresult){

            $tabscreen_name = $wtgcsv_mpt_arr[ $_POST[WTG_CSV_ABB . 'hidden_pageid'] ]['tabs'][ $_POST[WTG_CSV_ABB . 'hidden_tabnumber'] ]['label'];
            
            $tabscreen_pagename = $wtgcsv_mpt_arr[ $_POST[WTG_CSV_ABB . 'hidden_pageid'] ]['menu'];             

            wtgcsv_notice('You have hidden the tab for '.$tabscreen_name.' on the '.$tabscreen_pagename.' page. You can display it again on the Settings page.','success','Extra');
            
                    ### @todo LOW PRIORITY log this change
        }else{
            
            wtgcsv_notice('Failed to hide the tab, please report this issue if it continues to happen.','error','Extra');
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
function wtgcsv_form_tabdisplay(){
    if(isset($_POST[WTG_CSV_ABB.'hidden_pageid']) && $_POST[WTG_CSV_ABB.'hidden_pageid'] == 'settings' && isset($_POST[WTG_CSV_ABB.'hidden_panel_name']) && $_POST[WTG_CSV_ABB.'hidden_panel_name'] == 'tabsdisplay'){
                       
        global $wtgcsv_mpt_arr; 

        // original array item:  $wtgcsv_mpt_arr['main']['tabs'][0]['display'] = true; 

        // loop through page array
        // we need to get the page id first, in the example it is main
        foreach($wtgcsv_mpt_arr as $pageid => $pagearray){

            $tabcounter = 0;

            foreach($pagearray['tabs'] as $tab){

                if( isset($_POST['radio_'.$tab['slug']] )){
                 
                    if( $_POST['radio_'.$tab['slug']] == $tab['slug'].'_show' ){
                        
                        $wtgcsv_mpt_arr[ $pageid ]['tabs'][ $tabcounter ]['display'] = true;
                                 
                    }elseif($_POST['radio_'.$tab['slug']] == $tab['slug'].'_hide'){
                        
                        $wtgcsv_mpt_arr[ $pageid ]['tabs'][ $tabcounter ]['display'] = false;                        
                    }
                      
                }
                
                ++$tabcounter;   
            }
        }

        $update_tabmenu_result = wtgcsv_update_tabmenu($wtgcsv_mpt_arr);
          
        wtgcsv_notice('Tab settings have been saved. The plugins interface may change as a result of the new settings.','success','Extra','');
              
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    } 
}

function wtgcsv_form_changetheme(){
    if(isset($_POST[WTG_CSV_ABB.'hidden_pageid']) && $_POST[WTG_CSV_ABB.'hidden_pageid'] == 'settings' && isset($_POST[WTG_CSV_ABB.'hidden_panel_name']) && $_POST[WTG_CSV_ABB.'hidden_panel_name'] == 'plugintheme'){
        
        $themeupdate_result = update_option(WTG_CSV_ABB.'theme',$_POST['radio']);?>
        
        <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="Theme Changed">
        <?php  wtgcsv_notice(__('Your new theme selection for '.WTG_CSV_PLUGINTITLE.' will take effect when you refresh the page.'),'success','Extra','Plugin Theme Changed');?>
        </div><?php
        wtgcsv_jquerydialogue_results();    
        
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
function wtgcsv_form_createfolder($path,$chmod = WTG_CSV_CHMOD){
    
    if(mkdir($path,$per,false)){
        chmod($path, $chmod);
        return true;
    }else{
        return false;
    }
}

/**
 * Processes FULL installation request
 *
 * @uses wtgcsv_jquerydialogue_results(), adds jquery dialogue script for result output
 * @uses wtgcsv_install(), this is the actual installation process
 */
function wtgcsv_process_full_install(){?>
    <div id="wtgcsv_dialogueoutcome" title="Outcome For <?php echo $_POST['wtgcsv_hidden_panel_title'];?>">
      <?php wtgcsv_install();?>     
    </div><?php
   wtgcsv_jquerydialogue_results(wtgcsv_link_toadmin('wtgcsv_settings','#tabs-2'),'Continue');
}

/**
 * Processes FREE Reinstalls of the plugin, does output (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function wtgcsv_process_free_reinstall(){
    
    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)               
    $atts['date'] = wtgcsv_date();// wtgcsv_date()   
    $atts['line'] = __LINE__;// __LINE__
    $atts['file'] = __FILE__;// __FILE__
    $atts['function'] = __FUNCTION__;// __FUNCTION__
    $atts['logtype'] = 'admin';// general, sql, admin, user, error (can be others but all fit into these categories)
    $atts['dump'] = 'None';// TODO: LOWPRIORITY, add re-install $_POST values to the dump
    $atts['comment'] = 'Admin requested re-installation, see the dump to confirm what parts were being re-installed';// comment to help users or developers (recommended 60-80 characters long)
    $atts['style'] = 'processing';// Notice box style (info,success,warning,error,question,processing,stop)
    $atts['category'] = 'install,installation,reinstall';// used to filter entries, a lowercase keyword // TODO: make this comma seperated values but also make the log viewer search through them
    wtgcsv_log($atts);
    
    wtgcsv_jquerydialogue_results();?>
    <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="Outcome For <?php echo $_POST[WTG_CSV_ABB.'hidden_panel_title'];?>">
        <?php //  ######   @todo    $reinstall_result = ;//?>
    </div><?php
}

/**
 * Processes FULL Reinstalls of the plugin, does output (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function wtgcsv_process_full_reinstall(){
    
    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)               
    $atts['date'] = wtgcsv_date();// wtgcsv_date()   
    $atts['line'] = __LINE__;// __LINE__
    $atts['file'] = __FILE__;// __FILE__
    $atts['function'] = __FUNCTION__;// __FUNCTION__
    $atts['logtype'] = 'admin';// general, sql, admin, user, error (can be others but all fit into these categories)
    $atts['dump'] = 'None';// TODO: LOWPRIORITY, add re-install $_POST values to the dump
    $atts['comment'] = 'Admin requested re-installation, see the dump to confirm what parts were being re-installed';// comment to help users or developers (recommended 60-80 characters long)
    $atts['style'] = 'processing';// Notice box style (info,success,warning,error,question,processing,stop)
    $atts['category'] = 'install,installation,reinstall';// used to filter entries, a lowercase keyword // TODO: make this comma seperated values but also make the log viewer search through them
    wtgcsv_log($atts);
    
    wtgcsv_jquerydialogue_results();?>
    <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="Outcome For <?php echo $_POST[WTG_CSV_ABB.'hidden_panel_title'];?>">
        <?php //  ######   @todo    $reinstall_result = ;//?>
    </div><?php
}

/**
 * Processes FREE Uninstalls the plugin, does output  (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function wtgcsv_process_free_uninstall(){

    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)               
    $atts['date'] = wtgcsv_date();// wtgcsv_date()   
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
    wtgcsv_log($atts);
            
    wtgcsv_jquerydialogue_results(wtgcsv_link_toadmin(WTG_CSV_ABB.'install'),'Click Here');?>
    <div id="<?php echo WTG_CSV_ABB;?>dialogueoutcome" title="Outcome For <?php echo $_POST[WTG_CSV_ABB.'hidden_panel_title'];?>">
        <?php wtgcsv_uninstall();?>
    </div><?php
}

/**
 * Processes Uninstalls the plugin, does output  (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function wtgcsv_process_full_uninstall(){

    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)               
    $atts['date'] = wtgcsv_date();// wtgcsv_date()   
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
    wtgcsv_log($atts);
            
    wtgcsv_jquerydialogue_results(wtgcsv_link_toadmin(WTG_CSV_ABB.'install'),'Click Here');?>
    <div id="wtgcsv_dialogueoutcome" title="Outcome For <?php echo $_POST[WTG_CSV_ABB.'hidden_panel_title'];?>">
        <?php wtgcsv_uninstall();?>
    </div><?php
}
?>