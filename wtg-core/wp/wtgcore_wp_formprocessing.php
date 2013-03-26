<?php
###########################################################
#                                                         #
#      FORM SUBMISSION PROCESSING FUNCTIONS FOR CORE      #
#                                                         #
###########################################################
 
/**
* Install Plugin - initial post submission validation  
*/
function csv2post_form_installpackage(){   
    if(isset( $_POST['csv2post_plugin_install_now'] ) && $_POST['csv2post_plugin_install_now'] == 'z3sx4bhik970'){
        global $csv2post_plugintitle;
        if(!current_user_can('activate_plugins')){
            csv2post_notice(__('You do not have the required permissions to activate '.$csv2post_plugintitle.'. 
            The Wordpress role required is activate_plugins, usually granted to Administrators. Please
            contact your Web Master or contact info@csv2post.com if you feel this is a fault.'), 'warning', 'Large', false);
        }else{                  
            csv2post_install_core();                
        }
        
        return false;
    }else{
        return true;
    }       
}

/**
* Partial Un-install Plugin Options 
*/
function csv2post_form_uninstallplugin_partial(){
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'install' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'partialuninstall'){  
        global $csv2post_plugintitle;
        
        if(current_user_can('delete_plugins')){
            
            // if delete data import job tables
            if(isset($_POST['csv2post_deletejobtables_array'])){

                foreach($_POST['csv2post_deletejobtables_array'] as $k => $table_name){
                    
                    $code = str_replace('csv2post_','',$table_name);

                    // if table still in use
                    if(isset($csv2post_dataimportjobs_array[$code])){
                        
                        csv2post_notice('Table '.$table_name.' is still used by Data Import Job named '.$csv2post_dataimportjobs_array[$code]['name'].'.','error','Tiny','Cannot Delete Table','','echo');
                        return false;
                        
                    }else{
                                        
                        // drop table
                        csv2post_SQL_drop_dataimportjob_table($table_name);
                        
                        csv2post_notice('Table ' . $table_name . ' was deleted.','success','Tiny','Table Deleted','','echo'); 
                    } 
                }
            }

            // if delete csv files
            if(isset($_POST['csv2post_deletecsvfiles_array'])){
                foreach($_POST['csv2post_deletecsvfiles_array'] as $k => $csv_file_name){

                    $file_is_in_use = false;
                    $file_is_in_use = csv2post_is_csvfile_in_use($csv_file_name);
                    
                    // if file is in use
                    if($file_is_in_use){
                        csv2post_notice('The file named ' . $csv_file_name .' is in use, cannot delete.','error','Tiny','File In Use','','echo');
                    }else{
                        unlink(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_file_name); 
                        csv2post_notice( $csv_file_name .' Deleted','success','Tiny','','','echo');
                    }
                                            
                }      
            }
            
            // if delete folders
            if(isset($_POST['csv2post_deletefolders_array'])){
                foreach($_POST['csv2post_deletefolders_array'] as $k => $o){
                    // currently only have one folder so we will use a specific function   
                    csv2post_delete_contentfolder(WTG_C2P_CONTENTFOLDER_DIR,false);
                }      
            }            

            // if delete options
            if(isset($_POST['csv2post_deleteoptions_array'])){
                foreach($_POST['csv2post_deleteoptions_array'] as $k => $o){
                    delete_option($o);
                    csv2post_notice('Option record ' . $o . ' has been deleted.','success','Tiny','Option Record Deleted','','echo');    
                }      
            }
                             
        }else{
            csv2post_notice(__('You do not have the required permissions to un-install '.$csv2post_plugintitle.'. The Wordpress role required is delete_plugins, usually granted to Administrators.'), 'warning', 'Large','No Permission To Uninstall ' . $csv2post_plugintitle,'','echo');
            return false;
        }
        
        // return false to stop all further post validation function calls
        return false;// must go inside $_POST validation, not at end of function 
        
    }else{
        return true;
    } 
}

/**
* Deletes flags (post meta for flagged posts)  
* @todo CRITICALPRIORITY, change to delete database held flags which are global not just applied to posts 
*/
function csv2post_form_delete_flags(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'latestten'){

        // if no flags selected
        if(!isset($_POST['csv2post_delete_flag'])){
            csv2post_notice('No flags were selected, please select the flags you would like to delete.','error','Large','No Flags Selected','','echo');    
            return false;
        }
        
        // loop through selected flags
        foreach($_POST['csv2post_delete_flag'] as $key => $metaid){
            delete_meta($metaid);        
        }

        csv2post_notice('All selected flags deleted','success','Large','Flags Deleted','','echo');#
        
        return false;
    }else{
        return true;
    }       
}

/**
* Save drip feed limits  
*/
function csv2post_form_save_schedulelimits(){
    global $csv2post_projectslist_array,$csv2post_schedule_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'schedulelimits'){

        // if any required values are not in $_POST set them to zero
        if(!isset($_POST['day'])){
            $csv2post_schedule_array['limits']['day'] = 0;        
        }else{
            $csv2post_schedule_array['limits']['day'] = $_POST['day'];            
        }
        
        if(!isset($_POST['hour'])){
            $csv2post_schedule_array['limits']['hour'] = 0;
        }else{
            $csv2post_schedule_array['limits']['hour'] = $_POST['hour'];            
        }
        
        if(!isset($_POST['session'])){
            $csv2post_schedule_array['limits']['session'] = 0;
        }else{
            $csv2post_schedule_array['limits']['session'] = $_POST['session'];            
        }
        
        csv2post_update_option_schedule_array($csv2post_schedule_array);
        
        csv2post_notice('Your drip-feed limits have been set and will take effect on all projects right now.','success','Large','Drip-Feeding Limits Saved');        
        
        return false;
    }else{
        return true;
    }      
}

/**
* Saves global allowed days and hours
*/
function csv2post_form_save_scheduletimes_global(){
    global $csv2post_projectslist_array,$csv2post_schedule_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'scheduletimes'){

        // ensure $csv2post_schedule_array is an array, it may be boolean false if schedule has never been set
        if(isset($csv2post_schedule_array) && is_array($csv2post_schedule_array)){
            
            // if times array exists, unset the [times] array
            if(isset($csv2post_schedule_array['days'])){
                unset($csv2post_schedule_array['days']);    
            }
            
            // if hours array exists, unset the [hours] array
            if(isset($csv2post_schedule_array['hours'])){
                unset($csv2post_schedule_array['hours']);    
            }
            
        }else{
            
            // $schedule_array value is not array, this is first time it is being set
            $csv2post_schedule_array = array();
        }
        
        // loop through all days and set each one to true or false
        if(isset($_POST['csv2post_scheduleday_list'])){

            foreach($_POST['csv2post_scheduleday_list'] as $key => $submitted_day){
                $csv2post_schedule_array['days'][$submitted_day] = true;        
            }
               
        } 
        
        // loop through all hours and add each one to the array, any not in array will not be permitted                              
        if(isset($_POST['csv2post_schedulehour_list'])){
            
            foreach($_POST['csv2post_schedulehour_list'] as $key => $submitted_hour){
                $csv2post_schedule_array['hours'][$submitted_hour] = true;        
            }            
            
        }    

        csv2post_update_option_schedule_array($csv2post_schedule_array);
        
        csv2post_notice('Your permitted days and hours for the automation scheduled have been saved.','success','Large','Schedule Times Saved');

        return false;
    }else{
        return true;
    }    
}

/**
* Contact Form Submission Post Validation 
*/
function csv2post_form_contactformsubmission(){     
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'more' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'contact'){
        global $csv2post_plugintitle;
        
        // result and control variables
        $failed = false;
        $failurereason = 'Unknown';
        
        // email output list - a simple unordered list to add entries to regarding the output of this contact
        $email_list_start = '<h4>Contact Outcome</h4><ul>'; 
        
        // email template - the main template for all details
        $email_template = '<strong>Contact Reason:</strong>stringreplace_contactreasons <br />
        <strong>Contact Methods:</strong> stringreplace_contactmethods <br />
        <strong>Contact Priority:</strong> stringreplace_priority <br />
        <h4>Description</h4>
        <strong>Contact Description:</strong> stringreplace_description <br />
        <h4>Links</h4>
        <strong>Link 1:</strong> stringreplace_linkone <br />
        <strong>Link 2:</strong> stringreplace_linktwo <br />
        <strong>Link 3:</strong> stringreplace_linkthree <br />
        <strong>Contact Methods:</strong> stringreplace_contactmethods <br />
        <strong>Contact Methods:</strong> stringreplace_contactmethods <br />'; 
        
        // add $_POST values to email template
        if(isset($_POST['multiselect_'.WTG_C2P_ABB.'contactmethods'])){
            // loop through contact methods and create comma seperated list    
        }
          
        if(isset($_POST['multiselect_'.WTG_C2P_ABB.'contactreason'])){
            // loop through contact reasons and create comma seperated list    
        }
         
        ### @todo HIGH PRIORITY  check the contact description post value here, it has wtg does it match with form ???   
        $stringreplace_result = str_replace('stringreplace_description',$_POST['wtg_contactdescription'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linkone',$_POST[WTG_C2P_ABB.'linkone'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linktwo',$_POST[WTG_C2P_ABB.'linktwo'],$email_template);    
        $stringreplace_result = str_replace('stringreplace_linkthree',$_POST[WTG_C2P_ABB.'linkthree'],$email_template);          
        if(!stringreplace_result){
            ### @todo log that a failure happened, if ever detected we'll need to add individual log entries       
        }
            
        // arrays holding expected values
        $methods_array = array('email','ticket','forum','testimonial');
        $apimethods_array = array('ticket','forum','testimonial');
        $reason_array = array('hire','pluginhelp','testimonial','bug','generaladvice','requestchanges','requestfeature','requesttutorial','affiliateenquiry','provideftp','provideadmin','providemysql','providehosting');
        $priority_array = array('low','medium','high');
                     
        // ensure all submitted values are in expected value arrays (will be done again on the server as required security)
        // we also check values to decide if we need to use the WebTechGlobal Contact Web Service
        foreach($_POST['multiselect_csv2post_contactmethods'] as $amethod){
            if(!is_string($amethod) || !in_array($methods_array)){
                $failed = true;
                $failurereason = 'the giving contact method '.$methods_array.' is invalid.';   
            }  
        }
        
        foreach($_POST['multiselect_csv2post_contactreason'] as $areason){
            if(!is_string($areason) || !in_array($reason_array)){
                $failed = true;
                $failurereason = 'the giving contact reason '.$areason.' is invalid.';   
            }  
        }

        foreach($_POST['multiselect_csv2post_contactpriority'] as $apriority){
            if(!is_string($apriority) || !in_array($priority_array)){
                $failed = true;
                $failurereason = 'a submitted priority value,'.$apriority.', is invalid.';   
            }  
        }
        
        // output result if $failed so far
        if($failed == true){
            csv2post_notice('Contact attempt failed. This has happened because '.$failurereason);
        }
        
        ######################################## Contact method for gold users only
        ####      CONTACT WEB SERVICE      ##### Stores sensitive information in WebTechGlobal database
        ######################################## Ticket, Forum and sending data requires this else it is all sent by email
        
        /*  @todo Contact Web Services to be complete on server
        if($failed == true){
            
            // is the api required, did user selected contact methods that require it?
            // compare each contact method that requires the api against those submitted in POST
            foreach($_POST['multiselect_csv2post_contactmethods'] as $amethod){
                if(in_array($apimethods_array,$_POST['multiselect_csv2post_contactmethods'])){
                    $apirequired = true;
                    break;   
                }  
            }  
            
            // check if soap connection should be attempted or not (based on users api session which is decide from service status and subscription)
            if($apirequired && csv2post_api_canIconnect()){
            
                // decide which web service to use (ticket takes priority)
                if(in_array('ticket',$_POST['multiselect_csv2post_contactmethods'])){
                
                    // is none in the contact include, is so we do not send any sensitive data
                    if(in_array('none',$_POST['multiselect_csv2post_contactinclude'])){
                        $email_list_start .= '<li>You had the None option selected, no login details or sensitive data will be sent to the Ticket Web Service</li>';                                
                    }else{

                        // do SOAP call to WebTechGlobal Ticket Web Service and create ticket
                        $ticket_array = array();
                        
                        if(in_array('admin',$_POST['multiselect_csv2post_contactinclude'])){
                            // ensure user has permission to edit users and maybe other permission
                            // they may have plugin access but not permission to be sending details via email
                            if(USER HAS REQUIRED PERMISSION){
                                $email_list_start .= '<li>You will send login details for '.PUT USERNAME HERE.', the password will be included (not shown here for security)</li>';                    
                                // get current users admin details else get the default admin user details
                                $ticket_array['adminusername'] = 'TO BE COMPLETE';
                                $ticket_array['adminpassword'] = 'TO BE COMPLETE';
                            }else{
                                // add entry to output to tell user they are not allowed to send login details
                                $email_list_start .= '<li>You do not have the require permission to send login details</li>';
                            }
                        }  
                        
                        if(in_array('ftp',$_POST['multiselect_csv2post_contactinclude'])){  
                            // include ftp details, can we get them from Wordpress or Server automatically???
                            // if not auto, user must enter ftp details in settings (may be used for other features) 
                            if(csv2post_contact_ftpstored() || csv2post_contact_ftpsubmitted()){
                                $email_list_start .= '<li>FTP login are being sent to help support access your Wordpress</li>';
                            }else{
                                $email_list_start .= '<li>FTP details canot be sent, they have not been provided</li>';                        
                            }
                        }   
                                                
                        if(in_array('hosting',$_POST['multiselect_csv2post_contactinclude'])){  
                            // include hosting details - user must enter them in settings
                            // if not already in settings, display more form fields for this
                        }    
                                             
                        if(in_array('mysql',$_POST['multiselect_csv2post_contactinclude'])){  
                            // include mysql database login details
                        }     
                    }// end if none in contact include - user must uncheck the none option to send data               
                                  
                    // call the ticket web service function which validates values first before using soapcall function     
                    csv2post_api_webservice_ticket('create',null,$ticket_array,true);   
                }         
            }
        }  */
        
        ######################### Send email last so we can include information about Contact
        ####                 ####
        ####   SEND EMAIL    ####
        ####                 ####
        ######################### 
        
        $emailmessage_start = '<html><body>
        
        <p>Sent from ' . $csv2post_plugintitle .'</p>
        
        <p><strong>Reason:</strong> ' . $csv2post_plugintitle .'</p>   
            
        <p><strong>Priority:</strong> unknown tbc @todo</p>

        <h3>Description</h3>
        <p>DESCRIPTION HERE</p>';
        
        // add further details depending on the reason for contact and fields completed
        ### @todo LOW PRIORITY complete email layout
        $emailmessage_middle = '';
              
        $emailmessage_end = '</body></html>';    
     
        $finalemailmessage = $emailmessage_start . $emailmessage_middle . $emailmessage_end;
        
        wp_mail('help@csv2post.com','Contact From '.$csv2post_plugintitle,$emailmessage); 
        
       // return false to stop all further post validation function calls
       return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    } 
}

/**
* Updates existing installation
* 
* @todo this procedure is not complete. For now we are not using precise updating. It will require array comparisons possibly, table table alterations etc. So we need a range of functions for this.
* 
*/
function csv2post_form_plugin_update(){
    if(isset( $_POST['csv2post_plugin_update_now'] ) && $_POST['csv2post_plugin_update_now'] == 'a43bt7695c34'){

        // re-install tab menu
        csv2post_INSTALL_tabmenu_settings();    
        // re-install admin settings
        csv2post_INSTALL_admin_settings();
        // initialize csv2post_theme since it changed to jquery OR wordpresscss rather than jquery theme
        csv2post_option('csv2post_theme','add','jquery');
        
        // update locally stored version number
        global $csv2post_currentversion;
        update_option('csv2post_installedversion',$csv2post_currentversion);        
        update_option('csv2post_installeddate',time()); 

        csv2post_notice_postresult('success','Plugin Update Complete','Please have a browse over all of the
        plugins screens, ensure key settings are as you need them and where applicable check the front-end of 
        your blog to ensure nothing has gone wrong.');

        return false;
    }else{
        return true;
    }     
}   

/**
* Save opertional settings (none interface)
*/
function csv2post_form_save_settings_operation(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'operationsettings'){
        
        global $csv2post_adm_set;

        // save extension status
        update_option('csv2post_extensions',$_POST['csv2post_radiogroup_extensionstatus']);
 
        $csv2post_adm_set['reporting']['uselog'] = $_POST['csv2post_radiogroup_logstatus'];
        $csv2post_adm_set['reporting']['loglimit'] = $_POST['csv2post_loglimit'];

        csv2post_update_option_adminsettings($csv2post_adm_set);

        csv2post_n_postresult('success','Operation Settings Saved','We
        recommend that you monitor the plugin for a short time and ensure
        your new settings are as expected.');
        
        return false;
    }else{
        return true;
    }     
}  

function csv2post_form_save_settings_interface(){
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'main' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'interfacesettings'){
        global $csv2post_plugintitle;
        
        // save theme change
        update_option('csv2post_theme',$_POST['csv2post_themeradios']);
        // form submit dialog
        $csv2post_adm_set['interface']['forms']['dialog']['status'] = $_POST['csv2post_radiogroup_dialog'];
        // panel support buttons                                                                                         
        $csv2post_adm_set['interface']['panels']['supportbuttons']['status'] = $_POST['csv2post_radiogroup_supportbuttons']; 
        
        csv2post_update_option_adminsettings($csv2post_adm_set); 
        
        csv2post_n_postresult('success','Interface Settings Saved','This plugins
        interface settings can made a big difference in your experience. Please
        keep this in mind if you feel anything is not as expected.');

         // return false to stop all further post validation function calls
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    }                 
}   
?>