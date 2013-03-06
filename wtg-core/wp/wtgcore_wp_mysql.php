<?php
######################################################
#                                                    #
#   MySQL FUNCTIONS FOR ALL PLUGINS AND THEMES ONLY  #
#                                                    #
######################################################

/**
* Control Wordpress option functions using this single function.
* This function will give us the opportunity to easily log changes and some others ideas we have.
* 
* @param mixed $option
* @param mixed $action add, get, wtgget (own query function) update, delete
* @param mixed $value
* @param mixed $autoload used by add_option only
* 
* @todo LOWPRIORITY, call a global settings value for logging to server error log and make entries per action
*/
function csv2post_option($option,$action,$value = 'No Value',$autoload = 'no'){
    if($action == 'add'){  
        return add_option($option,$value,'','no');            
    }elseif($action == 'get'){
        return get_option($option);    
    }elseif($action == 'update'){        
        return update_option($option,$value);
    }elseif($action == 'delete'){
        return delete_option($option);        
    }
}

/**
* MySQL SELECT query
* 1. Do table exists check prior to using this function
* 
* @param mixed $table_name
* @param mixed $limit
* @param mixed $columns
* 
* @returns ARRAY_A if records else false
*/
function csv2post_WP_SQL_select($table_name,$limit = 10,$columns = '*',$where = ''){
    global $wpdb;    
    return $wpdb->get_results( 'SELECT '.$columns.' 
    FROM '. $table_name .' 
    '. $where .' 
    LIMIT '. $limit,ARRAY_A );
}

/**
* Gets posts with the giving meta value
*/
function csv2post_WP_SQL_get_posts_join_meta($meta_key,$meta_value,$limit = 1,$select = '*',$where = ''){
    global $wpdb;
    $q = "SELECT wposts.".$select."
    FROM ".$wpdb->posts." AS wposts
    INNER JOIN ".$wpdb->postmeta." AS wpostmeta
    ON wpostmeta.post_id = wposts.ID
    AND wpostmeta.meta_key = '".$meta_key."'                                                 
    AND wpostmeta.meta_value = '".$meta_value."' 
    ".$where."
    LIMIT ".$limit."";
    return $wpdb->get_results($q, OBJECT);    
}

/**
* Get POST ID using post_name (slug)
* 
* @param string $name
* @return string|null
*/
function csv2post_WP_SQL_get_post_ID_by_postname($name){
    global $wpdb;
    // get page id using custom query
    return $wpdb->get_var("SELECT ID 
    FROM $wpdb->posts 
    WHERE post_name = '".$name."' 
    AND post_type='page' ");
}

/**
* Returns all the columns in giving database table that hold data of the giving data type.
* The type will be determined with PHP not based on MySQL column data types. 
* 1. Table must have one or more records
* 2. 1 record will be queried  ### TODO:LOWPRIORITY, increase this and do a loop then pick the average type per column
* 3. Each columns values will be tested by PHP to determine data type
* 4. Array returned with column names that match the giving type
* 5. If $dt is false, all columns will be returned with their type however that is not the main purpose of this function
* 6. Types can be custom, using regex etc. The idea is to establish if a value is of the pattern suitable for intended use.
* 
* @param string $tableName table name
* @param string $dataType data type URL|IMG|NUMERIC|STRING|ARRAY
* 
* @returns false if no record could be found
* 
* @todo LOWPRIORITY, I'm not adding checks for anything other than URL right now as I'm using this function on URL cloaking panel. Add checks for other values types.
*/
function csv2post_WP_SQL_return_cols_with_data_type($tableName,$dataType = false){
    global $wpdb;
    
    $ra = array();// returned array - our array of columns matching data type
    $matchCount = 0;// matches
    $ra['arrayinfo']['matchcount'] = $matchCount;

    $rec = $wpdb->get_results( 'SELECT * FROM '. $tableName .'  LIMIT 1',ARRAY_A);
    if(!$rec){return false;}
    
    $knownTypes = array();
    foreach($rec as $id => $value_array){
        foreach($value_array as $column => $value){     
                         
            $isURL = csv2post_is_url($value);
            if($isURL){++$matchCount;$ra['matches'][] = $column;}
       
        }       
    }
    
    $ra['arrayinfo']['matchcount'] = $matchCount;
    return $ra;
}    
?>
