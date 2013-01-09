<?php
###############################################################
#                                                             #
#      SCHEDULE ARRAY - MUST BE INSTALLED AND RECORD USED     #
#                                                             #
###############################################################
$csv2post_schedule_array = array();
// history
$csv2post_schedule_array['history']['lastreturnreason'] = 'None';
$csv2post_schedule_array['history']['lasteventtime'] = time();
$csv2post_schedule_array['history']['lasteventtype'] = 'None';
$csv2post_schedule_array['history']['day_lastreset'] = time();
$csv2post_schedule_array['history']['hour_lastreset'] = time();
$csv2post_schedule_array['history']['hourcounter'] = 1;
$csv2post_schedule_array['history']['daycounter'] = 1;
$csv2post_schedule_array['history']['lasteventaction'] = 'None';
// times/days
$csv2post_schedule_array['days']['monday'] = true;
$csv2post_schedule_array['days']['tuesday'] = true;
$csv2post_schedule_array['days']['wednesday'] = true;
$csv2post_schedule_array['days']['thursday'] = true;
$csv2post_schedule_array['days']['friday'] = true;
$csv2post_schedule_array['days']['saturday'] = true;
$csv2post_schedule_array['days']['sunday'] = true;
// times/hours
$csv2post_schedule_array['hours'][0] = true;
$csv2post_schedule_array['hours'][1] = true;
$csv2post_schedule_array['hours'][2] = true;
$csv2post_schedule_array['hours'][3] = true;
$csv2post_schedule_array['hours'][4] = true;
$csv2post_schedule_array['hours'][5] = true;
$csv2post_schedule_array['hours'][6] = true;
$csv2post_schedule_array['hours'][7] = true;
$csv2post_schedule_array['hours'][8] = true;
$csv2post_schedule_array['hours'][9] = true;
$csv2post_schedule_array['hours'][10] = true;
$csv2post_schedule_array['hours'][11] = true;
$csv2post_schedule_array['hours'][12] = true;
$csv2post_schedule_array['hours'][13] = true;
$csv2post_schedule_array['hours'][14] = true;
$csv2post_schedule_array['hours'][15] = true;
$csv2post_schedule_array['hours'][16] = true;
$csv2post_schedule_array['hours'][17] = true;
$csv2post_schedule_array['hours'][18] = true;
$csv2post_schedule_array['hours'][19] = true;
$csv2post_schedule_array['hours'][20] = true;
$csv2post_schedule_array['hours'][21] = true;
$csv2post_schedule_array['hours'][22] = true;
$csv2post_schedule_array['hours'][23] = true;
// limits
$csv2post_schedule_array['limits']['hour'] = '1000';
$csv2post_schedule_array['limits']['day'] = '5000';
$csv2post_schedule_array['limits']['session'] = '300';
// event types (update csv2post_event_action() if adding more eventtypes)
$csv2post_schedule_array['eventtypes']['postcreation']['name'] = 'Post Creation'; 
$csv2post_schedule_array['eventtypes']['postcreation']['switch'] = 0;
$csv2post_schedule_array['eventtypes']['postupdate']['name'] = 'Post Update'; 
$csv2post_schedule_array['eventtypes']['postupdate']['switch'] = 1;
$csv2post_schedule_array['eventtypes']['dataimport']['name'] = 'Data Import';  
$csv2post_schedule_array['eventtypes']['dataimport']['switch'] = 0;
$csv2post_schedule_array['eventtypes']['dataupdate']['name'] = 'Data Update'; 
$csv2post_schedule_array['eventtypes']['dataupdate']['switch'] = 0;
$csv2post_schedule_array['eventtypes']['twittersend']['name'] = 'Twitter Send'; 
$csv2post_schedule_array['eventtypes']['twittersend']['switch'] = 0;
$csv2post_schedule_array['eventtypes']['twitterupdate']['name'] = 'Twitter Update'; 
$csv2post_schedule_array['eventtypes']['twitterupdate']['switch'] = 0;
$csv2post_schedule_array['eventtypes']['twitterget']['name'] = 'Twitter Get'; 
$csv2post_schedule_array['eventtypes']['twitterget']['switch'] = 0;   
?>