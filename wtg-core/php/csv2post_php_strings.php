<?php
/**
 * Returns a cleaned string so that it is suitable to be used as an SQL column name
 * @param string $column (characters removed = , / \ . - # _ and spaces)
 */
function csv2post_PHP_STRINGS_clean_sqlcolumnname( $column ){
    return str_replace( array( ",","/","'\'"," ",".",'-','#','_'),"", strtolower($column) );
} 

/**
* Get part of a string, specifically the string between two giving characters
* 
* @param string $start_limiter, start character
* @param string $end_limiter, end character
* @param string $haystack, string to be searched
* @return string or false on failure
* 
*/
function csv2post_PHP_STRINGS_get_between_two_values($start_limiter,$end_limiter,$haystack){
    $start_pos = strpos($haystack,$start_limiter);
    if ($start_pos === false){
        return false;
    }

    $end_pos = strpos($haystack,$end_limiter,$start_pos);

    if ($end_pos === false){
        return false;
    }

    return substr($haystack, $start_pos+1, ($end_pos-1)-$start_pos);
}
?>