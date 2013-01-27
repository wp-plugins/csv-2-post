<?php
###########################################################
#                                                         #
#   USED DURING INSTALL ONLY - SETS PERSISTENT NOTICES    #
#                                                         #
###########################################################
$csv2post_persistent_array = array();
// 0 - Easy CSV Importer screen introduction
$csv2post_persistent_array['notifications'][0]['message'] = 'This is our quick start feature. You can import data and create posts using the most commonly used settings. There are panels that are only provided by our paid services and they had to be kept due to complications in removing them. However everything the majority of users need for auto-blogging are included in our free edition of CSV 2 POST.';
$csv2post_persistent_array['notifications'][0]['type'] = 'info';
$csv2post_persistent_array['notifications'][0]['size'] = 'Large';
$csv2post_persistent_array['notifications'][0]['title'] = 'Easy CSV Importer Introduction';
$csv2post_persistent_array['notifications'][0]['helpurl'] = ''; 
$csv2post_persistent_array['notifications'][0]['placement_type'] = 'screen';      
$csv2post_persistent_array['notifications'][0]['placement_specific'] = 0;  
$csv2post_persistent_array['notifications'][0]['pageid'] = 'main';  
$csv2post_persistent_array['notifications'][0]['id'] = rand(100,10000) . time();
?>
