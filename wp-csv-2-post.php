<?php
/*
	Plugin Name: CSV 2 POST Free Edition
	Version: 0.4.6
	Plugin URI: http://www.csv2post.com
	Description: Professional edition of the CSV 2 POST wordpress plugin, import csv data to make wordpress posts in massive numbers!
	Author: Ryan Bayne
	Author URI: http://www.webtechglobal.co.uk
*/
global $wpdb;

// set error handler function
include_once('functions/reporting_functions.php');

// fix for mac users
ini_set('auto_detect_line_endings', 1);


// include PEAR csv function files
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){ini_set('include_path',rtrim(ini_get('include_path'),';').';'.dirname(__FILE__).'/pear/');} 
else{ini_set('include_path',rtrim(ini_get('include_path'),':').':'.dirname(__FILE__).'/pear/');}
require_once 'File/CSV.php';

// plugin activation and installation hook then functions
function init_campaigndata_tables_csv2post () 
{
	include_once('functions/config_functions.php');
	csv2post_databaseinstallation(0);
	csv2post_optionsinstallation(0);
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
add_action('admin_head', 'csv2post_plugincss');
?>