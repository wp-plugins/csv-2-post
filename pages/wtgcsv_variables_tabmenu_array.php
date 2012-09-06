<?php
####################################################################
####                                                            ####
####           TABS NAVIGATION ARRAY ($wtgcsv_mpt_arr)          ####
####                                                            ####
####################################################################

/**
* Returns value for displaying or hiding a page based on edition (free or full).
* These is no point bypassing this. The pages hidden require PHP that is only provided with
* the full edition. You may be able to use the forms, but the data saved won't do anything or might
* cause problems.
* 
* @param mixed $package_allowed, 0=free 1=full/paid 2=dont ever display
*/
function wtgcsv_page_show_hide($package_allowed = 0){
    global $wtgcsv_is_free;
    
    if($package_allowed == 2){
        return false;// do not display in any package
    }elseif($wtgcsv_is_free && $package_allowed == 0){
        return true;     
    }elseif($wtgcsv_is_free && $package_allowed == 1){
        return false;// paid edition page only, not be displayed in free edition
    }
    return true;
}

global $wtgcsv_homeslug;
$wtgcsv_mpt_arr = array();
// main page
$wtgcsv_mpt_arr['main']['active'] = true;// boolean -is this page in use
$wtgcsv_mpt_arr['main']['slug'] = $wtgcsv_homeslug;// home page slug set in main file
$wtgcsv_mpt_arr['main']['menu'] = WTG_CSV_PLUGINTITLE;// plugin dashboard page title
$wtgcsv_mpt_arr['main']['name'] = "mainpage";// name of page (slug) and unique
$wtgcsv_mpt_arr['main']['role'] = 'activate_plugins';// minimum required role in order to VIEW the page
$wtgcsv_mpt_arr['main']['title'] = 'Wordpress CSV Importer';// page title seen once page is opened
$wtgcsv_mpt_arr['main']['pagehelp'] = 'http://www.importcsv.eu';// url to the help content on plugin site for this page
$wtgcsv_mpt_arr['main']['headers'] = false;// boolean - display a content area above selected tabs i.e. introductions or status
$wtgcsv_mpt_arr['main']['vertical'] = false;// boolean - is the menu vertical rather than horizontal
$wtgcsv_mpt_arr['main']['statusicons'] = false;// boolean - instead of related icons we use cross & tick etc indicating completion or not
// main sub page 1 tab 1
$wtgcsv_mpt_arr['main']['tabs'][0]['active'] = true;
$wtgcsv_mpt_arr['main']['tabs'][0]['slug'] = 'tab0_main';
$wtgcsv_mpt_arr['main']['tabs'][0]['label'] = 'Screens';
$wtgcsv_mpt_arr['main']['tabs'][0]['name'] = 'screens';     
$wtgcsv_mpt_arr['main']['tabs'][0]['helpurl'] = 'http://www.importcsv.eu/'; 
$wtgcsv_mpt_arr['main']['tabs'][0]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$wtgcsv_mpt_arr['main']['tabs'][0]['display'] = wtgcsv_page_show_hide(2); 
// main sub page 1 tab 2
$wtgcsv_mpt_arr['main']['tabs'][0]['active'] = true;
$wtgcsv_mpt_arr['main']['tabs'][1]['slug'] = 'tab1_main';
$wtgcsv_mpt_arr['main']['tabs'][1]['label'] = 'Updates';
$wtgcsv_mpt_arr['main']['tabs'][1]['name'] = 'updates'; 
$wtgcsv_mpt_arr['main']['tabs'][1]['helpurl'] = 'http://www.importcsv.eu/'; 
$wtgcsv_mpt_arr['main']['tabs'][1]['allowhide'] = false;
$wtgcsv_mpt_arr['main']['tabs'][1]['display'] = wtgcsv_page_show_hide();
// main sub page 1 tab 3
$wtgcsv_mpt_arr['main']['tabs'][2]['active'] = true;
$wtgcsv_mpt_arr['main']['tabs'][2]['slug'] = 'tab2_main';
$wtgcsv_mpt_arr['main']['tabs'][2]['label'] = 'Quick Start';
$wtgcsv_mpt_arr['main']['tabs'][2]['name'] = 'quickstart'; 
$wtgcsv_mpt_arr['main']['tabs'][2]['helpurl'] = 'http://www.importcsv.eu/'; 
$wtgcsv_mpt_arr['main']['tabs'][2]['allowhide'] = false;
$wtgcsv_mpt_arr['main']['tabs'][2]['display'] = wtgcsv_page_show_hide(2);
// main sub page 1 tab 4
$wtgcsv_mpt_arr['main']['tabs'][3]['active'] = true;
$wtgcsv_mpt_arr['main']['tabs'][3]['slug'] = 'tab3_main';
$wtgcsv_mpt_arr['main']['tabs'][3]['label'] = 'About';
$wtgcsv_mpt_arr['main']['tabs'][3]['name'] = 'about'; 
$wtgcsv_mpt_arr['main']['tabs'][3]['helpurl'] = 'http://www.importcsv.eu/'; 
$wtgcsv_mpt_arr['main']['tabs'][3]['allowhide'] = false;
$wtgcsv_mpt_arr['main']['tabs'][3]['display'] = wtgcsv_page_show_hide(2);

// settings page
$wtgcsv_mpt_arr['settings']['active'] = true;
$wtgcsv_mpt_arr['settings']['slug'] = WTG_CSV_ABB . "settings";
$wtgcsv_mpt_arr['settings']['menu'] = "Plugin Settings";
$wtgcsv_mpt_arr['settings']['role'] = 'activate_plugins';
$wtgcsv_mpt_arr['settings']['title'] = WTG_CSV_PLUGINTITLE.' Settings';
$wtgcsv_mpt_arr['settings']['name'] = 'settings'; 
$wtgcsv_mpt_arr['settings']['icon'] = 'options-general';
$wtgcsv_mpt_arr['settings']['pagehelp'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['settings']['headers'] = false;
$wtgcsv_mpt_arr['settings']['vertical'] = false;
$wtgcsv_mpt_arr['settings']['statusicons'] = false;    
// settings sub page 1 tab 1
$wtgcsv_mpt_arr['settings']['tabs'][0]['active'] = true;
$wtgcsv_mpt_arr['settings']['tabs'][0]['slug'] = 'tab0_settings';
$wtgcsv_mpt_arr['settings']['tabs'][0]['label'] = 'General Settings';
$wtgcsv_mpt_arr['settings']['tabs'][0]['name'] = 'generalsettings';
$wtgcsv_mpt_arr['settings']['tabs'][0]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['settings']['tabs'][0]['allowhide'] = false;
$wtgcsv_mpt_arr['settings']['tabs'][0]['display'] = wtgcsv_page_show_hide();
// settings sub page 1 tab 2
$wtgcsv_mpt_arr['settings']['tabs'][1]['active'] = true;
$wtgcsv_mpt_arr['settings']['tabs'][1]['slug'] = 'tab1_settings';
$wtgcsv_mpt_arr['settings']['tabs'][1]['label'] = 'Interface Settings';
$wtgcsv_mpt_arr['settings']['tabs'][1]['name'] = 'interfacesettings';
$wtgcsv_mpt_arr['settings']['tabs'][1]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['settings']['tabs'][1]['allowhide'] = false;
$wtgcsv_mpt_arr['settings']['tabs'][1]['display'] = wtgcsv_page_show_hide(); 
// settings sub page 1 tab 3
$wtgcsv_mpt_arr['settings']['tabs'][2]['active'] = true;
$wtgcsv_mpt_arr['settings']['tabs'][2]['slug'] = 'tab2_settings';
$wtgcsv_mpt_arr['settings']['tabs'][2]['label'] = 'Easy Configuration Questions';
$wtgcsv_mpt_arr['settings']['tabs'][2]['name'] = 'easyconfigurationquestions';
$wtgcsv_mpt_arr['settings']['tabs'][2]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['settings']['tabs'][2]['allowhide'] = true; 
$wtgcsv_mpt_arr['settings']['tabs'][2]['display'] = wtgcsv_page_show_hide();

// install page
$wtgcsv_mpt_arr['install']['active'] = true;
$wtgcsv_mpt_arr['install']['slug'] = WTG_CSV_ABB . "install";
$wtgcsv_mpt_arr['install']['menu'] = WTG_CSV_PLUGINTITLE." Install";
$wtgcsv_mpt_arr['install']['role'] = 'activate_plugins';
$wtgcsv_mpt_arr['install']['title'] = WTG_CSV_PLUGINTITLE.' Install';
$wtgcsv_mpt_arr['install']['name'] = 'install';
$wtgcsv_mpt_arr['install']['icon'] = 'install';
$wtgcsv_mpt_arr['install']['pagehelp'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['install']['headers'] = false;
$wtgcsv_mpt_arr['install']['vertical'] = false;
$wtgcsv_mpt_arr['install']['statusicons'] = false;  
// install sub page 1 tab 1
$wtgcsv_mpt_arr['install']['tabs'][0]['active'] = true;
$wtgcsv_mpt_arr['install']['tabs'][0]['slug'] = 'tab0_install';
$wtgcsv_mpt_arr['install']['tabs'][0]['label'] = 'Install Actions';
$wtgcsv_mpt_arr['install']['tabs'][0]['name'] = 'installactions';
$wtgcsv_mpt_arr['install']['tabs'][0]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['install']['tabs'][0]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$wtgcsv_mpt_arr['install']['tabs'][0]['display'] = wtgcsv_page_show_hide(); 
// install sub page 1 tab 2
$wtgcsv_mpt_arr['install']['tabs'][1]['active'] = true;
$wtgcsv_mpt_arr['install']['tabs'][1]['slug'] = 'tab1_install';
$wtgcsv_mpt_arr['install']['tabs'][1]['label'] = 'Install History';
$wtgcsv_mpt_arr['install']['tabs'][1]['name'] = 'installhistory';
$wtgcsv_mpt_arr['install']['tabs'][1]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['install']['tabs'][1]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$wtgcsv_mpt_arr['install']['tabs'][1]['display'] = wtgcsv_page_show_hide();  
// install sub page 1 tab 3
$wtgcsv_mpt_arr['install']['tabs'][2]['active'] = true;
$wtgcsv_mpt_arr['install']['tabs'][2]['slug'] = 'tab2_install';
$wtgcsv_mpt_arr['install']['tabs'][2]['label'] = 'Install Status';
$wtgcsv_mpt_arr['install']['tabs'][2]['name'] = 'installstatus';
$wtgcsv_mpt_arr['install']['tabs'][2]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['install']['tabs'][2]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$wtgcsv_mpt_arr['install']['tabs'][2]['display'] = wtgcsv_page_show_hide();   
// install sub page 1 tab 4
$wtgcsv_mpt_arr['install']['tabs'][3]['active'] = true;
$wtgcsv_mpt_arr['install']['tabs'][3]['slug'] = 'tab3_install';
$wtgcsv_mpt_arr['install']['tabs'][3]['label'] = 'Your Server Status';
$wtgcsv_mpt_arr['install']['tabs'][3]['name'] = 'yourserverstatus';
$wtgcsv_mpt_arr['install']['tabs'][3]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['install']['tabs'][3]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$wtgcsv_mpt_arr['install']['tabs'][3]['display'] = wtgcsv_page_show_hide();   
// install sub page 1 tab 5
$wtgcsv_mpt_arr['install']['tabs'][4]['active'] = true;
$wtgcsv_mpt_arr['install']['tabs'][4]['slug'] = 'tab4_install';
$wtgcsv_mpt_arr['install']['tabs'][4]['label'] = 'Activation Controls';
$wtgcsv_mpt_arr['install']['tabs'][4]['name'] = 'activationcontrols';
$wtgcsv_mpt_arr['install']['tabs'][4]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['install']['tabs'][4]['allowhide'] = false  ;// is tab screen allowed to be hidden (boolean) 
$wtgcsv_mpt_arr['install']['tabs'][4]['display'] = wtgcsv_page_show_hide();
// install sub page 1 tab 6
$wtgcsv_mpt_arr['install']['tabs'][5]['active'] = true;
$wtgcsv_mpt_arr['install']['tabs'][5]['slug'] = 'tab5_install';
$wtgcsv_mpt_arr['install']['tabs'][5]['label'] = 'Files Status';
$wtgcsv_mpt_arr['install']['tabs'][5]['name'] = 'filesstatus';
$wtgcsv_mpt_arr['install']['tabs'][5]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['install']['tabs'][5]['allowhide'] = false  ;// is tab screen allowed to be hidden (boolean) 
$wtgcsv_mpt_arr['install']['tabs'][5]['display'] = wtgcsv_page_show_hide(); 


/**************** Varied Sub Pages Begin Here *****************/

######################################################
#                                                    #
#                         DATA                       #
#                                                    #
######################################################
$wtgcsv_mpt_arr['data']['active'] = true;
$wtgcsv_mpt_arr['data']['slug'] =  "wtgcsv_yourdata";
$wtgcsv_mpt_arr['data']['menu'] = "Manage Data";
$wtgcsv_mpt_arr['data']['name'] = "yourdata";
$wtgcsv_mpt_arr['data']['role'] = 'administrator';
$wtgcsv_mpt_arr['data']['title'] = 'Current Job: ';
$wtgcsv_mpt_arr['data']['icon'] = 'options-general';
$wtgcsv_mpt_arr['data']['pagehelp'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['headers'] = false;
$wtgcsv_mpt_arr['data']['vertical'] = false;
$wtgcsv_mpt_arr['data']['statusicons'] = true;     
// 1. Data sub page 1 tab 1
$wtgcsv_mpt_arr['data']['tabs'][0]['active'] = true;
$wtgcsv_mpt_arr['data']['tabs'][0]['slug'] = 'tab0_pagedata';
$wtgcsv_mpt_arr['data']['tabs'][0]['label'] = 'Start';
$wtgcsv_mpt_arr['data']['tabs'][0]['name'] = 'start';
$wtgcsv_mpt_arr['data']['tabs'][0]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['tabs'][0]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$wtgcsv_mpt_arr['data']['tabs'][0]['display'] = wtgcsv_page_show_hide(); 
// 1. Data sub page 1 tab 2
$wtgcsv_mpt_arr['data']['tabs'][1]['active'] = true;
$wtgcsv_mpt_arr['data']['tabs'][1]['slug'] = 'tab1_pagedata';
$wtgcsv_mpt_arr['data']['tabs'][1]['label'] = 'Import Jobs';
$wtgcsv_mpt_arr['data']['tabs'][1]['name'] = 'dataimport';
$wtgcsv_mpt_arr['data']['tabs'][1]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['tabs'][1]['allowhide'] = true;
$wtgcsv_mpt_arr['data']['tabs'][1]['display'] = wtgcsv_page_show_hide(); 
// 1. Data sub page 1 tab 3
$wtgcsv_mpt_arr['data']['tabs'][2]['active'] = true;
$wtgcsv_mpt_arr['data']['tabs'][2]['slug'] = 'tab2_pagedata';
$wtgcsv_mpt_arr['data']['tabs'][2]['label'] = 'Export Tools';
$wtgcsv_mpt_arr['data']['tabs'][2]['name'] = 'dataexport';
$wtgcsv_mpt_arr['data']['tabs'][2]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['tabs'][2]['allowhide'] = true;
$wtgcsv_mpt_arr['data']['tabs'][2]['display'] = wtgcsv_page_show_hide(2);
// 1. Data sub page 1 tab 4
$wtgcsv_mpt_arr['data']['tabs'][3]['active'] = true;
$wtgcsv_mpt_arr['data']['tabs'][3]['slug'] = 'tab3_pagedata';
$wtgcsv_mpt_arr['data']['tabs'][3]['label'] = 'Created Tables';
$wtgcsv_mpt_arr['data']['tabs'][3]['name'] = 'createdtables';
$wtgcsv_mpt_arr['data']['tabs'][3]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['tabs'][3]['allowhide'] = true;
$wtgcsv_mpt_arr['data']['tabs'][3]['display'] = wtgcsv_page_show_hide();
// 1. Data sub page 1 tab 5
$wtgcsv_mpt_arr['data']['tabs'][4]['active'] = true;
$wtgcsv_mpt_arr['data']['tabs'][4]['slug'] = 'tab4_pagedata';
$wtgcsv_mpt_arr['data']['tabs'][4]['label'] = 'Data Rules';
$wtgcsv_mpt_arr['data']['tabs'][4]['name'] = 'datarules';
$wtgcsv_mpt_arr['data']['tabs'][4]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['tabs'][4]['allowhide'] = true;
$wtgcsv_mpt_arr['data']['tabs'][4]['display'] = wtgcsv_page_show_hide(2);
// 1. Data sub page 1 tab 6
$wtgcsv_mpt_arr['data']['tabs'][5]['active'] = true;
$wtgcsv_mpt_arr['data']['tabs'][5]['slug'] = 'tab5_pagedata';
$wtgcsv_mpt_arr['data']['tabs'][5]['label'] = 'History';
$wtgcsv_mpt_arr['data']['tabs'][5]['name'] = 'datahistory';
$wtgcsv_mpt_arr['data']['tabs'][5]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['tabs'][5]['allowhide'] = true;
$wtgcsv_mpt_arr['data']['tabs'][5]['display'] = wtgcsv_page_show_hide(2);
// 1. Data sub page 1 tab 7
$wtgcsv_mpt_arr['data']['tabs'][6]['active'] = true;
$wtgcsv_mpt_arr['data']['tabs'][6]['slug'] = 'tab6_pagedata';
$wtgcsv_mpt_arr['data']['tabs'][6]['label'] = 'Data Sources';
$wtgcsv_mpt_arr['data']['tabs'][6]['name'] = 'datasources';
$wtgcsv_mpt_arr['data']['tabs'][6]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['tabs'][6]['allowhide'] = true;
$wtgcsv_mpt_arr['data']['tabs'][6]['display'] = wtgcsv_page_show_hide(2);
// 1. Data sub page 1 tab 8 TODO: LOWPRIORITY, search tools for the data management side of things
$wtgcsv_mpt_arr['data']['tabs'][7]['active'] = false;
$wtgcsv_mpt_arr['data']['tabs'][7]['slug'] = 'tab7_pagedata';
$wtgcsv_mpt_arr['data']['tabs'][7]['label'] = 'Search';
$wtgcsv_mpt_arr['data']['tabs'][7]['name'] = 'datasearch';
$wtgcsv_mpt_arr['data']['tabs'][7]['helpurl'] = 'http://www.importcsv.eu/';
$wtgcsv_mpt_arr['data']['tabs'][7]['allowhide'] = true;
$wtgcsv_mpt_arr['data']['tabs'][7]['display'] = wtgcsv_page_show_hide(2);
### TODO:LOWPRIORITY, add a page that tests all CSV files and lists their status and profile 
### if however it effects loading, could do it with the files in use or latest files uploaded
### full edition only 
?>
