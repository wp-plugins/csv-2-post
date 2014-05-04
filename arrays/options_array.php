<?php 
/** 
* Array of core option record values for installation related procedures in CSV 2 POST plugin 
* 
* @link by http://www.webtechglobal.co.uk
* 
* @author Ryan Bayne 
*
* @package CSV 2 POST
*/

$total_option_records = 0;// used to count total options and assign count to label
$c2p_options_array = array();
++$total_option_records;
// indicates if the options, tables and other installation changes altogether equal an installed state
$c2p_options_array['csv2post_is_installed']['datatype'] = 'boolean';// array,boolean,string etc
$c2p_options_array['csv2post_is_installed']['purpose'] = __('Indicates result of last installation status check, should hold value true for normal operation else an element of installation is missing.','csv2post');
$c2p_options_array['csv2post_is_installed']['name'] = __('Installation Switch','csv2post');
$c2p_options_array['csv2post_is_installed']['inputtype'] = 'hidden';
$c2p_options_array['csv2post_is_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$c2p_options_array['csv2post_is_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$c2p_options_array['csv2post_is_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
// main settings array now for public side also 
++$total_option_records;
$c2p_options_array['csv2post_settings']['datatype'] = 'array';// array,boolean,string etc
$c2p_options_array['csv2post_settings']['purpose'] = __('Settings for the administrator/backend only. These settings effect things that are to do with the backend only. They configure manual actions, tools and operations triggered by backend use.','csv2post');
$c2p_options_array['csv2post_settings']['name'] = __('Administration Settings','csv2post');
$c2p_options_array['csv2post_settings']['inputtype'] = 'hidden';
$c2p_options_array['csv2post_settings']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script
$c2p_options_array['csv2post_settings']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$c2p_options_array['csv2post_settings']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
// current installed version (in terms of options, database tables etc, not files)
$c2p_options_array['csv2post_installedversion']['datatype'] = 'string';
$c2p_options_array['csv2post_installedversion']['purpose'] = __('Used to determine gap between old and new version.','csv2post');
$c2p_options_array['csv2post_installedversion']['name'] = __('Latest Version','csv2post');
$c2p_options_array['csv2post_installedversion']['inputtype'] = 'hidden';
$c2p_options_array['csv2post_installedversion']['defaultvalue'] = '0.0.0';
$c2p_options_array['csv2post_installedversion']['public'] = 'false';
$c2p_options_array['csv2post_installedversion']['required'] = 'true';
// installation date
$c2p_options_array['csv2post_installeddate']['datatype'] = 'integer';
$c2p_options_array['csv2post_installeddate']['purpose'] = __('Date last full installation was run','csv2post');
$c2p_options_array['csv2post_installeddate']['name'] = __('Install Date','csv2post');
$c2p_options_array['csv2post_installeddate']['inputtype'] = 'hidden';
$c2p_options_array['csv2post_installeddate']['defaultvalue'] = time();
$c2p_options_array['csv2post_installeddate']['public'] = 'false';
$c2p_options_array['csv2post_installeddate']['required'] = 'true'; 
?>