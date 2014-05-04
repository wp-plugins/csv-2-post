<?php
/** 
* Wordpress database interaction covering common queries
* 
* @package CSV 2 POST
* 
* @version 0.0.1
* 
* @since 8.0.0
* 
* @author Ryan Bayne 
*/

class C2P_WPDB extends C2P_UpdatePlugin {
    function  __construct(){
        
    }
    function C2P_WPDB(){
        
    }
    public function selectrow($tablename, $condition, $select = '*'){
        global $wpdb;

        if(empty($condition))
        {
            return null;
        }
        return $wpdb->get_row("SELECT $select FROM $tablename WHERE $condition", OBJECT);
    }
    /**
    * SELECT (optional WHERE) query returning OBJECT
    * 
    * @param mixed $tablename
    * @param mixed $condition
    * @param mixed $orderby
    * @param mixed $select
    * @param mixed $limit
    */
    public function selectorderby($tablename, $condition=null, $orderby=null, $select = '*', $limit = ''){
        global $wpdb;
        $condition = empty ($condition)? '' : ' WHERE ' . $condition;
        $condition .= empty($orderby)? '': ' ORDER BY ' . $orderby;
        if(!empty($limit)){$limit = 'LIMIT ' . $limit;}
        return $wpdb->get_results("SELECT $select FROM $tablename $condition $limit", OBJECT);
    }
    /**
    * SELECT (optional WHERE) query returning any passed object
    * 
    * @param mixed $tablename
    * @param mixed $condition
    * @param mixed $orderby
    * @param mixed $select
    */
    public function selectwherearray($tablename, $condition=null, $orderby=null, $select = '*',$object = 'ARRAY_A'){
        global $wpdb;
        $condition = empty ($condition)? '' : ' WHERE ' . $condition;
        $condition .= empty($orderby)? '': ' ORDER BY ' . $orderby;
        return $wpdb->get_results("SELECT $select FROM $tablename $condition ", $object);
    } 
    /**
    * insert a new row to any table
    * 
    * @param string $tablename
    * @param array $fields
    */
    public function insert($tablename, $fields){
        global $wpdb;
        $fieldss = '';
        $valuess = '';
        $first = true;
        foreach($fields as $field=>$value)
        {
             if($first)
                $first = false;
             else
             {
                $fieldss .= ' , ';
                $valuess .= ' , ';
             }
             $fieldss .= " `$field` ";
             $valuess .= " '" .$wpdb->escape($value)."' ";
        }

        $query = " INSERT INTO $tablename ($fieldss) VALUES ($valuess)";

        $wpdb->query($query);
        return $wpdb->insert_id;
    }
    public function update($tablename, $condition, $fields){
        global $wpdb;
        $query = " UPDATE $tablename SET ";
        $first = true;
        foreach($fields as $field=>$value)
        {
            if($first) $first = false; else $query .= ' , ';
            $query .= " `$field` = '" . $wpdb->escape($value) ."' ";
        }

        $query .= empty($condition)? '': " WHERE $condition ";
        return $wpdb->query($query);
    }   
    public function delete($tablename, $condition){
        global $wpdb;
        return $wpdb->query("DELETE FROM $tablename WHERE $condition ");
    }
    public function count_rows($tablename,$where = ''){
        global $wpdb;
        return $wpdb->get_var( "SELECT COUNT(*) FROM $tablename" . $where );
    }    
    public function get_value($columns,$tablename,$conditions){
        global $wpdb;
        return $wpdb->get_var( "SELECT $columns FROM $tablename WHERE $conditions" );
    }  
    /**
    * Gets posts with the giving meta value
    * 
    * @param mixed $meta_key
    * @param mixed $meta_value
    * @param mixed $limit
    * @param mixed $select add table reference wpostmeta if adding meta table columns to select
    * @param mixed $where begin string with AND
    * @param mixed $querytype
    */
    public function get_posts_join_meta($meta_key,$meta_value,$limit = 1,$select = '*',$where = '',$querytype = 'get_results'){
        global $wpdb;
        
        $q = "SELECT wposts.".$select."
        FROM ".$wpdb->posts." AS wposts
        INNER JOIN ".$wpdb->postmeta." AS wpostmeta
        ON wpostmeta.post_id = wposts.ID
        AND wpostmeta.meta_key = '".$meta_key."'                                                 
        AND wpostmeta.meta_value = '".$meta_value."' 
        ".$where."
        LIMIT ".$limit."";
     
        if($querytype == 'query'){
            $result = $wpdb->query($q);    
        }elseif($querytype == 'get_var'){
            $result = $wpdb->get_var($q);        
        }else{
            $result = $wpdb->get_results($q, OBJECT);    
        }
        
        return $result;
    }
    /**
    * Function for validating values
    * @access private
    */
    function _sql_validate_value($var){
        if (is_null($var))
        {
            return 'NULL';
        }
        else if (is_string($var))
        {
            return "'" . $this->sql_escape($var) . "'";
        }
        else
        {
            return (is_bool($var)) ? intval($var) : $var;
        }
    }    
    /**
    * Build sql statement from array for insert/update/select statements
    *
    * Idea for this from Ikonboard
    * Possible query values: INSERT, INSERT_SELECT, UPDATE, SELECT
    *
    */
    public function sql_build_array($query, $assoc_ary = false){
        if (!is_array($assoc_ary)){
            return false;
        }

        $fields = $values = array();

        if ($query == 'INSERT' || $query == 'INSERT_SELECT')
        {
            foreach ($assoc_ary as $key => $var)
            {
                $fields[] = $key;

                if (is_array($var) && is_string($var[0]))
                {
                    // This is used for INSERT_SELECT(s)
                    $values[] = $var[0];
                }
                else
                {
                    $values[] = $this->_sql_validate_value($var);
                }
            }

            $query = ($query == 'INSERT') ? ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')' : ' (' . implode(', ', $fields) . ') SELECT ' . implode(', ', $values) . ' ';
        }
        else if ($query == 'UPDATE' || $query == 'SELECT')
        {
            $values = array();
            foreach ($assoc_ary as $key => $var)
            {
                $values[] = "$key = " . $this->_sql_validate_value($var);
            }
            $query = implode(($query == 'UPDATE') ? ', ' : ' AND ', $values);
        }

        return $query;
    }    
    /**
    * Uses get_results and finds all DISTINCT meta_keys, returns the result.
    * Currently does not have any measure to ensure keys are custom field only.
    */
    public function customfield_keys_distinct(){
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
    public function metakeys_distinct(){
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
     * counts total records in giving project table
     * @return 0 on fail or no records or the number of records in table
     */
    public function countrecords( $table_name,$where = '' ){
        global $wpdb;
        $records = $wpdb->get_var( 
            "
                SELECT COUNT(*) 
                FROM ". $table_name . "
                ".$where." 
            "
        );
        
        if( $records ){
            return $records;
        }else{
            return '0';
        }    
    }
    /**
    * Returns SQL query result of all option records in Wordpress options table that begin with the giving 
    */
    public function options_beginning_with($prependvalue){    
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
    public function post_exist_byid($id){
        global $wpdb;
        return $wpdb->get_row("SELECT post_title FROM $wpdb->posts WHERE id = '" . $id . "'", 'ARRAY_A');    
    }
    /**
     * Checks if a database table name exists or not
     * 1. One issue with this function is that Wordpress treats the lack of tables existence as an error
     * 2. Another approach is using csv2post_WP_SQL_get_tables() and checking the array for the table, this is error free
     * 
     * @global array $wpdb
     * @param string $table_name
     * @return boolean, true if table found, else if table does not exist
     */
    public function does_table_exist( $table_name ){
        global $wpdb;                                      
        if( $wpdb->query("SHOW TABLES LIKE '".$table_name."'") ){return true;}else{return false;}
    }
    /**
     * Checks if a database table exist
     * @param string $table_name (possible database table name)
     */
    public function database_table_exist( $table_name ){
        global $wpdb;
        if( $wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") != $table_name) {     
            return false;
        }else{
            return true;
        }
    }
    /**
    * Returns array of tables from the Wordpress database
    * @returns array $tables_array
    */
    public function get_tables(){
        global $wpdb;
        $result = mysql_query("SHOW TABLES FROM `".$wpdb->dbname."`");
        if(!$result){return false;}
        $tables_array = array();
        while ($row = mysql_fetch_row($result)) {
            $tables_array[] = $row[0];
        }        
        return $tables_array;
    }
    /**
    * Returns an array holding the column names for the giving table
    * 
    * @param mixed $return_array [false] = mysql result [true] = array of the result
    * @param mixed $columns_only true will not return column information
    * @return array or mysql result or false on failure
    * 
    * @todo get_col_info() may not be the correct function to use here as it is to be used on a recent query only
    * @todo this method could be reduced by using the foreach loop once and everything within it 
    */
    public function get_tablecolumns($table_name,$return_array = false,$columns_only = false){
        global $wpdb,$C2P_WP;
                    
        // an array is required - what data is required in the array...    
        if($return_array == true && $columns_only == false){// return an array holding ALL info
            $columns_array = array();              
            foreach ( $wpdb->get_col_info( "DESC " . $table_name, 0 ) as $column_details ) {
                $columns_array[] = $column_details;
            }
            
            return $columns_array;
                            
        }elseif($return_array == true && $columns_only == true){# return an array of column names only
            $columns_array = array();
            foreach ( $wpdb->get_col( "DESC " . $table_name, 0 ) as $column_name ) {
                $columns_array[] = $column_name;
            }
            
            return $columns_array;  
        }elseif($return_array == false){
            $columns_string = '';
            foreach ( $wpdb->get_col( "DESC " . $table_name, 0 ) as $column_name ) {
                $columns_string .= $column_name . ',';
            }    
            $columns_string = rtrim($columns_string, ",");
            return $columns_string;        
        }   
    }
    /**
    * Checks if a category already exists with the giving parent.
    * 
    * @param mixed $cat_encoded
    * @param mixed $parent
    * @return mixed
    */
    public function is_categorywithparent( $category_term,$parent_id ){
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
    * Drops the giving database table and displays result in notice 
    * 
    * @param mixed $table_name
    */
    public function drop_table($table_name){
        global $wpdb,$C2P_WP;
        $r = $wpdb->query("DROP TABLE IF EXISTS ".$table_name."");
        if( $r ){
            $C2P_WP->notice_depreciated(sprintf(__('Database table named %s has been deleted.','csv2post'),$table_name),'success','Tiny','','','echo');
        }else{
            $C2P_WP->notice_depreciated(sprintf(__('Database table named %s has already been deleted.','csv2post'),$table_name),'error','Tiny','','','echo');
        }    
    }
    /**
    * Mass change one key name to another
    * 
    * @param mixed $old_key
    * @param mixed $new_key
    */
    public function update_meta_key( $old_key = NULL, $new_key = NULL ){
        global $wpdb;
        
        $results = $wpdb->get_results( 
            "
                UPDATE ".$wpdb->prefix."postmeta 
                SET meta_key = '".$new_key."' 
                WHERE meta_key = '".$old_key."'
            "
        , ARRAY_A );
        return $results;
    }
    public function log_queryactions(){
        global $wpdb;    
        return $wpdb->get_results( 'SELECT DISTINCT action FROM '.$wpdb->prefix.'c2plog',ARRAY_A );    
    }
    /**
    * Queries distinct values in a giving column
    * @returns array of distinct values or 0 if no records or false if none 
    */
    public function column_distinctvalues($table_name,$column_name){
        global $wpdb;
        $distinct_values_found = $wpdb->get_results( "SELECT DISTINCT ".$column_name." FROM ". $table_name . ";",ARRAY_A );
                
        if(!$distinct_values_found){
            return 0;
        }else{
            return $distinct_values_found;        
        }  
        
        return false;                      
    }
    /**
    * get posts based on comment count.
    * 1. if using range and wish to include posts with a single comment then pass 0 as the minimum due to sql argument using > only
    * 
    * @param mixed $comment_count_low
    * @param mixed $comment_count_high
    * @param mixed $post_type
    * @param mixed $post_status
    * @param mixed $output
    */
    public function query_posts_by_comments($comment_count_low = 0,$comment_count_high = 9999,$post_type = 'post',$post_status = 'publish',$output = 'OBJECT'){
        global $wpdb;
        $query = "
            SELECT *
            FROM {$wpdb->prefix}posts
            WHERE {$wpdb->prefix}posts.post_type = '{$post_type}'
            AND {$wpdb->prefix}posts.post_status = '{$post_status}'
            ";
        
        // if low and high are not zero we add a range to the query
        if($comment_count_low == 0 && $comment_count_high == 0)
        {
            $query .= "AND {$wpdb->prefix}posts.comment_count = 0";    
        }    
        else
        {
            $query .= "AND {$wpdb->prefix}posts.comment_count > {$comment_count_low}
            AND {$wpdb->prefix}posts.comment_count <= {$comment_count_high}";
        }
        
        $query .= "
        ORDER BY {$wpdb->prefix}posts.post_date
        DESC;
        ";

        return $wpdb->get_results($query,$output);        
    }
    /**
    * query multiple database tables, assumed to have a data set and shared key column which is required for JOIN to work
    * 
    * @param mixed $tables_array
    * @param mixed $idcolumn
    * @param mixed $where
    */
    public function query_multipletables($tables_array = array(),$where = false,$total = false){
        global $wpdb;
                                  
        if(!is_array($tables_array)){return false;}
 
        // set the main table with primary key
        $main_table = $tables_array[0];
        
        // build select
        $select = '';
        foreach($tables_array as $key => $table_name){
            
            // add comma for the next table being added
            if($key > 0){$select .= ',';}
            
            // we join the current table to the main table based on giving ID column
            $select .= "$table_name.*";          
        }        

        // build JOIN - will be done in premium, free will keep it simple with one table intended
        $join = '';

        // build limit
        $limit = '';
        if(is_numeric($total)){$limit = "LIMIT $total";}
        
        // build where
        $wherepart = '';
        if($where !== false && is_string($where)){$wherepart = "WHERE $where";}
        
        $final_query = "SELECT $select FROM $main_table $wherepart $join $limit";

        // build where
        return $wpdb->get_results($final_query, ARRAY_A);
    }
}// end class C2P_WPDB
?>