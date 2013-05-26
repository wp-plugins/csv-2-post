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
            csv2post_notice(__('You do not have the required permissions to activate CSV 2 POST.
            The Wordpress role required is activate_plugins, usually granted to Administrators. Please
            contact your Web Master or contact info@csv2post.com if you feel this is a fault.'), 'warning', 'Large', false);
        }else{                  
            csv2post_install_core();
            csv2post_install_plugin();    
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' ); 
            exit;          
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
    if(isset($_POST['csv2post_hidden_pageid']) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'partialuninstall'){  
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
            
            // if delete core plugin tables
            if(isset($_POST['csv2post_deletecoretables_array'])){
                foreach($_POST['csv2post_deletecoretables_array'] as $key => $table_name){
                    csv2post_WP_SQL_drop_table($table_name);
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
            
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );
            exit;
                                                
        }else{           
            csv2post_notice(__('You do not have the required permissions to un-install '.$csv2post_plugintitle.'. The Wordpress role required is delete_plugins, usually granted to Administrators.'), 'warning', 'Large','No Permission To Uninstall ' . $csv2post_plugintitle,'','echo');
            return false;
        }
                 
        return false;
 
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
* Updates existing installation
* 
* @todo TODO:MEDIUMPRIORITY, update should be more precise only changing what needs to be, right now settings are not
*/
function csv2post_form_plugin_update(){
    if(isset( $_POST['csv2post_plugin_update_now'] ) && $_POST['csv2post_plugin_update_now'] == 'a43bt7695c34'){

        // re-install tab menu
        csv2post_INSTALL_tabmenu_settings();    
        // re-install admin settings
        csv2post_INSTALL_admin_settings();

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
    if(isset($_POST['csv2post_hidden_pageid']) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'interfacesettings'){
        global $csv2post_plugintitle;
        
        // save theme change
        update_option('csv2post_theme',$_POST['csv2post_themeradios']);
        // form submit dialog
        $csv2post_adm_set['interface']['forms']['dialog']['status'] = $_POST['csv2post_radiogroup_dialog'];
        // panel support buttons                                                                                         
        $csv2post_adm_set['interface']['panels']['supportbuttons']['status'] = $_POST['csv2post_radiogroup_supportbuttons']; 
        
        csv2post_update_option_adminsettings($csv2post_adm_set); 
        
        csv2post_n_postresult('success','Interface Settings Saved','This plugins
        interface settings may make changes you do not expect. Please
        keep this in mind and ask us if you are unsure about something.');

         // return false to stop all further post validation function calls
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    }                 
}   

function csv2post_form_savelogcriteria(){
    if(isset($_POST['csv2post_hidden_pageid']) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'logsearchoptions'){
        global $csv2post_adm_set;
        
        // first unset all criteria
        if(isset($csv2post_adm_set['log']['logscreen'])){
            unset($csv2post_adm_set['log']['logscreen']);
        }
        
        ##################################################
        #                                                #
        #         COLUMN DISPlAY SETTINGS FIRST          #
        #                                                #
        ##################################################
        // if a column is set in the array, it indicates that it is to be displayed, we unset those not to be set, we dont set them to false
        if(isset($_POST['csv2post_logfields'])){
            foreach($_POST['csv2post_logfields'] as $column){
                $csv2post_adm_set['log']['logscreen']['displayedcolumns'][$column] = true;                   
            }
        }
            
        ############################################################
        #                                                          #
        #          SAVE CUSTOM SEARCH CRITERIA CHECK BOXES         #
        #                                                          #
        ############################################################              
        // outcome criteria
        if(isset($_POST['csv2post_log_outcome'])){    
            foreach($_POST['csv2post_log_outcome'] as $outcomecriteria){
                $csv2post_adm_set['log']['logscreen']['outcomecriteria'][$outcomecriteria] = true;                   
            }            
        } 
        
        // type criteria
        if(isset($_POST['csv2post_log_type'])){
            foreach($_POST['csv2post_log_type'] as $typecriteria){
                $csv2post_adm_set['log']['logscreen']['typecriteria'][$typecriteria] = true;                   
            }            
        }         

        // category criteria
        if(isset($_POST['csv2post_log_category'])){
            foreach($_POST['csv2post_log_category'] as $categorycriteria){
                $csv2post_adm_set['log']['logscreen']['categorycriteria'][$categorycriteria] = true;                   
            }            
        }         
   
        // priority criteria
        if(isset($_POST['csv2post_log_priority'])){
            foreach($_POST['csv2post_log_priority'] as $prioritycriteria){
                $csv2post_adm_set['log']['logscreen']['prioritycriteria'][$prioritycriteria] = true;                   
            }            
        }         

        ############################################################
        #                                                          #
        #         SAVE CUSTOM SEARCH CRITERIA SINGLE VALUES        #
        #                                                          #
        ############################################################
        // page
        if(isset($_POST['csv2post_pluginpages_logsearch']) && $_POST['csv2post_pluginpages_logsearch'] != 'notselected'){
            $csv2post_adm_set['log']['logscreen']['page'] = $_POST['csv2post_pluginpages_logsearch'];
        }   
        // action
        if(isset($_POST['csv2pos_logactions_logsearch']) && $_POST['csv2pos_logactions_logsearch'] != 'notselected'){
            $csv2post_adm_set['log']['logscreen']['action'] = $_POST['csv2pos_logactions_logsearch'];
        }   
        // screen
        if(isset($_POST['csv2post_pluginscreens_logsearch']) && $_POST['csv2post_pluginscreens_logsearch'] != 'notselected'){
            $csv2post_adm_set['log']['logscreen']['screen'] = $_POST['csv2post_pluginscreens_logsearch'];
        }  
        // line
        if(isset($_POST['csv2post_logcriteria_phpline'])){
            $csv2post_adm_set['log']['logscreen']['line'] = $_POST['csv2post_logcriteria_phpline'];
        }  
        // file
        if(isset($_POST['csv2post_logcriteria_phpfile'])){
            $csv2post_adm_set['log']['logscreen']['file'] = $_POST['csv2post_logcriteria_phpfile'];
        }          
        // function
        if(isset($_POST['csv2post_logcriteria_phpfunction'])){
            $csv2post_adm_set['log']['logscreen']['function'] = $_POST['csv2post_logcriteria_phpfunction'];
        }
        // panel name
        if(isset($_POST['csv2post_logcriteria_panelname'])){
            $csv2post_adm_set['log']['logscreen']['panelname'] = $_POST['csv2post_logcriteria_panelname'];
        }
        // IP address
        if(isset($_POST['csv2post_logcriteria_ipaddress'])){
            $csv2post_adm_set['log']['logscreen']['ipaddress'] = $_POST['csv2post_logcriteria_ipaddress'];
        }
        // user id
        if(isset($_POST['csv2post_logcriteria_userid'])){
            $csv2post_adm_set['log']['logscreen']['userid'] = $_POST['csv2post_logcriteria_userid'];
        }

        csv2post_update_option_adminsettings($csv2post_adm_set);
        
        csv2post_n_postresult('success','Log Search Settings Saved','Your selections have an instant effect.
        Please browse the Log screen for the results of your new search.');    
    
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    }                 
}   
?>