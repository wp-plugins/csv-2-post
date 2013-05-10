<?php
/**
 * Installs the main elements for all packages
 */
function csv2post_install_core(){
    
    ######################
    #                    #                          
    #     CORE FIRST     #
    #                    #                           
    ######################
    
    /**
    * We install the core first. 
    * 1. tab menu array
    * 2. initial admin options (we)
    * 3. log table
    * 4. other core elements used by ALL packages
    */
    
    // settings arrays are includes by 
    global $csv2post_extension_loaded,$csv2post_pub_set,$csv2post_mpt_arr,$csv2post_currentversion,$csv2post_is_free;

    $minor_fails = 0;// count minor number of failures, if 3 or more then we'll call it a failed install
    $overall_install_result = true;// used to indicate overall result
        
    #################################################
    #                                               #
    #       INSTALL SCHEDULE ARRAY NOTICE ARRAY     #
    #                                               #
    #################################################
    if(!$csv2post_is_free){
        require(WTG_C2P_DIR.'include/variables/csv2post_schedule_array.php');
        if(!csv2post_option('csv2post_schedule','add',serialize($csv2post_schedule_array)) ){
             
            // should never happen - _uninstall() used at the beginning of _install_core()
            csv2post_notice('Schedule settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');
            csv2post_n('Schedule Settings Already Installed','Schedule settings are already installed, no changes were made to those settings.','warning','Tiny');
            $overall_install_result = false;          
       
        }else{
            csv2post_notice('Installed the schedule settings','success','Tiny',false,'','echo');
            csv2post_n('Schedule Settings Already Installed','Schedule settings are already installed, no changes were made to those settings.','warning','Tiny');
        }
    }
    csv2post_n('Schedule Settings Already Installed','Schedule settings are already installed, no changes were made to those settings.','warning','Tiny');
    
    #################################################
    #                                               #
    #         INSTALL PERSISTENT NOTICE ARRAY       #
    #                                               #
    #################################################
    require(WTG_C2P_DIR.'include/variables/csv2post_variables_notices_array.php');
    if( !csv2post_option('csv2post_notifications','add',serialize($csv2post_persistent_array)) ){
        // should never happen - _uninstall() used at the beginning of _install_core()
        csv2post_notice('Notification settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');
        $overall_install_result = false;          
    }else{
        csv2post_notice('Installed the notification settings','success','Tiny',false,'','echo');
    }    

    // theme - only change the theme value when it is not set  
    if(!csv2post_option('csv2post_theme','get')){
        csv2post_option('csv2post_theme','add','jquery');# jquery or wordpresscss
    }         
                             
    // extension switch option record
    if(!csv2post_option('csv2post_extensions','get')){
        csv2post_option('csv2post_extensions','add','disable');    
    }
      
    // installation state values
    update_option('csv2post_is_installed',true);
    update_option('csv2post_was_installed',true); 
    update_option('csv2post_installedversion',$csv2post_currentversion);# will only be updated when user prompted to upgrade rather than activation
    update_option('csv2post_installeddate',time());# update the installed date, this includes the installed date of new versions
    csv2post_option('csv2post_activationdate','add',time());# this date never changes, we also want to avoid user deleted it

    return $overall_install_result;
}

/**
* Checks all critical template system files and returns
* @return boolean, true if all files found or false if any are missing 
*/
function csv2post_templatefiles_missing($output = false){
    global $csv2post_templatesystem_files;

    if(!isset($csv2post_templatesystem_files) || !is_array($csv2post_templatesystem_files)){
        return false;
    }
        
    foreach( $csv2post_templatesystem_files as $key => $fileitem ){
        
        $path = '';          
        $path .= WTG_C2P_DIR . $fileitem['path'] . $fileitem['name'];
         
        if($fileitem['extension'] != 'folder'){        
            $path .= '.' . $fileitem['extension']; 
        }

        if(!file_exists($path)){ 
              
            if($output){
                csv2post_notice('A file important for the plugin to operate could not be located. The expected
                file should be on the follow path...<br /><br />' . $path,'error','Small',' Core File Missing: ','','echo');             
            }
              
            return true;// yes file is missing
        } 
    }
        
    return false; 
}

/**
* Creates csv2post_log
* @link http://www.csv2post.com/hacking/log-table
*/
function csv2post_INSTALL_table_log(){
    $table_name = 'csv2post_log';

    if(csv2post_WP_SQL_does_table_exist($table_name)){
        csv2post_notice('Database table named csv2post_log already exists.','warning','Tiny','','','echo');    
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

function csv2post_INSTALL_table_flags(){
    $table_name = 'csv2post_flags';

    if(csv2post_WP_SQL_does_table_exist($table_name)){
        csv2post_notice('Database table named '.$table_name.' already exists.','warning','Tiny','','','echo');    
    }else{ 
        global $wpdb;
        
        // table name and index 
        $create = 'CREATE TABLE `'.$table_name.'` (
        `rowid` int(11) NOT NULL AUTO_INCREMENT,';
        
        // columns set by flag call
        $create .= '`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,';
        $create .= '`phpline` int(11) DEFAULT NULL,';#__LINE__
        $create .= '`phpfunction` int(11) DEFAULT NULL,';#__FUNCTION__       
        $create .= '`priority` varchar(45) DEFAULT NULL,';# low|normal|high 
        $create .= '`type` varchar(45) DEFAULT NULL,';# file|data|user|error (errors will be displayed in beta mode only)
        $create .= '`fileurl` varchar(250) DEFAULT NULL,';# flagged file - could be an attachment or file front end user uploaded
        $create .= '`dataid` varchar(250) DEFAULT NULL,';# if type = data, this holds the row id being flagged
        $create .= '`userid` varchar(250) DEFAULT NULL,';# if type = user, this is the user being flagged
        $create .= '`errortext` varchar(250) DEFAULT NULL,';# if type = error, this is a dump of the error
        $create .= '`projectid` varchar(250) DEFAULT NULL,';# i.e. data import job ID or post creation project ID involved 
        $create .= '`reason` varchar(250) DEFAULT NULL,';# why has it been flagged?
        $create .= '`action` varchar(250) DEFAULT NULL,';# what should or could user do about the flag?        
  
        // default columns (set by flagging function)
        $create .= '`version` varchar(45) DEFAULT NULL,';# plugin version
        
        // table config 
        $create .= '   
        PRIMARY KEY (`rowid`),
        UNIQUE KEY `rowid` (`rowid`)) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8';
        
        $result = $wpdb->query( $create ); 
         
        if( $result ){
            csv2post_notice('Database table named '.$table_name.' has been created. This table is part of
            the flagging system which will notify or remind you about things happening in your blog.','success','Tiny','','','echo');
            return true;
        }else{
            csv2post_notice('Database table named '.$table_name.' could not be created. This must be investigated before using the plugin','error','Tiny','','','echo');
            return false;
        }
    }  
}

/**
* Quick way to delete then install all core database tables                             
*/
function csv2post_INSTALL_reinstall_databasetables(){
    global $csv2post_tables_array,$wpdb;
    $result_array = csv2post_ARRAY_init('result array for database table re-installation',__LINE__,__FUNCTION__,__FILE__,'result array',true);
    $result_array['droppedtables'] = array();
    
    if(is_array($csv2post_tables_array)){
        
        // delete all tables
        foreach($csv2post_tables_array['tables'] as $key => $table){
           
            if(csv2post_WP_SQL_does_table_exist($table['name'])){         
                $wpdb->query( 'DROP TABLE '. $table['name'] );
                ### TODO:LOWPRIORITY, we can check DROP outcome and change outcome to false with details
                $result_array['droppedtables'][] = $table['name'];
            }                                                             
        }
        
        // now install tables
        csv2post_INSTALL_table_log();
  
    }else{
        $result_array['outcome'] = false;
        $result_array['failreason'] = 'tables array is not an array';
    }   
    
    return $result_array;
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
    $csv2post_qs_array = array();
    $csv2post_qs_array['arrayupdated'] = time();
    $csv2post_qs_array['nextstep'] = 1;  
    csv2post_option('csv2post_ecisession','update',serialize($csv2post_qs_array));
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
 * Removes the plugins main wp-content folder, used in csv2post_install_core() for failed install
 * @todo function to be complete
 */
function csv2post_remove_contentfolder(){

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
?>
