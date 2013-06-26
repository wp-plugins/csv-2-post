<?php         
/*
Plugin Name: CSV 2 POST
Version: 7.0.0
Plugin URI: http://www.csv2post.com
Description: CSV 2 POST Data Engine plugin and services from WebTechGlobal for Wordpress blogs. This is the advanced choice for data import and instantly blogging large amounts of posts.
Author: WebTechGlobal
Author URI: http://www.csv2post.com

CSV 2 POST GPL v3 (free edition license, ignore for any other edition not downloaded from Wordpress.org)

This program is free software downloaded from Wordpress.org: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. This means
it can be provided for the sole purpose of being developed further
and we do not promise it is ready for any one persons specific needs.
See the GNU General Public License for more details.

See <http://www.gnu.org/licenses/>.

This license does not apply to the paid edition which comes with premium
services not just software. License and agreement is seperate.
*/         
                            
// package variables (frequently changed)
$csv2post_currentversion = '7.0.0';
$csv2post_php_version_tested = '5.4.12';// current version the plugin is being developed on
$csv2post_php_version_minimum = '5.3.0';// minimum version required for plugin to operate
$csv2post_is_free_override = false;// change to true for free edition setup when fulledition folder present 
$csv2post_demo_mode = false;// we do not want error display on demos on www.csvtopost.com
$csv2post_debug_mode = false;// www.csvtopost.com will override this but only if demo mode not active
$csv2post_disable_extensions = false;// boolean - can quickly disable extensions using this
$csv2post_beta_mode = false;// must be set to true prior to installation to ensure beta features are configured properly
$csv2post_is_dev = false;// false|true  - true will display more information i.e. array dumps using var_dump() 

// activate debug by url or based on the domain - you can change this to your own test domains                   
if($csv2post_demo_mode != true){# we ensure no error output on demos   
    $testingserver = strstr(ABSPATH,'testing/wordpress');
    if(isset($_GET['csv2postdebug']) || $testingserver ){
        $csv2post_debug_mode = true; 
        $csv2post_beta_mode = true;
        $csv2post_is_dev = true;      
    }                
}
         
// error output should never be on during AJAX requests               
if(defined('DOING_AJAX') && DOING_AJAX){
    $csv2post_debug_mode = false;    
}
           
// other variables required on installation or loading
$csv2post_plugintitle = 'CSV 2 POST';// requires so that extensions can re-brand the plugin
$csv2post_pluginname = 'csv2post';// should not be used to make up paths
$csv2post_homeslug = $csv2post_pluginname;// @todo page slug for plugin main page used in building menus
$csv2post_isbeingactivated = false;// changed to true during activation, used to avoid certain processing especially the schedule and automation system
$csv2post_is_event = false;// when true, an event is running or has ran, used to avoid over processing         
$csv2post_installation_required = true;                                                     
$csv2post_is_installed = false;        
$csv2post_was_installed = false;
$csv2post_is_emailauthorised = false;
$csv2post_log_maindir = 'unknown';
$csv2post_currentproject = 'No Project Set';
$csv2post_notice_array = array();// set notice array for storing new notices in (not persistent notices)
$csv2post_extension_loaded = false;
                                   
##########################################################################################
#                                                                                        #
#                                     DEFINE CONSTANTS                                   #
#                                                                                        #
##########################################################################################             
if(!defined("WTG_C2P_ABB")){define("WTG_C2P_ABB","csv2post_");}
if(!defined("WTG_C2P_NAME")){define("WTG_C2P_NAME",'CSV 2 POST');} 
if(!defined("WTG_C2P_URL")){define("WTG_C2P_URL", plugin_dir_url(__FILE__) );}//http://localhost/wordpress-testing/wtgplugintemplate/wp-content/plugins/wtgplugintemplate/
if(!defined("WTG_C2P_DIR")){define("WTG_C2P_DIR", plugin_dir_path(__FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/
if(!defined("WTG_C2P_FOLDERNAME")){define("WTG_C2P_FOLDERNAME",'csv-2-post');}// The plugins main folder name in the wordpress plugins directory  
if(!defined("WTG_C2P_BASENAME")){define("WTG_C2P_BASENAME", plugin_basename( __FILE__ ) );}// wtgplugintemplate/wtgtemplateplugin.php
if(!defined("WTG_C2P_PHPVERSIONTESTED")){define("WTG_C2P_PHPVERSIONTESTED",$csv2post_php_version_tested);}// The latest version of php the plugin has been tested on and certified to be working 
if(!defined("WTG_C2P_PHPVERSIONMINIMUM")){define("WTG_C2P_PHPVERSIONMINIMUM",$csv2post_php_version_minimum);}// The minimum php version that will allow the plugin to work     
if(!defined("WTG_C2P_CHMOD")){define("WTG_C2P_CHMOD",'0755');}###TODO:CRITICALPRIORITY,should this not be 0700? // File permission default CHMOD for any folders or files created by plugin  
if(!defined("WTG_C2P_CORE_PATH")){define("WTG_C2P_CORE_PATH",WP_PLUGIN_DIR.'/'.WTG_C2P_FOLDERNAME.'/wtg-core/');}
if(!defined("WTG_C2P_WPCORE_PATH")){define("WTG_C2P_WPCORE_PATH",WP_PLUGIN_DIR.'/'.WTG_C2P_FOLDERNAME.'/wtg-core/wp/');}
if(!defined("WTG_C2P_PAID_PATH")){define("WTG_C2P_PAID_PATH",WP_PLUGIN_DIR.'/'.WTG_C2P_FOLDERNAME.'/fulledition/');}
if(!defined("WTG_C2P_PANELFOLDER_PATH")){define("WTG_C2P_PANELFOLDER_PATH",WP_PLUGIN_DIR.'/'.WTG_C2P_FOLDERNAME.'/panels/');}// directory path to storage folder inside the wp_content folder                            
if(!defined("WTG_C2P_CONTENTFOLDER_DIR")){define("WTG_C2P_CONTENTFOLDER_DIR",WP_CONTENT_DIR.'/'.'wpcsvimportercontent');}// directory path to storage folder inside the wp_content folder  
if(!defined("WTG_C2P_IMAGEFOLDER_URL")){define("WTG_C2P_IMAGEFOLDER_URL",WP_PLUGIN_URL.'/'.WTG_C2P_FOLDERNAME.'/images/');} 
if(!defined("WTG_C2P_DATEFORMAT")){define("WTG_C2P_DATEFORMAT",'Y-m-d H:i:s');}
if(!defined("WTG_C2P_ID")){define("WTG_C2P_ID","27");}// used by SOAP web services, this ID allows specific web services to be made available for this plugin. Change the ID and things will simply go very wrong
                  
// set extension switch constant
if(!defined("WTG_C2P_EXTENSIONS")){# should not be defined before now ever 
    if(!$csv2post_disable_extensions){
        if(get_option('csv2post_extensions')){
            define("WTG_C2P_EXTENSIONS",get_option('csv2post_extensions'));
        }else{
            define("WTG_C2P_EXTENSIONS",'disable');
        }
    }
}
               
// decide if package is free or full edition - apply the over-ride variable to use as free edition when full edition files present
if(file_exists(WTG_C2P_DIR . 'fulledition') && $csv2post_is_free_override == false){
    $csv2post_is_free = false;
}else{
    $csv2post_is_free = true;
}  
              
##########################################################################################
#                                                                                        #
#                          INCLUDE WEBTECHGLOBAL PHP CORE                                #
#                    php functions package applicable to all CMS                         #
##########################################################################################
### TODO:LOWPRIORITY, whats better, scandir() approach or RecursiveDirectoryIterator() ? 
foreach (scandir( WTG_C2P_DIR . 'wtg-core/php/' ) as $wtgcore_filename) {   
    if ($wtgcore_filename != '.' && $wtgcore_filename != '..' && is_file(WTG_C2P_DIR . 'wtg-core/php/' . $wtgcore_filename)) { 
        if($wtgcore_filename != 'license.html' && $wtgcore_filename != 'index.php'){
            require_once( WTG_C2P_DIR . 'wtg-core/php/' . $wtgcore_filename );
        }                            
    }                        
} 
                        
##########################################################################################
#                                                                                        #
#                           INCLUDE WEBTECHGLOBAL WORDPRESS CORE                         #
#       our own functions suitable only for Wordpress for use in any plugin or theme     #
########################################################################################## 
$core_exclusions_array = array('wtgcore_wp_formsubmit.php');
foreach (scandir( WTG_C2P_DIR . 'wtg-core/wp/' ) as $wtgcore_filename) {   
    if (!in_array($wtgcore_filename,$core_exclusions_array) && $wtgcore_filename != '.' && $wtgcore_filename != '..' && is_file(WTG_C2P_DIR . 'wtg-core/wp/' . $wtgcore_filename)) { 
        if($wtgcore_filename != 'license.html' && $wtgcore_filename != 'index.php'){
            require_once( WTG_C2P_DIR . 'wtg-core/wp/' . $wtgcore_filename );
        }                            
    }                        
}  
             
##########################################################################################
#                                                                                        #
#                       INCLUDE FREE EDITION FUNCTIONS AND ARRAYS                        #
#                     functions and arrays applicable to all editions                    #
##########################################################################################
require_once(WTG_C2P_DIR.'include/csv2post_core_functions.php');### move functions from this file to either wtgcore or admin functions.php then delete it 
require_once(WTG_C2P_DIR.'include/csv2post_admininterface_functions.php');
require_once(WTG_C2P_DIR.'include/csv2post_settings_functions.php');
require_once(WTG_C2P_DIR.'include/csv2post_ajax_admin_functions.php');  
require_once(WTG_C2P_DIR.'include/csv2post_install_functions.php');
require_once(WTG_C2P_DIR.'include/csv2post_admin_functions.php');
require_once(WTG_C2P_DIR.'include/csv2post_sql_functions.php');
require_once(WTG_C2P_DIR.'include/csv2post_post_functions.php');// post creation,update related functions              
require_once(WTG_C2P_DIR.'include/csv2post_formsubmit_functions.php');
require_once(WTG_C2P_DIR.'include/variables/csv2post_seoplugins_array.php');
require_once(WTG_C2P_DIR.'include/variables/csv2post_wordpressoptionrecords_array.php'); 
require_once(WTG_C2P_DIR.'wtg-core/wp/wparrays/wtgcore_wp_tables_array.php');
                               
##########################################################################################
#                                                                                        #
#                                  INCLUDE PAID EDITION                                  #
#            this is the premium/paid package, usually for developers or business        #
##########################################################################################
$paid_exclusions_array = array('csv2post_paid_formsubmit.php');
if(!$csv2post_is_free){ 
    foreach (scandir( WTG_C2P_PAID_PATH ) as $fulledition_filename) {     
        if (!in_array($fulledition_filename,$paid_exclusions_array) && $fulledition_filename != '.' && $fulledition_filename != '..' && is_file( WTG_C2P_PAID_PATH . $fulledition_filename)) { 
            if($fulledition_filename != 'license.html' && $fulledition_filename != 'index.php'){
                require_once( WTG_C2P_PAID_PATH . $fulledition_filename);
            }
        }
    } 

    if(is_admin()){require_once(WTG_C2P_DIR.'fulledition/admin/csv2post_paid_adminforms.php');}    
} 

// fgetcsv transition   csv2post_p e a r csv_include();
          
// we require the main admin settings array for continuing the loading of the plugin                                                                       
$csv2post_adm_set = csv2post_get_option_adminsettings();# installs admin settings record if not yet installed, this will happen on plugin being activated
                  
// error display variables, variable that displays maximum errors is set in main file 
if($csv2post_demo_mode != true){csv2post_debugmode();}  
                                 
##########################################################################################
#                                                                                        #
#          LOAD OPTION RECORD VALUES - MUST BE AFTER THE ARRAY FILES ARE LOADED          #
#                                                                                        #
########################################################################################## 
// get data import jobs related variables
$csv2post_currentjob_code = csv2post_get_option_currentjobcode();
$csv2post_job_array = csv2post_get_dataimportjob($csv2post_currentjob_code);
$csv2post_jobtable_array = csv2post_get_option_jobtable_array(); 
$csv2post_dataimportjobs_array = csv2post_get_option_dataimportjobs_array();
$csv2post_file_profiles = csv2post_get_option_fileprofiles();
                 
// get post creation project related variables
$csv2post_currentproject_code = csv2post_option('csv2post_currentprojectcode','get');
$csv2post_project_array = csv2post_get_project_array($csv2post_currentproject_code);
$csv2post_projectslist_array = csv2post_get_projectslist();
$csv2post_textspin_array = csv2post_get_option_textspin_array();
                           
// get all other admin variables    
$csv2post_was_installed = csv2post_was_installed();// boolean - indicates if a trace of previous installation found       
$csv2post_schedule_array = csv2post_get_option_schedule_array();// holds permitted hours and limits
         
// admin only values (these are arrays that contain data that should never be displayed on public side, load them admin side only reduces a fault causing display of the information)
if(is_admin()){
    $csv2post_persistent_array = csv2post_get_option_persistentnotifications_array();// holds interface notices/messages, some temporary, some are persistent 
    $csv2post_mpt_arr = csv2post_get_option_tabmenu();
}   
              
##########################################################################################
#                                                                                        #
#                                    LOAD EXTENSIONS                                     #
#      Free users can adapt this to load their own custom extension or other files       #
##########################################################################################
if(!$csv2post_is_free){
    if(WTG_C2P_EXTENSIONS != 'disable' && file_exists(WP_CONTENT_DIR . '/csv2postextensions')){ 
        
        /*
                this system is 95% complete. Where "df1" is used we need to use variables
                and load multiple extensions within a loop, for now a single extension can be loaded
        */
        
        // if the extension is to be loaded, we will double check the files exist and install if required
        if(csv2post_extension_activation_status('df1') == 3 
        || isset($_GET['csv2postprocsub']) && isset($_GET['action']) && isset($_GET['extension']) && $_GET['extension'] == 'df1'){    
            
            // ensure extension files actually exist
            if(file_exists(WP_CONTENT_DIR . '/csv2postextensions/df1')){
                
                $name = 'df1';

                // set a variable to tell CSV 2 POST scripts to consider an active extension
                $csv2post_extension_loaded = true;
                // include functions
                require_once(WP_CONTENT_DIR . '/csv2postextensions/df1/extension.php');
                require_once(WP_CONTENT_DIR . '/csv2postextensions/df1/functions.php');  
                require_once(WP_CONTENT_DIR . '/csv2postextensions/df1/functions/interface.php');
                require_once(WP_CONTENT_DIR . '/csv2postextensions/df1/functions/shortcodes.php');
                require_once(WP_CONTENT_DIR . '/csv2postextensions/df1/functions/sql.php');
                require_once(WP_CONTENT_DIR . '/csv2postextensions/df1/functions/post.php');
                require_once(WP_CONTENT_DIR . '/csv2postextensions/df1/functions/installation.php');
                
                // include configuration (this makes changes required for the Wordpress installation)
                include_once(WP_CONTENT_DIR . '/csv2postextensions/df1/configuration.php');   

                $installedversion = get_option($name . '_version');

                $extension_version = ${"csv2post_extension_" . $name ."_version"};
                
                // do a version check on the installation compared to the files - disable extension until update performed by user
                if(!isset($_GET['action']) || $_GET['action'] != 'extensionupdate'){# avoid repeating this message during the update processing
                    $update_required = csv2post_extension_updaterequired('df1',$extension_version);
                    if($update_required){
                        // disable extension
                        update_option('ext_activated_DF1','no');
                        // notify user
                        csv2post_n('DF1 Extension Update Required','An extension installed and active has new files. The database
                        tables and option records that make the extensions installation must be updated. Please go to the Extension
                        screen and perform an update on the DF1 Extension if you wish to continue using the extension. The extension
                        will stay disabled until this is done.','warning','Large');                   
                    }
                }                
            }
        }
    }
}
                
####################################################################################################
####                                                                                            ####
####           ADMIN THAT MUST COME FIRST AND IS NOT APPLICABLE TO JUST CSV 2 POST PAGES        ####
####                        i.e. custom post types, dashboard widgets                           ####
####                                                                                            ####
####################################################################################################  
if(is_admin()){ 

    $csv2post_guitheme = csv2post_get_theme();
                       
    register_activation_hook( __FILE__ ,'csv2post_register_activation_hook');
    
    // content template custom post type
    add_action( 'init', 'csv2post_init_posttype_contentdesigns' );
    add_action( 'add_meta_boxes', 'csv2post_add_meta_boxes_contenttemplates' );
    add_action( 'save_post', 'csv2post_save_meta_boxes_contenttemplates',10,2 );
    // title template custom post type
    add_action( 'init', 'csv2post_register_customposttype_titledesigns' );
    // title template custom post type
    add_action( 'init', 'csv2post_register_customposttype_flags' );
    add_action( 'add_meta_boxes', 'csv2post_add_meta_boxes_flags' );
    add_action( 'save_post', 'csv2post_save_meta_boxes_flags',10,2 );
    
    $csv2post_is_installed = csv2post_is_installed();// boolean - if false either plugin has never been installed or installation has been tampered with 
}   
             
###############################################################################
#                                                                             #
#             PUBLIC SIDE HOOKS i.e. post updating and other events           #
#                                                                             #
###############################################################################
if(!$csv2post_is_free){
    add_action('init', 'csv2post_event_check');// part of schedule system in paid edition, run auto post and data updating events if any are due
    add_action('init','csv2post_cloak_forward');
        
    // Post Parsing (runs functions that alter content, title etc
    if(!isset($csv2post_adm_set['postfilter']['status'])
    || $csv2post_adm_set['postfilter']['status'] == true){
        
        /**
        * This will run by default for now (21st January 2013)
        * For the sake of performance, we need to only run it when required. So all procedures
        * included, when activated by user, must also activate the post parser by setting status to true
        * ### TODO:HIGHPRIORITY, have post parsing off by default and active when user actives post updating or spinner token re-spin
        * If any other parsing procedures required they will also need to activate post parsing
        * ### TODO:MEDIUMPRIORITY, create a setting to toggle post parsing, over-riding many other procedures but giving user more control over the plugins activity using a single setting
        */
        add_action('the_posts', 'csv2post_post_filter' );
    }    
}
                    
####################################################
####                                            ####
####               Add Shortcodes               ####
#### We will only add shortcodes when rules set ####
####################################################
if(!$csv2post_is_free){
    // add less advanced shortcodes, those that use values in shortcode itself
    add_shortcode( 'csv2post_random_basic', 'csv2post_SHORTCODE_textspinning_randombasic' );
    
    if(isset($csv2post_textspin_array['spinners'])){
        add_shortcode( 'csv2post_spinner_advanced', 'csv2post_SHORTCODE_textspinning_advanced' );
        add_shortcode( 'csv2post_random_advanced', 'csv2post_SHORTCODE_textspinning_randomadvanced' );# depreciated version 6.7.8    
    }
}
           
#############################################################################################################
####                                                                                                        #
####                         ADMIN THAT COMES LAST AND ALWAYS APPLYS                                        #
####   i.e. most of our jQuery UI is for our own interface, no need to load the scripts on other pages      #
####                                                                                                        #
#############################################################################################################
add_action('admin_menu','csv2post_admin_menu');// main navigation 
  
#############################################################################################################
####                                                                                                        #
####            ADMIN THAT COMES LAST AND APPLYS TO CSV 2 POST PLUGIN PAGES ONLY                            #
####   i.e. most of our jQuery UI is for our own interface, no need to load the scripts on other pages      #
####                                                                                                        #
############################################################################################################# 
if(is_admin() && isset($_GET['page']) && csv2post_is_plugin_page($_GET['page'])){

    // register scripts during admin initial loading
    add_action( 'admin_init', 'csv2post_ADDACTION_admin_init_registered_scripts' );

    // Comprehensive Google Map by Alexander Zagniotov causes a conflict. Removing the action which calls function causing conflict which breaks CSV 2 POST jQuery UI
    remove_action( 'admin_init', 'cgmp_google_map_admin_add_script' );# TODO:HIGHPRIORITY, retest as this may no longer be needed
    
    // script and css admin side          
    csv2post_script_core('admin');           
    csv2post_script_plugin('admin');
    csv2post_css_core('admin');  
    csv2post_css_plugin('admin');
         
    add_action('init','csv2post_export_singlesqltable_as_csvfile');// export CSV file request by $_POST

    // print scripts to page          
    if(isset($csv2post_guitheme) && $csv2post_guitheme == 'jquery' || $csv2post_guitheme == false){  
        add_action( 'admin_enqueue_scripts', 'csv2post_print_admin_scripts' );
    }

    // process form submission - moved to here 11th January 2013
    // this includes files that call every processing function one after the other, a simple approach until we add something faster
    add_action('admin_init','csv2post_process');
    
    // add admin page scripts to footer
    add_action('admin_footer', 'csv2post_WP_adminpage_script');
    
}elseif(!is_admin()){// default to public side script and css      
    csv2post_script_core('public');          
    csv2post_script_plugin('public');
    csv2post_css_core('public');  
    csv2post_css_plugin('public');   
}
?>