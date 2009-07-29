<?php
/*
Plugin Name: CSV 2 POST
Version: 1.4
Plugin URI: http://www.webtechglobal.co.uk/wordpress-services/wordpress-csv-2-post-plugin
Description: Turns CSV data rows into posts with high seo per post
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
	
# GET GLOBAL FUNCTIONS
require('functions.php');

# INSTANTIATE DATABASE CONNECTION
global $wpdb;

# INITIALISE HOOKS
// ensure database has been installed for main table
add_action("plugins_loaded", "init_csvtopost_campaigndata_tabele_wtg");

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// hook for checking processing requirements during page load
add_action('wp', 'wtg_csvtopost_processcheck');// trigger processing - in the footer causes looping problems

// action function for above hook
function mt_add_pages() 
{
    // Add a new top-level menu (ill-advised):
    add_menu_page('CSV 2 POST', 'CSV 2 POST', 8, __FILE__, 'wtg_toplevel_page');
    // Add a submenu to the custom top-level menu:
    add_submenu_page(__FILE__, 'New Campaign', 'New Campaign', 8, 'new_campaign', 'wtg_sublevel_page1');
    // Add a second submenu to the custom top-level menu:
    add_submenu_page(__FILE__, 'Manage Campaigns', 'Manage Campaigns', 8, 'manage_campaigns', 'wtg_sublevel_page2');
    // Add a third submenu to the custom top-level menu:
    add_submenu_page(__FILE__, 'Disclaimer', 'Disclaimer', 8, 'disclaimer', 'wtg_sublevel_page3');
}

// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function wtg_toplevel_page() 
{
    require('main_page.php');
}

// mt_sublevel_page() displays the page content for the first submenu
// of the custom Test Toplevel menu
function wtg_sublevel_page1() 
{
	require('new_campaign.php');
}

// mt_sublevel_page2() displays the page content for the second submenu
// of the custom Test Toplevel menu
function wtg_sublevel_page2() 
{
	require('edit_campaign.php');
}

// sub menu for disclaimer, terms and conditions
function wtg_sublevel_page3() 
{
	require('disclaimer.php');
	require('gnu-gpl.php');
}
?>