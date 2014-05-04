<?php
/** 
 * Default administration settings for CSV 2 POST plugin 
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */

// install main admin settings option record
$c2p_settings = array();
$c2p_settings['currentproject'] = false;// id 1 may not always exist but we will handle that automatically at some stage
// encoding
$c2p_settings['standardsettings']['encoding']['type'] = 'utf8';
// admin user interface settings start
$c2p_settings['standardsettings']['ui_advancedinfo'] = false;// hide advanced user interface information by default
// other
$c2p_settings['standardsettings']['ecq'] = array();
$c2p_settings['standardsettings']['chmod'] = '0750';
// testing and development
$c2p_settings['standardsettings']['developementinsight'] = 'disabled';
// global switches
$c2p_settings['standardsettings']['textspinrespinning'] = 'enabled';// disabled stops all text spin re-spinning and sticks to the last spin

##########################################################################################
#                                                                                        #
#                            DATA IMPORT AND MANAGEMENT SETTINGS                         #
#                                                                                        #
##########################################################################################
$c2p_settings['datasettings']['insertlimit'] = 100;

##########################################################################################
#                                                                                        #
#                           YOUTUBE RELATED SETTINGS                                     #
#                                                                                        #
##########################################################################################
$c2p_settings['youtubesettings']['defaultcolor'] = '&color1=0x2b405b&color2=0x6b8ab6';
$c2p_settings['youtubesettings']['defaultborder'] = 'enable';
$c2p_settings['youtubesettings']['defaultautoplay'] = 'enable';
$c2p_settings['youtubesettings']['defaultfullscreen'] = 'enable';
$c2p_settings['youtubesettings']['defaultscriptaccess'] = 'always';

##########################################################################################
#                                                                                        #
#                           GOOGLE RELATED SETTINGS                                      #
#                                                                                        #
##########################################################################################


##########################################################################################
#                                                                                        #
#                                  LOG SETTINGS                                          #
#                                                                                        #
##########################################################################################
$c2p_settings['logsettings']['uselog'] = 1;
$c2p_settings['logsettings']['loglimit'] = 1000;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['outcome'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['timestamp'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['line'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['function'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['page'] = true; 
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['panelname'] = true;   
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['userid'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['type'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['category'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['action'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['priority'] = true;
$c2p_settings['logsettings']['logscreen']['displayedcolumns']['comment'] = true;

##########################################################################################
#                                                                                        #
#                             DEFAULT PROJECT OPTIONS                                    #
#                                                                                        #
##########################################################################################
$c2p_settings['projectdefaults']['basicsettings']['poststatus'] = 'draft';
$c2p_settings['projectdefaults']['basicsettings']['pingstatus'] = 'closed';// open | closed
$c2p_settings['projectdefaults']['basicsettings']['commentstatus'] = 'open';// open | closed
$c2p_settings['projectdefaults']['basicsettings']['defaultauthor'] = 1;// user id
$c2p_settings['projectdefaults']['basicsettings']['defaultcategory'] = 0;// category id
$c2p_settings['projectdefaults']['basicsettings']['defaultposttype'] = 'post';// post,page or a custom post type
$c2p_settings['projectdefaults']['basicsettings']['defaultpostformat'] = 'standard';// aside,gallery,link,image,quote,status,video,audio,chat 
$c2p_settings['projectdefaults']['basicsettings']['categoryassignment'] = 'all';// all or last

$c2p_settings['projectdefaults']['images']['featuredimage']['table'] = '';
$c2p_settings['projectdefaults']['images']['featuredimage']['column'] = '';
                                          
// title template
$c2p_settings['projectdefaults']['titles']['defaulttitletemplate'] = ''; 

// content template                
$c2p_settings['projectdefaults']['content']['wysiwygdefaultcontent'] = '';

// custom fields                    
$c2p_settings['projectdefaults']['customfields']['cflist'][0]['id'] = 0;// used in WP_Table class to pass what is actually the key, use they key though where unique value is required
$c2p_settings['projectdefaults']['customfields']['cflist'][0]['name'] = '';// the key
$c2p_settings['projectdefaults']['customfields']['cflist'][0]['value'] = '';// on UI it is a template 
$c2p_settings['projectdefaults']['customfields']['cflist'][0]['unique'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][0]['updating'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][1]['id'] = 1;
$c2p_settings['projectdefaults']['customfields']['cflist'][1]['name'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][1]['value'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][1]['unique'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][1]['updating'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][2]['id'] = 2;
$c2p_settings['projectdefaults']['customfields']['cflist'][2]['name'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][2]['value'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][2]['unique'] = '';
$c2p_settings['projectdefaults']['customfields']['cflist'][2]['updating'] = '';

// category levels
$c2p_settings['projectdefaults']['categories']['data'][0]['table'] = '';
$c2p_settings['projectdefaults']['categories']['data'][0]['column'] = '';
$c2p_settings['projectdefaults']['categories']['data'][1]['table'] = '';
$c2p_settings['projectdefaults']['categories']['data'][1]['column'] = '';
$c2p_settings['projectdefaults']['categories']['data'][2]['table'] = '';
$c2p_settings['projectdefaults']['categories']['data'][2]['column'] = '';
$c2p_settings['projectdefaults']['categories']['data'][3]['table'] = '';
$c2p_settings['projectdefaults']['categories']['data'][3]['column'] = '';
$c2p_settings['projectdefaults']['categories']['data'][4]['table'] = '';
$c2p_settings['projectdefaults']['categories']['data'][4]['column'] = '';

// tags
$c2p_settings['projectdefaults']['tags']['table'] = '';// ready made tags
$c2p_settings['projectdefaults']['tags']['column'] = '';// ready made tags
$c2p_settings['projectdefaults']['tags']['textdata']['column'] = '';// enter a comma separated string of column names which have text suitable for generating tags from
$c2p_settings['projectdefaults']['tags']['defaultnumerics'] = 'disallow';// allow | disallow
$c2p_settings['projectdefaults']['tags']['tagstringlength'] = '50';// enter maximum length of all tags for a post when in a comma separated string
$c2p_settings['projectdefaults']['tags']['maximumtags'] = '3';// enter maximum number of separate tags for all posts
$c2p_settings['projectdefaults']['tags']['excludedtags'] = 'to,from,about,where,too,see,him,his,her,hers,ours,were';

$c2p_settings['projectdefaults']['dates']['publishdatemethod'] = 'wordpress';// wordpress | data | incremental | random
$c2p_settings['projectdefaults']['dates']['table'] = '';
$c2p_settings['projectdefaults']['dates']['column'] = '';
$c2p_settings['projectdefaults']['dates']['dateformat'] = 'noformat';// noformat | uk | us | mysql | unsure

$c2p_settings['projectdefaults']['dates']['incrementalstartdate'] = '';
$c2p_settings['projectdefaults']['dates']['naturalvariationlow'] = '30';// enter the mininum number of minutes to add to the increment minutes (used to create a random more natural variation per increment)
$c2p_settings['projectdefaults']['dates']['naturalvariationhigh'] = '90';// enter the maximum number of minutes to add to the incremental number of minutes
$c2p_settings['projectdefaults']['dates']['randomdateearliest'] = '';
$c2p_settings['projectdefaults']['dates']['randomdatelatest'] = '';
?>