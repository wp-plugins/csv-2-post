<?php 
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */

$total_option_records = 0;// used to count total options and assign count to label
$csv2post_options_array = array();
++$total_option_records;
# is_installed, result of last installation status check
$csv2post_options_array['csv2post_is_installed']['datatype'] = 'boolean';// array,boolean,string etc
$csv2post_options_array['csv2post_is_installed']['purpose'] = 'Indicates result of last installation status check, should hold value true for normal operation else an element of installation is missing.';
$csv2post_options_array['csv2post_is_installed']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array['csv2post_is_installed']['name'] = 'Installation Switch';
$csv2post_options_array['csv2post_is_installed']['inputtype'] = 'hidden';
$csv2post_options_array['csv2post_is_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$csv2post_options_array['csv2post_is_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$csv2post_options_array['csv2post_is_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# is_installed, result of last installation status check
$csv2post_options_array['csv2post_was_installed']['datatype'] = 'boolean';// array,boolean,string etc
$csv2post_options_array['csv2post_was_installed']['purpose'] = 'Ins but not all.';
$csv2post_options_array['csv2post_was_installed']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array['csv2post_was_installed']['name'] = 'Installation Switch';
$csv2post_options_array['csv2post_was_installed']['inputtype'] = 'hidden';
$csv2post_options_array['csv2post_was_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$csv2post_options_array['csv2post_was_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$csv2post_options_array['csv2post_was_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# admin settings
++$total_option_records;
$csv2post_options_array['csv2post_adminset']['datatype'] = 'array';// array,boolean,string etc
$csv2post_options_array['csv2post_adminset']['purpose'] = 'Settings for the administrator/backend only. These settings effect things that are to do with the backend only. They configure manual actions, tools and operations triggered by backend use.';
$csv2post_options_array['csv2post_adminset']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array['csv2post_adminset']['name'] = 'Administration Settings';
$csv2post_options_array['csv2post_adminset']['inputtype'] = 'hidden';
$csv2post_options_array['csv2post_adminset']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script
$csv2post_options_array['csv2post_adminset']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$csv2post_options_array['csv2post_adminset']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# last known installed version, used to track the gap between old and new versions ($csv2post_currentversion)
++$total_option_records;
$csv2post_options_array['csv2post_installedversion']['datatype'] = 'string';
$csv2post_options_array['csv2post_installedversion']['purpose'] = 'Used to determine gap between old and new version.';
$csv2post_options_array['csv2post_installedversion']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array['csv2post_installedversion']['name'] = 'Latest Version';
$csv2post_options_array['csv2post_installedversion']['inputtype'] = 'hidden';
$csv2post_options_array['csv2post_installedversion']['defaultvalue'] = '0.0.0';
$csv2post_options_array['csv2post_installedversion']['public'] = 'false';
$csv2post_options_array['csv2post_installedversion']['required'] = 'true';
# installation date (time()), currently has no use other than knowing the last time user done a new installation
++$total_option_records;
$csv2post_options_array['csv2post_installeddate']['datatype'] = 'integer';
$csv2post_options_array['csv2post_installeddate']['purpose'] = 'Date last full installation was run';
$csv2post_options_array['csv2post_installeddate']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array['csv2post_installeddate']['name'] = 'Install Date';
$csv2post_options_array['csv2post_installeddate']['inputtype'] = 'hidden';
$csv2post_options_array['csv2post_installeddate']['defaultvalue'] = time();
$csv2post_options_array['csv2post_installeddate']['public'] = 'false';
$csv2post_options_array['csv2post_installeddate']['required'] = 'true';
# wordpress activation date (time()), only use is to determine when user first added plugin to Wordpress
++$total_option_records;
$csv2post_options_array['csv2post_activationdate']['datatype'] = 'integer';
$csv2post_options_array['csv2post_activationdate']['purpose'] = 'Date last full installation was run';
$csv2post_options_array['csv2post_activationdate']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array['csv2post_activationdate']['name'] = 'Install Date';
$csv2post_options_array['csv2post_activationdate']['inputtype'] = 'hidden';
$csv2post_options_array['csv2post_activationdate']['defaultvalue'] = time();
$csv2post_options_array['csv2post_activationdate']['public'] = 'false';
$csv2post_options_array['csv2post_activationdate']['required'] = 'true';   
?>
