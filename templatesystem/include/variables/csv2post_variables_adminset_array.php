<?php
#################################################################
####                                                         ####
####            ADMIN ONLY SETTINGS ($csv2post_adm_set)         ####
####                                                         ####
################################################################# 
// install main admin settings option record
$csv2post_adm_set = array();
$csv2post_adm_set['chmod'] = '0750';
// admin user interface settings start
$csv2post_adm_set['ui_advancedinfo'] = false;// hide advanced user interface information by default
$csv2post_adm_set['ui_helpdialogue_width'] = 800;
$csv2post_adm_set['ui_helpdialogue_height'] = 500;

// logging settings start
$csv2post_adm_set['log_general_active'] = true;// boolean switch       
$csv2post_adm_set['log_sql_active'] = true;// boolean switch   
$csv2post_adm_set['log_admin_active'] = true;// boolean switch
$csv2post_adm_set['log_user_active'] = true;// boolean switch
$csv2post_adm_set['log_error_active'] = true;// boolean switch
$csv2post_adm_set['log_install_active'] = true;// boolean switch (connected to general log file)
// loggin settings end  
?>
