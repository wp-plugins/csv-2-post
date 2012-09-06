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
$wtgcsv_templatesystem_files = array();
// wtgcsv_load_initialplugin_configuration.php
$wtgcsv_templatesystem_files[23]['path'] = '/';
$wtgcsv_templatesystem_files[23]['name'] = WTG_CSV_ABB . 'load_initialplugin_configuration';
$wtgcsv_templatesystem_files[23]['extension'] = 'php';
$wtgcsv_templatesystem_files[23]['level'] = 0;
// css folder
$wtgcsv_templatesystem_files[0]['path'] = '/';// path within templatesystem folder, can be null
$wtgcsv_templatesystem_files[0]['name'] = 'css';// name of file with extension removed OR folder name
$wtgcsv_templatesystem_files[0]['extension'] = 'folder';// file extension (if a folder just put folder)
$wtgcsv_templatesystem_files[0]['level'] = 0;// importance of file, 0 being default for most critical 
// admin.css
$wtgcsv_templatesystem_files[1]['path'] = '/css/';
$wtgcsv_templatesystem_files[1]['name'] = 'admin';
$wtgcsv_templatesystem_files[1]['extension'] = 'css';
$wtgcsv_templatesystem_files[1]['level'] = 0; 
// global.css
$wtgcsv_templatesystem_files[2]['path'] = '/css/';
$wtgcsv_templatesystem_files[2]['name'] = 'global';
$wtgcsv_templatesystem_files[2]['extension'] = 'css';
$wtgcsv_templatesystem_files[2]['level'] = 0;
// jquery.multi-select.css
$wtgcsv_templatesystem_files[3]['path'] = '/css/';
$wtgcsv_templatesystem_files[3]['name'] = 'jquery.multi-select';
$wtgcsv_templatesystem_files[3]['extension'] = 'css';
$wtgcsv_templatesystem_files[3]['level'] = 0;
// notifications.css
$wtgcsv_templatesystem_files[4]['path'] = '/css/';
$wtgcsv_templatesystem_files[4]['name'] = 'notifications';
$wtgcsv_templatesystem_files[4]['extension'] = 'css';
$wtgcsv_templatesystem_files[4]['level'] = 0;
// public.css
$wtgcsv_templatesystem_files[5]['path'] = '/css/';
$wtgcsv_templatesystem_files[5]['name'] = 'public';
$wtgcsv_templatesystem_files[5]['extension'] = 'css';
$wtgcsv_templatesystem_files[5]['level'] = 0;
// wtg?_css_parent.php
$wtgcsv_templatesystem_files[6]['path'] = '/css/';
$wtgcsv_templatesystem_files[6]['name'] = WTG_CSV_ABB . 'css_parent';
$wtgcsv_templatesystem_files[6]['extension'] = 'php';
$wtgcsv_templatesystem_files[6]['level'] = 0; 
// images folder
$wtgcsv_templatesystem_files[7]['path'] = '/';
$wtgcsv_templatesystem_files[7]['name'] = 'images';
$wtgcsv_templatesystem_files[7]['extension'] = 'folder';
$wtgcsv_templatesystem_files[7]['level'] = 0;
// pear folder
$wtgcsv_templatesystem_files[8]['path'] = '/include/';
$wtgcsv_templatesystem_files[8]['name'] = 'pear';
$wtgcsv_templatesystem_files[8]['extension'] = 'folder';
$wtgcsv_templatesystem_files[8]['level'] = 0;
// pear/File folder
$wtgcsv_templatesystem_files[9]['path'] = '/include/pear/';
$wtgcsv_templatesystem_files[9]['name'] = 'File';
$wtgcsv_templatesystem_files[9]['extension'] = 'folder';
$wtgcsv_templatesystem_files[9]['level'] = 0;
// CSV.php
$wtgcsv_templatesystem_files[10]['path'] = '/include/pear/File/';
$wtgcsv_templatesystem_files[10]['name'] = 'CSV';
$wtgcsv_templatesystem_files[10]['extension'] = 'php';
$wtgcsv_templatesystem_files[10]['level'] = 0;
// Util.php
$wtgcsv_templatesystem_files[11]['path'] = '/include/pear/File/';
$wtgcsv_templatesystem_files[11]['name'] = 'Util';
$wtgcsv_templatesystem_files[11]['extension'] = 'php';
$wtgcsv_templatesystem_files[11]['level'] = 0;
// File.php
$wtgcsv_templatesystem_files[12]['path'] = '/include/pear/';
$wtgcsv_templatesystem_files[12]['name'] = 'File';
$wtgcsv_templatesystem_files[12]['extension'] = 'php';
$wtgcsv_templatesystem_files[12]['level'] = 0;
// PEAR.php
$wtgcsv_templatesystem_files[13]['path'] = '/include/pear/';
$wtgcsv_templatesystem_files[13]['name'] = 'PEAR';
$wtgcsv_templatesystem_files[13]['extension'] = 'php';
$wtgcsv_templatesystem_files[13]['level'] = 0;
// include
$wtgcsv_templatesystem_files[14]['path'] = '/';
$wtgcsv_templatesystem_files[14]['name'] = 'include';
$wtgcsv_templatesystem_files[14]['extension'] = 'folder';
$wtgcsv_templatesystem_files[14]['level'] = 0;
// webservices
$wtgcsv_templatesystem_files[14]['path'] = '/include/';
$wtgcsv_templatesystem_files[14]['name'] = 'webservices';
$wtgcsv_templatesystem_files[14]['extension'] = 'folder';
$wtgcsv_templatesystem_files[14]['level'] = 0;
// wtg?_api_parent.php
$wtgcsv_templatesystem_files[15]['path'] = '/include/webservices/';
$wtgcsv_templatesystem_files[15]['name'] = WTG_CSV_ABB . 'api_parent';
$wtgcsv_templatesystem_files[15]['extension'] = 'php';
$wtgcsv_templatesystem_files[15]['level'] = 0;
// wtg?_api_tickets.php
$wtgcsv_templatesystem_files[16]['path'] = '/include/webservices/';
$wtgcsv_templatesystem_files[16]['name'] = WTG_CSV_ABB . 'api_tickets';
$wtgcsv_templatesystem_files[16]['extension'] = 'php';
$wtgcsv_templatesystem_files[16]['level'] = 0;
// wtg?_admin_functions.php
$wtgcsv_templatesystem_files[17]['path'] = '/include/';
$wtgcsv_templatesystem_files[17]['name'] = WTG_CSV_ABB . 'admin_functions';
$wtgcsv_templatesystem_files[17]['extension'] = 'php';
$wtgcsv_templatesystem_files[17]['level'] = 0;
// wtg?_admininterface_functions.php
$wtgcsv_templatesystem_files[18]['path'] = '/include/';
$wtgcsv_templatesystem_files[18]['name'] = WTG_CSV_ABB . 'admininterface_functions';
$wtgcsv_templatesystem_files[18]['extension'] = 'php';
$wtgcsv_templatesystem_files[18]['level'] = 0;
// wtg?_install_functions.php
$wtgcsv_templatesystem_files[21]['path'] = '/include/';
$wtgcsv_templatesystem_files[21]['name'] = WTG_CSV_ABB . 'install_functions';
$wtgcsv_templatesystem_files[21]['extension'] = 'php';
$wtgcsv_templatesystem_files[21]['level'] = 0;
// wtg?_post_processing.php
$wtgcsv_templatesystem_files[24]['path'] = '/include/';
$wtgcsv_templatesystem_files[24]['name'] = WTG_CSV_ABB . 'form_processing';
$wtgcsv_templatesystem_files[24]['extension'] = 'php';
$wtgcsv_templatesystem_files[24]['level'] = 0;
// wtg?_sql_functions.php
$wtgcsv_templatesystem_files[25]['path'] = '/include/';
$wtgcsv_templatesystem_files[25]['name'] = WTG_CSV_ABB . 'sql_functions';
$wtgcsv_templatesystem_files[25]['extension'] = 'php';
$wtgcsv_templatesystem_files[25]['level'] = 0;
// wtg?_variables_adminconfig.php
$wtgcsv_templatesystem_files[26]['path'] = '/include/variables/';
$wtgcsv_templatesystem_files[26]['name'] = WTG_CSV_ABB . 'variables_adminconfig';
$wtgcsv_templatesystem_files[26]['extension'] = 'php';
$wtgcsv_templatesystem_files[26]['level'] = 0;
// wtg?_variables_adminset_array.php
$wtgcsv_templatesystem_files[27]['path'] = '/include/variables/';
$wtgcsv_templatesystem_files[27]['name'] = WTG_CSV_ABB . 'variables_adminset_array';
$wtgcsv_templatesystem_files[27]['extension'] = 'php';
$wtgcsv_templatesystem_files[27]['level'] = 0;
// wtg?_variables_easyset_array.php
$wtgcsv_templatesystem_files[28]['path'] = '/include/variables/';
$wtgcsv_templatesystem_files[28]['name'] = WTG_CSV_ABB . 'variables_easyset_array';
$wtgcsv_templatesystem_files[28]['extension'] = 'php';
$wtgcsv_templatesystem_files[28]['level'] = 0;
// wtg?_variables_publicconfig.php
$wtgcsv_templatesystem_files[29]['path'] = '/include/variables/';
$wtgcsv_templatesystem_files[29]['name'] = WTG_CSV_ABB . 'variables_publicconfig';
$wtgcsv_templatesystem_files[29]['extension'] = 'php';
$wtgcsv_templatesystem_files[29]['level'] = 0;
// wtg?_variables_templatesystemfiles_array.php
$wtgcsv_templatesystem_files[32]['path'] = '/include/variables/';
$wtgcsv_templatesystem_files[32]['name'] = WTG_CSV_ABB . 'variables_templatesystemfiles_array';
$wtgcsv_templatesystem_files[32]['extension'] = 'php';
$wtgcsv_templatesystem_files[32]['level'] = 0;
// script
$wtgcsv_templatesystem_files[33]['path'] = '/';
$wtgcsv_templatesystem_files[33]['name'] = 'script';
$wtgcsv_templatesystem_files[33]['extension'] = 'folder';
$wtgcsv_templatesystem_files[33]['level'] = 0;
// script/multiselect
$wtgcsv_templatesystem_files[34]['path'] = '/script/';
$wtgcsv_templatesystem_files[34]['name'] = 'multiselect';
$wtgcsv_templatesystem_files[34]['extension'] = 'folder';
$wtgcsv_templatesystem_files[34]['level'] = 0;
// multi-select-basic
$wtgcsv_templatesystem_files[35]['path'] = '/script/';
$wtgcsv_templatesystem_files[35]['name'] = 'multi-select-basic';
$wtgcsv_templatesystem_files[35]['extension'] = 'folder';
$wtgcsv_templatesystem_files[35]['level'] = 0;
// jquery.multi-select.js
$wtgcsv_templatesystem_files[36]['path'] = '/script/multi-select-basic/';
$wtgcsv_templatesystem_files[36]['name'] = 'jquery.multi-select';
$wtgcsv_templatesystem_files[36]['extension'] = 'js';
$wtgcsv_templatesystem_files[36]['level'] = 0;
// jquery-1.7.1.js
$wtgcsv_templatesystem_files[40]['path'] = '/script/';
$wtgcsv_templatesystem_files[40]['name'] = 'jquery-1.7.1';
$wtgcsv_templatesystem_files[40]['extension'] = 'js';
$wtgcsv_templatesystem_files[40]['level'] = 0;
// jquery-ui.js
$wtgcsv_templatesystem_files[41]['path'] = '/script/';
$wtgcsv_templatesystem_files[41]['name'] = 'jquery-ui';
$wtgcsv_templatesystem_files[41]['extension'] = 'js';
$wtgcsv_templatesystem_files[41]['level'] = 0;
// uploader.js
$wtgcsv_templatesystem_files[42]['path'] = '/script/';
$wtgcsv_templatesystem_files[42]['name'] = 'uploader';
$wtgcsv_templatesystem_files[42]['extension'] = 'js';
$wtgcsv_templatesystem_files[42]['level'] = 0;
// wtgcsv_script_admin_jqueryui.php
$wtgcsv_templatesystem_files[43]['path'] = '/script/';
$wtgcsv_templatesystem_files[43]['name'] = WTG_CSV_ABB . 'script_admin_jqueryui';
$wtgcsv_templatesystem_files[43]['extension'] = 'php';
$wtgcsv_templatesystem_files[43]['level'] = 0;
// wtgcsv_script_parent.php
$wtgcsv_templatesystem_files[44]['path'] = '/script/';
$wtgcsv_templatesystem_files[44]['name'] = WTG_CSV_ABB . 'script_parent';
$wtgcsv_templatesystem_files[44]['extension'] = 'php';
$wtgcsv_templatesystem_files[44]['level'] = 0;
?>
