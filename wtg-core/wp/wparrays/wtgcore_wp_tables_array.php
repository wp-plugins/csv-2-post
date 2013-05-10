<?php
$csv2post_tables_array =  array();
// csv2post_log
$csv2post_tables_array['tables'][1]['name'] = 'csv2post_log';
$csv2post_tables_array['tables'][1]['required'] = false;// required for all installations or not (boolean)
$csv2post_tables_array['tables'][1]['usercreated'] = false;// if the table is created as a result of user actions rather than core installation put true
$csv2post_tables_array['tables'][1]['version'] = '6.9.6';// used to trigger updates
// csv2post_flag
$csv2post_tables_array['tables'][2]['name'] = 'csv2post_flag';
$csv2post_tables_array['tables'][2]['required'] = false;
$csv2post_tables_array['tables'][2]['usercreated'] = false;
$csv2post_tables_array['tables'][2]['version'] = '6.9.6';
?>