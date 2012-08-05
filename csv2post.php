<?php
/*
Plugin Name: CSV 2 POST
Version: 6.5.5
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

$csv2post_debug_mode = false;// boolean true or false
if(!is_admin() || defined('DOING_AJAX') && DOING_AJAX){
    $csv2post_debug_mode = false;
}

### TODO:HIGHPRIORITY, detect paid edition folder automatically, if not found set as free edition
$csv2post_is_free = true;// changing this in free copy does not activate a paid edition, it may break the plugin
$csv2post_is_dev = false;// boolean, true displays more panels with even more data i.e. array dumps
$csv2post_currentversion = '6.5.5';// this value should not be relied on but only used for guidance
$csv2post_php_version_tested = '5.3.1';// current version the plugin is being developed on
$csv2post_php_version_minimum = '5.3.1';// minimum version required for plugin to operate
$csv2post_pluginname = 'csv2post';// should not be used to make up paths
$csv2post_homeslug = $csv2post_pluginname;// @todo page slug for plugin main page used in building menus
$csv2post_isbeingactivated = false;
$csv2post_disableapicalls = 0;// 1 = yes, disable all api calls 0 allows api calls
$csv2post_is_event = false;// when true, an event is running or has ran, used to avoid over processing 
$csv2post_csvmethod = 1;// 0=PEAR CSV 1=fget/fgetcsv only         
$csv2post_nav_type = 'jquery';// css,jquery,nonav (changes the navigation, we can adapt this as much as required)

##########################################################################################
#                                                                                        #
#               LOAD CORE VARIABLES AND FILES FOR BOTH PUBLIC AND ADMIN                  #
#                                                                                        #
##########################################################################################                 
if(!defined("WTG_C2P_ABB")){define("WTG_C2P_ABB","csv2post_");}
if(!defined("WTG_C2P_URL")){define("WTG_C2P_URL", plugin_dir_url(__FILE__) );}//http://localhost/wordpress-testing/wtgplugintemplate/wp-content/plugins/wtgplugintemplate/
if(!defined("WTG_C2P_DIR")){define("WTG_C2P_DIR", plugin_dir_path(__FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/
      
require_once(WTG_C2P_DIR.'templatesystem/csv2post_load_templatesystem_constants.php'); 
if(is_admin()){require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_variables_adminconfig.php');}
require_once(WTG_C2P_DIR.'templatesystem/csv2post_load_admin_arrays_templatesystem.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_core_functions.php');// must be loaded before initialplugin_configuration.php
require_once(WTG_C2P_DIR.'templatesystem/csv2post_load_initialplugin_configuration.php');// must be loaded after core_functions.php
require_once(WTG_C2P_DIR.'templatesystem/include/webservices/csv2post_api_parent.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_admininterface_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_ajax_admin_functions.php');  
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_install_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_admin_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_sql_functions.php');
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_file_functions.php');// file management related functions
require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_post_functions.php');// post creation,update related functions              
require_once(WTG_C2P_DIR.'pages/csv2post_variables_tabmenu_array.php');
if(!$csv2post_is_free){require_once(WTG_C2P_DIR.'fulledition/csv2post_advanced_functions.php');}

####################################################
####                                            ####
####       LOAD ADMIN THAT MUST COME FIRST      ####
####                                            ####
####################################################  
if(is_admin()){ 
    register_activation_hook( __FILE__ ,'csv2post_register_activation_hook');
  
    // init custom post types and custom box
    // content template
    add_action( 'init', 'csv2post_register_customposttype_contentdesigns' );
    add_action( 'add_meta_boxes', 'csv2post_add_custom_boxes_contenttemplate' );
    add_action( 'save_post', 'csv2post_save_postdata_contenttemplate' );
    // title template
    add_action( 'init', 'csv2post_register_customposttype_titledesigns' );
    add_action( 'save_post', 'csv2post_save_postdata_titletemplate' );
    
    // initialise core admin only variables ### TODO:MEDIUMPRIORITY, remove variables from here that are always set later even if set to false       
    $csv2post_notice_array = csv2post_get_option_notifications_array();// holds interface notices/messages, some temporary, some are persistent 
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
    $csv2post_twitter = 'WPCSVImporter';
    $csv2post_feedburner = 'CSV2POST';
    $csv2post_currentproject = 'No Project Set'; 

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

###################################################
####                                           ####
####     LOAD MIDDLE VARIABLES AND SCRIPTS     ####
####                                           ####
###################################################     
// get data import jobs related variables
$csv2post_currentjob_code = csv2post_get_option_currentjobcode();
$csv2post_job_array = csv2post_get_dataimportjob($csv2post_currentjob_code);
$csv2post_jobtable_array = csv2post_get_option_jobtable_array(); 
$csv2post_dataimportjobs_array = csv2post_get_option_dataimportjobs_array();

// get post creation project related variables
$csv2post_currentproject_code = csv2post_get_current_project_code();
$csv2post_project_array = csv2post_get_project_array($csv2post_currentproject_code);
$csv2post_projectslist_array = csv2post_get_projectslist();
$csv2post_textspin_array = csv2post_get_option_textspin_array();
        
// get all other admin variables    
$csv2post_was_installed = csv2post_was_installed();// boolean - indicates if a trace of previous installation found       
$csv2post_schedule_array = csv2post_get_option_schedule_array();
$csv2post_panels_closed = true;// boolean true forces all panels closed, false opens them all

// add public actions
if(!$csv2post_is_free){
    // run auto post and data updating events if any are due
    add_action('init', 'csv2post_event_check');
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
        
    csv2post_script('admin');
    csv2post_css('admin');
    
    // display a message if any files are missing from package
    csv2post_templatefiles_missing(true);              
}
?>