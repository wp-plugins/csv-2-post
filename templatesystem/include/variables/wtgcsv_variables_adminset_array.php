<?php
#################################################################
####                                                         ####
####            ADMIN ONLY SETTINGS ($wtgcsv_adm_set)         ####
####                                                         ####
################################################################# 
// install main admin settings option record
$wtgcsv_adm_set = array();
$wtgcsv_adm_set['chmod'] = '0750';
// admin user interface settings start
$wtgcsv_adm_set['ui_advancedinfo'] = false;// hide advanced user interface information by default
$wtgcsv_adm_set['ui_helpdialogue_width'] = 800;
$wtgcsv_adm_set['ui_helpdialogue_height'] = 500;

// logging settings start
$wtgcsv_adm_set['log_general_active'] = true;// boolean switch       
$wtgcsv_adm_set['log_sql_active'] = true;// boolean switch   
$wtgcsv_adm_set['log_admin_active'] = true;// boolean switch
$wtgcsv_adm_set['log_user_active'] = true;// boolean switch
$wtgcsv_adm_set['log_error_active'] = true;// boolean switch
$wtgcsv_adm_set['log_install_active'] = true;// boolean switch (connected to general log file)
// loggin settings end  
?>
