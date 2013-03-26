<?php
# RENAME THIS FILE TO csv2post_strings
/**
* Compares giving possible/expected prepend (needle) characters to haystack string and determines if the
* needle exists at the beginning of the haystack.
* 
* @param mixed $h
* @param mixed $n
* @param mixed $len
* @returns boolean true means needle exists at the beginning of the haystick, false indicates it does not
*/
function csv2post_STRINGS_prepend_exists($haystack,$needle){
    $strncmp_abc = strncmp($haystack,$needle,strlen($needle));// 0 means there is a match (-1 or 1 means one string is greater than other in matching characters)
    if($strncmp_abc == 0){return true;}else{return false;}                
}

/**
* PHP strtotime does not allow UK time, it treats it as US format.

* @param mixed $format This function allows specification of the US or UK or other format.
*/
function csv2post_STRINGS_strtotime($date_string,$format = 'UK'){
    if($format == 'US'){
        return strtotime($date_string);    
    }elseif($format == 'UK'){
        $date_explode = explode("/", $date_string);
        return mktime(0,0,0,$date_explode[1],$date_explode[0],$date_explode[2]);     
    }else{
        return strtotime($date_string);    
    }    
}  

/**
* Determines if a string is alphanumeric (English characters) or not
*/
function csv2post_STRINGS_is_alphanumeric($string,$minimum_length = 1,$maximum_length = 99){
    
    if (preg_match('/^[A-Z0-9]{'.$minimum_length.','.$maximum_length.'}$/i', $string)) {
        return true;
    } else {
        return false;
    }    
    
}
                
/**
* Converts Special Characters Using Correct Encoding Values For Content
* 
* @param string $content
* @return string
*/
function csv2post_encoding_clean_string($content) {
    global $csv2post_wtgcore_o42chars;

    if ( strtoupper( get_option('blog_charset' )) == 'UTF-8') {
        $content = str_replace($csv2post_wtgcore_o42chars['utf8'], $csv2post_wtgcore_o42chars['feed'], $content);
    }
    
    $content = str_replace($csv2post_wtgcore_o42chars['ecto'], $csv2post_wtgcore_o42chars['feed'], $content);
    $content = str_replace($csv2post_wtgcore_o42chars['in'], $csv2post_wtgcore_o42chars['feed'], $content);

    return $content;
}  

// Character Encoding Input Array
$csv2post_wtgcore_o42chars['in'] = array(
    chr(196), chr(228), chr(214), chr(246), chr(220), chr(252), chr(223)
);
$csv2post_wtgcore_o42chars['ecto'] = array(
    '�', '�', '�', '�', '�', '�', '�'
);
$csv2post_wtgcore_o42chars['html'] = array(
    '&Auml;', '&auml;', '&ouml;', '&ouml;', '&Uuml;', '&uuml;', '&szlig;'
);
$csv2post_wtgcore_o42chars['utf8'] = array(
    utf8_encode('�'), utf8_encode('�'), utf8_encode('�'), utf8_encode('�'),
    utf8_encode('�'), utf8_encode('�'), utf8_encode('�')
);
$csv2post_wtgcore_o42chars['perma'] = array(
    'Ae', 'ae', 'Oe', 'oe', 'Ue', 'ue', 'ss'
);

// Character Encoding Ouput Array
$csv2post_wtgcore_o42chars['post'] = array(
    '�', '�', '�', '�', 'Uuml;', '�', '�'
);
$csv2post_wtgcore_o42chars['feed'] = array(
    '&#196;', '&#228;', '&#214;', '&#246;', '&#220;', '&#252;', '&#223;'
);

/**
* Clean encoding in permalinks
* 
* @param string $title
* @return string
*/
function csv2post_encoding_clean_permalinks($title){
    global $csv2post_wtgcore_o42chars;
    
    if ( seems_utf8($title) ) {
        $invalid_latin_chars = array(chr(197).chr(146) => 'OE', chr(197).chr(147) => 'oe', chr(197).chr(160) => 'S', chr(197).chr(189) => 'Z', chr(197).chr(161) => 's', chr(197).chr(190) => 'z', chr(226).chr(130).chr(172) => 'E');
        $title = utf8_decode(strtr($title, $invalid_latin_chars));
    }
    
    $title = str_replace($csv2post_wtgcore_o42chars['ecto'], $csv2post_wtgcore_o42chars['perma'], $title);
    $title = str_replace($csv2post_wtgcore_o42chars['in'], $csv2post_wtgcore_o42chars['perma'], $title);
    $title = str_replace($csv2post_wtgcore_o42chars['html'], $csv2post_wtgcore_o42chars['perma'], $title);
    $title = sanitize_title_with_dashes($title);
    return $title;
}

function csv2post_remove_last_comma($s){
    return substr_replace($s, '', -1);     
}
?>
