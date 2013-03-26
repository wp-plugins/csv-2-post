<?php
/**
 * Installs the main elements for all packages
 */
function csv2post_install_core(){
    
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
    require(WTG_C2P_DIR.'include/variables/csv2post_variables_notices_array.php');
    if( !csv2post_option('csv2post_notifications','add',serialize($csv2post_persistent_array)) ){
        // should never happen - _uninstall() used at the beginning of _install_core()
        csv2post_notice('Notification settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');
        $overall_install_result = false;          
    }else{
        csv2post_notice('Installed the notification settings','success','Tiny',false,'','echo');
    }    

    // theme - only change the theme value when it is not set 
    // February 2013: changed to jquery or css rather than actual themes     
    if(!csv2post_option('csv2post_theme','get')){
        csv2post_option('csv2post_theme','add','jquery');# jquery or wordpresscss
    }         
                             
    // extension switch option record
    if(!csv2post_option('csv2post_extensions','get')){
        csv2post_option('csv2post_extensions','add','disable');    
    }
                    
    // update switches
    update_option('csv2post_is_installed',true);
    update_option('csv2post_was_installed',true); 
    
    // installed version will only be updated when user prompted to upgrade rather than activation
    update_option('csv2post_installedversion',$csv2post_currentversion);  

    // update the installed date, this includes the installed date of new versions
    update_option('csv2post_installeddate',time());
    
    // extensions - set extensions active by default (if user adds extension files prior to CSV 2 POST install this avoids no permissions screen showing)
    update_option('csv2post_extensions','enable');
           
    // this date never changes, we also want to avoid user deleted it
    csv2post_option('csv2post_activationdate','add',time());### TODO:LOWPRIORITY, hide this option from un-install page, we want this to be included as a trace of previous installation

    ###########################################
    #                                         #
    #    PLUGIN AND EXTENSION INSTALLATION    #
    #                                         #
    ###########################################
    
    // install plugin (not core)
    $overall_install_result = csv2post_install_plugin();
    
    // if extension defined run extension installation functions    
    if($csv2post_extension_loaded){  
        // ensure csv2post_install_extension() function is loaded else the extension is not 
        if(!function_exists('csv2post_install_extension')){
            csv2post_notice('No extension could be installed due to the
            csv2post_install_extension() function not being loaded. It
            could simply mean that no extension is meant to be installed
            or the extension package is not complete. We would appreciate
            this message being reported. You may need to un-install
            the plugin and do a re-install.','error','Large','Extension Not Installed');    
        }else{
            csv2post_install_extension();### TODO:LOWPRIORITY, this function should return and update $overall_install_result for better installation result overview    
        }
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
                csv2post_notice('A files important for the plugin to operate appear to be missing. The expect
                file should be on the follow path...<br /><br />' . $path,'error','Small',' Core File Missing: ','','echo');             
            }
              
            return true;// yes file is missing
        } 
    }
        
    return false; 
}
?>
