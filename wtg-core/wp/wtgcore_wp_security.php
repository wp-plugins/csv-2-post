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

/**
* Checks if DOING_AJAX is set, indicating header is loaded for ajax request only
* @link http://www.csv2post.com/troubleshooting-tips/no-scheduled-events-during-ajax-requests
* @return boolean true if Ajax request ongoing else false        
*/
function csv2post_DOING_AJAX(){
    if(defined('DOING_AJAX')){
        return true;
    }
    return false;    
} 


/**
* Determines if the giving value is a CSV 2 POST page or not
*/
function csv2post_is_plugin_page($page){
    
    // we have two approaches to use. We could loop through page array and check slug values.
    // instead we will just check for "csv2post" within the string, that should be suitable and faster
    return strstr($page,'csv2post');  
} 
?>
