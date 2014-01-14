<?php
/** 
 * WebTechGlobal standard PHP and CMS function library
 *
 * @package WTG Core Functions Library
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
/**
* WebTechGlobal array info function.
* Returns array for updating another array. This is a standard set of values used to maintain 
* stored arrays and it also helps in debugging.
* 
* @param mixed $line
* @param mixed $function
* @param mixed $file
* @param mixed $reason
* @param mixed $version
*/
function csv2post_ARRAY_arrayinfo_set($line,$function,$file,$reason = false,$version = false){
    $a = array();
    
    if($reason != false){
        $a['reason'] = $reason;
    }
    
    if($version != false){
        $a['version'] = $version;
    }
    
    $a['line'] = $line;
    $a['function'] = $function;
    $a['file'] = $file;
    $a['date'] = csv2post_date();
    
    return $a;   
}  

/**
* Get random values from giving array
* 
* @param mixed $array
* @param mixed $number number of random values to get
*/
function csv2post_ARRAYS_random_value($array,$number = 1){
    $rand_key = array_rand( $array,$number );
    return $array[ $rand_key ];      
}

/**
* Gets the following value that comes after the giving value.
* Requires a current value for which its key will be established. 
* Using the key we can establish the next value.
* 
* 1. Array keys must be numeric and incremented. If doubt establish another solution.
* 2. Returns random value instead of generating a false return where any issues are found 
* 
* @returns false on failure to establish the next value
*/
function csv2post_ARRAYS_get_next_value($array,$current_value){

    if(!is_array($array)){return $current_value;}
    
    // get the key for the current value
    $current_value_key = array_search ( $current_value , $array , true );
    
    // if we cannot find the value in the array (user may have edited it, then return a random value)
    if(!$current_value_key || !is_numeric($current_value_key)){
        return csv2post_ARRAYS_random_value($array);
    }
    
    $next_key = $current_value_key + 1;

    if(!isset($array[$next_key])){
        return csv2post_ARRAYS_random_value($array);// key is missing so return a random value instead    
    }
    
    return $current_value_key;
}

/**
 * Updates option array, records history to aid debugging
 * @return true on success or false on failure
 * @param string $option_key (wordpress options table key value)
 * @param mixed $option_value (can be string or array)
 * @param integer $line (line number passed by __LINE__)
 * @param string $file (file name passed by __FILE__)
 * @param string $function (function name passed by __FUNCTION__)
 * 
 * @todo check if including the php constants in the attributes applyes where this function is or where it is used
 * @todo what is the best way to determine if update actually failed or there was no difference in array ?
 * @todo complete logging (no output that will be handled where function called)
 */
function csv2post_option_array_update( $option_key, $option_value, $line = __LINE__, $file = __FILE__, $function = __FUNCTION__ ){
    // store an array of values indicating the update time and where it occured
    $change = array();
    $change['date'] = date("Y-m-d H:i:s");
    $change['time'] = time();
    $change['line'] = $line;
    $change['file'] = $file;

    $option_value['arrayhistory'] = $change;

    update_option($option_key,$option_value);

    return $change;
}

/**
 * Establishes if an arrays element count is odd or even (currently divided by 2)
 * For using when balancing tables
 * @param array $array
 * 
 * @todo divide by any giving number, validate the number, the function that builds the table will need to handle that
 */
function csv2post_oddeven_arrayelements($array){
    $oddoreven_array = array();

    // store total number of items in totalelements key
    $oddoreven_array['totalelements'] = count($array);

    // store the calculation result from division before rounding up or down, usually up
    $oddoreven_array['divisionbeforerounded'] = $oddoreven_array['totalelements'] / 2;

    // round divisionbeforerounded using ceil and store the answer in columnlimitceil, this is the first columns maximum number of items
    $oddoreven_array['columnlimitceil'] = ceil($oddoreven_array['divisionbeforerounded']);

    // compare our maths answer with the ceil value - if they are not equal then the total is odd
    // if the total is oddd we then know the last column must have one less item, a blank row in the table
    if($oddoreven_array['divisionbeforerounded'] == $oddoreven_array['columnlimitceil']){
        $oddoreven_array['balance'] = 'even';
    }else{
        $oddoreven_array['balance'] = 'odd';
    }

    return $oddoreven_array;
}
?>
