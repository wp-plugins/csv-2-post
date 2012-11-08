<?php
################################################################
#                TEMPLATE SYSTEM FILES ARRAY                   #
#                                                              #
#  Level                                                       #
#  0 = critical for free and full                              #
#  1 = critical for full only                                  #
#  2 = not critical                                            #
#                                                              #
################################################################
$csv2post_templatesystem_files = array();
// csv2post_load_initialplugin_configuration.php
$csv2post_templatesystem_files[23]['path'] = '/';
$csv2post_templatesystem_files[23]['name'] = WTG_C2P_ABB . 'load_initialplugin_configuration';
$csv2post_templatesystem_files[23]['extension'] = 'php';
$csv2post_templatesystem_files[23]['level'] = 0;
// css folder
$csv2post_templatesystem_files[0]['path'] = '/';// path within templatesystem folder, can be null
$csv2post_templatesystem_files[0]['name'] = 'css';// name of file with extension removed OR folder name
$csv2post_templatesystem_files[0]['extension'] = 'folder';// file extension (if a folder just put folder)
$csv2post_templatesystem_files[0]['level'] = 0;// importance of file, 0 being default for most critical 
// admin.css
$csv2post_templatesystem_files[1]['path'] = '/css/';
$csv2post_templatesystem_files[1]['name'] = 'admin';
$csv2post_templatesystem_files[1]['extension'] = 'css';
$csv2post_templatesystem_files[1]['level'] = 0; 
// global.css
$csv2post_templatesystem_files[2]['path'] = '/css/';
$csv2post_templatesystem_files[2]['name'] = 'global';
$csv2post_templatesystem_files[2]['extension'] = 'css';
$csv2post_templatesystem_files[2]['level'] = 0;
// jquery.multi-select.css
$csv2post_templatesystem_files[3]['path'] = '/css/';
$csv2post_templatesystem_files[3]['name'] = 'jquery.multi-select';
$csv2post_templatesystem_files[3]['extension'] = 'css';
$csv2post_templatesystem_files[3]['level'] = 0;
// notifications.css
$csv2post_templatesystem_files[4]['path'] = '/css/';
$csv2post_templatesystem_files[4]['name'] = 'notifications';
$csv2post_templatesystem_files[4]['extension'] = 'css';
$csv2post_templatesystem_files[4]['level'] = 0;
// public.css
$csv2post_templatesystem_files[5]['path'] = '/css/';
$csv2post_templatesystem_files[5]['name'] = 'public';
$csv2post_templatesystem_files[5]['extension'] = 'css';
$csv2post_templatesystem_files[5]['level'] = 0;
// wtg?_css_parent.php
$csv2post_templatesystem_files[6]['path'] = '/css/';
$csv2post_templatesystem_files[6]['name'] = WTG_C2P_ABB . 'css_parent';
$csv2post_templatesystem_files[6]['extension'] = 'php';
$csv2post_templatesystem_files[6]['level'] = 0; 
// images folder
$csv2post_templatesystem_files[7]['path'] = '/';
$csv2post_templatesystem_files[7]['name'] = 'images';
$csv2post_templatesystem_files[7]['extension'] = 'folder';
$csv2post_templatesystem_files[7]['level'] = 0;
// pear folder
$csv2post_templatesystem_files[8]['path'] = '/include/';
$csv2post_templatesystem_files[8]['name'] = 'pear';
$csv2post_templatesystem_files[8]['extension'] = 'folder';
$csv2post_templatesystem_files[8]['level'] = 0;
// pear/File folder
$csv2post_templatesystem_files[9]['path'] = '/include/pear/';
$csv2post_templatesystem_files[9]['name'] = 'File';
$csv2post_templatesystem_files[9]['extension'] = 'folder';
$csv2post_templatesystem_files[9]['level'] = 0;
// CSV.php
$csv2post_templatesystem_files[10]['path'] = '/include/pear/File/';
$csv2post_templatesystem_files[10]['name'] = 'CSV';
$csv2post_templatesystem_files[10]['extension'] = 'php';
$csv2post_templatesystem_files[10]['level'] = 0;
// Util.php
$csv2post_templatesystem_files[11]['path'] = '/include/pear/File/';
$csv2post_templatesystem_files[11]['name'] = 'Util';
$csv2post_templatesystem_files[11]['extension'] = 'php';
$csv2post_templatesystem_files[11]['level'] = 0;
// File.php
$csv2post_templatesystem_files[12]['path'] = '/include/pear/';
$csv2post_templatesystem_files[12]['name'] = 'File';
$csv2post_templatesystem_files[12]['extension'] = 'php';
$csv2post_templatesystem_files[12]['level'] = 0;
// PEAR.php
$csv2post_templatesystem_files[13]['path'] = '/include/pear/';
$csv2post_templatesystem_files[13]['name'] = 'PEAR';
$csv2post_templatesystem_files[13]['extension'] = 'php';
$csv2post_templatesystem_files[13]['level'] = 0;
// include
$csv2post_templatesystem_files[14]['path'] = '/';
$csv2post_templatesystem_files[14]['name'] = 'include';
$csv2post_templatesystem_files[14]['extension'] = 'folder';
$csv2post_templatesystem_files[14]['level'] = 0;
// webservices
$csv2post_templatesystem_files[14]['path'] = '/include/';
$csv2post_templatesystem_files[14]['name'] = 'webservices';
$csv2post_templatesystem_files[14]['extension'] = 'folder';
$csv2post_templatesystem_files[14]['level'] = 0;
// wtg?_api_parent.php
$csv2post_templatesystem_files[15]['path'] = '/include/webservices/';
$csv2post_templatesystem_files[15]['name'] = WTG_C2P_ABB . 'api_parent';
$csv2post_templatesystem_files[15]['extension'] = 'php';
$csv2post_templatesystem_files[15]['level'] = 0;
// wtg?_api_tickets.php
$csv2post_templatesystem_files[16]['path'] = '/include/webservices/';
$csv2post_templatesystem_files[16]['name'] = WTG_C2P_ABB . 'api_tickets';
$csv2post_templatesystem_files[16]['extension'] = 'php';
$csv2post_templatesystem_files[16]['level'] = 0;
// wtg?_admin_functions.php
$csv2post_templatesystem_files[17]['path'] = '/include/';
$csv2post_templatesystem_files[17]['name'] = WTG_C2P_ABB . 'admin_functions';
$csv2post_templatesystem_files[17]['extension'] = 'php';
$csv2post_templatesystem_files[17]['level'] = 0;
// wtg?_admininterface_functions.php
$csv2post_templatesystem_files[18]['path'] = '/include/';
$csv2post_templatesystem_files[18]['name'] = WTG_C2P_ABB . 'admininterface_functions';
$csv2post_templatesystem_files[18]['extension'] = 'php';
$csv2post_templatesystem_files[18]['level'] = 0;
// wtg?_install_functions.php
$csv2post_templatesystem_files[21]['path'] = '/include/';
$csv2post_templatesystem_files[21]['name'] = WTG_C2P_ABB . 'install_functions';
$csv2post_templatesystem_files[21]['extension'] = 'php';
$csv2post_templatesystem_files[21]['level'] = 0;
// wtg?_post_processing.php
$csv2post_templatesystem_files[24]['path'] = '/include/';
$csv2post_templatesystem_files[24]['name'] = WTG_C2P_ABB . 'form_processing';
$csv2post_templatesystem_files[24]['extension'] = 'php';
$csv2post_templatesystem_files[24]['level'] = 0;
// wtg?_sql_functions.php
$csv2post_templatesystem_files[25]['path'] = '/include/';
$csv2post_templatesystem_files[25]['name'] = WTG_C2P_ABB . 'sql_functions';
$csv2post_templatesystem_files[25]['extension'] = 'php';
$csv2post_templatesystem_files[25]['level'] = 0;
// wtg?_variables_adminconfig.php
$csv2post_templatesystem_files[26]['path'] = '/include/variables/';
$csv2post_templatesystem_files[26]['name'] = WTG_C2P_ABB . 'variables_adminconfig';
$csv2post_templatesystem_files[26]['extension'] = 'php';
$csv2post_templatesystem_files[26]['level'] = 0;
// wtg?_variables_adminset_array.php
$csv2post_templatesystem_files[27]['path'] = '/include/variables/';
$csv2post_templatesystem_files[27]['name'] = WTG_C2P_ABB . 'variables_adminset_array';
$csv2post_templatesystem_files[27]['extension'] = 'php';
$csv2post_templatesystem_files[27]['level'] = 0;
// wtg?_variables_publicconfig.php
$csv2post_templatesystem_files[29]['path'] = '/include/variables/';
$csv2post_templatesystem_files[29]['name'] = WTG_C2P_ABB . 'variables_publicconfig';
$csv2post_templatesystem_files[29]['extension'] = 'php';
$csv2post_templatesystem_files[29]['level'] = 0;
// wtg?_variables_templatesystemfiles_array.php
$csv2post_templatesystem_files[32]['path'] = '/include/variables/';
$csv2post_templatesystem_files[32]['name'] = WTG_C2P_ABB . 'variables_templatesystemfiles_array';
$csv2post_templatesystem_files[32]['extension'] = 'php';
$csv2post_templatesystem_files[32]['level'] = 0;
// script
$csv2post_templatesystem_files[33]['path'] = '/';
$csv2post_templatesystem_files[33]['name'] = 'script';
$csv2post_templatesystem_files[33]['extension'] = 'folder';
$csv2post_templatesystem_files[33]['level'] = 0;
// script/multiselect
$csv2post_templatesystem_files[34]['path'] = '/script/';
$csv2post_templatesystem_files[34]['name'] = 'multiselect';
$csv2post_templatesystem_files[34]['extension'] = 'folder';
$csv2post_templatesystem_files[34]['level'] = 0;
// multi-select-basic
$csv2post_templatesystem_files[35]['path'] = '/script/';
$csv2post_templatesystem_files[35]['name'] = 'multi-select-basic';
$csv2post_templatesystem_files[35]['extension'] = 'folder';
$csv2post_templatesystem_files[35]['level'] = 0;
// jquery.multi-select.js
$csv2post_templatesystem_files[36]['path'] = '/script/multi-select-basic/';
$csv2post_templatesystem_files[36]['name'] = 'jquery.multi-select';
$csv2post_templatesystem_files[36]['extension'] = 'js';
$csv2post_templatesystem_files[36]['level'] = 0;
// jquery-1.7.1.js
$csv2post_templatesystem_files[40]['path'] = '/script/';
$csv2post_templatesystem_files[40]['name'] = 'jquery-1.7.1';
$csv2post_templatesystem_files[40]['extension'] = 'js';
$csv2post_templatesystem_files[40]['level'] = 0;
// jquery-ui.js
$csv2post_templatesystem_files[41]['path'] = '/script/';
$csv2post_templatesystem_files[41]['name'] = 'jquery-ui';
$csv2post_templatesystem_files[41]['extension'] = 'js';
$csv2post_templatesystem_files[41]['level'] = 0;
// uploader.js
$csv2post_templatesystem_files[42]['path'] = '/script/';
$csv2post_templatesystem_files[42]['name'] = 'uploader';
$csv2post_templatesystem_files[42]['extension'] = 'js';
$csv2post_templatesystem_files[42]['level'] = 0;
// csv2post_script_admin_jqueryui.php
$csv2post_templatesystem_files[43]['path'] = '/script/';
$csv2post_templatesystem_files[43]['name'] = WTG_C2P_ABB . 'script_admin_jqueryui';
$csv2post_templatesystem_files[43]['extension'] = 'php';
$csv2post_templatesystem_files[43]['level'] = 0;
// csv2post_script_parent.php
$csv2post_templatesystem_files[44]['path'] = '/script/';
$csv2post_templatesystem_files[44]['name'] = WTG_C2P_ABB . 'script_parent';
$csv2post_templatesystem_files[44]['extension'] = 'php';
$csv2post_templatesystem_files[44]['level'] = 0;
?>
