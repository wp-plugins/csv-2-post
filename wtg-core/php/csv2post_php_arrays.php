<?php
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
?>
