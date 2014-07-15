<?php         
/*
Plugin Name: CSV 2 POST
Version: 8.0.3
Plugin URI: http://www.webtechglobal.co.uk
Description: CSV 2 POST data importer for Wordpress by Ryan Bayne @WebTechGlobal.
Author: Ryan Bayne
Author URI: http://www.webtechglobal.co.uk
Last Updated: July 2014
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
  
// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'Direct script access is not allowed!' );
       
// package variables
$c2p_currentversion = '8.0.3';# to be removed, version is now in the CSV2POST() class 
$c2p_debug_mode = false;# to be phased out, going to use environment variables (both WP and php.ini instead)
$edition = 'free';// free or paid
              
// go into dev mode if on test installation               
if( strstr( ABSPATH, 'csv2post' ) ){
    $c2p_debug_mode = true;     
}                

// avoid error output when...              
if ( ( 'wp-login.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) ) // Login screen
        || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST )
        || ( defined( 'DOING_CRON' ) && DOING_CRON )
        || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
    $c2p_debug_mode = false;
}                   
         
// other variables required on installation or loading
$c2p_is_event = false;// locally stored value is used to prevent too much automation         
$c2p_installation_required = true;                                                     
$c2p_is_installed = false;        
$c2p_notice_array = array();// set notice array for storing new notices in (not persistent notices)                         

// define constants                              
if(!defined( "WTG_CSV2POST_NAME") ){define( "WTG_CSV2POST_NAME", 'CSV 2 POST' );} 
if(!defined( "WTG_CSV2POST__FILE__") ){define( "WTG_CSV2POST__FILE__", __FILE__);}
if(!defined( "WTG_CSV2POST_BASENAME") ){define( "WTG_CSV2POST_BASENAME",plugin_basename( WTG_CSV2POST__FILE__ ) );}
if(!defined( "WTG_CSV2POST_ABSPATH") ){define( "WTG_CSV2POST_ABSPATH", plugin_dir_path( __FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/  
if(!defined( "WTG_CSV2POST_PHPVERSIONMINIMUM") ){define( "WTG_CSV2POST_PHPVERSIONMINIMUM", '5.3.0' );}// The minimum php version that will allow the plugin to work                                
if(!defined( "WTG_CSV2POST_IMAGES_URL") ){define( "WTG_CSV2POST_IMAGES_URL",plugins_url( 'images/' , __FILE__ ) );}
if(!defined( "WTG_CSV2POST_FREE") ){define( "WTG_CSV2POST_FREE", $edition );} 
        
// require main class
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-csv2post.php' );

// new plugin load approach, fire a single class, make more use of $this and less use of global
add_action( 'init', array( 'CSV2POST', 'run' ) );
// the goal is for everything below this line to be removed
                
// include core functions and arrays (many which apply to all WTG plugins)               
require_once( WTG_CSV2POST_ABSPATH . 'arrays/options_array.php' );
require_once( WTG_CSV2POST_ABSPATH . 'arrays/tableschema_array.php' ); 
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-charts.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-flags.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-install.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-phplibrary.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-ui.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-updates.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-wpdb.php' );     

// install class (includes update and surgical installation tools) 
$C2P_Install = new C2P_Install();
$C2P_Install->current_version = $c2p_currentversion;

// these objects are being phased out slowly to reduce overhead in every loading
$C2P_DB = new C2P_DB();# this class is loaded in CSV2POST() __construct() and only needs to be called 
$CSV2POST = new CSV2POST();# this is the main class and might be harder to phase out so caution must be taking
$C2P_UI = new C2P_UI();# this class is loaded in CSV2POST() __construct() and global use of $C2P_UI should be phased out asap      
   
$CSV2POST->wp_init();                                                                             
$c2p_settings = $CSV2POST->adminsettings();
$CSV2POST->custom_post_types();
$CSV2POST->debugmode();    
$c2p_is_installed = $CSV2POST->is_installed();// boolean - if false either plugin has never been installed or installation has been tampered with 

// admin only values (these are arrays that contain data that should never be displayed on public side, load them admin side only reduces a fault causing display of the information)
if( is_admin() ){
    $c2p_persistent_array = $C2P_UI->persistentnotifications_array();// holds interface notices/messages, some temporary, some are persistent 
}   

// load admin that comes last and applys to CSV 2 POST plugin pages only
if( is_admin() && isset( $_GET['page'] ) && $CSV2POST->is_plugin_page( $_GET['page'] ) ){
    $CSV2POST->css_core( 'admin' );// script and css admin side       
}elseif(!is_admin() ){
    // default to public side script and css      
    $CSV2POST->css_core( 'public' );    
}  

function csv2post_textdomain() {
    load_plugin_textdomain( 'csv2post', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action( 'plugins_loaded', 'csv2post_textdomain' );                                                                                                                  
?>