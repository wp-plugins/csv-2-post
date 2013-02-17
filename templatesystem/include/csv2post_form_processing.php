<?php 
global $csv2post_notice_result;
       
# TODO: add hidden input with value uses in these arguments to skip more function calls i.e. one per screen
    
// Data Screen Form Submissions
if($cont){

    // Process CSV file upload    
    $cont = csv2post_form_upload_csv_file();
                               
    // create a new data import job
    $cont = csv2post_form_createdataimportjob();
                    
    // Delete Data Import Jobs
    $cont = csv2post_form_delete_dataimportjobs();
           
    // Delete one or more database tables
    $cont = csv2post_form_drop_database_tables(); 
                
    // Manual data import
    $cont = csv2post_form_importdata();
                             
    // Delete CSV file
    $cont = csv2post_form_delete_csvfile();
            
    // Advanced manual data import
    $cont = csv2post_form_importdata_advanced();
              
    // Table To Table Pairing
    $cont = csv2post_form_tabletotable_pair(); 
    
    // Table to table configure column relationships
    $cont = csv2post_form_tabletotable_configure();
    
    // Table To Table Transfer
    $cont = csv2post_form_tabletotable_transfer();
    
    // Table to table delete pair
    $cont = csv2post_form_tabletotable_delete();
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
    
    // Update the default title template 
    $cont = csv2post_form_change_default_titletemplate();    
    
    // Update the default excerpt template 
    $cont = csv2post_form_change_default_excerpttemplate();
        
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
    
    // Save a new spinner (text spin)
    $cont = csv2post_form_save_textspinner();
    
    // Deletes random advanced shortcode rules
    $cont = csv2post_form_delete_randomadvanced_shortcoderules();
    
    // Activate or disable text spinning
    $cont = csv2post_form_textspinning_switch();
    
    // Save basic SEO options
    $cont = csv2post_form_save_basic_seo_options();
    
    // Save advanced SEO option
    $cont = csv2post_form_save_advanced_seo_options();    
    
    // Save post titles data column
    $cont = csv2post_form_save_title_data_column();
    
    // Save Ultimate Taxonomy Manager category custom field settings
    $cont = csv2post_form_save_ultimatetaxonomymanager_categories();
    
    // Save default author
    $cont = csv2post_form_save_default_author();
    
    // Save featured image table and column
    $cont = csv2post_form_featuredimage();
    
    // Save sub-page by permalinks
    $cont = csv2post_form_subpage_bypermalinks();

    // save sub-page by grouping 
    $cont = csv2post_form_subpage_bygrouping();  
}

// Creation Screen
if($cont){  
    $cont = csv2post_form_save_dripfeedprojects_switch();
        
    // Start post creation even manually
    $cont = csv2post_form_start_post_creation();
    
    // Creates categories (2012 method, all levels at once)
    $cont = csv2post_form_create_categories(); 
    
    // Create category level (2013 method, one level at a time for better monitoring/diagnostics)
    $cont = csv2post_form_create_category_level();
    
    // Updates a single giving post using post ID                         
    $cont = csv2post_form_update_post();
    
    // Save global updating settings
    $cont = csv2post_form_save_globalupdatesettings();  
    
    // Undo posts
    $cont = csv2post_form_undo_posts();
    
    // Delete flags
    $cont = csv2post_form_delete_flags(); 
    
    // Undo current project categories 
    $cont = csv2post_form_undo_categories();        
}

// Install
if($cont){
        
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
     
    $cont = csv2post_form_installplugin();       
    $cont = csv2post_form_uninstallplugin_partial();    
}

// Main and Settings     
if($cont){
    // Save easy configuration questions
    $cont = csv2post_form_save_easyconfigurationquestions();
    
    // Save extension settings    
    $cont = csv2post_form_save_extensionsettings();

    // Save global allowed days and hours
    $cont = csv2post_form_save_scheduletimes_global();
    
    // Save drip feed limits
    $cont = csv2post_form_save_schedulelimits();
    
    // Save event types
    $cont = csv2post_form_save_eventtypes();
    
    // Save encoding settings
    $cont = csv2post_form_save_encoding_settings();
    
    // Save reporting settings
    $cont = csv2post_form_save_reporting_settings();
    
    // Save admin triggered automation settings
    $cont = csv2post_form_save_admin_triggered_automaton();

    // Save admin triggered automation settings
    $cont = csv2post_form_save_public_triggered_automaton(); 
        
    // Save form settings
    $cont = csv2post_form_save_formsettings(); 
    
    // Save screen permissions settings
    $cont = csv2post_form_save_screenpermissionssettings();
    
    // Save page permissions settings
    $cont = csv2post_form_save_pagepermissionssettings(); 
    
    // Reset Easy CSV Importer Session
    $cont = csv2post_form_reseteci();            
}    
    
// Other
if($cont){
    $cont = csv2post_form_changetheme();  
    $cont = csv2post_form_createcontentfolder();
    $cont = csv2post_form_deletecontentfolder(); 
    
    // Delete persistent notice
    $cont = csv2post_form_delete_persistentnotice();   
}

// Easy CSV Importer - Free
if($cont){
    
    // Step 18: Create Posts
    $cont = csv2post_form_ECI_free_step18_createposts();
    
    // Step 17: Post Types
    $cont = csv2post_form_ECI_free_step17_posttypes();
    
    // Step 16: Theme Support
    $cont = csv2post_form_ECI_free_step16_themesupport();    
    
    // Step 15: Authors
    $cont = csv2post_form_ECI_free_step15_authors(); 

    // Step 14: Text Spinning
    $cont = csv2post_form_ECI_free_step14_textspinning();

    // Step 13: Tags
    $cont = csv2post_form_ECI_free_step13_tags();

    // Step 12: Images
    $cont = csv2post_form_ECI_free_step12_images();

    // Step 11: Post Update Options
    $cont = csv2post_form_ECI_free_step11_postupdateoptions();

    // Step 10: Categories
    $cont = csv2post_form_ECI_free_step10_categories();

    // Step 9: Custom Fields
    $cont = csv2post_form_ECI_free_step9_customfields(); 

    // Step 8: Post Dates
    $cont = csv2post_form_ECI_free_step8_postdates(); 

    // Step 7: Post Status
    $cont = csv2post_form_ECI_free_step7_poststatus(); 

    // Step 6: SEO
    $cont = csv2post_form_ECI_free_step6_seo(); 

    // Step 5: Title Template
    $cont = csv2post_form_ECI_free_step5_titletemplate();

    // Step 4: Content Template
    $cont = csv2post_form_ECI_free_step4_contenttemplate();

    // Step 3: Import Date
    $cont = csv2post_form_ECI_free_step3_importdate();

    // Step 2: User Confirms CSV File Format
    $cont = csv2post_form_ECI_free_step2_confirmformat();
    
    // Step 1: Upload CSV File (also updates the ECI session array)
    $cont = csv2post_form_ECI_free_step1_uploadcsvfile();
            
}

// Easy CSV Importer - Paid
if($cont){

    // Step 18: Create Posts
    $cont = csv2post_form_ECI_paid_step18_createposts();
    
    // Step 17: Post Types 
    $cont = csv2post_form_ECI_paid_step17_posttypes();
    
    // Step 16: Theme Support
    $cont = csv2post_form_ECI_paid_step16_themesupport();    
    
    // Step 15: Authors
    $cont = csv2post_form_ECI_paid_step15_authors(); 

    // Step 14: Text Spinning
    $cont = csv2post_form_ECI_paid_step14_textspinning();

    // Step 13: Tags
    $cont = csv2post_form_ECI_paid_step13_tags();

    // Step 12: Images
    $cont = csv2post_form_ECI_paid_step12_images();

    // Step 11: Post Update Options
    $cont = csv2post_form_ECI_paid_step11_postupdateoptions();

    // Step 10: Categories
    $cont = csv2post_form_ECI_paid_step10_categories();

    // Step 9: Custom Fields
    $cont = csv2post_form_ECI_paid_step9_customfields(); 

    // Step 8: Post Dates
    $cont = csv2post_form_ECI_paid_step8_postdates(); 

    // Step 7: Post Types
    $cont = csv2post_form_ECI_paid_step7_poststatus(); 

    // Step 6: SEO
    $cont = csv2post_form_ECI_paid_step6_seo(); 

    // Step 5: Title Template
    $cont = csv2post_form_ECI_paid_step5_titletemplate();

    // Step 4: Content Template
    $cont = csv2post_form_ECI_paid_step4_contenttemplate();

    // Step 3: Import Date
    $cont = csv2post_form_ECI_paid_step3_importdate();

    // Step 2: User Confirms CSV File Format
    $cont = csv2post_form_ECI_paid_step2_confirmformat();
    
    // Step 1: Upload CSV File (also updates the ECI session array)
    $cont = csv2post_form_ECI_paid_step1_uploadcsvfile();
            
}

// Update Page
if($cont){ 
    csv2post_form_plugin_update();
}

#################################################
#                                               #
#      EASY CSV IMPORTER - PAID FUNCTIONS       #
#                                               #
#################################################
function csv2post_form_ECI_paid_step18_createposts(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        $csv2post_ecisession_array['nextstep'] = 17;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
} 

function csv2post_form_ECI_paid_step17_posttypes(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
   
        
        $csv2post_ecisession_array['nextstep'] = 18;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
} 
       
function csv2post_form_ECI_paid_step16_themesupport(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();


        
        $csv2post_ecisession_array['nextstep'] = 16;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
} 

function csv2post_form_ECI_paid_step15_authors(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
    
        $csv2post_ecisession_array['nextstep'] = 15;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step14_textspinning(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();


        $csv2post_ecisession_array['nextstep'] = 14;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step13_tags(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
  
        $csv2post_ecisession_array['nextstep'] = 13;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step12_images(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
  
        $csv2post_ecisession_array['nextstep'] = 12;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step11_postupdateoptions(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
   
        
        $csv2post_ecisession_array['nextstep'] = 11;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}
    
function csv2post_form_ECI_paid_step10_categories(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();


        $csv2post_ecisession_array['nextstep'] = 10;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step9_customfields(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        $csv2post_ecisession_array['nextstep'] = 9;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step8_postdates(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();


        $csv2post_ecisession_array['nextstep'] = 9;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}
 
function csv2post_form_ECI_paid_step7_poststatus(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        $csv2post_ecisession_array['nextstep'] = 8;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step6_seo(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        $csv2post_ecisession_array['nextstep'] = 7;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step5_titletemplate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
 
        
        $csv2post_ecisession_array['nextstep'] = 6;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_paid_step4_contenttemplate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        $csv2post_ecisession_array['nextstep'] = 5;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}
    

function csv2post_form_ECI_paid_step3_importdate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        
        $csv2post_ecisession_array['nextstep'] = 4;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

// Easy CSV Importer - Step 2 (in code it is zero) - Confirm Format 
function csv2post_form_ECI_paid_step2_confirmformat(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();


        $csv2post_ecisession_array['nextstep'] = 3;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

// Easy CSV Importer - Step 1 (in code it is zero) - Upload CSV File
function csv2post_form_ECI_paid_step1_uploadcsvfile(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        
        $csv2post_ecisession_array['nextstep'] = 2;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     

        return false;
    }else{
        return true;
    }     
}
    
#################################################
#                                               #
#      EASY CSV IMPORTER - FREE FUNCTIONS       #
#                                               #
#################################################
function csv2post_form_ECI_free_step18_createposts(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreecreateposts' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code,$csv2post_project_array;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        // update the ECI session array
//$csv2post_ecisession_array['nextstep'] = 19;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array); 
                
        // free edition processes all records at once, $_POST['csv2post_postsamount'] will not be set   
        $post_id = csv2post_create_posts_basic($csv2post_currentproject_code,'manual');
        if($post_id){
            // no false returned (false indicates a failure)
            // $post_id will be the last post ID created
            csv2post_notice_postresult('success','Posts Created','Post creation went smoothly, no 
            problems were detected. The last post ID created was <strong>'.$post_id.'</strong>.');
            ### TODO:LOWPRIORITY, add link and url to last created post to the output  
        }else{
           // must be a failure, if multiple posts were requests the failure is big enough to output it to the user
           csv2post_notice_postresult('warning','Problem Detected','A problem was detected during 
           the post creation process. The severity can only be established by checking logs and 
           any posts created or expected to have been created. Feel free to contact the plugins 
           team for free help.');
        }    
        
        return false;
    }else{
        return true;
    }     
} 
                       
function csv2post_form_ECI_free_step17_posttypes(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeposttypes' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        
        global $csv2post_project_array,$csv2post_currentproject_code;
        $csv2post_project_array['defaultposttype'] = $_POST['csv2post_radio_defaultpostype'];
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 
            
        // update the ECI session array
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        $csv2post_ecisession_array['nextstep'] = 18;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        csv2post_notice_postresult('success','Post Type Saved','Your post type has been saved.');
        
        return false;
    }else{
        return true;
    }     
} 
       
function csv2post_form_ECI_free_step16_themesupport(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        // not in free edition
        return false;
    }else{
        return true;
    }     
} 

function csv2post_form_ECI_free_step15_authors(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreedefaultauthor' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        global $csv2post_project_array,$csv2post_currentproject_code;

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        $csv2post_project_array['authors']['defaultauthor'] = $_POST['csv2post_ecifreedefaultauthor_select'];
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 

        $csv2post_ecisession_array['nextstep'] = 17;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        csv2post_notice_postresult('success','Default Author Saved','A default author has been saved');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step14_textspinning(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        // not currently in free edition
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step13_tags(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreetags' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
                
        if($_POST['csv2post_eci_freetags_methods'] == 'no'){
            // nothing needs to be done
            csv2post_notice_postresult('success','No Featured Images Wanted','You opted to not use featured images in your posts.');    
        }else{
            
            global $csv2post_project_array,$csv2post_currentproject_code;
            
            $csv2post_project_array['tags']['default']['table'] = 'csv2post_' . $csv2post_ecisession_array['dijcode'];
            $csv2post_project_array['tags']['default']['column'] = $_POST['csv2post_eci_freetags_methods'];                       
            $csv2post_project_array['tags']['method'] = 'premade'; 
            
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);                
            
            csv2post_notice_postresult('success','Tags Configured','Your tags data will be added to your posts providing your posts.');    
        }

        $csv2post_ecisession_array['nextstep'] = 15;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step12_images(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeimages' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
      
        if($_POST['csv2post_eci_freefeaturedimages_methods'] == 'no'){
            // nothing needs to be done
            csv2post_notice_postresult('success','No Featured Images Wanted','You opted to not use featured images in your posts.');    
        }else{
            
            global $csv2post_project_array,$csv2post_currentproject_code;

            $csv2post_project_array['images']['featuredimage']['table'] = 'csv2post_' . $csv2post_ecisession_array['dijcode'];            
            $csv2post_project_array['images']['featuredimage']['column'] = $_POST['csv2post_csvfileheader_eci_freefeaturedimages_WTGTestB'];
            
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);                
            
            csv2post_notice_postresult('success','Featured Images Setup','Your posts will have featured images providing the image URL are valid.');    
        }

        $csv2post_ecisession_array['nextstep'] = 13;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);    
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step11_postupdateoptions(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreenotpermittedinfreeedition' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        // not part of free edition
        return false;
    }else{
        return true;
    }     
}
    
function csv2post_form_ECI_free_step10_categories(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreecategories' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code,$csv2post_project_array; 
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        
        $csv2post_project_array['categories']['default'] = $_POST['csv2post_createcategorymappingecifreecategory_select'];

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);        
                    
        $csv2post_ecisession_array['nextstep'] = 12;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        csv2post_notice_postresult('success','Category Saved','You have set a default category, the category ID is '.$_POST['csv2post_createcategorymappingecifreecategory_select'].'.');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step9_customfields(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreecustomfields' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code,$csv2post_project_array;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        // get last array key for current custom fields if they exist
        if(isset($csv2post_project_array['custom_fields']['basic'])){
            $last_array_key = csv2post_get_array_nextkey($csv2post_project_array['custom_fields']['basic']);
        }else{
            $last_array_key = 0;
        }
           
        // loop through headers
        $job_headers_array = csv2post_get_dataimportjob_headers_singlefile($csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);
        foreach($job_headers_array as $key => $header){

            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['table_name'] = 'csv2post_' . $csv2post_ecisession_array['dijcode'];                
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['column_name'] = $header['sql'];
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['meta_key'] = $_POST['csv2post_ecifree_cf_'.$key];
            ++$last_array_key;
        }           

        // update project option         
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        // update the ECI session array
        $csv2post_ecisession_array['nextstep'] = 10;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        csv2post_notice_postresult('success','Custom Fields Saved','Your custom field settings have been saved.');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step8_postdates(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreepostdates' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code,$csv2post_project_array;

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        $file = $csv2post_ecisession_array['filenamenoext'];
        
        if($_POST['csv2post_eci_freedates_methods'] == 'default'){
            
            unset($csv2post_project_array['dates']['currentmethod']);
             
        }elseif($_POST['csv2post_eci_freedates_methods'] == 'data'){
            
            $csv2post_project_array['dates']['date_column']['table_name'] = 'csv2post_' . $csv2post_ecisession_array['dijcode'];          
            $csv2post_project_array['dates']['date_column']['column_name'] = $_POST['csv2post_csvfileheader_eci_freedates_' . $file];
            $csv2post_project_array['dates']['currentmethod'] = 'data';
             
        }else{
            unset($csv2post_project_array['dates']['currentmethod']);    
        }  
   
        ### TODO:MEDIUMPRIORITY, test a date value from users data, also consider a tool for converting dates to require format
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        // update the ECI session array              
        $csv2post_ecisession_array['nextstep'] = 9;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);
        
        csv2post_notice_postresult('success','Data Method Saved','Your selected date method has been saved.');     
        
        return false;
    }else{
        return true;
    }     
}
 
function csv2post_form_ECI_free_step7_poststatus(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreepoststatus' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        global $csv2post_project_array;
        
        if(!isset($_POST['csv2post_radio_poststatus'])){
            $status = 'publish';
        }else{
            $status = $_POST['csv2post_radio_poststatus'];
        }
        
        $csv2post_project_array['poststatus'] = $_POST['csv2post_radio_poststatus'];
        csv2post_update_option_postcreationproject('freeproject',$csv2post_project_array);
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        $csv2post_ecisession_array['nextstep'] = 8;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     

        csv2post_notice_postresult('success','Post Status Saved','All your post status will be set to ' . $status . '.');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step6_seo(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        // currently not in free edition, feel free to hack and let us know what you do so we know what abilities users would like put here
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step5_titletemplate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreesetuptitletemplate' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        
        $file = $csv2post_ecisession_array['filenamenoext'];
        
        $template_id = csv2post_insert_titletemplate($file . ' ' . csv2post_date(),'#'.$_POST['csv2post_csvfileheader_eci_pair_description_'.$file]);
        
        if(!is_numeric($template_id)){
            csv2post_notice_postresult('error','Title Template Not Created','A new title template could not be created. Please report
            this issue and get help before continuing.');
            return false;
        }
        
        csv2post_update_default_titletemplate($csv2post_currentproject_code,$template_id);
        
        $csv2post_ecisession_array['nextstep'] = 7;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     

        csv2post_notice_postresult('success','Title Template Created','A new title template was created.');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step4_contenttemplate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreesetupcontenttemplate' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        $file = $csv2post_ecisession_array['filenamenoext'];
                
        $free_content_template = 'x-DESCRIPTION-x<a href="x-LINK-x"><img class="alignleft size-thumbnail wp-image-12" title="" src="x-IMAGE-x" alt="" width="150" height="150" /></a>'; 
        
        // replace tokens in our inline template with new tokens
        # TODO:MEDIUMPRIORITY, add validation by testing values from a row, warn user but do not break the progress
        $free_content_template = str_replace('x-DESCRIPTION-x','#'.$_POST['csv2post_csvfileheader_eci_pair_description_'.$file],$free_content_template);
        $free_content_template = str_replace('x-IMAGE-x','#'.$_POST['csv2post_csvfileheader_eci_pair_image_'.$file],$free_content_template);
        $free_content_template = str_replace('x-LINK-x','#'.$_POST['csv2post_csvfileheader_eci_pair_link_'.$file],$free_content_template);
                
        $template_id = csv2post_insert_post_contenttemplate($free_content_template,$file . ' ' . csv2post_date());
  
        if(!is_numeric($template_id)){
            csv2post_notice_postresult('error','Content Template Not Created','A new content template could not be created. Please report
            this issue and get help before continuing.');
            return false;
        }
        
        csv2post_update_default_contenttemplate($csv2post_currentproject_code,$template_id); 
         
        $csv2post_ecisession_array['nextstep'] = 5;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     

        csv2post_notice_postresult('error','Content Template Created','A new content template was created
        and set as your projects default template. You may edit the template under Content Templates in the
        main Wordpress menu, it is a post type.');
            
        return false;
    }else{
        return true;
    }     
}
    
function csv2post_form_ECI_free_step3_importdate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeimportdata' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_is_free;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        
        $job_code = $csv2post_ecisession_array['dijcode'];
        $file_name = $csv2post_ecisession_array['filename'];
  
        // perform data import
        $overall_result = 'success';
        $dataimportjob_array = csv2post_data_import_from_csvfile_basic($file_name,'csv2post_'.$job_code,9999999,$job_code);
        
        // determine new $overall_result and apply styling to the main notice to suit it
        if($dataimportjob_array == false){
            csv2post_notice_postresult('error','Fault','There was a problem importing
            data, please seek support from the plugin author.');
            return false;
        }
        
        $intromes = '';

        // display result    
        csv2post_notice( '<h4>Data Import Result<h4>'.$intromes.'
        '.csv2post_notice( 'New Records: '.$dataimportjob_array["stats"]["lastevent"]['inserted'],'success','Small',false,'www.csv2post.com/notifications/new-records-count','return').'
        '.csv2post_notice( 'Void Records: '.$dataimportjob_array["stats"]["lastevent"]['void'],'info','Small',false,'www.csv2post.com/notifications/void-records-counter','return').'
        '.csv2post_notice( 'Dropped Rows: '.$dataimportjob_array["stats"]["lastevent"]['dropped'],'warning','Small',false,'www.csv2post.com/notifications/dropped-rows-counter','return').'
        '.csv2post_notice( 'Rows Processed: '.$dataimportjob_array["stats"]["lastevent"]['processed'],'info','Small',false,'www.csv2post.com/notifications/rows-processed-counter','return').'         
        ',$overall_result,'Extra','','','echo'); 

        $csv2post_ecisession_array['nextstep'] = 4;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);
                        
        return false;
    }else{
        return true;
    }     
}
                          
// Easy CSV Importer - Step 2 (in code it is zero) - Confirm Format 
function csv2post_form_ECI_free_step2_confirmformat(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeconfirmformat'){
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        
        // set full filename
        $filename = $csv2post_ecisession_array['filename'];

        $file = $csv2post_ecisession_array['filenamenoext'];
                                       
        // if user did not enter field count
        if(!isset($_POST['csv2post_csvfile_fieldcount_' . $file]) || $_POST['csv2post_csvfile_fieldcount_' . $file] == ''){
            csv2post_notice_postresult('error','Column/Field Number Required','You did not enter a value for the number of columns your CSV file has.');
            return;
        }
                
        // if user did not select separator
        if(!isset($_POST['csv2post_newjob_separators' . $file])){
            csv2post_notice_postresult('error','No Separator Selected','Please select the separator/delimiter.');
            return;
        }
        
        // if user did not select quote
        if(!isset($_POST['csv2post_newjob_quote' . $file])){
            csv2post_notice_postresult('error','No Quote Selected','Please select the quote used in your CSV file.');
            return;
        }            

        $importjobname_validate_result = csv2post_validate_dataimportjob_name($file);
        if(!$importjobname_validate_result){
            csv2post_notice_postresult('error','Invalid Data Import Job Name','This job name has been determined as not suitable:'.$file.'. Please report this, we can make modifications to get around the problem quickly.');
            return;
        }
        
        // generate job code (used to name database table and option record for job history) 
        $code = csv2post_create_code(6); 

        // create an array for the job, to be stored in an option record of its own
        $jobarray = csv2post_create_jobarray($file,$code);
        $jobarray['jobname'] = $file;

        // free edition does not allow multiple files                
        $jobarray['filegrouping'] = 'single';
                         
        // add the file with the $fileid as key, $fileid is simple integer number beginning from 1
        $jobarray['files'][1] = $filename;

        // add separator
        $jobarray[$filename]['separator'] = $_POST['csv2post_newjob_separators' . $file];        
       
        // add quote
        if($_POST['csv2post_newjob_quote' . $file] == 'doublequote'){
            $jobarray[$filename]['quote'] = '"';    
        }elseif($_POST['csv2post_newjob_quote' . $file] == 'singlequote'){
            $jobarray[$filename]['quote'] = "'";
        }

        // add number of fields/columns
        $jobarray[$filename]['fields'] = $_POST['csv2post_csvfile_fieldcount_'.$file];    
       
        // add job stats for the file, required for multiple file jobs
        $jobarray['stats'][$filename]['progress'] = 0;
        $jobarray['stats'][$filename]['inserted'] = 0;    
        $jobarray['stats'][$filename]['updated'] = 0;
        $jobarray['stats'][$filename]['deleted'] = 0;
        $jobarray['stats'][$filename]['void'] = 0;    
        $jobarray['stats'][$filename]['dropped'] = 0;    
        $jobarray['stats'][$filename]['duplicates'] = 0;                    
        $jobarray['stats'][$filename]['rows'] = csv2post_count_csvfilerows($filename);                    

        // also add an array of each files headers with the file as key
        $jobarray[$filename]['headers'] = csv2post_get_file_headers_formatted($filename,1,$jobarray[$filename]['separator'],$jobarray[$filename]['quote'],$jobarray[$filename]['fields']);
         
        // set total rows
        $jobarray['totalrows'] = $jobarray['stats'][$filename]['rows'];
  
        $result = csv2post_save_dataimportjob($jobarray,$code);
        if(!$result){
            csv2post_notice_postresult('error','Failure','Could not save new Data Import Job, please report this.');
            return;        
        }
                   
        // set global $csv2post_currentjob_code as new code and set global $csv2post_job_array
        global $csv2post_currentjob_code,$csv2post_job_array;
        $csv2post_currentjob_code = $code;
        $csv2post_job_array = $jobarray;
                    
        // create a database table - multiple file jobs are put into a single table, column names are giving appended values to prevent conflict with shared names    
        $createtable_result = csv2post_WP_SQL_create_dataimportjob_table($code,'single');
        if(!$createtable_result){
            csv2post_notice_postresult('error','Failure','Your data import database table 
            could not be created, this is required for importing your data to before using 
            it to create posts. Please seek help from the plugin author.');
            return;       
        }
   
        // update csv2post_current_job option record
        csv2post_update_option_currentjob_code($code);
                        
        // update the Data Import Jobs Array (the list of all job ID)
        global $csv2post_dataimportjobs_array;
                        
        // if data import jobs array is not already set then this must be the first job - set it as an array
        if(!is_array($csv2post_dataimportjobs_array)){
            $csv2post_dataimportjobs_array = array();    
        }

        // add job to the array that only holds a list of jobs not job statistics
        csv2post_add_dataimportjob_to_list($code,$file);

        // set last step as 9 (by default we use start by zero allows us to confirm start was done)
        $csv2post_ecisession_array['nextstep'] = 3;
        $csv2post_ecisession_array['dijcode'] = $code;// add data import job code 
        $csv2post_ecisession_array['jobname'] = $file;

        #################################################
        #                                               #
        #        CREATE POST CREATION PROJECT           #
        #                                               #
        #################################################
        global $csv2post_currentproject_code;

        // reset the project table
        csv2post_WP_SQL_reset_project_table($filename,true);
  
        // in free edition we automatically delete the existing csv2post_freeproject table
        csv2post_drop_dataimportjob_table('csv2post_freeproject');

        // create project function will return project code on success
        csv2post_create_post_creation_project($file . ' ' . csv2post_date() ,array('csv2post_'.$code),'defaultorder');

        // now set the new project as the Current Project ($csv2post_currentproject_code)               
        $csv2post_currentproject_code = $code;
        csv2post_update_currentproject($code);

        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);
                
        csv2post_notice_postresult('success','Project Created','A data 
        import job was created for managing your data. A post creation 
        project was created for managing your post creation.');

        return false;
    }else{
        return true;
    }     
}

// Easy CSV Importer - Step 1 (in code it is zero) - Upload CSV File
function csv2post_form_ECI_free_step1_uploadcsvfile(){
    if(isset($_POST['csv2post_post_eciuploadcsvfile']) && $_POST['csv2post_post_eciuploadcsvfile'] == true){
        global $csv2post_plugintitle;
        
        $upload = $_FILES['file'];
        
        // ensure user uploaded a .csv file
        if(!strstr($upload['name'],'.csv')){
            csv2post_notice('Sorry but '.$csv2post_plugintitle.' only accepts CSV 
            files with .csv extension right now.','error','Large','File Extension Not Allowed','','echo');
            return false;
        }        
        
        // check error value
        if($upload['error'] != 0){
            csv2post_notice('Could not upload file please contact us for support and 
            give error code: ' . $upload['error'],'error','Large','Upload Failed');
            return false;// not returning false due to failure, only returning false to indicate end of processing            
        }        
        
        // ensure file destination exists
        $open_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        if(!$open_result){
            csv2post_notice('File was not uploaded. Could not open the destination folder. 
            The folder is named wpcsvimportercontent and should be in the wp-content 
            directory. Please fix this before trying again.','error','Large','File Not Upload');
            return false;
        }

        // first reset ECI session array
        $csv2post_eci_session_array = array();
        $csv2post_eci_session_array['arrayupdated'] = time();
        $csv2post_eci_session_array['filename'] = $upload['name'];

        // check if filename already exists in destination - we will let the user know they wrote over an existing file
        $target_file_path =  WTG_C2P_CONTENTFOLDER_DIR . '/' . $upload['name'];
        $target_file_path_exists = file_exists( $target_file_path );
        if($target_file_path_exists){
            
            $csv2post_eci_session_array['filereplaced'] = true;
            
            // get existing files datestamp - we use it to ensure the new file is newer/changed and trigger data update
            $oldtime = filemtime( $target_file_path );
                    
            // delete the existing file
            unlink( $target_file_path );
            
            if ( file_exists( $target_file_path )){
                
                csv2post_notice('The name of your file being uploaded already exists in the target 
                folder. '.$csv2post_plugintitle.' could not remove the existing file, but it should have. 
                It may be because the existing file is in use, please investigate this then try again if 
                required. If some sort of permissions problem is causing this, you may delete the existing 
                file using FTP also.','error','Large','Existing File Not Removed'); 
                   
                // return now due to not being able to remove the existing file
                return false;
            }
            
            // file must not exist, unlink was success, let user know this was done
            csv2post_notice('The file name being uploaded existed already. The existing file was replaced.','info','Large','File Replaced');        
        }else{
            $csv2post_eci_session_array['filereplaced'] = false;
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
        
        // we use the files name without extension a lot so we will store it now 
        $csv2post_eci_session_array['filenamenoext'] = str_replace('.csv','',$upload['name']); 
        
        // set last step as 9 (by default we use start by zero allows us to confirm start was done)
        $csv2post_eci_session_array['nextstep'] = 2;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_eci_session_array);
        
        // upload is a success
        csv2post_notice('CSV file has been uploaded, you can proceed to the next step. <br /><br />Please note
        that you cannot move between this ECI screen and other screens in order to work with multiple
        Data Import Jobs or Post Creation Projects. You must complete the ECI process and only then 
        use other screens to work on different projects. You can ignore this message if you have no
        intention of working with multiple Data Import Jobs or do not use the other screens.','success','Large','CSV File Uploaded');

        return false;
    }else{
        return true;
    }     
}

function csv2post_form_delete_persistentnotice(){
    if(isset($_POST['csv2post_post_deletenotice']) && $_POST['csv2post_post_deletenotice'] == true){
         
        global $csv2post_persistent_array;

        foreach($csv2post_persistent_array['notifications'] as $key => $notice){
            if($notice['id'] == $_POST['csv2post_post_deletenotice_id']){
                unset($csv2post_persistent_array['notifications'][$key]);
            }            
        }
        
        csv2post_option('csv2post_notifications','update',$csv2post_persistent_array);        
                  
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_save_screenpermissionssettings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'screenpermissions'){
        
        global $csv2post_mpt_arr;

        // loop through tabs, this is the same loop build as on the capabilities interface itself
        $menu_id = 0;
        foreach($csv2post_mpt_arr['menu'] as $page_name => $page_array){

            foreach($page_array['tabs'] as $key => $tab_array){
                
                if(isset($tab_array['display']) && $tab_array['display'] != false){
                                        
                    // is post value set for current tab
                    if(isset($_POST['csv2post_capabilitiesmenu_'.$page_name.'_'.$key.''])){
         
                        // update capability setting for screen
                        $csv2post_mpt_arr['menu'][$page_name]['tabs'][$key]['permissions']['customcapability'] = $_POST['csv2post_capabilitiesmenu_'.$page_name.'_'.$key.''];
                    }

                    ++$menu_id; 
                }        
            }
        }        

        csv2post_option('csv2post_tabmenu','update',$csv2post_mpt_arr);

        csv2post_notice_postresult('success','Screen Permissions Saved','Your saved screen permissions
        may hide or display screens for users. We recommend that you access your blog using applicable 
        user accounts to test your new permissions.');
        
        return false;
    }else{
        return true;
    }       
} 

function csv2post_form_save_pagepermissionssettings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'pagepermissions'){

        global $csv2post_mpt_arr;

        foreach($csv2post_mpt_arr as $page_name => $page_array){
            
            if(isset($_POST['csv2post_capabilitiesmenu_'.$page_name.'_99'])){
                $csv2post_mpt_arr['menu'][$page_name]['permissions']['customcapability'] = $_POST['csv2post_capabilitiesmenu_'.$page_name.'_99'];    
            }
 
        }        

        csv2post_option('csv2post_tabmenu','update',$csv2post_mpt_arr); 
        
        csv2post_notice_postresult('success','Page Permissions Saved','Your saved page permissions
        may hide or display the plugins pages for users. We recommend that you access your blog using applicable 
        user accounts to test your new permissions.');
                
        return false;
    }else{
        return true;
    }       
}  

function csv2post_form_save_formsettings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'formsettings'){

        global $csv2post_adm_set;

        $csv2post_adm_set['interface']['forms']['dialog']['status'] = $_POST['csv2post_radiogroup_dialog'];
        csv2post_update_option_adminsettings($csv2post_adm_set);
        csv2post_notice_postresult('success','Form Settings Saved','Your form settings have been saved.');
        
        return false;
    }else{
        return true;
    }       
}  

/**
* Save reporting settings 
*/
function csv2post_form_save_reporting_settings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'reportingsettings'){

        global $csv2post_adm_set;
        
        $csv2post_adm_set['reporting']['uselog'] = $_POST['csv2post_radiogroup_logstatus'];
        $csv2post_adm_set['reporting']['loglimit'] = $_POST['csv2post_loglimit'];
        
        csv2post_update_option_adminsettings($csv2post_adm_set);
        
        csv2post_notice_postresult('success','Report Settings Saved','Your reporting settings have been saved. Please remember that
        reporting can help us provide support when you experience a fault or just require some advice 
        about your use of the plugin.');
        
        return false;
    }else{
        return true;
    }       
}  

/**
* Save encoding settings for free and premium. Premium only encoding will be hidden
* and its functions in premium files.
*/
function csv2post_form_save_encoding_settings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'encodingsettings'){

        global $csv2post_adm_set;
        
        $csv2post_adm_set['encoding']['type'] = $_POST['csv2post_radiogroup_encoding'];

        csv2post_update_option_adminsettings($csv2post_adm_set);
        
        csv2post_notice('Encoding settings have been saved. We recommend that you run a test
        before doing a lot of data import or activating automatic data importing on the Schedule System.'
        ,'success','Large','Encoding Settings Saved','','echo');
        
        return false;
    }else{
        return true;
    }       
}  

/**
* Saves admin triggered automation
*/
function csv2post_form_save_admin_triggered_automaton(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'admintriggeredautomation'){
        
        global $csv2post_adm_set;
        
        // new csv file detection
        $csv2post_adm_set['admintriggers']['newcsvfiles']['status'] = $_POST['csv2post_radiogroup_detectnewcsvfiles'];
        $csv2post_adm_set['admintriggers']['newcsvfiles']['display'] = $_POST['csv2post_radiogroup_detectnewcsvfiles_display'];
        
        csv2post_update_option_adminsettings($csv2post_adm_set);
        
        csv2post_notice('Please remember that some actions triggered are also triggered by the Schedule System when visitors come to your blog.
        These admin trigger settings related only to logged in administrators.','success','Large','Admin Triggered Automation Settings Saved','','echo');
        
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
* Saves basic seo options          
*/
function csv2post_form_save_advanced_seo_options(){
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
* Saves extension settings 
*/
function csv2post_form_save_extensionsettings(){
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'main' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'extensionsettings'){
  
        // save extension status
        update_option('csv2post_extensions',$_POST['csv2post_radiogroup_extensionstatus']);

        csv2post_notice('Extension settings have been saved. If you have an extension present you may need to click on another Wordpress administration screen to refresh the menu and get access to any changes.','success','Large','Extension Settings Saved','','echo');
        
        return false;
    }else{
        return true;
    }     
}    
   
/**
* Deletes table to table pairings
*/
function csv2post_form_tabletotable_delete(){
          
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'pairtablesdelete'){
         
        // if no pairs selected
        if(!isset($_POST['csv2post_pairs']) || !is_array($_POST['csv2post_pairs'])){
            csv2post_notice('You did not select a pair of tables to be deleted, please try again.','error','Large','No Pairs Deleted','','echo');
        }
        
        // get table to table array
        $table2table_array = csv2post_get_option_tabletotable_array();

        foreach($_POST['csv2post_pairs'] as $key => $pairs_array_key){
            unset($table2table_array[$pairs_array_key]);
        }

        // use array_values to return an array of our existing array but with the keys re-ordered
        $new_array = array_values($table2table_array);

        csv2post_update_option_tabletotable($new_array);               

        return false;
    }else{
        return true;
    }      
}  
  
/**
* Saves table to table column pairing configuration 
*/
function csv2post_form_tabletotable_configure(){

    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_tabletotable_configure'])){
        global $csv2post_is_free;
        
        // get table to table array
        $table2table_array = csv2post_get_option_tabletotable_array();
        
        // get destination table columns and count them, then loop that number of times
        $t2_names_array = csv2post_WP_SQL_get_tablecolumns($_POST['csv2post_t2'],true,true);
    
        // ensure we have valid result
        if(!is_array($t2_names_array) || !is_array($t2_names_array)){
            csv2post_notice('There was a problem querying the column names for your destination table
            name '.$t2.'. Please report this notice.','error','Large','Fault Detected','','echo');
            return false;
        }
        
        // ensure key column selected for premium users
        if(!$csv2post_is_free && !isset($_POST['csv2post_idcolumn'])){
            csv2post_notice('You did not select an ID/Key Column. This is required to ensure existing
            records are updated rather than risk duplicate records being created. Please
            try again.','error','Large','No ID/Key Column Selected','','echo'); 
            return false;   
        }
        
        // variable indicates if user paired the same column selected as key
        $key_matched = false;         

        // count destination columns, deduct one, the for loop needs to start at 0 not 1 because the $_POST values begin at 0 
        $t2_count = count($t2_names_array);
        $loopno = $t2_count - 1;
        
        // count number of columns paired, for use in array
        $paired = 0;

        for ($i = 0; $i <= $loopno; $i++) {
            
            // establish $_POST value for column name
            $post_column = $_POST['csv2post_table_columns_' . $_POST['csv2post_t1'] . $_POST['csv2post_arraykey'] . $i];

            // extract column name from $_POST values in form items
            $extracted_column = str_replace( $_POST['csv2post_t1'].'_', '', $post_column );

            if($extracted_column != 'notrequired'){
                
                // table to table array key for the pair being submitted is also submitted, used that to save the selections to the correct array key
                $table2table_array[ $_POST['csv2post_arraykey'] ]['columns'][ $paired ]['source'] = $extracted_column;
                $table2table_array[ $_POST['csv2post_arraykey'] ]['columns'][ $paired ]['dest'] = $_POST['csv2post_destination_column_'. $i];

                // set the ID/Key column source and destination
                if(!$csv2post_is_free && $_POST['csv2post_destination_column_'. $i] == $_POST['csv2post_idcolumn']){

                    $table2table_array[ $_POST['csv2post_arraykey'] ]['keydest'] = $_POST['csv2post_destination_column_'. $i];
                    $table2table_array[ $_POST['csv2post_arraykey'] ]['keysource'] = $extracted_column;
                    
                    // indicate user selected key column that has also been paired
                    $key_matched = true;                    
                }
                
                ++$paired;
            }
        } 

        // if $key_matched = false then user did not select a key column that has also been paired, required to ensure column is in the queries
        if(!$key_matched){
            csv2post_notice('Your ID/Key column selection is not a column you
            paired. Please pair your ID column so that the plugin knows what ID/Key value
            to compare in both tables.','error','Large','ID/Key Column Not Paired','','echo');
            return false;
        }
        ### TODO:LOWPRIORITY, ensure user has not selected the same destination column twice
                  
        csv2post_update_option_tabletotable($table2table_array);               

        csv2post_notice('Table To Table column relationships has been saved. If you want to change your selections you must
        delete the pair and re-make it.
        <p>Please scroll down to the Table Pairs panel again and complete the process by clicking on the Submit
        button which will then transfer data from your first table to your destination table based on the pairing you
        just done.</p>','success','Large','Column Relationships Saved','','echo');
        
        return false;
    }else{
        return true;
    }      
}   
  
/**
* Table to table data transfer request
* 
* @todo LOWPRIORITY, offer a setting to do use different SQL approach: 1 row queried at a time or all rows at once
* possibly add a range of approaches especially if the destination table is causing issues with data values being INSERT
* ability to transfer records with WHERE in the query (INSERT INTO TABLE2 SELECT * FROM TABLE1 WHERE COL1 = 'A')
* http://catdevblog.nickbair.net/2012/04/05/mysql-copying-column-data-between-tables/
*/
function csv2post_form_tabletotable_transfer(){

    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_tabletotable_transfer'])){
        global $wpdb,$wtgcsv_is_free;
        
        // get table to table array
        $tabletotable_array = csv2post_get_option_tabletotable_array();
        if(!isset($tabletotable_array) || !is_array($tabletotable_array)){
            csv2post_notice('A problem was detected when retrieving the Table to Table array, please report this.','error','Large','Problem Detected','','return');
            return false;    
        }   
        
        // build INSERT INTO columns (destination table columns)
        // build SELECT columns (source table columns)
        $d_columns = '';
        $s_columns = '';
        foreach($tabletotable_array[ $_POST['csv2post_arraykey'] ]['columns'] as $key => $column_set){
            
            if($d_columns != ''){
                $d_columns .= ',';
                $s_columns .= ',';            
            }
            
            $d_columns .= $column_set['dest'];
            $s_columns .= $column_set['source'];
        }
         
        // if is free use basic query with no protection, else use advanced queries
        if($wtgcsv_is_free){
            
            // this query provides no statistics or prevents duplicates. Feel free to hack it to suit your specific needs.
            // there is a wide range of queries that could be used here, contact WebTechGlobal for help writing the query.
            $query = 'INSERT 
            INTO '.$_POST["csv2post_t2"].' 
            ('.$d_columns.') 
            SELECT '.$s_columns.' 
            FROM '.$_POST['csv2post_t1'];
            // execute query transferring all data
            $wpdb->query( $query ); 
                       
        }else{
            
            // set tables
            $d_table = $tabletotable_array[ $_POST['csv2post_arraykey'] ]['t2'];
            $s_table = $tabletotable_array[ $_POST['csv2post_arraykey'] ]['t1'];

            // set the key column names
            $idcolumn_d = $tabletotable_array[ $_POST['csv2post_arraykey'] ]['keydest'];
            $idcolumn_s = $tabletotable_array[ $_POST['csv2post_arraykey'] ]['keysource'];            
               
            csv2post_WP_SQL_tabletotable_transfer_updatemethod_advanced($d_table,$s_table,$d_columns,$s_columns,$idcolumn_d,$idcolumn_s);
        }

        csv2post_notice('Table to Table process has complete.','success','Large','Table To Table Transfer Complete','','echo');
          
        return false;
    }else{
        return true;
    }      
}   

/**
* Table To Table Pairing   
*/
function csv2post_form_tabletotable_pair(){

    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'pairtables'){
        
        // if user selected the same two tables
        if(isset($_POST['wtgpt_tabletotable_tableone']) && isset($_POST['wtgpt_tabletotable_tabletwo'])
        && $_POST['wtgpt_tabletotable_tableone'] == $_POST['wtgpt_tabletotable_tabletwo']){
            csv2post_notice('You selected the same table in both menus. You must select two different tables. One
            which acts as the source of data and one where you would like data to be imported into.','error',
            'Large','Same Table Selected Twice','','echo');
            return false;    
        }
        
        // display notice for each table
        csv2post_notice('You selected table named ' . $_POST['wtgpt_tabletotable_tableone'] .' as your first table.','info','Small','Table One: ','','echo');
        csv2post_notice('You selected table named ' . $_POST['wtgpt_tabletotable_tabletwo'] .' as your second table.','info','Small','Table Two: ','','echo');
        
        // does the pair already exist
        $pair_exists = csv2post_tabletotable_does_pair_exist($_POST['wtgpt_tabletotable_tableone'],$_POST['wtgpt_tabletotable_tabletwo']);
        if($pair_exists){
            csv2post_notice('The two tables you selected are already setup as a pair. Your existing pair will have
            a panel in which you can initiate the transfer of data. Delete the existing pairing to restart the
            table to table data transfer.','warning','Large','Pairing Exists','','echo');
            return false;    
        }
        
        // add new pair to the table to table array
        csv2post_tabletotable_add_pair($_POST['wtgpt_tabletotable_tableone'],$_POST['wtgpt_tabletotable_tabletwo']);
                
        csv2post_notice('You have created a pair of tables for transferring data. A new panel will appear on the
        Table To Table screen which is your next step. Please find that panel now and complete the form in it.',
        'success','Large','Table To Table Pair Created','','echo'); 
        
        return false;
    }else{
        return true;
    }      
}  
  
/**
* Process CSV file upload      
*/
function csv2post_form_upload_csv_file(){
    global $csv2post_projectslist_array,$csv2post_schedule_array,$csv2post_plugintitle;
    
    if(isset($_POST['csv2post_post_uploadcsvfile']) && $_POST['csv2post_post_uploadcsvfile'] == true){
        
        $upload = $_FILES['file'];  

        if(!strstr($upload['name'],'.csv')){
            csv2post_notice('Sorry but '.$csv2post_plugintitle.' only accepts CSV files with .csv extension right now.','error','Large','File Extension Not Allowed','','echo');
            return false;
        }
        
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
                csv2post_notice('The name of your file being uploaded already exists in the target folder. '.$csv2post_plugintitle.' could not remove the existing file, but it should have. It may be because the existing file is in use, please investigate this then try again if required. If some sort of permissions problem is causing this, you may delete the existing file using FTP also.','error','Large','Existing File Not Removed');    
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
* Partial Un-install Plugin Options 
*/
function csv2post_form_uninstallplugin_partial(){
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'install' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'partialuninstall'){  
        global $csv2post_plugintitle;
        
        if(current_user_can('delete_plugins')){
            
            // if delete data import job tables
            if(isset($_POST['csv2post_deletejobtables_array'])){

                foreach($_POST['csv2post_deletejobtables_array'] as $k => $table_name){
                    
                    $code = str_replace('csv2post_','',$table_name);

                    // if table still in use
                    if(isset($csv2post_dataimportjobs_array[$code])){
                        
                        csv2post_notice('Table '.$table_name.' is still used by Data Import Job named '.$csv2post_dataimportjobs_array[$code]['name'].'.','error','Tiny','Cannot Delete Table','','echo');
                        return false;
                        
                    }else{
                                        
                        // drop table
                        csv2post_drop_dataimportjob_table($table_name);
                        
                        csv2post_notice('Table ' . $table_name . ' was deleted.','success','Tiny','Table Deleted','','echo'); 
                    } 
                }
            }

            // if delete csv files
            if(isset($_POST['csv2post_deletecsvfiles_array'])){
                foreach($_POST['csv2post_deletecsvfiles_array'] as $k => $csv_file_name){

                    $file_is_in_use = false;
                    $file_is_in_use = csv2post_is_csvfile_in_use($csv_file_name);
                    
                    // if file is in use
                    if($file_is_in_use){
                        csv2post_notice('The file named ' . $csv_file_name .' is in use, cannot delete.','error','Tiny','File In Use','','echo');
                    }else{
                        unlink(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_file_name); 
                        csv2post_notice( $csv_file_name .' Deleted','success','Tiny','','','echo');
                    }
                                            
                }      
            }
            
            // if delete folders
            if(isset($_POST['csv2post_deletefolders_array'])){
                foreach($_POST['csv2post_deletefolders_array'] as $k => $o){
                    // currently only have one folder so we will use a specific function   
                    $result = csv2post_delete_contentfolder(WTG_C2P_CONTENTFOLDER_DIR,false);
                    if($result){
                        csv2post_notice('Folder and its contents deleted.','success','Tiny','Folder ' . $o,'','echo');   
                    }else{
                        csv2post_notice('Folder named '.$o.' could not be deleted, it could be a permissions issue.','error','Small','Folder Not Deleted','','echo');    
                    }
                }      
            }            

            // if delete options
            if(isset($_POST['csv2post_deleteoptions_array'])){
                foreach($_POST['csv2post_deleteoptions_array'] as $k => $o){
                    delete_option($o);
                    csv2post_notice('Option record ' . $o . ' has been deleted.','success','Tiny','Option Record Deleted','','echo');    
                }      
            }
                             
        }else{
            csv2post_notice(__('You do not have the required permissions to un-install '.$csv2post_plugintitle.'. The Wordpress role required is delete_plugins, usually granted to Administrators.'), 'warning', 'Large','No Permission To Uninstall ' . $csv2post_plugintitle,'','echo');
            return false;
        }
        
        // return false to stop all further post validation function calls
        return false;// must go inside $_POST validation, not at end of function 
        
    }else{
        return true;
    } 
}
 
/**
* Advanced manual data import
*/
function csv2post_form_importdata_advanced(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_importdatarequest_advanced_postmethod']) && $_POST['csv2post_importdatarequest_advanced_postmethod'] == 'true'){
        global $csv2post_is_free;
                   
        // if job code not in $_POST
        if(!isset($_POST['csv2post_importdatarequest_jobcode']) || $_POST['csv2post_importdatarequest_jobcode'] == NULL || !is_string($_POST['csv2post_importdatarequest_jobcode'])){
            csv2post_notice('A data import job code was not found in the submitted form data, no import could be started.','error','Large','No Job Code Submitted','','echo');
            return false;
        }
        
        // put jobcode into variable to make rest of script easier 
        $job_code = $_POST['csv2post_importdatarequest_jobcode'];
        
        // use the jobcode to get the data import job_array, we will need to save ID column for starters
        $job_array = csv2post_get_dataimportjob($job_code);
        
        // if no csv file value in $_POST
        if(!isset($_POST['csv2post_importselection_csvfiles'])){
            csv2post_notice('No CSV file name could be found in the submitted post data, no import could be carried out.','error','Large','No CSV Filename Found','','echo');    
            return false;
        }
        
        // get filename (currently preparing for multiple file import at once so we are submitting an array) 
        $file_name = $_POST['csv2post_importselection_csvfiles'][0];

        // clean field name
        $file_name_cleaned = explode(".", $_POST['csv2post_importselection_csvfiles'][0]);
        
        // build the string for ID column object name and use it in $_POST[]
        // the interface must use both job_code and file_name to prevent javascript conflicts
        $id_menu_name = 'csv2post_advancedidcolumn_'.$job_code.'_'.$file_name_cleaned[0];

        // if ID column not set
        if(!isset($_POST[$id_menu_name]) || empty($_POST[$id_menu_name])){
           csv2post_notice('You have not selected the ID column for your CSV file named '.$file_name.'.
           The ID column should have unique ID data which is used to link CSV file rows with records you
           have already imported. The only other method for updating is Default Order, which does not work
           if even a single row has been added or removed from the CSV file. That methodi is not recommended.',
           'error','Large','No CSV File Header Selected','','echo');
           return false; 
        }
        
        // save the selected ID column so that we can apply it to the form
        $job_array = csv2post_get_dataimportjob($job_code);
        
        // make sure to put the submitted ID column into the selected files own node in the array
        // both the header name and the array key from the ['headers'] will come in handy     
        $job_array[$file_name]['idcolumn_header'] = $_POST[$id_menu_name];
        $job_array[$file_name]['idcolumn_key'] = csv2post_get_headers_key($_POST[$id_menu_name],$file_name,$job_code);

        // if manual progress reset requested
        if(isset($_POST['csv2post_radio_progresscontrols']) && $_POST['csv2post_radio_progresscontrols'] == 'reset'){
            // reset the all events (for all files) progress counter
            $job_array["stats"]["allevents"]['progress'] = 0;
            // loop through job files and reset progress counters per file
            foreach($job_array['files'] as $filekey => $fn){ 
                $job_array['stats'][$fn]['progress'] = 0;
                $job_array['stats'][$fn]['lastrow'] = 0;   
            }
        }

        // save job array
        csv2post_update_dataimportjob($job_array,$job_code);

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
      
        // call advanced data import function, it checks for ID values already existing in database table and does an update to existing records rather than import
        $dataimportjob_array = csv2post_data_import_from_csvfile_advanced($file_name,'csv2post_'.$job_code,$row_number,$job_code);
                                  
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
        ### TODO:HIGHPRIORITY,complete the notification pages for these notice boxes   
        csv2post_notice( '<h4>Data Import Result<h4>'.$intromes.'
        '.csv2post_notice( 'New Records: '.$dataimportjob_array["stats"]["lastevent"]['inserted'],'success','Small',false,'http://www.csv2post.com/notifications/new-records-count','return').'
        '.csv2post_notice( 'Updated Records: '.$dataimportjob_array["stats"]["lastevent"]['updated'],'success','Small',false,'http://www.csv2post.com/notifications/updated-records-count','return').'        
        '.csv2post_notice( 'Void Records: '.$dataimportjob_array["stats"]["lastevent"]['void'],'info','Small',false,'http://www.csv2post.com/notifications/void-records-counter','return').'
        '.csv2post_notice( 'Dropped Rows: '.$dataimportjob_array["stats"]["lastevent"]['dropped'],'warning','Small',false,'http://www.csv2post.com/notifications/dropped-rows-counter','return').'
        '.csv2post_notice( 'Rows Processed: '.$dataimportjob_array["stats"]["lastevent"]['processed'],'info','Small',false,'http://www.csv2post.com/notifications/rows-processed-counter','return').'     
        '.csv2post_notice( 'Job Progress: '.$dataimportjob_array["stats"]["allevents"]['progress'],'info','Small',false,'http://www.csv2post.com/notifications/job-progress-counter','return').'    
        ',$overall_result,'Extra','','','echo'); 

        return false;
    }else{
        return true;
    }     
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
* 
* @todo HIGHPRIORITY, complete this function. Add option to reverse specific groups of posts by time/date range.
*/
function csv2post_form_undo_posts(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'undopostscurrentproject'){
        global $csv2post_currentproject_code,$csv2post_project_array;

        $number_of_posts_deleted = 0;
                
        // if current project options selected but no posts made with project
        $postscreated = csv2post_does_project_have_posts($csv2post_currentproject_code);
        if(!$postscreated){
            csv2post_notice('The current project does not have any posts according to the projects main table','warning','Large','No Posts','','echo');
            return false;        
        } 
        
        // Sub-page
        // if sub-page in use and all posts are to be deleted we need to reset the stage counter
        if(isset($csv2post_project_array['subpages']['stage'])){
            $csv2post_project_array['subpages']['stage'] = 1;
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        }
            
        // delete posts
        $number_of_posts_deleted = csv2post_delete_project_posts_byrange($csv2post_currentproject_code,'currentproject');
        
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
        global $csv2post_schedule_array,$csv2post_plugintitle;
        
        // if is set constant updating for content
        if(isset($_POST['csv2post_globalpostupdatesettings_constantupdating_content'])){
            // if value is 1 then use is activing constant post content updating
            if($_POST['csv2post_globalpostupdatesettings_constantupdating_content'] == 1){
                csv2post_notice('Constant post content updating has been activated. '.$csv2post_plugintitle.' will now do more
                processing to ensure posts are updated quickly. Rather than following the schedule.',
                'success','Large','Constant Content Updating Activated','','echo');
                $csv2post_schedule_array['constantupdating']['content'] = true;    
            }else{
                // user wants constant updating off so we remove the setting to make the array as small as possible
                if(isset($csv2post_schedule_array['constantupdating']['content'])){
                    unset($csv2post_schedule_array['constantupdating']['content']);
                    csv2post_notice('Constant post content updating has been disabled. '.$csv2post_plugintitle.' will now
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
        $catfields = csv2post_WP_SQL_ultimatetaxonomymanager_taxonomyfield();### TODO:LOWPRIORITY, change this to a function that gets category related custom fields only
        if(!$catfields){
            
            echo csv2post_notice('You do not appear to have used Ultimate Taxonomy Manager to create any custom taxonomy fields yet.','info','Large','No Custom Taxonomy Fields','','return');
            return false;
            
        }else{    
          
            // loop 5 times for five levels of categories
            for($i = 1; $i < 6; $i++){
                
                // now loop through category fields
                foreach ($catfields as $catfield){

                    // did user make selection for current field and current category level
                    if(isset($_POST['csv2post_utm_categorylevel'.$i.'_'.$catfield->field_name])){
                    
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
        global $csv2post_plugintitle;
         
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
            csv2post_notice('The post ID you submitted does not belong to a post created using '.$csv2post_plugintitle.'. 
            There are advanced functions to adopt none '.$csv2post_plugintitle.' created posts that this plugin can manage them,
            please search the plugins website for more information.','info','Large','Not A '.$csv2post_plugintitle.' Post','','echo');
            return false;    
        }
        
        // get project data
        $project_array = csv2post_get_project_array($project_code);
        
        // if no project data
        if(!$project_array){
            csv2post_notice('It appears that the project data for the post you have submitted no longer exists. A
            user of '.$csv2post_plugintitle.' must have deleted the project that created the post. Updating cannot be done by
            '.$csv2post_plugintitle.' in this way. You may be able to use another project to adopt the post if the posts
            data is still stored in the original project database table.','info','Large','No Project Data','','echo');
            return false;
        }
        
        // if projects maintable value not set
        if(!isset($project_array['maintable'])){
            csv2post_notice('Your projects main database table value could not be found. Without it there is no
            way to determine what database table holds the record used to create your post with ID '.$_POST['csv2post_update_post_with_id'].'.
            Please report this event.','success','Large','Database Table Unknown','','echo');
            return false;    
        }
        
        // if maintable does not exist
        if(!csv2post_WP_SQL_does_table_exist($project_array['maintable'])){
            csv2post_notice('Your projects main database table does not seem to exist anymore. Is it possible
            that you have deleted it? The table would hold the record used to create your post, without it
            no update can be performed.
            
            <p>If this poses a great problem for you please seek support from WebTechGlobal. You may need a solution
            to fix this situation you have arrived at. Sending your feedback to us helps us understand users needs
            and how the plugin is being used. If you deleted the table by accident, do you remember why you deleted
            the table? Knowing the answers helps us to come up with safe guards and features that may be better use
            to users.</p>','success','Large','Project Table No Longer Exists','','echo');
            return false;
        }

        // get the posts project record for further validation only
        $post_record = csv2post_WP_SQL_get_posts_record($project_array['maintable'],$_POST['csv2post_update_post_with_id']);

        if(!$post_record){
            csv2post_notice('The record that was used to create your post no longer exists in the project database table.','error','Large','Record No Longer Exists','','echo');
            return false;
        }
        
        // if record id held in post does not retrieve a record (this confirms both record id in post is right and exists)
        $record_id = get_post_meta($_POST['csv2post_update_post_with_id'], 'csv2post_record_id', true); 
        if($record_id == false){
            csv2post_notice('The giving post does not have its record ID stored in meta. '.$csv2post_plugintitle.' stores the
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
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createallcategories'){
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
* Deletes random advanced shortcode rules
*/
function csv2post_form_delete_randomadvanced_shortcoderules(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deleterandomvalueshortcodes'){
        
        if(isset($_POST['csv2post_shortcodeadvanced_delete'])){
            global $csv2post_textspin_array;
            if(is_array($_POST['csv2post_shortcodeadvanced_delete'])){
                foreach($_POST['csv2post_shortcodeadvanced_delete'] as $key => $shortcode_name){
                    if(isset($csv2post_textspin_array['spinners'][ $shortcode_name ])){
                        unset($csv2post_textspin_array['spinners'][ $shortcode_name ]);
                    }        
                }
                csv2post_update_option_textspin($csv2post_textspin_array);
                csv2post_notice('All selected advanced random value shortcode rules have been deleted.','success','Large','Shortcode Rules Deleted','','echo');
                return false;    
            }else{
                if(isset($csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodeadvanced_delete'] ])){
                    unset($csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodeadvanced_delete'] ]);
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
* Saves Multiple File Project panel - the configuration options that create relationships between tables
*/
function csv2post_form_save_multiplefilesproject(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'multipletableproject'){
        global $csv2post_project_array,$csv2post_currentproject_code,$csv2post_plugintitle;
        
        // ensure there are not to many "notrequired" values submitted
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
        If done properly the relationship setup should allow '.$csv2post_plugintitle.' to query records 
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
        global $csv2post_project_array,$csv2post_currentproject_code,$csv2post_plugintitle;
      
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
        
        csv2post_notice('Tag generator settings have been saved and '.$csv2post_plugintitle.' will generator tags from your selected columns for all posts.','success','Large','Tag Generator Settings Saved','','echo');
        
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
                    
                    csv2post_drop_dataimportjob_table($table_name); 
                                            
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
* Save drip feed limits  
*/
function csv2post_form_save_schedulelimits(){
    global $csv2post_projectslist_array,$csv2post_schedule_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'schedulelimits'){

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
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'scheduletimes'){

        // ensure $csv2post_schedule_array is an array, it may be boolean false if schedule has never been set
        if(isset($csv2post_schedule_array) && is_array($csv2post_schedule_array)){
            
            // if times array exists, unset the [times] array
            if(isset($csv2post_schedule_array['days'])){
                unset($csv2post_schedule_array['days']);    
            }
            
            // if hours array exists, unset the [hours] array
            if(isset($csv2post_schedule_array['hours'])){
                unset($csv2post_schedule_array['hours']);    
            }
            
        }else{
            
            // $schedule_array value is not array, this is first time it is being set
            $csv2post_schedule_array = array();
        }
        
        // loop through all days and set each one to true or false
        if(isset($_POST['csv2post_scheduleday_list'])){

            foreach($_POST['csv2post_scheduleday_list'] as $key => $submitted_day){
                $csv2post_schedule_array['days'][$submitted_day] = true;        
            }
               
        } 
        
        // loop through all hours and add each one to the array, any not in array will not be permitted                              
        if(isset($_POST['csv2post_schedulehour_list'])){
            
            foreach($_POST['csv2post_schedulehour_list'] as $key => $submitted_hour){
                $csv2post_schedule_array['hours'][$submitted_hour] = true;        
            }            
            
        }    

        csv2post_update_option_schedule_array($csv2post_schedule_array);
        
        csv2post_notice('Your permitted days and hours for the automation scheduled have been saved.','success','Large','Schedule Times Saved');

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
            foreach( $csv2post_projectslist_array as $project_code => $project ){
                if($project_code != 'arrayinfo'){ 
                    $csv2post_projectslist_array[$project_code]['dripfeeding'] = 'off';
                }
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

        // switch activates for updating via the schedule
        $csv2post_project_array['updating']['content']['settings']['switch'] = $_POST['csv2post_updatesettings_postupdating_switch_inputname'];
        // public actives for updating when a public visitor opens the post
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
            
            if($csv2post_project_array['defaultposttype'] == 'page'){
                csv2post_notice_postresult('info','New Panel Available','A new panel is available 
                on the Post Types screen to you for creating sub-pages.');
            }
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
        $template_id = csv2post_PHP_STRINGS_get_between_two_values('(',')',$_POST['csv2post_templatename_and_id']);        

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
        $template_id = csv2post_PHP_STRINGS_get_between_two_values('(',')',$_POST['csv2post_templatename_and_id']);        

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

function csv2post_form_change_default_excerpttemplate(){
    global $csv2post_currentproject_code;
    if(isset($_POST['csv2post_change_default_excerpttemplate']) && isset($_POST['csv2post_change_default_excerpttemplate'])){
  
        // extract template id from string
        $template_id = csv2post_PHP_STRINGS_get_between_two_values('(',')',$_POST['csv2post_templatename_and_id']);        

        if(!is_numeric($template_id)){
            csv2post_notice('The excerpt template ID could not be extracted from the submission, please try again then report this issue.','error','Large','Error Saving Default Excerpt Template');
        }else{
            csv2post_update_default_excerpttemplate($csv2post_currentproject_code,$template_id);
            csv2post_notice('The excerpt template you selected has been saved as your current projects default excerpt template design.','success','Large','Default Excerpt Template Saved');
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
    global $csv2post_currentproject_code;// TODO ADD THIS TO POST IN CUSTOM FIELD
    
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
                  
            $wpinsertpost_result = csv2post_insert_post_contenttemplate($_POST['csv2post_wysiwyg_editor'],$_POST['csv2post_templatename']);// returns post ID
              
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
        global $csv2post_is_free,$csv2post_plugintitle;
        
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
                    csv2post_notice('You did not enter your CSV file column/field number. '.$csv2post_plugintitle.' will attempt to 
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

                // add established file group type to the array (no use for it as I add it but adding it just in case)                
                $jobarray['filegrouping'] = $job_file_group;
                                   
                // count files, counter acts as file id within the job array, it is also appended to column names 
                $fileid = 1;
                 
                // add each csv file to the jobarray
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
                    
                    // in free edition we automatically delete the existing csv2post_freeproject table
                    csv2post_drop_dataimportjob_table('csv2post_freeproject');
                    
                    // create a database table - multiple file jobs are put into a single table, column names are giving appended values to prevent conflict with shared names    
                    $createtable_result = csv2post_WP_SQL_create_dataimportjob_table($code,$job_file_group);

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
        
        // undo changes that were made to the blog despite an overall fail
        ### TODO:MEDIUMPRIORITY, remove database table and job entry to the job array if an overall failure is reached
        
        // display result
        csv2post_notice('<h4>Create New Data Import Job Result</h4>' . $initialnotice . $extendednotice);

        if($functionoutcome){
            if($csv2post_is_free){
                csv2post_notice('You should now click on the Basic Import screen and begin importing your data.','step','Large','Next Step',false,'echo');    
            }else{
                csv2post_notice('You should now click on the Advanced Import screen and begin importing your data manually or
                configure the plugins Schedule Settings to import data automatically.','step','Large','Next Step',false,'echo');                
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
* Log File Installation Post Validation
*/
function csv2post_form_logfileinstallation(){
    if(isset($_POST[WTG_C2P_ABB.'createlogfile'])){

        $logfileexists_result = csv2post_logfile_exists($_POST[WTG_C2P_ABB.'logtype']);
        if($logfileexists_result){
            csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file already exists, no changes have been made to your blog.'),'info','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Exists');
        }else{
             $createlogfile_result = csv2post_create_logfile($_POST[WTG_C2P_ABB.'logtype']);
             if($createlogfile_result){
                
                 csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file was created, please now ensure logging for this file is active.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Created');

                // also activate log file
                csv2post_activate_logfile($_POST[WTG_C2P_ABB.'logtype']);
                csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file has been activated.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Activated');
                                      
             }else{
                csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log could not be created, please check the plugins FAQ for help on what to do next.'),'error','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Creation Failed');              
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
    if(isset($_POST['csv2post_deletelogfile'])){ 
        
        // check if log file exists
        $logfileexists_result = csv2post_logfile_exists($_POST[WTG_C2P_ABB.'logtype']);
        
        if(!$logfileexists_result){  
            csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file could not be located, no changes have been made.'),'info','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Not Found');
        }else{
            
             $deletelogfile_result = csv2post_delete_logfile($_POST['csv2post_logtype']);
                                     
             if($deletelogfile_result){
                
                // disable the log file in settings
                csv2post_disable_logfile($_POST[WTG_C2P_ABB.'logtype']);
             
                csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file was deleted, please now ensure logging for this file is disabled or it may be re-created.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Removed');
             
             }else{
                csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log could not be deleted, reason unknown. Please try again, ensure the log exists then seek support.'),'error','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Not Removed');
             }
        } 

       return false;// return false to stop all further post validation function calls         
    }else{
        return true;
    } 
}

/**
* Disable Log File
*/
function csv2post_form_disablelogfile(){
    if(isset($_POST[WTG_C2P_ABB.'disablelogfile'])){
        $logfile_result = csv2post_disable_logfile($_POST[WTG_C2P_ABB.'logtype']);
        if($logfile_result){
            csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file has been Disabled.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Disabled');
        }
       return false;// return false to stop all further post validation function calls        
    }else{
        return true;
    } 
}

/**
* Activate Log File Post Validation
*/
function csv2post_form_activatelogfile(){
    if(isset($_POST[WTG_C2P_ABB.'activatelogfile'])){
        csv2post_activate_logfile($_POST[WTG_C2P_ABB.'logtype']);
        csv2post_notice(__('The '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' log file has been activated.'),'success','Extra',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File Activated');
        return false;         
    }else{
        return true;
    } 
}

/**
* View Log File Post Validation
*/
function csv2post_form_viewlogfile(){
    if(isset($_POST[WTG_C2P_ABB.'viewlogfile'])){?> 
        <div id="<?php echo WTG_C2P_ABB;?>dialogoutcome" title="<?php ucfirst($_POST[WTG_C2P_ABB.'logtype']);?> Log File Activated">
            <?php 
            csv2post_notice(__('the '.$_POST[WTG_C2P_ABB.'logtype'].' log file has been retrieved and displayed below.'),'success','Small',ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log: ');
            
            // create array of key words to filter entries from the general log
            $install_filter_array = array();
            $install_filter_array['logfile'] = $_POST[WTG_C2P_ABB.'logtype'];// use logfile to open specific log file
            $install_filter_array['action'] = 'install';// use this action for uninstall,reinstall etc
            $install_filter_array['priority'] = 'all';// all (default),low,high,critical
            // add panel details to array, used for forms in notices       
            $install_filter_array['panel_title'] = 'View '.ucfirst($_POST[WTG_C2P_ABB.'logtype']).' Log File';            
            $install_filter_array['panel_name'] = WTG_C2P_ABB.'postsubmit_viewlogfile';
            $install_filter_array['panel_number'] = '1';  
                                                 
            csv2post_viewhistory($install_filter_array); ?>
        </div><?php
        csv2post_jquerydialog_results();  
        
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
        global $csv2post_plugintitle;
        
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
        
        // add $_POST values to email template
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

                        // do SOAP call to WebTechGlobal Ticket Web Service and create ticket
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
        
        <p>Sent from ' . $csv2post_plugintitle .'</p>
        
        <p><strong>Reason:</strong> ' . $csv2post_plugintitle .'</p>   
            
        <p><strong>Priority:</strong> unknown tbc @todo</p>

        <h3>Description</h3>
        <p>DESCRIPTION HERE</p>';
        
        // add further details depending on the reason for contact and fields completed
        ### @todo LOW PRIORITY complete email layout
        $emailmessage_middle = '';
              
        $emailmessage_end = '</body></html>';    
     
        $finalemailmessage = $emailmessage_start . $emailmessage_middle . $emailmessage_end;
        
        wp_mail('help@csv2post.com','Contact From '.$csv2post_plugintitle,$emailmessage); 
        
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

            $tabscreen_name = $csv2post_mpt_arr['menu'][ $_POST[WTG_C2P_ABB . 'hidden_pageid'] ]['tabs'][ $_POST[WTG_C2P_ABB . 'hidden_tabnumber'] ]['label'];
            
            $tabscreen_pagename = $csv2post_mpt_arr['menu'][ $_POST[WTG_C2P_ABB . 'hidden_pageid'] ]['menu'];             

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
        foreach($csv2post_mpt_arr['menu'] as $pageid => $pagearray){

            $tabcounter = 0;

            foreach($pagearray['tabs'] as $tab){

                if( isset($_POST['radio_'.$tab['slug']] )){
                 
                    if( $_POST['radio_'.$tab['slug']] == $tab['slug'].'_show' ){
                        
                        $csv2post_mpt_arr['menu'][ $pageid ]['tabs'][ $tabcounter ]['display'] = true;
                                 
                    }elseif($_POST['radio_'.$tab['slug']] == $tab['slug'].'_hide'){
                        
                        $csv2post_mpt_arr['menu'][ $pageid ]['tabs'][ $tabcounter ]['display'] = false;                        
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
        global $csv2post_plugintitle;
        
        $themeupdate_result = update_option(WTG_C2P_ABB.'theme',$_POST['radio']);?>
        
        <div id="<?php echo WTG_C2P_ABB;?>dialogoutcome" title="Theme Changed">
        <?php  csv2post_notice(__('Your new theme selection for '.$csv2post_plugintitle.' will take effect when you refresh the page.'),'success','Extra','Plugin Theme Changed');?>
        </div><?php
        csv2post_jquerydialog_results();    
        
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
 * @todo is this function a duplicate and should it not be in the core file (installation file is being deleted)
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
    csv2post_jquerydialog_results();?>
    <div id="<?php echo WTG_C2P_ABB;?>dialogoutcome" title="Outcome For <?php echo $_POST[WTG_C2P_ABB.'hidden_panel_title'];?>">
        <?php //  ######   @todo    $reinstall_result = ;//?>
    </div><?php
}

/**
 * Processes FULL Reinstalls of the plugin, does output (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function csv2post_process_full_reinstall(){    
    csv2post_jquerydialog_results();?>
    <div id="<?php echo WTG_C2P_ABB;?>dialogoutcome" title="Outcome For <?php echo $_POST[WTG_C2P_ABB.'hidden_panel_title'];?>">
        <?php //  ######   @todo    $reinstall_result = ;//?>
    </div><?php
}

/**
 * Processes FREE Uninstalls the plugin, does output  (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function csv2post_process_free_uninstall(){            
    csv2post_jquerydialog_results(csv2post_link_toadmin(WTG_C2P_ABB.'install'),'Click Here');?>
    <div id="<?php echo WTG_C2P_ABB;?>dialogoutcome" title="Outcome For <?php echo $_POST[WTG_C2P_ABB.'hidden_panel_title'];?>">
        <?php csv2post_uninstall();?>
    </div><?php
}

/**
 * Processes Uninstalls the plugin, does output  (submitted form has optional checkbox inputs to include or exclude specific parts)
 */
function csv2post_process_full_uninstall(){           
    csv2post_jquerydialog_results(csv2post_link_toadmin(WTG_C2P_ABB.'install'),'Click Here');?>
    <div id="csv2post_dialogoutcome" title="Outcome For <?php echo $_POST[WTG_C2P_ABB.'hidden_panel_title'];?>">
        <?php csv2post_uninstall();?>
    </div><?php
}

/**
* Reset Easy CSV Importer session array 
*/
function csv2post_form_reseteci(){
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'main' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'ecireset'){

        csv2post_INSTALL_ecisession();
        
        csv2post_notice_postresult('success','Easy CSV Importer Reset','You can now start with Step One of the Easy CSV Importer system.');
        
        return false;
    }else{
        return true;
    }     
}  

function csv2post_form_plugin_update(){
    if(isset( $_POST['csv2post_plugin_update_now'] ) && $_POST['csv2post_plugin_update_now'] == 'a43bt7695c34'){

        // re-install tab menu
        csv2post_INSTALL_tabmenu_settings();    
        // re-install admin settings
        csv2post_INSTALL_admin_settings();
        
        // update locally stored version number
        global $csv2post_currentversion;
        update_option('csv2post_installedversion',$csv2post_currentversion);        
        update_option('csv2post_installeddate',time()); 

        csv2post_notice_postresult('success','Plugin Update Complete','Please have a browse over all of the
        plugins screens, ensure key settings are as you need them and where applicable check the front-end of 
        your blog to ensure nothing has gone wrong.');

        return false;
    }else{
        return true;
    }     
}   



/**
* Install Plugin - initial post submission validation  
*/
function csv2post_form_installplugin(){   
    if(isset( $_POST['csv2post_plugin_install_now'] ) && $_POST['csv2post_plugin_install_now'] == 'z3sx4bhik970'){
        global $csv2post_plugintitle;
        
        if(!current_user_can('activate_plugins')){
            csv2post_notice(__('You do not have the required permissions to activate '.$csv2post_plugintitle.'. 
            The Wordpress role required is activate_plugins, usually granted to Administrators. Please
            contact your Web Master or contact info@csv2post.com if you feel this is a fault.'), 'warning', 'Large', false);
        }else{                  
            csv2post_install();                
        }
        
        return false;
    }else{
        return true;
    }       
}   

/**
* Save a new HTML shortcode - this one offers a shortcode showing shortcode name (no need for user to enter values in shortcode)
* 1. Ignore ['spinners'], both cycled and random is in this node for now
*/
function csv2post_form_save_textspinner(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createrandomvalueshortcodes'){
        
        // error if name not entered
        if(!isset($_POST['csv2post_shortcodename']) || $_POST['csv2post_shortcodename'] == '' || $_POST['csv2post_shortcodename'] == ' '){
            csv2post_notice('You did not enter a spinner name, please enter a name that will help you remember what values you have setup.','error','Large','No Shortcode Name Submitted','','echo',false);    
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
        
        // no reason to return, now get required globals
        global $csv2post_textspin_array,$csv2post_adm_set; 
        
        // if name already exists
        if(isset($csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ])){
            csv2post_notice('The shortcode name you submitted already exists, please use a different name or delete the existing shortcode.','warning','Large','Shortcode Name Exists Already','','echo');
            return false;
        }
                
        // cant assume user filled out text fields in order so go through all of them
        for ($i = 1; $i <= 8; $i++) {
            if(isset($_POST['csv2post_textspin_v' . $i]) && $_POST['csv2post_textspin_v' . $i] != NULL && $_POST['csv2post_textspin_v' . $i] != ''){
                // dont use for loop $i as key because some values may not be set
                $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['values'][] = $_POST['csv2post_textspin_v' . $i];   
            }
        } 
        
        // is a cycle wanted for this spinner rather than randomising
        $cycle = false;
        if(isset($_POST['csv2post_radio_spinnercycleswitch']) && $_POST['csv2post_radio_spinnercycleswitch'] == 'on'){
            $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['cycle']['status'] = true;
        }
        
        // get the spinners delay range
        $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay'] = false;
        $min = 0;
        $max = 0;
        $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay']['min'] = 0;
        $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay']['max'] = 0;        
        if(isset($_POST['csv2post_increment_range_spinnerdelay'])){
            $removed_spaces = str_replace(' ','',$_POST['csv2post_increment_range_spinnerdelay']);
            $range_array = explode('-',$removed_spaces);

            $min = $range_array[0];
            $max = $range_array[1];
            
            // if the values are zero we do not monitor delay, avoiding a meta value being created per post
            if($min == 0 && $max == 0){
                $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay']['status'] = false;
                $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay']['min'] = 0;
                $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay']['max'] = 0;    
            }else{
                $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay']['status'] = true;
                $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay']['min'] = $min;
                $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['delay']['max'] = $max;
            }  
        }
        
        // save spinner re-spin switch
        if(isset($_POST['csv2post_radio_spinner_tokenrespinswitch']) && $_POST['csv2post_radio_spinner_tokenrespinswitch'] == 'yes'){
            
            // set this spinner for respinning as a token, when the post filter is run this will be checked per spinner
            // as some spinners may required re-spin and some may not
            $csv2post_textspin_array['spinners'][ $_POST['csv2post_shortcodename'] ]['respintokens'] = true;

            // activate post parsing status to true and also set token respin to true
            if(isset($csv2post_adm_set['postfilter']['tokenrespin']) && $csv2post_adm_set['postfilter']['tokenrespin'] != true
            || isset($csv2post_adm_set['postfilter']['status']) && $csv2post_adm_set['postfilter']['status'] != true){
                $csv2post_adm_set['postfilter']['tokenrespin'] = true;// activates global setting to include token respin procedure in the post filter function
                $csv2post_adm_set['postfilter']['status'] = true;// activates the post filter itself which runs various procedures if setup
                csv2post_notice_postresult('success','Public Triggered Automation Updated','You can
                find the settings for Public Triggered Automation on the General Settings screen. They have
                been updated to allow your Spinner Token to be re-spun whenever a post is opened. Delay and
                cycle will be taking into consideration if in use.');                  
            }
            
            csv2post_update_option_adminsettings($csv2post_adm_set);
        }
                        
        csv2post_update_option_textspin($csv2post_textspin_array);      

        csv2post_notice('You saved a new spinner named ' . $_POST['csv2post_shortcodename'] . '. You
        can use this shortcode by copying and pasting this bold text: <br />
        <strong>[csv2post_spinner_advanced name="'.$_POST['csv2post_shortcodename'].'"]</strong>','success','Large','Spinner Settings Saved','','echo');

        return false;
    }else{
        return true;
    }       
} 

/**
* Create a data rule for replacing specific values after import 
*/
function csv2post_form_save_eventtypes(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'eventtypes'){
        global $csv2post_schedule_array;   

        $csv2post_schedule_array['eventtypes']["postcreation"]['switch'] = $_POST["csv2post_eventtype_postcreation"];
        $csv2post_schedule_array['eventtypes']["postupdate"]['switch'] = $_POST["csv2post_eventtype_postupdate"];
        $csv2post_schedule_array['eventtypes']["dataimport"]['switch'] = $_POST["csv2post_eventtype_dataimport"];
        $csv2post_schedule_array['eventtypes']["dataupdate"]['switch'] = $_POST["csv2post_eventtype_dataupdate"];
        $csv2post_schedule_array['eventtypes']["twittersend"]['switch'] = $_POST["csv2post_eventtype_twittersend"];
        $csv2post_schedule_array['eventtypes']["twitterupdate"]['switch'] = $_POST["csv2post_eventtype_twitterupdate"];
        $csv2post_schedule_array['eventtypes']["twitterget"]['switch'] = $_POST["csv2post_eventtypes_twitterget"];

        csv2post_update_option_schedule_array($csv2post_schedule_array);
        
        csv2post_notice('Schedule event types have been saved, the changes will have an effect on the types of events run, straight away.','success','Large','Schedule Event Types Saved','','echo');
        return false;
    }else{
        return true;
    }          
}    

// Save public triggered automation settings
function csv2post_form_save_public_triggered_automaton(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'admintriggeredautomation'){
        
        global $csv2post_adm_set;

        $csv2post_adm_set['postfilter']['status'] = $_POST['csv2post_radiogroup_postfilter'];          
        $csv2post_adm_set['postfilter']['tokenrespin']['status'] = $_POST['csv2post_radiogroup_spinnertokenrespin'];
     
        csv2post_update_option_adminsettings($csv2post_adm_set);
        
        csv2post_notice('Your public triggered automation settings have been saved. We recommend that your
        monitor your blog for sometime and ensuring you are happy with performance.',
        'success','Large','Public Triggered Automation Settings Saved','','echo');
        
        return false;
    }else{
        return true;
    }     
}  
                        
/**
* Save sub-page by permalinks
* 
* @todo LOWPRIORITY, prevent user selecting the same column twice
*/
function csv2post_form_subpage_bypermalinks(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'subpagesbypermalinks'){
        
        global $csv2post_project_array,$csv2post_currentproject_code;

        if($_POST['csv2post_subpage_permalinks_radio'] == 'off'){
            
            $csv2post_project_array['subpages']['status'] = false;

            csv2post_notice_postresult('success','Sub-page Grouping Method Disabled','Your post creation
            will not create sub-pages at all. This action disables all methods. Please submit a sub-page
            settings form if you still wish to create sub-pages.'); 
                        
        }else{
      
            $csv2post_project_array['subpages']['levelcolumn']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bypermalinks_level']);
            $csv2post_project_array['subpages']['levelcolumn']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bypermalinks_level']);            
                    
            $csv2post_project_array['subpages']['slugscolumn']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bypermalinks_slug']);
            $csv2post_project_array['subpages']['slugscolumn']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bypermalinks_slug']);            

            // is another method active? If so make user aware that it will be deactivated as only one method can run at a time
            if(isset($csv2post_project_array['subpages']['status']) && $csv2post_project_array['subpages']['status'] == true){
                if(isset($csv2post_project_array['subpages']['method']) && $csv2post_project_array['subpages']['method'] != 'permalinks'){
                    csv2post_notice_postresult('warning','Sub-page Method Changed',
                    'You already had a sub-page method active but only one method can be used at a time. The
                    settings saved for your other submitted method will not be used. The grouping method
                    will now be used for your current project.');    
                }
            }

            $csv2post_project_array['subpages']['status'] = true;
            $csv2post_project_array['subpages']['method'] = 'permalinks';
            $csv2post_project_array['subpages']['stage'] = 1;// this is increased per stage and used to determine what level of pages is to be created
            
            csv2post_notice_postresult('success','Sub-page Grouping Method Activated','Your post creation
            will setup sub-pages providing your data is suitable for the permalink method.');            
        }

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);            
                        
        return false;
    }else{
        return true;
    }     
} 

/**
* save sub-page by grouping
* NOT IN USE YET
*/
function csv2post_form_subpage_bygrouping(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'subpagesbygroupingtwocolumn'){

        global $csv2post_project_array,$csv2post_currentproject_code;
                          
        $table_name1 = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bygrouping_parent']);
        $column_name1 = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bygrouping_parent']);            
                
        $table_name2 = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bygrouping_sub1']);
        $column_name2 = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bygrouping_sub1']);            
                     
        if(isset($_POST['csv2post_subpages_bygrouping_sub2']) && $_POST['csv2post_subpages_bygrouping_sub2'] != 'noselectionmade'){
            $table_name3 = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bygrouping_sub2']);
            $column_name3 = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bygrouping_sub2']);            
        }
        
        // is another method active? If so make user aware that it will be deactivated as only one method can run at a time
        if(isset($csv2post_project_array['subpages']['status']) && $csv2post_project_array['subpages']['status'] == true){
            if(isset($csv2post_project_array['subpages']['method']) && $csv2post_project_array['subpages']['method'] != 'grouping'){
                csv2post_notice_postresult('warning','Sub-page Method Changed',
                'You already had a sub-page method active but only one method can be used at a time. The
                settings saved for your other submitted method will not be used. The grouping method
                will now be used for your current project.');    
            }
        }

        $csv2post_project_array['subpages']['status'] = true;
        $csv2post_project_array['subpages']['method'] = 'grouping';
        $csv2post_project_array['subpages']['stage'] = 1;// this is increased per stage and used to determine what level of pages is to be created           
        $csv2post_project_array['subpages']['slugscolumn']['table'] = 'grouping';
        $csv2post_project_array['subpages']['slugscolumn']['column'] = 'grouping';
        $csv2post_project_array['subpages']['subone']['table'] = $table_name1;
        $csv2post_project_array['subpages']['subone']['column'] = $column_name1;
        $csv2post_project_array['subpages']['subtwo']['table'] = $table_name2;
        $csv2post_project_array['subpages']['subtwo']['column'] = $column_name2;        
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 
        
        csv2post_notice_postresult('success','Sub-page Grouping Method Activated','Your post creation
        will setup sub-pages providing your data is suitable for the grouping method.');
        
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
            return false;
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
    
                    csv2post_WP_SQL_reset_project_table($_POST['csv2post_databasetables_resettable_array'],$reset_posts);
                    csv2post_notice('The table named '.$_POST['csv2post_databasetables_resettable_array'].' was reset as requested.','success','Large','Table Reset','','echo');                    
                
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
                        
                        csv2post_WP_SQL_reset_project_record($table_name,$reset_posts);
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
* Process post creation for giving project 
*/
function csv2post_form_start_post_creation(){
    global $csv2post_projectslist_array,$csv2post_schedule_array,$csv2post_is_free,$csv2post_project_array,$csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_post_creation_request'])){
        
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
    
        // subpages
        $subpagelevel = false;
        if(isset($csv2post_project_array['subpages']['status'] ) && $csv2post_project_array['subpages']['status'] == true
        && isset($csv2post_project_array['subpages']['stage']) && is_numeric($csv2post_project_array['subpages']['stage'])){
            $subpagelevel = $csv2post_project_array['subpages']['stage'];    
        }
        
        // call create posts function     
        $post_id = csv2post_create_posts($_POST['csv2post_project_code'],$target_posts,'manual',$subpagelevel);
        if($post_id){
            
            // no false returned (false indicates a failure)
            // $post_id will be the last post ID created
            csv2post_notice('Post creation went smoothly, no problems were detected. The last post ID created was <strong>'.$post_id.'</strong>.','success','Large','Post Creation Complete','','echo');
            ### TODO:LOWPRIORITY, add link and url to last created post to the output
                
        }else{
           // must be a failure, if multiple posts were requests the failure is big enough to output it to the user
           csv2post_notice('No post ID was returned during post creation. This is usually because all 
           records have been used to create posts and the project is finished. This warning is simply 
           to recommend that you confirm all records used or report a discrepancy.','warning','Small',
           'Projects Post Creation Complete','','echo');
        }
         
        return false;
    }else{
        return true;
    }      
}                    

/**
* Activate or disable text spinning 
*/
function csv2post_form_textspinning_switch(){
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'projects' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'textspinningswitch'){
        global $csv2post_textspin_array,$csv2post_adm_set;

        if(isset($csv2post_textspin_array['settings']['status']) && $csv2post_textspin_array['settings']['status'] == true){
            $csv2post_textspin_array['settings']['status'] = false;
            csv2post_notice_postresult('success','Text Spin Features On','You have activated
            text spin features. It will put all post content through more processing during post creation
            and display more accordion panels.');       
        }else{
            $csv2post_textspin_array['settings']['status'] = true;
            csv2post_notice_postresult('success','Text Spin Features Off','You have disabled
            text spin features. This will reduce processing during post creation and hide options.
            However at does not disable shortcodes already in use.');              
        }
        
        csv2post_update_option_textspin($csv2post_textspin_array);        
        
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
        $required_column_level = false;// change to level 1,2,3 or 4 to indicate which column has not been selected but should be
        
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
            
            // apply depth
            $csv2post_project_array['categories']['applydepth'] = $_POST['csv2post_categorisationlevel_basic'];
            
            // add level 1 
            $csv2post_project_array['categories']['level1']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel1_select_columnandtable']);
            $csv2post_project_array['categories']['level1']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel1_select_columnandtable']);            

            // add level 2
            if($_POST['csv2post_categorylevel2_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level2']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel2_select_columnandtable']);
                $csv2post_project_array['categories']['level2']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel2_select_columnandtable']);                     
            }elseif(isset($csv2post_project_array['categories']['level2']) && $_POST['csv2post_categorylevel2_select_columnandtable'] == 'notselected'){
                unset($csv2post_project_array['categories']['level2']);            
            }
            
            // add level 3
            if($_POST['csv2post_categorylevel3_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level3']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel3_select_columnandtable']);
                $csv2post_project_array['categories']['level3']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel3_select_columnandtable']);                     
            }elseif(isset($csv2post_project_array['categories']['level3']) && $_POST['csv2post_categorylevel3_select_columnandtable'] == 'notselected'){
                unset($csv2post_project_array['categories']['level3']);           
            }                

            // add level 4
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel4_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level4']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel4_select_columnandtable']);
                $csv2post_project_array['categories']['level4']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel4_select_columnandtable']);                     
            }elseif(isset($csv2post_project_array['categories']['level4']) && $_POST['csv2post_categorylevel4_select_columnandtable'] == 'notselected'){
                unset($csv2post_project_array['categories']['level4']);           
            }
            
            // add level 5
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel5_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level5']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel5_select_columnandtable']);
                $csv2post_project_array['categories']['level5']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel5_select_columnandtable']);                     
            }elseif(isset($csv2post_project_array['categories']['level5']) && $_POST['csv2post_categorylevel5_select_columnandtable'] == 'notselected'){
                unset($csv2post_project_array['categories']['level5']);            
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
* Saves advanced category submission 
*/
function csv2post_form_save_categories_advanced(){
    global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'advancedcategories'){
        
        // ensure the previous column has been selected for every column user submits
        $required_column_missing = false;// set to true if a required column has not been selected
        $required_column_level = false;// change to level 1,2,3 or 4 to indicate which column has not been selected but should be
        
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
            
            // apply depth
            $csv2post_project_array['categories']['applydepth'] = $_POST['csv2post_categorisationlevel_adv'];
                        
            // add level 1 
            $csv2post_project_array['categories']['level1']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel1_advanced']);
            $csv2post_project_array['categories']['level1']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel1_advanced']);            

            // save level 1 description template id if selected
            if( $_POST['csv2post_categorylevel1_description'] != 'notselected' ){
                $csv2post_project_array['categories']['level1']['description'] = $_POST['csv2post_categorylevel1_advanced'];        
            }elseif(isset($_POST['csv2post_categorylevel1_descriptioncolumn_advanced'])){
                $csv2post_project_array['categories']['level1']['descriptioncolumn'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel1_descriptioncolumn_advanced']);
                $csv2post_project_array['categories']['level1']['descriptiontable'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel1_descriptioncolumn_advanced']);    
            }
  
            // add level 2
            if($_POST['csv2post_categorylevel2_advanced'] != 'notselected'){
                $csv2post_project_array['categories']['level2']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel2_advanced']);
                $csv2post_project_array['categories']['level2']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel2_advanced']);                     
            
                // save level 2 description template id if selected
                if($_POST['csv2post_categorylevel2_description'] != 'notselected'){
                    $csv2post_project_array['categories']['level2']['description'] = $_POST['csv2post_categorylevel2_advanced'];        
                }elseif(isset($_POST['csv2post_categorylevel2_descriptioncolumn_advanced'])){
                    $csv2post_project_array['categories']['level2']['descriptioncolumn'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel2_descriptioncolumn_advanced']);
                    $csv2post_project_array['categories']['level2']['descriptiontable'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel2_descriptioncolumn_advanced']);    
                }    
                        
            }elseif(isset($csv2post_project_array['categories']['level2']) && $_POST['csv2post_categorylevel2_advanced'] == 'notselected'){
                unset($csv2post_project_array['categories']['level2']);            
            }
            
            // add level 3
            if($_POST['csv2post_categorylevel3_advanced'] != 'notselected'){
                $csv2post_project_array['categories']['level3']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel3_advanced']);
                $csv2post_project_array['categories']['level3']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel3_advanced']);                     
            
                // save level 3 description template id if selected
                if($_POST['csv2post_categorylevel3_description'] != 'notselected'){
                    $csv2post_project_array['categories']['level3']['description'] = $_POST['csv2post_categorylevel3_advanced'];        
                }elseif(isset($_POST['csv2post_categorylevel3_descriptioncolumn_advanced'])){
                    $csv2post_project_array['categories']['level3']['descriptioncolumn'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel3_descriptioncolumn_advanced']);
                    $csv2post_project_array['categories']['level3']['descriptiontable'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel3_descriptioncolumn_advanced']);    
                }       
                     
            }elseif(isset($csv2post_project_array['categories']['level3']) && $_POST['csv2post_categorylevel3_advanced'] == 'notselected'){
                unset($csv2post_project_array['categories']['level3']);            
            }                

            // add level 4
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel4_advanced'] != 'notselected'){
                $csv2post_project_array['categories']['level4']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel4_advanced']);
                $csv2post_project_array['categories']['level4']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel4_advanced']);                     

                // save level 4 description template id if selected
                if($_POST['csv2post_categorylevel4_description'] != 'notselected'){
                    $csv2post_project_array['categories']['level4']['description'] = $_POST['csv2post_categorylevel4_advanced'];        
                }elseif(isset($_POST['csv2post_categorylevel4_descriptioncolumn_advanced'])){
                    $csv2post_project_array['categories']['level4']['descriptioncolumn'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel4_descriptioncolumn_advanced']);
                    $csv2post_project_array['categories']['level4']['descriptiontable'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel4_descriptioncolumn_advanced']);    
                }     
                       
            }elseif(isset($csv2post_project_array['categories']['level4']) && $_POST['csv2post_categorylevel4_advanced'] == 'notselected'){
                unset($csv2post_project_array['categories']['level4']);            
            }
            
            // add level 5             
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel5_advanced'] != 'notselected'){
                $csv2post_project_array['categories']['level5']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel5_advanced']);
                $csv2post_project_array['categories']['level5']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel5_advanced']);                     
            
                // save level 5 description template id if selected
                if($_POST['csv2post_categorylevel5_description'] != 'notselected'){
                    $csv2post_project_array['categories']['level5']['description'] = $_POST['csv2post_categorylevel5_advanced'];        
                }elseif(isset($_POST['csv2post_categorylevel5_descriptioncolumn_advanced'])){
                    $csv2post_project_array['categories']['level5']['descriptioncolumn'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel5_descriptioncolumn_advanced']);
                    $csv2post_project_array['categories']['level5']['descriptiontable'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel5_descriptioncolumn_advanced']);    
                }     
                  
            }elseif(isset($csv2post_project_array['categories']['level5']) && $_POST['csv2post_categorylevel5_advanced'] == 'notselected'){
                unset($csv2post_project_array['categories']['level5']);            
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
* Creates one level of categories at a time 
*/
function csv2post_form_create_category_level(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createcategoriesperlevel'){
        global $csv2post_is_free;
        
        if(!$csv2post_is_free){
            csv2post_WP_CATEGORIES_manuallevels_advanced($_POST['csv2post_categories_next_level']);
        }else{
            csv2post_WP_CATEGORIES_manuallevels_basic($_POST['csv2post_categories_next_level']);
        }

        return false;
    }else{
        return true;
    }     
} 

/**
* Delete all categories created with the current project 
*/
function csv2post_form_undo_categories(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'undocategoriescurrentproject'){
        global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;  
        
        $categories_deleted_count = 0;
        
        $pro_table = csv2post_get_project_maintable($csv2post_currentproject_code);
        
        // query csv2post_catid column
        $records = csv2post_WP_SQL_select_catidcolumn($pro_table); 
        if(!$records){
            csv2post_n_postresult('warning','No Category Data','There does not appear to be any category
            ID values in your data. If you are sure you created categories and not already undone them, please
            contact the plugin author for support.');
            return;
        }

        // keep track of the combinations of cat ID already deleted to avoid running deletion more than once
        $cats_deleted_array = array();
        
        foreach($records as $key => $category){

            if($category['csv2post_catid'] != NULL && !in_array($category['csv2post_catid'],$cats_deleted_array)){
                
                // explode the ID's and delete each category with those ID
                $category_IDs_array = explode(',',$category['csv2post_catid']);

                foreach($category_IDs_array as $key => $cat_ID){
                    if(wp_delete_category( $cat_ID )){
                        ++$categories_deleted_count;
                    }
                }
                
                // update records csv2post_catid value with NULL where csv2post_catid matches our string
                csv2post_WP_SQL_categories_resetIDs($pro_table,$category['csv2post_catid']);
                
                // update cats_deleted_array
                $cats_deleted_array[] = $category['csv2post_catid'];    
            }        
        }
        
        // reset category level tracking - will loop 10 times should we ever add more levels
        for($i=1;$i<=10;$i++){
            if(isset($csv2post_project_array['categories']['level'.$i]['complete'])){
                unset($csv2post_project_array['categories']['level'.$i]['complete']);
            }
        }
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_n_postresult('success','Projects Categories Deleted','A total of '.$categories_deleted_count.' were deleted');        
         
        return false;
    }else{
        return true;
    }     
}             
?>