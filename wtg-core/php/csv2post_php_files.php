<?php
/**
 * Creates a new directory (folder) using giving path, validation is expected to have been done already
 * @param uri $pathdir
 * @param numeric $per (chmod permissions)
 * @todo this needs to be improved to make a log and report errors for viewing in history
 */
function csv2post_createfolder($path,$chmod = 0700){
    if(mkdir($path,0700,true)){
        chmod($path, $chmod);
        return true;
    }else{
        return false;
    }
}  
?>
