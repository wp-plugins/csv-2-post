<?php
/**
* Queries distinct values in a giving column
* 
* @returns array of distinct values or 0 if no records or false if none 
*/
function wtgcsv_sql_column_distinctvalues($table_name,$column_name){
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
function wtgcsv_sql_build_columnstring($table_name){
    $table_columns = wtgcsv_sql_get_tablecolumns($table_name);
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
function wtgcsv_update_project_databasetable_basic($record_id,$post_id,$table_name){
    global $wpdb;                  
    $wpdb->query('UPDATE '. $table_name .'                       
    SET wtgcsv_postid = '.$post_id.',wtgcsv_applied = NOW()                            
    WHERE wtgcsv_id = '.$record->eciid.'');
        
    return wp_update_post( $my_post );
}    
    
/**
* Query a single project table records which have not been used.
* 
* @param string $table_name
*/
function wtgcsv_sql_query_unusedrecords_singletable($table_name,$posts_target = '1'){
    global $wpdb,$wtgcsv_is_free;
    
    // ensure user has not manually deleted table 
    $table_exist = wtgcsv_does_table_exist($table_name);
    if(!$table_exist){return false;}
    
    // if free edition then we do not allow us of specific target as the interface does not allow the entry
    if($wtgcsv_is_free){$posts_target = '999999';}
        
    return $wpdb->get_results( 'SELECT * 
    FROM '. $table_name .' 
    WHERE wtgcsv_postid 
    IS NULL OR wtgcsv_postid = 0 
    LIMIT '. $posts_target,ARRAY_A );    
}

/**
* Uses get_results and finds all DISTINCT meta_keys, returns the result.
* Currently does not have any measure to ensure keys are custom field only.
* @todo, LOWPRIORITY, investigate an efficient way to exclude none custom fields
*/
function wtgcsv_get_customfield_keys_distinct(){
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
function wtgcsv_get_metakeys_distinct(){
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
function wtgcsv_count_records( $table_name ){
    return wtgcsv_sql_counttablerecords( $table_name );
} 

/**
* Returns the number of rows imported for a giving database table and also the giving file.
* Required in multi-file jobs
*/
function wtgcsv_sql_count_records_forfile( $tablename,$csvfile_name,$csvfile_id,$file_grouping = 'single' ){
    global $wpdb,$wtgcsv_is_free;
    
    // no file id is to be applied if free edition or single file project, projects only have a single file
    if($wtgcsv_is_free || $file_grouping == 'single'){$csvfile_id = '';}
    
    $query = "SELECT COUNT(*) FROM ". $tablename . " WHERE wtgcsv_filedone".$csvfile_id." = 1";
    $records = $wpdb->get_var( $query );
    if( $records ){return $records;}else{return '0';}   
} 
/**
 * counts total records in giving project table
 * @return 0 on fail or no records or the number of records in table
 */
function wtgcsv_sql_counttablerecords( $table_name ){
    global $wpdb;
    $query = "SELECT COUNT(*) FROM ". $table_name . ";";
    $records = $wpdb->get_var( $query );
    if( $records ){return $records;}else{return '0';}    
}

/**
* Returns SQL query result of all option records in Wordpress options table that begin with the giving 
*/
function wtgcsv_get_options_beginning_with($prependvalue){
    
    // set variables
    global $wpdb;
    $optionrecord_array = array();
    
    // first get all records
    $optionrecords = $wpdb->get_results( "SELECT option_name FROM $wpdb->options" );
    
    // loop through each option record and check their name value for wtgcsv_ at the beginning
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
function wtgcsv_sql_row_id_check($table_name,$id){
    global $wpdb;
    $query = "SELECT COUNT(*) FROM ". $table_name . " WHERE wtgcsv_id = ".$id.";";
    $records = $wpdb->get_var( $query );
    if( $records != false && $records != 0 && $records != wtgcsv_is_WP_Error($records) ){return true;}else{return false;}      
}

/**
 * Builds and executes a MySQL UPATE query
 * The WHERE part is simple in this query, it uses a single value, usually record ID to apply the update. 
 */
function wtgcsv_sql_update_record( $row, $csvfile_name, $column_total, $jobcode, $record_id, $header_array, $filegrouping){        
    global $wtgcsv_is_free;
    
    $col = 0;
    
    // establish csv file id - if free edition there is no file id
    if($wtgcsv_is_free || $filegrouping == 'single'){
        $file_id = '';    
    }else{
        $file_id = wtgcsv_get_csvfile_id($csvfile_name,$jobcode);;
    }    
    
    
    // start SET data part of query
    $set = ' SET wtgcsv_imported = NOW(),wtgcsv_updated = NOW(),wtgcsv_filedone'.$file_id.' = 1';
    
    // start where part of query
    $where = ' WHERE wtgcsv_id = ' . $record_id;
    
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
    $updatequery_complete = 'UPDATE wtgcsv_' . $jobcode . $set . $where;
    global $wpdb;    
    $updatequery_result = $wpdb->query($updatequery_complete);                
    return $updatequery_result;
}

/**
* Creates a new record in giving table, ready for updating with CSV file data. 
*/
function wtgcsv_query_insert_new_record ( $table_name,$csvfile_modtime ){
    global $wpdb;
    $sql_query = $wpdb->prepare( "INSERT INTO `".$table_name."` (wtgcsv_postid) VALUES (0)" );
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
function wtgcsv_create_dataimportjob_table($jobcode,$job_file_group,$maintableonly = false){
    global $wtgcsv_is_free;

    /**
    * wtgcsv_id          - record id within data table, not imported id
    * wtgcsv_postid      - if record used to make post, this is the wordpress post id
    * wtgcsv_postcontent - where required, post content will also be stored
    * wtgcsv_inuse       - boolean, false means the record is not to be used for whatever reason
    * wtgcsv_imported    - date of first import of row from csv file, not the last update
    * wtgcsv_updated     - date a newer row was imported from csv file and updated the record
    * wtgcsv_changed     - latest date that the plugin auto changed or user manually changed values in record
    * wtgcsv_applied     - last date and time the record was applied too its post
    * wtgcsv_filetime    - csv file datestamp when record imported, can then be compared against a newer file to trigger updates
    * 
    * Update Webpage
    * http://www.importcsv.eu/hacking/post-creation-project-database-tables
    * 
    * Update Functions
    * wtgcsv_is_wtgcsv_postprojecttable()
    */
    
    // CREATE TABLE beginning
    $table = "CREATE TABLE `wtgcsv_". $jobcode ."` (
    `wtgcsv_id` int(10) unsigned NOT NULL auto_increment,
    `wtgcsv_postid` int(10) unsigned default NULL COMMENT '',
    `wtgcsv_postcontent` int(10) unsigned default NULL COMMENT '',
    `wtgcsv_inuse` int(10) unsigned default NULL COMMENT '',
    `wtgcsv_imported` datetime NOT NULL COMMENT '',
    `wtgcsv_updated` datetime NOT NULL COMMENT '',
    `wtgcsv_changed` datetime NOT NULL COMMENT '',
    `wtgcsv_applied` datetime NOT NULL COMMENT '',";
    
    
    // if $maintableonly, request is to build a table with the above columns only for a multi file project
    if($maintableonly == false){                                         
        $column_int = 0;
        $fileid = 1;
                    
        $job_array = wtgcsv_get_dataimportjob($jobcode);
        
        // loop through jobs files
        foreach($job_array['files'] as $fileid => $csv_filename){
            
            // establish file ID value - if a single file is in use or free edition we do not append a value
            if($wtgcsv_is_free || $job_file_group == 'single'){$mod_append = '';}else{$mod_append = $fileid;}
            
            // add file modification time column for each file, do not append $fileid for single file jobs
            /**
            * wtgcsv_filemod(ID) - the CSV files last checked modification
            * wtgcsv_filedone(ID) - boolean true or false, indicates if the row has been update using specific file (with ID)
            */      
            $table .= "
            `wtgcsv_filemoddate".$mod_append."` datetime default NULL COMMENT '',
            `wtgcsv_filedone".$mod_append."` text default NULL COMMENT '',";

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
    $table .= "PRIMARY KEY  (`wtgcsv_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table created by Wordpress CSV Importer';";
    
    global $wpdb;        
    $createresult1 = $wpdb->query( $table );

    if( $createresult1 ){
        // update the job table array - it is simple a record of the tables creating for jobs for tracing then deleting them
        wtgcsv_add_jobtable('wtgcsv_' . $jobcode);  
        return true; 
    }else{
        wtgcsv_notice('SQL Query failed. The query itself should be studied, please submit it to support if you
        require assistance:<br /><br />' . wtgcsv_sql_formatter($table),'error','Large','','','echo','');
        return false;
    }        
}


/**
 * Returns a cleaned string so that it is suitable to be used as an SQL column name
 * @param string $column (characters removed = , / \ . - # _ and spaces)
 */
function wtgcsv_cleansqlcolumnname( $column ){
    global $wpdb;
    return str_replace( array( ",","/","'\'"," ",".",'-','#','_'),"", strtolower($column) );
} 

/**
 * Checks if a database table name exists or not
 * @global array $wpdb
 * @param string $table_name
 * @return boolean, true if table found, else if table does not exist
 */
function wtgcsv_does_table_exist( $table_name ){
    global $wpdb;
    if( $wpdb->query("SHOW TABLES LIKE '".$table_name."'") ){return true;}else{return false;}
}

/**
* Returns all tables from the Wordpress blogs database
* @returns direct result of query SHOW TABLES FROM
*/
function wtgcsv_sql_get_tables(){
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
function wtgcsv_sql_get_tablecolumns($t,$return_array = false,$columns_only = false){
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
function wtgcsv_sql_is_categorywithparent( $category_term,$parent_id ){
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
function wtgcsv_sql_formatter($sql_query){
    return $sql_query;    
}
?>
