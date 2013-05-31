<?php
/**
* Flag something
* 1. type: file|data|user|error
*/
function csv2post_flag($atts){
    if(!csv2post_WP_SQL_does_table_exist('csv2post_flags')){
        return false;    
    }   
    
    extract( shortcode_atts( array(  
        'phpline' => __LINE__, 
        'phpfunction' => false, 
        'priority' => false,
        'type' => false,
        'fileurl' => false,
        'dataid' => false,
        'userid' => false,
        'errortext' => false,
        'projectid' => false,
        'reason' => false,
        'action' => false,          
    ), $atts ) );
    
    // start query
    $query = "INSERT INTO `csv2post_log`";
    
    // add columns and values
    $query_columns = '(phpline';
    $query_values = '('.$phpline.'';
    
    if($phpfunction){$query_columns .= ',phpfunction';$query_values .= ',"'.$phpfunction.'"';}
    if($priority){$query_columns .= ',priority';$query_values .= ',"'.$priority.'"';}
    if($type){$query_columns .= ',type';$query_values .= ',"'.$type.'"';}
    if($fileurl){$query_columns .= ',fileurl';$query_values .= ',"'.$fileurl.'"';}
    if($dataid){$query_columns .= ',dataid';$query_values .= ',"'.$dataid.'"';}
    if($userid){$query_columns .= ',userid';$query_values .= ',"'.$userid.'"';}
    if($errortext){$query_columns .= ',errortext';$query_values .= ',"'.$errortext.'"';}
    if($projectid){$query_columns .= ',projectid';$query_values .= ',"'.$projectid.'"';}
    if($reason){$query_columns .= ',reason';$query_values .= ',"'.$reason.'"';}
    if($action){$query_columns .= ',action';$query_values .= ',"'.$action.'"';}
    
    $query_columns .= ')';
    $query_values .= ')';
    $query .= $query_columns .' VALUES '. $query_values;  
    $wpdb->query( $query );     
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
        
    ### TODO:MEDIUMPRIORITY, apply new flag approach that includes log table
            
    add_post_meta($post_ID,'_csv2post_flagged',$a,false);   
}  
?>
