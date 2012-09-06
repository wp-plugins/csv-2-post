<?php 
##############################################################################################
####                                                                                      ####
####                          WORDPRESS OPTIONS RECORD ARRAY                              ####
####                                                                                      ####
##############################################################################################
$total_option_records = 0;// used to count total options and assign count to label
$wtgcsv_options_array = array();
++$total_option_records;
# is_installed, result of last installation status check
$wtgcsv_options_array[WTG_CSV_ABB.'is_installed']['datatype'] = 'boolean';// array,boolean,string etc
$wtgcsv_options_array[WTG_CSV_ABB.'is_installed']['purpose'] = 'Indicates result of last installation status check, should hold value true for normal operation else an element of installation is missing.';
$wtgcsv_options_array[WTG_CSV_ABB.'is_installed']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'is_installed']['name'] = 'Installation Switch';
$wtgcsv_options_array[WTG_CSV_ABB.'is_installed']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'is_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$wtgcsv_options_array[WTG_CSV_ABB.'is_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$wtgcsv_options_array[WTG_CSV_ABB.'is_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# is_installed, result of last installation status check
$wtgcsv_options_array[WTG_CSV_ABB.'was_installed']['datatype'] = 'boolean';// array,boolean,string etc
$wtgcsv_options_array[WTG_CSV_ABB.'was_installed']['purpose'] = 'Ins but not all.';
$wtgcsv_options_array[WTG_CSV_ABB.'was_installed']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'was_installed']['name'] = 'Installation Switch';
$wtgcsv_options_array[WTG_CSV_ABB.'was_installed']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'was_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$wtgcsv_options_array[WTG_CSV_ABB.'was_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$wtgcsv_options_array[WTG_CSV_ABB.'was_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# admin settings
++$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'adminset']['datatype'] = 'array';// array,boolean,string etc
$wtgcsv_options_array[WTG_CSV_ABB.'adminset']['purpose'] = 'Settings for the administrator/backend only. These settings effect things that are to do with the backend only. They configure manual actions, tools and operations triggered by backend use.';
$wtgcsv_options_array[WTG_CSV_ABB.'adminset']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'adminset']['name'] = 'Administration Settings';
$wtgcsv_options_array[WTG_CSV_ABB.'adminset']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'adminset']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script
$wtgcsv_options_array[WTG_CSV_ABB.'adminset']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$wtgcsv_options_array[WTG_CSV_ABB.'adminset']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# public settings
++$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'publicset']['datatype'] = 'array';// array,boolean,string etc
$wtgcsv_options_array[WTG_CSV_ABB.'publicset']['purpose'] = 'Settings that effect the public side such as widgets or even automated processing when any visitor opens a page.';
$wtgcsv_options_array[WTG_CSV_ABB.'publicset']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'publicset']['name'] = 'Public Settings';
$wtgcsv_options_array[WTG_CSV_ABB.'publicset']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'publicset']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script   
$wtgcsv_options_array[WTG_CSV_ABB.'publicset']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$wtgcsv_options_array[WTG_CSV_ABB.'publicset']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# tab menu array (the stored array controlling plugins tab menu, originally in file until installation)
++$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'tabmenu']['datatype'] = 'array';// array,boolean,string etc
$wtgcsv_options_array[WTG_CSV_ABB.'tabmenu']['purpose'] = 'This array is used to build the plugins tab navigation and stores settings per tab screen offering a unique control over the plugins interface.';
$wtgcsv_options_array[WTG_CSV_ABB.'tabmenu']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'tabmenu']['name'] = 'Tab Menu Settings';
$wtgcsv_options_array[WTG_CSV_ABB.'tabmenu']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'tabmenu']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script 
$wtgcsv_options_array[WTG_CSV_ABB.'tabmenu']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$wtgcsv_options_array[WTG_CSV_ABB.'tabmenu']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# easy question answers arrays
++$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'easyset']['datatype'] = 'array';// array,boolean,string etc
$wtgcsv_options_array[WTG_CSV_ABB.'easyset']['purpose'] = 'This array holds the answers for the Easy Questions.';
$wtgcsv_options_array[WTG_CSV_ABB.'easyset']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'easyset']['name'] = 'Easy Answers';
$wtgcsv_options_array[WTG_CSV_ABB.'easyset']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'easyset']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script 
$wtgcsv_options_array[WTG_CSV_ABB.'easyset']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$wtgcsv_options_array[WTG_CSV_ABB.'easyset']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# last known installed version, used to track the gap between old and new versions ($wtgcsv_currentversion)
++$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'installedversion']['datatype'] = 'string';
$wtgcsv_options_array[WTG_CSV_ABB.'installedversion']['purpose'] = 'Used to determine gap between old and new version.';
$wtgcsv_options_array[WTG_CSV_ABB.'installedversion']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'installedversion']['name'] = 'Latest Version';
$wtgcsv_options_array[WTG_CSV_ABB.'installedversion']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'installedversion']['defaultvalue'] = '0.0.0';
$wtgcsv_options_array[WTG_CSV_ABB.'installedversion']['public'] = 'false';
$wtgcsv_options_array[WTG_CSV_ABB.'installedversion']['required'] = 'true';
# installation date (time()), currently has no use other than knowing the last time user done a new installation
++$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'installeddate']['datatype'] = 'integer';
$wtgcsv_options_array[WTG_CSV_ABB.'installeddate']['purpose'] = 'Date last full installation was run';
$wtgcsv_options_array[WTG_CSV_ABB.'installeddate']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'installeddate']['name'] = 'Install Date';
$wtgcsv_options_array[WTG_CSV_ABB.'installeddate']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'installeddate']['defaultvalue'] = time();
$wtgcsv_options_array[WTG_CSV_ABB.'installeddate']['public'] = 'false';
$wtgcsv_options_array[WTG_CSV_ABB.'installeddate']['required'] = 'true';
# wordpress activation date (time()), only use is to determine when user first added plugin too Wordpress
++$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'activationdate']['datatype'] = 'integer';
$wtgcsv_options_array[WTG_CSV_ABB.'activationdate']['purpose'] = 'Date last full installation was run';
$wtgcsv_options_array[WTG_CSV_ABB.'activationdate']['label'] = 'Option Record '.$total_option_records;
$wtgcsv_options_array[WTG_CSV_ABB.'activationdate']['name'] = 'Install Date';
$wtgcsv_options_array[WTG_CSV_ABB.'activationdate']['inputtype'] = 'hidden';
$wtgcsv_options_array[WTG_CSV_ABB.'activationdate']['defaultvalue'] = time();
$wtgcsv_options_array[WTG_CSV_ABB.'activationdate']['public'] = 'false';
$wtgcsv_options_array[WTG_CSV_ABB.'activationdate']['required'] = 'true';   
?>