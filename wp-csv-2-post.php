<?php
/*
Plugin Name: CSV 2 POST
Version: 3.1
Plugin URI: http://www.csv2post.com
Description: Import csv data files including feeds from affiliate using interface only, no need to edit csv file!
Author: Ryan Bayne
Author URI: http://www.webtechglobal.co.uk

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$testmode = 0; // 1 = on and 0 = off
if($testmode == 1)
{
	$wpdb->show_errors();
	ini_set('display_errors',1);
	error_reporting(E_ALL);
}

// installation
function campaigndata_tables_wtg_csv2post () 
{
	require('db_tables.php');
}
register_activation_hook(__FILE__,'campaigndata_tables_wtg_csv2post');

// processing check
function wtg_csvtopost_processcheck()
{ 
    if(isset($_SESSION['csvtopostpage']) && $_SESSION['csvtopostpage'] == $_SERVER['PHP_SELF'])
    {
    	# DO NOTHING – the current page has not change from the last page load so do not begin process and this approach will hopefully allow plugins like XML-Sitemap and WP-to-Twitter to do their job, trigger page loads but not trigger further processing in CSV 2 POST.
    }
    else
    {
		# TRIGGER CSV 2 POST PROCESSING
		$_SESSION['csvtopostpage'] = $_SERVER['PHP_SELF']; // set current page into session and use on next page load to prevent processing if page not differrent

		# CHECK FULL PROCESSING TRIAL STATUS
		global $wpdb;
		
		$full_trial_used_csv2post = get_option( "full_trial_used_csv2post" );
		
		if($full_trial_used_csv2post != true)
		{	
			# ANY PROCESS CAN BE USED
			$count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = '100'");
		}
		else
		{
			# ONLY STAGGERED PROCESSING CAN BE USED
			$count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = '100' AND process = '2'");
		}
		
		if( $count > 0 )
		{
			ini_set('auto_detect_line_endings', '1');
			include_once('functions.php');
			include('post-maker.php');
		}
		else
		{			
			# DO NOTHING AS THERE ARE NO CAMPAIGNS TO RUN
		}
	}
}

add_action('shutdown', 'wtg_csvtopost_processcheck');// trigger processing

// Hook for adding admin menus
add_action('admin_menu', 'wtg_csv2post_add_pages');

// action function for above hook
function wtg_csv2post_add_pages() 
{
    add_menu_page('CSV 2 POST', 'CSV 2 POST', 8, __FILE__, 'wtg_csv2post_toplevel_page');
    add_submenu_page(__FILE__, 'New Campaign', 'New Campaign', 8, 'newcampaign_csv2post', 'wtg_csv2post_sublevel_page1');
    add_submenu_page(__FILE__, 'Manage Campaigns', 'Manage Campaigns', 8, 'managecampaigns_csv2post', 'wtg_csv2post_sublevel_page2');
    add_submenu_page(__FILE__, 'Disclaimer', 'Disclaimer', 8, 'disclaimer_csv2post', 'wtg_csv2post_sublevel_page3');
    add_submenu_page(__FILE__, 'Settings', 'Settings', 8, 'settings_csv2post', 'wtg_csv2post_sublevel_page4');
    add_submenu_page(__FILE__, 'Tools', 'Tools', 8, 'tools_csv2post', 'wtg_csv2post_sublevel_page5');
}

function wtg_csv2post_toplevel_page() 
{
	include_once('functions.php');
    require('mainpage_csv2post.php');
}

function wtg_csv2post_sublevel_page1() 
{
	ini_set('auto_detect_line_endings', '1');
	include_once('functions.php');
	require('newcampaign_csv2post.php');
}

function wtg_csv2post_sublevel_page2() 
{
	include_once('functions.php');
	require('editcampaign_csv2post.php');
}

function wtg_csv2post_sublevel_page3() 
{
	include_once('functions.php');
	require('disclaimer_csv2post.php');?>

	<script type="text/javascript"><!--
	google_ad_client = "pub-4923567693678329";
	/* 728x90, created 7/18/09 */
	google_ad_slot = "1325545528";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
    
	<?php
	require('gnu-gpl.php');
	?>
    
    <script type="text/javascript"><!--
	google_ad_client = "pub-4923567693678329";
	/* 728x90, created 7/18/09 */
	google_ad_slot = "1325545528";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script><?php
}

function wtg_csv2post_sublevel_page4() 
{
	include_once('functions.php');
	require('settings_csv2post.php');
}
function wtg_csv2post_sublevel_page5() 
{
	include_once('functions.php');
	require('toolscsv2post_csv2post.php');
}
?>