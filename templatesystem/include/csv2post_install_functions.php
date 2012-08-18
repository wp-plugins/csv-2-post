<?php
/**
 * Checks if plugin has been installed before (not security and not indication of full existing installation)
 */
function csv2post_was_installed(){
    global $csv2post_options_array,$csv2post_templatesystem_files;
    
    $result = false;
    
    if(isset($csv2post_options_array) && is_array($csv2post_options_array)){
        // check possible option records
        foreach($csv2post_options_array as $id => $optionrecord){
     
            // avoid checking tab menu as that is added to blow on Wordpress plugin activation, we do not want to use it as an indication of install
            if($id != WTG_C2P_ABB.'tabmenu' 
            && $id != WTG_C2P_ABB.'installedversion' 
            && $id != WTG_C2P_ABB.'installeddate' 
            && $id != WTG_C2P_ABB.'activationdate'){
                                        
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
function csv2post_is_activated(){ 
   global $csv2post_activationcode;
   return false;
}

/**
* Checks if plugin IS FULLY INSTALLED (all required options arrays,folders,path files etc)
* Another function and variable establishes if the plugin WAS installed in the past by finding a trace
* 
* @see csv2post_variables_admin.php
* 
* @todo HIGHPRIORITY, ensure this function only runs when admin logged in
*/
function csv2post_is_installed(){
    
    global $csv2post_options_array;
    
    if(!isset($csv2post_options_array) || !is_array($csv2post_options_array)){
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
                 
    foreach($csv2post_options_array as $id => $optionrecord){
             
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
    $templatefiles_result = csv2post_templatefiles_missing(false);
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
function csv2post_install(){
    
    // settings arrays are includes by 
    global $csv2post_adm_set,$csv2post_pub_set,$csv2post_eas_set,$csv2post_mpt_arr,$csv2post_currentversion;

    $minor_fails = 0;// count minor number of failures, if 3 or more then we'll call it a failed install
    $overall_install_result = true;// used to indicate overall result

    // register custom post types (currently one for post content designs)
    csv2post_install_customposttypes();
    
    // clean up existing installation to prevent conflict
    csv2post_uninstall();

    update_option(WTG_C2P_ABB . 'installedversion',$csv2post_currentversion);
    update_option(WTG_C2P_ABB . 'installeddate',time());
    add_option(WTG_C2P_ABB . 'activationdate',time());// track original first use on current blog
        
    // install admin only settings
    if(!add_option(WTG_C2P_ABB.'adminset',serialize($csv2post_adm_set))){
        
        // should never happen - csv2post_uninstall() used at the beginning of csv2post_install()
        csv2post_notice('Adding option '.WTG_C2P_ABB.'adminset returned false, this is usually because it already exists.','error','Tiny',false);
        
        $overall_install_result = false;          
        
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'adminset could not be installed';
        $csv2post_log['style'] = 'error';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);

    }else{
        
        csv2post_notice('Installed option record called '.WTG_C2P_ABB.'adminset','success','Tiny',false);
        
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'adminset was installed';
        $csv2post_log['style'] = 'success';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }

    // install main public settings option record
    if(!add_option(WTG_C2P_ABB.'publicset',serialize($csv2post_pub_set))){
        
        // should never happen - csv2post_uninstall() used at the beginning of csv2post_install()
        csv2post_notice('Adding option '.WTG_C2P_ABB.'publicset returned false, this is usually because it already exists.','error','Tiny',false);
        
        $overall_install_result = false;
        
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'publicset could not be installed';
        $csv2post_log['style'] = 'error';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }else{
        csv2post_notice('Installed option record called '.WTG_C2P_ABB.'publicset','success','Tiny',false);
        
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'publicset was installed';
        $csv2post_log['style'] = 'success';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }
         
    // install easy configuration question default answers - see csv2post_variables_easy.php     
    if(!add_option(WTG_C2P_ABB.'easyset',serialize($csv2post_eas_set))){
        
        // should never happen - csv2post_uninstall() used at the beginning of csv2post_install()
        csv2post_notice('Adding option '.WTG_C2P_ABB.'easyset returned false, this is usually because it already exists.','error','Tiny',false);
        
        $overall_install_result = false;          
        
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'easyset could not be installed';
        $csv2post_log['style'] = 'error';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);

    }else{
        csv2post_notice('Installed option record called '.WTG_C2P_ABB.'easyset','success','Tiny',false);
        
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'easyset was installed';
        $csv2post_log['style'] = 'success';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }

    // install admin menu array - see csv2post_variables_adminconfig.php
    if(!add_option(WTG_C2P_ABB.'tabmenu',serialize($csv2post_mpt_arr))){
        
        // should never happen - csv2post_uninstall() used at the beginning of csv2post_install()
        csv2post_notice('Adding option '.WTG_C2P_ABB.'tabmenu returned false, this is usually because it already exists.','error','Tiny',false);
        
        $overall_install_result = false;          
        
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'tabmenu could not be installed';
        $csv2post_log['style'] = 'error';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);

    }else{
        csv2post_notice('Installed option record called '.WTG_C2P_ABB.'tabmenu','success','Tiny',false);
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'tabmenu was installed';
        $csv2post_log['style'] = 'success';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }
        
    // update switches
    update_option(WTG_C2P_ABB . 'is_installed',true);
    update_option(WTG_C2P_ABB . 'was_installed',true); 
    update_option(WTG_C2P_ABB . 'installeddate',time());
    update_option(WTG_C2P_ABB . 'installedversion',$csv2post_currentversion);
           
    // create or confirm content folder for storing main uploads - false means no folder wanted, otherwise a valid path is expected
    if( defined("WTG_C2P_CONTENTFOLDER_DIR")){$overall_install_result = csv2post_install_contentfolder(WTG_C2P_CONTENTFOLDER_DIR);}

    // if there were too many minor fails, the installation is a failure
    if($minor_fails > 2){
        $overall_install_result = false;
    }

    if($overall_install_result == false){
        csv2post_notice( 'You are attempting to run a First-Time Install but there was a problem. If you have installed the plugin previously, it
            could be because there is a trace of that installation still in your blog. Please use the Un-Install feature then try again. First-Time
            Installation is designed only for first time use on a blog unless you have used the Un-Install feature to remove any trace of a previous
            installation.','error','Large','Installation Problems','');
    }

    return $overall_install_result;
}

/*
 * Removes the plugins main wp-content folder, used in csv2post_install() for failed install
 * @todo function to be complete
 */
function csv2post_remove_contentfolder(){

}

/**
 * Uninstall most options, database tables, files etc
 * Does not remove permanent options left to track plugin version, installation issues or other data that
 * may be critical to future use of the plugin on the same blog
 * 
 * Leaves the single value options to control installation status for re-install actions or temporary un-install
 */
function csv2post_uninstall(){
    $uninstall_outcome = true;

    // delete administration only settings
    if(!delete_option(WTG_C2P_ABB . 'adminset')){
        $uninstall_outcome = false;
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'adminset could not be deleted';
        $csv2post_log['style'] = 'error';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }else{
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'adminset was deleted';
        $csv2post_log['style'] = 'success';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }
    
    # delete public related settings
    if(!delete_option(WTG_C2P_ABB . 'publicset')){
        $uninstall_outcome = false;
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'publicset could not be deleted';
        $csv2post_log['style'] = 'error';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }else{
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'publicset was deleted';
        $csv2post_log['style'] = 'success';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    } 
    // delete tab navigation array settings
    if(!delete_option(WTG_C2P_ABB . 'easyset')){
        $uninstall_outcome = false;
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'easyset could not be deleted';
        $csv2post_log['style'] = 'error';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }else{
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'easyset was deleted';
        $csv2post_log['style'] = 'success';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }  
    // delete tab navigation array settings
    if(!delete_option(WTG_C2P_ABB . 'tabmenu')){
        $uninstall_outcome = false;
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'tabmenu could not be deleted';
        $csv2post_log['style'] = 'error';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }else{
        $csv2post_log = array();
        $csv2post_log['line'] = __LINE__;
        $csv2post_log['file'] = __FILE__;
        $csv2post_log['function'] = __FUNCTION__;
        $csv2post_log['type'] = 'general';// general,sql,admin,user,error
        $csv2post_log['comment'] = 'Options record named '.WTG_C2P_ABB.'tabmenu was deleted';
        $csv2post_log['style'] = 'success';
        $csv2post_log['category'] = 'install';
        csv2post_log($csv2post_log);
    }
    return $uninstall_outcome;
}  

/**
* Must be called using add_action( 'init', 'csv2post_register_customposttype_contentdesigns' )
* Registers custom post type for content only
* 
* @todo MEDIUMPRIORITY, add installation status check on install status screen for this custom post type using http://codex.wordpress.org/Function_Reference/post_type_exists
*/
function csv2post_register_customposttype_contentdesigns() {
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
function csv2post_register_customposttype_titledesigns() {
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
function csv2post_install_customposttypes(){
    add_action( 'init', 'csv2post_register_customposttype_contentdesigns' );        
}
?>