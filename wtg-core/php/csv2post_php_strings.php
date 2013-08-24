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

/**
* Determines if a string matches a known format. Meant for established intended purpose of a value.
* 1. url
* 2. image
* 3. number
* 4. text
* 5. money
* 6. decimal
* 7. email
* @returns unknown if could not establish types
*/
function csv2post_STRINGS_type($value){
    if(csv2post_STRINGS_is_image_url($value)){
        return 'image';
    }
    
    // so its not an image url, is it any type of url? either for using as link or PHP functionality
    if(csv2post_is_url($value)){
        return 'url';    
    }
    
    // check if decimal before checking if a plain number or money
    if(csv2post_STRINGS_is_decimalnumber($value)){
        return 'decimal';
    }

    // is money value
    if(csv2post_STRING_is_string_money($value)){
        return 'money'; 
    }
    
    // is not money, is it even a number?  
    if(is_numeric($value)){
        return 'numeric';
    }
    
    // is email address
    if(csv2post_string_is_valid_emailaddress($value)){
        return 'email';
    }                  
    // it must be text but we will do the check anyway
    if(is_string($value)){
        return 'text';
    }
                   
    return 'unknown';# should never happen    
}    

function csv2post_string_is_valid_emailaddress($value){
    if(filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }    
}     

/**
* establishes if a string is monitory
*
* first character is checked, if it is not a number or letter and the rest of the string is numeric we guess this is a money value
*
* @package CSV 2 POST
* @since 7.0.4
*
* @return boolean true if string is recognized as a money value|false if string is not recognized as a money value 
*/
function wtgvb_() {
    $return = false;
    
    
    
    return $return;
}
function csv2post_STRING_is_string_money($value,$currency = 'nonespecified'){
    
    if(!$value || empty($value) || $value == '' || $value == ' '){
        return false;
    }
    
    // get first character and test it unless specific currency enforced
    if($currency == 'nonespecified'){
                  
        // is first character numeric or a letter, if so this is not money it may just be decimal (numeric), return false
        if(is_numeric($value['0']) || ctype_alpha ( $value['0'] )){ 
            return false;
        }
        
        // lets assume the first character, which we know is not numeric, is a currency symbol
        // remove it and test the rest of the $value to determine if that is numeric
        if(strstr($value,'£')){
            $possiblenumeric = substr($value,2);       
        }else{    
            $possiblenumeric = substr($value,1);
        }
        
        // is the remaining string a number, which would indicate a high possibility that the value is money    
        if(is_numeric($possiblenumeric)){
            return true;
        }
       
    }else{
        // strings first character must be = $currency for a true else false    
    }
    return false;
}
/**
* Determines if numeric value is decimal.
* 1. checks if value is actually numeric first
* @returns boolean
*/
function csv2post_STRINGS_is_decimalnumber($img_url){
    return is_numeric( $img_url ) && floor( $img_url ) != $img_url;    
}

/**
* Checks if url has an image extension, does not validate that resource exists
* @returns boolean
*/
function csv2post_STRINGS_is_image_url($img_url){
    $img_formats = array("png", "jpg", "jpeg", "gif", "tiff","bmp"); 
    $path_info = pathinfo($img_url);
    if(is_array($path_info) && isset($path_info['extension'])){
        if (in_array(strtolower($path_info['extension']), $img_formats)) {
            return true;
        }
    }
    return false;
} 
?>