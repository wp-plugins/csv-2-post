<?php
/** 
* Class for handling $_POST and $_GET requests
* 
* The class is called in the process_POST_GET() method found in the CSV2POST class. 
* The process_POST_GET() method is hooked at admin_init. It means requests are handled in the admin
* head, globals can be updated and pages will show the most recent data. Nonce security is performed
* within process_POST_GET() then the require method for processing the request is used.
* 
* Methods in this class MUST be named within the form or link itself, basically a unique identifier for the form.
* i.e. the Section Switches settings have a form name of "sectionswitches" and so the method in this class used to
* save submission of the "sectionswitches" form is named "sectionswitches".
* 
* process_POST_GET() uses eval() to call class + method 
* 
* @package CSV 2 POST
* @author Ryan Bayne   
* @since 8.0.0
*/

// load in Wordpress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
* Class processes form submissions, the class is only loaded once nonce and other security checked
* 
* @author Ryan R. Bayne
* @package CSV 2 POST
* @since 8.0.0
* @version 1.0.2
*/
class C2P_Requests {  
    public function __construct() {
        global $c2p_settings;
    
        // create class objects
        $this->CSV2POST = CSV2POST::load_class( 'CSV2POST', 'class-csv2post.php', 'classes' ); # plugin specific functions
        $this->UI = $this->CSV2POST->load_class( 'C2P_UI', 'class-ui.php', 'classes' ); # interface, mainly notices
        $this->DB = $this->CSV2POST->load_class( 'C2P_DB', 'class-wpdb.php', 'classes' ); # database interaction
        $this->PHP = $this->CSV2POST->load_class( 'C2P_PHP', 'class-phplibrary.php', 'classes' ); # php library by Ryan R. Bayne
                        
        // set current project values
        if( isset( $c2p_settings['currentproject'] ) ) {    
            $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
            $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings ); 
        }   
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */
    public function installtestdata() {
        global $C2P_Install;
        $C2P_Install->testdata();// main section and any prep required for other sections
        $this->UI->create_notice( __( 'Test Data installation procedure has finished.' ), 'success', 'Small', __( 'Test Data Installed' ) );
    }  

    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.1
    */    
    public function user_can( $capability = 'activate_plugins' ){
        
        if(!current_user_can( $capability ) ){
            
            $this->UI->n_depreciated( 'You Are Restricted', 'You do not have permission to complete that submission. Your
            Wordpress account requires the "'.$capability.'" capability to perform the action you attempted.', 'warning', 'Small' );
            return false;
            
        }   
        
        return true;
    }  

    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.1
    */    
    public function request_success( $form_title, $more_info = '' ){  
        $this->UI->create_notice( "Your submission for $form_title was successful. " . $more_info, 'success', 'Small', "$form_title Updated");          
    } 

    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.1
    */    
    public function request_failed( $form_title, $reason = '' ){
        $this->UI->n_depreciated( $form_title . ' Unchanged', "Your settings for $form_title were not changed. " . $reason, 'error', 'Small' );    
    }

    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.1
    */    
    public function logsettings() {
        global $c2p_settings;
        $c2p_settings['globalsettings']['uselog'] = $_POST['csv2post_radiogroup_logstatus'];
        $c2p_settings['globalsettings']['loglimit'] = $_POST['csv2post_loglimit'];
        
        
        ##################################################
        #           LOG SEARCH CRITERIA                  #
        ##################################################
        
        // first unset all criteria
        if( isset( $c2p_settings['logsettings']['logscreen'] ) ){
            unset( $c2p_settings['logsettings']['logscreen'] );
        }
                                                           
        // if a column is set in the array, it indicates that it is to be displayed, we unset those not to be set, we dont set them to false
        if( isset( $_POST['csv2post_logfields'] ) ){
            foreach( $_POST['csv2post_logfields'] as $column){
                $c2p_settings['logsettings']['logscreen']['displayedcolumns'][$column] = true;                   
            }
        }
                                                                                 
        // outcome criteria
        if( isset( $_POST['csv2post_log_outcome'] ) ){    
            foreach( $_POST['csv2post_log_outcome'] as $outcomecriteria){
                $c2p_settings['logsettings']['logscreen']['outcomecriteria'][$outcomecriteria] = true;                   
            }            
        } 
        
        // type criteria
        if( isset( $_POST['csv2post_log_type'] ) ){
            foreach( $_POST['csv2post_log_type'] as $typecriteria){
                $c2p_settings['logsettings']['logscreen']['typecriteria'][$typecriteria] = true;                   
            }            
        }         

        // category criteria
        if( isset( $_POST['csv2post_log_category'] ) ){
            foreach( $_POST['csv2post_log_category'] as $categorycriteria){
                $c2p_settings['logsettings']['logscreen']['categorycriteria'][$categorycriteria] = true;                   
            }            
        }         

        // priority criteria
        if( isset( $_POST['csv2post_log_priority'] ) ){
            foreach( $_POST['csv2post_log_priority'] as $prioritycriteria){
                $c2p_settings['logsettings']['logscreen']['prioritycriteria'][$prioritycriteria] = true;                   
            }            
        }         

        ############################################################
        #         SAVE CUSTOM SEARCH CRITERIA SINGLE VALUES        #
        ############################################################
        // page
        if( isset( $_POST['csv2post_pluginpages_logsearch'] ) && $_POST['csv2post_pluginpages_logsearch'] != 'notselected' ){
            $c2p_settings['logsettings']['logscreen']['page'] = $_POST['csv2post_pluginpages_logsearch'];
        }   
        // action
        if( isset( $_POST['csv2pos_logactions_logsearch'] ) && $_POST['csv2pos_logactions_logsearch'] != 'notselected' ){
            $c2p_settings['logsettings']['logscreen']['action'] = $_POST['csv2pos_logactions_logsearch'];
        }   
        // screen
        if( isset( $_POST['csv2post_pluginscreens_logsearch'] ) && $_POST['csv2post_pluginscreens_logsearch'] != 'notselected' ){
            $c2p_settings['logsettings']['logscreen']['screen'] = $_POST['csv2post_pluginscreens_logsearch'];
        }  
        // line
        if( isset( $_POST['csv2post_logcriteria_phpline'] ) ){
            $c2p_settings['logsettings']['logscreen']['line'] = $_POST['csv2post_logcriteria_phpline'];
        }  
        // file
        if( isset( $_POST['csv2post_logcriteria_phpfile'] ) ){
            $c2p_settings['logsettings']['logscreen']['file'] = $_POST['csv2post_logcriteria_phpfile'];
        }          
        // function
        if( isset( $_POST['csv2post_logcriteria_phpfunction'] ) ){
            $c2p_settings['logsettings']['logscreen']['function'] = $_POST['csv2post_logcriteria_phpfunction'];
        }
        // panel name
        if( isset( $_POST['csv2post_logcriteria_panelname'] ) ){
            $c2p_settings['logsettings']['logscreen']['panelname'] = $_POST['csv2post_logcriteria_panelname'];
        }
        // IP address
        if( isset( $_POST['csv2post_logcriteria_ipaddress'] ) ){
            $c2p_settings['logsettings']['logscreen']['ipaddress'] = $_POST['csv2post_logcriteria_ipaddress'];
        }
        // user id
        if( isset( $_POST['csv2post_logcriteria_userid'] ) ){
            $c2p_settings['logsettings']['logscreen']['userid'] = $_POST['csv2post_logcriteria_userid'];
        }
        
        $this->CSV2POST->update_settings( $c2p_settings);
        $this->UI->n_postresult_depreciated( 'success', __( 'Log Settings Saved', 'csv2post' ), __( 'It may take sometime for new log entries to be created depending on your websites activity.', 'csv2post' ) );  
    }  
    
    /**
    * Create a data rule for replacing specific values after import 
    */
    public function eventtypes() {   
        $c2p_schedule_array = $this->CSV2POST->get_option_schedule_array();
        $c2p_schedule_array['eventtypes']["deleteuserswaiting"]['switch'] = $_POST["deleteuserswaiting"];
        $this->CSV2POST->update_option_schedule_array( $c2p_schedule_array );
        $this->UI->notice_depreciated( __( 'Schedule event types have been saved, the changes will have an effect on the types of events run, straight away.', 'csv2post' ), 'success', 'Large', __( 'Schedule Event Types Saved', 'csv2post' ), '', 'echo' );
    } 
    
    /**
    * Data panel one settings
    */
    public function panelone() {
        global $c2p_settings;
        $c2p_settings['globalsettings']['encoding']['type'] = $_POST['csv2post_radiogroup_encoding'];
        $c2p_settings['globalsettings']['admintriggers']['newcsvfiles']['status'] = $_POST['csv2post_radiogroup_detectnewcsvfiles'];
        $c2p_settings['globalsettings']['admintriggers']['newcsvfiles']['display'] = $_POST['csv2post_radiogroup_detectnewcsvfiles_display'];
        $c2p_settings['globalsettings']['postfilter']['status'] = $_POST['csv2post_radiogroup_postfilter'];          
        $c2p_settings['globalsettings']['postfilter']['tokenrespin']['status'] = $_POST['csv2post_radiogroup_spinnertokenrespin'];        
        $this->CSV2POST->update_settings( $c2p_settings);
        $this->UI->n_postresult_depreciated( 'success', __( 'Data Related Settings Saved', 'csv2post' ), __( 'We recommend that you monitor the plugin for a short time and ensure your new settings are as expected.', 'csv2post' ) );
    }

    /**
    * update global data settings
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.1
    */ 
    public function globaldatasettings () {
        global $c2p_settings;
        
        if(!is_numeric( $_POST['importlimit'] ) ){
            $this->UI->create_notice( 'You must enter a numeric value for the maximum number of records to be imported and inserted to the database per event.
            This applies to manual events only.', 'error', 'Small', 'Import Limit Number Required' );
            return;
        }
        
        $value = $_POST['importlimit'];
        if( $_POST['importlimit'] < 1){
            $value = 1;
        }
        
        $c2p_settings['datasettings']['insertlimit'] = $_POST['importlimit'];
        $this->CSV2POST->update_settings( $c2p_settings);
        $this->UI->create_notice( __( 'Your data options have been saved.', 'csv2post' ), 'success', 'Small', __( 'Global Data Settings Saved', 'csv2post' ) );        
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */   
    public function persistentnotice() {
        global $c2p_persistent_array;
        foreach( $c2p_persistent_array['notifications'] as $key => $notice){
            if( $notice['id'] == $_POST['csv2post_post_deletenotice_id'] ){
                unset( $c2p_persistent_array['notifications'][$key] );
            }            
        } 
        $this->CSV2POST->option( 'csv2post_notifications', 'update', $c2p_persistent_array );            
    }  
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function screenpermissions() {
        global $c2pm;
        // loop through tabs, this is the same loop build as on the capabilities interface itself
        $menu_id = 0;
        foreach( $c2pm as $page_name => $page_array ){
            foreach( $page_array['tabs'] as $key => $tab_array ){
                if( isset( $tab_array['display'] ) && $tab_array['display'] != false ){                   
                    // is post value set for current tab
                    if( isset( $_POST['csv2post_capabilitiesmenu_'.$page_name.'_'.$key.''] ) ){
         
                        // update capability setting for screen
                        $c2pm[$page_name]['tabs'][$key]['permissions']['customcapability'] = $_POST['csv2post_capabilitiesmenu_'.$page_name.'_'.$key.''];
                    }
                    ++$menu_id; 
                }        
            }
        }        
        $this->CSV2POST->option( 'csv2post_tabmenu', 'update', $c2pm);
        $this->UI->notice_postresult_depreciated( 'success', __( 'Screen Permissions Saved', 'csv2post' ), __( 'Your saved screen permissions may hide or display screens for users. We recommend that you access your blog using applicable user accounts to test your new permissions.', 'csv2post' ) );    
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function pagepermissions() {
        global $c2pm;
        foreach( $c2pm as $page_name => $page_array ){
            if( isset( $_POST['csv2post_capabilitiesmenu_'.$page_name.'_99'] ) ){
                $c2pm[$page_name]['permissions']['customcapability'] = $_POST['csv2post_capabilitiesmenu_'.$page_name.'_99'];    
            }
        }        
        $this->CSV2POST->option( 'csv2post_tabmenu', 'update', $c2pm); 
        $this->UI->notice_postresult_depreciated( 'success', __( 'Page Permissions Saved', 'csv2post' ), __( 'Your saved page permissions may hide or display the plugins pages for users. We recommend that you access your blog using applicable user accounts to test your new permissions.', 'csv2post' ) );     
    } 
     
    /**
    * Partial Un-install Plugin Options 
    */
    public function partialuninstall() {
        if(current_user_can( 'delete_plugins' ) ){
                     
            // if delete data import job tables
            if( isset( $_POST['csv2post_deletejobtables_array'] ) ){
                               
                foreach( $_POST['csv2post_deletejobtables_array'] as $k => $table_name){
                    $code = str_replace( 'csv2post_', '', $table_name);
                    csv2post_SQL_drop_dataimportjob_table( $table_name);
                    $this->CSV2POST->notice_depreciated( 'Table ' . $table_name . ' was deleted.', 'success', 'Tiny', 'Table Deleted', '', 'echo' ); 
                }
            }
            
            // if delete core plugin tables
            if( isset( $_POST['csv2post_deletecoretables_array'] ) ){
                foreach( $_POST['csv2post_deletecoretables_array'] as $key => $table_name){
                    C2P_DB::drop_table( $table_name);
                }
            }
       
            // if delete csv files
            if( isset( $_POST['csv2post_deletecsvfiles_array'] ) ){
                foreach( $_POST['csv2post_deletecsvfiles_array'] as $k => $csv_file_name){
                        
                    $file_is_in_use = false;
                    $file_is_in_use = csv2post_is_csvfile_in_use( $csv_file_name);
                       
                    // if file is in use
                    if( $file_is_in_use){        
                        $this->CSV2POST->notice_depreciated( 'The file named ' . $csv_file_name .' is in use, cannot delete.', 'error', 'Tiny', 'File In Use', '', 'echo' );
                    }else{                         
                        unlink( $csv_file_name); 
                        $this->CSV2POST->notice_depreciated( $csv_file_name .' Deleted', 'success', 'Tiny', '', '', 'echo' );
                    }
                                            
                }      
            }
                      
            // if delete folders
            if( isset( $_POST['csv2post_deletefolders_array'] ) ){    
                foreach( $_POST['csv2post_deletefolders_array'] as $k => $o){       

                }      
            }            

            // if delete options
            if( isset( $_POST['csv2post_deleteoptions_array'] ) ){          
                foreach( $_POST['csv2post_deleteoptions_array'] as $k => $o){      
                    delete_option( $o);
                    $this->CSV2POST->notice_depreciated( 'Option record ' . $o . ' has been deleted.', 'success', 'Tiny', 'Option Record Deleted', '', 'echo' ); 
                }      
            }
            
            wp_redirect( get_bloginfo( 'url' ) . '/wp-admin/admin.php?page=csv2post' );
            exit;
                                                
        }else{           
            $this->CSV2POST->notice_depreciated( __( 'You do not have the required permissions to un-install CSV 2 POST. The Wordpress role required is delete_plugins, usually granted to Administrators.' ), 'warning', 'Large', 'No Permission To Uninstall CSV 2 POST', '', 'echo' );
            return false;
        }
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.1
    */       
    public function beginpluginupdate() {
        
        // check if an update method exists, else the plugin needs to do very little
        eval( '$method_exists = method_exists ( $this , "patch_' . $_POST['csv2post_plugin_update_now'] .'" );' );

        if( $method_exists){
            // perform update by calling the request version update procedure
            eval( '$update_result_array = C2P_UpdatePlugin::patch_' . $_POST['csv2post_plugin_update_now'] .'( "update");' );       
        }else{
            // default result to true
            $update_result_array['failed'] = false;
        } 
      
        if( $update_result_array['failed'] == true){           
            $this->UI->create_notice( __( 'The update procedure failed, the reason should be displayed below. Please try again unless the notice below indicates not to. If a second attempt fails, please seek support.', 'csv2post' ), 'error', 'Small', __( 'Update Failed', 'csv2post' ) );    
            $this->UI->create_notice( $update_result_array['failedreason'], 'info', 'Small', 'Update Failed Reason' );
        }else{  
            // storing the current file version will prevent user coming back to the update screen
            global $c2p_currentversion;        
            update_option( 'csv2post_installedversion', $c2p_currentversion);

            $this->UI->create_notice( __( 'Good news, the update procedure was complete. If you do not see any errors or any notices indicating a problem was detected it means the procedure worked. Please ensure any new changes suit your needs.', 'csv2post' ), 'success', 'Small', __( 'Update Complete', 'csv2post' ) );
            
            // do a redirect so that the plugins menu is reloaded
            wp_redirect( get_bloginfo( 'url' ) . '/wp-admin/admin.php?page=csv2post' );
            exit;                
        }
    }
    
    /**
    * Save drip feed limits  
    */
    public function schedulesettings() {
        $c2p_schedule_array = $this->CSV2POST->get_option_schedule_array();
        
        // if any required values are not in $_POST set them to zero
        if(!isset( $_POST['day'] ) ){
            $c2p_schedule_array['limits']['day'] = 0;        
        }else{
            $c2p_schedule_array['limits']['day'] = $_POST['day'];            
        }
        
        if(!isset( $_POST['hour'] ) ){
            $c2p_schedule_array['limits']['hour'] = 0;
        }else{
            $c2p_schedule_array['limits']['hour'] = $_POST['hour'];            
        }
        
        if(!isset( $_POST['session'] ) ){
            $c2p_schedule_array['limits']['session'] = 0;
        }else{
            $c2p_schedule_array['limits']['session'] = $_POST['session'];            
        }
                                 
        // ensure $c2p_schedule_array is an array, it may be boolean false if schedule has never been set
        if( isset( $c2p_schedule_array ) && is_array( $c2p_schedule_array ) ){
            
            // if times array exists, unset the [times] array
            if( isset( $c2p_schedule_array['days'] ) ){
                unset( $c2p_schedule_array['days'] );    
            }
            
            // if hours array exists, unset the [hours] array
            if( isset( $c2p_schedule_array['hours'] ) ){
                unset( $c2p_schedule_array['hours'] );    
            }
            
        }else{
            // $schedule_array value is not array, this is first time it is being set
            $c2p_schedule_array = array();
        }
        
        // loop through all days and set each one to true or false
        if( isset( $_POST['csv2post_scheduleday_list'] ) ){
            foreach( $_POST['csv2post_scheduleday_list'] as $key => $submitted_day ){
                $c2p_schedule_array['days'][$submitted_day] = true;        
            }  
        } 
        
        // loop through all hours and add each one to the array, any not in array will not be permitted                              
        if( isset( $_POST['csv2post_schedulehour_list'] ) ){
            foreach( $_POST['csv2post_schedulehour_list'] as $key => $submitted_hour){
                $c2p_schedule_array['hours'][$submitted_hour] = true;        
            }           
        }    

        if( isset( $_POST['deleteuserswaiting'] ) )
        {
            $c2p_schedule_array['eventtypes']['deleteuserswaiting']['switch'] = 'enabled';                
        }
        
        if( isset( $_POST['eventsendemails'] ) )
        {
            $c2p_schedule_array['eventtypes']['sendemails']['switch'] = 'enabled';    
        }        
  
        $this->CSV2POST->update_option_schedule_array( $c2p_schedule_array );
        $this->UI->notice_depreciated( __( 'Schedule settings have been saved.', 'csv2post' ), 'success', 'Large', __( 'Schedule Times Saved', 'csv2post' ) );   
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function logsearchoptions() {
        $this->UI->n_postresult_depreciated( 'success', __( 'Log Search Settings Saved', 'csv2post' ), __( 'Your selections have an instant effect. Please browse the Log screen for the results of your new search.', 'csv2post' ) );                   
    }
    
    /**
    * creates a new project using existing database tables 
    */
    public function newprojectexistingcsvfiles() {
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function deleteproject() {
        global $wpdb, $c2p_settings;
        
        if(empty( $_POST['confirmcode'] ) ){
            $this->UI->create_notice( __( 'Please re-enter the confirmation code.' ), 'error', 'Small', __( 'Confirmation Code Required' ) );
            return;
        }    
        
        if( $_POST['randomcode'] !== $_POST['confirmcode'] ){
            $this->UI->create_notice( __( 'Confirmation codes do not match.' ), 'error', 'Small', __( 'No Match' ) );
            return;
        }
        
        if(empty( $_POST['projectid'] ) ){
            $this->UI->create_notice( __( 'Project ID required, please ensure you get the correct ID.' ), 'error', 'Small', __( 'Project ID Required' ) );
            return;
        }
        
        if(!is_numeric( $_POST['projectid'] ) ){
            $this->UI->create_notice( __( 'Project ID must be numeric.' ), 'error', 'Small', __( 'Invalid Project ID' ) );
            return;
        }
        
        // delete row from c2pprojects table
        $this->DB->delete( $wpdb->c2pprojects, "projectid = '" . $_POST['projectid'] . "'");
               
        // unset current project setting
        unset( $c2p_settings['currentproject'] );
        $this->CSV2POST->update_settings( $c2p_settings);
        
        $this->UI->create_notice( __( 'Your project was deleted.' ), 'success', 'Small', __( 'Success' ) );
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function setexpecteddatatypes() {
        global $c2p_settings, $wpdb;
        
        $project_columns_array = $this->CSV2POST->get_project_columns_from_db( $c2p_settings['currentproject'], true);

        // all columns are in one array but the key are the tables, each table needs its own update query 
        foreach( $project_columns_array as $source_table => $columns_array ){
            foreach( $columns_array as $key => $column){
                // array contains information we must skip
                if( $key != 'datatreatment' && $key != 'sources' ){
                    // is the current table and column set in $_POST
                    if( isset( $_POST['datatypescolumns#'.$source_table.'#'.$column] ) ){
                        if( $_POST['datatypescolumns#'.$source_table.'#'.$column] != 'notrequired' ){
                            $this->CSV2POST->add_new_data_rule( $_POST['sourceid_' . $source_table . $column], 'datatypes', $_POST['datatypescolumns#'.$source_table.'#'.$column], $column);                       
                        }elseif( $_POST['datatypescolumns#'.$source_table.'#'.$column] == 'notrequired' ){
                            $this->CSV2POST->delete_data_rule( $_POST['sourceid_' . $source_table . $column], 'datatypes', $column);
                        }
                    }
                }
            }
        }
        
        $this->UI->create_notice( __( 'Your column data types have been updated. There are forms that will adapt to your changes to simplify things for you.' ), 'success', 'Small', __( 'Data Types Updated' ) );
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function roundnumberup () {
        global $c2p_settings;
        
        $project_columns_array = $this->CSV2POST->get_project_columns_from_db( $c2p_settings['currentproject'], true);
 
        // all columns are in one array but the key are the tables, each table needs its own update query 
        foreach( $project_columns_array as $source_table => $columns_array ){
            foreach( $columns_array as $key => $column){
                // array contains information we must skip
                if( $key != 'datatreatment' && $key != 'sources' ){
                    // is the current table and column set in $_POST
                    if( isset( $_POST['roundnumberupcolumns#'.$source_table.'#'.$column] ) ){
                        if( $_POST['roundnumberupcolumns#'.$source_table.'#'.$column] != 'notrequired' ){
                            $this->CSV2POST->add_new_data_rule( $_POST['sourceid_' . $source_table . $column], 'roundnumberupcolumns', true, $column);                       
                        }elseif( $_POST['roundnumberupcolumns#'.$source_table.'#'.$column] == 'notrequired' ){
                            $this->CSV2POST->delete_data_rule( $_POST['sourceid_' . $source_table . $column], 'roundnumberupcolumns', $column);
                        }
                    }
                }
            }
        }

        $this->UI->create_notice( __( 'Values in the selected columns will be rounded upwards.' ), 'success', 'Small', __( 'Rules Updated' ) );   
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function roundnumberdown() {
        global $c2p_settings;
        
        $project_columns_array = $this->CSV2POST->get_project_columns_from_db( $c2p_settings['currentproject'], true);
 
        // all columns are in one array but the key are the tables, each table needs its own update query 
        foreach( $project_columns_array as $source_table => $columns_array ){
            foreach( $columns_array as $key => $column){
                // array contains information we must skip
                if( $key != 'datatreatment' && $key != 'sources' ){
                    // is the current table and column set in $_POST
                    if( isset( $_POST['roundnumbercolumns#'.$source_table.'#'.$column] ) ){
                        if( $_POST['roundnumbercolumns#'.$source_table.'#'.$column] != 'notrequired' ){
                            $this->CSV2POST->add_new_data_rule( $_POST['sourceid_' . $source_table . $column], 'roundnumbercolumns', true, $column);                       
                        }elseif( $_POST['roundnumbercolumns#'.$source_table.'#'.$column] == 'notrequired' ){
                            $this->CSV2POST->delete_data_rule( $_POST['sourceid_' . $source_table . $column], 'roundnumbercolumns', $column);
                        }
                    }
                }
            }
        }
        
        $this->UI->create_notice( __( 'Values in the selected columns will be rounded down.' ), 'success', 'Small', __( 'Round-down Rules Updated' ) );   
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function captalizefirstletter() {
        global $c2p_settings;
        
        $project_columns_array = $this->CSV2POST->get_project_columns_from_db( $c2p_settings['currentproject'], true);
 
        // all columns are in one array but the key are the tables, each table needs its own update query 
        foreach( $project_columns_array as $source_table => $columns_array ){
            foreach( $columns_array as $key => $column){
                // array contains information we must skip
                if( $key != 'datatreatment' && $key != 'sources' ){
                    // is the current table and column set in $_POST
                    if( isset( $_POST['captalizefirstlettercolumns#'.$source_table.'#'.$column] ) ){
                        if( $_POST['captalizefirstlettercolumns#'.$source_table.'#'.$column] != 'notrequired' ){
                            $this->CSV2POST->add_new_data_rule( $_POST['sourceid_' . $source_table . $column], 'captalizefirstlettercolumns', true, $column);                       
                        }elseif( $_POST['captalizefirstlettercolumns#'.$source_table.'#'.$column] == 'notrequired' ){
                            $this->CSV2POST->delete_data_rule( $_POST['sourceid_' . $source_table . $column], 'captalizefirstlettercolumns', $column);
                        }
                    }
                }
            }
        }
        
        $this->UI->create_notice( __( 'The first letter in the selected column text data will be capitalized.' ), 'success', 'Small', __( 'Capitalize Rules Updated' ) );   
    }  
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function lowercaseall() {
        global $c2p_settings;
        
        $project_columns_array = $this->CSV2POST->get_project_columns_from_db( $c2p_settings['currentproject'], true);
 
        // all columns are in one array but the key are the tables, each table needs its own update query 
        foreach( $project_columns_array as $source_table => $columns_array ){
            foreach( $columns_array as $key => $column){
                // array contains information we must skip
                if( $key != 'datatreatment' && $key != 'sources' ){
                    // is the current table and column set in $_POST
                    if( isset( $_POST['lowercaseallcolumns#'.$source_table.'#'.$column] ) ){
                        if( $_POST['lowercaseallcolumns#'.$source_table.'#'.$column] != 'notrequired' ){
                            $this->CSV2POST->add_new_data_rule( $_POST['sourceid_' . $source_table . $column], 'lowercaseallcolumns', true, $column);                       
                        }elseif( $_POST['lowercaseallcolumns#'.$source_table.'#'.$column] == 'notrequired' ){
                            $this->CSV2POST->delete_data_rule( $_POST['sourceid_' . $source_table . $column], 'lowercaseallcolumns', $column);
                        }
                    }
                }
            }
        }
        
        $this->UI->create_notice( __( 'All text in the selected column will be made lower-case during importing.' ), 'success', 'Small', __( 'Lower-case Rules Updated' ) );   
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function uppercaseall() {
        global $c2p_settings;
        
        $project_columns_array = $this->CSV2POST->get_project_columns_from_db( $c2p_settings['currentproject'], true);
 
        // all columns are in one array but the key are the tables, each table needs its own update query 
        foreach( $project_columns_array as $source_table => $columns_array ){
            
            foreach( $columns_array as $key => $column){
                
                // array contains information we must skip
                if( $key != 'datatreatment' && $key != 'sources' ){
                    
                    // is the current table and column set in $_POST
                    if( isset( $_POST['uppercaseallcolumns#'.$source_table.'#'.$column] ) ){
                        
                        if( $_POST['uppercaseallcolumns#'.$source_table.'#'.$column] != 'notrequired' ){
                            
                            $this->CSV2POST->add_new_data_rule( $_POST['sourceid_' . $source_table . $column], 'uppercaseallcolumns', true, $column);  
                                                 
                        }elseif( $_POST['uppercaseallcolumns#'.$source_table.'#'.$column] == 'notrequired' ){
                            
                            $this->CSV2POST->delete_data_rule( $_POST['sourceid_' . $source_table . $column], 'uppercaseallcolumns', $column);
                            
                        }
                    }
                }
            }
        }
        
        $this->UI->create_notice( __( 'All text in the selected column will be made upper-case during importing.' ), 'success', 'Small', __( 'Upper-case Rules Updated' ) );   
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */             
    public function datasplitter() {
        global $wpdb, $c2p_settings;
        
        // column to be splitted makes its source the primary/head in this procedure and the lead is taking from that during import
        $explode_splitter_column = explode( '#', $_POST['datasplitercolumn'] );
        
        // we need the source id that the splitter rules applies to
        $sourceid = $this->DB->selectrow( $wpdb->c2psources, 'projectid = ' . $c2p_settings['currentproject'] .' AND tablename = "' . $explode_splitter_column[0] .'"', 'sourceid' );

        // now query the rules column in the established source
        $rules_array = $this->CSV2POST->get_data_rules_source( $sourceid->sourceid);# returns array no matter what so we can just get working with it
        
        // begin adding values to the rules_array
        $rules_array['splitter']['separator'] = $_POST['datasplitterseparator'];// separator character
        $rules_array['splitter']['datasplitertable'] = $explode_splitter_column[0];
        $rules_array['splitter']['datasplitercolumn'] = $explode_splitter_column[1];
        
        // ensure we have the first and second tables + columns
        if(empty( $_POST["receivingcolumn1"] ) || empty( $_POST["receivingtable1"] ) || empty( $_POST["receivingcolumn2"] ) || empty( $_POST["receivingtable2"] ) ){
            $this->UI->create_notice( __( 'The data splitting procedure requires a minimum of two columns for the split data to be inserted to. Please complete the first four text fields.' ), 'error', 'Small', 'Two Columns Required' );
            return;
        }
        
        // add up to 5 tables+columns to rules array
        for( $i=1;$i<=5;$i++){
            if(empty( $_POST["receivingcolumn$i"] ) || empty( $_POST["receivingtable$i"] ) ){
                break;                        
            }

            $rules_array['splitter']["receivingtable$i"] = $_POST["receivingtable$i"];
            $rules_array['splitter']["receivingcolumn$i"] = $_POST["receivingcolumn$i"];
            
            // do the receiving columns exist if not create them
            $table_columns_array = $this->DB->get_tablecolumns( $_POST["receivingtable$i"], true, true);

            if(!in_array( $_POST["receivingcolumn$i"], $table_columns_array ) ){
                $result = $wpdb->query( 'alter table '.$_POST["receivingtable$i"].' add column '.$_POST["receivingcolumn$i"].' TEXT default null' );
                if(!$result){
                    $this->UI->create_notice( 'CSV 2 POST attempted to add a new column named '.$_POST["receivingcolumn$i"].' to table named '.$_POST["receivingtable$i"], 'error', 'Small', 'Database Query Failure' );
                }elseif( $result){
                    $this->CSV2POST->create_notice( 'A new column named '.$_POST["receivingcolumn$i"].' was added to table named '.$_POST["receivingtable$i"], 'success', 'Small', 'New Column Added' );
                }
            }    
        }
          
        $rules_array = maybe_serialize( $rules_array );                
        $this->DB->update( $wpdb->c2psources, "sourceid = $sourceid->sourceid", array( 'rules' => $rules_array ) );
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function importdata0() {
        global $c2p_settings;
        $this->CSV2POST->import_from_csv_file( $_POST['sourceid'], $c2p_settings['currentproject'] );
    }
     
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */      
    public function importdata1() {
        global $c2p_settings;
        $this->CSV2POST->import_from_csv_file( $_POST['sourceid'], $c2p_settings['currentproject'] );   
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function importdata2() {
        global $c2p_settings;
        $this->CSV2POST->import_from_csv_file( $_POST['sourceid'], $c2p_settings['currentproject'] );    
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function importdata3() {
        global $c2p_settings;
        $this->CSV2POST->import_from_csv_file( $_POST['sourceid'], $c2p_settings['currentproject'] );    
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function importdata4() {
        global $c2p_settings;
        $this->CSV2POST->import_from_csv_file( $_POST['sourceid'], $c2p_settings['currentproject'] );    
    }
    
    /**
    * quick action data import request
    */
    public function importdatecurrentproject() {
        global $c2p_settings;
        
        // import records from all sources for curret project
        $sourceid_array = $this->CSV2POST->get_project_sourcesid( $c2p_settings['currentproject'] );
        foreach( $sourceid_array as $key => $source_id){
            $this->CSV2POST->import_from_csv_file( $source_id, $c2p_settings['currentproject'], 'import',2);
        }        
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function updatedatacurrentproject() {
        global $c2p_settings;
        
        // import records from all sources for curret project
        $sourceid_array = $this->CSV2POST->get_project_sourcesid( $c2p_settings['currentproject'] );
        foreach( $sourceid_array as $key => $source_id){
            $this->CSV2POST->import_from_csv_file( $source_id, $c2p_settings['currentproject'], 'update' );
        }  
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function categorydata() {
        global $c2p_settings;
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $project_settings = maybe_unserialize( $project_array->projectsettings );
        if(!is_array( $project_settings ) ){$project_settings = array();}
        
        unset( $project_settings['categories']['data'] );
        
        $onceonly_array = array();
        
        // first menu is required
        if( $_POST['categorylevel0'] == 'notselected' ){
            $this->UI->create_notice( __( 'The first level is always required. Please make a selection in the first menu.' ), 'error', 'Small', 'Level 0 Required' );
            return;
        }        

        // add first level to final array 
        $onceonly_array[] = $_POST['categorylevel0'];
        $cat1_exploded = explode( '#', $_POST['categorylevel0'] );
        $project_settings['categories']['data'][0]['table'] = $cat1_exploded[0];
        $project_settings['categories']['data'][0]['column'] = $cat1_exploded[1];
        
        for( $i=1;$i<=4;$i++){   
            if( $_POST["categorylevel$i"] !== 'notselected' ){
                if(in_array( $_POST["categorylevel$i"], $onceonly_array ) ){
                    $this->UI->create_notice( __( 'You appear to have selected the same table and column twice. Each level of categories normally requires
                    different terms/titles and so this validation exists to prevent accidental selection of the same column more than once.' ),
                    'error', 'Small', "Column Selected Twice");
                    return;
                }
                
                $onceonly_array[] = $_POST["categorylevel$i"];
                $exploded = explode( '#', $_POST["categorylevel$i"] );
                $project_settings['categories']['data'][$i]['table'] = $exploded[0];
                $project_settings['categories']['data'][$i]['column'] = $exploded[1];
                        
            }else{
                // break when we reach the first not selected, this ensures we do not allow user to skip a level
                break;
            }
        }

        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_settings ) ), true);
        $this->UI->create_notice( __( "Your category options have been saved."), 'success', 'Small', __( 'Categories Saved' ) );
    }
     
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */      
    public function categorydescriptions() {
        global $c2p_settings;
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $categories_array = maybe_unserialize( $project_array->projectsettings);
        if(!is_array( $categories_array ) ){$categories_array = array();}

        for( $i=0;$i<=4;$i++){
            if( isset( $_POST['level'.$i.'description'] ) ){
                $categories_array['categories']['meta'][$i]['description'] = $_POST['level'.$i.'description'];
            }           
        }
         
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $categories_array ) ), true);
        $this->UI->create_notice( __( "Your category descriptons have been saved."), 'success', 'Small', __( 'Category Descriptions Saved' ) );        
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function categorypairing() {
        global $wpdb, $c2p_settings;
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $categories_array = maybe_unserialize( $project_array->projectsettings);
        
        // remove all existing mapping
        if( isset( $categories_array['categories']['mapping'] ) ){unset( $categories_array['categories']['mapping'] );}
        
        // query and loop through distinct category terms
        foreach( $categories_array['categories']['data'] as $key => $catarray ){
                               
            $column = $catarray['column'];
            $table = $catarray['table'];

            $distinct_result = $wpdb->get_results( "SELECT DISTINCT $column FROM $table",ARRAY_A);
            foreach( $distinct_result as $key => $value ){
                
                $distinctval_cleaned = $this->CSV2POST->clean_string( $value[$column] );
                $nameandid = 'distinct'.$table.$column.$distinctval_cleaned;
                
                if( isset( $_POST[$column .'#'. $table .'#'. $distinctval_cleaned] ) ){
                    
                    if( isset( $_POST['existing'. $distinctval_cleaned] ) && $_POST['existing'. $distinctval_cleaned] != 'notselected' ){

                        $ourterm = $_POST[$column .'#'. $table .'#'. $distinctval_cleaned];// I think this is the same as $value[$column]
                        $categories_array['categories']['mapping'][$table][$column][ $ourterm ] = $_POST['existing'. $distinctval_cleaned];

                    }
                }
            }
        }
                         
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $categories_array ) ), true);
        $this->UI->create_notice( __( "Your category mapping has been saved."), 'success', 'Small', __( 'Category Map Saved' ) );
    }
    
    /**
    * manual category creation
    * 
    * requires all of users data to be imported to project table
    * the general procedure is the same as used on the projection screen but it has been adapted
    */          
    public function categorycreation() {
        global $c2p_settings;    
        
        $projection_array = array();

        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        
        $projectsettings = maybe_unserialize( $project_array->projectsettings);
          
        // we need to build a query that includes all columns and gets all rows
        $select = '';
        $from = 'notsetyet';
        foreach( $projectsettings['categories']['data'] as $level => $catarray ){
                                         
            $c = $catarray['column'];
            $t = $catarray['table'];
            
            if( $select === '' ){
                $select .= $c;
            }else{
                $select .= ', ' . $c;
            }
            
            // all columns must be in the same table (this can be adapted though)
            if( $from == 'notsetyet' ){
                $from = $t;
            }elseif( $from != $t){
                $this->UI->create_notice( __( 'Your category columns are not all within the same database table, no categories have been created. This is a strict requirement in the current version. It can be adapted if needed but the plugin is not currently ready to create categories using two or more tables.' ), 'error', 'Small', 'Too Many Tables' );
                return;
            }  
        } 
          
        $rows = $this->DB->selectorderby( $from, false, false, $select);

        if(!$rows){
            $this->UI->create_notice( __( 'No data appears to be available for creating your categories. Please ensure your data has been imported.' ), 'warning', 'Small', 'No Categories Created' );
            return;
        }
        
        foreach( $rows as $key => $category_group){
            $group_array = array();// we will store each cat ID in this array (use to apply parent and store in project table)
            $level = 0;// use this to query terms within current level, compare level + term name
     
            // if a level one category ID has been pre-set apply it and increase level 
            if( $level == 0 && isset( $projectsettings['categories']['presetcategoryid'] ) && is_numeric( $projectsettings['categories']['presetcategoryid'] ) ){       
                $group_array[$level] = $projectsettings['categories']['presetcategoryid'];
                
                ++$level;
            }
            
            foreach( $category_group as $column => $my_term){

                // do we need to create a category using $my_term or has user mapped the term to an existing cat ID
                if( isset( $projectsettings['categories']['mapping'][$from][$column][ $my_term ] ) && is_numeric( $projectsettings['categories']['mapping'][$from][$column][ $my_term ] ) ){         
                    $group_array[$level] = $projectsettings['categories']['mapping'][$from][$column][ $my_term ];    
                }else{       
                    // does term exist within the current level? 
                    $existing_term_id = $this->CSV2POST->term_exists_in_level( $my_term, $level);
        
                    if(is_numeric( $existing_term_id) ){
                        /* 
                        
                        we could check if the existing terms parent is also the expected parent within the users data 
                        however it gets complicated because the value in the data may also be mapped and so the expected parent
                        could be a mapped one, not sure how badly this is needed I can add it later 
                         
                        */
                        $group_array[$level] = $existing_term_id;
                    }else{
                        
                        // set parent id
                        $parent_id = 0;
                        if( $level > 0){
                            $parent_keyin_group = $level - 1;
                            $parent_id = $group_array[$parent_keyin_group];   
                        }
                        
                        // create a new category term
                        $new_cat_id = wp_create_category( $my_term, $parent_id );
                          
                        if( isset( $new_cat_id) && is_numeric( $new_cat_id) ){
                            $group_array[$level] = $new_cat_id; 
                        }else{
                            $this->UI->create_notice( __( 'WP returned an error when attempting to create a new category. The category creation procedure has been aborted, please report this to WebTechGlobal and provide your data for testing purposes.' ), 'error', 'Small', __( 'Category Creation Failure' ) );
                            return false;
                        }                         
                    }
                }                

                ++$level;
            }
        } 
        $this->UI->create_notice( __( 'Category creation has finished. Has the plugin has created them as expected? If you have any difficulties please seek support at WebTechGlobal.' ), 'success', 'Small', 'Categories Created' );    
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function newcustomfield() {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $customfields_array = maybe_unserialize( $project_array->projectsettings);
        
        // clean the cf name and if the cleaned string differs then the original is not suitable
        $cleaned_string = preg_replace( "/[^a-zA-Z0-9s_]/", "", $_POST['customfieldname'] );    
        if( $cleaned_string !== $_POST['customfieldname'] ){ 
            $this->UI->create_notice( __( 'Your custom field name/key is invalid. It must not contain spaces or special characters. Underscore is acceptable.' ), 'error', 'Small', 'Invalid Name' );
            return false;
        }
        
        // ensure a value was submitted
        if(empty( $_POST['customfielddefaultcontent'] ) ){
            $this->UI->create_notice( __( 'You did not enter a column token or any other content to the WYSIWYG editor.' ), 'error', 'Small', 'Custom Field Value Required' );
            return false;
        }
        
        // if unique ensure the custom field name has not already been used
        if( $_POST['customfieldunique'] == 'enabled' && isset( $customfields_array['customfields']['cflist'][$_POST['customfieldname']] ) ){ 
            $this->UI->create_notice( __( 'That custom field name already exists in your list. You opted for the custom field name to be unique for each post so you cannot use the name/key twice. If you require the custom field name to exist multiple times per post i.e. to create a list of items. Then please select No for the Unique option.' ), 'error', 'Small', 'Name Exists Already' );
            return false;       
        }

        // set next array key value
        $next_key = 0;

        // determine next array key
        if( isset( $customfields_array['customfields']['cflist'] ) ){    
            $next_key = $this->CSV2POST->get_array_nextkey( $customfields_array['customfields']['cflist'] );
        }   
               
        $customfields_array['customfields']['cflist'][$next_key]['id'] = $next_key;
        $customfields_array['customfields']['cflist'][$next_key]['name'] = $_POST['customfieldname'];
        $customfields_array['customfields']['cflist'][$next_key]['unique'] = $_POST['customfieldunique'];
        $customfields_array['customfields']['cflist'][$next_key]['updating'] = $_POST['customfieldupdating'];
        $customfields_array['customfields']['cflist'][$next_key]['value'] = $_POST['customfielddefaultcontent'];
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $customfields_array ) ), true);
        $this->UI->create_notice( __( "Your custom field has been added to the list."), 'success', 'Small', __( 'New Custom Field Created' ) );
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function deletecustomfieldrule() {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $customfields_array = maybe_unserialize( $project_array->projectsettings);
        
        if(!isset( $_GET['cfid'] ) ){
            $this->UI->create_notice( __( 'No ID was, no custom fields deleted.' ), 'error', 'Small', __( 'ID Required' ) );
            return;    
        }
        
        if(!isset( $customfields_array['cflist'][$_GET['cfid']] ) ){
            $this->UI->create_notice( __( 'The ID submitted could not be found, it appears your custom field has already been deleted.' ), 'error', 'Small', __( 'ID Does Not Exist' ) );
            return;            
        }
        
        unset( $customfields_array['cflist'][$_GET['cfid']] );
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $customfields_array ) ), true );
        $this->UI->create_notice( __( "Your custom field has been added to the list."), 'success', 'Small', __( 'New Custom Field Created' ) );        
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function singletaxonomies() {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $taxonomies_array = maybe_unserialize( $project_array->projectsettings);
        if(!is_array( $taxonomies_array ) ){$taxonomies_array = array();}

        for( $i=1; $i<=$_POST['numberoftaxonomies']; $i++){
            if( isset( $_POST["column$i"] ) && $_POST["column$i"] !== 'notselected' ) {
                $exploded_tax = explode( '.', $_POST["taxonomy$i"] );
                $exploded_col = explode( '#', $_POST["column$i"] );
                $post_type = $exploded_tax[0];
                $tax_name = $exploded_tax[1];                       
                $taxonomies_array['taxonomies']['columns'][$post_type][$tax_name]['table'] = $exploded_col[0];
                $taxonomies_array['taxonomies']['columns'][$post_type][$tax_name]['column'] = $exploded_col[1];
            }
        }

        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $taxonomies_array ) ), true);
        $this->UI->create_notice( __( "Your taxonomy setup has been updated."), 'success', 'Small', __( 'Taxonomies Updated' ) );                
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function basicpostoptions () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings); 
               
        $project_array['basicsettings']['poststatus'] = $_POST['poststatus'];
        $project_array['basicsettings']['pingstatus'] = $_POST['pingstatus'];
        $project_array['basicsettings']['commentstatus'] = $_POST['commentstatus'];
        $project_array['basicsettings']['defaultauthor'] = $_POST['defaultauthor'];
        $project_array['basicsettings']['defaultcategory'] = $_POST['defaultcategory'];
        $project_array['basicsettings']['defaultposttype'] = $_POST['defaultposttype'];
        $project_array['basicsettings']['defaultpostformat'] = $_POST['defaultpostformat'];
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true);
        $this->UI->create_notice( __( "Your basic post options have been saved."), 'success', 'Small', __( 'Basic Post Options Saved' ) );        
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function databasedoptions () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings); 

        if( $_POST['tags'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['tags'] );
            $project_array['tags']['table'] = $exploded[0];
            $project_array['tags']['column'] = $exploded[1];
        }
        
        if( $_POST['featuredimage'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['featuredimage'] );
            $project_array['featuredimage']['table'] = $exploded[0];
            $project_array['featuredimage']['column'] = $exploded[1];
        }
        
        if( $_POST['permalink'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['permalink'] );
            $project_array['permalink']['table'] = $exploded[0];
            $project_array['permalink']['column'] = $exploded[1];
        }
        
        if( $_POST['permalink'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['permalink'] );
            $project_array['urlcloak1']['table'] = $exploded[0];
            $project_array['urlcloak1']['column'] = $exploded[1];
        }
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true );
        $this->UI->create_notice( __( "Your data based post options have been saved."), 'success', 'Small', __( 'Data Based Post Options Saved' ) );    
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function authoroptions () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings); 

        if( $_POST['email'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['email'] );
            $project_array['authors']['email']['table'] = $exploded[0];
            $project_array['authors']['email']['column'] = $exploded[1];
        }
        
        if( $_POST['username'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['username'] );
            $project_array['authors']['username']['table'] = $exploded[0];
            $project_array['authors']['username']['column'] = $exploded[1];
        }
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true );
        $this->UI->create_notice( __( "Your selected author options have been saved. It is recommended that you run a small test on the new settings before mass creating posts/users."), 'success', 'Small', __( 'Author Options Saved' ) );    
    }    
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function defaulttagrules () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings); 

        if( $_POST['generatetags'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['generatetags'] );
            $project_array['tags']['generatetags']['table'] = $exploded[0];
            $project_array['tags']['generatetags']['column'] = $exploded[1];
        }
        
        $project_array['tags']['generatetagsexample'] = $_POST['generatetagsexample'];
        $project_array['tags']['numerictags'] = $_POST['numerictags'];
        $project_array['tags']['tagstringlength'] = $_POST['tagstringlength'];
        $project_array['tags']['maximumtags'] = $_POST['maximumtags'];
        $project_array['tags']['excludedtags'] = $_POST['excludedtags'];

        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true);
        $this->UI->create_notice( __( "You may want to test these settings before mass creating posts and generating a lot of tags."), 'success', 'Small', __( 'Tag Rules Saved' ) );    
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function defaultpublishdates () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings); 

        $project_array['dates']['publishdatemethod'] = $_POST['publishdatemethod'];
        
        if( $_POST['datescolumn'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['datescolumn'] );
            $project_array['dates']['table'] = $exploded[0];
            $project_array['dates']['column'] = $exploded[1];
        }
        
        $project_array['dates']['dateformat'] = $_POST['dateformat'];
        $project_array['dates']['incrementalstartdate'] = $_POST['incrementalstartdate'];
        $project_array['dates']['naturalvariationlow'] = $_POST['naturalvariationlow'];
        $project_array['dates']['naturalvariationhigh'] = $_POST['naturalvariationhigh'];
        $project_array['dates']['randomdateearliest'] = $_POST['randomdateearliest'];
        $project_array['dates']['randomdatelatest'] = $_POST['randomdatelatest'];

        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ) );
        $this->UI->create_notice( __( "You m a lot of tags."), 'success', 'Small', __( 'Post Dates Settings Saved' ) );    
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */          
    public function defaulttitletemplate () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings); 
        $project_array['titles']['defaulttitletemplate'] = $_POST['defaulttitletemplate'];
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true );
        $this->UI->create_notice( __( "Your title template design has been saved to your project settings."), 'success', 'Small', __( 'Title Template Updated' ) );    
    }  
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */        
    public function defaultcontenttemplate () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings); 
        
        // store the content as default value
        $project_array['content']['wysiwygdefaultcontent'] = stripslashes_deep( $_POST['wysiwygdefaultcontent'] );
  
        // if user opted, create a post content template also
        if( isset( $_POST['createnewtemplate'] ) && $_POST['createnewtemplate'] == 'yes' ){
            $post = array(
              'comment_status' => 'closed',
              'ping_status' => 'closed',
              'post_author' => get_current_user_id(),
              'post_content' => $content,
              'post_status' => 'publish', 
              'post_title' => $_POST['contenttemplatetitle'],
              'post_type' => 'wtgcsvcontent'
            );  
                        
            $post_id = wp_insert_post( $post, true );// returns WP_Error on fail  
            
            $this->UI->create_notice( __( 'A new content template has been created and your projects default content template was also updated.' ), 'success', 'Small', __( 'Content Template Created' ) );
            
        }else{
            $this->UI->create_notice( __( 'Your content template design has been saved.' ), 'success', 'Small', __( 'Content Template Updated' ) );    
        }
    
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true);     
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */           
    public function multipledesignsrules () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings);
        
        if( $_POST['designrulecolumn1'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['designrulecolumn1'] );    
            $project_array['content']['designrule1']['table'] = $exploded[0];         
            $project_array['content']['designrule1']['column'] = $exploded[1];
            $project_array['content']['designruletrigger1'] = $_POST['designruletrigger1'];
            $project_array['content']['designtemplate1'] = $_POST['designtemplate1'];
        }
        
        if( $_POST['designrulecolumn2'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['designrulecolumn2'] );
            $project_array['content']['designrule2']['table'] = $exploded[0];         
            $project_array['content']['designrule2']['column'] = $exploded[1];
            $project_array['content']['designruletrigger2'] = $_POST['designruletrigger2'];
            $project_array['content']['designtemplate2'] = $_POST['designtemplate2'];
        }
        
        if( $_POST['designrulecolumn3'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['designrulecolumn3'] );
            $project_array['content']['designrule3']['table'] = $exploded[0];         
            $project_array['content']['designrule3']['column'] = $exploded[1];        
            $project_array['content']['designruletrigger3'] = $_POST['designruletrigger3'];
            $project_array['content']['designtemplate3'] = $_POST['designtemplate3'];
        }
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true);
        $this->UI->create_notice( __( "Design template rules have been updated."), 'success', 'Small', __( 'Content Design Rules Saved' ) );    
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function defaultposttyperules () {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings);
        
        if( $_POST['posttyperule1'] !== 'notrequired' ) {    
            $exploded = explode( '#', $_POST['posttyperule1'] );
            $project_array['posttypes']['posttyperule1']['table'] = $exploded[0];         
            $project_array['posttypes']['posttyperule1']['column'] = $exploded[1];        
            $project_array['posttypes']['posttyperuletrigger1'] = $_POST['posttyperuletrigger1'];
            $project_array['posttypes']['posttyperuleposttype1'] = $_POST['posttyperuleposttype1'];
        }
        
        if( $_POST['posttyperule2'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['posttyperule2'] );
            $project_array['posttypes']['posttyperule2']['table'] = $exploded[0];         
            $project_array['posttypes']['posttyperule2']['column'] = $exploded[1];        
            $project_array['posttypes']['posttyperuletrigger2'] = $_POST['posttyperuletrigger2'];
            $project_array['posttypes']['posttyperuleposttype2'] = $_POST['posttyperuleposttype2'];
        }
        
        if( $_POST['posttyperule3'] !== 'notrequired' ) {
            $exploded = explode( '#', $_POST['posttyperule3'] );
            $project_array['posttypes']['posttyperule3']['table'] = $exploded[0];         
            $project_array['posttypes']['posttyperule3']['column'] = $exploded[1];        
            $project_array['posttypes']['posttyperuletrigger3'] = $_POST['posttyperuletrigger3'];
            $project_array['posttypes']['posttyperuleposttype3'] = $_POST['posttyperuleposttype3'];
        }
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ) );
        $this->UI->create_notice( __( "Your post type rules have been updated."), 'success', 'Small', __( 'Post Type Rules Saved' ) );    
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function applydefaultprojectsettings () {
        global $c2p_settings;
        $this->CSV2POST->apply_project_defaults( $c2p_settings['currentproject'] );
        $this->UI->create_notice( __( "Your current active projects settings have been set using your configured defaults."), 'success', 'Small', __( 'Project Settings Updated' ) );           
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function resetdefaultprojectsettings () {
        global $c2p_settings;
        
        // put users stored settings into another variable
        $active_settings = $c2p_settings;
        
        // include the settings array to get the original array of defaultproject settings
        require_once( WTG_CSV2POST_ABSPATH . 'arrays/settings_array.php' );
        $active_settings['projectdefaults'] = $c2p_settings['projectdefaults'];
        
        $this->CSV2POST->option( 'csv2post_settings', 'update', $active_settings);
        
        $this->UI->create_notice( __( "Default project settings have been reset to those stored in the settings_array.php file."), 'success', 'Small', __( 'Default Project Settings Reset' ) );           
    } 
    
    /**
    * a default array for projects settings
    * 
    * 1. right now table defaults to project main table as this will be the most common requirement, we'll upgrade this on request
    * 
    */
    public function defaultglobalpostsettings () {
        global $c2p_settings;
        
        $default_table = $this->CSV2POST->get_project_main_table( $c2p_settings['currentproject'] );
        
        $c2p_settings['projectdefaults'] = array();
        
        // the default settings will go into basicsettings as it is the main and most commonly used array     
        $c2p_settings['projectdefaults']['basicsettings']['poststatus'] = $_POST['poststatus'];
        $c2p_settings['projectdefaults']['basicsettings']['pingstatus'] = $_POST['pingstatus'];
        $c2p_settings['projectdefaults']['basicsettings']['commentstatus'] = $_POST['commentstatus'];
        $c2p_settings['projectdefaults']['basicsettings']['defaultauthor'] = $_POST['defaultauthor'];
        $c2p_settings['projectdefaults']['basicsettings']['defaultcategory'] = $_POST['defaultcategory'];
        $c2p_settings['projectdefaults']['basicsettings']['defaultposttype'] = $_POST['defaultposttype'];
        $c2p_settings['projectdefaults']['basicsettings']['defaultpostformat'] = $_POST['defaultpostformat'];
        $c2p_settings['projectdefaults']['basicsettings']['categoryassignment'] = $_POST['categoryassignment'];
        
        // wordpress post settings requiring data - right now only column is entered on UI        
        $c2p_settings['projectdefaults']['images']['featuredimage']['table'] = $default_table;
        $c2p_settings['projectdefaults']['images']['featuredimage']['column'] = $_POST['featuredimage'];
        $c2p_settings['projectdefaults']['permalinks']['table'] = $default_table;
        $c2p_settings['projectdefaults']['permalinks']['column'] = $_POST['permalink'];
        $c2p_settings['projectdefaults']['cloaking']['urlcloak1']['table'] = $default_table;
        $c2p_settings['projectdefaults']['cloaking']['urlcloak1']['column'] = $_POST['urlcloak1'];
        
        // authors
        $c2p_settings['projectdefaults']['authors']['email']['table'] = $default_table;
        $c2p_settings['projectdefaults']['authors']['email']['column'] = $_POST['email'];
        $c2p_settings['projectdefaults']['authors']['username']['table'] = $default_table;
        $c2p_settings['projectdefaults']['authors']['username']['column'] = $_POST['username'];
                
        // title template
        $c2p_settings['projectdefaults']['titles']['defaulttitletemplate'] = $_POST['defaulttitletemplate'];
        
        // main content
        $c2p_settings['projectdefaults']['content']['wysiwygdefaultcontent'] = $_POST['wysiwygdefaultcontent'];
        
        // custom fields specifically for seo plugins
        $c2p_settings['projectdefaults']['customfields']['seotitletemplate'] = $_POST['seotitletemplate'];        
        $c2p_settings['projectdefaults']['customfields']['seotitlekey'] = $_POST['seotitlekey']; 
        $c2p_settings['projectdefaults']['customfields']['seodescriptionkey'] = $_POST['seodescriptionkey'];
        $c2p_settings['projectdefaults']['customfields']['seodescriptiontemplate'] = $_POST['seodescriptiontemplate'];
        $c2p_settings['projectdefaults']['customfields']['seokeywordskey'] = $_POST['seokeywordskey'];
        $c2p_settings['projectdefaults']['customfields']['seokeywordstemplate'] = $_POST['seokeywordstemplate'];
        
        // custom fields
        if(!empty( $_POST['cfkey1'] ) && !empty( $_POST['cftemplate1'] ) ){
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['id'] = 0;// used in WP_Table class to pass what is actually the key, use they key though where unique value is required
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['name'] = $_POST['cfkey1'];// the key
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['value'] = $_POST['cftemplate1'];// on UI it is a template 
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['unique'] = '';
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['updating'] = '';
        }
        
        if(!empty( $_POST['cfkey2'] ) && !empty( $_POST['cftemplate2'] ) ){
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['id'] = 1;
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['name'] = $_POST['cfkey2'];
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['value'] = $_POST['cftemplate2'];
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['unique'] = '';
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['updating'] = '';
        }
        
        if(!empty( $_POST['cfkey3'] ) && !empty( $_POST['cftemplate3'] ) ){
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['id'] = 2;
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['name'] = $_POST['cfkey3'];
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['value'] = $_POST['cftemplate3'];
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['unique'] = '';
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['updating'] = '';
        }
        
        // template design rules
        $c2p_settings['projectdefaults']['content']['designrule1']['table'] = $default_table;
        $c2p_settings['projectdefaults']['content']['designrule1']['column'] = $_POST['designrule1'];
        $c2p_settings['projectdefaults']['content']['designruletrigger1'] = $_POST['designruletrigger1'];
        $c2p_settings['projectdefaults']['content']['designtemplate1'] = $_POST['designtemplate1'];
        $c2p_settings['projectdefaults']['content']['designrule2']['table'] = $default_table;
        $c2p_settings['projectdefaults']['content']['designrule2']['column'] = $_POST['designrule2'];
        $c2p_settings['projectdefaults']['content']['designruletrigger2'] = $_POST['designruletrigger2'];
        $c2p_settings['projectdefaults']['content']['designtemplate2'] = $_POST['designtemplate2'];
        $c2p_settings['projectdefaults']['content']['designrule3']['table'] = $default_table;
        $c2p_settings['projectdefaults']['content']['designrule3']['column'] = $_POST['designrule3'];
        $c2p_settings['projectdefaults']['content']['designruletrigger3'] = $_POST['designruletrigger3'];
        $c2p_settings['projectdefaults']['content']['designtemplate3'] = $_POST['designtemplate3'];

        // images and media requireing token or shortcode to be entered to post content
        $c2p_settings['projectdefaults']['content']['enablegroupedimageimport'] = $_POST['enablegroupedimageimport'];
        $c2p_settings['projectdefaults']['content']["localimages"]['table'] = $default_table;
        $c2p_settings['projectdefaults']['content']["localimages"]['column'] = $_POST['localimagesdatacolumn'];
        $c2p_settings['projectdefaults']['content']['incrementalimages'] = $_POST['incrementalimages'];
        $c2p_settings['projectdefaults']['content']['groupedimagesdir'] = 
        // pre-set level one category
        $c2p_settings['projectdefaults']['categories']['presetcategoryid'] = false;// change to a category ID
        
        // category columns
        if(!empty( $_POST['categorylevel1'] ) ){
            $c2p_settings['projectdefaults']['categories']['data'][0]['table'] = $default_table;
            $c2p_settings['projectdefaults']['categories']['data'][0]['column'] = $_POST['categorylevel1'];
        
            if(!empty( $_POST['categorylevel2'] ) ){
                $c2p_settings['projectdefaults']['categories']['data'][1]['table'] = $default_table;
                $c2p_settings['projectdefaults']['categories']['data'][1]['column'] = $_POST['categorylevel2'];
            
                if(!empty( $_POST['categorylevel3'] ) ){
                    $c2p_settings['projectdefaults']['categories']['data'][2]['table'] = $default_table;
                    $c2p_settings['projectdefaults']['categories']['data'][2]['column'] = $_POST['categorylevel3'];
                
                    if(!empty( $_POST['categorylevel4'] ) ){
                        $c2p_settings['projectdefaults']['categories']['data'][3]['table'] = $default_table;
                        $c2p_settings['projectdefaults']['categories']['data'][3]['column'] = $_POST['categorylevel4'];
                        
                        if(!empty( $_POST['categorylevel5'] ) ){
                            $c2p_settings['projectdefaults']['categories']['data'][4]['table'] = $default_table;
                            $c2p_settings['projectdefaults']['categories']['data'][4]['column'] = $_POST['categorylevel5'];
                        }                    
                    }                                
                }          
            }        
        }
                       
        // category descriptions
        for( $i=0;$i<=4;$i++){                      
            $c2p_settings['projectdefaults']['categories']["descriptiondata"][$i]['table'] = $default_table;
            $c2p_settings['projectdefaults']['categories']["descriptiondata"][$i]['column'] = $_POST["categorydescription$i"];
            $c2p_settings['projectdefaults']['categories']["descriptiontemplates"][$i] = $_POST["categorydescriptiontemplate$i"];
        }
        
        // adoption
        $c2p_settings['projectdefaults']['adoption']['adoptionmethod'] = $_POST['adoptionmethod'];
        $c2p_settings['projectdefaults']['adoption']['allowedchanges'] = $_POST['allowedchanges'];
        $c2p_settings['projectdefaults']['adoption']['adoptionmetakey'] = $_POST['adoptionmetakey'];
        $c2p_settings['projectdefaults']['adoption']['adoptionmeta']['table'] = $default_table;
        $c2p_settings['projectdefaults']['adoption']['adoptionmeta']['column'] = $_POST['adoptionmeta'];
        
        // tags
        $c2p_settings['projectdefaults']['tags']['column'] = $_POST['tags'];// ready made tags
        $c2p_settings['projectdefaults']['tags']['textdata']['table'] = $default_table;// generate tags from text
        $c2p_settings['projectdefaults']['tags']['textdata']['column'] = $_POST['textdata'];// generate tags from text
        $c2p_settings['projectdefaults']['tags']['defaultnumerics'] = $_POST['defaultnumerics'];
        $c2p_settings['projectdefaults']['tags']['tagstringlength'] = $_POST['tagstringlength'];
        $c2p_settings['projectdefaults']['tags']['maximumtags'] = $_POST['maximumtags'];
        $c2p_settings['projectdefaults']['tags']['excludedtags'] = $_POST['excludedtags'];
        
        // post type rules
        for( $i=1;$i<=3;$i++){
            $c2p_settings['projectdefaults']['posttypes']["posttyperule$i"]['table'] = $default_table;
            $c2p_settings['projectdefaults']['posttypes']["posttyperule$i"]['column'] = $_POST["posttyperule$i"];
            $c2p_settings['projectdefaults']['posttypes']["posttyperuletrigger$i"] = $_POST["posttyperuletrigger$i"];
            $c2p_settings['projectdefaults']['posttypes']["posttyperuleposttype$i"] = $_POST["posttyperuleposttype$i"];
        }
        
        // publish dates
        $c2p_settings['projectdefaults']['dates']['publishdatemethod'] = $_POST['publishdatemethod'];
        $c2p_settings['projectdefaults']['dates']['column'] = $_POST['dates'];
        $c2p_settings['projectdefaults']['dates']['dateformat'] = $_POST['dateformat'];
        $c2p_settings['projectdefaults']['dates']['incrementalstartdate'] = $_POST['incrementalstartdate'];
        $c2p_settings['projectdefaults']['dates']['naturalvariationlow'] = $_POST['naturalvariationlow'];
        $c2p_settings['projectdefaults']['dates']['naturalvariationhigh'] = $_POST['naturalvariationhigh'];
        $c2p_settings['projectdefaults']['dates']['randomdateearliest'] = $_POST['randomdateearliest'];
        $c2p_settings['projectdefaults']['dates']['randomdatelatest'] = $_POST['randomdatelatest'];
        
        // post updating
        $c2p_settings['projectdefaults']['updating']['updatepostonviewing'] = $_POST['updatepostonviewing'];     
        
        $this->CSV2POST->update_settings( $c2p_settings);
        $this->UI->create_notice( __( 'Your default project settings have been stored. Many of the setting will only work with multiple different
        projects if each projects datasource has the same format/configuration. Please configure projects individually where required and do not
        rely on these defaults if working with various different sources.', 'csv2post' ), 'success', 'Small', __( 'Default Project Options Stored Successfully', 'csv2post' ) );
    }
    
    /**
    * creates posts manually from tools with manual insert of parameters
    */
    public function createpostsbasic() {
        global $c2p_settings;
        
        // set total posts to be created
        $total = 1;
        
        if( isset( $_POST['totalposts'] ) && is_numeric( $_POST['totalposts'] ) ){
            $total = $_POST['totalposts'];
        }        
                 
        $this->CSV2POST->create_posts( $c2p_settings['currentproject'], $total); 
        
        $this->UI->create_notice( __( 'Post creation request was performed. This notice does not indicate that posts were created. The actual results should be displayed above this notice.', 'csv2post' ),  'success', 'Small', __( 'Post Creation Ended', 'csv2post' ) );   
    }
    
    /**
    * creates posts manually from quick actions and uses pre-set parameters
    */    
    public function createpostscurrentproject() {
        global $c2p_settings;
        $this->CSV2POST->create_posts( $c2p_settings['currentproject'],1);    
    } 
    
    /**
    * updates posts manually from tools with manual insert of parameters
    */
    public function updatepostsbasic() {
        global $c2p_settings; 
           
        // set total posts to be created
        $total = 1;
        
        if( isset( $_POST['totalposts'] ) && is_numeric( $_POST['totalposts'] ) ){
            $total = $_POST['totalposts'];
        }
        
        $this->CSV2POST->update_posts( $c2p_settings['currentproject'], $total);    
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function updatepostsbasicnewdataonly() {
        global $c2p_settings;
        
        // set total posts to be created
        $total = 1;
        if( isset( $_POST['totalposts'] ) && is_numeric( $_POST['totalposts'] ) ){$total = $_POST['totalposts'];}
            
        // query for rows of data that have been updated
        $rows = $this->CSV2POST->get_updated_rows( $c2p_settings['currentproject'], $total, $this->CSV2POST->get_project_idcolumn( $c2p_settings['currentproject'] ) );
        if(!$rows){
            $this->UI->create_notice( __( 'None of your imported rows have been updated since their original import.' ), 'info', 'Small', 'No Posts Updated' );
            return;            
        }
     
        $this->CSV2POST->update_posts( $c2p_settings['currentproject'], $total, false, array( 'rows' => $rows) );    
    }   
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */        
    public function updatepostsbasicprojectchangesonly() {
        global $c2p_settings;
                                                  
        // set total posts to be created
        $total = 1;
        if( isset( $_POST['totalposts'] ) && is_numeric( $_POST['totalposts'] ) ){$total = $_POST['totalposts'];}

        // query for rows that have not been applied since the project configuration changed
        $rows = $this->CSV2POST->get_outdatedpost_rows( $c2p_settings['currentproject'], $total);
        
        if(!$rows){        
            $this->UI->create_notice( __( 'No posts appear to need updating. All applied dates are later than when you changed your projects settings.' ), 'info', 'Small', 'No Posts Require Updating' );
            return;            
        }
                  
        $this->CSV2POST->update_posts( $c2p_settings['currentproject'], $total, false, array( 'rows' => $rows) );    
    }  
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */         
    public function updatespecificpost() {
        global $c2p_settings;
        
        // set total posts to be created
        $total = 1;
        if( empty( $_POST['updatespecificpostid'] ) ){
            $this->UI->create_notice( __( 'A post ID is required. Please enter a numeric value then submit the form again.' ), 'error', 'Small', __( 'Post ID Required' ) );
            return;
        } 
        
        if( !is_numeric( $_POST['updatespecificpostid'] ) ){
            $this->UI->create_notice( __( 'You have not entered a numeric value for your post ID.' ), 'error', 'Small', __( 'Numeric Post ID Required' ) );           
            return;    
        }                                   

        $this->CSV2POST->update_posts( $c2p_settings['currentproject'], $total, $_POST['updatespecificpostid'] ); 
         
        $this->UI->create_notice( __( 'Your update request for post with ID '. $_POST['updatespecificpostid'] .' has finished. The results should be displayed in another notice.' ), 'success', 'Small', __( 'Post Update Request Complete' ) );            
    }
    
    /**
    * updates posts manually from quick actions and uses pre-set parameters
    */    
    public function updatepostscurrentproject() {
        global $c2p_settings;
        $this->CSV2POST->update_posts( $c2p_settings['currentproject'],1);    
    }
    
    /**
    * processes submitted string for nested spinner and outputs   
    */
    public function spintaxtest() {
        if(!isset( $_POST['spintaxteststring'] ) || empty( $_POST['spintaxteststring'] ) ){
            $this->UI->create_notice( 'No value was submitted. Please paste or type some text with bracket/nested spintax included.', 'info', 'Small', 'No Value Submitted' );
            return;
        }
        
        $result = $this->CSV2POST->spin( $_POST['spintaxteststring'] );
        
        $this->UI->create_notice( $result, 'success', 'Extra', 'Spintax Test Result' );
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function groupimportlocalimages () {  
        if(!isset( $_POST['groupimportdir'] ) || empty( $_POST['groupimportdir'] ) ){
            $this->UI->create_notice( __( 'A path to your image directory is required.' ), 'error', 'Small', __( 'Image Directory Required' ) );
            return;
        }
                      
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings);

        $project_array['content']['enablegroupedimageimport'] = $_POST['enablegroupedimageimport'];
        
        $exploded = explode( '#', $_POST['localimagesdata'] );
        
        // these values are for unique values making up part or all of file names, not for data with paths
        $project_array['content']["localimages"]['table'] = $exploded[0];
        $project_array['content']["localimages"]['column'] = $exploded[1]; 
        $project_array['content']["incrementalimages"] = $_POST['incrementalimages'];
        $project_array['content']["groupedimagesdir"] = $_POST['groupimportdir'];
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true);
        $this->UI->create_notice( __( "Images will be imported during post creation to the Wordpress media library and inserted to
        content as a list if you are using the #localimagelist# token."), 'success', 'Small', __( 'Grouped Image Import Settings Saved' ) );                        
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function reinstalldatabasetables() {
        $installation = new C2P_Install();
        $installation->reinstalldatabasetables();
        $this->UI->create_notice( 'All tables were re-installed. Please double check the database status list to
        ensure this is correct before using the plugin.', 'success', 'Small', 'Tables Re-Installed' );
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function presetlevelonecategory() {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings);
            
        if(!is_numeric( $_POST['presetcategoryid'] ) ){
            $this->UI->create_notice( 'You did not enter a valid category ID also known as a slug ID.', 'error', 'Small', 'No Category ID' );
            return;    
        }
        
        $project_array['categories']['presetcategoryid'] = $_POST['presetcategoryid'];
        
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true );
        $this->UI->create_notice( __( "You have setup a pre-set level one category. Any categories CSV 2 POST creates will be level two
        or lower and will be children of the parent with ID " . $project_array['categories']['presetcategoryid'] ), 'success', 'Small', __( 'Pre-Set Level One Category' ) );   
    }  
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */          
    public function globalswitches() {
        global $c2p_settings;
        $c2p_settings['standardsettings']['textspinrespinning'] = $_POST['textspinrespinning'];
        $c2p_settings['standardsettings']['systematicpostupdating'] = $_POST['systematicpostupdating'];
        $this->CSV2POST->update_settings( $c2p_settings); 
        $this->UI->create_notice( __( 'Global switches have been updated. These switches can initiate the use of 
        advanced systems. Please monitor your blog and ensure the plugin operates as you expected it to. If
        anything does not appear to work in the way you require please let WebTechGlobal know.' ),
        'success', 'Small', __( 'Global Switches Updated' ) );       
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */         
    public function replacevaluerules() {
        global $c2p_settings;    
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
        $project_array = maybe_unserialize( $project_array->projectsettings);

        // set next array key value
        $next_key = 0;
                 
        // determine next array key
        if( isset( $project_array['content']['valuerules'] ) ){    
            $next_key = $this->CSV2POST->get_array_nextkey( $project_array['content']['valuerules'] );
        }   
        
        $exploded = explode( '#', $_POST['vrvdata'] ); 
        $project_array['content']['valuerules'][$next_key]['id'] = $next_key;       
        $project_array['content']['valuerules'][$next_key]['table'] = $exploded[0];
        $project_array['content']['valuerules'][$next_key]['column'] = $exploded[1];
        $project_array['content']['valuerules'][$next_key]['vrvdatavalue'] = $_POST['vrvdatavalue'];
        $project_array['content']['valuerules'][$next_key]['vrvreplacementvalue'] = $_POST['vrvreplacementvalue'];
  
        $this->CSV2POST->update_project( $c2p_settings['currentproject'], array( 'projectsettings' => maybe_serialize( $project_array ) ), true );
        $this->UI->create_notice( __( 'A new value replacement rule has been stored. Please test your new rule.' ), 'success', 'Small',
        __( 'Replace Value Rule Created' ) );   
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function displayprojectsummary() {
        global $c2p_settings;
        $message = '';
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $project_settings = maybe_unserialize( $project_array->projectsettings);

        $message .= '<table class="form-table">';        
        
        $message .= '<tr valign="top">';
        $message .= '<th scope="row">ID</th>';
        $message .= '<td>'.$project_array->projectid.'</td>';
        $message .= '</tr>';
        
        $message .= '<tr valign="top">';
        $message .= '<th scope="row">Project Name</th>';
        $message .= '<td>'.$project_array->projectname.'</td>';
        $message .= '</tr>';        
        
        $message .= '<tr valign="top">';
        $message .= '<th scope="row">Timestamp</th>';
        $message .= '<td>'.$project_array->timestamp.'</td>';
        $message .= '</tr>';        
        
        $message .= '<tr valign="top">';
        $message .= '<th scope="row">Source 1 ID</th>';
        $message .= '<td>'.$project_array->source1.'</td>';
        $message .= '</tr>';        
        
        if( isset( $project_array->source2) && $project_array->source2 != 0){
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Source 2 ID</th>';
            $message .= '<td>'.$project_array->source2.'</td>';
            $message .= '</tr>';        
        }
        
        if( isset( $project_array->source3) && $project_array->source3 != 0){
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Source 3 ID</th>';
            $message .= '<td>'.$project_array->source3.'</td>';
            $message .= '</tr>'; 
        }       
        
        if( isset( $project_array->source4) && $project_array->source4 != 0){
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Source 4 ID</th>';
            $message .= '<td>'.$project_array->source4.'</td>';
            $message .= '</tr>';
        }
        
        if( isset( $project_array->source5) && $project_array->source5 != 0){
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Source 5 ID</th>';
            $message .= '<td>'.$project_array->source5.'</td>';
            $message .= '</tr>';
        }

        $message .= '<tr valign="top">';
        $message .= '<th scope="row">Lock Content</th>';
        $message .= '<td>'.$project_array->lockcontent.'</td>';
        $message .= '</tr>';
        
        $message .= '<tr valign="top">';
        $message .= '<th scope="row">Lock Meta</th>';
        $message .= '<td>'.$project_array->lockmeta.'</td>';
        $message .= '</tr>';
        
        $message .= '<tr valign="top">';
        $message .= '<th scope="row">Data Treatment</th>';
        $message .= '<td>'.$project_array->datatreatment.'</td>';
        $message .= '</tr>'; 

        $message .= '<tr valign="top">';
        $message .= '<th scope="row">Settings Changed</th>';
        $message .= '<td>'.$project_array->settingschange.'</td>';
        $message .= '</tr>';
                                        
        $message .= '</table>';
  
        $this->UI->create_notice( $message, 'info', 'Extra', 'Project Summary', false, 'http://www.webtechglobal.co.uk/wordpress/csv-2-post/project-summary-explained/' );
    } 
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */         
    public function displaysourcesummary() {
        global $c2p_settings;
        $project_array = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $source = $this->CSV2POST->get_source( $c2p_settings['currentproject'], $project_array->source1); 
        $config = maybe_unserialize( $source->theconfig);
        if( $source){
            $message = '';
            $message .= '<table class="form-table">';

            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Source ID</th>';
            $message .= '<td>'.$source->sourceid.'</td>';
            $message .= '</tr>';  
      
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Project ID</th>';
            $message .= '<td>'.$source->projectid.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Submitted Path</th>';
            $message .= '<td>'.$config['submittedpath'].'</td>';  
            $message .= '</tr>';        
           
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Full Path</th>';
            $message .= '<td>'.$config['fullpath'].'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Separator</th>';
            $message .= '<td>'.$config['sep'].'</td>';
            $message .= '</tr>';  
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Fields</th>';
            $message .= '<td>'.$config['fields'].'</td>';
            $message .= '</tr>';              
                    
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Source Type</th>';
            $message .= '<td>'.$source->sourcetype.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Progress</th>';
            $message .= '<td>'.$source->progress.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Timestamp</th>';
            $message .= '<td>'.$source->timestamp.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Path</th>';
            $message .= '<td>'.$source->path.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Key Column</th>';
            $message .= '<td>'.$source->idcolumn.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Monitor Change</th>';
            $message .= '<td>'.$source->monitorchange.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Change Counter</th>';
            $message .= '<td>'.$source->changecounter.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Data Treatment</th>';
            $message .= '<td>'.$source->datatreatment.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Parent File ID</th>';
            $message .= '<td>'.$source->parentfileid.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Database Table</th>';
            $message .= '<td>'.$source->tablename.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Rules</th>';
            $message .= '<td>'.$source->rules.'</td>';
            $message .= '</tr>';
            
            $message .= '<tr valign="top">';
            $message .= '<th scope="row">Separator</th>';
            $message .= '<td>'.$source->thesep.'</td>';
            $message .= '</tr>';

            $message .= '</table>';            
            $this->UI->create_notice( $message, 'info', 'Extra', 'Data Source Summary', false, 'http://www.webtechglobal.co.uk/wordpress/csv-2-post/data-source-summary/' );
        }else{
             $this->UI->create_notice( __( 'Data source entry does not exist. If the data source exist i.e. database table
             then it will need to be entered into the sources table so CSV 2 POST can monitor it.' ), 'info', 'Extra', __( 'Data Source Entry Not Found' ) );
        }
    }
    /**
    * used by queryduplicateposts to deletion duplicates
    * 
    * expects a specific ARRAY_A $result which includes a string of ids created
    * by a GROUP_CONCAT query
    * 
    * @param mixed $result
    */
    static function deleteduplicateposts( $result ){
        $total_posts_deleted = 0;
        // loop through the posts that have duplicates
        foreach( $result as $key => $dup){
            // explode the returned post ID's (avoid deleting the first, that is the one we will keep)
            $dup_ids_array = explode( ', ', $dup['ids'] );
            
            $first = true;
            
            // loop through duplicate post ID's
            foreach( $dup_ids_array as $key => $postid){
                if( $key !== 0){
                    $forcedelete = false;
                    if( isset( $_POST['forcedelete'] ) ){$forcedelete = true;}
                    wp_delete_post( $postid, $forcedelete );
                    ++$total_posts_deleted;
                }
            }
        }  
        return $total_posts_deleted;  
    } 
    
    /**
    * deletes duplicate posts
    */
    public function queryduplicateposts () {
        global $wpdb;

        $total_posts_deleted = 0;
        
        // get one of two ID's where post titles are perfect match
        $result = $wpdb->get_results( 'SELECT COUNT(*) as cnt, GROUP_CONCAT(ID) AS ids
                                        FROM '.$wpdb->posts.'
                                        WHERE post_status != "inherit"
                                        AND post_status != "trash"
                                        GROUP BY post_title
                                        HAVING cnt > 1',ARRAY_A );
        if( $result){
            $deleted_count = $this->deleteduplicateposts( $result);
            $total_posts_deleted = $total_posts_deleted + $deleted_count;
        }
        
        // get one of two ID's where post content is perfect match  
        /*                        
        $result = $wpdb->get_results( 'SELECT COUNT(*) as c, GROUP_CONCAT(ID) AS ids
                                        FROM wp_posts
                                        GROUP BY post_content
                                        HAVING c > 1' );
                                        
        if( $result){
            echo 'Second method found duplicates <br> ';
        }  */

        // delete post tat share the same c2p_rowid value
        if( isset( $_POST['safetycodeconfirmed'] ) && $_POST['safetycodeconfirmed'] === $_POST['deleteduplicatepostssafetycode'] ){
                                   
            // get one of two ID's where                                 
            $result = $wpdb->get_results( 'SELECT COUNT(*) as cnt, GROUP_CONCAT(post_id) AS ids
                                            FROM '.$wpdb->postmeta.'
                                            WHERE meta_key = "c2p_rowid"
                                            GROUP BY meta_key,meta_value
                                            HAVING cnt > 1',ARRAY_A );

            if( $result){
                $deleted_count = $this->deleteduplicateposts( $result);
                $total_posts_deleted = $total_posts_deleted + $deleted_count;
            }
        }
                  
        if( $total_posts_deleted == 0){
            $this->UI->create_notice( __( 'No duplicate posts were found, no changes were made to your blog.' ), 'info', 'Small', __( 'No Duplicates' ) );
        }else{
            $this->UI->create_notice( "A total of $total_posts_deleted posts were deleted.", 'success', 'Small', 'Duplicate Posts Deleted' );
        }
    }  
     
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */         
    public function undoprojectposts() {
        global $c2p_settings, $wpdb;
        if(!current_user_can( 'delete_posts' ) ){
            $this->UI->create_notice( __( 'You do not have permission to delete posts.' ), 'error', 'Small', __( 'Not Permitted' ) );
            return;
        }
        if(!isset( $_POST['undoallpostsconfirm'] ) || $_POST['undoallpostsconfirm'] !== $_POST['undoallpostssafecode'] ){
            $this->UI->create_notice( __( 'You must enter the safety code and confirm you really want to delete all of the current projects posts.' ), 'error', 'Small', __( 'Not Permitted' ) );
            return;        
        }
        
        $limit = 30;
        if( isset( $_POST['undopostslimit'] ) && is_numeric( $_POST['undopostslimit'] ) ){$limit = $_POST['undopostslimit'];}
        
        $result = $wpdb->get_results( 'SELECT post_id
        FROM '.$wpdb->postmeta.' 
        WHERE meta_key = "c2p_project" 
        AND meta_value = "'.$c2p_settings['currentproject'].'"
        LIMIT ' . $limit,ARRAY_A );
         
        if(!$result){
            $this->UI->create_notice( __( 'No posts were found for the current project. Are you sure you created some?' ), 'info', 'Small', __( 'No Posts Deleted' ) );
        }else{
            $posts_deleted = 0;
            foreach( $result as $key => $postid){
                $forcedelete = false;
                if( isset( $_POST['forcedelete'] ) ){$forcedelete = true;}
                wp_delete_post( $postid['post_id'], $forcedelete );
                $wpdb->query( 'UPDATE `'.$this->CSV2POST->get_project_main_table( $c2p_settings['currentproject'] ).'` SET `c2p_postid` = 0 WHERE `c2p_postid` = ' . $postid['post_id'] );
                ++$posts_deleted;
            }
            $this->UI->create_notice( __( "A total of $posts_deleted posts were deleted. All
            post ID have been removed from the projects database table so that you can re-create the posts."), 'success', 'Small', __( 'Posts Deleted' ) );
        }
    }    
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function resetimportedrows() {
        global $wpdb, $c2p_settings;
        $result = $wpdb->query( 'UPDATE `'.$this->CSV2POST->get_project_main_table( $c2p_settings['currentproject'] ).'` SET `c2p_postid` = 0' );
        $this->UI->create_notice( "The plugin removed all post ID's from a total of $result rows in your imported data for the current project.", 'success', 'Small', __( 'Result Rows Results' ) );
    }
    
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */       
    public function newprojectandnewcsvfiles() {
        global $wpdb, $c2p_settings;
        $error = false;
        $files_array = array( 'total_files' => 0);
        
        if(empty( $_POST['csvfile1'] ) || empty( $_POST['csvfile2'] ) && !empty( $_POST['csvfile3'] ) || empty( $_POST['csvfile3'] ) && !empty( $_POST['csvfile4'] ) || empty( $_POST['csvfile4'] ) && !empty( $_POST['csvfile5'] ) ){
            $this->UI->create_notice( 'You have missed a required field. Fields marked with an asterix * are required.', 'error', 'Small', 'Field Required' );
            return;
        }
                
        // how many files were submitted
        for( $i=1;$i<=20;$i++){
            if(!empty( $_POST['csvfile'.$i] ) ){
                ++$files_array['total_files'];
            }
        }
        
        // ensure all files exist
        for( $i=1;$i<=$files_array['total_files'];$i++){
            if(!empty( $_POST['csvfile'.$i] ) ){
                
                $files_array[$i]['submittedpath'] = $_POST['csvfile'.$i];
                $files_array[$i]['fullpath'] = ABSPATH . $_POST['csvfile'.$i];
                
                $file_one_exists = file_exists( $files_array[$i]['fullpath'] );
                if(!$file_one_exists)
                {
                    $error = true;
                    $path = $files_array[$i]['fullpath'];
                    $this->UI->create_notice( "File $i could not be located, please ensure the path is correct and your file exists.
                    The path checked was $path", 'error', 'Small', 'File Not Found' );    
                }
            }        
        }
        
        if( $error){return;}
        
        // ensure all files are .csv
        for( $i=1;$i<=$files_array['total_files'];$i++){
            // ensure file is .csv
            if(pathinfo( $files_array[$i]['fullpath'], PATHINFO_EXTENSION) != 'csv' )
            {
                $error = true;
                $this->UI->create_notice( "File $i is not a CSV file. Either change the extension to .csv or use software to re-format it.", 'error', 'Small', 'Not .csv' );
            }         
        }
        
        if( $error){return;}
        
        // build each files configuration (separate, number of fields, original headers and sql ready headers for comparison)
        for( $i=1;$i<=$files_array['total_files'];$i++){
            $files_array[$i]['sep'] = $this->CSV2POST->established_separator( $files_array[$i]['fullpath'] );
           
            // we are ready to read the file
            $file = new SplFileObject( $files_array[$i]['fullpath'] );
            while (!$file->eof() ) {
                $header_array = $file->fgetcsv( $files_array[$i]['sep'], '"' );
                break;// we just need the first line to do a count()
            }

            // count number of fields
            $files_array[$i]['fields'] = count( $header_array ); 
      
            foreach( $header_array as $key => $header){  
                $files_array[$i]['originalheaders'][$key] = $header;
                $files_array[$i]['sqlheaders'][$key] = $this->PHP->clean_sqlcolumnname( $header);        
            }
            
            // store basename for each file
            $files_array[$i]['basename'] = basename( $files_array[$i]['fullpath'] ); 
            
            // clean the basename for mysql ready table name (data treatment individual is the only one requiring all files to have a tablename but we will create it to use for other purposes)
            $files_array[$i]['tablename'] = $wpdb->prefix . $this->PHP->clean_sqlcolumnname( $files_array[$i]['basename'] ); 

            // although this will be the same for every file and a multifile project I'm adding it to avoid having to run 
            // another query to establish how a file should be treated despite the treatment also being stored in project table. (just depends on procedural situation)
            $files_array[$i]['datatreatment'] = $_POST['datatreatment'];
        }
         
        // are headers sql ready
        $nonesql_string = '';
        for( $i=1;$i<=$files_array['total_files'];$i++){
            foreach( $files_array[$i]['originalheaders'] as $key => $header){
                if( $header !== $files_array[$i]['sqlheaders'][$key] ){
                    $error = true;
                    $nonesql_string .= $header . ' ( '.$files_array[$i]['sqlheaders'][$key].' ), ';
                }
            }        
        } 
     
        // error at this stage indicates headers are not mysql ready so we need
        // to create a mysql ready version of them
        if( $error){
            $nonesql_string = rtrim( $nonesql_string, ", ");
            $this->UI->create_notice( 'CSV 2 POST creates a database table for your data. It names the columns using your .csv file headers and
            creates a MySQL ready version of them. Your file itself will not be changed but the plugin will work with the MySQL version of them.',
            'info', 'Small', __( 'Header Preparation' ) );
        } 
                       
        // ensure ID column is valid
        $cleanedidcolumn = '';
        if(!empty( $_POST['uniqueidcolumn'] ) ){
            $cleanedidcolumn = $this->CSV2POST->clean_sqlcolumnname( $_POST['uniqueidcolumn'] );
            if(!in_array( $cleanedidcolumn, $files_array[1]['sqlheaders'] ) ){
                $this->UI->create_notice( 'You entered '.$_POST['uniqueidcolumn'].' as your ID column 
                it does not appear to be one of your .csv files column names. No project has been 
                created. Please check the spelling of your column header designated as an ID column
                with unique values then try again.', 'error', 'Small', __( "ID Column Doesn't Exist") );
                return;
            }
        }
                    
        // perform multifile checks 
        // $_POST['datatreatment'] == 'join' we must ensure no duplicates exist other than a selected ID column
        // if $_POST['datatreatment'] == 'append' we must ensure all headers in all files are exactly the same
        if( $files_array['total_files'] > 1){
            
            // we require an id column
            if( $_POST['datatreatment'] == 'join' || $_POST['datatreatment'] == 'append' ){
                if(empty( $_POST['uniqueidcolumn'] ) ){
                    $this->UI->create_notice( __( 'Your data treatment requires an ID column to be entered. The column should exist in all of your files and hold
                    the exact same values. This is used to ensure the correct rows from each file are joined.' ), 'error', 'Small', __( 'ID Column Required' ) );
                    return;
                }    
            }
            
            // join + individual: ensure the id column field has a value and it exists in all files
            if( $_POST['datatreatment'] == 'join' || $_POST['datatreatment'] == 'individual' ){
                for( $i=1;$i<=$files_array['total_files'];$i++){
                    $id_column_found = false;
                    foreach( $files_array[$i]['sqlheaders'] as $key => $header){
                        if( $header == $_POST['uniqueidcolumn'] ){
                            $id_column_found = true;
                        }        
                    } 
                    
                    if(!$id_column_found){
                        $this->UI->create_notice( "File $i does not appear to have your ID column which you have submitted as ".$_POST['uniqueidcolumn'].". This is required to make
                        a connection from row to row over multiple files.", 'error', 'Small', 'No ID Column' );  
                        return;
                    }                               
                }     
            }
            
            // append: ensure all files have the exact same columns
            if( $_POST['datatreatment'] == 'append' ){
                for( $i=1;$i<=$files_array['total_files'];$i++){
                    if( $files_array[$i]['sqlheaders'] !== $files_array[1]['sqlheaders'] ){
                        $this->UI->create_notice( "File $i does not have the exact same headers as your first/main file. To use the append
                        data treatment all .csv files must have the same headers.", 'error', 'Small', "Headers Don't Match");
                        return;                    
                    }    
                }
            }            
        }         
         
        // set project name
        if(empty( $_POST['newprojectname'] ) ){
            $files_array['projectname'] = basename( $files_array[1]['fullpath'] );
        }else{
            $files_array['projectname'] = $_POST['newprojectname'];
        }
        
        // before we make changes to the database we need to ensure our predicted table name/s do not already exist
        if( $_POST['datatreatment'] == 'single' || $_POST['datatreatment'] == 'append' || $_POST['datatreatment'] == 'join' ){
            
            $table_exists_result = $this->DB->does_table_exist( $files_array[1]['tablename'] );
            
            if( $table_exists_result){
                // drop table if user entered the random number
                if( $_POST['deleteexistingtable'] ==  $_POST['deleteexistingtablecode'] ){   
                    $this->DB->drop_table( $files_array[1]['tablename'] );           
                }else{                
                    $this->UI->create_notice( 'A database table already exists named ' . $files_array[1]['tablename'] . '. Please delete
                    the existing table if it is not in use or change the name of your .csv file a little.', 'error', 'Small', 'Table Exists Already' );
                    return;  
                } 
            }
            
        }elseif( $_POST['datatreatment'] == 'individual' ){
            for( $i=1;$i<=$files_array['total_files'];$i++){
                $table_exists_result = $this->DB->does_table_exist( $files_array[$i]['tablename'] );
                if( $table_exists_result){
                    
                    // drop table if user entered the random number
                    if( $_POST['deleteexistingtable'] ==  $_POST['deleteexistingtablecode'] ){
                        $this->CSV2POST->drop_table( $files_array[$i]['tablename'] );           
                    }else{
                        $this->UI->create_notice( 'A database table already exists named ' . $files_array[$i]['tablename'] . '. Please delete
                        the existing table if it is not in use or change the name of .csv file '.$i.'.', 'error', 'Small', 'Table Exists Already' );
                    }
                    
                    return;
                }            
            }               
        }
    
        // store files as new sources in the c2psources table
        for( $i=1;$i<=$files_array['total_files'];$i++){
            if(!empty( $_POST['csvfile'.$i] ) ){
                if( $i == 1){
                    $parentfile_id = 0;
                }else{
                    $parentfile_id = $files_array[1]['sourceid'];
                }
                
                // if not requesting individual tables for multifile or is single then use the first files tablename
                if( $files_array['total_files'] > 1 && $_POST['datatreatment'] !== 'individual' || $_POST['datatreatment'] == 'single' ){
                    $newtablename = $files_array[1]['tablename'];
                }else{
                    // individual treatment requested
                    $newtablename = $files_array[$i]['tablename'];   
                }
                                 
                $files_array[$i]['sourceid'] = $this->CSV2POST->insert_data_source(stripslashes_deep( $_POST['csvfile'.$i] ), $parentfile_id, $newtablename, 'localcsv', $files_array[$i], $_POST['uniqueidcolumn'] );        
            }            
        }        
           
        // create database table/s
        if( $_POST['datatreatment'] == 'single' || $_POST['datatreatment'] == 'append' )
        {
            $sqlheaders_array = array();
            foreach( $files_array[1]['sqlheaders'] as $key => $header){
                $sqlheaders_array[$header] = 'nodetails';
            }
     
            $this->CSV2POST->create_project_table( $files_array[1]['tablename'], $sqlheaders_array ); 
            self::a_table_was_created( $files_array[1]['tablename'] );   
        }
        elseif( $_POST['datatreatment'] == 'join' )
        {
            // put all headers into a single array
            $allheaders_array = array();
            for( $i=1;$i<=$files_array['total_files'];$i++){
                foreach( $files_array[$i]['sqlheaders'] as $key => $header){
                    $allheaders_array[$header] = 'nodetails';      
                }                     
            }   
            
            $this->CSV2POST->create_project_table( $files_array[1]['tablename'], $allheaders_array ); 
            self::a_table_was_created( $files_array[1]['tablename'] );
        }       
        elseif( $_POST['datatreatment'] == 'individual' )
        {
            for( $i=1;$i<=$files_array['total_files'];$i++){
                
                $sqlheaders_array = array();
                foreach( $files_array[$i]['sqlheaders'] as $key => $header){
                    $sqlheaders_array[$header] = 'nodetails';      
                }   
                
                $this->CSV2POST->create_project_table( $files_array[$i]['tablename'], $sqlheaders_array );
                self::a_table_was_created( $files_array[$i]['tablename'] );                  
            }             
        }       
        
        // create array of the source ID's
        $sourceid_array = array();
        for( $i=1;$i<=$files_array['total_files'];$i++){
            $sourceid_array['source' . $i] = $files_array[$i]['sourceid'];
        }        
               
        // create a new project in the c2pprojects table
        $projectid = $this->CSV2POST->insert_project( $files_array['projectname'], $sourceid_array, $_POST['datatreatment'] ); 
      
        // ensure we have valid $projectid and set it as the current project
        if(!is_numeric( $projectid) ){
            $this->UI->create_notice( __( 'The plugin could not finish inserting your new project to the database. This should never happen,
            please report it.' ), 'success', 'Small', __( 'Problem Detected When Creating Project' ) );                    
            return false;
        } 
              
        // if applicable we apply defaults to the projects settings array, initialize it with coded settings or users own defaults
        $this->CSV2POST->apply_project_defaults( $projectid);

        // from here on we can begin using the $project_array
        $project_array = $this->CSV2POST->get_project( $projectid);      
        $project_array = maybe_unserialize( $project_array->projectsettings);
        
        // add the id column to the project settings array, we indicate id columns within the source row
        // however in some procedures we have the $project_array and do not need the source                   
        $project_array['idcolumn'] = $cleanedidcolumn;

        // execute update query
        $this->CSV2POST->update_project( $projectid, array( 'projectsettings' => maybe_serialize( $project_array ) ), false );
        
        // set the current project
        $c2p_settings['currentproject'] = $projectid;
        $this->CSV2POST->update_settings( $c2p_settings);
        
        // update source rows with project id
        $this->CSV2POST->update_sources_withprojects( $projectid, $sourceid_array );
            
        if(empty( $_POST['uniqueidcolumn'] ) ){
            $this->UI->create_notice( __( 'You did not enter an ID column. You will not be able to update your data using an updated .csv file. If you
            do not plan on updating your .csv file you can ignore this.' ), 'warning', 'Small', __( 'Data Updating Not Ready' ) );
        }
        
        $this->UI->create_notice( 'Your project has been created and the ID is ' . $projectid . '. The
        default project name is '.$files_array['projectname'].' which you can change using project settings.', 'success', 'Small', __( 'Project Created' ) );                    
    }  

    public function a_table_was_created( $table_name){
        $this->UI->create_notice( 'CSV 2 POST created a new database table named ' . $table_name .' for your data being imported to, before posts are made.', 'success', 'Small', 'Table Created Named ' . $table_name);
    }
              
    /**
    * form processing function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.0
    */            
    public function changecsvfilepath () {
        global $c2p_settings, $wpdb;
        if(!isset( $_POST['newpath'] ) || empty( $_POST['newpath'] ) ){
            $this->UI->create_notice( __( 'Please enter the path to the .csv file that is replacing your sources existing file.' ), 'error', 'Small', __( 'New File Path Required' ) );
            return;
        }    
        
        // check if file exists
        $file_one_exists = file_exists( ABSPATH . $_POST['newpath'] );
        if(!$file_one_exists){
            $this->UI->create_notice( __( "The new .csv file could not be located or its permissions do not all access. Your source has not been changed."), 'error', 'Small', __( 'File Not Found' ) );    
            return;
        }
        
        // ensure is .csv file
        if(pathinfo(ABSPATH . $_POST['newpath'], PATHINFO_EXTENSION) != 'csv' ){
            $this->UI->create_notice( __( "The submitted path does not point to a .csv file. This plugin only works with CSV files. Please see the WebTechGlobal plugin range for one that handles other file types and types of data storage."), 'error', 'Small', __( 'CSV File Required' ) );
            return;
        }                
        
        $this->CSV2POST->update_sources_withpath( $_POST['newpath'], $_POST['datasource'] );
        
        // get the source data
        $source_array = $this->CSV2POST->get_source( $c2p_settings['currentproject'], $_POST['datasource'] );
        
        // has the source row been deleted
        if( $source_array ){
            $this->UI->create_notice( __( 'No source row could be found in the sources table. This can happen if you have deleted the associated project.', 'csv2post' ), 'success', 'Small', __( 'Source Missing', 'csv2post' ) );
            return;            
        }                       
        
        $theconfig_array = maybe_unserialize( $source_array->theconfig );
        $theconfig_array['submittedpath'] = $_POST['newpath'];
        $theconfig_array['fullpath'] = ABSPATH . $_POST['newpath'];
        
        $this->CSV2POST->update( $wpdb->c2psources, 'sourceid = ' . $_POST['datasource'], array( 'theconfig' => maybe_serialize( $theconfig_array ) ) );            
    
        $this->UI->create_notice( __( 'The request has been complete and the source record has been updated. Any projects using the
        source will now also use the new .csv file.' ), 'success', 'Small', 'Source Path Updated' );    
    }
    
    /**
    * mass update posts for current project with new categories array
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function setpostscategories() {
        global $c2p_settings;
       
        // load categories class
        $this->CSV2POST->load_class( 'C2P_Categories', 'class-categories.php', 'classes',array( 'noreturn' ) );
        $C2P_Categories = new C2P_Categories();
        
        // establish if pre-set parent in use
        $preset_parent = false;
        if( isset(  $this->current_project_settings['categories']['presetcategoryid'] ) ){
            $preset_parent = $this->current_project_settings['categories']['presetcategoryid'];
        }

        // get rows used to create posts, this function will add post ID's as array key for use in mass_update_posts_categories() 
        $used_category_data = $this->CSV2POST->get_category_data_used( $c2p_settings['currentproject'], 5, true );   
               
        // run a posts category update, it includes creating categories to apply any 
        // changes and updating posts to reflect any category changes
        $C2P_Categories->mass_update_posts_categories( $used_category_data, $preset_parent );
    }

    /**
    * mass removal the relationships between posts and categories
    * this should be done before mass delete to split the operation into phases
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function resetpostscategories() {
        # mass category plugin does this, check how it does it and establish the best way using the wp core
    }
    
    /**
    * using an array of keys that exist twice or more, will delete the extra rows
    * and also delete posts if posts have been created using any of the extra rows
    * 
    * @returns false if no rows deleted else returns total rows deleted
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function deleteduplicaterowsandposts() {
        global $c2p_settings;

        // if no idcolumn set this operation can be executed
        if( !isset( $this->current_project_settings['idcolumn'] ) ){
            $this->UI->create_notice( __( 'No ID column was found. It means you are not applying any strict validation that
            requires a key column of unique/distinct values per row. This operation you have requested is for deleting
            duplicates based on that type of rule.', 'csv2post' ), 'warning', 'Small', __( 'No ID Column', 'csv2post' ) );     
            return false;  
        }                                                                                                           
        
        $table_name = $this->CSV2POST->get_project_main_table( $c2p_settings['currentproject'] );
        
        // get an array of the keys which have duplicates (not every duplicate just an array of keys that have 2 or more)
        $duplicate_keys = $this->DB->get_duplicate_keys( $table_name, $this->current_project_settings['idcolumn'] );
        
        $orderby = $this->current_project_settings['idcolumn'];
        
        $select = 'c2p_rowid, c2p_postid, ' . $this->current_project_settings['idcolumn'];

        // count number of rows sharing the same post_id so that we can avoid deleting that post
        $rows_sharing_posts = 0;
        
        // count deletions
        $rows_deleted = 0;
        
        // count post deletion
        $posts_deleted = 0;
            
        // loop through doubled up key rows
        foreach( $duplicate_keys as $array_key => $data_key ) {
            
            $condition = $this->current_project_settings['idcolumn'] . ' = ' . $data_key;
             
            // get all rows with the current $data_key
            $result = $this->DB->selectwherearray( $table_name, $condition, $orderby, $select, ARRAY_A );
             
            // store the first post id to avoid deleting it, rows may be sharing the same post
            $first_post_id = false;
            
            // count which row we are on, avoid deleting the first
            $row_count = 0;
            
            // loop through the rows  
            if( $result ){
                
                foreach( $result as $key => $row ){
                    
                    // if first post and it has a post id then set the $first_post_id to prevent its deletion
                    // if another row also has the same post id
                    if( $row_count === 0 && isset( $row['c2p_postid'] ) && is_numeric( $row['c2p_postid'] ) ) {
                        
                        $first_post_id = $row['c2p_postid'];
 
                    } 
                    
                    // delete all rows after the first
                    if( $row_count > 0 ) {
                        
                        $this->DB->delete( $table_name, 'c2p_rowid = ' . $row['c2p_rowid'] );
                        
                        ++$rows_deleted;  
                        
                        // delete post 
                        if( isset( $row['c2p_postid'] ) && $row['c2p_postid'] !== $first_post_id ) {
                            
                            wp_delete_post( $row['c2p_postid'] );
                            
                            ++$posts_deleted;
                            
                        }  
                    }                   
                    
                    ++$row_count;
                }
            }     
        }
        
        $this->UI->create_notice( "A total of $posts_deleted posts were deleted and $rows_deleted imported rows were delete.", 'success', 'Small', __( 'Duplicate Deletion Finished', 'csv2post' ) );
    }
      
    #################################################################
    #                                                               #
    #              BETA TESTING FUNCTIONS BEGIN HERE                #
    #                                                               #
    #################################################################
    
    /**
    * Processes a beta test form
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function t4() {
        
        // we want to pass an array which determines our category set. 
        // this is where the pre-set category would need to be set, I will run a test with pre-set and one without
        $new_categories = array( 'Delete Me 1', 'Delete Me 2', 'Delete Me 3', 'Delete Me 4' );
        
        // run this without mapping to create a simplified version of the method
        $C2P_Categories = new C2P_Categories();
        $result = $C2P_Categories->create_categories_set( $new_categories, false );

        echo '<h4>Result (without Pre-Set parent or mapping)</h4>';
        echo '<pre>';
        var_dump( $result );
        echo '</pre>'; 
        
               
        // run again with pre-set category setting in use for the current project
        // Delete Me 1 should be created as child of pre-set category
        $new_categories = array( 'Delete Me 1', 'Delete Me 2', 'Delete Me 3', 'Delete Me 4' );
        $preset_parent = 313;
        $result = $C2P_Categories->create_categories_set( $new_categories, $preset_parent );

        echo '<h4>Result (with Pre-Set parent but no mapping)</h4>';
        echo '<pre>';
        var_dump( $result );
        echo '</pre>'; 
                                  
   
    }
}       
?>
