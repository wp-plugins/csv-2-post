<?php
####################################################################
####                                                            ####
####           TABS NAVIGATION ARRAY ($csv2post_mpt_arr)          ####
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

global $csv2post_homeslug;
$csv2post_mpt_arr = array();
// main page
$csv2post_mpt_arr['main']['active'] = true;// boolean -is this page in use
$csv2post_mpt_arr['main']['slug'] = $csv2post_homeslug;// home page slug set in main file
$csv2post_mpt_arr['main']['menu'] = WTG_C2P_PLUGINTITLE;// plugin dashboard page title
$csv2post_mpt_arr['main']['name'] = "mainpage";// name of page (slug) and unique
$csv2post_mpt_arr['main']['role'] = 'activate_plugins';// minimum required role in order to VIEW the page
$csv2post_mpt_arr['main']['title'] = 'CSV 2 POST';// page title seen once page is opened
$csv2post_mpt_arr['main']['pagehelp'] = 'http://www.csv2post.com';// url to the help content on plugin site for this page
$csv2post_mpt_arr['main']['headers'] = false;// boolean - display a content area above selected tabs i.e. introductions or status
$csv2post_mpt_arr['main']['vertical'] = false;// boolean - is the menu vertical rather than horizontal
$csv2post_mpt_arr['main']['statusicons'] = false;// boolean - instead of related icons we use cross & tick etc indicating completion or not
// main sub page 1 tab 1
$csv2post_mpt_arr['main']['tabs'][0]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][0]['slug'] = 'tab0_main';
$csv2post_mpt_arr['main']['tabs'][0]['label'] = 'Screens';
$csv2post_mpt_arr['main']['tabs'][0]['name'] = 'screens';     
$csv2post_mpt_arr['main']['tabs'][0]['helpurl'] = 'http://www.csv2post.com/'; 
$csv2post_mpt_arr['main']['tabs'][0]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['main']['tabs'][0]['display'] = csv2post_page_show_hide(); 
// main sub page 1 tab 2
$csv2post_mpt_arr['main']['tabs'][1]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][1]['slug'] = 'tab1_main';
$csv2post_mpt_arr['main']['tabs'][1]['label'] = 'Updates';
$csv2post_mpt_arr['main']['tabs'][1]['name'] = 'updates'; 
$csv2post_mpt_arr['main']['tabs'][1]['helpurl'] = 'http://www.csv2post.com/'; 
$csv2post_mpt_arr['main']['tabs'][1]['allowhide'] = false;
$csv2post_mpt_arr['main']['tabs'][1]['display'] = csv2post_page_show_hide();
// main sub page 1 tab 3
$csv2post_mpt_arr['main']['tabs'][2]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][2]['slug'] = 'tab2_main';
$csv2post_mpt_arr['main']['tabs'][2]['label'] = 'Quick Start';
$csv2post_mpt_arr['main']['tabs'][2]['name'] = 'quickstart'; 
$csv2post_mpt_arr['main']['tabs'][2]['helpurl'] = 'http://www.csv2post.com/'; 
$csv2post_mpt_arr['main']['tabs'][2]['allowhide'] = false;
$csv2post_mpt_arr['main']['tabs'][2]['display'] = csv2post_page_show_hide();
// main sub page 1 tab 4
$csv2post_mpt_arr['main']['tabs'][3]['active'] = true;
$csv2post_mpt_arr['main']['tabs'][3]['slug'] = 'tab3_main';
$csv2post_mpt_arr['main']['tabs'][3]['label'] = 'About';
$csv2post_mpt_arr['main']['tabs'][3]['name'] = 'about'; 
$csv2post_mpt_arr['main']['tabs'][3]['helpurl'] = 'http://www.csv2post.com/'; 
$csv2post_mpt_arr['main']['tabs'][3]['allowhide'] = false;
$csv2post_mpt_arr['main']['tabs'][3]['display'] = csv2post_page_show_hide();

// settings page
$csv2post_mpt_arr['settings']['active'] = true;
$csv2post_mpt_arr['settings']['slug'] = WTG_C2P_ABB . "settings";
$csv2post_mpt_arr['settings']['menu'] = "Plugin Settings";
$csv2post_mpt_arr['settings']['role'] = 'activate_plugins';
$csv2post_mpt_arr['settings']['title'] = WTG_C2P_PLUGINTITLE.' Settings';
$csv2post_mpt_arr['settings']['name'] = 'settings'; 
$csv2post_mpt_arr['settings']['icon'] = 'options-general';
$csv2post_mpt_arr['settings']['pagehelp'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['settings']['headers'] = false;
$csv2post_mpt_arr['settings']['vertical'] = false;
$csv2post_mpt_arr['settings']['statusicons'] = false;    
// settings sub page 1 tab 1
$csv2post_mpt_arr['settings']['tabs'][0]['active'] = true;
$csv2post_mpt_arr['settings']['tabs'][0]['slug'] = 'tab0_settings';
$csv2post_mpt_arr['settings']['tabs'][0]['label'] = 'General Settings';
$csv2post_mpt_arr['settings']['tabs'][0]['name'] = 'generalsettings';
$csv2post_mpt_arr['settings']['tabs'][0]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['settings']['tabs'][0]['allowhide'] = false;
$csv2post_mpt_arr['settings']['tabs'][0]['display'] = csv2post_page_show_hide();
// settings sub page 1 tab 2
$csv2post_mpt_arr['settings']['tabs'][1]['active'] = true;
$csv2post_mpt_arr['settings']['tabs'][1]['slug'] = 'tab1_settings';
$csv2post_mpt_arr['settings']['tabs'][1]['label'] = 'Interface Settings';
$csv2post_mpt_arr['settings']['tabs'][1]['name'] = 'interfacesettings';
$csv2post_mpt_arr['settings']['tabs'][1]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['settings']['tabs'][1]['allowhide'] = false;
$csv2post_mpt_arr['settings']['tabs'][1]['display'] = csv2post_page_show_hide(); 
// settings sub page 1 tab 3
$csv2post_mpt_arr['settings']['tabs'][2]['active'] = true;
$csv2post_mpt_arr['settings']['tabs'][2]['slug'] = 'tab2_settings';
$csv2post_mpt_arr['settings']['tabs'][2]['label'] = 'Easy Configuration Questions';
$csv2post_mpt_arr['settings']['tabs'][2]['name'] = 'easyconfigurationquestions';
$csv2post_mpt_arr['settings']['tabs'][2]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['settings']['tabs'][2]['allowhide'] = true; 
$csv2post_mpt_arr['settings']['tabs'][2]['display'] = csv2post_page_show_hide();

// install page
$csv2post_mpt_arr['install']['active'] = true;
$csv2post_mpt_arr['install']['slug'] = WTG_C2P_ABB . "install";
$csv2post_mpt_arr['install']['menu'] = WTG_C2P_PLUGINTITLE." Install";
$csv2post_mpt_arr['install']['role'] = 'activate_plugins';
$csv2post_mpt_arr['install']['title'] = WTG_C2P_PLUGINTITLE.' Install';
$csv2post_mpt_arr['install']['name'] = 'install';
$csv2post_mpt_arr['install']['icon'] = 'install';
$csv2post_mpt_arr['install']['pagehelp'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['install']['headers'] = false;
$csv2post_mpt_arr['install']['vertical'] = false;
$csv2post_mpt_arr['install']['statusicons'] = false;  
// install sub page 1 tab 1
$csv2post_mpt_arr['install']['tabs'][0]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][0]['slug'] = 'tab0_install';
$csv2post_mpt_arr['install']['tabs'][0]['label'] = 'Install Actions';
$csv2post_mpt_arr['install']['tabs'][0]['name'] = 'installactions';
$csv2post_mpt_arr['install']['tabs'][0]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['install']['tabs'][0]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['install']['tabs'][0]['display'] = csv2post_page_show_hide(); 
// install sub page 1 tab 2
$csv2post_mpt_arr['install']['tabs'][1]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][1]['slug'] = 'tab1_install';
$csv2post_mpt_arr['install']['tabs'][1]['label'] = 'Install History';
$csv2post_mpt_arr['install']['tabs'][1]['name'] = 'installhistory';
$csv2post_mpt_arr['install']['tabs'][1]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['install']['tabs'][1]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['install']['tabs'][1]['display'] = csv2post_page_show_hide();  
// install sub page 1 tab 3
$csv2post_mpt_arr['install']['tabs'][2]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][2]['slug'] = 'tab2_install';
$csv2post_mpt_arr['install']['tabs'][2]['label'] = 'Install Status';
$csv2post_mpt_arr['install']['tabs'][2]['name'] = 'installstatus';
$csv2post_mpt_arr['install']['tabs'][2]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['install']['tabs'][2]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['install']['tabs'][2]['display'] = csv2post_page_show_hide();   
// install sub page 1 tab 4
$csv2post_mpt_arr['install']['tabs'][3]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][3]['slug'] = 'tab3_install';
$csv2post_mpt_arr['install']['tabs'][3]['label'] = 'Your Server Status';
$csv2post_mpt_arr['install']['tabs'][3]['name'] = 'yourserverstatus';
$csv2post_mpt_arr['install']['tabs'][3]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['install']['tabs'][3]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['install']['tabs'][3]['display'] = csv2post_page_show_hide();   
// install sub page 1 tab 5
$csv2post_mpt_arr['install']['tabs'][4]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][4]['slug'] = 'tab4_install';
$csv2post_mpt_arr['install']['tabs'][4]['label'] = 'Activation Controls';
$csv2post_mpt_arr['install']['tabs'][4]['name'] = 'activationcontrols';
$csv2post_mpt_arr['install']['tabs'][4]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['install']['tabs'][4]['allowhide'] = false  ;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['install']['tabs'][4]['display'] = csv2post_page_show_hide();
// install sub page 1 tab 6
$csv2post_mpt_arr['install']['tabs'][5]['active'] = true;
$csv2post_mpt_arr['install']['tabs'][5]['slug'] = 'tab5_install';
$csv2post_mpt_arr['install']['tabs'][5]['label'] = 'Files Status';
$csv2post_mpt_arr['install']['tabs'][5]['name'] = 'filesstatus';
$csv2post_mpt_arr['install']['tabs'][5]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['install']['tabs'][5]['allowhide'] = false  ;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['install']['tabs'][5]['display'] = csv2post_page_show_hide(1); 
  
// more page - includes a sub-menu for offering far more pages without adding to plugn menu
$csv2post_mpt_arr['more']['active'] = true;
$csv2post_mpt_arr['more']['slug'] = "csv2post_more";
$csv2post_mpt_arr['more']['menu'] = "More";
$csv2post_mpt_arr['more']['role'] = 'activate_plugins';
$csv2post_mpt_arr['more']['title'] = 'More';
$csv2post_mpt_arr['more']['name'] = 'more'; 
$csv2post_mpt_arr['more']['icon'] = 'install';
$csv2post_mpt_arr['more']['pagehelp'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['headers'] = false;
$csv2post_mpt_arr['more']['vertical'] = false;
$csv2post_mpt_arr['more']['statusicons'] = false;      
// more sub page 1 tab 1
$csv2post_mpt_arr['more']['tabs'][0]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][0]['slug'] = 'tab0_more';
$csv2post_mpt_arr['more']['tabs'][0]['label'] = 'Support';
$csv2post_mpt_arr['more']['tabs'][0]['name'] = 'support';
$csv2post_mpt_arr['more']['tabs'][0]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][0]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][0]['display'] = csv2post_page_show_hide();   
// more sub page 1 tab 2
$csv2post_mpt_arr['more']['tabs'][1]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][1]['slug'] = 'tab1_more';
$csv2post_mpt_arr['more']['tabs'][1]['label'] = 'Community';
$csv2post_mpt_arr['more']['tabs'][1]['name'] = 'community';
$csv2post_mpt_arr['more']['tabs'][1]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][1]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][1]['display'] = csv2post_page_show_hide();  
// more sub page 1 tab 3
$csv2post_mpt_arr['more']['tabs'][2]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][2]['slug'] = 'tab2_more';
$csv2post_mpt_arr['more']['tabs'][2]['label'] = 'Downloads';
$csv2post_mpt_arr['more']['tabs'][2]['name'] = 'downloads';
$csv2post_mpt_arr['more']['tabs'][2]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][2]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][2]['display'] = csv2post_page_show_hide();  
// more sub page 1 tab 4
$csv2post_mpt_arr['more']['tabs'][3]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][3]['slug'] = 'tab3_more';
$csv2post_mpt_arr['more']['tabs'][3]['label'] = 'Affiliates';// Affiliate, payment history, traffic stats, display banners
$csv2post_mpt_arr['more']['tabs'][3]['name'] = 'affiliates';
$csv2post_mpt_arr['more']['tabs'][3]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][3]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][3]['display'] = csv2post_page_show_hide(); 
// more sub page 1 tab 5
$csv2post_mpt_arr['more']['tabs'][4]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][4]['slug'] = 'tab4_more';
$csv2post_mpt_arr['more']['tabs'][4]['label'] = 'Development';// RSS feed link, blog entries directly, coming soon (top feature coming next)
$csv2post_mpt_arr['more']['tabs'][4]['name'] = 'development';
$csv2post_mpt_arr['more']['tabs'][4]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][4]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][4]['display'] = csv2post_page_show_hide();
// more sub page 1 tab 6
$csv2post_mpt_arr['more']['tabs'][5]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][5]['slug'] = 'tab5_more';
$csv2post_mpt_arr['more']['tabs'][5]['label'] = 'Testing';// test blogs, beta tester list, test forum discussion, RSS for testers and developers, short TO DO list (not whole list)
$csv2post_mpt_arr['more']['tabs'][5]['name'] = 'testing';
$csv2post_mpt_arr['more']['tabs'][5]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][5]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][5]['display'] = csv2post_page_show_hide(); 
// more sub page 1 tab 7
$csv2post_mpt_arr['more']['tabs'][6]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][6]['slug'] = 'tab6_more';
$csv2post_mpt_arr['more']['tabs'][6]['label'] = 'Offers';// display a range of main offers, hosting packages with premium plugin purchase, free installs, setup etc
$csv2post_mpt_arr['more']['tabs'][6]['name'] = 'offers';
$csv2post_mpt_arr['more']['tabs'][6]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][6]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][6]['display'] = csv2post_page_show_hide(); 
// more sub page 1 tab 8
$csv2post_mpt_arr['more']['tabs'][7]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][7]['slug'] = 'tab7_more';
$csv2post_mpt_arr['more']['tabs'][7]['label'] = 'My Tickets';// users submitted tickets, if API can access
$csv2post_mpt_arr['more']['tabs'][7]['name'] = 'mytickets';
$csv2post_mpt_arr['more']['tabs'][7]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][7]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][7]['display'] = csv2post_page_show_hide(); 
// more sub page 1 tab 9
$csv2post_mpt_arr['more']['tabs'][8]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][8]['slug'] = 'tab8_more';
$csv2post_mpt_arr['more']['tabs'][8]['label'] = 'My Account';// purchased plugins, users account, transactions, loyalty points, stored API key, special permissions and access indicators etc
$csv2post_mpt_arr['more']['tabs'][8]['name'] = 'myaccount';
$csv2post_mpt_arr['more']['tabs'][8]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][8]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['more']['tabs'][8]['display'] = csv2post_page_show_hide(); 
// more sub page 1 tab 10
$csv2post_mpt_arr['more']['tabs'][9]['active'] = true;
$csv2post_mpt_arr['more']['tabs'][9]['slug'] = 'tab9_more';
$csv2post_mpt_arr['more']['tabs'][9]['label'] = 'Contact';// advanced contact form, creates ticket, forum post and sends email
$csv2post_mpt_arr['more']['tabs'][9]['name'] = 'contact';
$csv2post_mpt_arr['more']['tabs'][9]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['more']['tabs'][9]['allowhide'] = false;// is tab screen allowed to be hidden (boolean) 
$csv2post_mpt_arr['more']['tabs'][9]['display'] = csv2post_page_show_hide(1);
/**************** Varied Sub Pages Begin Here *****************/

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
$csv2post_mpt_arr['data']['pagehelp'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['headers'] = false;
$csv2post_mpt_arr['data']['vertical'] = false;
$csv2post_mpt_arr['data']['statusicons'] = true;     
// 1. Data sub page 1 tab 1
$csv2post_mpt_arr['data']['tabs'][0]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][0]['slug'] = 'tab0_pagedata';
$csv2post_mpt_arr['data']['tabs'][0]['label'] = 'Start';
$csv2post_mpt_arr['data']['tabs'][0]['name'] = 'start';
$csv2post_mpt_arr['data']['tabs'][0]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['tabs'][0]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['data']['tabs'][0]['display'] = csv2post_page_show_hide(); 
// 1. Data sub page 1 tab 2
$csv2post_mpt_arr['data']['tabs'][1]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][1]['slug'] = 'tab1_pagedata';
$csv2post_mpt_arr['data']['tabs'][1]['label'] = 'Import Jobs';
$csv2post_mpt_arr['data']['tabs'][1]['name'] = 'dataimport';
$csv2post_mpt_arr['data']['tabs'][1]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['tabs'][1]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][1]['display'] = csv2post_page_show_hide(); 
// 1. Data sub page 1 tab 3
$csv2post_mpt_arr['data']['tabs'][2]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][2]['slug'] = 'tab2_pagedata';
$csv2post_mpt_arr['data']['tabs'][2]['label'] = 'Export Tools';
$csv2post_mpt_arr['data']['tabs'][2]['name'] = 'dataexport';
$csv2post_mpt_arr['data']['tabs'][2]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['tabs'][2]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][2]['display'] = csv2post_page_show_hide();
// 1. Data sub page 1 tab 4
$csv2post_mpt_arr['data']['tabs'][3]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][3]['slug'] = 'tab3_pagedata';
$csv2post_mpt_arr['data']['tabs'][3]['label'] = 'Created Tables';
$csv2post_mpt_arr['data']['tabs'][3]['name'] = 'createdtables';
$csv2post_mpt_arr['data']['tabs'][3]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['tabs'][3]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][3]['display'] = csv2post_page_show_hide();
// 1. Data sub page 1 tab 5
$csv2post_mpt_arr['data']['tabs'][4]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][4]['slug'] = 'tab4_pagedata';
$csv2post_mpt_arr['data']['tabs'][4]['label'] = 'Data Rules';
$csv2post_mpt_arr['data']['tabs'][4]['name'] = 'datarules';
$csv2post_mpt_arr['data']['tabs'][4]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['tabs'][4]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][4]['display'] = csv2post_page_show_hide(2);
// 1. Data sub page 1 tab 6
$csv2post_mpt_arr['data']['tabs'][5]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][5]['slug'] = 'tab5_pagedata';
$csv2post_mpt_arr['data']['tabs'][5]['label'] = 'History';
$csv2post_mpt_arr['data']['tabs'][5]['name'] = 'datahistory';
$csv2post_mpt_arr['data']['tabs'][5]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['tabs'][5]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][5]['display'] = csv2post_page_show_hide(2);
// 1. Data sub page 1 tab 7
$csv2post_mpt_arr['data']['tabs'][6]['active'] = true;
$csv2post_mpt_arr['data']['tabs'][6]['slug'] = 'tab6_pagedata';
$csv2post_mpt_arr['data']['tabs'][6]['label'] = 'Data Sources';
$csv2post_mpt_arr['data']['tabs'][6]['name'] = 'datasources';
$csv2post_mpt_arr['data']['tabs'][6]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['tabs'][6]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][6]['display'] = csv2post_page_show_hide(2);
// 1. Data sub page 1 tab 8 TODO: LOWPRIORITY, search tools for the data management side of things
$csv2post_mpt_arr['data']['tabs'][7]['active'] = false;
$csv2post_mpt_arr['data']['tabs'][7]['slug'] = 'tab7_pagedata';
$csv2post_mpt_arr['data']['tabs'][7]['label'] = 'Search';
$csv2post_mpt_arr['data']['tabs'][7]['name'] = 'datasearch';
$csv2post_mpt_arr['data']['tabs'][7]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['data']['tabs'][7]['allowhide'] = true;
$csv2post_mpt_arr['data']['tabs'][7]['display'] = csv2post_page_show_hide(2);
### TODO:LOWPRIORITY, add a page that tests all CSV files and lists their status and profile 
### if however it effects loading, could do it with the files in use or latest files uploaded
### full edition only 

######################################################
#                                                    #
#                      YOUR PROJECTS                 #
#                                                    #
######################################################
$csv2post_mpt_arr['projects']['active'] = true;
$csv2post_mpt_arr['projects']['slug'] =  "csv2post_yourprojects";
$csv2post_mpt_arr['projects']['menu'] = "2. Your Projects";
$csv2post_mpt_arr['projects']['name'] = "yourprojects";
$csv2post_mpt_arr['projects']['role'] = 'administrator';
$csv2post_mpt_arr['projects']['title'] = 'Current Project: ';
$csv2post_mpt_arr['projects']['icon'] = 'options-general';
$csv2post_mpt_arr['projects']['pagehelp'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['headers'] = false;
$csv2post_mpt_arr['projects']['vertical'] = false;
$csv2post_mpt_arr['projects']['statusicons'] = true;     
// 2. Project sub page 1 tab 1
$csv2post_mpt_arr['projects']['tabs'][0]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][0]['slug'] = 'tab0_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][0]['label'] = 'Projects';
$csv2post_mpt_arr['projects']['tabs'][0]['name'] = 'projects';
$csv2post_mpt_arr['projects']['tabs'][0]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][0]['allowhide'] = false;
$csv2post_mpt_arr['projects']['tabs'][0]['display'] = csv2post_page_show_hide(); 

// 2. Project sub page 1 tab 2
$csv2post_mpt_arr['projects']['tabs'][1]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][1]['slug'] = 'tab1_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][1]['label'] = 'Content';
$csv2post_mpt_arr['projects']['tabs'][1]['name'] = 'content';
$csv2post_mpt_arr['projects']['tabs'][1]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][1]['allowhide'] = true;
$csv2post_mpt_arr['projects']['tabs'][1]['display'] = csv2post_page_show_hide();

// 2. Project sub page 1 tab 3
$csv2post_mpt_arr['projects']['tabs'][2]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][2]['slug'] = 'tab2_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][2]['label'] = 'Titles';
$csv2post_mpt_arr['projects']['tabs'][2]['name'] = 'titles';
$csv2post_mpt_arr['projects']['tabs'][2]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][2]['allowhide'] = true;
$csv2post_mpt_arr['projects']['tabs'][2]['display'] = csv2post_page_show_hide();
// 2. Project sub page 1 tab 4
$csv2post_mpt_arr['projects']['tabs'][3]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][3]['slug'] = 'tab3_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][3]['label'] = 'SEO';
$csv2post_mpt_arr['projects']['tabs'][3]['name'] = 'seo';
$csv2post_mpt_arr['projects']['tabs'][3]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][3]['allowhide'] = true;
$csv2post_mpt_arr['projects']['tabs'][3]['display'] = csv2post_page_show_hide();
// 2. Project sub page 1 tab 5
$csv2post_mpt_arr['projects']['tabs'][4]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][4]['slug'] = 'tab4_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][4]['label'] = 'Post Types';
$csv2post_mpt_arr['projects']['tabs'][4]['name'] = 'posttypes';
$csv2post_mpt_arr['projects']['tabs'][4]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][4]['allowhide'] = true;
$csv2post_mpt_arr['projects']['tabs'][4]['display'] = csv2post_page_show_hide();
// 2. Project sub page 1 tab 6
$csv2post_mpt_arr['projects']['tabs'][5]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][5]['slug'] = 'tab5_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][5]['label'] = 'Post Dates';
$csv2post_mpt_arr['projects']['tabs'][5]['name'] = 'postdates';
$csv2post_mpt_arr['projects']['tabs'][5]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][5]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][5]['display'] = csv2post_page_show_hide();
// 2. Project sub page 1 tab 7
$csv2post_mpt_arr['projects']['tabs'][6]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][6]['slug'] = 'tab6_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][6]['label'] = 'Custom Fields';
$csv2post_mpt_arr['projects']['tabs'][6]['name'] = 'customfields';
$csv2post_mpt_arr['projects']['tabs'][6]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][6]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][6]['display'] = csv2post_page_show_hide();
// 2. Project sub page 1 tab 8
$csv2post_mpt_arr['projects']['tabs'][7]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][7]['slug'] = 'tab7_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][7]['label'] = 'Categories';
$csv2post_mpt_arr['projects']['tabs'][7]['name'] = 'categories';
$csv2post_mpt_arr['projects']['tabs'][7]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][7]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][7]['display'] = csv2post_page_show_hide(); 
// 2. Project sub page 1 tab 9
$csv2post_mpt_arr['projects']['tabs'][8]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][8]['slug'] = 'tab8_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][8]['label'] = 'Update Options';
$csv2post_mpt_arr['projects']['tabs'][8]['name'] = 'updateoptions';
$csv2post_mpt_arr['projects']['tabs'][8]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][8]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][8]['display'] = csv2post_page_show_hide(1);
// 2. Project sub page 1 tab 10
$csv2post_mpt_arr['projects']['tabs'][9]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][9]['slug'] = 'tab9_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][9]['label'] = 'Images';
$csv2post_mpt_arr['projects']['tabs'][9]['name'] = 'images';
$csv2post_mpt_arr['projects']['tabs'][9]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][9]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][9]['display'] = csv2post_page_show_hide(2);
// 2. Project sub page 1 tab 10
$csv2post_mpt_arr['projects']['tabs'][10]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][10]['slug'] = 'tab10_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][10]['label'] = 'URL Cloaking';
$csv2post_mpt_arr['projects']['tabs'][10]['name'] = 'urlcloaking';
$csv2post_mpt_arr['projects']['tabs'][10]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][10]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][10]['display'] = csv2post_page_show_hide(2);
// 2. Project sub page 1 tab 11
$csv2post_mpt_arr['projects']['tabs'][11]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][11]['slug'] = 'tab11_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][11]['label'] = 'Tags';
$csv2post_mpt_arr['projects']['tabs'][11]['name'] = 'tags';
$csv2post_mpt_arr['projects']['tabs'][11]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][11]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][11]['display'] = csv2post_page_show_hide();
// 2. Project sub page 1 tab 12
$csv2post_mpt_arr['projects']['tabs'][12]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][12]['slug'] = 'tab12_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][12]['label'] = 'Text Spinning';
$csv2post_mpt_arr['projects']['tabs'][12]['name'] = 'textspinning';
$csv2post_mpt_arr['projects']['tabs'][12]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][12]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][12]['display'] = csv2post_page_show_hide(1);
// 2. Project sub page 1 tab 13
$csv2post_mpt_arr['projects']['tabs'][13]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][13]['slug'] = 'tab13_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][13]['label'] = 'Project Data';
$csv2post_mpt_arr['projects']['tabs'][13]['name'] = 'projectdata';
$csv2post_mpt_arr['projects']['tabs'][13]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][13]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][13]['display'] = csv2post_page_show_hide();
// 2. Project sub page 1 tab 14
$csv2post_mpt_arr['projects']['tabs'][14]['active'] = true;
$csv2post_mpt_arr['projects']['tabs'][14]['slug'] = 'tab14_pageprojects';
$csv2post_mpt_arr['projects']['tabs'][14]['label'] = 'Authors';
$csv2post_mpt_arr['projects']['tabs'][14]['name'] = 'authors';
$csv2post_mpt_arr['projects']['tabs'][14]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['projects']['tabs'][14]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['projects']['tabs'][14]['display'] = csv2post_page_show_hide();

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
$csv2post_mpt_arr['creation']['pagehelp'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['creation']['headers'] = false;
$csv2post_mpt_arr['creation']['vertical'] = false;
$csv2post_mpt_arr['creation']['statusicons'] = true; 
// 3. Results sub page 1 tab 1
$csv2post_mpt_arr['creation']['tabs'][0]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][0]['slug'] = 'tab0_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][0]['label'] = 'Create Posts';
$csv2post_mpt_arr['creation']['tabs'][0]['name'] = 'selectables';
$csv2post_mpt_arr['creation']['tabs'][0]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['creation']['tabs'][0]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][0]['display'] = csv2post_page_show_hide();    
// 3. Results sub page 1 tab 2
$csv2post_mpt_arr['creation']['tabs'][1]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][1]['slug'] = 'tab1_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][1]['label'] = 'Schedule';
$csv2post_mpt_arr['creation']['tabs'][1]['name'] = 'schedule';
$csv2post_mpt_arr['creation']['tabs'][1]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['creation']['tabs'][1]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][1]['display'] = csv2post_page_show_hide(1); 
// 3. Results sub page 1 tab 3
$csv2post_mpt_arr['creation']['tabs'][2]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][2]['slug'] = 'tab2_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][2]['label'] = 'Update Posts';
$csv2post_mpt_arr['creation']['tabs'][2]['name'] = 'updateposts';
$csv2post_mpt_arr['creation']['tabs'][2]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['creation']['tabs'][2]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][2]['display'] = csv2post_page_show_hide(1);
// 3. Results sub page 1 tab 4
$csv2post_mpt_arr['creation']['tabs'][3]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][3]['slug'] = 'tab3_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][3]['label'] = 'Delete Posts';
$csv2post_mpt_arr['creation']['tabs'][3]['name'] = 'Delete Posts';
$csv2post_mpt_arr['creation']['tabs'][3]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['creation']['tabs'][3]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][3]['display'] = csv2post_page_show_hide(2);
// 3. Results sub page 1 tab 5
$csv2post_mpt_arr['creation']['tabs'][4]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][4]['slug'] = 'tab4_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][4]['label'] = 'View Posts';
$csv2post_mpt_arr['creation']['tabs'][4]['name'] = 'viewposts';
$csv2post_mpt_arr['creation']['tabs'][4]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['creation']['tabs'][4]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][4]['display'] = csv2post_page_show_hide(2);
// 3. Results sub page 1 tab 5
$csv2post_mpt_arr['creation']['tabs'][5]['active'] = true;
$csv2post_mpt_arr['creation']['tabs'][5]['slug'] = 'tab5_pagecreation';
$csv2post_mpt_arr['creation']['tabs'][5]['label'] = 'Create Categories';
$csv2post_mpt_arr['creation']['tabs'][5]['name'] = 'viewposts';
$csv2post_mpt_arr['creation']['tabs'][5]['helpurl'] = 'http://www.csv2post.com/';
$csv2post_mpt_arr['creation']['tabs'][5]['allowhide'] = true;// is tab screen allowed to be hidden (boolean)
$csv2post_mpt_arr['creation']['tabs'][5]['display'] = csv2post_page_show_hide(1);
        
?>
