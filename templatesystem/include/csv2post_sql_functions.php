<?php                  
/**
* Queries a projects database table for giving posts linked record, last update value
* 1. Always queries the main project table, if main table not set in project array then defaults to the first in tables array 
* 2. Only returns record date record was last update
* 
* @returns the date value from csv2post_updated else returns false on table not existing or record not found
* @todo LOWPRIORITY, is this function not meant to be in paid edition folder only?
*/
function csv2post_sql_query_records_last_update($project_code,$post_id){
    // establish main project table
    $main_table = csv2post_get_project_maintable($project_code);
    // ensure user has not manually deleted table 
    $table_exist = csv2post_does_table_exist($main_table);
    if(!$table_exist){return false;}

    // csv2post_updated is not changed in a multiple table project until all tables are updated so we dont need to 
    // be concerned with that here.
    // 5th Aug 2012 Ryan Bayne: added LIMIT 1 to help ensure the result only has 1 record, should somehow post id end up in 2 records   
    global $wpdb;                                                
    $record_array = $wpdb->get_var( 'SELECT csv2post_updated 
    FROM '. $main_table .' 
    WHERE csv2post_postid = ' . $post_id . ' LIMIT 1',ARRAY_A ); 
    if(!$record_array){
        return false;
    }else{          
        return $record_array;  
    }
}   

/**
* Determines if all tables in a giving array exist or not
* @returns boolean true if all table exist else false if even one does not
*/
function csv2post_sql_do_tables_exist($tables_array){
    if($tables_array && is_array($tables_array)){         
        // foreach table in array, if one does not exist return false
        foreach($tables_array as $key => $table_name){
            $table_exists = csv2post_does_table_exist($table_name);  
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
function csv2post_sql_column_distinctvalues($table_name,$column_name){
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
* Builds string of comma delimited table colum names
*/
function csv2post_sql_build_columnstring($table_name){
    $table_columns = csv2post_sql_get_tablecolumns($table_name);
    $column_string = '';
    $first_column = true;
    
    while ($row_column = mysql_fetch_row($table_columns)) { 

        if(!$first_column){
            $column_string .= ',';
        } 
        
        $column_string .= $row_column[0];
        $first_column = false;
    }
    
    return $column_string;       
}

/**
* Update database table record with details of the post that was created using the record.
* This is the basic function provided in free edition. 
* 
* @returns result of wp_update_post(), could be WP_Error or post ID or false
*/
function csv2post_update_project_databasetable_basic($record_id,$post_id,$table_name){
    global $wpdb;
            
    $result = $wpdb->query('UPDATE '. $table_name .'                       
    SET csv2post_postid = '.$post_id.',csv2post_applied = NOW()                            
    WHERE csv2post_id = '.$record_id.'');   
    return $result;
}  

/**
* Update records applied time to indicate that it has just been updated
* 
* @param mixed $post_id
* @param mixed $table_name
* @return int|false
*/
function csv2post_update_project_databasetable_applied($post_id,$table_name){
    global $wpdb;                  
    $result = $wpdb->query('UPDATE '. $table_name .'                       
    SET csv2post_applied = NOW()                            
    WHERE csv2post_id = '.$post_id.'');   
    return $result;
}  
    
/**
* Query a single project table records which have not been used.
* 
* @param string $table_name
*/
function csv2post_sql_query_unusedrecords_singletable($table_name,$posts_target = '1'){
    global $wpdb,$csv2post_is_free;
    
    // ensure user has not manually deleted table 
    $table_exist = csv2post_does_table_exist($table_name);
    if(!$table_exist){return false;}
    
    // if free edition then we do not allow us of specific target as the interface does not allow the entry
    if($csv2post_is_free){$posts_target = '999999';}
        
    return $wpdb->get_results( 'SELECT * 
    FROM '. $table_name .' 
    WHERE csv2post_postid 
    IS NULL OR csv2post_postid = 0 
    LIMIT '. $posts_target,ARRAY_A );    
}

/**
* Uses get_results and finds all DISTINCT meta_keys, returns the result.
* Currently does not have any measure to ensure keys are custom field only.
* @todo, LOWPRIORITY, investigate an efficient way to exclude none custom fields
*/
function csv2post_get_customfield_keys_distinct(){
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
function csv2post_get_metakeys_distinct(){
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
function csv2post_count_records( $table_name ){
    return csv2post_sql_counttablerecords( $table_name );
} 

/**
* Returns the number of rows imported for a giving database table and also the giving file.
* Required in multi-file jobs
*/
function csv2post_sql_count_records_forfile( $tablename,$csvfile_name,$csvfile_id,$file_grouping = 'single' ){
    global $wpdb,$csv2post_is_free;
    
    // no file id is to be applied if free edition or single file project, projects only have a single file
    if($csv2post_is_free || $file_grouping == 'single'){$csvfile_id = '';}
    
    $query = "SELECT COUNT(*) FROM ". $tablename . " WHERE csv2post_filedone".$csvfile_id." = 1";
    $records = $wpdb->get_var( $query );
    if( $records ){return $records;}else{return '0';}   
} 
/**
 * counts total records in giving project table
 * @return 0 on fail or no records or the number of records in table
 */
function csv2post_sql_counttablerecords( $table_name ){
    global $wpdb;
    $query = "SELECT COUNT(*) FROM ". $table_name . ";";
    $records = $wpdb->get_var( $query );
    if( $records ){return $records;}else{return '0';}    
}

/**
* Returns SQL query result of all option records in Wordpress options table that begin with the giving 
*/
function csv2post_get_options_beginning_with($prependvalue){
    
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
* SELECT query to check if a rows record has already been prepared for updating too.
* This function is only required for multi-file data import jobs
* 
* @param mixed $table_name
*/
function csv2post_sql_row_id_check($table_name,$id){
    global $wpdb;
    $query = "SELECT COUNT(*) FROM ". $table_name . " WHERE csv2post_id = ".$id.";";
    $records = $wpdb->get_var( $query );
    if( $records != false && $records != 0 && $records != csv2post_is_WP_Error($records) ){return true;}else{return false;}      
}

/**
 * Builds and executes a MySQL UPATE query
 * The WHERE part is simple in this query, it uses a single value, usually record ID to apply the update. 
 */
function csv2post_sql_update_record( $row, $csvfile_name, $column_total, $jobcode, $record_id, $header_array, $filegrouping){        
    global $csv2post_is_free;
    
    $col = 0;
    
    // establish csv file id - if free edition there is no file id
    if($csv2post_is_free || $filegrouping == 'single'){
        $file_id = '';    
    }else{
        $file_id = csv2post_get_csvfile_id($csvfile_name,$jobcode);;
    }    

    // start SET data part of query
    $set = ' SET csv2post_imported = NOW(),csv2post_updated = NOW(),csv2post_filedone'.$file_id.' = 1';
    
    // start where part of query
    $where = ' WHERE csv2post_id = ' . $record_id;
    
    // count how many keys are used
    $keysused = 0;      
                     
    foreach( $header_array as $header_key => $header ){
      
        $set .= ',';
        
        // use different sql column if multiple file (sql_adapted has an appended number to avoid columns with shared names conflicting)
        if($filegrouping == 'single'){
            $set .= $header['sql'] ." = '". mysql_real_escape_string($row[$col]) ."'";    
        }else{
            $set .= $header['sql_adapted'] ." = '". mysql_real_escape_string($row[$col]) ."'";
        }            

        ++$col;
    }    
     
    // put together parts of query
    $updatequery_complete = 'UPDATE csv2post_' . $jobcode . $set . $where;
    global $wpdb;    
    $updatequery_result = $wpdb->query($updatequery_complete);                
    return $updatequery_result;
}

/**
* Creates a new record in giving table, ready for updating with CSV file data. 
*/
function csv2post_query_insert_new_record ( $table_name,$csvfile_modtime ){
    global $wpdb;
    $sql_query = $wpdb->prepare( "INSERT INTO `".$table_name."` (csv2post_postid) VALUES (0)" );
    $wpdb->query( $sql_query );
    return $wpdb->insert_id;
}
                     
/**
* Create the table for a data import job, table is named using job code
* 
* @param mixed $jobcode
* @param mixed $job_file_group, single or multiple, used to decide if column names should get appended number or not
* @param boolean $maintableonly, default false - if true a project table is required, only project columns added
*/
function csv2post_create_dataimportjob_table($jobcode,$job_file_group,$maintableonly = false){
    global $csv2post_is_free;

    /**
    * csv2post_id          - record id within data table, not imported id
    * csv2post_postid      - if record used to make post, this is the wordpress post id
    * csv2post_postcontent - where required, post content will also be stored
    * csv2post_inuse       - boolean, false means the record is not to be used for whatever reason
    * csv2post_imported    - date of first import of row from csv file, not the last update
    * csv2post_updated     - date a newer row was imported from csv file and updated the record
    * csv2post_changed     - latest date that the plugin auto changed or user manually changed values in record
    * csv2post_applied     - last date and time the record was applied too its post
    * csv2post_filetime    - csv file datestamp when record imported, can then be compared against a newer file to trigger updates
    * 
    * Update Webpage
    * http://www.csv2post.com/hacking/post-creation-project-database-tables
    * 
    * Update Functions
    * csv2post_is_csv2post_postprojecttable()
    */
    
    // CREATE TABLE beginning
    $table = "CREATE TABLE `csv2post_". $jobcode ."` (
    `csv2post_id` int(10) unsigned NOT NULL auto_increment,
    `csv2post_postid` int(10) unsigned default NULL COMMENT '',
    `csv2post_postcontent` int(10) unsigned default NULL COMMENT '',
    `csv2post_inuse` int(10) unsigned default NULL COMMENT '',
    `csv2post_imported` datetime NOT NULL COMMENT '',
    `csv2post_updated` datetime NOT NULL COMMENT '',
    `csv2post_changed` datetime NOT NULL COMMENT '',
    `csv2post_applied` datetime NOT NULL COMMENT '',";

    // if $maintableonly, request is to build a table with the above columns only for a multi file project
    if($maintableonly == false){                                         
        $column_int = 0;
        $fileid = 1;
                    
        $job_array = csv2post_get_dataimportjob($jobcode);
        
        // loop through jobs files
        foreach($job_array['files'] as $fileid => $csv_filename){
            
            // establish file ID value - if a single file is in use or free edition we do not append a value
            if($csv2post_is_free || $job_file_group == 'single'){$mod_append = '';}else{$mod_append = $fileid;}
            
            // add file modification time column for each file, do not append $fileid for single file jobs
            /**
            * csv2post_filemod(ID) - the CSV files last checked modification
            * csv2post_filedone(ID) - boolean true or false, indicates if the row has been update using specific file (with ID)
            */      
            $table .= "
            `csv2post_filemoddate".$mod_append."` datetime default NULL COMMENT '',
            `csv2post_filedone".$mod_append."` text default NULL COMMENT '',";

            // loop through each files set of headers (3 entries in array per header)
            foreach( $job_array[$csv_filename]['headers'] as $header_key => $header){
                
                // if this is a single file job, do not append number
                if($job_file_group == 'single'){
                    $column_name = $header['sql'];
                }else{
                    $column_name = $header['sql_adapted'];// has appended number based on the order of all files
                }
                
                $table .= "
                `" . $column_name . "` text default NULL COMMENT '',";                                                                                                              
            }
            
            ++$fileid;
        }
    }
        
    // end of table
    $table .= "PRIMARY KEY  (`csv2post_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table created by CSV 2 POST';";
    
    global $wpdb;        
    $createresult1 = $wpdb->query( $table );

    if( $createresult1 ){
        // update the job table array - it is simple a record of the tables creating for jobs for tracing then deleting them
        csv2post_add_jobtable('csv2post_' . $jobcode);  
        return true; 
    }else{
        csv2post_notice('Database query failed. If you did not enter separator, quote or number of columns for your CSV file 
        that may be the cause:<br /><br />' . csv2post_sql_formatter($table),'error','Large','Database Query Failure','http://www.csv2post.com/notifications/database-query-failure-on-creating-data-import-job','echo','');
        return false;
    }        
}


/**
 * Returns a cleaned string so that it is suitable to be used as an SQL column name
 * @param string $column (characters removed = , / \ . - # _ and spaces)
 */
function csv2post_cleansqlcolumnname( $column ){
    global $wpdb;
    return str_replace( array( ",","/","'\'"," ",".",'-','#','_'),"", strtolower($column) );
} 

/**
 * Checks if a database table name exists or not
 * @global array $wpdb
 * @param string $table_name
 * @return boolean, true if table found, else if table does not exist
 */
function csv2post_does_table_exist( $table_name ){
    global $wpdb;
    if( $wpdb->query("SHOW TABLES LIKE '".$table_name."'") ){return true;}else{return false;}
}

/**
* Returns all tables from the Wordpress blogs database
* @returns direct result of query SHOW TABLES FROM
*/
function csv2post_sql_get_tables(){
    global $wpdb;
    $result = mysql_query("SHOW TABLES FROM `".$wpdb->dbname."`");
    return $result;
}

/**
* Returns an array holding the column names for the giving table
* 
* @param mixed $t, table name
* @param boolean $return_array, passing true causes array to be built and returned instead of mysql_query resource
* @return false if query returns false, returns array of results if array requested, returns a resource directly from mysql_query by default
* @param boolean
*  $columns_only
*/
function csv2post_sql_get_tablecolumns($t,$return_array = false,$columns_only = false){
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
function csv2post_sql_is_categorywithparent( $category_term,$parent_id ){
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
function csv2post_sql_formatter($sql_query){
    return $sql_query;    
}


/**
* Query post creation project database table for used records (those with csv2post_postid populated)
* 
* @param string $table_name, must be a project table i.e. $project_array['maintable']
* @param numeric $number_of_records, records requested (pass 9999999 for all records), set at 1 by default to avoid over processing by mistake
*/
function csv2post_sql_used_records($table_name,$number_of_records = 1,$select = '*'){
    global $wpdb;
    
    // ensure user has not manually deleted table 
    $table_exist = csv2post_does_table_exist($table_name);
    if(!$table_exist){return false;}
         
    return $wpdb->get_results( 'SELECT '.$select.' 
    FROM '. $table_name .' 
    WHERE csv2post_postid 
    IS NOT NULL 
    AND csv2post_postid != 0
    LIMIT '. $number_of_records,ARRAY_A ); 
}  

/**
* Resets a project table so that it can be used again
* 
* @param string $table_name
* @param boolean $reset_posts
* 
* @todo LOWPRIORITY, create a setting for user to force deletion (no trash) when deleting posts
*/
function csv2post_sql_reset_project_table($table_name,$reset_posts){
    global $wpdb;    
    if($reset_posts){
       $post_ids = $wpdb->get_results( 'SELECT csv2post_postid FROM '. $table_name .' WHERE csv2post_postid IS NOT NULL',ARRAY_A ); 
       if($post_ids){
           foreach($post_ids as $key => $id){
               wp_delete_post($id,false);
           }
       }    
    }
    
    $wpdb->query('UPDATE ' . $table_name .' SET csv2post_postid = 0');
}        

/**
* Resets the project record that has the giving post id in the csv2post_postid column
*/
function csv2post_sql_reset_project_record($post_ID,$table_name){
    global $wpdb;
    if(isset($post_ID) && isset($table_name)){
        $wpdb->query('UPDATE ' . $table_name .' SET csv2post_postid = 0 WHERE csv2post_postid = '.$post_ID);
    }        
}
?>
