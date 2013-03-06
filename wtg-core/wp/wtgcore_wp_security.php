<?php
/**
* Put the function in the head of a file to prevent it being called directly. 
* Uses function_exists to check if a common Wordpress function has loaded, indicating
* Wordpress has loaded. Wordpress security would the be in effect. 
*/
function csv2post_WP_SECURITY_exit_forbidden_request($file = 'Unknown'){
    if (!function_exists('add_action')) {
        header('Status: 403 Forbidden');
        header('HTTP/1.1 403 Forbidden');
        exit();
    }
}  
?>
