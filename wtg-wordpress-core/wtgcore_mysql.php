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
function wtgcore_option($option,$action,$value = 'No Value',$autoload = 'no'){
    
    if($action == 'add'){
        $action_result = add_option($option,$value,'',$autoload);    
    }elseif($action == 'get'){
        $action_result = get_option($option); 
    }elseif($action == 'wtgget'){
        $action_result = wtgcore_get_option($option);   
    }elseif($action == 'update'){        
        $action_result = update_option($option,$value);
    }elseif($action == 'delete'){
        $action_result = delete_option($option);        
    }
          
    return $action_result;
}

/**
* WTG version of Wordpress get_option().
* This has been created to control the error output caused when an option record does not exist.
* 
* @param mixed $option
*/
function wtgcore_get_option($option){
    global $wpdb;
    // Has to be get_row instead of get_var because of funkiness with 0, false, null values 
    $row = $wpdb->get_row( $wpdb->prepare( "SELECT 
    option_value 
    FROM $wpdb->options 
    WHERE option_name = %s 
    LIMIT 1", $option ) );
    // will be object if record exists
    if ( is_object( $row ) ) {
        $value = $row->option_value;
    } else { // option does not exist
         return false;
    }            
}
?>
