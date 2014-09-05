<?php         
/*
Plugin Name: CSV 2 POST
Version: 8.0.34
Plugin URI: http://www.webtechglobal.co.uk
Description: CSV 2 POST data importer for Wordpress by Ryan Bayne @WebTechGlobal.
Author: Ryan Bayne
Author URI: http://www.webtechglobal.co.uk
Last Updated: September 2014
Text Domain: csv2post
Domain Path: /languages

CSV 2 POST Free Edition License (does not apply to pro edition)

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
$c2p_currentversion = '8.0.34';# to be removed, version is now in the CSV2POST() class 
$c2p_debug_mode = false;# to be phased out, going to use environment variables (both WP and php.ini instead)

// go into dev mode if on test installation               
if( strstr( ABSPATH, 'csv2post' ) ){
    $c2p_debug_mode = false;     
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
$c2p_notice_array = array();// set notice array for storing new notices in (not persistent notices)                         

// define constants                              
if(!defined( "WTG_CSV2POST_NAME") ){define( "WTG_CSV2POST_NAME", 'CSV 2 POST' );} 
if(!defined( "WTG_CSV2POST__FILE__") ){define( "WTG_CSV2POST__FILE__", __FILE__);}
if(!defined( "WTG_CSV2POST_BASENAME") ){define( "WTG_CSV2POST_BASENAME",plugin_basename( WTG_CSV2POST__FILE__ ) );}
if(!defined( "WTG_CSV2POST_ABSPATH") ){define( "WTG_CSV2POST_ABSPATH", plugin_dir_path( __FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/  
if(!defined( "WTG_CSV2POST_PHPVERSIONMINIMUM") ){define( "WTG_CSV2POST_PHPVERSIONMINIMUM", '5.3.0' );}// The minimum php version that will allow the plugin to work                                
if(!defined( "WTG_CSV2POST_IMAGES_URL") ){define( "WTG_CSV2POST_IMAGES_URL",plugins_url( 'images/' , __FILE__ ) );}
if(!defined( "WTG_CSV2POST_FREE") ){define( "WTG_CSV2POST_FREE", 'paid' );} 
        
// require main class
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-csv2post.php' );

// new plugin load approach, fire a single class, make more use of $this and less use of global
add_action( 'init', array( 'CSV2POST', 'run' ) );
// the goal is for everything below this line to be removed
                
// include core functions and arrays (many which apply to all WTG plugins)   
# these are to be removed but will require further work and testing            
require_once( WTG_CSV2POST_ABSPATH . 'arrays/options_array.php' );
require_once( WTG_CSV2POST_ABSPATH . 'arrays/tableschema_array.php' ); 
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-charts.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-flags.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-install.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-phplibrary.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-ui.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-updates.php' );
require_once( WTG_CSV2POST_ABSPATH . 'classes/class-wpdb.php' );     

// these objects are being phased out slowly to reduce overhead in every loading
$CSV2POST = new CSV2POST();# this is the main class and might be harder to phase out so caution must be taking
    
$CSV2POST->wp_init();                                                                             
$c2p_settings = $CSV2POST->adminsettings();
$CSV2POST->custom_post_types();
$CSV2POST->debugmode();    

function csv2post_textdomain() {
    load_plugin_textdomain( 'csv2post', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action( 'plugins_loaded', 'csv2post_textdomain' );                                                                                                                  
?>