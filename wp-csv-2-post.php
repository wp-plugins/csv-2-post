<?php
/*
	Plugin Name: CSV 2 POST
	Version: 0.4.4
	Plugin URI: http://www.csv2post.com
	Description: Professional edition of the CSV 2 POST wordpress plugin, import csv data to make wordpress posts in massive numbers!
	Author: Ryan Bayne
	Author URI: http://www.webtechglobal.co.uk
*/
global $wpdb;

// set error handler function
include('functions/reporting_functions.php');

// fix for mac users
ini_set('auto_detect_line_endings', 1);

// current edition - pro is full edition - free is download on wordpress - demo is online demo
$csv2post_edition = 'free';

// include PEAR csv function files
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){ini_set('include_path',rtrim(ini_get('include_path'),';').';'.dirname(__FILE__).'/pear/');} 
else{ini_set('include_path',rtrim(ini_get('include_path'),':').':'.dirname(__FILE__).'/pear/');}
require_once 'File/CSV.php';

// plugin activation and installation hook then functions
function init_campaigndata_tables_csv2post () 
{
	include('functions/config_functions.php');
	csv2post_databaseinstallation(0);
	csv2post_optionsinstallation(0);
}

// this function calls the function and post maker files only when required by scheduled campaigns		
function csv2post_cronscheduledcampaign() 
{
	csv2post_debug_write('Ran csv2post_processcheck function - File wp-csv-2-post - Scheduled campaign processing begun!');
	include_once( 'global_functions.php' );
	include( 'functions/postmaker_functions.php' );
	include('postmaker_csv2post.php');
}
			
// this function is called when a campaing requires processing
function csv2post_processcheck()
{
	csv2post_debug_write(__LINE__,__FILE__,'Run csv2post_processcheck function - Start');
	global $wpdb;

	// force waiting period between processing events basedo on user settings
	$t = get_option('csv2post_lastprocessingtime');
	$t = $t + get_option('csv2post_processingdelay');// add seconds to to the old time
	// do not attempt processing if the page load was done on a New Campaign process Stage
	if(isset($_GET['page']) && $_GET['page'] == 'newcampaign_csv2post')
	{
		csv2post_debug_write(__LINE__,__FILE__,'Processing rejected due to being new campaign admin page triggering it');
	}
	else
	{
		if($t < time())// if old time (extended) is less than current time then allow processing
		{	
			// set the current time for preventing further processing in none FULL modes within the time limit.
			update_option('csv2post_lastprocessingtime',time());// indicate processing ongoing
	
			$_SESSION['lastpage'] = $_SERVER['PHP_SELF']; // set current page into session and use on next page load to prevent processing if page not differrent
		
			$count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "csv2post_campaigns WHERE stage = '100' AND process != '3'");

			if( $count > 0 )// a full or staggered campaign is ongoing
			{
				// check if it is a scheduled campaign or staggered/full				
				csv2post_debug_write(__LINE__,__FILE__,'Run csv2post_processcheck function - Full or Staggered campaign found');
				include_once('functions/global_functions.php');
				include( 'functions/postmaker_functions.php' );
				include('postmaker_csv2post.php');
			}
			else // check scheduled campaigns - controlled by cron scheduling
			{
				csv2post_debug_write(__LINE__,__FILE__,'No Full or Staggered campaign found, now checking Scheduled');
				$count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = '100' AND process = '3'");
				
				if( $count > 0 )
				{
					add_action('cronschedulledprocessing','csv2post_cronscheduledcampaign');// checks if scheduled posts are due
				}
			}
		}
		else
		{
			csv2post_debug_write(__LINE__,__FILE__,'Timer has not yet expired since last processing event');
		}		
	}
}

// import css file for plugin only
function csv2post_plugincss() 
{
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}

// add action for detecting cloaked url click
function csv2post_processcloakedurlclick() 
{
	include('cloakedurls_csv2post.php');// processes click and forwards user to destination
}

// plugin admin pages
function csv2post_add_pages() 
{
	if(get_option('csv2post_demo') == 1){$i = 0;}else{$i = 8;}
	
	add_menu_page('CSV2POST PRO', 'CSV2POST PRO', $i, __FILE__, 'csv2post_toplevel_page');
    add_submenu_page(__FILE__, '1. CSV Uploader', '1. CSV Uploader', $i, 'uploader_csv2post', 'csv2post_sublevel_page7');
    add_submenu_page(__FILE__, '2. CSV Profiles', '2. CSV Profiles', $i, 'csvprofiles_csv2post', 'csv2post_sublevel_page6');
    add_submenu_page(__FILE__, '3. New Campaign', '3. New Campaign', $i, 'newcampaign_csv2post', 'csv2post_sublevel_page1');
    add_submenu_page(__FILE__, 'Manage Campaigns', 'Manage Campaigns', $i, 'managecampaigns_csv2post', 'csv2post_sublevel_page2');
    add_submenu_page(__FILE__, 'Settings', 'Settings', $i, 'settings_csv2post', 'csv2post_sublevel_page4');
    add_submenu_page(__FILE__, 'Tools', 'Tools', $i, 'tools_csv2post', 'csv2post_sublevel_page5');
}

function csv2post_toplevel_page() 
{
	include_once('functions/global_functions.php');
    include('main_page.php');
}

function csv2post_sublevel_page1() 
{
	include_once('functions/global_functions.php');
	include('newcampaign_csv2post.php');
}
function csv2post_sublevel_page2() 
{
	include_once('functions/global_functions.php');
	include('editcampaign_csv2post.php');
}
function csv2post_sublevel_page4() 
{
	include_once('functions/global_functions.php');
	include('settings_csv2post.php');
}
function csv2post_sublevel_page5() 
{
	include_once('functions/global_functions.php');
	include('tools_csv2post.php');
}
function csv2post_sublevel_page6() 
{
	include_once('functions/global_functions.php');
	include('profiles_csv2post.php');
}
function csv2post_sublevel_page7() 
{
	include_once('functions/global_functions.php');
	include('csvuploader_csv2post.php');
}

// do hooks and actions
add_action('admin_menu', 'csv2post_add_pages',0);
register_activation_hook(__FILE__,'init_campaigndata_tables_csv2post');
add_action('status_header', 'csv2post_processcloakedurlclick');
add_action('admin_head', 'csv2post_plugincss');

if( $csv2post_edition == 'pro' ||  $csv2post_edition == 'demo')
{
	add_action(get_option('csv2post_processingtrigger'), 'csv2post_processcheck');// trigger processing
}
?>