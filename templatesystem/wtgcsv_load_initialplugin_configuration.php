<?php
####################################################################################################
####                                                                                            ####
####        LOADING CONFIGURATION SHOULD ONLY REQUIRE WORDPRESS AND GLOBAL FUNCTIONS            ####
####                                                                                            ####
#################################################################################################### 

// early php version compatibility check
wtgcsv_php_version_check_wp_die();
  
// error display variables, variable that displays maximum errors is set in main file 
wtgcsv_debugmode();

###############################################################
####                                                       ####
####              LOAD STORED SETTINGS DATA                ####
####                                                       ####
###############################################################
$wtgcsv_pub_set_result = get_option('wtgcsv_publicset');
if($wtgcsv_pub_set_result){
    $wtgcsv_pub_set = unserialize(get_option('wtgcsv_publicset'));    
}

$wtgcsv_adm_set_result = get_option('wtgcsv_adminset');
if($wtgcsv_adm_set_result){
    $wtgcsv_adm_set = unserialize(get_option('wtgcsv_adminset'));    
}

$wtgcsv_eas_set_result = get_option('wtgcsv_easyset');
if($wtgcsv_eas_set_result){
    $wtgcsv_eas_set = unserialize(get_option('wtgcsv_easyset'));    
}?>