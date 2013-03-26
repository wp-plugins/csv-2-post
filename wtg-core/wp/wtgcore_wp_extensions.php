<?php
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
?>
