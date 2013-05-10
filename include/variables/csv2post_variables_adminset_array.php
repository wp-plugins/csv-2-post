<?php
#################################################################
####                                                         ####
####            ADMIN ONLY SETTINGS ($csv2post_adm_set)      ####
####                                                         ####
################################################################# 

// install main admin settings option record
$csv2post_adm_set = array();
// interface
$csv2post_adm_set['interface']['forms']['dialog']['status'] = 'hide';
// encoding
$csv2post_adm_set['encoding']['type'] = 'utf8';
// admin user interface settings start
$csv2post_adm_set['ui_advancedinfo'] = false;// hide advanced user interface information by default
$csv2post_adm_set['ui_helpdialog_width'] = 800;
$csv2post_adm_set['ui_helpdialog_height'] = 500;
// log
$csv2post_adm_set['reporting']['uselog'] = 1;
$csv2post_adm_set['reporting']['loglimit'] = 1000;
// other
$csv2post_adm_set['ecq'] = array();
$csv2post_adm_set['chmod'] = '0750';
?>