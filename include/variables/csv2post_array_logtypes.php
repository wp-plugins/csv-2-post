<?php

/**
* Logging Categories Array
* Indicates the main columns for the category AND the ones to be displayed on history 
* screens.This helps us avoid adding a lot of empty columns.
*/

$csv2post_logcats_array = csv2post_ARRAY_init('An array of used log entry categories',__LINE__,__FUNCTION__,__FILE__,'inline array',false);
// install 
$csv2post_logcats_array['categories']['install']['purpose'] = 'used in installation related events';
$csv2post_logcats_array['categories']['install']['columns'] = array('outcome','timestamp','userid','comment');
// schedule 
$csv2post_logcats_array['categories']['schedule']['purpose'] = 'for use in schedule system';
$csv2post_logcats_array['categories']['schedule']['columns'] = array();
// posts
$csv2post_logcats_array['categories']['posts']['purpose'] = 'log events related to post creation or updating';
$csv2post_logcats_array['categories']['posts']['columns'] = array();
// data 
$csv2post_logcats_array['categories']['data']['purpose'] = 'log events related to data import or updating';
$csv2post_logcats_array['categories']['data']['columns'] = array();
// project 
$csv2post_logcats_array['categories']['project']['purpose'] = 'log key project changes especially automatic configuration';
$csv2post_logcats_array['categories']['project']['columns'] = array();
// adminform (dashboard side form submission) 
$csv2post_logcats_array['categories']['adminform']['purpose'] = 'admin side form submissions';
$csv2post_logcats_array['categories']['adminform']['columns'] = array();
// publicform (front side form submission) 
$csv2post_logcats_array['categories']['publicform']['purpose'] = 'public side form submissions';
$csv2post_logcats_array['categories']['publicform']['columns'] = array();

?>