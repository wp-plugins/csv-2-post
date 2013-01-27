<?php
##############################################################################################
####                                                                                      ####
####                    EASY QUESTIONS ANSWER ARRAY ($csv2post_easyset)                   ####
####                                                                                      ####
##############################################################################################
/*
* This array is installed in wp_option table. It exists in this file so that a default exists
* on all settings.
* 
* Each easy configuration questions answer is stored
* in this array. This allows the easy configuration question system to check the saved answer, 
* simply by using the array key. The order of the questions is the order of the answers. So we
* must always add new questions to the end of the $csv2post_easyquestions_array
*/
$csv2post_eas_set = array();
$csv2post_eas_set[0] = 'answer1';
$csv2post_eas_set[1] = 'answer2';
$csv2post_eas_set[3] = 'answer3';
$csv2post_eas_set[4] = 'answer4';

#################################################################
####                                                         ####
####            ADMIN ONLY SETTINGS ($csv2post_adm_set)      ####
####                                                         ####
################################################################# 

// install main admin settings option record
$csv2post_adm_set = array();
$csv2post_adm_set['easyconfigurationquestions'] = $csv2post_eas_set;
$csv2post_adm_set['chmod'] = '0750';
// admin user interface settings start
$csv2post_adm_set['ui_advancedinfo'] = false;// hide advanced user interface information by default
$csv2post_adm_set['ui_helpdialog_width'] = 800;
$csv2post_adm_set['ui_helpdialog_height'] = 500;

// logging settings start
$csv2post_adm_set['log_general_active'] = true;// boolean switch       
$csv2post_adm_set['log_sql_active'] = true;// boolean switch   
$csv2post_adm_set['log_admin_active'] = true;// boolean switch
$csv2post_adm_set['log_user_active'] = true;// boolean switch
$csv2post_adm_set['log_error_active'] = true;// boolean switch
$csv2post_adm_set['log_install_active'] = true;// boolean switch (connected to general log file)  
?>