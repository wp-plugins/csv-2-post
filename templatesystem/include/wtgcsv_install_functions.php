<?php
/**
 * Checks if plugin has been installed before (not security and not indication of full existing installation)
 */
function wtgcsv_was_installed(){
    global $wtgcsv_options_array,$wtgcsv_templatesystem_files;
    
    $result = false;
    
    if(isset($wtgcsv_options_array) && is_array($wtgcsv_options_array)){
        // check possible option records
        foreach($wtgcsv_options_array as $id => $optionrecord){
     
            // avoid checking tab menu as that is added to blow on Wordpress plugin activation, we do not want to use it as an indication of install
            if($id != WTG_CSV_ABB.'tabmenu' 
            && $id != WTG_CSV_ABB.'installedversion' 
            && $id != WTG_CSV_ABB.'installeddate' 
            && $id != WTG_CSV_ABB.'activationdate'){
                                        
                $currentresult = get_option($id);    

                // change return switch too false if option not found
                if(isset($currentresult) && $currentresult != null){

                    // we return on first detection of previous installation to avoid going through entire loop
                    return true;    
                }
            }
        } 
        
        return $result; 
    }
     
    return $result;
}

/**
* NOT YET IN USE - WILL CHECK IF PLUGIN HAS BEEN ACTIVATED WITH SECURITY VIA SERVER
* Determines if the plugin is activated and validates credentials to ensure ongoing use.
* Once done, less SOAP calls will be required and the aim is to reduce traffic.
*/
function wtgcsv_is_activated(){ 
   global $wtgcsv_activationcode;
   return false;
}

/**
* Checks if plugin IS FULLY INSTALLED (all required options arrays,folders,path files etc)
* Another function and variable establishes if the plugin WAS installed in the past by finding a trace
* 
* @see wtgcsv_variables_admin.php
* 
* @todo HIGHPRIORITY, ensure this function only runs when admin logged in
*/
function wtgcsv_is_installed(){
    
    global $wtgcsv_options_array;
    
    if(!isset($wtgcsv_options_array) || !is_array($wtgcsv_options_array)){
        ### TODO:HIGHPRIORITY, log this event
        return false;
    }
    
    // currently this value is returned, if changed too false
    $returnresult = true;
    $failcause = 'Not Known';// only used for debugging to determine what causes indication of not fully installed
    
    // function only returns boolean but if required we will add results array too the log
    $is_installed_result = array();
    $is_installed_result['finalresult'] = false;
    $is_installed_result['options'] = null;
                 
    foreach($wtgcsv_options_array as $id => $optionrecord){
             
        if($optionrecord['required'] == true){
                    
            $currentresult = get_option($id);    
            
            $is_installed_result['options'][$id]['result'] = $currentresult;
            
            // change return switch too false if option not found
            if($currentresult == false || $currentresult == null){
                $returnresult = false;
                $failcause = 'Option RecordMissing:'.$id;    
            }
        } 
    }

    // check plugins required files but do not display message, we only want a true or false outcome
    $templatefiles_result = wtgcsv_templatefiles_missing(false);
    if($templatefiles_result){
        // a template file is missing, user will find more info on status screen
        $returnresult = false;
        $failcause = 'Core File Missing';        
    }

    return $returnresult;
}      

/**
 * Installs everything for the first time only (deletes any previous trace to ensure a first time install procedure)
 * 
 * @return array $install_result_array (holds option key or table name with outcome of the installation attempt for each
 *
 * @todo include folders and database tables in the installation summary not just option keys
 */
function wtgcsv_install(){
    
    // settings arrays are includes by 
    global $wtgcsv_adm_set,$wtgcsv_pub_set,$wtgcsv_eas_set,$wtgcsv_mpt_arr,$wtgcsv_currentversion;

    $minor_fails = 0;// count minor number of failures, if 3 or more then we'll call it a failed install
    $overall_install_result = true;// used to indicate overall result

    // register custom post types (currently one for post content designs)
    wtgcsv_install_customposttypes();
    
    // clean up existing installation to prevent conflict
    wtgcsv_uninstall();

    update_option(WTG_CSV_ABB . 'installedversion',$wtgcsv_currentversion);
    update_option(WTG_CSV_ABB . 'installeddate',time());
    add_option(WTG_CSV_ABB . 'activationdate',time());// track original first use on current blog
        
    // install admin only settings
    if(!add_option(WTG_CSV_ABB.'adminset',serialize($wtgcsv_adm_set))){
        
        // should never happen - wtgcsv_uninstall() used at the beginning of wtgcsv_install()
        wtgcsv_notice('Adding option '.WTG_CSV_ABB.'adminset returned false, this is usually because it already exists.','error','Tiny',false);
        
        $overall_install_result = false;          
        
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'adminset could not be installed';
        $wtgcsv_log['style'] = 'error';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);

    }else{
        
        wtgcsv_notice('Installed option record called '.WTG_CSV_ABB.'adminset','success','Tiny',false);
        
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'adminset was installed';
        $wtgcsv_log['style'] = 'success';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }

    // install main public settings option record
    if(!add_option(WTG_CSV_ABB.'publicset',serialize($wtgcsv_pub_set))){
        
        // should never happen - wtgcsv_uninstall() used at the beginning of wtgcsv_install()
        wtgcsv_notice('Adding option '.WTG_CSV_ABB.'publicset returned false, this is usually because it already exists.','error','Tiny',false);
        
        $overall_install_result = false;
        
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'publicset could not be installed';
        $wtgcsv_log['style'] = 'error';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }else{
        wtgcsv_notice('Installed option record called '.WTG_CSV_ABB.'publicset','success','Tiny',false);
        
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'publicset was installed';
        $wtgcsv_log['style'] = 'success';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }
         
    // install easy configuration question default answers - see wtgcsv_variables_easy.php     
    if(!add_option(WTG_CSV_ABB.'easyset',serialize($wtgcsv_eas_set))){
        
        // should never happen - wtgcsv_uninstall() used at the beginning of wtgcsv_install()
        wtgcsv_notice('Adding option '.WTG_CSV_ABB.'easyset returned false, this is usually because it already exists.','error','Tiny',false);
        
        $overall_install_result = false;          
        
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'easyset could not be installed';
        $wtgcsv_log['style'] = 'error';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);

    }else{
        wtgcsv_notice('Installed option record called '.WTG_CSV_ABB.'easyset','success','Tiny',false);
        
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'easyset was installed';
        $wtgcsv_log['style'] = 'success';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }

    // install admin menu array - see wtgcsv_variables_adminconfig.php
    if(!add_option(WTG_CSV_ABB.'tabmenu',serialize($wtgcsv_mpt_arr))){
        
        // should never happen - wtgcsv_uninstall() used at the beginning of wtgcsv_install()
        wtgcsv_notice('Adding option '.WTG_CSV_ABB.'tabmenu returned false, this is usually because it already exists.','error','Tiny',false);
        
        $overall_install_result = false;          
        
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'tabmenu could not be installed';
        $wtgcsv_log['style'] = 'error';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);

    }else{
        wtgcsv_notice('Installed option record called '.WTG_CSV_ABB.'tabmenu','success','Tiny',false);
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'tabmenu was installed';
        $wtgcsv_log['style'] = 'success';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }
        
    // update switches
    update_option(WTG_CSV_ABB.'is_installed',true);
    update_option(WTG_CSV_ABB.'was_installed',true); 
    update_option(WTG_CSV_ABB . 'installeddate',time());
    update_option(WTG_CSV_ABB . 'installedversion',$wtgcsv_currentversion);
           
    // create or confirm content folder for storing main uploads - false means no folder wanted, otherwise a valid path is expected
    if( defined("WTG_CSV_CONTENTFOLDER_DIR")){$overall_install_result = wtgcsv_install_contentfolder(WTG_CSV_CONTENTFOLDER_DIR);}

    // if there were too many minor fails, the installation is a failure
    if($minor_fails > 2){
        $overall_install_result = false;
    }

    if($overall_install_result == false){
        wtgcsv_notice('You are attempting to run a First-Time Install but there was a problem. If you have installed the plugin previously, it
            could be because there is a trace of that installation still in your blog. Please use the Un-Install feature then try again. First-Time
            Installation is designed only for first time use on a blog unless you have used the Un-Install feature to remove any trace of a previous
            installation.','error','Large',false);
    }

    return $overall_install_result;
}

/*
 * Removes the plugins main wp-content folder, used in wtgcsv_install() for failed install
 * @todo function to be complete
 */
function wtgcsv_remove_contentfolder(){

}

/**
 * Uninstall most options, database tables, files etc
 * Does not remove permanent options left to track plugin version, installation issues or other data that
 * may be critical to future use of the plugin on the same blog
 * 
 * Leaves the single value options to control installation status for re-install actions or temporary un-install
 */
function wtgcsv_uninstall(){
    $uninstall_outcome = true;

    // delete administration only settings
    if(!delete_option(WTG_CSV_ABB . 'adminset')){
        $uninstall_outcome = false;
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'adminset could not be deleted';
        $wtgcsv_log['style'] = 'error';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }else{
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'adminset was deleted';
        $wtgcsv_log['style'] = 'success';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }
    
    # delete public related settings
    if(!delete_option(WTG_CSV_ABB . 'publicset')){
        $uninstall_outcome = false;
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'publicset could not be deleted';
        $wtgcsv_log['style'] = 'error';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }else{
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'publicset was deleted';
        $wtgcsv_log['style'] = 'success';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    } 
    // delete tab navigation array settings
    if(!delete_option(WTG_CSV_ABB . 'easyset')){
        $uninstall_outcome = false;
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'easyset could not be deleted';
        $wtgcsv_log['style'] = 'error';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }else{
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'easyset was deleted';
        $wtgcsv_log['style'] = 'success';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }  
    // delete tab navigation array settings
    if(!delete_option(WTG_CSV_ABB . 'tabmenu')){
        $uninstall_outcome = false;
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'tabmenu could not be deleted';
        $wtgcsv_log['style'] = 'error';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }else{
        $wtgcsv_log = array();
        $wtgcsv_log['line'] = __LINE__;
        $wtgcsv_log['file'] = __FILE__;
        $wtgcsv_log['function'] = __FUNCTION__;
        $wtgcsv_log['type'] = 'general';// general,sql,admin,user,error
        $wtgcsv_log['comment'] = 'Options record named '.WTG_CSV_ABB.'tabmenu was deleted';
        $wtgcsv_log['style'] = 'success';
        $wtgcsv_log['category'] = 'install';
        wtgcsv_log($wtgcsv_log);
    }
    return $uninstall_outcome;
}  

/**
* Must be called using add_action( 'init', 'wtgcsv_register_customposttype_contentdesigns' )
* Registers custom post type for content only
* 
* @todo MEDIUMPRIORITY, add installation status check on install status screen for this custom post type using http://codex.wordpress.org/Function_Reference/post_type_exists
*/
function wtgcsv_register_customposttype_contentdesigns() {
    $labels = array(
        'name' => _x('Content Templates', 'post type general name'),
        'singular_name' => _x('Content Template', 'post type singular name'),
        'add_new' => _x('Create', 'wtgcsvcontent'),
        'add_new_item' => __('Create Content Template'),
        'edit_item' => __('Edit Content Template'),
        'new_item' => __('Create Content Template'),
        'all_items' => __('All Content Templates'),
        'view_item' => __('View Content Template'),
        'search_items' => __('Search Content Templates'),
        'not_found' =>  __('No content templates found'),
        'not_found_in_trash' => __('No content templates found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'Content Templates'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => array( 'title', 'editor','custom-fields' )
    );   

    register_post_type( 'wtgcsvcontent', $args );
}

/**
* Register custom post type for title templates 
*/
function wtgcsv_register_customposttype_titledesigns() {
    $labels = array(
        'name' => _x('Title Templates', 'post type general name'),
        'singular_name' => _x('Title Template', 'post type singular name'),
        'add_new' => _x('Create', 'wtgcsvcontent'),
        'add_new_item' => __('Create Title Template'),
        'edit_item' => __('Edit Title Template'),
        'new_item' => __('Create Title Template'),
        'all_items' => __('All Title Templates'),
        'view_item' => __('View Title Template'),
        'search_items' => __('Search Title Templates'),
        'not_found' =>  __('No title templates found'),
        'not_found_in_trash' => __('No title templates found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'Title Templates'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => array( 'title', 'editor','custom-fields' )
    );   

    register_post_type( 'wtgcsvtitle', $args );
}

/**
* Called in installation process to add_action for custom post types
*/
function wtgcsv_install_customposttypes(){
    add_action( 'init', 'wtgcsv_register_customposttype_contentdesigns' );        
}
?>