<?php
####################################################################
####                                                            ####
####           TABS NAVIGATION ARRAY ($csv2post_mpt_arr)        ####
####                                                            ####
####################################################################                                        
global $csv2post_homeslug,$csv2post_plugintitle;
$freepath = WTG_C2P_DIR.'pages/';
$paidpath = WTG_C2P_DIR.'fulledition/pages/';
$csv2post_mpt_arr = array();
// ARRAY INFORMATION FIRST
$csv2post_mpt_arr['arrayinfo']['version'] = '1.0.0';
// main page
$csv2post_mpt_arr['menu']['main']['active'] = true;// boolean -is this page in use
$csv2post_mpt_arr['menu']['main']['slug'] = 'csv2post';// home page slug set in main file
$csv2post_mpt_arr['menu']['main']['menu'] = 'CSV 2 POST';// main menu title
$csv2post_mpt_arr['menu']['main']['name'] = "mainpage";// name of page (slug) and unique
$csv2post_mpt_arr['menu']['main']['title'] = 'CSV 2 POST';// page title seen once page is opened
$csv2post_mpt_arr['menu']['main']['headers'] = false;// boolean - display a content area above selected tabs i.e. introductions or status
$csv2post_mpt_arr['menu']['main']['vertical'] = false;// boolean - is the menu vertical rather than horizontal
$csv2post_mpt_arr['menu']['main']['statusicons'] = false;// boolean - instead of related icons we use cross & tick etc indicating completion or not
$csv2post_mpt_arr['menu']['main']['permissions']['defaultcapability'] = 'update_core';// our best guess on a suitable capability
$csv2post_mpt_arr['menu']['main']['permissions']['customcapability'] = 'update_core';// users requested capability which is giving priority over default
$csv2post_mpt_arr['menu']['main']['package'] = 'free';// free|paid|beta - free will add screen to all packages - beta requires $csv2post_beta_mode = true to display the screen, meaning beta can be hidden also, important for switching to a ready build before release 
$sub = 0;#1 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;// boolean - developer only - disbale screen in all packages using false
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'quickstart';// old tab0_main
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Quick Start';      
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_quickstart.php';   // old csv2post_tab'.$sub.'_main
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';// optional, if not set, scripts will default to 'activate_plugins'
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'import';// example only, does not need to be set for every tab, will be set when user changes the required capability
++$sub;#2 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'news';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'News';  
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_news.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'update_core'; 
++$sub;#3 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'updatepaidcore';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Update Paid Core';  
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_updatepaidcore.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'update_core';
++$sub;#4 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'about';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'About';  
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_about.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins'; 
++$sub;#5 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'generalsettings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'General Settings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_generalsettings.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins'; 
++$sub;#6 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'datasettings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Data Settings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_datasettings.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';  
++$sub;#7 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'ecq';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Easy Configuration Questions';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_ecq.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';
++$sub;#8
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'schedulesettings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Schedule Settings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_schedulesettings.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';
++$sub;#9
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'fileprofiles';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'File Profiles';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_fileprofiles.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins'; 
++$sub;#10
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'labels';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Labels (Beta)';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'beta';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $paidpath.'main/csv2post_labels.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;#11
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'install';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Install';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_install.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;#12
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'dev';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Dev';# developer information
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'beta';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $paidpath.'main/csv2post_dev.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;#13
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'extensions';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Extensions';# developer information
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $paidpath.'main/csv2post_extensions.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;#14
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'log';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Log';# developer information
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/csv2post_log.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
 
######################################################
#                                                    #
#                         DATA                       #
#                                                    #
######################################################
$csv2post_mpt_arr['menu']['data']['active'] = true;
$csv2post_mpt_arr['menu']['data']['slug'] =  "csv2post_yourdata";
$csv2post_mpt_arr['menu']['data']['menu'] = "1. Your Data";
$csv2post_mpt_arr['menu']['data']['name'] = "yourdata";
$csv2post_mpt_arr['menu']['data']['title'] = 'Data Import';
$csv2post_mpt_arr['menu']['data']['icon'] = 'options-general';
$csv2post_mpt_arr['menu']['data']['headers'] = false;
$csv2post_mpt_arr['menu']['data']['vertical'] = false;
$csv2post_mpt_arr['menu']['data']['statusicons'] = true;
$csv2post_mpt_arr['menu']['data']['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['data']['package'] = 'paid';// free|paid (using free) 
$sub = 0;#1
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'datastart';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Start';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_datastart.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';  
++$sub;#2
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'basicimporter';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Basic Importer';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_basicimporter.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import'; 
++$sub;#3
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'exporttools';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Export Tools';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_exporttools.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'export';
++$sub;#4
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'createdtables';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Created Tables';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_createdtables.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;#5
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'datarules';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Data Rules';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_datarules.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';
++$sub;#7
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'datasources';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Data Sources';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_datasources.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;#8
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'search';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Search';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_search.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;#9
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'premiumimporter';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Premium Importer';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_premiumimporter.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';
++$sub;#10
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tabletotable';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Table To Table';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = $paidpath.'data/csv2post_tabletotable.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';


######################################################
#                                                    #
#                    YOUR PROJECTS                   #
#                                                    #
######################################################
$csv2post_mpt_arr['menu']['projects']['active'] = true;
$csv2post_mpt_arr['menu']['projects']['slug'] =  "csv2post_yourprojects";
$csv2post_mpt_arr['menu']['projects']['menu'] = "2. Your Projects";
$csv2post_mpt_arr['menu']['projects']['name'] = "yourprojects";
$csv2post_mpt_arr['menu']['projects']['title'] = 'Post Creation';
$csv2post_mpt_arr['menu']['projects']['icon'] = 'options-general';
$csv2post_mpt_arr['menu']['projects']['headers'] = false;
$csv2post_mpt_arr['menu']['projects']['statusicons'] = true;
$csv2post_mpt_arr['menu']['projects']['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['projects']['package'] = 'paid';// free|paid (using free)   
$sub = 0;#1
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'projects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Projects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_projects.php';  
++$sub;#2
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'contenttemplate';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Content';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_contenttemplate.php';
++$sub;#3
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'titletemplates';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Titles';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_titletemplates.php';   
++$sub;#4
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'seo';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'SEO';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_seo.php';
++$sub;#5
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'postsettings';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Post Settings';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_postsettings.php';
++$sub;#6
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'dates';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Dates';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_dates.php';
++$sub;#7
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'customfields';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Custom Fields';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_customfields.php';
++$sub;#8
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'categories';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Categories';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_categories.php'; 
++$sub;#9
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'updateoptions';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Update Options';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_updateoptions.php';
++$sub;#10
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'images';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Images';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_images.php';
++$sub;#11
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'links';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'URL/Links';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_links.php';
++$sub;#12
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tags';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Tags';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_tags.php';   
++$sub;#13
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'spinning';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Text Spinning';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_spinning.php';
++$sub;#14
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'info';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Info';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_info.php';
++$sub;#15
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'authors';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Authors';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_authors.php';
++$sub;#16
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'themes';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Theme Support';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_themes.php';
++$sub;#17
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'adoption';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Adoption';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = $paidpath.'projects/csv2post_adoption.php';

######################################################
#                                                    #
#                    CREATION                        #
#                                                    #
######################################################
$csv2post_mpt_arr['menu']['creation']['active'] = true;
$csv2post_mpt_arr['menu']['creation']['slug'] =  WTG_C2P_ABB . "yourcreation";
$csv2post_mpt_arr['menu']['creation']['menu'] = "3. Your Creation";
$csv2post_mpt_arr['menu']['creation']['name'] = "yourcreation";
$csv2post_mpt_arr['menu']['creation']['title'] = 'Your Creation';
$csv2post_mpt_arr['menu']['creation']['icon'] = 'options-general';
$csv2post_mpt_arr['menu']['creation']['headers'] = false;
$csv2post_mpt_arr['menu']['creation']['vertical'] = false;
$csv2post_mpt_arr['menu']['creation']['statusicons'] = true;
$csv2post_mpt_arr['menu']['creation']['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['creation']['package'] = 'paid';// free|paid (using free)
$sub = 0;#1
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'createcategories';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = '1. Create Categories';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = $paidpath.'creation/csv2post_createcategories.php'; 
++$sub;#1
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'createposts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = '2. Create Posts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = $paidpath.'creation/csv2post_createposts.php';
++$sub;#2
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'updateposts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = '3. Update Posts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = $paidpath.'creation/csv2post_updateposts.php';     
++$sub;#3
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'scheduleevents';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'Scheduled Events';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = $paidpath.'creation/csv2post_scheduledevents.php';
++$sub;#4
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'undocreations';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'Undo Creations';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = $paidpath.'creation/csv2post_undocreations.php';
++$sub;#5
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'viewposts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'View Posts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = $paidpath.'creation/csv2post_viewposts.php';

######################################################
#                                                    #
#                     MORE PAGE                      #
#                                                    #
######################################################  
$csv2post_mpt_arr['menu']['more']['active'] = false;
$csv2post_mpt_arr['menu']['more']['slug'] = "csv2post_more";
$csv2post_mpt_arr['menu']['more']['menu'] = "More";
$csv2post_mpt_arr['menu']['more']['role'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['more']['title'] = 'More';
$csv2post_mpt_arr['menu']['more']['name'] = 'more'; 
$csv2post_mpt_arr['menu']['more']['icon'] = 'install';
$csv2post_mpt_arr['menu']['more']['headers'] = false;
$csv2post_mpt_arr['menu']['more']['vertical'] = false;
$csv2post_mpt_arr['menu']['more']['statusicons'] = false;
$csv2post_mpt_arr['menu']['more']['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['more']['package'] = 'paid';// free|paid (using free)      
$sub = 0;#1
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab0_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Support';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php';   
++$sub;#2
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab1_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Community';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php';  
++$sub;#3
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab2_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Downloads';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php';  
++$sub;#4
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab3_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Affiliates';// Affiliate, payment history, traffic stats, display banners
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php'; 
++$sub;#5
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab4_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Development';// RSS feed link, blog entries directly, coming soon (top feature coming next)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php';
++$sub;#6
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab5_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Testing';// test blogs, beta tester list, test forum discussion, RSS for testers and developers, short TO DO list (not whole list)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php'; 
++$sub;#7
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab6_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Offers';// display a range of main offers, hosting packages with premium plugin purchase, free installs, setup etc
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php'; 
++$sub;#8
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab7_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'My Tickets';// users submitted tickets, if API can access
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php'; 
++$sub;#9
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab8_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'My Account';// purchased plugins, users account, transactions, loyalty points, stored API key, special permissions and access indicators etc
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php'; 
++$sub;#10
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab9_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Contact';// advanced contact form, creates ticket, forum post and sends email
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = $paidpath.'more/csv2post_tab'.$sub.'_more.php';
?>