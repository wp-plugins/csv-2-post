<?php 
################################################################
#                                                              #
#             SQL CSV 2 POST CORE FUNCTIONS ONLY               #
#             if the function contains "csv2post"              #                                             #
################################################################
/**
* Creates a new record in giving table, ready for updating with CSV file data. 
*/
function csv2post_WP_SQL_insert_new_record( $table_name,$csvfile_modtime ){
    global $wpdb;
    $wpdb->query( "INSERT INTO `".$table_name."` (csv2post_postid) VALUES (0)" );
    return $wpdb->insert_id;
}

/**
* Get the record used to create a post using Wordpress post ID
* @returns ARRAY_A if record found else false if record could not be found or failure
*/
function csv2post_WP_SQL_get_posts_record($main_table,$post_id,$project_array = false){

    global $wpdb,$csv2post_is_free;

    $query = 'SELECT * FROM ' . $main_table . ' WHERE csv2post_postid = ' . $post_id;
    
    /*  TODO:MEDIUMPRIORITY, still to add multiple table support
    $tables_added_count = 0;
    foreach($project_tables as $key => $table_name){
        
        if($tables_added_count != 0){
            $query .= ',';    
        }
        
        $query .= $table_name;    
                                
        ++$tables_added_count;    
    }
    
    
      */

    $query .= ' LIMIT 1';  
    
    return $wpdb->get_results( $query,ARRAY_A ); 
}

/**
* Counts the number of available templates
* 
* @param string $template_type postcontent,customfieldvalue,categorydescription,postexcerpt,keywordstring,dynamicwidgetcontent
* @todo HIGHPRIORITY, filter out none category description templates
*/
function csv2post_WP_SQL_count_posts_type($template_type){
    // post query argument for get_posts function
    $args = array(
        'post_type' => 'wtgcsvcontent'
    );

    global $post;
    $myposts = get_posts( $args );
    return count($myposts);      
}  
             
/**
* Queries a projects database table for giving posts linked record, last update value
* 1. Always queries the main project table, if main table not set in project array then defaults to the first in tables array 
* 2. Only returns record date record was last update
* 
* @returns the date value from csv2post_updated else returns false on table not existing or record not found
* @todo LOWPRIORITY, is this function not meant to be in paid edition folder only?
*/
function csv2post_WP_SQL_records_last_update($project_code,$post_id){
    // establish main project table
    $main_table = csv2post_get_project_maintable($project_code);
    // ensure user has not manually deleted table 
    $table_exist = csv2post_WP_SQL_does_table_exist($main_table);
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
* Update database table record with details of the post that was created using the record.
* This is the basic function provided in free edition. 
* 
* @returns result of wp_update_post(), could be WP_Error or post ID or false
*/
function csv2post_WP_SQL_update_project_databasetable_basic($record_id,$post_id,$table_name){
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
function csv2post_WP_SQL_update_project_databasetable_applied($post_id,$table_name){
    global $wpdb;                  
    $result = $wpdb->query('UPDATE '. $table_name .'                       
    SET csv2post_applied = NOW()                            
    WHERE csv2post_id = '.$post_id.'');   
    return $result;
}  

/**
* Function is for use when creating sub-pages
* 
* @param mixed $table_name
* @param mixed $levcol_name column name that holds level numbers
* @param mixed $level the level to be queried i.e. all level 2 page records
* @return array
*/
function csv2post_WP_SQL_unusedrecords_singletable_subpagelevels($table_name,$levcol_name,$level = 1){
    global $wpdb,$csv2post_is_free;
    
    // ensure user has not manually deleted table 
    $table_exist = csv2post_WP_SQL_does_table_exist($table_name);
    if(!$table_exist){
        ### TODO:HIGHPRIORITY, log this
        return false;
    }                          

    return $wpdb->get_results( 'SELECT * 
    FROM '. $table_name .' 
    WHERE csv2post_postid 
    IS NULL OR csv2post_postid = 0
    AND '.$levcol_name.' = '.$level,ARRAY_A );    
}                                                                                                                                                                              

    
/**
* Query a single project table records which have not been used.
* 
* @param string $table_name
*/
function csv2post_WP_SQL_unusedrecords_singletable($table_name,$posts_target = '1'){
    global $wpdb,$csv2post_is_free;
    
    // ensure user has not manually deleted table 
    $table_exist = csv2post_WP_SQL_does_table_exist($table_name);
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
* Returns the number of rows imported for a giving database table and also the giving file.
* Required in multi-file jobs
*/
function csv2post_WP_SQL_count_records_forfile( $tablename,$csvfile_name,$csvfile_id,$file_grouping = 'single' ){
    global $wpdb,$csv2post_is_free;
    
    // no file id is to be applied if free edition or single file project, projects only have a single file
    if($csv2post_is_free || $file_grouping == 'single'){$csvfile_id = '';}
    
    $query = "SELECT COUNT(*) FROM ". $tablename . " WHERE csv2post_filedone".$csvfile_id." = 1";
    $records = $wpdb->get_var( $query );
    if( $records ){return $records;}else{return '0';}   
}

/**
* SELECT query to check if a rows record has already been prepared for updating too.
* This function is only required for multi-file data import jobs
* 
* @param mixed $table_name
*/
function csv2post_WP_SQL_row_id_check($table_name,$id){
    global $wpdb;
    $query = "SELECT COUNT(*) FROM ". $table_name . " WHERE csv2post_id = ".$id.";";
    $records = $wpdb->get_var( $query );
    if( $records != false && $records != 0 && $records != csv2post_is_WP_Error($records) ){return true;}else{return false;}      
}

/**
 * Builds and executes a MySQL UPATE query
 * The WHERE part is simple in this query, it uses a single value, usually record ID to apply the update. 
 */
function csv2post_WP_SQL_update_record( $row, $csvfile_name, $column_total, $jobcode, $record_id, $header_array, $filegrouping){        
    global $csv2post_is_free;
    
    $jobarray = csv2post_get_dataimportjob($jobcode);
    
    // establish csv file id - if free edition there is no file id
    if($csv2post_is_free || $filegrouping == 'single'){
        $file_id = '';    
    }else{
        $file_id = csv2post_get_csvfile_id($csvfile_name,$jobcode);;
    }    

    // start SET data part of query
    $set = ' SET csv2post_imported = NOW(),csv2post_filedone'.$file_id.' = 1';

    // start where part of query
    $where = ' WHERE csv2post_id = "' . $record_id .'"';
    
    // count how many keys are used
    $keysused = 0;      
    $col = 0;                 
    foreach( $header_array as $header_key => $header ){
        
        if($csv2post_is_free){
            $row[$col] = csv2post_data_prep_fromcsvfile($row[$col]);
        }else{
            $row[$col] = csv2post_data_prep_fromcsvfile_advanced($jobarray,$row[$col],$header['sql']);
        }
        
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
* Create the table for a data import job, table is named using job code
* 
* @param mixed $jobcode, used to create table name
* @param mixed $job_file_group, single or multiple, used to decide if column names should get appended number or not
* @param boolean $maintableonly, default false - if true a project table is required, only project columns added
* 
* @todo is csv2post_changed column in use? if not remove it
*/
function csv2post_WP_SQL_create_dataimportjob_table($jobcode,$job_file_group,$maintableonly = false){
    global $csv2post_is_free;

    /**
    * csv2post_id          - record id within data table, not imported id
    * csv2post_postid      - if record used to make post, this is the wordpress post id
    * csv2post_postcontent - where required, post content will also be stored
    * csv2post_inuse       - boolean, false means the record is not to be used for whatever reason
    * csv2post_imported    - date of first import of row from csv file, not the last update
    * csv2post_updated     - date a newer row was imported from csv file and updated the record
    * csv2post_changed     - latest date that the plugin auto changed or user manually changed values in record
    * csv2post_applied     - last date and time the record was applied to its post
    * csv2post_filetime    - csv file datestamp when record imported, can then be compared against a newer file to trigger updates
    * csv2post_catid       - categord id i.e. 23,24,25. Added Feb 2013
    * 
    * Update Webpage
    * http://www.webtechglobal.co.uk/hacking/post-creation-project-database-tables
    * 
    * Update Functions
    * csv2post_is_csv2post_postprojecttable()
    */
    
    // CREATE TABLE beginning
    $table = "CREATE TABLE `csv2post_". $jobcode ."` (
    `csv2post_id` int(10) unsigned NOT NULL auto_increment,
    `csv2post_postid` int(10) unsigned default NULL,
    `csv2post_postcontent` int(10) unsigned default NULL,
    `csv2post_inuse` int(10) unsigned default NULL,
    `csv2post_imported` datetime NOT NULL,
    `csv2post_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `csv2post_changed` datetime NOT NULL,
    `csv2post_applied` datetime NOT NULL,
    `csv2post_catid` text default NULL,";

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
            `csv2post_filemoddate".$mod_append."` datetime default NULL,
            `csv2post_filedone".$mod_append."` text default NULL,";

            // loop through each files set of headers (3 entries in array per header)
            foreach( $job_array[$csv_filename]['headers'] as $header_key => $header){
                
                // is header null, this indicates incorrect separator/quote/column number entered
                if($header['sql'] == NULL || $header['sql'] == '' || $header['sql'] == ' '){
                    csv2post_notice('An incorrect separator, Enclosure Character or the number of columns has been
                    entered for your file. A blank/empty header was found. Please ensure the correct values are
                    submitted and that your CSV file does not actually have a column with no text in the header/title.',
                    'error','Large','Blank Header Detected','http://www.webtechglobal.co.uk/notifications/database-query-failure-on-creating-data-import-job','echo','');
                    return false;    
                }
                
                // if this is a single file job, do not append number
                if($job_file_group == 'single'){
                    $column_name = $header['sql'];
                }else{
                    $column_name = $header['sql_adapted'];// has appended number based on the order of all files
                }
                
                $table .= "
                `" . $column_name . "` text default NULL,";                                                                                                              
            }

            ++$fileid;
        }
    }
    
    // add special data prep columns that the user can make use of
    $table .= " 
    `splitcat1` text default NULL,
    `splitcat2` text default NULL,
    `splitcat3` text default NULL,
    `splitcat4` text default NULL,
    `splitcat5` text default NULL,";
    
    // end of table
    ### TODO:CRITICAL, create setting for user to configure CHARSET
    $table .= "PRIMARY KEY  (`csv2post_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table created by CSV 2 POST';";
            
    global $wpdb;        
    $createresult1 = $wpdb->query( $table );

    if( $createresult1 ){
        // update the job table array - it is simple a record of the tables creating for jobs for tracing then deleting them
        csv2post_add_jobtable('csv2post_' . $jobcode);  
        return true; 
    }else{
        csv2post_notice('Database query not correct. Usually this is due to incorrect Separator/Delimiter, Enclosure Character or number of 
        columns for your CSV file being wrong. 50% of the time this is caused by an extra separator (comma)
        in the header row which causes a blank column and MySQL cannot accept a blank header in the column. Here is your query, feel
        free to send it to us along with your CSV file for advice:<br /><br />' . csv2post_WP_SQL_formatter($table),
        'error','Small','Possible Incorrect Separator or Enclosure Character','http://www.webtechglobal.co.uk/notifications/database-query-failure-on-creating-data-import-job','echo','');
        return false;
    }        
}

/**
* Updates empty premade record in data job table using CSV file row.
* Reports errors to server log.
* 
* @returns boolean, true if an update was done with success else returns false
* 
* @param mixed $record
* @param mixed $csvfile_name
* @param mixed $fields
* @param mixed $jobcode
* @param mixed $record_id
* @param mixed $headers_array
*/
function csv2post_WP_SQL_update_record_dataimportjob( $record, $csvfile_name, $fields, $jobcode,$record_id, $headers_array,$filegrouping ){
    global $csv2post_plugintitle;
    // using new record id - update the record
    $updaterecord_result = csv2post_WP_SQL_update_record( $record, $csvfile_name, $fields, $jobcode,$record_id, $headers_array, $filegrouping );
    // increase $inserted counter if the update was a success, the full process counts as a new inserted record            
    if($updaterecord_result === false){
        csv2post_error_log($csv2post_plugintitle . ': csv2post_WP_SQL_update_record() returned FALSE for JOB:'.$jobcode.' FILE:'.$csvfile_name.'. Please investigate.');                
        return false;
    }elseif($updaterecord_result === 1){ 
        return true;  
    }elseif($updaterecord_result === 0){
        csv2post_error_log($csv2post_plugintitle . ': csv2post_WP_SQL_update_record() returned 0 for JOB:'.$jobcode.' FILE:'.$csvfile_name.'. Please investigate.');
        return false;
    }  
}

/**
* Query post creation project database table for used records (those with csv2post_postid populated)
* 
* @param string $table_name, must be a project table i.e. $project_array['maintable']
* @param numeric $number_of_records, records requested (pass 9999999 for all records), set at 1 by default to avoid over processing by mistake
*/
function csv2post_WP_SQL_used_records($table_name,$number_of_records = 1,$select = '*'){
    global $wpdb;
    
    // ensure user has not manually deleted table 
    $table_exist = csv2post_WP_SQL_does_table_exist($table_name);
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
* @param boolean $reset_posts, true will cause posts to be deleted also
* 
* @todo LOWPRIORITY, create a setting for user to force deletion (no trash) when deleting posts
*/
function csv2post_WP_SQL_reset_project_table($table_name,$reset_posts){
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
* Drops a database table created for using with data import job.
* Also updates the data import job tables array $csv2post_jobtable_array
* 1. A check should be done prior to calling this function to determine if table is in use
* 
* @param mixed $table_name
*/
function csv2post_SQL_drop_dataimportjob_table($table_name){
    global $wpdb,$csv2post_jobtable_array,$csv2post_dataimportjobs_array;
    
    ### TODO:LOWPRIORITY, put statement in here to handle failed DROP TABLE should user attempt to drop none existing tables
    $wpdb->query( 'DROP TABLE '. $table_name );
    
    // remove table from $csv2post_jobtable_array
    if(is_array($csv2post_jobtable_array)){
        foreach($csv2post_jobtable_array as $key => $jobtable_name){
            if($table_name == $jobtable_name){
                unset($csv2post_jobtable_array[ $key ]);
                csv2post_update_option_jobtables_array($csv2post_jobtable_array);
                break;
            }
        } 
    }                          
}      

/**
* Resets the project record that has the giving post id in the csv2post_postid column
*/
function csv2post_WP_SQL_reset_project_record($post_ID,$table_name){
    global $wpdb;
    if(isset($post_ID) && isset($table_name)){
        $wpdb->query(
            '
                UPDATE ' . $table_name .' 
                SET csv2post_postid = 0 
                WHERE csv2post_postid = '.$post_ID
        );
    }        
}

/**
* Creates the string after SET in an UPDATE query.
* 
* @param array $rec
* @param array $source_columns_array
* @param array $dest_columns_array
*/
function csv2post_WP_SQL_create_updateset_string($record,$source_columns_array,$dest_columns_array){
    $set_string = '';
    $comma = false;
    // loop through source columns
    foreach($dest_columns_array as $key => $d_col){
        if($comma == true){
            $set_string .= ', ';
        }
        $set_string .= $d_col . "= '".mysql_real_escape_string($record->$source_columns_array[$key])."'";
        $comma = true;    
    }
    return $set_string;
}

function csv2post_SQL_get_posts_oudated($project_modified,$project_code,$limit = 1,$select = '*'){
    global $wpdb;
    $q = "SELECT wposts.ID 
    FROM ".$wpdb->posts." wposts, ".$wpdb->postmeta." metaprojectcode, ".$wpdb->postmeta." metaupdated 
    WHERE wposts.ID = metaprojectcode.post_id 
    AND wposts.ID = metaupdated.post_id 
    AND (metaprojectcode.meta_key = 'csv2post_project_code' AND metaprojectcode.meta_value = '".$project_code."') 
    AND (metaupdated.meta_key = 'csv2post_last_update') 
    AND (metaupdated.meta_value < '".$project_modified."')
    LIMIT 1";       
    return $wpdb->get_results($q, OBJECT);
}
 
/**
* Update csv2post_catid column.
* 1. Update with a single category ID if post to be assigned to last category
* 2. Update with string of ID's if post to have multiple categories
* 
* @param mixed $pro_table
* @param mixed $col_name
* @param mixed $cat_name 
* @param mixed $cat_id
* @param mixed $lev the level being applied, tells script to append or not
* 
* @returns number of rows effected
*/
function csv2post_WP_SQL_categories_updateIDs($table_name,$cat_IDs,$record_id){
    global $wpdb; 
    return $wpdb->query('UPDATE '. $table_name .' 
    SET csv2post_catid = "'.$cat_IDs.'"
    WHERE csv2post_id = '.$record_id.'');      
}
    
function csv2post_WP_SQL_categories_resetIDs($table_name,$cat_IDs){
    global $wpdb; 
    return $wpdb->query('UPDATE '. $table_name .' 
    SET csv2post_catid = NULL
    WHERE csv2post_catid = "'.$cat_IDs.'"');      
}

/**
* Select all from csv2post_catid in the giving table
*/
function csv2post_WP_SQL_select_catidcolumn($table_name){
    global $wpdb;  
    return $wpdb->get_results( 'SELECT csv2post_catid,csv2post_id 
    FROM '.$table_name,ARRAY_A);      
}

/**
* Gets all categories data for all categories column based on the
* current projects category settings.
* 1. Returns every row - must take matching cat names with different parents into consideration
* 
* OUTPUT TYPE
* One of three pre-defined constants. Defaults to OBJECT.
* OBJECT - result will be output as an object.
* ARRAY_A - result will be output as an associative array.
* ARRAY_N - result will be output as a numerically indexed array.
* 
* @param mixed $table_name
* @return array
*/
function csv2post_SQL_categoriesdata_onelevel_advanced($table_name,$column_name){
    global $wpdb,$csv2post_project_array;

    // ensure user has not manually deleted table 
    $table_exist = csv2post_WP_SQL_does_table_exist($table_name);
    if(!$table_exist){
        return false;
    }

    return $wpdb->get_results('
        
        SELECT '.$column_name.',csv2post_catid,csv2post_id 
        FROM '.$table_name
        
    ,ARRAY_A);     
}
?>