<?php
/** 
 * WebTechGlobal standard PHP and CMS function library
 *
 * @package WTG Core Functions Library
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
/**
 * Checks if an extension is loaded on the server
 * @uses get_loaded_extensions()
 * @param string $giving_extension (name of the extension)
 * @return boolean (if extension is loaded returns true)
 */
function csv2post_is_extensionloaded($giving_extension){
    $loaded_extensions = get_loaded_extensions();
    foreach($loaded_extensions as $key => $extension){
        if($extension == $giving_extension){
            return true;
        }
    }
    return false;
}

/**
* Checks the extensions version with the version stored in Wordpress options table
*/
function csv2post_extension_updaterequired($name,$version){
    $current_version = get_option($name . '_version');
    if(!$current_version || $current_version < $version){
        return true;
    }else{
        return false;
    }
}  
?>
