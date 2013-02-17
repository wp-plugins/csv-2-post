<?php
/**
* Control Wordpress option functions using this single function.
* This function will give us the opportunity to easily log changes and some others ideas we have.
* 
* @param mixed $option
* @param mixed $action add, get, wtgget (own query function) update, delete
* @param mixed $value
* @param mixed $autoload used by add_option only
* 
* @todo LOWPRIORITY, call a global settings value for logging to server error log and make entries per action
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

/**
* Get POST ID using post_name (slug)
* 
* @param string $name
* @return string|null
*/
function csv2post_WP_SQL_get_post_ID_by_postname($name){
    var_dump($name);
    global $wpdb;
    // get page id using custom query
    return $wpdb->get_var("SELECT ID 
    FROM $wpdb->posts 
    WHERE post_name = '".$name."' 
    AND post_type='page' ");
}  

/**
* Get the record used to create a post using Wordpress post ID
* @returns ARRAY_A if record found else false if record could not be found or failure
*/
function csv2post_WP_SQL_get_posts_record($main_table,$post_id,$project_array = false){

    global $wpdb,$csv2post_is_free;

    $query = 'SELECT * FROM ' . $main_table . ' WHERE csv2post_postid = ' . $post_id;
    
    /*  TODO:MEDIUMPRIORITY, still to add multiple table support
    $tables_added_count = 0;
    foreach($project_tables as $key => $table_name){
        
        if($tables_added_count != 0){
            $query .= ',';    
        }
        
        $query .= $table_name;    
                                
        ++$tables_added_count;    
    }
    
    
      */

    $query .= ' LIMIT 1';  
    
    return $wpdb->get_results( $query,ARRAY_A ); 
}

/**
* Counts the number of available templates
* 
* @param string $template_type postcontent,customfieldvalue,categorydescription,postexcerpt,keywordstring,dynamicwidgetcontent
* @todo HIGHPRIORITY, filter out none category description templates
*/
function csv2post_WP_SQL_count_posts_type($template_type){
    // post query argument for get_posts function
    $args = array(
        'post_type' => 'wtgcsvcontent'
    );

    global $post;
    $myposts = get_posts( $args );
    return count($myposts);      
}   
?>
