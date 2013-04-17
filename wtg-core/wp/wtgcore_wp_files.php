<?php
/**
* Function not in use yet and not complete COMMENT IT FULLY
* 
* @param mixed $table_name
*/
function csv2post_csvfile_download_export_databasettable($table_name){
 
    global $wpdb;

    $result = $wpdb->get_results( "SELECT * FROM ".$table_name."" );
    $requestedTable = mysql_query("SELECT * FROM ".$table_name."" );
    $fieldsCount = mysql_num_fields($requestedTable);

    for($i=0; $i<$fieldsCount; $i++){
        $field = mysql_fetch_field($requestedTable);
        $field = (object) $field;         
        $getField .= $field->name.',';
    }
    
    $sub = substr_replace($getField, '', -1);
    $fields = $sub; # GET FIELDS NAME
    $each_field = explode(',', $sub);        
    $csv_file_name = 'finishedsessions_'.date('Ymd_His').'.csv';
    
    # GET FIELDS VALUES WITH LAST COMMA EXCLUDED
    foreach($result as $row){
        
        for($j = 0; $j < $fieldsCount; $j++){
            if($j == 0) $fields .= "\n"; # FORCE NEW LINE IF LOOP COMPLETE
            $value = str_replace(array("\n", "\n\r", "\r\n", "\r"), "\t", $row->$each_field[$j]); # REPLACE NEW LINE WITH TAB
            $value = str_getcsv ( $value , ",", "\"" , "\\"); # SEQUENCING DATA IN CSV FORMAT, REQUIRED PHP >= 5.3.0
            $fields .= $value[0].','; # SEPARATING FIELDS WITH COMMA
        }            
        $fields = substr_replace($fields, '', -1); # REMOVE EXTRA SPACE AT STRING END
    }
    
    header("Content-type: text/x-csv"); # DECLARING FILE TYPE
    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: attachment; filename=".$csv_file_name); # EXPORT GENERATED CSV FILE
    header("Pragma: no-cache");
    header("Expires: 0");

    echo $fields;
    exit;
} 

/**
 * Formats number to a size for interface display, usually bytes returned from checking a file size
 * @param integer $size
 */
function csv2post_format_file_size($size) {
      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      if ($size == 0) { 
          return('n/a'); 
      } else {
          return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); 
      }
}  

/**
 * Returns cleaned string for use as filename - we remove all characters for the sake of shortenening
 * @param string $filename
 */
function csv2post_cleanfilename( $filename ){
    $remove_these = array('-','_',' ',')','(',);
    $filename = str_replace ( $remove_these , '' ,  $filename );
    return $filename;
}
        
/**
 * Counts rows in CSV file and returns (does no include header row)
 * @uses eci_csvfileexists
 * @param filename $filename
 * @param array $pro
 */
function csv2post_count_csvfilerows($csvfile_name){    
    return count(file(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name)) - 1;
}

/**
* Counts separator characters per row, compares total over all rows counted to determine probably Separator
* 
* @param mixed $csv_filename
* @param mixed $output
* 
* @todo LOWPRIORITY, add further checks when the difference between two counts is not great, is it possible to ignore the needles with quotes around them? Maybe ignore columns with large text values
*/
function csv2post_establish_csvfile_separator_fgetmethod($csv_filename, $output = false ){
    
    $probable_separator = ','; 
    
    if (($handle = fopen(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_filename, "r")) !== FALSE) {
        
        $probable_separator = ',';
        
        // count Separators
        $comma_count = 0;
        $pipe_count = 0;
        $semicolon_count = 0;
        $colon_count = 0;          

        // one row at a time we will count each possible Separator
        while (($rowstring = fgets($handle, 4096)) !== false) {
            
            $comma_count = $comma_count + substr_count ( $rowstring , ',' );
            $pipe_count = $pipe_count + substr_count ( $rowstring , '|' );                    
            $semicolon_count = $semicolon_count + substr_count ( $rowstring , ';' );
            $colon_count = $colon_count + substr_count ( $rowstring , ':' ); 
                                
        }  
        
        if (!feof($handle)) {
            csv2post_notice('A failure happened with end-of-file function feof for '.$csv_filename.'. You may need to seek support if you want to use this CSV file.','success','error','Large','Test 1: Could Not Establish Separator Using fgets','','echo');    
        }
        fclose($handle);                
      
        $probable_separator = 'UNKNOWN';
        $probable_separator_name = 'UNKNOWN';
            
        // compare count results - comma
        if($comma_count > $pipe_count && $comma_count > $semicolon_count && $comma_count > $colon_count){
            
            $probable_separator = ',';
            $probable_separator_name = 'comma';
    
        }
        
        // pipe
        if($pipe_count > $comma_count && $pipe_count > $semicolon_count && $pipe_count > $colon_count){ 
            
            $probable_separator = '|';
            $probable_separator_name = 'pipe';
            
        }
        
        // semicolon
        if($semicolon_count > $comma_count && $semicolon_count > $pipe_count && $semicolon_count > $colon_count){
            
            $probable_separator = ';';
            $probable_separator_name = 'semicolon';
            
        }
        
        // colon
        if($colon_count > $comma_count && $colon_count > $pipe_count && $colon_count > $semicolon_count){
            
            $probable_separator = ':';
            $probable_separator_name = 'colon';
            
        }

        // display the result of output required
        if($output){
            csv2post_notice('Separator was established using method one, fgets. Established Separator is <strong>'.$probable_separator_name.' ( '.$probable_separator.' )</strong>','success','Large','Test 1: Established Separator Using fgets','','echo');       
        }
        
    }// if handle open for giving file
    
    return $probable_separator; 
}

/**
* Establishes CSV files separator character
* 
* @param mixed $csv_filename
* @param boolean $display, will cause more output to screen for user
* 
* @todo HIGHPRIORITY, complete function
*/
function csv2post_establish_csvfile_separator_PEARCSVmethod( $csv_filename,$output = false){
    //csv2post_pearcsv_include();
    $csv_file_conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_filename );

    // display the result of output required
    if(!$output){
        return $csv_file_conf['sep'];
    }elseif($output){

        if($csv_file_conf['sep'] == ','){
            
            $probable_separator = ',';
            $probable_separator_name = 'comma';
                
        }
        
        // pipe
        if($csv_file_conf['sep'] == '|'){ 
            
            $probable_separator = '|';
            $probable_separator_name = 'pipe';
            
        }
        
        // semicolon
        if($csv_file_conf['sep'] == ';'){
            
            $probable_separator = ';';
            $probable_separator_name = 'semicolon';
            
        }
        
        // colon
        if($csv_file_conf['sep'] == ':'){
            
            $probable_separator = ':';
            $probable_separator_name = 'colon';
            
        }        
        
        csv2post_notice('Separator was established using method two, PEAR CSV. Established Separator is <strong>'.$probable_separator_name.' ( '.$probable_separator.' )</strong>','success','Large','Test 2: Established Separator Using PEAR CSV','','echo');
    }
            
    return $csv_file_conf['sep'];          
} 

/**
* Establishes CSV files quote character
* 
* @param mixed $csv_filename
* @param boolean $display, will cause more output to screen for user
* 
* @todo HIGHPRIORITY, complete function
*/
function csv2post_establish_csvfile_quote_PEARCSVmethod( $csv_filename,$output = false){
    //csv2post_pearcsv_include();
    $csv_file_conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_filename );
           
    // display the result of output required
    if($output){
        
        $probable_quote = 'UNKNOWN';
        $probable_quote_name = 'UNKNOWN';
            
        // pear returns NULL
        if($csv_file_conf['quote'] == NULL){
            
            $probable_quote = '"';
            $probable_quote_name = 'double quote';
                
        }
        
        // double quote       
        if($csv_file_conf['quote'] == '"'){
            
            $probable_quote = '"';
            $probable_quote_name = 'double quote';
                
        }
        
        // single quote
        if($csv_file_conf['quote'] == "'"){ 
            
            $probable_quote = "'";
            $probable_quote_name = 'single quote';
            
        }

        csv2post_notice('Quote was established using PEAR CSV. Established quote is <strong>'.$probable_quote_name.' ( '.$probable_quote.' )</strong>','success','Large','Test 3: Established Quote','','echo');
    }
                    
    return $csv_file_conf['quote'];   
} 

/**
* Uses pear to establish the number of fields/columns in giving CSV file
* 
* @param mixed $csv_filename
* @return numeric on success or false on fail, possibly zero if PEAR fails
*/
function csv2post_establish_csvfile_fieldcount_PEAR($csv_filename){
    //csv2post_pearcsv_include();
    $csv_file_conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_filename );             
    return $csv_file_conf['fields'];   
} 

/**
* Returns array holding the headers of the giving filename
* It also prepares the array to hold other formats of the column headers in prepartion for the plugins various uses
*/
function csv2post_get_file_headers_formatted($csv_filename,$fileid,$separator = ',',$quote = '"',$fields = 0){

    $csv_file_conf = array();    
    $csv_file_conf['fields'] = $fields;    
    $csv_file_conf['sep'] = $separator;        
    $csv_file_conf['quote'] = $quote; 
            
    $header_array = array();

    // read and loop through the first row in the csv file    
    while ( ( $readone = File_CSV::read( WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_filename,$csv_file_conf ) ) ){                
               
        for ( $i = 0; $i < $csv_file_conf['fields']; $i++ ){
            $header_array[$i]['original'] = $readone[$i];
            $header_array[$i]['sql'] = csv2post_PHP_STRINGS_clean_sqlcolumnname($readone[$i]);// none adapted/original sql version of headers, could have duplicates with multi-file jobs
            $header_array[$i]['sql_adapted'] = csv2post_PHP_STRINGS_clean_sqlcolumnname($readone[$i]) . $fileid;// add files id to avoid duplicate header names              
        }           
        break;
    }
                        
    return $header_array;    
}

/**
* Returns established separator
* 
* @param string $csv_filename
* @param string $method, either PEAR or FGETCSV (not in use yet)
*/
function csv2post_get_file_separator($csv_filename){
    global $csv2post_csvmethod;
    $pearcsv_failed = false;
    
    if($csv2post_csvmethod == 0){
        //csv2post_pearcsv_include();
        
        $csv_file_conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_filename );
            
        if(!$csv_file_conf || !isset($csv_file_conf['sep']) || $csv_file_conf['sep'] == false){
            $pearcsv_failed = true;
        }else{
            return $csv_file_conf['sep'];
        }
    }
    
    // if method is 1 (fget without PEAR CSV) OR it is PEAR CSV but PEAR CSV failed
    if($pearcsv_failed == true || $csv2post_csvmethod == 1){
        return csv2post_establish_csvfile_separator_fgetmethod($csv_filename,false);    
    }   
}

/**
* Returns established quote
* 
* @param string $csv_filename
* @param string $method, PEAR or FGETCSV (not in use yet)
* @return string, should be a single character
*/
function csv2post_get_file_quote($csv_filename,$method = 'PEAR'){
    global $csv2post_csvmethod;
    $pearcsv_failed = false;
    
    if($csv2post_csvmethod == 0){
        //csv2post_pearcsv_include();
        
        $csv_file_conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_filename );
            
        if(!$csv_file_conf || !isset($csv_file_conf['quote']) || $csv_file_conf['quote'] == false){
            $pearcsv_failed = true;
        }else{
            return $csv_file_conf['quote'];
        }
    }
 
    // if method is 1 (fget without PEAR CSV) OR it is PEAR CSV but PEAR CSV failed
    if($pearcsv_failed == true || $csv2post_csvmethod == 1){
        return '"';### TODO:MEDIUMPRIORITY, add a function that does not use PEAR CSV to determine quote    
    }    
}

/**
* Checks if a directory is empty
* 1. Returns NULL if directory is not readable
* 2. Avoid actions on directory if NULL or 0 returned
* 
* @param mixed $dir
*/
function csv2post_dir_is_empty($dir) {
    if (!is_readable($dir)){
        return NULL;
    }else{
        return (count(scandir($dir)) == 2);
    }
}   
?>