<?php 
###############################################################
#                                                             #
#     CALLS FORM PROCESSING FUNCTIONS IN PLUGIN PACKAGE       #
#                                                             #
###############################################################

global $csv2post_notice_result;
       
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
}
                     
// Project Screen Form Submissions (project creation and configuration)
if($cont){
    
    // Save basic SEO options
    $cont = csv2post_form_save_basic_seo_options(); 
                     
    // Create post creation project
    $cont = csv2post_form_create_post_creation_project();
                                       
    // Delete one or more post creation projects
    $cont = csv2post_form_delete_post_creation_projects();
                                       
    // Change current project
    $cont = csv2post_form_change_current_project();
                   
    // Save template
    $cont = csv2post_form_save_contenttemplate();
                   
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

    // Save standard category configuration
    $cont = csv2post_form_save_categories_standard();
    
    // Save category mapping (data values too)
    $cont = csv2post_form_save_category_mapping();
    
    // Save default category
    $cont = csv2post_form_save_default_category();
    
    // Save tag creation rules
    $cont = csv2post_form_save_tag_rules();

    // Activate or disable text spinning
    $cont = csv2post_form_textspinning_switch();

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
    
    // save post slug data
    $cont = csv2post_form_save_postslugdata(); 
}

// Creation Screen
if($cont){  
    
    // Start post creation even manually
    $cont = csv2post_form_start_post_creation();
    
    // Creates categories (2012 method, all levels at once)
    $cont = csv2post_form_create_categories(); 
    
    // Create category level (2013 method, one level at a time for better monitoring/diagnostics)
    $cont = csv2post_form_create_category_level();

    // Undo posts
    $cont = csv2post_form_undo_posts();
    
    // Delete flags
    $cont = csv2post_form_delete_flags(); 
    
    // Undo current project categories 
    $cont = csv2post_form_undo_categories();        
}

// Install
if($cont){
      
    // Test CSV File 
    $cont = csv2post_form_test_csvfile();
        
    // Contact Form Submission Post Validation
    $cont = csv2post_form_contactformsubmission();
    
    // Create a data rule for replacing specific values after import 
    $cont = csv2post_form_create_datarule_replacevalue();      
    $cont = csv2post_form_uninstallplugin_partial(); 
    $cont = csv2post_form_reinstall_databasetables();   
}

// Main and Settings     
if($cont){
    // Save easy configuration questions
    $cont = csv2post_form_save_easyconfigurationquestions();

    // Save global allowed days and hours
    $cont = csv2post_form_save_scheduletimes_global();
    
    // Save drip feed limits
    $cont = csv2post_form_save_schedulelimits(); 
    
    // Reset Quick Start Session
    $cont = csv2post_form_reseteci();   
    
    // Save operation settings
    $cont = csv2post_form_save_settings_operation();

    // Save Data Panel One settings
    $cont = csv2post_form_save_settings_datapanelone();
        
    // Save interface settings
    $cont = csv2post_form_save_settings_interface();    
}    
    
// Other
if($cont){
    $cont = csv2post_form_createcontentfolder();
    $cont = csv2post_form_deletecontentfolder(); 
    $cont = csv2post_form_delete_persistentnotice();   
}

// Quick Start - Free
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

// Update Page
if($cont){ 
    $cont = csv2post_form_plugin_update();
}
?>