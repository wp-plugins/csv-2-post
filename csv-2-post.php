<?php         
/*
Plugin Name: CSV 2 POST
Version: 8.0.0
Plugin URI: http://www.webtechglobal.co.uk
Description: CSV 2 POST data importer for Wordpress has been around for years and has reached version 8.0.0 thanks to the support from users.
Author: Ryan Bayne
Author URI: http://www.webtechglobal.co.uk
Last Updated: February 2014
Text Domain: csv2post
Domain Path: /languages

CSV 2 POST Free Edition License (does not apply to premium edition)

GPL v3 

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
  
if ( ! defined( 'ABSPATH' ) ) {exit;}
                                 
// package variables
$c2p_currentversion = '8.0.0'; 
$c2p_debug_mode = false;
$c2p_is_beta = false;// expect beta mode until 2014 - hides partialy completed features or information not true until features complete
$c2p_is_dev = false;// true will display more information i.e. array dumps using var_dump() 
$c2p_is_free = false;// change to false when premium phase of development begins (from then on free edition is updated independently)
                                            
// go into dev mode if on test installation               
if(strstr(ABSPATH,'csv2post'))
{
    $c2p_debug_mode = true; 
    $c2p_is_beta = true;// we do not want to hide partially completed features or information for those features
    $c2p_is_dev = true;
    $c2p_is_free_override = true;// toggle free/paid modes even when paid folder present      
}                

// error output should never be on during AJAX requests               
if(defined('DOING_AJAX') && DOING_AJAX){
    $c2p_debug_mode = false;    
}                   
         
// other variables required on installation or loading
$c2p_is_event = false;// when true, an event is running or has ran, used to avoid over processing         
$c2p_installation_required = true;                                                     
$c2p_is_installed = false;        
$c2p_notice_array = array();// set notice array for storing new notices in (not persistent notices)
$c2p_extension_loaded = false;                          
if(file_exists(plugin_dir_path(__FILE__) . 'paidedition') && isset($c2p_is_free_override) && $c2p_is_free_override == false){
    $c2p_is_free = false;
}

// define constants                              
if(!defined("WTG_CSV2POST_NAME")){define("WTG_CSV2POST_NAME",'CSV 2 POST');} 
if(!defined("WTG_CSV2POST_PATH")){define("WTG_CSV2POST_PATH", plugin_dir_path(__FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/  
if(!defined("WTG_CSV2POST_PHPVERSIONMINIMUM")){define("WTG_CSV2POST_PHPVERSIONMINIMUM",'5.3.0');}// The minimum php version that will allow the plugin to work                                

// initiate plugin (this is a new class approach being slowly introduced to a function only plugin, expect gradual reduction of this file per version)
if( !class_exists( 'CSV2POST' ) ) 
{                    
    // include core functions and arrays (many which apply to all WTG plugins)               
    require_once(WTG_CSV2POST_PATH.'arrays/options_array.php');
    require_once(WTG_CSV2POST_PATH.'arrays/sections_array.php');
    require_once(WTG_CSV2POST_PATH.'arrays/tableschema_array.php'); 
    
    // include section functions
    global $c2p_sections_array;
    foreach ($c2p_sections_array as $section => $section_array){if($section_array['active'] === true){foreach(glob(WTG_CSV2POST_PATH.'functions/sections/'.$section."/*.php") as $filename){include $filename;}}} 
            
    // WebTechGlobal Wordpress classes - chained (use $C2P_WP to call methods)
    
    require_once(WTG_CSV2POST_PATH . 'functions/class/wpmain.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/charts.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/flags.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/install.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/notice.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/phplibrary.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/ui.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/updates.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/wpdb.php');
    require_once(WTG_CSV2POST_PATH . 'functions/class/main.php');

    // integration classes (third party plugins, themes, platforms and web services)
    if(defined('WP_ESTORE_VERSION') && defined('WP_ESTORE_DB_VERSION') ){
        require_once(WTG_CSV2POST_PATH . 'functions/integrationclasses/wpestore_class.php');
    }

    // install class (includes update and surgical installation tools) 
    $C2P_Install = new C2P_Install();
    $C2P_Install->current_version = $c2p_currentversion;
    
    // these class objects help in the development of a large project with hundreds of functions
    $C2P_DB = new C2P_WPDB();// common database methods making development simple (also extended by C2P_WP)
    $C2P_WP = new C2P_WP();// strictly Wordpress functions/methods for all WTG plugins 
    $CSV2POST = new CSV2POST();
    $C2P_UI = new C2P_ui();    
}  
   
$CSV2POST->wp_init();                                                                             
$c2p_settings = $CSV2POST->adminsettings();
$CSV2POST->custom_post_types();
$CSV2POST->debugmode();    
$c2p_is_installed = $CSV2POST->is_installed();// boolean - if false either plugin has never been installed or installation has been tampered with 

// admin only values (these are arrays that contain data that should never be displayed on public side, load them admin side only reduces a fault causing display of the information)
if(is_admin()){
    $c2p_persistent_array = $C2P_WP->persistentnotifications_array();// holds interface notices/messages, some temporary, some are persistent 
    $c2p_mpt_arr = $CSV2POST->tabmenu();
}   

// load admin that comes last and applys to CSV 2 POST plugin pages only
if(is_admin() && isset($_GET['page']) && $C2P_WP->is_plugin_page($_GET['page']))
{
    $C2P_WP->css_core('admin');// script and css admin side       
}
elseif(!is_admin())
{
    // default to public side script and css      
    $C2P_WP->css_core('public');    
}  

function csv2post_textdomain() {
    load_plugin_textdomain( 'csv2post', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action('plugins_loaded', 'csv2post_textdomain');                                                                                                                     
?>