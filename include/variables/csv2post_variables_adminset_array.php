<?php
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */

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

###############################################################
#                        SCHEDULE ARRAY                       #
###############################################################
global $csv2post_is_free;
if(isset($csv2post_is_free) && !$csv2post_is_free){
    
    // history
    $csv2post_adm_set['schedule']['schedule']['history']['lastreturnreason'] = 'None';
    $csv2post_adm_set['schedule']['history']['lasteventtime'] = time();
    $csv2post_adm_set['schedule']['history']['lasteventtype'] = 'None';
    $csv2post_adm_set['schedule']['history']['day_lastreset'] = time();
    $csv2post_adm_set['schedule']['history']['hour_lastreset'] = time();
    $csv2post_adm_set['schedule']['history']['hourcounter'] = 1;
    $csv2post_adm_set['schedule']['history']['daycounter'] = 1;
    $csv2post_adm_set['schedule']['history']['lasteventaction'] = 'None';
    // times/days
    $csv2post_adm_set['schedule']['days']['monday'] = true;
    $csv2post_adm_set['schedule']['days']['tuesday'] = true;
    $csv2post_adm_set['schedule']['days']['wednesday'] = true;
    $csv2post_adm_set['schedule']['days']['thursday'] = true;
    $csv2post_adm_set['schedule']['days']['friday'] = true;
    $csv2post_adm_set['schedule']['days']['saturday'] = true;
    $csv2post_adm_set['schedule']['days']['sunday'] = true;
    // times/hours
    $csv2post_adm_set['schedule']['hours'][0] = true;
    $csv2post_adm_set['schedule']['hours'][1] = true;
    $csv2post_adm_set['schedule']['hours'][2] = true;
    $csv2post_adm_set['schedule']['hours'][3] = true;
    $csv2post_adm_set['schedule']['hours'][4] = true;
    $csv2post_adm_set['schedule']['hours'][5] = true;
    $csv2post_adm_set['schedule']['hours'][6] = true;
    $csv2post_adm_set['schedule']['hours'][7] = true;
    $csv2post_adm_set['schedule']['hours'][8] = true;
    $csv2post_adm_set['schedule']['hours'][9] = true;
    $csv2post_adm_set['schedule']['hours'][10] = true;
    $csv2post_adm_set['schedule']['hours'][11] = true;
    $csv2post_adm_set['schedule']['hours'][12] = true;
    $csv2post_adm_set['schedule']['hours'][13] = true;
    $csv2post_adm_set['schedule']['hours'][14] = true;
    $csv2post_adm_set['schedule']['hours'][15] = true;
    $csv2post_adm_set['schedule']['hours'][16] = true;
    $csv2post_adm_set['schedule']['hours'][17] = true;
    $csv2post_adm_set['schedule']['hours'][18] = true;
    $csv2post_adm_set['schedule']['hours'][19] = true;
    $csv2post_adm_set['schedule']['hours'][20] = true;
    $csv2post_adm_set['schedule']['hours'][21] = true;
    $csv2post_adm_set['schedule']['hours'][22] = true;
    $csv2post_adm_set['schedule']['hours'][23] = true;
    // limits
    $csv2post_adm_set['schedule']['limits']['hour'] = '1000';
    $csv2post_adm_set['schedule']['limits']['day'] = '5000';
    $csv2post_adm_set['schedule']['limits']['session'] = '300';
    // event types (update csv2post_event_action() if adding more eventtypes)
    $csv2post_adm_set['schedule']['eventtypes']['postcreation']['name'] = 'Post Creation'; 
    $csv2post_adm_set['schedule']['eventtypes']['postcreation']['switch'] = 0;
    $csv2post_adm_set['schedule']['eventtypes']['postupdate']['name'] = 'Post Update'; 
    $csv2post_adm_set['schedule']['eventtypes']['postupdate']['switch'] = 1;
    $csv2post_adm_set['schedule']['eventtypes']['dataimport']['name'] = 'Data Import';  
    $csv2post_adm_set['schedule']['eventtypes']['dataimport']['switch'] = 0;
    $csv2post_adm_set['schedule']['eventtypes']['dataupdate']['name'] = 'Data Update'; 
    $csv2post_adm_set['schedule']['eventtypes']['dataupdate']['switch'] = 0;
    $csv2post_adm_set['schedule']['eventtypes']['twittersend']['name'] = 'Twitter Send'; 
    $csv2post_adm_set['schedule']['eventtypes']['twittersend']['switch'] = 0;
    $csv2post_adm_set['schedule']['eventtypes']['twitterupdate']['name'] = 'Twitter Update'; 
    $csv2post_adm_set['schedule']['eventtypes']['twitterupdate']['switch'] = 0;
    $csv2post_adm_set['schedule']['eventtypes']['twitterget']['name'] = 'Twitter Get'; 
    $csv2post_adm_set['schedule']['eventtypes']['twitterget']['switch'] = 0; 
}  

###############################################################
#                         LOG SEARCH                          #
###############################################################
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome'] = true;
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['timestamp'] = true;
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['line'] = true;
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['function'] = true;
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['page'] = true; 
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['panelname'] = true;   
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['type'] = true;
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['category'] = true;
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['action'] = true;
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['priority'] = true;
$csv2post_adm_set['log']['logscreen']['displayedcolumns']['comment'] = true;     
?>