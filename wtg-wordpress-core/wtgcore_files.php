<?php
/**
* Function not in use yet and not complete COMMENT IT FULLY
* 
* @param mixed $table_name
*/
function wtgcore_csvfile_download_export_databasettable($table_name){
 
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
        echo 'TEST';
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
?>
