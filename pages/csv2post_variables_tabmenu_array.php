<?php
####################################################################
####                                                            ####
####           TABS NAVIGATION ARRAY ($csv2post_mpt_arr)        ####
####                                                            ####
####################################################################
global $csv2post_homeslug,$csv2post_plugintitle;
$csv2post_mpt_arr = array();
// ARRAY INFORMATION FIRST
$csv2post_mpt_arr['arrayinfo']['version'] = '1.0.0';### TODO:LOWPRIORITY, apply this value to all array, will require extensive testing
// main page
$csv2post_mpt_arr['menu']['main']['active'] = true;// boolean -is this page in use
$csv2post_mpt_arr['menu']['main']['slug'] = $csv2post_homeslug;// home page slug set in main file
$csv2post_mpt_arr['menu']['main']['menu'] = 'CSV 2 POST';// main menu title
$csv2post_mpt_arr['menu']['main']['name'] = "mainpage";// name of page (slug) and unique
$csv2post_mpt_arr['menu']['main']['title'] = 'CSV 2 POST';// page title seen once page is opened
$csv2post_mpt_arr['menu']['main']['headers'] = false;// boolean - display a content area above selected tabs i.e. introductions or status
$csv2post_mpt_arr['menu']['main']['vertical'] = false;// boolean - is the menu vertical rather than horizontal
$csv2post_mpt_arr['menu']['main']['statusicons'] = false;// boolean - instead of related icons we use cross & tick etc indicating completion or not
$csv2post_mpt_arr['menu']['main']['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['main']['permissions']['customcapability'] = 'update_core';

// main 0
$sub = 0; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;// boolean - developer only - disbale screen in all packages using false
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'tab0_main';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Easy CSV Importer (beta)';      
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';// optional, if not set, scripts will default to 'activate_plugins'
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'import';// example only, does not need to be set for every tab, will be set when user changes the required capability
// main 1
++$sub; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'tab1_main';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Updates';  
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'update_core'; 
// main 2
++$sub; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'tab2_main';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Update Paid Core';  
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'update_core';
// main 3
++$sub; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'tab3_main';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'About';  
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins'; 
// main 4
++$sub; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'tab4_main';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'General Settings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins'; 
// main 5
++$sub; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'tab5_main';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Interface Settings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';  
// main 6
++$sub; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'tab6_main';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Easy Configuration Questions (beta)';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true; 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens 
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';
// main 7
++$sub;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'schedulesettings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Schedule Settings';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_schedulesettings.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';
// main 8
++$sub;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'fileprofiles';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'File Profiles';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_fileprofiles.php';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$csv2post_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';
        
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
    
// data 0
$sub = 0;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab0_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Start';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';  
// data 1
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab1_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Basic Import';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import'; 
// data 2
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab2_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Export Tools';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'export';
// data 3
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab3_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Created Tables';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
// data 4
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab4_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Data Rules';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';
// data 5
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab5_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'History';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
// data 6
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab6_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Data Sources';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';

// data 7
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab7_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Search';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
// data 8
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab8_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Advanced Import';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';
// data 9
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'tab9_pagedata';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Table To Table';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'import';
// data 10
++$sub;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['slug'] = 'datahistory';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['label'] = 'Data History';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_datahistory.php';
$csv2post_mpt_arr['menu']['data']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
### TODO:LOWPRIORITY, add a page that tests all CSV files and lists their status and profile 
### if however it effects loading, could do it with the files in use or latest files uploaded
### full edition only 

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
$csv2post_mpt_arr['menu']['projects']['vertical'] = false;
$csv2post_mpt_arr['menu']['projects']['statusicons'] = true;
$csv2post_mpt_arr['menu']['projects']['permissions']['defaultcapability'] = 'update_core'; 
     
// projects 0
$sub = 0;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab0_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Projects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
 
// projects 1  
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab1_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Content';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 2
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab2_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Titles';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 3   
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab3_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'SEO';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 4
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab4_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Post Types';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 5
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab5_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Post Dates';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 6
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab6_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Custom Fields';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 7
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab7_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Categories';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php'; 
// projects 8
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab8_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Update Options';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 9
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab9_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Images';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 10
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab10_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'URL Cloaking';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 11
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab11_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Tags';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 12   
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab12_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Text Spinning';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 13
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab13_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Project Data';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 14
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab14_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Authors';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 15
++$sub;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'tab15_pageprojects';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Theme Support';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 16
++$sub;                                                        
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['slug'] = 'projecthistory';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['label'] = 'Project History';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['allowhide'] = true;   
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_projecthistory.php';

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
$sub = 0;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'createcategories';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = '1. Create Categories';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_createcategories.php'; 
++$sub;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'createposts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = '2. Create Posts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_createposts.php';
++$sub;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'updateposts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = '3. Update Posts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_updateposts.php';     
++$sub;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'scheduleevents';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'Scheduled Events';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_scheduledevents.php';
++$sub;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'undocreations';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'Undo Creations';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_undocreations.php';
++$sub;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'viewposts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'View Posts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_viewposts.php';
++$sub; 
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'flaggedposts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'Flagged Posts';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_flaggedposts.php';       
++$sub;                                                        
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'postshistory';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'Posts History';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;   
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_postshistory.php';
++$sub;                                                        
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['slug'] = 'automationhistory';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['label'] = 'Automation History';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['allowhide'] = true;   
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_automation.php';
  
######################################################
#                                                    #
#                INSTALL and STATUS                  #
#                                                    #
######################################################
// install page
$csv2post_mpt_arr['menu']['install']['active'] = true;
$csv2post_mpt_arr['menu']['install']['slug'] = WTG_C2P_ABB . "install";
$csv2post_mpt_arr['menu']['install']['menu'] = "Install/Uninstall";
$csv2post_mpt_arr['menu']['install']['title'] = 'Install';
$csv2post_mpt_arr['menu']['install']['name'] = 'install';
$csv2post_mpt_arr['menu']['install']['icon'] = 'install';
$csv2post_mpt_arr['menu']['install']['headers'] = false;
$csv2post_mpt_arr['menu']['install']['vertical'] = false;
$csv2post_mpt_arr['menu']['install']['statusicons'] = false; 
$csv2post_mpt_arr['menu']['install']['permissions']['defaultcapability'] = 'update_core'; 
// install 0
$sub = 0;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['slug'] = 'tab0_install';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['label'] = 'Install Actions';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins'; 
// install 1
++$sub;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['slug'] = 'tab1_install';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['label'] = 'Install History';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';  
// install 2
++$sub;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['slug'] = 'tab2_install';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['label'] = 'Install Status';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';   
// install 3
++$sub;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['slug'] = 'tab3_install';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['label'] = 'Your Server Status';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';   
// install 4
++$sub;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['slug'] = 'tab4_install';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['label'] = 'Activation Controls';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['allowhide'] = false  ;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';
// install 5
++$sub;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['slug'] = 'tab5_install';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['label'] = 'Files Status';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['allowhide'] = false  ;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['package'] = 'paid';
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php'; 

######################################################
#                                                    #
#                     MORE PAGE                      #
#                                                    #
######################################################  
// more page - includes a sub-menu for offering far more pages without adding to plugn menu
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
// more 0
$sub = 0;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab0_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Support';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';   
// more 1
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab1_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Community';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';  
// more 2
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab2_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Downloads';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';  
// more 3
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab3_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Affiliates';// Affiliate, payment history, traffic stats, display banners
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 4
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab4_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Development';// RSS feed link, blog entries directly, coming soon (top feature coming next)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';
// more 5
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab5_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Testing';// test blogs, beta tester list, test forum discussion, RSS for testers and developers, short TO DO list (not whole list)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 6
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab6_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Offers';// display a range of main offers, hosting packages with premium plugin purchase, free installs, setup etc
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 7
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab7_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'My Tickets';// users submitted tickets, if API can access
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 8
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab8_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'My Account';// purchased plugins, users account, transactions, loyalty points, stored API key, special permissions and access indicators etc
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 9
++$sub;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['slug'] = 'tab9_more';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['label'] = 'Contact';// advanced contact form, creates ticket, forum post and sends email
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';

######################################################
#                                                    #
#                     BETA PAGE                      #
#                                                    #
######################################################  
// beta page - used for testing, new interfaces will be added to the beta area for sometime and in paid edition only
$csv2post_mpt_arr['menu']['beta']['active'] = false;
$csv2post_mpt_arr['menu']['beta']['slug'] = "csv2post_beta";
$csv2post_mpt_arr['menu']['beta']['menu'] = "Beta";
$csv2post_mpt_arr['menu']['beta']['role'] = 'activate_plugins';// required user role permission
$csv2post_mpt_arr['menu']['beta']['title'] = 'Beta';
$csv2post_mpt_arr['menu']['beta']['name'] = 'beta'; 
$csv2post_mpt_arr['menu']['beta']['icon'] = 'install';
$csv2post_mpt_arr['menu']['beta']['headers'] = false;
$csv2post_mpt_arr['menu']['beta']['vertical'] = false;
$csv2post_mpt_arr['menu']['beta']['statusicons'] = false;
$csv2post_mpt_arr['menu']['beta']['permissions']['defaultcapability'] = 'update_core';      
// more 0
$sub = 0;
$csv2post_mpt_arr['menu']['beta']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['menu']['beta']['tabs'][$sub]['slug'] = 'betaone';
$csv2post_mpt_arr['menu']['beta']['tabs'][$sub]['label'] = 'Beta One';
$csv2post_mpt_arr['menu']['beta']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['menu']['beta']['tabs'][$sub]['package'] = 'free';
$csv2post_mpt_arr['menu']['beta']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$csv2post_mpt_arr['menu']['beta']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_betaone.php';
?>
