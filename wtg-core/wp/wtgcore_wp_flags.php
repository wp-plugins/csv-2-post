<?php
/** 
 * WebTechGlobal standard PHP and CMS function library
 *
 * @package WTG Core Functions Library
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
/**
* Flag something
* 1. type: file|data|user|error
* 
* @todo to be complete, create custom post type flag
*/
function csv2post_flag($atts){
    return false;      
}

/**
* Flags the giving post by adding _csv2post_flagged meta value which is used in the flagging system.
*     
* @param integer $post_ID
* @param integer $priority, 1 = low priority (info style notification), 2 = unsure of priority (warning style notification), 3 = high priority (error style notification)
* @param string $type, keyword to enhance search ability (USED:updatefailure ) 
* @param string $reason, as much information as required for user to take the required action or know they can delete the flag
*/
function csv2post_flag_post($post_ID,$priority,$type,$reason){
    $a = array();
    $a['priority'] = $priority;
    $a['time'] = time();
    $a['reason'] = $reason;

    add_post_meta($post_ID,'_csv2post_flagged',$a,false);   
}  
?>
