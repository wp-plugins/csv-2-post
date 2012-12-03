<?php
############################################################################################################
#                                                                                                          #
#   This file holds the $csv2post_logfile_array and it is used to create plus manage multiple wtgcore      #
#   log files and allow the addition of custom log files for specific purposes. We can even create one     #
#   for individual user needs i.e. use them to monitor specific actions/activity                           #
#                                                                                                          #
#   1. Create a function for each log file i.e. csv2post_log_custom                                        #
#   2. Functions paramaters must be the same variable names as the header keys                             #
#   3. The label value is used for building tables and notifications                                       #
#                                                                                                          #
############################################################################################################
$csv2post_logfiles_array = array();

// posts
$csv2post_logfiles_array['posts']['headers']['logged']['label'] = 'Logged';// log entry made (not using Date so users dont think that it is post date)
$csv2post_logfiles_array['posts']['headers']['postid']['label'] = 'Post ID';
$csv2post_logfiles_array['posts']['headers']['posttitle']['label'] = 'Post Title';
$csv2post_logfiles_array['posts']['headers']['action']['label'] = 'Action';
$csv2post_logfiles_array['posts']['headers']['message']['label'] = 'Message';
$csv2post_logfiles_array['posts']['headers']['projectname']['label'] = 'Project Name'; 

// data
$csv2post_logfiles_array['data']['headers']['lastrecordid']['label'] = 'Last Record ID';
$csv2post_logfiles_array['data']['headers']['jobid']['label'] = 'Job ID';
$csv2post_logfiles_array['data']['headers']['comment']['label'] = 'Comment';
$csv2post_logfiles_array['data']['headers']['line']['label'] = 'Line';
$csv2post_logfiles_array['data']['headers']['file']['label'] = 'File';
$csv2post_logfiles_array['data']['headers']['function']['label'] = 'Function';
$csv2post_logfiles_array['data']['headers']['dump']['label'] = 'Dump';
$csv2post_logfiles_array['data']['headers']['sqlresult']['label'] = 'SQL Result';
$csv2post_logfiles_array['data']['headers']['sqlquery']['label'] = 'SQL Query';

// automation (schedule, actions, events)
$csv2post_logfiles_array['automation']['headers']['action']['label'] = 'Action';// intended action or reason for the processing/event
$csv2post_logfiles_array['automation']['headers']['outcome']['label'] = 'Outcome';// for user: the action only, not the reason
$csv2post_logfiles_array['automation']['headers']['trigger']['label'] = 'Trigger Type';// schedule, hook (action hooks such as text spinning could be considered automation), cron, url, user (i.e. user does something that triggers background processing) 
$csv2post_logfiles_array['automation']['headers']['line']['label'] = 'Line';// __LINE__
$csv2post_logfiles_array['automation']['headers']['file']['label'] = 'File';// __FILE__
$csv2post_logfiles_array['automation']['headers']['function']['label'] = 'Function';// __FUNCTION__

##################################################
#                                                #
#                CORE LOG FILES                  #
#                                                #
##################################################
// sql
$csv2post_logfiles_array['sql']['headers']['outcome']['label'] = 'Outcome';// success,failed
$csv2post_logfiles_array['sql']['headers']['comment']['label'] = 'Comment';
$csv2post_logfiles_array['sql']['headers']['line']['label'] = 'Line';
$csv2post_logfiles_array['sql']['headers']['file']['label'] = 'File';
$csv2post_logfiles_array['sql']['headers']['function']['label'] = 'Function';
$csv2post_logfiles_array['sql']['headers']['dump']['label'] = 'Dump';
$csv2post_logfiles_array['sql']['headers']['sqlresult']['label'] = 'SQL Result';
$csv2post_logfiles_array['sql']['headers']['sqlquery']['label'] = 'SQL Query';
$csv2post_logfiles_array['sql']['headers']['recordid']['label'] = 'Record ID';

// users
$csv2post_logfiles_array['users']['headers']['userid']['label'] = 'User ID';
$csv2post_logfiles_array['users']['headers']['username']['label'] = 'Username';
$csv2post_logfiles_array['users']['headers']['usertype']['label'] = 'User Type';// subscriber, author etc
$csv2post_logfiles_array['users']['headers']['side']['label'] = 'Side';// public or admin  
$csv2post_logfiles_array['users']['headers']['message']['label'] = 'Message';// state the outcome from the actino
$csv2post_logfiles_array['users']['headers']['panelname']['label'] = 'Panel Name';// admin form panels
$csv2post_logfiles_array['users']['headers']['paneltitle']['label'] = 'Panel Title';
$csv2post_logfiles_array['users']['headers']['page']['label'] = 'Page';
$csv2post_logfiles_array['users']['headers']['ipaddress']['label'] = 'IP Address';

// error (mainly critical errors, points in scripts we should not ever reach)
$csv2post_logfiles_array['error']['headers']['line']['label'] = 'Line';
$csv2post_logfiles_array['error']['headers']['function']['label'] = 'Function';
$csv2post_logfiles_array['error']['headers']['file']['label'] = 'File';
$csv2post_logfiles_array['error']['headers']['message']['label'] = 'Message';
$csv2post_logfiles_array['error']['headers']['dump']['label'] = 'Dump';// dump Wordpress error, data being used at the time of error, current user

// install
$csv2post_logfiles_array['install']['headers']['action']['label'] = 'Action';
$csv2post_logfiles_array['install']['headers']['userid']['label'] = 'User ID';// user who initiated instal status change
$csv2post_logfiles_array['install']['headers']['message']['label'] = 'Message';
?>
