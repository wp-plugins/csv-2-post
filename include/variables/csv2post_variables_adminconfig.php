<?php
# TODO:LOWPRIORITY, Move everything from this file and remove use of it then delete file
#################################################################
####                                                         ####
####          WP OPTIONS - Updated 22/11/2011 By RB1         ####
####                                                         ####
################################################################# 
$csv2post_apisession_array = false;
           
#############################################
####                                     ####
####          SET ADMIN THEME            ####
####                                     ####
############################################# 
// set theme variable from users own setting, set default if it has not been saved.
$csv2post_guitheme = csv2post_option('csv2post_theme','get');
if(!is_string($csv2post_guitheme) || $csv2post_guitheme == null || $csv2post_guitheme == false){
    $csv2post_guitheme = 'wordpresscss';// jquery|wordpresscss
}       

###############################################################
####                                                       ####
####             LOAD STORED PUBLIC SETTINGS               ####
####                                                       ####
###############################################################
# NOT YET IN USE
$csv2post_pub_set = array();
$csv2post_pub_set['automation'] = 0;// 0 = off, 1 = on (controls automated background scripts, not CRON just page load triggered) 
?>
