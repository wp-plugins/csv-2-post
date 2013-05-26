<?php
/**
* Returns MySQL version 
*/
function csv2post_get_mysqlversion() { 
    $output = shell_exec('mysql -V'); 
    preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
    return $version[0]; 
}
?>