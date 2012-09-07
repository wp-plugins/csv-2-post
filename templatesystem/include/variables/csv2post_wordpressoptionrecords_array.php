<?php 
##############################################################################################
####                                                                                      ####
####                          WORDPRESS OPTIONS RECORD ARRAY                              ####
####                                                                                      ####
##############################################################################################
$total_option_records = 0;// used to count total options and assign count to label
$csv2post_options_array = array();
++$total_option_records;
# is_installed, result of last installation status check
$csv2post_options_array[WTG_C2P_ABB.'is_installed']['datatype'] = 'boolean';// array,boolean,string etc
$csv2post_options_array[WTG_C2P_ABB.'is_installed']['purpose'] = 'Indicates result of last installation status check, should hold value true for normal operation else an element of installation is missing.';
$csv2post_options_array[WTG_C2P_ABB.'is_installed']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'is_installed']['name'] = 'Installation Switch';
$csv2post_options_array[WTG_C2P_ABB.'is_installed']['inputtype'] = 'hidden';
$csv2post_options_array[WTG_C2P_ABB.'is_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$csv2post_options_array[WTG_C2P_ABB.'is_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$csv2post_options_array[WTG_C2P_ABB.'is_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# is_installed, result of last installation status check
$csv2post_options_array[WTG_C2P_ABB.'was_installed']['datatype'] = 'boolean';// array,boolean,string etc
$csv2post_options_array[WTG_C2P_ABB.'was_installed']['purpose'] = 'Ins but not all.';
$csv2post_options_array[WTG_C2P_ABB.'was_installed']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'was_installed']['name'] = 'Installation Switch';
$csv2post_options_array[WTG_C2P_ABB.'was_installed']['inputtype'] = 'hidden';
$csv2post_options_array[WTG_C2P_ABB.'was_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$csv2post_options_array[WTG_C2P_ABB.'was_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$csv2post_options_array[WTG_C2P_ABB.'was_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# admin settings
++$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'adminset']['datatype'] = 'array';// array,boolean,string etc
$csv2post_options_array[WTG_C2P_ABB.'adminset']['purpose'] = 'Settings for the administrator/backend only. These settings effect things that are to do with the backend only. They configure manual actions, tools and operations triggered by backend use.';
$csv2post_options_array[WTG_C2P_ABB.'adminset']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'adminset']['name'] = 'Administration Settings';
$csv2post_options_array[WTG_C2P_ABB.'adminset']['inputtype'] = 'hidden';
$csv2post_options_array[WTG_C2P_ABB.'adminset']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script
$csv2post_options_array[WTG_C2P_ABB.'adminset']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$csv2post_options_array[WTG_C2P_ABB.'adminset']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# public settings
++$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'publicset']['datatype'] = 'array';// array,boolean,string etc
$csv2post_options_array[WTG_C2P_ABB.'publicset']['purpose'] = 'Settings that effect the public side such as widgets or even automated processing when any visitor opens a page.';
$csv2post_options_array[WTG_C2P_ABB.'publicset']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'publicset']['name'] = 'Public Settings';
$csv2post_options_array[WTG_C2P_ABB.'publicset']['inputtype'] = 'hidden';
$csv2post_options_array[WTG_C2P_ABB.'publicset']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script   
$csv2post_options_array[WTG_C2P_ABB.'publicset']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$csv2post_options_array[WTG_C2P_ABB.'publicset']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# tab menu array (the stored array controlling plugins tab menu, originally in file until installation)
++$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'tabmenu']['datatype'] = 'array';// array,boolean,string etc
$csv2post_options_array[WTG_C2P_ABB.'tabmenu']['purpose'] = 'This array is used to build the plugins tab navigation and stores settings per tab screen offering a unique control over the plugins interface.';
$csv2post_options_array[WTG_C2P_ABB.'tabmenu']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'tabmenu']['name'] = 'Tab Menu Settings';
$csv2post_options_array[WTG_C2P_ABB.'tabmenu']['inputtype'] = 'hidden';
$csv2post_options_array[WTG_C2P_ABB.'tabmenu']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script 
$csv2post_options_array[WTG_C2P_ABB.'tabmenu']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$csv2post_options_array[WTG_C2P_ABB.'tabmenu']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# last known installed version, used to track the gap between old and new versions ($csv2post_currentversion)
++$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'installedversion']['datatype'] = 'string';
$csv2post_options_array[WTG_C2P_ABB.'installedversion']['purpose'] = 'Used to determine gap between old and new version.';
$csv2post_options_array[WTG_C2P_ABB.'installedversion']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'installedversion']['name'] = 'Latest Version';
$csv2post_options_array[WTG_C2P_ABB.'installedversion']['inputtype'] = 'hidden';
$csv2post_options_array[WTG_C2P_ABB.'installedversion']['defaultvalue'] = '0.0.0';
$csv2post_options_array[WTG_C2P_ABB.'installedversion']['public'] = 'false';
$csv2post_options_array[WTG_C2P_ABB.'installedversion']['required'] = 'true';
# installation date (time()), currently has no use other than knowing the last time user done a new installation
++$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'installeddate']['datatype'] = 'integer';
$csv2post_options_array[WTG_C2P_ABB.'installeddate']['purpose'] = 'Date last full installation was run';
$csv2post_options_array[WTG_C2P_ABB.'installeddate']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'installeddate']['name'] = 'Install Date';
$csv2post_options_array[WTG_C2P_ABB.'installeddate']['inputtype'] = 'hidden';
$csv2post_options_array[WTG_C2P_ABB.'installeddate']['defaultvalue'] = time();
$csv2post_options_array[WTG_C2P_ABB.'installeddate']['public'] = 'false';
$csv2post_options_array[WTG_C2P_ABB.'installeddate']['required'] = 'true';
# wordpress activation date (time()), only use is to determine when user first added plugin too Wordpress
++$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'activationdate']['datatype'] = 'integer';
$csv2post_options_array[WTG_C2P_ABB.'activationdate']['purpose'] = 'Date last full installation was run';
$csv2post_options_array[WTG_C2P_ABB.'activationdate']['label'] = 'Option Record '.$total_option_records;
$csv2post_options_array[WTG_C2P_ABB.'activationdate']['name'] = 'Install Date';
$csv2post_options_array[WTG_C2P_ABB.'activationdate']['inputtype'] = 'hidden';
$csv2post_options_array[WTG_C2P_ABB.'activationdate']['defaultvalue'] = time();
$csv2post_options_array[WTG_C2P_ABB.'activationdate']['public'] = 'false';
$csv2post_options_array[WTG_C2P_ABB.'activationdate']['required'] = 'true';   
?>
