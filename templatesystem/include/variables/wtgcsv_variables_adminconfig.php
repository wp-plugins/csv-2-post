<?php
#################################################################
####                                                         ####
####          WP OPTIONS - Updated 22/11/2011 By RB1         ####
####                                                         ####
################################################################# 
$wtgcsv_apisession_array = get_option('wtgcsv_apisession');// array, indicates if api web services are authorised or not                                   

###########################################################################
####                                                                   ####
####        SET ADMIN THEME NAME   - Updated 27/01/2012 By RB1         ####
####                                                                   ####
########################################################################### 
// set theme variable from users own setting, set default if it has not been saved.
$wtgcsv_jqueryuitheme = get_option('wtgcsv_theme');
if(!is_string($wtgcsv_jqueryuitheme) || $wtgcsv_jqueryuitheme == null || $wtgcsv_jqueryuitheme == false){
    $wtgcsv_jqueryuitheme = 'start';
    update_option('wtgcsv_theme',$wtgcsv_jqueryuitheme);
}       

###########################################################################
####                                                                   ####
####                         THEME ARRAY                               ####
####                                                                   ####
########################################################################### 
$wtgcsv_theme_array = array();
// 1: overcast
$wtgcsv_theme_array[0]['name'] = 'overcast';
$wtgcsv_theme_array[0]['source'] = 'default';// hardcoded path to default css source
$wtgcsv_theme_array[0]['thumb'] = 'default';// hardcoded path too themethumb folder
$wtgcsv_theme_array[0]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 3: cupertino
$wtgcsv_theme_array[2]['name'] = 'cupertino';
$wtgcsv_theme_array[2]['source'] = 'default';// hardcoded path to default css source
$wtgcsv_theme_array[2]['thumb'] = 'default';// hardcoded path too themethumb folder
$wtgcsv_theme_array[2]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 4: dark-hive
$wtgcsv_theme_array[3]['name'] = 'dark-hive';
$wtgcsv_theme_array[3]['source'] = 'default';// hardcoded path to default css source
$wtgcsv_theme_array[3]['thumb'] = 'default';// hardcoded path too themethumb folder
$wtgcsv_theme_array[3]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 5: flick
$wtgcsv_theme_array[4]['name'] = 'flick';
$wtgcsv_theme_array[4]['source'] = 'default';// hardcoded path to default css source
$wtgcsv_theme_array[4]['thumb'] = 'default';// hardcoded path too themethumb folder
$wtgcsv_theme_array[4]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 6: overcast
$wtgcsv_theme_array[5]['name'] = 'redmond';
$wtgcsv_theme_array[5]['source'] = 'default';// hardcoded path to default css source
$wtgcsv_theme_array[5]['thumb'] = 'default';// hardcoded path too themethumb folder
$wtgcsv_theme_array[5]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 7: smoothness
$wtgcsv_theme_array[6]['name'] = 'smoothness';
$wtgcsv_theme_array[6]['source'] = 'default';// hardcoded path to default css source
$wtgcsv_theme_array[6]['thumb'] = 'default';// hardcoded path too themethumb folder
$wtgcsv_theme_array[6]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed
// 9: start
$wtgcsv_theme_array[8]['name'] = 'start';
$wtgcsv_theme_array[8]['source'] = 'default';// hardcoded path to default css source
$wtgcsv_theme_array[8]['thumb'] = 'default';// hardcoded path too themethumb folder
$wtgcsv_theme_array[8]['author'] = 'jquery.com';// mainly for custom themes where whole icon set etc is changed

####################################################################################################
####                                                                                            ####
####         VARIABLES LOADED ON PUBLIC SIDE, USUALLY LOADED WHILE ADMIN LOGGED IN ALSO         ####
####                                                                                            ####
####################################################################################################

$wtgcsv_webtechglobalhostingurl = 'http://www.webtechglobal.co.uk/hosting';
$wtgcsv_logfile_header = array( 'PROJECTNAME','DATE','LINE','FILE','FUNCTION','DUMP','COMMENT','SQLRESULT','SQLQUERY','STYLE','CATEGORY' );      

###############################################################
####                                                       ####
####             LOAD STORED PUBLIC SETTINGS               ####
####                                                       ####
###############################################################
$wtgcsv_pub_set = array();
$wtgcsv_pub_set['automation'] = 0;// 0 = off, 1 = on (controls automated background scripts, not CRON just page load triggered) 
?>