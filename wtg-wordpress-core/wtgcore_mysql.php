<?php
/**
* Control Wordpress option functions using this single function.
* This function will give us the opportunity to easily log changes and some others ideas we have.
* 
* @param mixed $option
* @param mixed $action add, get, wtgget (own query function) update, delete
* @param mixed $value
* @param mixed $autoload used by add_option only
*/
function csv2post_option($option,$action,$value = 'No Value',$autoload = 'no'){
    
    if($action == 'add'){  
        return add_option($option,$value,'','no');            
    }elseif($action == 'get'){
        return get_option($option);    
    }elseif($action == 'update'){        
        return update_option($option,$value);
    }elseif($action == 'delete'){
        return delete_option($option);        
    }
}
?>
