<?php
function csv2post_install_plugin(){
    
    $overall_install_result = true;
    
    #################################################
    #                                               #
    #                INSTALL ECI ARRAY              #
    #                                               #
    #################################################
    $csv2post_eci_session_array = array();
    $csv2post_eci_session_array['arrayupdated'] = time();
    $csv2post_eci_session_array['nextstep'] = 1;  
    if( !csv2post_option('csv2post_ecisession','add',serialize($csv2post_eci_session_array)) ){
        // should never happen - csv2post_uninstall() used at the beginning of csv2post_install_core()
        csv2post_notice('Quick Start settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');          
    }else{
        csv2post_notice('Installed the Quick Start settings','success','Tiny',false,'','echo');
    }    
    
    // register custom post types (currently one for post content designs)
    csv2post_install_customposttypes();### MEDIUMPRIORITY, this should be moved or contents moved to main file as it only has add_action()
    
    // create or confirm content folder for storing main uploads - false means no folder wanted, otherwise a valid path is expected
    if( defined("WTG_C2P_CONTENTFOLDER_DIR")){$overall_install_result = csv2post_install_contentfolder_wpcsvimportercontent(WTG_C2P_CONTENTFOLDER_DIR);}        

    return $overall_install_result;
}

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
* This diagnostic is specific to the custom plugin i.e. CSV 2 POST or Quick Start.
* 1. Call this function in csv2post_diagnostic_core
*/
function csv2post_diagnostic_custom(){
    
    # Check CSV 2 POST option records, not core options records such as menu or installation status records
    
    # check status of all projects database table, if any missing alert, if any still do not have records alert
    
    # MAYBE query posts not updated since project change 
    
    # MAYBE query posts not updated since thier record was changed (a way to idendify updating not frequent enough)
    
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
* @todo MEDIUMPRIORITY, return a result array so we can make use of negative installation state reason
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
 * Removes the plugins main wp-content folder, used in csv2post_install_core() for failed install
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
    require_once(WTG_C2P_DIR.'include/variables/csv2post_variables_adminset_array.php');
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
* Installs the Quick Start by using update.
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


function csv2post_INSTALL_reinstall_databasetables(){
    global $csv2post_tables_array,$wpdb;
    $result_array = csv2post_ARRAY_init('result array for database table re-installation',__LINE__,__FUNCTION__,__FILE__,'result array',true);
    $result_array['droppedtables'] = array();
    
    if(is_array($csv2post_tables_array)){
        foreach($csv2post_tables_array['tables'] as $key => $table){
           
            if(csv2post_WP_SQL_does_table_exist($table['name'])){         
                $wpdb->query( 'DROP TABLE '. $table['name'] );
                ### TODO:LOWPRIORITY, we can check DROP outcome and change outcome to false with details
                $result_array['droppedtables'][] = $table['name'];
            }                                                             
        }
        
        // csv2post_ryanair_session
        csv2post_INSTALL_table_log();
  
    }else{
        $result_array['outcome'] = false;
        $result_array['failreason'] = 'tables array is not an array';
    }   
    
    return $result_array;
}

/**
* Creates csv2post_log
* @link http://www.csv2post.com/hacking/log-table
* 
* @todo LOWPRIORITY, a default is set in code but lets set a default for "type" anyway based on the value that queries all log entries, probably all but needs confirmed 
*/
function csv2post_INSTALL_table_log(){
    $table_name = 'csv2post_log';

    if(csv2post_WP_SQL_does_table_exist($table_name)){
        csv2post_notice('Database table named csv2post_ryanair_session already exists.','warning','Tiny','','','echo');    
    }else{ 
        global $wpdb;
        
        // table name 
        $create = 'CREATE TABLE `'.$table_name.'` (';

        // columns - please update http://www.csv2post.com/hacking/log-table   
        $create .= '`rowid` int(11) NOT NULL AUTO_INCREMENT,
        `outcome` tinyint(1) NOT NULL DEFAULT 1,
        `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `line` int(11) DEFAULT NULL,
        `file` varchar(250) DEFAULT NULL,
        `function` varchar(250) DEFAULT NULL,
        `sqlresult` blob,
        `sqlquery` varchar(45) DEFAULT NULL,
        `sqlerror` mediumtext,
        `wordpresserror` mediumtext,
        `screenshoturl` varchar(500) DEFAULT NULL,
        `userscomment` mediumtext,
        `page` varchar(45) DEFAULT NULL,
        `version` varchar(45) DEFAULT NULL,
        `panelid` varchar(45) DEFAULT NULL,
        `panelname` varchar(45) DEFAULT NULL,
        `tabscreenid` varchar(45) DEFAULT NULL,
        `tabscreenname` varchar(45) DEFAULT NULL,
        `dump` longblob,
        `ipaddress` varchar(45) DEFAULT NULL,
        `userid` int(11) DEFAULT NULL,
        `comment` mediumtext,
        `type` varchar(45) DEFAULT NULL,
        `category` varchar(45) DEFAULT NULL,
        `action` varchar(45) DEFAULT NULL,
        `priority` varchar(45) DEFAULT NULL,        
        PRIMARY KEY (`rowid`),
        UNIQUE KEY `rowid` (`rowid`)';

        // table config  
        $create .= ') ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8';
        
        $result = $wpdb->query( $create ); 
         
        if( $result ){
            csv2post_notice('Database table named '.$table_name.' has been created.','success','Tiny','','','echo');
            return true;
        }else{
            csv2post_notice('Database table named '.$table_name.' could not be created. This must be investigated before using the plugin','error','Tiny','','','echo');
            return false;
        }
    }  
}
?>