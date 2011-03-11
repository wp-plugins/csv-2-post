<?php
/*
	Plugin Name: CSV 2 POST Free Data Importer
	Version: 4.3
	Plugin URI:http://www.csv2post.com
	Description: CSV 2 POST imports data to database very easily, then creates posts with it and if you hire us we can provide the customisation needed for automatic updating,displaying content in widgets and much more. This is the professionals choice of plugin and the service to support your clients.
	Author: WebTechGlobal
	Author URI: http://www.csv2post.co.uk
*/
//ini_set('display_errors',1);
//error_reporting(E_ALL);
// installation trigger
register_activation_hook( __FILE__ ,'c2pf_activate');
function c2pf_activate()
{
	require_once('functions/c2pf_f_install.php');
	c2pf_install_options();
}

// include variables
require_once('includes/c2pf_i_variables.php');

// load hooks
require_once('includes/c2pf_i_hooks.php');

// load shortcodes
require_once('functions/c2pf_f_shortcodes.php');

// load resources specific to user - this allows us to seperate admin only functions or public only
if( is_admin() )
{	
	// get functions for admin users
	require_once('functions/c2pf_f_global.php');
	require_once('functions/c2pf_f_data.php');
	require_once('functions/c2pf_f_interface.php');
	require_once('functions/c2pf_f_process.php');
	require_once('functions/c2pf_f_admin.php');
	require_once('functions/c2pf_f_install.php');
}

// include pear csv functions
function c2pf_pearcsv_include()
{
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){ini_set('include_path',rtrim(ini_get('include_path'),';').';'.dirname(__FILE__).'/pear/');} 
	else{ini_set('include_path',rtrim(ini_get('include_path'),':').':'.dirname(__FILE__).'/pear/');}
	require_once 'File/CSV.php';
}
?>