<?php
/*
Plugin Name: Wordpress CSV Importer
Version: 0.0.2
Plugin URI: http://www.importcsv.eu
Description: Wordpress CSV Importer released 2012 by Zara Walsh
Author: Zara Walsh
Author URI: http://www.importcsv.eu
Free Edition License: GPL v3

WordPress CSV Importer
Copyright (C) 20011-2012, Zara Walsh - zara@importcsv.eu

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

$wtgcsv_debug_mode = true;// boolean true or false
if(!is_admin() || defined('DOING_AJAX') && DOING_AJAX){
    $wtgcsv_debug_mode = false;
}

### TODO:HIGHPRIORITY, detect paid edition folder automatically, if not found set as free edition
$wtgcsv_is_free = false;// changing this in free copy does not activate a paid edition, it may break the plugin
$wtgcsv_is_dev = true;// boolean, true displays more panels with even more data i.e. array dumps
$wtgcsv_currentversion = '0.0.2';// this value should not be relied on but only used for guidance
$wtgcsv_php_version_tested = '5.3.1';// current version the plugin is being developed on
$wtgcsv_php_version_minimum = '5.3.1';// minimum version required for plugin to operate
$wtgcsv_pluginname = 'wordpresscsvimporter';// should not be used to make up paths
$wtgcsv_homeslug = $wtgcsv_pluginname;// @todo page slug for plugin main page used in building menus
$wtgcsv_isbeingactivated = false;
$wtgcsv_disableapicalls = 0;// 1 = yes, disable all api calls 0 allows api calls
$wtgcsv_is_event = false;// when true, an event is running or has ran, used to avoid over processing 
$wtgcsv_csvmethod = 1;// 0=PEAR CSV 1=fget/fgetcsv only         
$wtgcsv_nav_type = 'jquery';// css,jquery,nonav (changes the navigation, we can adapt this as much as required)

##########################################################################################
#                                                                                        #
#               LOAD CORE VARIABLES AND FILES FOR BOTH PUBLIC AND ADMIN                  #
#                                                                                        #
##########################################################################################                 
if(!defined("WTG_CSV_ABB")){define("WTG_CSV_ABB","wtgcsv_");}
if(!defined("WTG_CSV_URL")){define("WTG_CSV_URL", plugin_dir_url(__FILE__) );}//http://localhost/wordpress-testing/wtgplugintemplate/wp-content/plugins/wtgplugintemplate/
if(!defined("WTG_CSV_DIR")){define("WTG_CSV_DIR", plugin_dir_path(__FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/
      
require_once(WTG_CSV_DIR.'templatesystem/wtgcsv_load_templatesystem_constants.php'); 
if(is_admin()){require_once(WTG_CSV_DIR.'templatesystem/include/variables/wtgcsv_variables_adminconfig.php');}
require_once(WTG_CSV_DIR.'templatesystem/wtgcsv_load_admin_arrays_templatesystem.php');
require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_core_functions.php');// must be loaded before initialplugin_configuration.php
require_once(WTG_CSV_DIR.'templatesystem/wtgcsv_load_initialplugin_configuration.php');// must be loaded after core_functions.php
require_once(WTG_CSV_DIR.'templatesystem/include/webservices/wtgcsv_api_parent.php');
require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_admininterface_functions.php');
require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_ajax_admin_functions.php');  
require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_install_functions.php');
require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_admin_functions.php');
require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_sql_functions.php');
require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_file_functions.php');// file management related functions
require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_post_functions.php');// post creation,update related functions              
require_once(WTG_CSV_DIR.'pages/wtgcsv_variables_tabmenu_array.php');
if(!$wtgcsv_is_free){require_once(WTG_CSV_DIR.'fulledition/wtgcsv_advanced_functions.php');}

// run auto post and data updating events if any are due
if(!$wtgcsv_is_free){add_action('init', 'wtgcsv_event_check');}

//add_action('the_posts', 'eci_updatethepost' );// this will be used for updating posts being queried

####################################################
####                                            ####
####       LOAD ADMIN THAT MUST COME FIRST      ####
####                                            ####
####################################################  
if(is_admin()){ 
    register_activation_hook( __FILE__ ,'wtgcsv_register_activation_hook');
      
    // initialise core admin only variables ### TODO:MEDIUMPRIORITY, remove variables from here that are always set later even if set to false       
    $wtgcsv_notice_array = wtgcsv_get_option_notifications_array();// holds interface notices/messages, some temporary, some are persistent 
    $wtgcsv_installation_required = true;
    $wtgcsv_apiservicestatus = 'unknown';
    $wtgcsv_is_webserviceavailable = false;                                                       
    $wtgcsv_is_subscribed = false;
    $wtgcsv_is_installed = false;        
    $wtgcsv_was_installed = false;
    $wtgcsv_is_domainregistered = false;
    $wtgcsv_is_emailauthorised = false;
    $wtgcsv_log_maindir = 'unknown';
    $wtgcsv_callcode = '000000000000';
    $wtgcsv_twitter = 'WPCSVImporter';
    $wtgcsv_feedburner = 'wordpresscsvimporter';
    $wtgcsv_currentproject = 'No Project Set'; 

    //$wtgcsv_activationcode = wtgcsv_get_activationcode(); ### TODO:MEDIUMPRIORITY, part of activation code system 
    $wtgcsv_is_installed = wtgcsv_is_installed();// boolean - if false either plugin has never been installed or installation has been tampered with 
    if(!$wtgcsv_is_free){
        //$wtgcsv_is_webserviceavailable = wtgcsv_is_webserviceavailable();
    }else{
        $wtgcsv_is_webserviceavailable == false;
    }
    
    // if web services are available, we can then check if domain is registered or not
    if(!$wtgcsv_is_free && $wtgcsv_is_webserviceavailable){
        
        # TODO: CRITICAL, change call code design so that it does not expire but may be changed from time to time
        # TODO: CRITICAL, once call code does not expire, avoid using wtgcsv_is_domainregistered() every page call, leave a local value indicating domain is registered 
        
        $wtgcsv_is_domainregistered = wtgcsv_is_domainregistered();// returns boolean AND stores call code 
        
        // if domain is within membership then we can continue doing further api calls 
        if($wtgcsv_is_domainregistered){
            
            // continue other api calls
            $wtgcsv_callcode = get_option('wtgcsv_callcode');                              
            $wtgcsv_is_callcodevalid = wtgcsv_is_callcodevalid();
            //$wtgcsv_is_subscribed = wtgcsv_is_subscribed();// returns boolean       
        }
    }
}

###################################################
####                                           ####
####     LOAD MIDDLE VARIABLES AND SCRIPTS     ####
####                                           ####
###################################################     
// get data import jobs related variables
$wtgcsv_currentjob_code = wtgcsv_get_option_currentjobcode();
$wtgcsv_job_array = wtgcsv_get_dataimportjob($wtgcsv_currentjob_code);
$wtgcsv_jobtable_array = wtgcsv_get_option_jobtable_array(); 
$wtgcsv_dataimportjobs_array = wtgcsv_get_option_dataimportjobs_array();

// get post creation project related variables
$wtgcsv_currentproject_code = wtgcsv_get_current_project_code();
$wtgcsv_project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);
$wtgcsv_projectslist_array = wtgcsv_get_projectslist();
$wtgcsv_textspin_array = wtgcsv_get_option_textspin_array();
        
// get all other admin variables    
$wtgcsv_was_installed = wtgcsv_was_installed();// boolean - indicates if a trace of previous installation found       
$wtgcsv_schedule_array = wtgcsv_get_option_schedule_array();
$wtgcsv_panels_closed = true;// boolean true forces all panels closed, false opens them all

####################################################
####                                            ####
####               Add Shortcodes               ####
#### We will only add shortcodes when rules set ####
####################################################
if(!$wtgcsv_is_free){
    // add less advanced shortcodes, those that use values in shortcode itself
    add_shortcode( 'wtgcsv_random_basic', 'wtgcsv_shortcode_textspinning_randombasic' );
    
    if(isset($wtgcsv_textspin_array['randomvalue'])){
        add_shortcode( 'wtgcsv_random_advanced', 'wtgcsv_shortcode_textspinning_randomadvanced' );    
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
    if(!isset($wtgcsv_isbeingactivated) || isset($wtgcsv_isbeingactivated) && $wtgcsv_isbeingactivated != true){
        $looped = 0;
        // loop through pages in page array
        foreach($wtgcsv_mpt_arr as $key=>$pagearray){
            // if admin url contains the page value and we have a slug (should do) - are the equal
            // this prevents the plugins scripts loading unless we are on the plugins own pages
            if (isset($_GET['page']) && isset($pagearray['slug']) && $_GET['page'] == $pagearray['slug']){
                add_action( 'wp_print_scripts', 'wtgcsv_print_admin_scripts' );
            }
            ++$looped;
        }
    }        
    
    add_action('admin_menu','wtgcsv_admin_menu');// main navigation 
    add_action('init','wtgcsv_export_singlesqltable_as_csvfile');// export CSV file request by $_POST
        
    wtgcsv_script('admin');
    wtgcsv_css('admin');
    
    // display a message if any files are missing from package
    wtgcsv_templatefiles_missing(true);              
}
?>