<?php
/** 
 * WebTechGlobal standard PHP and CMS function library
 *
 * @package WTG Core Functions Library
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
/**
* Builds string of comma delimited table colum names
*/
function csv2post_WP_SQL_build_columnstring($table_name){
    $table_columns = csv2post_WP_SQL_get_tablecolumns($table_name);
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
* Removes special characters and converts to lowercase
*/
function csv2post_clean_string($string){ 
    $string = preg_replace("/[^a-zA-Z0-9s]/", "", $string);
    $string = strtolower ( $string );
    return $string;
}

/**
* Creates random code or can be used to make passwords
*/
function csv2post_create_code($length = 10,$specialchars = false) { 

    if($specialchars){
        $chars = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789£%^&*";        
    }else{
        $chars = "abcdefghjkmnopqrstuvwxyz023456789";
    }
     
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    $length = $length - 1;
    
    while ($i <= $length) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 
} 

/**
* Adds an 's at the end of a string if pluralize required.
* Requires a count of what the string equals i.e. 2 and apple to make apple's
* 
* @param integer $count
* @param string $text
*/
function csv2post_pluralize( $count, $text ) { 
    return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
}

/**
* Adds comma to the end of giving string based on what has already been added to the string value. 
*/
function csv2post_commas($originalstring){
    if($originalstring != ' '){$result = $originalstring . ',';return $result;}else{return $originalstring;}    
}

/**
* Returns human readable age based on giving file modified date
* @todo                           
*/
function csv2post_get_files_age($time){
               
    //echo date("F d Y H:i:s.", filemtime(WTG_C2P_CONTENTFOLDER_DIR . $filename));
    
    return '1 Day, 1 Hour, 1 Min, 1 Sec';   
}

/**
* Returns human readable time passed since giving date.
* Years,months etc all separated with comma and as plurals where required.
* 
* PHP 5.3 or above only
* 
* @param mixed $datetime 
* @param boolean $use_year (this will only be used if value is not 0)
* @param boolean $use_month (this will also only be used if value is not 0)
* @param boolean $use_day
* @param boolean $use_hour
* @param boolean $use_minute
* @param boolean $use_second (false by default)
*/
function csv2post_ago( $datetime,$use_year = true,$use_month = true,$use_day = true,$use_hour = true,$use_minute = true,$use_second = false ){
 
    // PHP 5.3 method is currently the best             
    $interval = date_create('now')->diff( $datetime );
    
    $ago_string = ' ';
             
    // year
    if($use_year){
        if ( $interval->y >= 1 ){
            $ago_string .= csv2post_pluralize( $interval->y, 'year' );        
        } 
    }

    // month
    if($use_month){
        if ( $interval->m >= 1 ){
            $ago_string_with_comma_month = csv2post_commas($ago_string); 
            $ago_string = $ago_string_with_comma_month . csv2post_pluralize( $interval->m, 'month' );        
        } 
    }  
        
    // day
    if($use_day){
        if ( $interval->d >= 1 ){
            $ago_string_with_comma_day = csv2post_commas($ago_string);            
            $ago_string = $ago_string_with_comma_day . csv2post_pluralize( $interval->d, 'day' );        
        } 
    }
    
    // hour
    if($use_hour){
        if ( $interval->h >= 1 ){
            $ago_string_with_comma_hour = csv2post_commas($ago_string);            
            $ago_string = $ago_string_with_comma_hour . csv2post_pluralize( $interval->h, 'hour' );        
        } 
    }       
 
    // minute
    if($use_hour){
        if ( $interval->m >= 1 ){
            $ago_string_with_comma_minute = csv2post_commas($ago_string);            
            $ago_string = $ago_string_with_comma_minute . csv2post_pluralize( $interval->m, 'minute' );        
        } 
    }

    // second
    if($use_second){
        if ( $interval->s >= 1 ){
            $ago_string_with_comma_second = csv2post_commas($ago_string);            
            $ago_string = $ago_string_with_comma_second . csv2post_pluralize( $interval->s, 'second' );        
        } 
    }    
    
    return $ago_string;
}

/**
* truncate string to a specific length 
* 
* @param string $string, string to be shortened if too long
* @param integer $max_length, maximum length the string is allowed to be
* @return string, possibly shortened if longer than
*/
function csv2post_truncatestring( $string, $max_length ){
    if (strlen($string) > $max_length) {
        $split = preg_split("/\n/", wordwrap($string, $max_length));
        return ($split[0]);
    }
    return ( $string );
}

/**
* Formats number into currency, default is en_GB and no GBP i.e. not GBP145.50 just 145.50 is returned
* 
* @param mixed $s
*/
function csv2post_format_money($s){
    setlocale(LC_MONETARY, 'en_GB');
    return money_format('%!2n',$s) . "\n";        
}

/**
 * Validate a url (http https ftp)
 * @return true if valid false if not a valid url
 * @param url $url
 */
function csv2post_validate_url($url){
    if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i',$url)){
            return false;
    } else {
            return true;
    }
}

/**
 * Checks if value is valid a url (http https ftp)
 * 1. Does not check if url is active (not broken)
 * 
 * @return true if valid false if not a valid url
 * @param url $url
 */
function csv2post_is_url($url){
    if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i',$url)){
            return false;
    } else {
            return true;
    }
}

/**
 * Generates a username using a single value by incrementing an appended number until a none used value is found
 * @param string $username_base
 * @return string username, should only fail if the value passed to the function causes so
 * 
 * @todo log entry functions need to be added, store the string, resulting username
 */
function csv2post_create_username($username_base){
    $attempt = 0;
    $limit = 500;// maximum trys - would we ever get so many of the same username with appended number incremented?
    $exists = true;// we need to change this to false before we can return a value

    // clean the string
    $username_base = preg_replace('/([^@]*).*/', '$1', $username_base );

    // ensure giving string does not already exist as a username else we can just use it
    $exists = username_exists( $username_base );
    if( $exists == false ){
        return $username_base;
    }else{
        // if $suitable is true then the username already exists, increment it until we find a suitable one
        while( $exists != false ){
            ++$attempt;
            $username = $username_base.$attempt;

            // username_exists returns id of existing user so we want a false return before continuing
            $exists = username_exists( $username );

            // break look when hit limit or found suitable username
            if($attempt > $limit || $exists == false ){
                break;
            }
        }

        // we should have our login/username by now
        if ( $exists == false ) {
            return $username;
        }
    }
}

/**
 * Returns the current url as viewed with all variables etc
 * @return string current url with all GET variables
 */
function csv2post_currenturl() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    
        $pageURL .= "://";
        
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80" && isset($_SERVER["SERVER_NAME"]) && isset($_SERVER["REQUEST_URI"])) {

        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

    }elseif(isset($_SERVER["SERVER_NAME"]) && isset($_SERVER["REQUEST_URI"])){
        
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        
    }else{
        
        return 'Error Unexpected State In Current URL Function';
        
    }
    return $pageURL;
}  

/**
* Wrapper, uses csv2post_url_toadmin to create local admin url
* 
* @param mixed $page
* @param mixed $values 
*/
function csv2post_create_adminurl($page,$values = ''){
    return csv2post_url_toadmin($page,$values);    
}

/**
* Returns the plugins standard date (MySQL Date Time Formatted) with common format used in Wordpress.
* Optional $time parameter, if false will return the current time().
* 1. Passing a date string is optional
* 2. Using $convert_string will convert to mysql (replace slashes with hyphens)
* 3. Can pass a string such as 23/05/2014 and get a mysql ready date string returned
* 
* @param integer $timeaddition, number of seconds to add to the current time to create a future date and time
* @param integer $time optional parameter, by default causes current time() to be used
* @todo adapt this to return various date formats to suit interface
*/
function csv2post_date($timeaddition = 0,$time = false,$datestring = false,$convert_string = false){  
    
    // if date string passed we convert that and return it
    if($datestring != false && is_string($datestring) && $convert_string != false){
        $mysqlready = str_replace('/', '-', $datestring);
        $datetotime = strtotime($mysqlready);
        $fulldate = date('Y-m-d H:i:s', $datetotime + $timeaddition);
        return $fulldate;
    }
    
    // arriving here means no string, we work with the current time() or passed $time to create a date
    $thetime = time();
    if($time != false){$thetime = $time;}  
    return date('Y-m-d H:i:s',$thetime + $timeaddition);    
} 

/**
* Builds URL to the Contact screen
* 
*/
function csv2post_contactscreen_url(){
    //return get_admin_url(null,'admin.php?page=csv2post_more&csv2post_tab=tab10_more');   OLD TAB METHOD     
    return get_admin_url(null,'admin.php?page=csv2post_more#tabs-9');// new jquery tabs method
} 
?>