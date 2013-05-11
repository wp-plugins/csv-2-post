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

/**
* Determines if giving path contains any files with the giving extension
* 1. Extension value should not have . passed with it 
* 2. Faster than csv2post_count_extension_in_directory() because it returns sooner, important for directory with a lot of files
* 
* @returns boolean
*/
function csv2post_does_folder_contain_file_type($path,$extension){
    $all_files  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    $html_files = new RegexIterator($all_files, '/\.'.$extension.'/');                        
    foreach($html_files as $file) {
        return true;# entering foreach means we found one or more files with our extension
    }    
    return false;# no files with extension found
}

/**
* Counts number of files with giving extension
* 1. Use csv2post_does_folder_contain_file_type() for checking if any files with specific extension exist especially if directory contains many files
* 
*/
function csv2post_count_extension_in_directory(){
    $all_files  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    $html_files = new RegexIterator($all_files, '/\.'.$extension.'/');
    $count = 0;                        
    foreach($html_files as $file) {
        ++$count;
    }    
    return $count;
}
?>