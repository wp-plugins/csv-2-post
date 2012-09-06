<?php
/**
 * Counts rows in CSV file and returns (does no include header row)
 * @uses eci_csvfileexists
 * @param filename $filename
 * @param array $pro
 */
function wtgcsv_count_csvfilerows($csvfile_name){    
    return count(file(WTG_CSV_CONTENTFOLDER_DIR . '/' . $csvfile_name)) - 1;
}

/**
* Counts separator characters per row, compares total over all rows counted to determine probably Separator
* 
* @param mixed $csv_filename
* @param mixed $output
* 
* @todo LOWPRIORITY, add further checks when the difference between two counts is not great, is it possible to ignore the needles with quotes around them? Maybe ignore columns with large text values
*/
function wtgcsv_establish_csvfile_separator_fgetmethod($csv_filename, $output = false ){
    
    $probable_separator = ','; 
    
    if (($handle = fopen(WTG_CSV_CONTENTFOLDER_DIR . '/' . $csv_filename, "r")) !== FALSE) {
        
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
            wtgcsv_notice('A failure happened with end-of-file function feof for '.$csv_filename.'. You may need to seek support if you want to use this CSV file.','success','error','Large','Test 1: Could Not Establish Separator Using fgets','','echo');    
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
            wtgcsv_notice('Separator was established using method one, fgets. Established Separator is <strong>'.$probable_separator_name.' ( '.$probable_separator.' )</strong>','success','Large','Test 1: Established Separator Using fgets','','echo');       
        }
        
    }// if handle open for giving file
    
    return $probable_separator; 
}

/**
* Guesses CSV files separator character
* 
* @param mixed $csv_filename
* @param boolean $display, will cause more output to screen for user
* 
* @todo HIGHPRIORITY, complete function
*/
function wtgcsv_establish_csvfile_separator_PEARCSVmethod( $csv_filename,$output = false){
    wtgcsv_pearcsv_include();
    $csv_file_conf = File_CSV::discoverFormat( WTG_CSV_CONTENTFOLDER_DIR . '/' . $csv_filename );

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
        
        wtgcsv_notice('Separator was established using method two, PEAR CSV. Established Separator is <strong>'.$probable_separator_name.' ( '.$probable_separator.' )</strong>','success','Large','Test 2: Established Separator Using PEAR CSV','','echo');
    }
            
    return $csv_file_conf['sep'];          
} 

/**
* Guesses CSV files quote character
* 
* @param mixed $csv_filename
* @param boolean $display, will cause more output to screen for user
* 
* @todo HIGHPRIORITY, complete function
*/
function wtgcsv_establish_csvfile_quote_PEARCSVmethod( $csv_filename,$output = false){
    wtgcsv_pearcsv_include();
    $csv_file_conf = File_CSV::discoverFormat( WTG_CSV_CONTENTFOLDER_DIR . '/' . $csv_filename );
           
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

        wtgcsv_notice('Quote was established using PEAR CSV. Established quote is <strong>'.$probable_quote_name.' ( '.$probable_quote.' )</strong>','success','Large','Test 3: Established Quote','','echo');
    }
                    
    return $csv_file_conf['quote'];   
} 

/**
* Returns array holding the headers of the giving filename
* It also prepares the array to hold other formats of the column headers in prepartion for the plugins various uses
*/
function wtgcsv_get_file_headers_formatted($csv_filename,$fileid,$separator = ',',$quote = '"',$fields = 0){
    
    wtgcsv_pearcsv_include();
    
    if($fields == 0){
        
    }
    
    $csv_file_conf = array();    
    $csv_file_conf['fields'] = $fields;    
    $csv_file_conf['sep'] = $separator;        
    $csv_file_conf['quote'] = $quote; 
            
    $header_array = array();

    // read and loop through the first row in the csv file    
    while ( ( $readone = File_CSV::read( WTG_CSV_CONTENTFOLDER_DIR . '/' . $csv_filename,$csv_file_conf ) ) ){                
               
        for ( $i = 0; $i < $csv_file_conf['fields']; $i++ ){
            $header_array[$i]['original'] = $readone[$i];
            $header_array[$i]['sql'] = wtgcsv_cleansqlcolumnname($readone[$i]);// none adapted/original sql version of headers, could have duplicates with multi-file jobs
            $header_array[$i]['sql_adapted'] = wtgcsv_cleansqlcolumnname($readone[$i]) . $fileid;// add files id to avoid duplicate header names              
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
function wtgcsv_get_file_separator($csv_filename){
    global $wtgcsv_csvmethod;
    $pearcsv_failed = false;
    
    if($wtgcsv_csvmethod == 0){
        wtgcsv_pearcsv_include();
        
        $csv_file_conf = File_CSV::discoverFormat( WTG_CSV_CONTENTFOLDER_DIR . '/' . $csv_filename );
            
        if(!$csv_file_conf || !isset($csv_file_conf['sep']) || $csv_file_conf['sep'] == false){
            $pearcsv_failed = true;
        }else{
            return $csv_file_conf['sep'];
        }
    }
    
    // if method is 1 (fget without PEAR CSV) OR it is PEAR CSV but PEAR CSV failed
    if($pearcsv_failed == true || $wtgcsv_csvmethod == 1){
        return wtgcsv_establish_csvfile_separator_fgetmethod($csv_filename,false);    
    }   
}

/**
* Returns established quote
* 
* @param string $csv_filename
* @param string $method, PEAR or FGETCSV (not in use yet)
* @return string, should be a single character
*/
function wtgcsv_get_file_quote($csv_filename,$method = 'PEAR'){
    global $wtgcsv_csvmethod;
    $pearcsv_failed = false;
    
    if($wtgcsv_csvmethod == 0){
        wtgcsv_pearcsv_include();
        
        $csv_file_conf = File_CSV::discoverFormat( WTG_CSV_CONTENTFOLDER_DIR . '/' . $csv_filename );
            
        if(!$csv_file_conf || !isset($csv_file_conf['quote']) || $csv_file_conf['quote'] == false){
            $pearcsv_failed = true;
        }else{
            return $csv_file_conf['quote'];
        }
    }
 
    // if method is 1 (fget without PEAR CSV) OR it is PEAR CSV but PEAR CSV failed
    if($pearcsv_failed == true || $wtgcsv_csvmethod == 1){
        return '"';### TODO:MEDIUMPRIORITY, add a function that does not use PEAR CSV to determine quote    
    }    
}
?>
