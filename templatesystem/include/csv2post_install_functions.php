<?php
/**
* Call this function to check everything that can be checked.
* Add functions to this function that create notice output only. The idea is that the user
* gets a very descriptive status of the plugin and for troubleshooting we can browse a long list
* of notifications for anything unusual.* 
* 
* @todo complete this function
*/
function csv2post_diagnostic_core(){
    
    # Update the options array with core options and use it to detect the installation status or use existing fuction that does that
    
    ######################################
    #                                    #
    #     CUSTOM PLUGIN DIAGNOSTICS      #
    #                                    #
    ######################################
    csv2post_diagnostic_custom();
    
}

/**
* This diagnostic is specific to the custom plugin i.e. CSV 2 POST or Easy CSV Importer.
* 1. Call this function in csv2post_diagnostic_core
*/
function csv2post_diagnostic_custom(){
    
    # Check CSV 2 POST option records, not core options records such as menu or installation status records
    
    # check status of all projects database table, if any missing alert, if any still do not have records alert
    
    # MAYBE query posts not updated since project change 
    
    # MAYBE query posts not updated since thier record was changed (a way to idendify updating not frequent enough)
    
}

/**
 * Installs anything not yet installed (does not destroy existing values)
 * Updates values or files that have changed in a newer version.
 * 
 * 1. Do not use the individual INSTALL functions, they use update
 * 
 * @todo include folders and database tables in the installation summary not just option keys
 */
function csv2post_install(){
    
    // settings arrays are includes by 
    global $csv2post_pub_set,$csv2post_mpt_arr,$csv2post_currentversion,$csv2post_is_free;

    $minor_fails = 0;// count minor number of failures, if 3 or more then we'll call it a failed install
    $overall_install_result = true;// used to indicate overall result

    #################################################
    #                                               #
    #       INSTALL SCHEDULE ARRAY NOTICE ARRAY     #
    #                                               #
    #################################################
    if(!$csv2post_is_free){
        require(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_schedule_array.php');
        if( !csv2post_option('csv2post_schedule','add',serialize($csv2post_schedule_array)) ){
             
            // should never happen - csv2post_uninstall() used at the beginning of csv2post_install()
            csv2post_notice('Schedule settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');

            $overall_install_result = false;          
       
        }else{
            csv2post_notice('Installed the schedule settings','success','Tiny',false,'','echo');
        }
    }
    
    #################################################
    #                                               #
    #         INSTALL PERSISTENT NOTICE ARRAY       #
    #                                               #
    #################################################
    require(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_variables_notices_array.php');
    if( !csv2post_option('csv2post_notifications','add',serialize($csv2post_persistent_array)) ){
         
        // should never happen - csv2post_uninstall() used at the beginning of csv2post_install()
        csv2post_notice('Notification settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');
        
        $overall_install_result = false;          
   
    }else{
        csv2post_notice('Installed the notification settings','success','Tiny',false,'','echo');
    }  
    
    #################################################
    #                                               #
    #                INSTALL ECI ARRAY              #
    #                                               #
    #################################################
    $csv2post_eci_session_array = array();
    $csv2post_eci_session_array['arrayupdated'] = time();
    $csv2post_eci_session_array['nextstep'] = 1;  
    if( !csv2post_option('csv2post_ecisession','add',serialize($csv2post_eci_session_array)) ){
         
        // should never happen - csv2post_uninstall() used at the beginning of csv2post_install()
        csv2post_notice('Easy CSV Importer settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');
        
        $overall_install_result = false;          
   
    }else{
        csv2post_notice('Installed the Easy CSV Importer settings','success','Tiny',false,'','echo');
    }       

    // theme - only change the theme value when it is not set      
    if(!csv2post_option('csv2post_theme','get')){
        csv2post_option('csv2post_theme','add','start');
    }         
                             
    // extension
    if(!csv2post_option('csv2post_extensions','get')){
        csv2post_option('csv2post_extensions','add','disable');    
    }
                    
    // update switches
    update_option('csv2post_is_installed',true);
    update_option('csv2post_was_installed',true); 
  
    // register custom post types (currently one for post content designs)
    csv2post_install_customposttypes();
    
    // installed version will only be updated when user prompted to upgrade rather than activation
    add_option('csv2post_installedversion',$csv2post_currentversion);### TODO:LOWPRIORITY, hide this option from un-install page, we want this to be included as a trace of previous installation  
    
    // update the installed date, this includes the installed date of new versions
    update_option('csv2post_installeddate',time());
    
    // this date never changes, we also want to avoid user deleted it
    csv2post_option('csv2post_activationdate','add',time());### TODO:LOWPRIORITY, hide this option from un-install page, we want this to be included as a trace of previous installation
    
    // create or confirm content folder for storing main uploads - false means no folder wanted, otherwise a valid path is expected
    if( defined("WTG_C2P_CONTENTFOLDER_DIR")){$overall_install_result = csv2post_install_contentfolder(WTG_C2P_CONTENTFOLDER_DIR);}

    // if extension defined run extension installation functions    
    if(defined("WTG_C2P_EXT")){  
        csv2post_install_extension();
    }
                
    // if there were to many minor fails, the installation is a failure
    if($minor_fails > 2){
        $overall_install_result = false;
    }

    if($overall_install_result == false){
        csv2post_notice( 'You are attempting to run a First-Time Install but there was a problem. If you have installed the plugin previously, it
        could be because there is a trace of that installation still in your blog. Please use the Un-Install feature then try again. First-Time
        Installation is designed only for first time use on a blog unless you have used the Un-Install feature to remove any trace of a previous
        installation.','error','Large','Installation Problems','','echo');
    }

    return $overall_install_result;
}

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

                // change return switch to false if option not found
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

### TODO:MEDIUMPRIORITY, move install functions to the core file and test, delete install_functions file

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
             
    // currently this value is returned, if changed to false
    $returnresult = true;
    $failcause = 'Not Known';// only used for debugging to determine what causes indication of not fully installed
    
    // function only returns boolean but if required we will add results array to the log
    $is_installed_result = array();
    $is_installed_result['finalresult'] = false;
    $is_installed_result['options'] = null;
                
    foreach($csv2post_options_array as $id => $optionrecord){
            
        if($optionrecord['required'] == true){
                    
            $currentresult = get_option($id);    
            
            $is_installed_result['options'][$id]['result'] = $currentresult;
                        
            // change return switch to false if option not found
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

/*
 * Removes the plugins main wp-content folder, used in csv2post_install() for failed install
 * @todo function to be complete
 */
function csv2post_remove_contentfolder(){

}

/**
 * NOT IN USE
 * @todo LOWPRIORITY, make this function perform a 100% uninstallation including CSV files, tables, option records the whole lot. This should be offered clearly as a destructive process for anyone who wants to continue using the plugin.
 */
function csv2post_uninstall(){
    $uninstall_outcome = true;

    // delete administration only settings
    delete_option('csv2post_adminset');
    
    // delete public related settings
    delete_option('csv2post_publicset');

    // delete tab navigation array settings
    delete_option('csv2post_tabmenu');

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

/**
* DO NOT CALL DURING FULL PLUGIN INSTALL
* This function uses update. Do not call it during full install because user may be re-installing but
* wishing to keep some existing option records.
* 
* Use this function when installing admin settings during use of the plugin. 
*/
function csv2post_INSTALL_admin_settings(){
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_variables_adminset_array.php');
    return csv2post_option('csv2post_adminset','update',$csv2post_adm_set);# update creates record if it does not exist   
}

/**
* DO NOT CALL DURING FULL PLUGIN INSTALL
* This function uses update. Users may want their installation to retain old values, we cannot assume the
* installation is 100% fresh.
* 
* Use this function when the tab menu option array is missing or invalid or when user actions a re-install of everything 
*/
function csv2post_INSTALL_tabmenu_settings(){
    require_once(WTG_C2P_DIR.'pages/csv2post_variables_tabmenu_array.php');
    $result = csv2post_option('csv2post_tabmenu','update',$csv2post_mpt_arr);   
} 

/**
* Installs the Easy CSV Importer by using update.
* This function should not be used during plugin installation because it
* would destroy values that the user may be trying to retain for a new
* installation. 
*/
function csv2post_INSTALL_ecisession(){
    $csv2post_eci_session_array = array();
    $csv2post_eci_session_array['arrayupdated'] = time();
    $csv2post_eci_session_array['nextstep'] = 1;  
    csv2post_option('csv2post_ecisession','update',serialize($csv2post_eci_session_array));
}
?>
