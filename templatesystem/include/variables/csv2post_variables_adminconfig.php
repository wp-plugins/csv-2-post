<?php
#################################################################
####                                                         ####
####          WP OPTIONS - Updated 22/11/2011 By RB1         ####
####                                                         ####
################################################################# 
$csv2post_apisession_array = get_option('csv2post_apisession');// array, indicates if api web services are authorised or not                                   

###########################################################################
####                                                                   ####
####        SET ADMIN THEME NAME   - Updated 27/01/2012 By RB1         ####
####                                                                   ####
########################################################################### 
// set theme variable from users own setting, set default if it has not been saved.
$csv2post_jqueryuitheme = get_option('csv2post_theme');
if(!is_string($csv2post_jqueryuitheme) || $csv2post_jqueryuitheme == null || $csv2post_jqueryuitheme == false){
    $csv2post_jqueryuitheme = 'start';
    update_option('csv2post_theme',$csv2post_jqueryuitheme);
}       

###########################################################################
####                                                                   ####
####                         THEME ARRAY                               ####
####                                                                   ####
########################################################################### 
$csv2post_theme_array = array();
// 1: overcast
$csv2post_theme_array[0]['name'] = 'overcast';
$csv2post_theme_array[0]['source'] = 'default';// hardcoded path to default css source
$csv2post_theme_array[0]['thumb'] = 'default';// hardcoded path too themethumb folder
$csv2post_theme_array[0]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 3: cupertino
$csv2post_theme_array[2]['name'] = 'cupertino';
$csv2post_theme_array[2]['source'] = 'default';// hardcoded path to default css source
$csv2post_theme_array[2]['thumb'] = 'default';// hardcoded path too themethumb folder
$csv2post_theme_array[2]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 4: dark-hive
$csv2post_theme_array[3]['name'] = 'dark-hive';
$csv2post_theme_array[3]['source'] = 'default';// hardcoded path to default css source
$csv2post_theme_array[3]['thumb'] = 'default';// hardcoded path too themethumb folder
$csv2post_theme_array[3]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 5: flick
$csv2post_theme_array[4]['name'] = 'flick';
$csv2post_theme_array[4]['source'] = 'default';// hardcoded path to default css source
$csv2post_theme_array[4]['thumb'] = 'default';// hardcoded path too themethumb folder
$csv2post_theme_array[4]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 6: overcast
$csv2post_theme_array[5]['name'] = 'redmond';
$csv2post_theme_array[5]['source'] = 'default';// hardcoded path to default css source
$csv2post_theme_array[5]['thumb'] = 'default';// hardcoded path too themethumb folder
$csv2post_theme_array[5]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 7: smoothness
$csv2post_theme_array[6]['name'] = 'smoothness';
$csv2post_theme_array[6]['source'] = 'default';// hardcoded path to default css source
$csv2post_theme_array[6]['thumb'] = 'default';// hardcoded path too themethumb folder
$csv2post_theme_array[6]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 9: start
$csv2post_theme_array[8]['name'] = 'start';
$csv2post_theme_array[8]['source'] = 'default';// hardcoded path to default css source
$csv2post_theme_array[8]['thumb'] = 'default';// hardcoded path too themethumb folder
$csv2post_theme_array[8]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed

####################################################################################################
####                                                                                            ####
####         VARIABLES LOADED ON PUBLIC SIDE, USUALLY LOADED WHILE ADMIN LOGGED IN ALSO         ####
####                                                                                            ####
####################################################################################################

$csv2post_webtechglobalhostingurl = 'http://www.webtechglobal.co.uk/hosting';
$csv2post_logfile_header = array( 'PROJECTNAME','DATE','LINE','FILE','FUNCTION','DUMP','COMMENT','SQLRESULT','SQLQUERY','STYLE','CATEGORY' );      

###############################################################
####                                                       ####
####             LOAD STORED PUBLIC SETTINGS               ####
####                                                       ####
###############################################################
$csv2post_pub_set = array();
$csv2post_pub_set['automation'] = 0;// 0 = off, 1 = on (controls automated background scripts, not CRON just page load triggered) 
?>