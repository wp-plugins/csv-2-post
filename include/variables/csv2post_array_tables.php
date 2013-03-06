<?php
$csv2post_tables_array = csv2post_ARRAY_init('An array of all database tables',__LINE__,__FUNCTION__,__FILE__,'inline array',false);
// csv2post_log
$csv2post_tables_array['tables'][1]['name'] = 'csv2post_log';
$csv2post_tables_array['tables'][1]['required'] = false;// required for all installations or not (boolean)
$csv2post_tables_array['tables'][1]['usercreated'] = false;// if the table is created as a result of user actions rather than core installation put true
$csv2post_tables_array['tables'][1]['version'] = '6.8.7';// version of plugin or extension that table was added to, can use this to update old installations
?>



