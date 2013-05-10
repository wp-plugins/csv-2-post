<?php
/**
* Create a string of data values extracted from a query result record, using a string of the columns queried.
* This can be used when querying one table and putting the resulting data into another table using INSERT.
* 
* @param string $columns comma separated column names (must be in the $record object)
* @param array $record
*/
function csv2post_PHP_SQL_columnstring_to_valuestring($columns,$record){

    // split column string into array
    $column_array = explode(',',$columns);

    $value_string = '';
    
    $comma = false;
    
    foreach($column_array as $key => $column){
        
        if($comma == true){
            $value_string .= ',';
        }

        $value_string .= "'".mysql_real_escape_string($record->$column)."'";    

        $comma = true;
    }
    
    return $value_string;
} 
?>
