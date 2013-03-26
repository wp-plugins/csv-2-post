<?php
######################################################
#                                                    #
#     Wordpress MySQL Functions For All Plugins      #
#           if function contains $wpdb               #
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
* @todo LOWPRIORITY, create a setting for activating option record loggin, log old + new value and if possible the reason for the change, where the change was called from, that would require more atts passed
*/
function csv2post_option($option,$action,$value = 'No Value',$autoload = 'yes'){
    if($action == 'add'){  
        return add_option($option,$value,'',$autoload);            
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

function csv2post_WP_SQL_querylog_bytype($type = 'all',$limit = 100){
    global $wpdb;

    // where
    $where = '';
    if($type != 'all'){
      $where = 'WHERE type = "'.$type.'"';
    }

    // limit
    $limit = 'LIMIT ' . $limit;
    
    // get_results
    $rows = $wpdb->get_results( 
    "
    SELECT * 
    FROM csv2post_log
    ".$where."
    ".$limit."

    ",ARRAY_A);

    if(!$rows){
        return false;
    }else{
        return $rows;
    }
} 

/**
* Determines if all tables in a giving array exist or not
* @returns boolean true if all table exist else false if even one does not
*/
function csv2post_WP_SQL_do_tables_exist($tables_array){
    if($tables_array && is_array($tables_array)){         
        // foreach table in array, if one does not exist return false
        foreach($tables_array as $key => $table_name){
            $table_exists = csv2post_WP_SQL_does_table_exist($table_name);  
            if(!$table_exists){          
                ### TODO:LOWPRIORITY, log this event so we can make user aware that an active project has am missing table
                return false;
            }
        }        
    }
    return true;    
}

/**
* Queries distinct values in a giving column
* 
* @returns array of distinct values or 0 if no records or false if none 
*/
function csv2post_WP_SQL_column_distinctvalues($table_name,$column_name){
    global $wpdb;
    
    $query = "SELECT DISTINCT ".$column_name." FROM ". $table_name . ";";
    
    $distinct_values_found = $wpdb->get_results( $query,ARRAY_A );
            
    if(!$distinct_values_found){
        return 0;
    }else{
        return $distinct_values_found;        
    }  
    
    return false;                      
}

/**
* Uses get_results and finds all DISTINCT meta_keys, returns the result.
* Currently does not have any measure to ensure keys are custom field only.
* @todo, LOWPRIORITY, investigate an efficient way to exclude none custom fields
*/
function csv2post_WP_SQL_get_customfield_keys_distinct(){
    global $wpdb;
    return $wpdb->get_results("SELECT DISTINCT meta_key FROM $wpdb->postmeta 
                                  WHERE meta_key != '_encloseme' 
                                  AND meta_key != '_wp_page_template'
                                  AND meta_key != '_edit_last'
                                  AND meta_key != '_edit_lock'
                                  AND meta_key != '_wp_trash_meta_time'
                                  AND meta_key != '_wp_trash_meta_status'
                                  AND meta_key != '_wp_old_slug'
                                  AND meta_key != '_pingme'
                                  AND meta_key != '_thumbnail_id'
                                  AND meta_key != '_wp_attachment_image_alt'
                                  AND meta_key != '_wp_attachment_metadata'
                                  AND meta_key != '_wp_attached_file'");    
}

/**
* Uses get_results and finds all DISTINCT meta_keys, returns the result  
*/
function csv2post_WP_SQL_metakeys_distinct(){
    global $wpdb;
    return $wpdb->get_results("SELECT DISTINCT meta_key FROM $wpdb->postmeta 
                                  WHERE meta_key != '_encloseme' 
                                  AND meta_key != '_wp_page_template'
                                  AND meta_key != '_edit_last'
                                  AND meta_key != '_edit_lock'
                                  AND meta_key != '_wp_trash_meta_time'
                                  AND meta_key != '_wp_trash_meta_status'
                                  AND meta_key != '_wp_old_slug'
                                  AND meta_key != '_pingme'
                                  AND meta_key != '_thumbnail_id'
                                  AND meta_key != '_wp_attachment_image_alt'
                                  AND meta_key != '_wp_attachment_metadata'
                                  AND meta_key != '_wp_attached_file'");    
}

/**
* Returns the number of rows imported for a giving database table
* @deprecated, function was a duplicate, prefer the function containing sql in the name
*/
function csv2post_WP_SQL_count_records( $table_name ){
    return csv2post_WP_SQL_counttablerecords( $table_name );
}

/**
 * counts total records in giving project table
 * @return 0 on fail or no records or the number of records in table
 */
function csv2post_WP_SQL_counttablerecords( $table_name ){
    global $wpdb;
    $query = "SELECT COUNT(*) FROM ". $table_name . ";";
    $records = $wpdb->get_var( $query );
    if( $records ){return $records;}else{return '0';}    
}

/**
* Returns SQL query result of all option records in Wordpress options table that begin with the giving 
*/
function csv2post_WP_SQL_options_beginning_with($prependvalue){
    
    // set variables
    global $wpdb;
    $optionrecord_array = array();
    
    // first get all records
    $optionrecords = $wpdb->get_results( "SELECT option_name FROM $wpdb->options" );
    
    // loop through each option record and check their name value for csv2post_ at the beginning
    foreach( $optionrecords as $optkey => $option ){
        if(strpos( $option->option_name , $prependvalue ) === 0){
            $optionrecord_array[] = $option->option_name;
        }
    } 
    
    return $optionrecord_array;   
}

/**
* Query posts by ID 
*/
function csv2post_WP_SQL_does_post_exist_byid($id){
    global $wpdb;
    return $wpdb->get_row("SELECT post_title FROM wp_posts WHERE id = '" . $id . "'", 'ARRAY_A');    
} 

/**
 * Checks if a database table name exists or not
 * @global array $wpdb
 * @param string $table_name
 * @return boolean, true if table found, else if table does not exist
 */
function csv2post_WP_SQL_does_table_exist( $table_name ){
    global $wpdb;                                      
    if( $wpdb->query("SHOW TABLES LIKE '".$table_name."'") ){return true;}else{return false;}
}

/**
* Returns all tables from the Wordpress blogs database
* @returns direct result of query SHOW TABLES FROM
*/
function csv2post_WP_SQL_get_tables(){
    global $wpdb;
    $result = mysql_query("SHOW TABLES FROM `".$wpdb->dbname."`");
    return $result;
}

/**
* Returns an array holding the column names for the giving table
* 
* @param mixed $t
* @param mixed $return_array false returns mysql result and true returns an array of the result
* @param mixed $columns_only for use when returning array only and true will return only column names not other information mysql returns in the query
* @return array or mysql result or false on failure
*/
function csv2post_WP_SQL_get_tablecolumns($t,$return_array = false,$columns_only = false){
    global $wpdb;
    $mysql_query_result = mysql_query("SHOW COLUMNS FROM `".$t."`");
    if(!$mysql_query_result){return false;}
    
    if(!$return_array){return $mysql_query_result;}
    
    if($return_array == true && $columns_only == false){
        
        $newarray = array();
        while ($column = mysql_fetch_row($mysql_query_result)) {
            $newarray[] = $column;    
        }
        return $newarray;
                
    }elseif($return_array == true && $columns_only == true){
        
        $newarray = array();
        $column_counter = 0;
        while ($column = mysql_fetch_row($mysql_query_result)) {

            $newarray[] = $column[0];// $column holds column configuration, [0] is the table name
            
            ++$column_counter;    
        }
        return $newarray;  
    }   
}

/**
* Checks if a category already exists with the giving parent.
* 
* @param mixed $cat_encoded
* @param mixed $parent
* @return mixed
*/
function csv2post_WP_SQL_is_categorywithparent( $category_term,$parent_id ){
    global $wpdb;
    return $wpdb->get_row("SELECT
    $wpdb->terms.term_id,
    $wpdb->terms.name,
    $wpdb->term_taxonomy.parent
    FROM $wpdb->terms
    JOIN $wpdb->term_taxonomy
    WHERE $wpdb->terms.name = '".$category_term."'
    AND $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id
    AND $wpdb->term_taxonomy.parent = '".$parent_id."'
    LIMIT 1");
}

/**
* NOT IN USE YET - Formats SQL string for displaying in HTML.
* Using something like https://github.com/jdorn/sql-formatter
* @todo LOWPRIORITY
*/
function csv2post_WP_SQL_formatter($sql_query){
    return $sql_query;    
}

/**
 * Checks if a database table exist
 * @param string $table_name (possible database table name)
 *
 * @todo SHOW TABLES can cause problems, invistagate another approach such as querying the table, ignoring the error if it does not exist
 */
function csv2post_database_table_exist( $table_name ){
    global $wpdb;
    if( $wpdb->get_var("SHOW TABLES LIKE `".$table_name."`") != $table_name) {
            return false;
    }else{
            return true;
    }
}
?>