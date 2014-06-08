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
* @since 8.0.0
* 
* @author Ryan Bayne 
*/

class C2P_requests {
    public function installtestdata(){
        global $C2P_Install,$CSV2POST;
            
        $C2P_Install->testdata();// main section and any prep required for other sections
       
        $C2P_WP->create_notice(__('Test Data installation procedure has finished.'),'success','Small',__('Test Data Installed'));
    }  
    public function user_can($capability = 'activate_plugins'){
        if(!current_user_can($capability)){
            global $C2P_WP;
            $C2P_WP->n_depreciated('You Are Restricted','You do not have permission to complete that submission. Your
            Wordpress account requires the "'.$capability.'" capability to perform the action you attempted.','warning','Small');
            return false;
        }   
        return true;
    }  
    public function request_success($form_title,$more_info = ''){  
        global $C2P_WP; 
        $C2P_WP->create_notice("Your submission for $form_title was successful. " . $more_info,'success','Small',"$form_title Updated");          
    } 
    public function request_failed($form_title,$reason = ''){
        global $C2P_WP;
        $C2P_WP->n_depreciated($form_title . ' Unchanged',"Your settings for $form_title were not changed. " . $reason,'error','Small');    
    }
    public function logsettings(){
        global $c2p_settings,$C2P_WP;
        $c2p_settings['globalsettings']['uselog'] = $_POST['csv2post_radiogroup_logstatus'];
        $c2p_settings['globalsettings']['loglimit'] = $_POST['csv2post_loglimit'];
        $C2P_WP->update_settings($c2p_settings);
        $C2P_WP->n_postresult_depreciated('success',__('Log Settings Saved','csv2post'),__('It may take sometime for new log entries to be created depending on your websites activity.','csv2post'));  
    }  
    /**
    * Create a data rule for replacing specific values after import 
    */
    /**
    * Data panel one settings
    */
    public function panelone(){
        global $c2p_settings,$C2P_WP;
        $c2p_settings['globalsettings']['encoding']['type'] = $_POST['csv2post_radiogroup_encoding'];
        $c2p_settings['globalsettings']['admintriggers']['newcsvfiles']['status'] = $_POST['csv2post_radiogroup_detectnewcsvfiles'];
        $c2p_settings['globalsettings']['admintriggers']['newcsvfiles']['display'] = $_POST['csv2post_radiogroup_detectnewcsvfiles_display'];
        $c2p_settings['globalsettings']['postfilter']['status'] = $_POST['csv2post_radiogroup_postfilter'];          
        $c2p_settings['globalsettings']['postfilter']['tokenrespin']['status'] = $_POST['csv2post_radiogroup_spinnertokenrespin'];        
        $C2P_WP->update_settings($c2p_settings);
        $C2P_WP->n_postresult_depreciated('success',__('Data Related Settings Saved','csv2post'),__('We recommend that you monitor the plugin for a short time and ensure your new settings are as expected.','csv2post'));
    }
    public function globaldatasettings (){
        global $c2p_settings,$C2P_WP;
        
        if(!is_numeric($_POST['importlimit'])){
            $C2P_WP->create_notice('You must enter a numeric value for the maximum number of records to be imported and inserted to the database per event.
            This applies to manual events only.','error','Small','Import Limit Number Required');
            return;
        }
        
        $value = $_POST['importlimit'];
        if($_POST['importlimit'] < 1){
            $value = 1;
        }
        
        $c2p_settings['datasettings']['insertlimit'] = $_POST['importlimit'];
        $C2P_WP->update_settings($c2p_settings);
    }     
    public function persistentnotice(){
        global $c2p_persistent_array,$CSV2POST;
        foreach($c2p_persistent_array['notifications'] as $key => $notice){
            if($notice['id'] == $_POST['csv2post_post_deletenotice_id']){
                unset($c2p_persistent_array['notifications'][$key]);
            }            
        }
        
        $CSV2POST->option('csv2post_notifications','update',$c2p_persistent_array);            
    }  
    public function screenpermissions(){
        global $c2p_mpt_arr,$CSV2POST,$C2P_WP;

        // loop through tabs, this is the same loop build as on the capabilities interface itself
        $menu_id = 0;
        foreach($c2p_mpt_arr as $page_name => $page_array){

            foreach($page_array['tabs'] as $key => $tab_array){
                
                if(isset($tab_array['display']) && $tab_array['display'] != false){
                                        
                    // is post value set for current tab
                    if(isset($_POST['csv2post_capabilitiesmenu_'.$page_name.'_'.$key.''])){
         
                        // update capability setting for screen
                        $c2p_mpt_arr[$page_name]['tabs'][$key]['permissions']['customcapability'] = $_POST['csv2post_capabilitiesmenu_'.$page_name.'_'.$key.''];
                    }

                    ++$menu_id; 
                }        
            }
        }        

        $CSV2POST->option('csv2post_tabmenu','update',$c2p_mpt_arr);

        $C2P_WP->notice_postresult_depreciated('success',__('Screen Permissions Saved','csv2post'),__('Your saved screen permissions may hide or display screens for users. We recommend that you access your blog using applicable user accounts to test your new permissions.','csv2post'));    
    } 
    public function pagepermissions(){
        global $c2p_mpt_arr,$CSV2POST,$C2P_WP;

        foreach($c2p_mpt_arr as $page_name => $page_array){
            
            if(isset($_POST['csv2post_capabilitiesmenu_'.$page_name.'_99'])){
                $c2p_mpt_arr[$page_name]['permissions']['customcapability'] = $_POST['csv2post_capabilitiesmenu_'.$page_name.'_99'];    
            }
        }        

        $CSV2POST->option('csv2post_tabmenu','update',$c2p_mpt_arr); 
        
        $C2P_WP->notice_postresult_depreciated('success',__('Page Permissions Saved','csv2post'),__('Your saved page permissions may hide or display the plugins pages for users. We recommend that you access your blog using applicable user accounts to test your new permissions.','csv2post'));     
    }  
    /**
    * Partial Un-install Plugin Options 
    */
    public function partialuninstall(){
        global $C2P_WP;
        
        if(current_user_can('delete_plugins')){
                     
            // if delete data import job tables
            if(isset($_POST['csv2post_deletejobtables_array'])){
                               
                foreach($_POST['csv2post_deletejobtables_array'] as $k => $table_name){
                    $code = str_replace('csv2post_','',$table_name);
                    csv2post_SQL_drop_dataimportjob_table($table_name);
                    $C2P_WP->notice_depreciated('Table ' . $table_name . ' was deleted.','success','Tiny','Table Deleted','','echo'); 
                }
            }
            
            // if delete core plugin tables
            if(isset($_POST['csv2post_deletecoretables_array'])){
                foreach($_POST['csv2post_deletecoretables_array'] as $key => $table_name){
                    C2P_WPDB::drop_table($table_name);
                }
            }
       
            // if delete csv files
            if(isset($_POST['csv2post_deletecsvfiles_array'])){
                foreach($_POST['csv2post_deletecsvfiles_array'] as $k => $csv_file_name){
                        
                    $file_is_in_use = false;
                    $file_is_in_use = csv2post_is_csvfile_in_use($csv_file_name);
                       
                    // if file is in use
                    if($file_is_in_use){        
                        $C2P_WP->notice_depreciated('The file named ' . $csv_file_name .' is in use, cannot delete.','error','Tiny','File In Use','','echo');
                    }else{                         
                        unlink($csv_file_name); 
                        $C2P_WP->notice_depreciated( $csv_file_name .' Deleted','success','Tiny','','','echo');
                    }
                                            
                }      
            }
                      
            // if delete folders
            if(isset($_POST['csv2post_deletefolders_array'])){    
                foreach($_POST['csv2post_deletefolders_array'] as $k => $o){       

                }      
            }            

            // if delete options
            if(isset($_POST['csv2post_deleteoptions_array'])){          
                foreach($_POST['csv2post_deleteoptions_array'] as $k => $o){      
                    delete_option($o);
                    $C2P_WP->notice_depreciated('Option record ' . $o . ' has been deleted.','success','Tiny','Option Record Deleted','','echo'); 
                }      
            }
            
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );
            exit;
                                                
        }else{           
            $C2P_WP->notice_depreciated(__('You do not have the required permissions to un-install CSV 2 POST. The Wordpress role required is delete_plugins, usually granted to Administrators.'), 'warning', 'Large','No Permission To Uninstall CSV 2 POST','','echo');
            return false;
        }
    }
    public function updatecsv2post(){
        global $C2P_WP;
        
        // we need requested update version, usually the version up from the installed version however we wont assume that
        if(!isset($_POST['csv2post_plugin_update_now']) || !is_numeric($_POST['csv2post_plugin_update_now']))
        {
            $C2P_WP->create_notice(__('The plugin update procedure was requested but a security parameter has not validated. No changes have been made and you will need to contact WebTechGlobal for support.','csv2post'),'error','Large',__('Update Cannot Continue','csv2post'));
            return false;
        }
        
        // check if an update method exists, else the plugin needs to do very little
        eval('$method_exists = method_exists ( $this , "patch_' . $_POST['csv2post_plugin_update_now'] .'" );');

        if($method_exists)
        {
            // perform update by calling the request version update procedure
            eval('$update_result_array = C2P_UpdatePlugin::patch_' . $_POST['csv2post_plugin_update_now'] .'("update");');       
        }
        else
        {
            // default result to true
            $update_result_array['failed'] = false;
        } 
      
        if($update_result_array['failed'] == true)
        {           
            $C2P_WP->create_notice(__('The update procedure failed, the reason should be displayed below. Please try again unless the notice below indicates not to. If a second attempt fails, please seek support.','csv2post'),'error','Small',__('Update Failed','csv2post'));
                    
            $C2P_WP->create_notice($update_result_array['failedreason'],'info','Small','Update Failed Reason');
        }
        else
        {  
            // storing the current file version will prevent user coming back to the update screen
            global $c2p_currentversion;        
            update_option('csv2post_installedversion',$c2p_currentversion);

            $C2P_WP->create_notice(__('Good news, the update procedure was complete. If you do not see any errors or any notices indicating a problem was detected it means the procedure worked. Please ensure any new changes suit your needs.','csv2post'),'success','Small',__('Update Complete','csv2post'));
            
            // do a redirect so that the plugins menu is reloaded
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );
            exit;                
        }
    }
    public function logsearchoptions(){
        global $c2p_settings,$C2P_WP;
        
        // first unset all criteria
        if(isset($c2p_settings['logsettings']['logscreen'])){
            unset($c2p_settings['logsettings']['logscreen']);
        }
        
        ##################################################
        #         COLUMN DISPlAY SETTINGS FIRST          #
        ##################################################
        // if a column is set in the array, it indicates that it is to be displayed, we unset those not to be set, we dont set them to false
        if(isset($_POST['csv2post_logfields'])){
            foreach($_POST['csv2post_logfields'] as $column){
                $c2p_settings['logsettings']['logscreen']['displayedcolumns'][$column] = true;                   
            }
        }
            
        ############################################################
        #          SAVE CUSTOM SEARCH CRITERIA CHECK BOXES         #
        ############################################################              
        // outcome criteria
        if(isset($_POST['csv2post_log_outcome'])){    
            foreach($_POST['csv2post_log_outcome'] as $outcomecriteria){
                $c2p_settings['logsettings']['logscreen']['outcomecriteria'][$outcomecriteria] = true;                   
            }            
        } 
        
        // type criteria
        if(isset($_POST['csv2post_log_type'])){
            foreach($_POST['csv2post_log_type'] as $typecriteria){
                $c2p_settings['logsettings']['logscreen']['typecriteria'][$typecriteria] = true;                   
            }            
        }         

        // category criteria
        if(isset($_POST['csv2post_log_category'])){
            foreach($_POST['csv2post_log_category'] as $categorycriteria){
                $c2p_settings['logsettings']['logscreen']['categorycriteria'][$categorycriteria] = true;                   
            }            
        }         

        // priority criteria
        if(isset($_POST['csv2post_log_priority'])){
            foreach($_POST['csv2post_log_priority'] as $prioritycriteria){
                $c2p_settings['logsettings']['logscreen']['prioritycriteria'][$prioritycriteria] = true;                   
            }            
        }         

        ############################################################
        #         SAVE CUSTOM SEARCH CRITERIA SINGLE VALUES        #
        ############################################################
        // page
        if(isset($_POST['csv2post_pluginpages_logsearch']) && $_POST['csv2post_pluginpages_logsearch'] != 'notselected'){
            $c2p_settings['logsettings']['logscreen']['page'] = $_POST['csv2post_pluginpages_logsearch'];
        }   
        // action
        if(isset($_POST['csv2pos_logactions_logsearch']) && $_POST['csv2pos_logactions_logsearch'] != 'notselected'){
            $c2p_settings['logsettings']['logscreen']['action'] = $_POST['csv2pos_logactions_logsearch'];
        }   
        // screen
        if(isset($_POST['csv2post_pluginscreens_logsearch']) && $_POST['csv2post_pluginscreens_logsearch'] != 'notselected'){
            $c2p_settings['logsettings']['logscreen']['screen'] = $_POST['csv2post_pluginscreens_logsearch'];
        }  
        // line
        if(isset($_POST['csv2post_logcriteria_phpline'])){
            $c2p_settings['logsettings']['logscreen']['line'] = $_POST['csv2post_logcriteria_phpline'];
        }  
        // file
        if(isset($_POST['csv2post_logcriteria_phpfile'])){
            $c2p_settings['logsettings']['logscreen']['file'] = $_POST['csv2post_logcriteria_phpfile'];
        }          
        // function
        if(isset($_POST['csv2post_logcriteria_phpfunction'])){
            $c2p_settings['logsettings']['logscreen']['function'] = $_POST['csv2post_logcriteria_phpfunction'];
        }
        // panel name
        if(isset($_POST['csv2post_logcriteria_panelname'])){
            $c2p_settings['logsettings']['logscreen']['panelname'] = $_POST['csv2post_logcriteria_panelname'];
        }
        // IP address
        if(isset($_POST['csv2post_logcriteria_ipaddress'])){
            $c2p_settings['logsettings']['logscreen']['ipaddress'] = $_POST['csv2post_logcriteria_ipaddress'];
        }
        // user id
        if(isset($_POST['csv2post_logcriteria_userid'])){
            $c2p_settings['logsettings']['logscreen']['userid'] = $_POST['csv2post_logcriteria_userid'];
        }

        $C2P_WP->update_settings($c2p_settings);
        
        $C2P_WP->n_postresult_depreciated('success',__('Log Search Settings Saved','csv2post'),__('Your selections have an instant effect. Please browse the Log screen for the results of your new search.','csv2post'));                   
    }
    public function newprojectandnewcsvfiles(){
        global $C2P_UI,$C2P_WP,$CSV2POST,$C2P_DB,$wpdb,$c2p_settings;
        $error = false;
        $files_array = array('total_files' => 0);
        
        if(empty($_POST['csvfile1']) || empty($_POST['csvfile2']) && !empty($_POST['csvfile3']) || empty($_POST['csvfile3']) && !empty($_POST['csvfile4']) || empty($_POST['csvfile4']) && !empty($_POST['csvfile5'])){
            $C2P_WP->create_notice('You have missed a required field. Fields marked with an asterix * are required.','error','Small','Field Required');
            return;
        }
                
        // how many files were submitted
        for($i=1;$i<=20;$i++){
            if(!empty($_POST['csvfile'.$i])){
                ++$files_array['total_files'];
            }
        }
        
        // ensure all files exist
        for($i=1;$i<=$files_array['total_files'];$i++){
            if(!empty($_POST['csvfile'.$i])){
                
                $files_array[$i]['submittedpath'] = $_POST['csvfile'.$i];
                $files_array[$i]['fullpath'] = ABSPATH . $_POST['csvfile'.$i];
                
                $file_one_exists = file_exists($files_array[$i]['fullpath']);
                if(!$file_one_exists)
                {
                    $error = true;
                    $path = $files_array[$i]['fullpath'];
                    $C2P_WP->create_notice("File $i could not be located, please ensure the path is correct and your file exists.
                    The path checked was $path",'error','Small','File Not Found');    
                }
            }        
        }
        
        if($error){return;}
        
        // ensure all files are .csv
        for($i=1;$i<=$files_array['total_files'];$i++){
            // ensure file is .csv
            if(pathinfo($files_array[$i]['fullpath'], PATHINFO_EXTENSION) != 'csv')
            {
                $error = true;
                $C2P_WP->create_notice("File $i is not a CSV file. Either change the extension to .csv or use software to re-format it.",'error','Small','Not .csv');
            }         
        }
        
        if($error){return;}
        
        // build each files configuration (separate, number of fields, original headers and sql ready headers for comparison)
        for($i=1;$i<=$files_array['total_files'];$i++){
            $files_array[$i]['sep'] = $CSV2POST->established_separator($files_array[$i]['fullpath']);
        
            // we are ready to read the file
            $file = new SplFileObject($files_array[$i]['fullpath']);
            while (!$file->eof()) {
                $header_array = $file->fgetcsv($files_array[$i]['sep'],'"');
                break;// we just need the first line to do a count()
            }

            // count number of fields
            $files_array[$i]['fields'] = count($header_array); 
      
            foreach($header_array as $key => $header){  
                $files_array[$i]['originalheaders'][$key] = $header;
                $files_array[$i]['sqlheaders'][$key] = $C2P_WP->clean_sqlcolumnname($header);        
            }
            
            // store basename for each file
            $files_array[$i]['basename'] = basename($files_array[$i]['fullpath']); 
            
            // clean the basename for mysql ready table name (data treatment individual is the only one requiring all files to have a tablename but we will create it to use for other purposes)
            $files_array[$i]['tablename'] = $wpdb->prefix . $C2P_WP->clean_sqlcolumnname($files_array[$i]['basename']); 
        }
        
        // are headers sql ready
        $nonesql_string = '';
        for($i=1;$i<=$files_array['total_files'];$i++){
            foreach($files_array[$i]['originalheaders'] as $key => $header){
                if($header !== $files_array[$i]['sqlheaders'][$key]){
                    $error = true;
                    $nonesql_string .= $header . ' ('.$files_array[$i]['sqlheaders'][$key].'),';
                }
            }        
        } 
     
        // error at this stage indicates headers are not mysql ready so we need
        // to create a mysql ready version of them
        if($error){
            $nonesql_string = rtrim($nonesql_string, ",");
            $C2P_WP->create_notice('CSV 2 POST needs to create a database table for your data. To do this your .csv file headers must be cleaned
            so that they are MySQL ready. Your file itself will not be changed but the plugin will work with the MySQL version of them. It recommended
            that your .csv file headers are actually updated to be MySQL ready but it is not required.',
            'warning','Small',__('Header Preparation'));
        } 

        // set project name
        if(empty($_POST['newprojectname'])){
            $files_array['projectname'] = basename($files_array[1]['fullpath']);
        }else{
            $files_array['projectname'] = $_POST['newprojectname'];
        }

        $table_exists_result = $C2P_DB->does_table_exist($files_array[1]['tablename']);
        if($table_exists_result){
            $C2P_WP->create_notice('A database table already exists named ' . $files_array[1]['tablename'] . '. Please delete
            the existing table if it is not in use or change the name of your .csv file a little.','error','Small','Table Exists Already');
            return;
        }

        // store files as new sources in the c2psources table
        for($i=1;$i<=$files_array['total_files'];$i++){
            if(!empty($_POST['csvfile'.$i])){
                if($i == 1){
                    $parentfile_id = 0;
                }else{
                    $parentfile_id = $files_array[1]['sourceid'];
                }

                $newtablename = $files_array[1]['tablename'];
         
                $files_array[$i]['sourceid'] = $CSV2POST->insert_data_source(stripslashes_deep($_POST['csvfile'.$i]),$parentfile_id,$newtablename,'localcsv',$files_array[$i]);        
            }            
        }        
        
        function a_table_was_created($table_name){
            global $C2P_WP;
            $C2P_WP->create_notice('CSV 2 POST created a new database table named ' . $table_name .' for your data being imported to, before posts are made.','success','Small','Table Created Named ' . $table_name);
        }
                     
        // create database table/s
        $sqlheaders_array = array();
        foreach($files_array[1]['sqlheaders'] as $key => $header){
            $sqlheaders_array[$header] = 'nodetails';
        }
 
        $CSV2POST->create_project_table($files_array[1]['tablename'],$sqlheaders_array); 
        a_table_was_created($files_array[1]['tablename']);   

        
        // create array of the source ID's
        $sourceid_array = array();
        for($i=1;$i<=$files_array['total_files'];$i++){
            $sourceid_array['source' . $i] = $files_array[$i]['sourceid'];
        }        
               
        // create a new project in the c2pprojects table
        $projectid = $CSV2POST->insert_project($files_array['projectname'],$sourceid_array); 
       
        $CSV2POST->apply_project_defaults($projectid);
         
        if(is_numeric($projectid)){
            $c2p_settings['currentproject'] = $projectid;
        } 
        
        $C2P_WP->update_settings($c2p_settings);
        
        // update source rows with project id
        $C2P_WP->update_sources_withprojects($projectid,$sourceid_array);
        
        if(empty($_POST['uniqueidcolumn'])){
            $C2P_WP->create_notice(__('You did not enter an ID column. You will not be able to update your data using an updated .csv file. If you
            do not plan on updating your .csv file you can ignore this.'),'warning','Small',__('Data Updating Not Ready'));
        }
        
        $C2P_WP->create_notice('Your project has been created and the ID is ' . $projectid . '. The
        default project name is '.$files_array['projectname'].' which you can change using project settings.','success','Small',__('Project Created'));                    
    }  
    
    public function deleteproject(){
        global $C2P_WP,$CSV2POST,$C2P_DB;
        
        if(empty($_POST['confirmcode'])){
            $C2P_WP->create_notice(__('Please re-enter the confirmation code.'),'error','Small',__('Confirmation Code Required'));
            return;
        }    
        
        if($_POST['randomcode'] !== $_POST['confirmcode']){
            $C2P_WP->create_notice(__('Confirmation codes do not match.'),'error','Small',__('No Match'));
            return;
        }
        
        if(empty($_POST['projectid'])){
            $C2P_WP->create_notice(__('Project ID required, please ensure you get the correct ID.'),'error','Small',__('Project ID Required'));
            return;
        }
        
        if(!is_numeric($_POST['projectid'])){
            $C2P_WP->create_notice(__('Project ID must be numeric.'),'error','Small',__('Invalid Project ID'));
            return;
        }
        
        $CSV2POST->deleteproject($_POST['projectid']);
        
        $C2P_WP->create_notice(__('Your project was deleted.'),'success','Small',__('Success'));
    }     
    public function importdata0(){
        global $C2P_WP,$c2p_settings;
        $C2P_WP->import_from_csv_file($_POST['sourceid'],$c2p_settings['currentproject']);
    }
    /**
    * quick action data import request
    */
    public function importdatecurrentproject(){
        global $C2P_WP,$c2p_settings;
        
        // import records from all sources for curret project
        $sourceid_array = $C2P_WP->get_project_sourcesid($c2p_settings['currentproject']);
        foreach($sourceid_array as $key => $source_id){
            $C2P_WP->import_from_csv_file($source_id,$c2p_settings['currentproject'],'import',2);
        }        
    }
    public function updatedatacurrentproject(){
        global $C2P_WP,$c2p_settings;
        
        // import records from all sources for curret project
        $sourceid_array = $C2P_WP->get_project_sourcesid($c2p_settings['currentproject']);
        foreach($sourceid_array as $key => $source_id){
            $C2P_WP->import_from_csv_file($source_id,$c2p_settings['currentproject'],'update');
        }  
    }
    public function categorydata(){
        global $C2P_WP,$c2p_settings;
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);
        $categories_array = maybe_unserialize($project_array->projectsettings);
        if(!is_array($categories_array)){$categories_array = array();}
        
        unset($categories_array['categories']['data']);
        
        $onceonly_array = array();
        
        // first menu is required
        if($_POST['categorylevel0'] == 'notselected'){
            $C2P_WP->create_notice(__('The first level is always required. Please make a selection in the first menu.'),'error','Small','Level 0 Required');
            return;
        }        

        // add first level to final array 
        $onceonly_array[] = $_POST['categorylevel0'];
        $cat1_exploded = explode('#',$_POST['categorylevel0']);
        $categories_array['categories']['data'][0]['table'] = $cat1_exploded[0];
        $categories_array['categories']['data'][0]['column'] = $cat1_exploded[1];
        
        for($i=1;$i<=4;$i++){   
            if($_POST["categorylevel$i"] !== 'notselected'){
                if(in_array($_POST["categorylevel$i"],$onceonly_array)){
                    $C2P_WP->create_notice(__('You appear to have selected the same table and column twice. Each level of categories normally requires
                    different terms/titles and so this validation exists to prevent accidental selection of the same column more than once.'),
                    'error','Small',"Column Selected Twice");
                    return;
                }
                
                $onceonly_array[] = $_POST["categorylevel$i"];
                $exploded = explode('#',$_POST["categorylevel$i"]);
                $categories_array['categories']['data'][$i]['table'] = $exploded[0];
                $categories_array['categories']['data'][$i]['column'] = $exploded[1];
                        
            }else{
                // break when we reach the first not selected, this ensures we do not allow user to skip a level
                break;
            }
        }
        
        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($categories_array) ));
        $C2P_WP->create_notice(__("Your category options have been saved."),'success','Small',__('Categories Saved'));
    }
    public function categorypairing(){
        global $wpdb,$C2P_UI,$C2P_WP,$C2P_DB,$c2p_settings;
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);
        $categories_array = maybe_unserialize($project_array->projectsettings);
        
        // remove all existing mapping
        if(isset($categories_array['categories']['mapping'])){unset($categories_array['categories']['mapping']);}
        
        // query and loop through distinct category terms
        foreach($categories_array['categories']['data'] as $key => $catarray){
                               
            $column = $catarray['column'];
            $table = $catarray['table'];

            $distinct_result = $wpdb->get_results("SELECT DISTINCT $column FROM $table",ARRAY_A);
            foreach($distinct_result as $key => $value){
                
                $distinctval_cleaned = $C2P_WP->clean_string($value[$column]);
                $nameandid = 'distinct'.$table.$column.$distinctval_cleaned;
                
                if(isset($_POST[$column .'#'. $table .'#'. $distinctval_cleaned])){
                    
                    if(isset($_POST['existing'. $distinctval_cleaned]) && $_POST['existing'. $distinctval_cleaned] != 'notselected'){

                        $ourterm = $_POST[$column .'#'. $table .'#'. $distinctval_cleaned];// I think this is the same as $value[$column]
                        $categories_array['categories']['mapping'][$table][$column][ $ourterm ] = $_POST['existing'. $distinctval_cleaned];

                    }
                }
            }
        }
                         
        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($categories_array) ));
        $C2P_WP->create_notice(__("Your category mapping has been saved."),'success','Small',__('Category Map Saved'));
    }
    public function newcustomfield(){
        global $C2P_WP,$c2p_settings;    
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
        $customfields_array = maybe_unserialize($project_array->projectsettings);
        
        // clean the cf name and if the cleaned string differs then the original is not suitable
        $cleaned_string = preg_replace("/[^a-zA-Z0-9s_]/", "",$_POST['customfieldname']);    
        if($cleaned_string !== $_POST['customfieldname']){ 
            $C2P_WP->create_notice(__('Your custom field name/key is invalid. It must not contain spaces or special characters. Underscore is acceptable.'),'error','Small','Invalid Name');
            return false;
        }
        
        // ensure a value was submitted
        if(empty($_POST['customfielddefaultcontent'])){
            $C2P_WP->create_notice(__('You did not enter a column token or any other content to the WYSIWYG editor.'),'error','Small','Custom Field Value Required');
            return false;
        }
        
        // if unique ensure the custom field name has not already been used
        if($_POST['customfieldunique'] == 'enabled' && isset($customfields_array['customfields']['cflist'][$_POST['customfieldname']])){ 
            $C2P_WP->create_notice(__('That custom field name already exists in your list. You opted for the custom field name to be unique for each post so you cannot use the name/key twice. If you require the custom field name to exist multiple times per post i.e. to create a list of items. Then please select No for the Unique option.'),'error','Small','Name Exists Already');
            return false;       
        }

        // set next array key value
        $next_key = 0;

        // determine next array key
        if(isset($customfields_array['customfields']['cflist'])){    
            $next_key = $C2P_WP->get_array_nextkey($customfields_array['customfields']['cflist']);
        }   
               
        $customfields_array['customfields']['cflist'][$next_key]['id'] = $next_key;
        $customfields_array['customfields']['cflist'][$next_key]['name'] = $_POST['customfieldname'];
        $customfields_array['customfields']['cflist'][$next_key]['unique'] = $_POST['customfieldunique'];
        $customfields_array['customfields']['cflist'][$next_key]['value'] = $_POST['customfielddefaultcontent'];
        
        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($customfields_array) ));
        $C2P_WP->create_notice(__("Your custom field has been added to the list."),'success','Small',__('New Custom Field Created'));
    }
    public function deletecustomfieldrule(){
        global $C2P_WP,$c2p_settings;    
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
        $customfields_array = maybe_unserialize($project_array->projectsettings);
        
        if(!isset($_GET['cfid'])){
            $C2P_WP->create_notice(__('No ID was, no custom fields deleted.'),'error','Small',__('ID Required'));
            return;    
        }
        
        if(!isset($customfields_array['cflist'][$_GET['cfid']])){
            $C2P_WP->create_notice(__('The ID submitted could not be found, it appears your custom field has already been deleted.'),'error','Small',__('ID Does Not Exist'));
            return;            
        }
        
        unset($customfields_array['cflist'][$_GET['cfid']]);
        
        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($customfields_array) ));
        $C2P_WP->create_notice(__("Your custom field has been added to the list."),'success','Small',__('New Custom Field Created'));        
    }
    public function basicpostoptions (){
        global $C2P_WP,$c2p_settings;    
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
        $project_array = maybe_unserialize($project_array->projectsettings); 
               
        $project_array['basicsettings']['poststatus'] = $_POST['poststatus'];
        $project_array['basicsettings']['pingstatus'] = $_POST['pingstatus'];
        $project_array['basicsettings']['commentstatus'] = $_POST['commentstatus'];
        $project_array['basicsettings']['defaultauthor'] = $_POST['defaultauthor'];
        $project_array['basicsettings']['defaultcategory'] = $_POST['defaultcategory'];
        $project_array['basicsettings']['defaultposttype'] = $_POST['defaultposttype'];
        $project_array['basicsettings']['defaultpostformat'] = $_POST['defaultpostformat'];
        
        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($project_array) ));
        $C2P_WP->create_notice(__("Your basic post options have been saved."),'success','Small',__('Basic Post Options Saved'));        
    }
    public function databasedoptions (){
        global $C2P_WP,$c2p_settings;    
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
        $project_array = maybe_unserialize($project_array->projectsettings); 

        $exploded = explode('#',$_POST['tags']);
        $project_array['tags']['table'] = $exploded[0];
        $project_array['tags']['column'] = $exploded[1];
        
        $exploded = explode('#',$_POST['featuredimage']);
        $project_array['featuredimage']['table'] = $exploded[0];
        $project_array['featuredimage']['column'] = $exploded[1];

        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($project_array) ));
        $C2P_WP->create_notice(__("Your data based post options have been saved."),'success','Small',__('Data Based Post Options Saved'));    
    }  
    public function defaulttagrules (){
        global $C2P_WP,$c2p_settings;    
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
        $project_array = maybe_unserialize($project_array->projectsettings); 

        $exploded = explode('#',$_POST['generatetags']);
        $project_array['tags']['generatetags']['table'] = $exploded[0];
        $project_array['tags']['generatetags']['column'] = $exploded[1];
                
        $project_array['tags']['generatetagsexample'] = $_POST['generatetagsexample'];
        $project_array['tags']['numerictags'] = $_POST['numerictags'];
        $project_array['tags']['tagstringlength'] = $_POST['tagstringlength'];
        $project_array['tags']['maximumtags'] = $_POST['maximumtags'];
        $project_array['tags']['excludedtags'] = $_POST['excludedtags'];

        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($project_array) ));
        $C2P_WP->create_notice(__("You may want to test these settings before mass creating posts and generating a lot of tags."),'success','Small',__('Tag Rules Saved'));    
    }
    public function defaultpublishdates (){
        global $C2P_WP,$c2p_settings;    
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
        $project_array = maybe_unserialize($project_array->projectsettings); 

        $project_array['dates']['publishdatemethod'] = $_POST['publishdatemethod'];
        
        $exploded = explode('#',$_POST['datescolumn']);
        $project_array['dates']['table'] = $exploded[0];
        $project_array['dates']['column'] = $exploded[1];
        
        $project_array['dates']['dateformat'] = $_POST['dateformat'];
        $project_array['dates']['incrementalstartdate'] = $_POST['incrementalstartdate'];
        $project_array['dates']['naturalvariationlow'] = $_POST['naturalvariationlow'];
        $project_array['dates']['naturalvariationhigh'] = $_POST['naturalvariationhigh'];
        $project_array['dates']['randomdateearliest'] = $_POST['randomdateearliest'];
        $project_array['dates']['randomdatelatest'] = $_POST['randomdatelatest'];

        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($project_array) ));
        $C2P_WP->create_notice(__("You m a lot of tags."),'success','Small',__('Post Dates Settings Saved'));    
    }    
    public function defaulttitletemplate (){
        global $C2P_WP,$c2p_settings;    
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
        $project_array = maybe_unserialize($project_array->projectsettings); 
        $project_array['titles']['defaulttitletemplate'] = $_POST['defaulttitletemplate'];
        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($project_array) ));
        $C2P_WP->create_notice(__("Your title template design has been saved to your project settings."),'success','Small',__('Default Title Template Stored'));    
    }   
    public function defaultcontenttemplate (){
        global $C2P_WP,$c2p_settings;    
        $project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
        $project_array = maybe_unserialize($project_array->projectsettings); 
        $project_array['content']['wysiwygdefaultcontent'] = $_POST['wysiwygdefaultcontent'];
        $C2P_WP->update_project($c2p_settings['currentproject'], array('projectsettings' => maybe_serialize($project_array) ));
        $C2P_WP->create_notice(__("Your content template design has been saved to your project settings."),'success','Small',__('Default Content Template Updated'));    
    }    
    public function applydefaultprojectsettings (){
        global $C2P_WP,$c2p_settings,$CSV2POST;
        $CSV2POST->apply_project_defaults($c2p_settings['currentproject']);
        $C2P_WP->create_notice(__("Your current active projects settings have been set using your configured defaults."),'success','Small',__('Project Settings Updated'));           
    }
    public function resetdefaultprojectsettings (){
        global $C2P_WP,$c2p_settings,$CSV2POST;
        
        // put users stored settings into another variable
        $active_settings = $c2p_settings;
        
        // include the settings array to get the original array of defaultproject settings
        require_once(WTG_CSV2POST_PATH . 'arrays/settings_array.php');
        $active_settings['projectdefaults'] = $c2p_settings['projectdefaults'];
        
        $CSV2POST->option('csv2post_settings','update',$active_settings);
        
        $C2P_WP->create_notice(__("Default project settings have been reset to those stored in the settings_array.php file."),'success','Small',__('Default Project Settings Reset'));           
    } 
    /**
    * a default array for projects settings
    * 
    * 1. right now table defaults to project main table as this will be the most common requirement, we'll upgrade this on request
    * 
    */
    public function defaultglobalpostsettings (){
        global $c2p_settings,$C2P_WP;
        
        $default_table = $C2P_WP->get_project_main_table($c2p_settings['currentproject']);
        
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
                
        // title template
        $c2p_settings['projectdefaults']['titles']['defaulttitletemplate'] = $_POST['defaulttitletemplate'];
        
        // main content
        $c2p_settings['projectdefaults']['content']['wysiwygdefaultcontent'] = $_POST['wysiwygdefaultcontent'];
        
        // custom fields
        if(!empty($_POST['cfkey1']) && !empty($_POST['cftemplate1'])){
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['id'] = 0;// used in WP_Table class to pass what is actually the key, use they key though where unique value is required
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['name'] = $_POST['cfkey1'];// the key
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['value'] = $_POST['cftemplate1'];// on UI it is a template 
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['unique'] = '';
            $c2p_settings['projectdefaults']['customfields']['cflist'][0]['updating'] = '';
        }
        
        if(!empty($_POST['cfkey2']) && !empty($_POST['cftemplate2'])){
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['id'] = 1;
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['name'] = $_POST['cfkey2'];
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['value'] = $_POST['cftemplate2'];
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['unique'] = '';
            $c2p_settings['projectdefaults']['customfields']['cflist'][1]['updating'] = '';
        }
        
        if(!empty($_POST['cfkey3']) && !empty($_POST['cftemplate3'])){
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['id'] = 2;
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['name'] = $_POST['cfkey3'];
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['value'] = $_POST['cftemplate3'];
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['unique'] = '';
            $c2p_settings['projectdefaults']['customfields']['cflist'][2]['updating'] = '';
        }
        
        // category columns
        if(!empty($_POST['categorylevel1'])){
            $c2p_settings['projectdefaults']['categories']['data'][0]['table'] = $default_table;
            $c2p_settings['projectdefaults']['categories']['data'][0]['column'] = $_POST['categorylevel1'];
        
            if(!empty($_POST['categorylevel2'])){
                $c2p_settings['projectdefaults']['categories']['data'][1]['table'] = $default_table;
                $c2p_settings['projectdefaults']['categories']['data'][1]['column'] = $_POST['categorylevel2'];
            
                if(!empty($_POST['categorylevel3'])){
                    $c2p_settings['projectdefaults']['categories']['data'][2]['table'] = $default_table;
                    $c2p_settings['projectdefaults']['categories']['data'][2]['column'] = $_POST['categorylevel3'];                              
                }          
            }        
        }

        // tags
        $c2p_settings['projectdefaults']['tags']['column'] = $_POST['tags'];// ready made tags
        $c2p_settings['projectdefaults']['tags']['textdata']['table'] = $default_table;// generate tags from text
        $c2p_settings['projectdefaults']['tags']['textdata']['column'] = $_POST['textdata'];// generate tags from text
        $c2p_settings['projectdefaults']['tags']['defaultnumerics'] = $_POST['defaultnumerics'];
        $c2p_settings['projectdefaults']['tags']['tagstringlength'] = $_POST['tagstringlength'];
        $c2p_settings['projectdefaults']['tags']['maximumtags'] = $_POST['maximumtags'];
        $c2p_settings['projectdefaults']['tags']['excludedtags'] = $_POST['excludedtags'];

        // publish dates
        $c2p_settings['projectdefaults']['dates']['publishdatemethod'] = $_POST['publishdatemethod'];
        $c2p_settings['projectdefaults']['dates']['column'] = $_POST['dates'];
        $c2p_settings['projectdefaults']['dates']['dateformat'] = $_POST['dateformat'];
        $c2p_settings['projectdefaults']['dates']['incrementalstartdate'] = $_POST['incrementalstartdate'];
        $c2p_settings['projectdefaults']['dates']['naturalvariationlow'] = $_POST['naturalvariationlow'];
        $c2p_settings['projectdefaults']['dates']['naturalvariationhigh'] = $_POST['naturalvariationhigh'];
        $c2p_settings['projectdefaults']['dates']['randomdateearliest'] = $_POST['randomdateearliest'];
        $c2p_settings['projectdefaults']['dates']['randomdatelatest'] = $_POST['randomdatelatest'];

        $C2P_WP->update_settings($c2p_settings);
        $C2P_WP->create_notice('Your default project settings have been stored. Many of the setting will only work with multiple different
        projects if each projects datasource has the same format/configuration. Please configure projects individually where required and do not
        rely on these defaults if working with various different sources.','success','Small','Default Project Options Stored Successfully');
    }
    /**
    * creates posts manually from tools with manual insert of parameters
    */
    public function createpostsbasic(){
        global $c2p_settings,$C2P_WP;
        
        // set total posts to be created
        $total = 1;
        if(isset($_POST['totalposts']) && is_numeric($_POST['totalposts'])){$total = $_POST['totalposts'];}
          
        $C2P_WP->create_posts($c2p_settings['currentproject'],$total);    
    }
    /**
    * creates posts manually from quick actions and uses pre-set parameters
    */    
    public function createpostscurrentproject(){
        global $c2p_settings,$C2P_WP;
        $C2P_WP->create_posts($c2p_settings['currentproject'],1);    
    } 
    /**
    * updates posts manually from quick actions and uses pre-set parameters
    */    
    public function updatepostscurrentproject(){
        global $c2p_settings,$C2P_WP;
        $C2P_WP->update_posts($c2p_settings['currentproject'],1);    
    }
    public function reinstalldatabasetables(){
        global $C2P_WP;
        $installation = new C2P_Install();
        $installation->reinstalldatabasetables();
        $C2P_WP->create_notice('All tables were re-installed. Please double check the database status list to
        ensure this is correct before using the plugin.','success','Small','Tables Re-Installed');
    }                        
}       
?>
