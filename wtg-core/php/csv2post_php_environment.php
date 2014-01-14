<?php
/** 
 * WebTechGlobal standard PHP and CMS function library
 *
 * @package WTG Core Functions Library
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
/**
* Returns MySQL version 
*/
function csv2post_get_mysqlversion() { 
    $output = shell_exec('mysql -V'); 
    preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
    return $version[0]; 
}
?>