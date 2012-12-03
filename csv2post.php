<?php
/*
Plugin Name: CSV 2 POST
Version: 6.7.3
Plugin URI: http://www.csv2post.com
Description: CSV 2 POST released 2012 by Zara Walsh and Ryan Bayne
Author: Zara Walsh
Author URI: http://www.csv2post.com
Free Edition License: GPL v3

CSV 2 POST
Copyright (C) 20011-2012, Zara Walsh - zara@csv2post.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

This license does not apply to the paid edition which is bundled with a seperate license file.
*/
                                        
// package variables 
$csv2post_debug_mode = false;// boolean true or false 
$csv2post_is_dev = false;// boolean, true displays more panels with even more data i.e. array dumps
$csv2post_currentversion = '6.7.3';// this value should not be relied on but only used for guidance
$csv2post_is_free_override = false;// change to true for free edition setup when fulledition folder present
              
// other variables required on installation or loading
### TODO:HIGHPRIORITY, some these should be constants 
$csv2post_php_version_tested = '5.4.0';// current version the plugin is being developed on
$csv2post_php_version_minimum = '5.3.1';// minimum version required for plugin to operate
$csv2post_plugintitle = 'CSV 2 POST';
$csv2post_pluginname = 'csv2post';// should not be used to make up paths
$csv2post_homeslug = $csv2post_pluginname;// @todo page slug for plugin main page used in building menus
$csv2post_isbeingactivated = false;
$csv2post_disableapicalls = 0;// 1 = yes, disable all api calls 0 allows api calls
$csv2post_is_event = false;// when true, an event is running or has ran, used to avoid over processing 
$csv2post_csvmethod = 1;// 0=PEAR CSV 1=fget/fgetcsv only         
$csv2post_nav_type = 'jquery';// css,jquery,nonav (changes the navigation, we can adapt this as much as required)
$csv2post_installation_required = true;
$csv2post_apiservicestatus = 'unknown';
$csv2post_is_webserviceavailable = false;                                                       
$csv2post_is_subscribed = false;
$csv2post_is_installed = false;        
$csv2post_was_installed = false;
$csv2post_is_domainregistered = false;
$csv2post_is_emailauthorised = false;
$csv2post_log_maindir = 'unknown';
$csv2post_callcode = '000000000000';
$csv2post_currentproject = 'No Project Set';
    
##########################################################################################
#                                                                                        #
#                                     DEFINE CONSTANTS                                   #
#                                                                                        #
##########################################################################################                 
if(!defined("WTG_C2P_ABB")){define("WTG_C2P_ABB","csv2post_");}
if(!defined("WTG_C2P_URL")){define("WTG_C2P_URL", plugin_dir_url(__FILE__) );}//http://localhost/wordpress-testing/wtgplugintemplate/wp-content/plugins/wtgplugintemplate/
if(!defined("WTG_C2P_DIR")){define("WTG_C2P_DIR", plugin_dir_path(__FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/
if(!defined("WTG_C2P_ID")){define("WTG_C2P_ID","27");}
if(!defined("WTG_C2P_FOLDERNAME")){define("WTG_C2P_FOLDERNAME",'csv-2-post');}// The plugins main folder name in the wordpress plugins directory  
if(!defined("WTG_C2P_BASENAME")){define("WTG_C2P_BASENAME", plugin_basename( __FILE__ ) );}// wtgplugintemplate/wtgtemplateplugin.php
if(!defined("WTG_C2P_CONURL")){define("WTG_C2P_CONURL", get_bloginfo('url') );}// http://localhost/wordpress-testing/wtgplugintemplate
if(!defined("WTG_C2P_PHPVERSIONTESTED")){define("WTG_C2P_PHPVERSIONTESTED",$csv2post_php_version_tested);}// The latest version of php the plugin has been tested on and certified to be working 
if(!defined("WTG_C2P_PHPVERSIONMINIMUM")){define("WTG_C2P_PHPVERSIONMINIMUM",$csv2post_php_version_minimum);}// The minimum php version that will allow the plugin to work     
if(!defined("WTG_C2P_CHMOD")){define("WTG_C2P_CHMOD",'0755');}###TODO:CRITICALPRIORITY,should this not be 0700? // File permission default CHMOD for any folders or files created by plugin  
if(!defined("WTG_C2P_PANELFOLDER_PATH")){define("WTG_C2P_PANELFOLDER_PATH",WP_PLUGIN_DIR.'/'.WTG_C2P_FOLDERNAME.'/panels/');}// directory path to storage folder inside the wp_content folder                            
if(!defined("WTG_C2P_CONTENTFOLDER_DIR")){define("WTG_C2P_CONTENTFOLDER_DIR",WP_CONTENT_DIR.'/'.'wpcsvimportercontent');}// directory path to storage folder inside the wp_content folder  
if(!defined("WTG_C2P_IMAGEFOLDER_URL")){define("WTG_C2P_IMAGEFOLDER_URL",WP_PLUGIN_URL.'/'.WTG_C2P_FOLDERNAME.'/templatesystem/images/');}// directory path to storage folder inside the wp_content folder 
if(!defined("WTG_C2P_DATEFORMAT")){define("WTG_C2P_DATEFORMAT",'Y-m-d H:i:s');}
if(!defined("WTG_C2P_EXTENSIONS")){define("WTG_C2P_EXTENSIONS",get_option('csv2post_extensions'));}

// disable debug mode during Ajax requests or on public side 
if(!is_admin() || defined('DOING_AJAX') && DOING_AJAX){
    $csv2post_debug_mode = false;
}

// decide if package is free or full edition - apply the over-ride variable to use as free edition when full edition files present
if(file_exists(WTG_C2P_DIR . 'fulledition') && $csv2post_is_free_override == false){
    $csv2post_is_free = false;
}else{
    $csv2post_is_free = true;
}

##########################################################################################
#                                                                                        #
#              INCLUDE WEBTECHGLOBAL WORDPRESS CORE LIBRARY FUNCTION FILES               #
#                                                                                        #
########################################################################################## 
foreach (scandir( WTG_C2P_DIR . 'wtg-wordpress-core/' ) as $filename) {   
    if ($filename != '.' && $filename != '..' && is_file(WTG_C2P_DIR . 'wtg-wordpress-core/' . $filename)) { 
        if($fulledition_filename != 'license.html' && $fulledition_filename != 'index.php'){
            require_once(WTG_C2P_DIR . 'wtg-wordpress-core/' . $filename);
        }        
    }
}    

##########################################################################################
#                                                                                        #
#                              INCLUDE PLUGIN FUNCTION FILES                             #
#                                                                                        #
##########################################################################################
if(is_admin()){require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_variables_adminconfig.php');}// admin only variables files
require_once(WTG_C2P_DIR.'templatesystem/csv2post_load_admin_arrays.php');// multiple files each holding arrays of settings etc
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_core_functions.php');### move functions from this file to either wtgcore or admin functions.php then delete it 
require_once(WTG_C2P_DIR.'templatesystem/csv2post_load_initialplugin_configuration.php');// must be loaded after core_functions.php
require_once(WTG_C2P_DIR.'templatesystem/include/webservices/csv2post_api_parent.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_admininterface_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_settings_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_ajax_admin_functions.php');  
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_install_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_admin_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_sql_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_file_functions.php');// file management related functions
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_post_functions.php');// post creation,update related functions              
require_once(WTG_C2P_DIR.'pages/csv2post_variables_tabmenu_array.php');  

##########################################################################################
#                                                                                        #
#               INCLUDE FULL EDITION WORDPRESS CORE LIBRARY FUNCTION FILES               #
#                                                                                        #
##########################################################################################
if(!$csv2post_is_free){ 
    foreach (scandir( WTG_C2P_DIR.'fulledition/' ) as $fulledition_filename) {   
        if ($fulledition_filename != '.' && $fulledition_filename != '..' && is_file(WTG_C2P_DIR . 'fulledition/' . $fulledition_filename)) { 
            if($fulledition_filename != 'license.html' && $fulledition_filename != 'index.php'){
                require_once(WTG_C2P_DIR . 'fulledition/' . $fulledition_filename);
            }
        }
    } 
}   

##########################################################################################
#                                                                                        #
#                              LOAD EXTENSION CONFIGURATION                              #
#                                                                                        #
##########################################################################################
if(WTG_C2P_EXTENSIONS != 'disable' && file_exists(WTG_C2P_CONTENTFOLDER_DIR . '/extensions')){
    // we are only going to load our prototype extension right
    if(file_exists(WTG_C2P_CONTENTFOLDER_DIR . '/extensions/ryanair')){
        // include constants, variables and arrays
        include_once(WTG_C2P_CONTENTFOLDER_DIR . '/extensions/ryanair/variables.php');
        // include functions
        include_once(WTG_C2P_CONTENTFOLDER_DIR . '/extensions/ryanair/functions.php');        
        // include configuration (this makes changes required for the Wordpress installation)
        include_once(WTG_C2P_CONTENTFOLDER_DIR . '/extensions/ryanair/configuration.php');            
    }
}
             
##########################################################################################
#                                                                                        #
#          LOAD OPTION RECORD VALUES - MUST BE AFTER THE ARRAY FILES ARE LOADED          #
#                                                                                        #
########################################################################################## 
$csv2post_notice_array = csv2post_get_option_notifications_array();// holds interface notices/messages, some temporary, some are persistent 

// get data import jobs related variables
$csv2post_currentjob_code = csv2post_get_option_currentjobcode();
$csv2post_job_array = csv2post_get_dataimportjob($csv2post_currentjob_code);
$csv2post_jobtable_array = csv2post_get_option_jobtable_array(); 
$csv2post_dataimportjobs_array = csv2post_get_option_dataimportjobs_array();
$csv2post_file_profiles = csv2post_get_option_fileprofiles();

// get post creation project related variables
$csv2post_currentproject_code = csv2post_get_current_project_code();
$csv2post_project_array = csv2post_get_project_array($csv2post_currentproject_code);
$csv2post_projectslist_array = csv2post_get_projectslist();
$csv2post_textspin_array = csv2post_get_option_textspin_array();

// get all other admin variables    
$csv2post_was_installed = csv2post_was_installed();// boolean - indicates if a trace of previous installation found       
$csv2post_schedule_array = csv2post_get_option_schedule_array();// holds permitted hours and limits

####################################################
####                                            ####
####       LOAD ADMIN THAT MUST COME FIRST      ####
####                                            ####
####################################################  
if(is_admin()){ 
    register_activation_hook( __FILE__ ,'csv2post_register_activation_hook');
  
    // content template custom post type
    add_action( 'init', 'csv2post_register_customposttype_contentdesigns' );
    add_action( 'add_meta_boxes', 'csv2post_add_custom_boxes_contenttemplate' );
    add_action( 'save_post', 'csv2post_save_postdata_contenttemplate' );
    // title template custom post type
    add_action( 'init', 'csv2post_register_customposttype_titledesigns' );
    add_action( 'save_post', 'csv2post_save_postdata_titletemplate' );

    //$csv2post_activationcode = csv2post_get_activationcode(); ### TODO:MEDIUMPRIORITY, part of activation code system 
    $csv2post_is_installed = csv2post_is_installed();// boolean - if false either plugin has never been installed or installation has been tampered with 
    
    if(!$csv2post_is_free){
        //$csv2post_is_webserviceavailable = csv2post_is_webserviceavailable();
    }else{
        $csv2post_is_webserviceavailable == false;
    }
    
    // if web services are available, we can then check if domain is registered or not
    if(!$csv2post_is_free && $csv2post_is_webserviceavailable){
        
        # TODO: CRITICAL, change call code design so that it does not expire but may be changed from time to time
        # TODO: CRITICAL, once call code does not expire, avoid using csv2post_is_domainregistered() every page call, leave a local value indicating domain is registered 
        
        $csv2post_is_domainregistered = csv2post_is_domainregistered();// returns boolean AND stores call code 
        
        // if domain is within membership then we can continue doing further api calls 
        if($csv2post_is_domainregistered){
            
            // continue other api calls
            $csv2post_callcode = get_option('csv2post_callcode');                              
            $csv2post_is_callcodevalid = csv2post_is_callcodevalid();
            //$csv2post_is_subscribed = csv2post_is_subscribed();// returns boolean       
        }
    }
}

// add public actions 
if(!$csv2post_is_free){# if you hack this, you will need to write the require functions
    // run auto post and data updating events if any are due
    add_action('init', 'csv2post_event_check');
    // has user disabled public post updating
    if(!isset($csv2post_project_array['updating']['content']['settings']['public'])
    || $csv2post_project_array['updating']['content']['settings']['public'] == 'on'){
        add_action('the_posts', 'csv2post_posts_publicupdating' );
    }
}
                     
####################################################
####                                            ####
####               Add Shortcodes               ####
#### We will only add shortcodes when rules set ####
####################################################
if(!$csv2post_is_free){
    // add less advanced shortcodes, those that use values in shortcode itself
    add_shortcode( 'csv2post_random_basic', 'csv2post_shortcode_textspinning_randombasic' );
    
    if(isset($csv2post_textspin_array['randomvalue'])){
        add_shortcode( 'csv2post_random_advanced', 'csv2post_shortcode_textspinning_randomadvanced' );    
    }
}

####################################################
####                                            ####
####       LOAD ADMIN THAT MUST COME LAST       ####
####                                            ####
#################################################### 
if(is_admin()){        
    // add action for main script loading only if on plugins own pages
    // loop through all page slugs - only if not currently being activated
    ### TODO: HIGHPRIORITY, if continue to get script problems in firefox, try putting these conditions inside the add_action
    if(!isset($csv2post_isbeingactivated) || isset($csv2post_isbeingactivated) && $csv2post_isbeingactivated != true){
        $looped = 0;
        // loop through pages in page array
        foreach($csv2post_mpt_arr as $key=>$pagearray){
            // if admin url contains the page value and we have a slug (should do) - are the equal
            // this prevents the plugins scripts loading unless we are on the plugins own pages
            if (isset($_GET['page']) && isset($pagearray['slug']) && $_GET['page'] == $pagearray['slug']){
                add_action( 'wp_print_scripts', 'csv2post_print_admin_scripts' );
            }
            ++$looped;
        }
    }        
    
    add_action('admin_menu','csv2post_admin_menu');// main navigation 
    add_action('init','csv2post_export_singlesqltable_as_csvfile');// export CSV file request by $_POST
        
    csv2post_script('admin');// TODO
    /* ################ TODO:CRITICAL, change the way scripts loaded, make use of admin_init */
    csv2post_css('admin');
                 
}else{
    csv2post_script('public');
    csv2post_css('public');    
}           
?>
