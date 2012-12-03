<?php
####################################################################
####                                                            ####
####           TABS NAVIGATION ARRAY ($csv2post_mpt_arr)        ####
####                                                            ####
####################################################################
### TODO:HIGHPRIORITY,using the ['path'] parameter created for extensions, create the ability to add the full
### path so that we can point to any web page or file and not just those in extension or plugin core

/**
* Returns value for displaying or hiding a page based on edition (free or full).
* These is no point bypassing this. The pages hidden require PHP that is only provided with
* the full edition. You may be able to use the forms, but the data saved won't do anything or might
* cause problems.
* 
* @param mixed $package_allowed, 0=free 1=full/paid 2=dont ever display
* @returns boolean true if screen is to be shown else false
* @todo LOWPRIORITY, rename function to csv2post_screen_active()
*/
function csv2post_page_show_hide($package_allowed = 0){
    global $csv2post_is_free;
    
    if($package_allowed == 2){
        return false;// do not display in any package
    }elseif($csv2post_is_free && $package_allowed == 0){
        return true;     
    }elseif($csv2post_is_free && $package_allowed == 1){
        return false;// paid edition page only, not be displayed in free edition
    }
    return true;
}

global $csv2post_homeslug,$csv2post_plugintitle;
$csv2post_mpt_arr = array();
// main page
$csv2post_mpt_arr['main']['active'] = true;// boolean -is this page in use
$csv2post_mpt_arr['main']['slug'] = $csv2post_homeslug;// home page slug set in main file
$csv2post_mpt_arr['main']['menu'] = $csv2post_plugintitle;// plugin dashboard page title
$csv2post_mpt_arr['main']['name'] = "mainpage";// name of page (slug) and unique
$csv2post_mpt_arr['main']['role'] = 'activate_plugins';// minimum required role in order to VIEW the page
$csv2post_mpt_arr['main']['title'] = 'CSV 2 POST';// page title seen once page is opened
$csv2post_mpt_arr['main']['headers'] = false;// boolean - display a content area above selected tabs i.e. introductions or status
$csv2post_mpt_arr['main']['vertical'] = false;// boolean - is the menu vertical rather than horizontal
$csv2post_mpt_arr['main']['statusicons'] = false;// boolean - instead of related icons we use cross & tick etc indicating completion or not
// main 0
$sub = 0; 
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'tab0_main';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'Screens';      
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';  
// main 1
++$sub; 
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'tab1_main';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'Updates';  
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php'; 
// main 2
++$sub; 
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'tab2_main';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'Quick Start';  
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
// main 3
++$sub; 
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'tab3_main';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'About';  
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php'; 
// main 4
++$sub; 
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'tab4_main';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'General Settings';
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php'; 
// main 5
++$sub; 
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'tab5_main';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'Interface Settings';
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';  
// main 6
++$sub; 
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'tab6_main';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'Easy Configuration Questions';
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = true; 
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide(); 
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_tab'.$sub.'_main.php';
// main 7
++$sub;
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'schedulesettings';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'Schedule Settings';
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_schedulesettings.php';
// main 8
++$sub;
$csv2post_mpt_arr['main']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][$sub]['slug'] = 'fileprofiles';
$csv2post_mpt_arr['main']['tabs'][$sub]['label'] = 'File Profiles';
$csv2post_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['main']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);// 0 = free+paid  1 = paid only  2 = none
$csv2post_mpt_arr['main']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/pagemain/csv2post_fileprofiles.php';
        
######################################################
#                                                    #
#                         DATA                       #
#                                                    #
######################################################
$csv2post_mpt_arr['data']['active'] = true;
$csv2post_mpt_arr['data']['slug'] =  "csv2post_yourdata";
$csv2post_mpt_arr['data']['menu'] = "1. Your Data";
$csv2post_mpt_arr['data']['name'] = "yourdata";
$csv2post_mpt_arr['data']['role'] = 'administrator';
$csv2post_mpt_arr['data']['title'] = 'Current Job: ';
$csv2post_mpt_arr['data']['icon'] = 'options-general';
$csv2post_mpt_arr['data']['headers'] = false;
$csv2post_mpt_arr['data']['vertical'] = false;
$csv2post_mpt_arr['data']['statusicons'] = true;     
// data 0
$sub = 0;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab0_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Start';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';  
// data 1
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab1_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Basic Import';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php'; 
// data 2
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab2_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Export Tools';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
// data 3
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab3_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Created Tables';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
// data 4
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab4_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Data Rules';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide(2);
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
// data 5
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab5_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'History';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide(2);
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
// data 6
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab6_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Data Sources';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide(2);
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
// data 7
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = false;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab7_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Search';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide(2);
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
// data 8
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab8_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Advanced Import';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
// data 9
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'tab9_pagedata';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Table To Table';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_tab'.$sub.'_pagedata.php';
// data 10
++$sub;
$csv2post_mpt_arr['data']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['slug'] = 'datahistory';
$csv2post_mpt_arr['data']['tabs'][$sub]['label'] = 'Data History';
$csv2post_mpt_arr['data']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][$sub]['display'] = csv2post_page_show_hide(0);// 0 = free+paid  1 = paid only  2 = none
$csv2post_mpt_arr['data']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/data/csv2post_datahistory.php';
### TODO:LOWPRIORITY, add a page that tests all CSV files and lists their status and profile 
### if however it effects loading, could do it with the files in use or latest files uploaded
### full edition only 

######################################################
#                                                    #
#                    YOUR PROJECTS                   #
#                                                    #
######################################################
$csv2post_mpt_arr['projects']['active'] = true;
$csv2post_mpt_arr['projects']['slug'] =  "csv2post_yourprojects";
$csv2post_mpt_arr['projects']['menu'] = "2. Your Projects";
$csv2post_mpt_arr['projects']['name'] = "yourprojects";
$csv2post_mpt_arr['projects']['role'] = 'administrator';
$csv2post_mpt_arr['projects']['title'] = 'Current Project: ';
$csv2post_mpt_arr['projects']['icon'] = 'options-general';
$csv2post_mpt_arr['projects']['headers'] = false;
$csv2post_mpt_arr['projects']['vertical'] = false;
$csv2post_mpt_arr['projects']['statusicons'] = true;     
// projects 0
$sub = 0;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab0_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Projects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = false;
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide(); 
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 1
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab1_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Content';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 2
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab2_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Titles';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 3
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab3_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'SEO';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 4
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab4_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Post Types';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 5
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab5_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Post Dates';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 6
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab6_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Custom Fields';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 7
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab7_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Categories';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php'; 
// projects 8
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab8_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Update Options';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 9
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab9_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Images';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 10
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab10_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'URL Cloaking';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide(2);
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 11
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab11_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Tags';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 12
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab12_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Text Spinning';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 13
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab13_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Project Data';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 14
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab14_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Authors';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 15
++$sub;
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'tab15_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Theme Support';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_tab'.$sub.'_pageprojects.php';
// projects 16
++$sub;                                                        
$csv2post_mpt_arr['projects']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][$sub]['slug'] = 'projecthistory';
$csv2post_mpt_arr['projects']['tabs'][$sub]['label'] = 'Project History';
$csv2post_mpt_arr['projects']['tabs'][$sub]['allowhide'] = true;   
$csv2post_mpt_arr['projects']['tabs'][$sub]['display'] = csv2post_page_show_hide(0);// 0 = free+paid  1 = paid only  2 = none
$csv2post_mpt_arr['projects']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/projects/csv2post_projecthistory.php';

######################################################
#                                                    #
#                    CREATION                        #
#                                                    #
######################################################
$csv2post_mpt_arr['creation']['active'] = true;
$csv2post_mpt_arr['creation']['slug'] =  WTG_C2P_ABB . "yourcreation";
$csv2post_mpt_arr['creation']['menu'] = "3. Your Creation";
$csv2post_mpt_arr['creation']['name'] = "yourcreation";
$csv2post_mpt_arr['creation']['role'] = 'administrator';
$csv2post_mpt_arr['creation']['title'] = 'Your Creation';
$csv2post_mpt_arr['creation']['icon'] = 'options-general';
$csv2post_mpt_arr['creation']['headers'] = false;
$csv2post_mpt_arr['creation']['vertical'] = false;
$csv2post_mpt_arr['creation']['statusicons'] = true; 
// creation 0
$sub = 0;
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'tab0_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'Create Posts';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide(0);
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_tab'.$sub.'_pagecreation.php';     
// creation 1
++$sub;
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'tab1_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'Schedule Events';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_tab'.$sub.'_pagecreation.php';
// creation 2
++$sub;
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'tab2_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'Update Posts';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_tab'.$sub.'_pagecreation.php';
// creation 3
++$sub;
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'tab3_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'Undo';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_tab'.$sub.'_pagecreation.php';
// creation 4
++$sub;
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'tab4_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'View Posts';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide(2);
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_tab'.$sub.'_pagecreation.php';
// creation 5
++$sub;
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'tab5_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'Create Categories';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_tab'.$sub.'_pagecreation.php';
// creation 6
++$sub; 
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'tab6_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'Flagged Posts';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_tab'.$sub.'_pagecreation.php';       
// creation 7
++$sub;                                                        
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'postshistory';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'Posts History';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;   
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide(0);// 0 = free+paid  1 = paid only  2 = none
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_postshistory.php';
// creation 8
++$sub;                                                        
$csv2post_mpt_arr['creation']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][$sub]['slug'] = 'automationhistory';
$csv2post_mpt_arr['creation']['tabs'][$sub]['label'] = 'Automation History';
$csv2post_mpt_arr['creation']['tabs'][$sub]['allowhide'] = true;   
$csv2post_mpt_arr['creation']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);// 0 = free+paid  1 = paid only  2 = none
$csv2post_mpt_arr['creation']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/creation/csv2post_automation.php';
  
######################################################
#                                                    #
#                INSTALL and STATUS                  #
#                                                    #
######################################################
// install page
$csv2post_mpt_arr['install']['active'] = true;
$csv2post_mpt_arr['install']['slug'] = WTG_C2P_ABB . "install";
$csv2post_mpt_arr['install']['menu'] = "Install/Uninstall";
$csv2post_mpt_arr['install']['role'] = 'activate_plugins';
$csv2post_mpt_arr['install']['title'] = 'Install';
$csv2post_mpt_arr['install']['name'] = 'install';
$csv2post_mpt_arr['install']['icon'] = 'install';
$csv2post_mpt_arr['install']['headers'] = false;
$csv2post_mpt_arr['install']['vertical'] = false;
$csv2post_mpt_arr['install']['statusicons'] = false;  
// install 0
$sub = 0;
$csv2post_mpt_arr['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][$sub]['slug'] = 'tab0_install';
$csv2post_mpt_arr['install']['tabs'][$sub]['label'] = 'Install Actions';
$csv2post_mpt_arr['install']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['install']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php'; 
// install 1
++$sub;
$csv2post_mpt_arr['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][$sub]['slug'] = 'tab1_install';
$csv2post_mpt_arr['install']['tabs'][$sub]['label'] = 'Install History';
$csv2post_mpt_arr['install']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['install']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';  
// install 2
++$sub;
$csv2post_mpt_arr['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][$sub]['slug'] = 'tab2_install';
$csv2post_mpt_arr['install']['tabs'][$sub]['label'] = 'Install Status';
$csv2post_mpt_arr['install']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['install']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';   
// install 3
++$sub;
$csv2post_mpt_arr['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][$sub]['slug'] = 'tab3_install';
$csv2post_mpt_arr['install']['tabs'][$sub]['label'] = 'Your Server Status';
$csv2post_mpt_arr['install']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['install']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';   
// install 4
++$sub;
$csv2post_mpt_arr['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][$sub]['slug'] = 'tab4_install';
$csv2post_mpt_arr['install']['tabs'][$sub]['label'] = 'Activation Controls';
$csv2post_mpt_arr['install']['tabs'][$sub]['allowhide'] = false  ;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['install']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php';
// install 5
++$sub;
$csv2post_mpt_arr['install']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][$sub]['slug'] = 'tab5_install';
$csv2post_mpt_arr['install']['tabs'][$sub]['label'] = 'Files Status';
$csv2post_mpt_arr['install']['tabs'][$sub]['allowhide'] = false  ;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['install']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['install']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/install/csv2post_tab'.$sub.'_install.php'; 

######################################################
#                                                    #
#                     MORE PAGE                      #
#                                                    #
######################################################  
// more page - includes a sub-menu for offering far more pages without adding to plugn menu
$csv2post_mpt_arr['more']['active'] = false;
$csv2post_mpt_arr['more']['slug'] = "csv2post_more";
$csv2post_mpt_arr['more']['menu'] = "More";
$csv2post_mpt_arr['more']['role'] = 'activate_plugins';
$csv2post_mpt_arr['more']['title'] = 'More';
$csv2post_mpt_arr['more']['name'] = 'more'; 
$csv2post_mpt_arr['more']['icon'] = 'install';
$csv2post_mpt_arr['more']['headers'] = false;
$csv2post_mpt_arr['more']['vertical'] = false;
$csv2post_mpt_arr['more']['statusicons'] = false;      
// more 0
$sub = 0;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab0_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'Support';
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';   
// more 1
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab1_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'Community';
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';  
// more 2
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab2_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'Downloads';
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';  
// more 3
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab3_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'Affiliates';// Affiliate, payment history, traffic stats, display banners
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 4
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab4_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'Development';// RSS feed link, blog entries directly, coming soon (top feature coming next)
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';
// more 5
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab5_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'Testing';// test blogs, beta tester list, test forum discussion, RSS for testers and developers, short TO DO list (not whole list)
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 6
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab6_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'Offers';// display a range of main offers, hosting packages with premium plugin purchase, free installs, setup etc
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 7
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab7_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'My Tickets';// users submitted tickets, if API can access
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 8
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab8_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'My Account';// purchased plugins, users account, transactions, loyalty points, stored API key, special permissions and access indicators etc
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php'; 
// more 9
++$sub;
$csv2post_mpt_arr['more']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][$sub]['slug'] = 'tab9_more';
$csv2post_mpt_arr['more']['tabs'][$sub]['label'] = 'Contact';// advanced contact form, creates ticket, forum post and sends email
$csv2post_mpt_arr['more']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['more']['tabs'][$sub]['display'] = csv2post_page_show_hide(1);
$csv2post_mpt_arr['more']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_tab'.$sub.'_more.php';

######################################################
#                                                    #
#                     BETA PAGE                      #
#                                                    #
######################################################  
// beta page - used for testing, new interfaces will be added too the beta area for sometime and in paid edition only
$csv2post_mpt_arr['beta']['active'] = false;
$csv2post_mpt_arr['beta']['slug'] = "csv2post_beta";
$csv2post_mpt_arr['beta']['menu'] = "Beta";
$csv2post_mpt_arr['beta']['role'] = 'activate_plugins';// required user role permission
$csv2post_mpt_arr['beta']['title'] = 'Beta';
$csv2post_mpt_arr['beta']['name'] = 'beta'; 
$csv2post_mpt_arr['beta']['icon'] = 'install';
$csv2post_mpt_arr['beta']['headers'] = false;
$csv2post_mpt_arr['beta']['vertical'] = false;
$csv2post_mpt_arr['beta']['statusicons'] = false;      
// more 0
$sub = 0;
$csv2post_mpt_arr['beta']['tabs'][$sub]['active'] = true;
$csv2post_mpt_arr['beta']['tabs'][$sub]['slug'] = 'betaone';
$csv2post_mpt_arr['beta']['tabs'][$sub]['label'] = 'Beta One';
$csv2post_mpt_arr['beta']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['beta']['tabs'][$sub]['display'] = csv2post_page_show_hide();
$csv2post_mpt_arr['beta']['tabs'][$sub]['path'] = WTG_C2P_DIR.'pages/more/csv2post_betaone.php';
?>
