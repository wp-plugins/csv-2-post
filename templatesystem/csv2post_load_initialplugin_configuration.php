<?php
####################################################################################################
####                                                                                            ####
####        LOADING CONFIGURATION SHOULD ONLY REQUIRE WORDPRESS AND GLOBAL FUNCTIONS            ####
####                                                                                            ####
#################################################################################################### 

// early php version compatibility check
csv2post_php_version_check_wp_die();
  
// error display variables, variable that displays maximum errors is set in main file 
csv2post_debugmode();

###############################################################
####                                                       ####
####              LOAD STORED SETTINGS DATA                ####
####                                                       ####
###############################################################
$csv2post_pub_set_result = get_option('csv2post_publicset');
if($csv2post_pub_set_result){
    $csv2post_pub_set = unserialize(get_option('csv2post_publicset'));    
}

$csv2post_adm_set_result = get_option('csv2post_adminset');
if($csv2post_adm_set_result){
    $csv2post_adm_set = unserialize(get_option('csv2post_adminset'));    
}
?>