<?php
/**
* Determines if domain owner is subscribing (currently effects premium support services, bonus downloads, extra credits etc)
* Subscription is not required for activation of full edition, that requires membership (which does not need annual payments)
* 
* @return boolean
*/
function wtgcsv_is_subscribed(){
    global $wtgcsv_is_domainregistered;
                     
    // is domain registered and has user giving permission for email authorisation
    if($wtgcsv_is_domainregistered === true){
   
        $function_boolean_result = false;
        
        // begin result array defaults
        $soapcall_result_array = array();
        $soapcall_result_array['result'] = true;
        $soapcall_result_array['rejected'] = false;
        $soapcall_result_array['rejectedreason'] = 'Not Rejected';        
        
        // use domain to make a call to web services
        $soapcall_result_array = wtgcsv_api_checksubscriptionstatus_for_domain();
        $soapcall_result_array['result'] = true;
        $soapcall_result_array['rejected'] = false;
        $soapcall_result_array['rejectedreason'] = 'Not Rejected';
         
         return $soapcall_result_array['result'];         
    }
    
    return false;// default if domain not registered or user never gave permissions for email authorisation
}


/**
* Uses SOAP CALL to determine if the last code code is valid and not expired
* 
* @param mixed $wtgcsv_callcode
* @global $wtgcsv_callcode, set in main file
*/
function wtgcsv_is_callcodevalid(){
    global $wtgcsv_callcode;
               
    $soapcall_result_array = array();
    $soapcall_result_array = wtgcsv_validate_call_code($wtgcsv_callcode);
                   
    if( $soapcall_result_array['resultcode'] == 2 ){
        return false;
    }elseif( $soapcall_result_array['resultcode'] == 3 ){        
        return true;
    }else{
        return false;
    }    
}

/**
* First function to calling web services and confirming domain registered for use with plugin
*/
function wtgcsv_is_domainregistered(){
    
    $soapcall_result_array = array();
    $soapcall_result_array = wtgcsv_confirm_current_domain_is_registered();
    
    if( $soapcall_result_array['resultcode'] == 2 ){
        return false;
    }elseif( $soapcall_result_array['resultcode'] == 3 ){

        // store call code - common use after this function is for generating activation code
        wtgcsv_update_callcode($soapcall_result_array['callcode']);
        
        return true;
    }else{
        return false;
    }
}

/**
* Stores call code in Wordpress options table
*/
function wtgcsv_update_callcode($callcode){
    return update_option(WTG_CSV_ABB . 'callcode',$callcode);
}

/**
* Gets the call code record if it exists 
*/
function wtgcsv_get_callcode(){
    return get_option(WTG_CSV_ABB . 'callcode');                       
}

/**
* Called from main file using add_action. Must always be within an admin check for security.
* 
* @todo HIGHPRIORITY, Ajax wont do anything with this but add the code for avoiding it when ajax call 
*/
function wtgcsv_export_singlesqltable_as_csvfile(){
    if(isset($_POST['wtgcsv_post_processing_required'])){
        if(isset( $_POST['wtgcsv_hidden_pageid'] ) && $_POST['wtgcsv_hidden_pageid'] == 'data' && isset($_POST['wtgcsv_hidden_panel_name']) && $_POST['wtgcsv_hidden_panel_name'] == 'exportsingletabledata'){
                 
            global $wtgcsv_is_free;

            if($wtgcsv_is_free || !strstr( $_POST['wtgpt_exporttable'] , 'wtgcsv_' )){
                wtgcsv_notice('This action is not permitted for security. We do not want to provide a free tool that allows any tables in
                the database to be exported. Only the paid edition, created with developers in mind, offers this feature.','warning','Large','Export Not Permitted','','echo');
            }else{
                
                ### TODO:CRITICAL, check of a table has any records, else exit
                global $wpdb;
                
                // get string of column names for using in SELECT query and CSV file header
                $column_string = wtgcsv_sql_build_columnstring($_POST['wtgpt_exporttable']);
                                                  
                $query_results = $wpdb->get_results( 'SELECT ' . $column_string . ' FROM ' . $_POST['wtgpt_exporttable'],ARRAY_A );
                
                if(!$query_results){
                    wtgcsv_notice('No records could be obtained for export from table named '.$_POST['wtgpt_exporttable'].'. Please ensure you have selected the correct database table for export.','warning','Large','No Records To Export','','echo');                    
                    return;
                }
                
                header( 'Content-Type: text/csv' );
                header( 'Content-Disposition: attachment;filename=export.csv' );
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

                // output CSV files header row
                echo $column_string;
                
                // now output records
                foreach( $query_results as $record_array ){
      
                    echo implode(',',$record_array);    
                }
            }
        }
    }    
} 

function wtgcsv_array_to_string(){
    
}

/**
* Implode array into a string
*            
* @param mixed $value
* @param mixed $delimeter
*/
function wtgcsv_build_string($array,$delimeter = ','){

    $comma_separated = implode($delimeter, $array);
        
}
                    
/**
* Called after wtgcsv_is_activated which determines if plugin currently has full edition activation state
* Called before wtgcsv_is_domainregistered simply to avoid constantly checking domain after activation even if broken
* 
* If activation code value found but our activation check failed ($wtgcsv_is_activated) then we have a broken activation 
* 
* @requires $wtgcsv_is_activated to be populated first 
*/
function wtgcsv_is_activationbroken(){
    global $wtgcsv_activationcode;
    if($wtgcsv_activationcode){
        global $wtgcsv_is_activated;// populated by soap call to confirm activation code still valid
        if($wtgcsv_is_activated){
            return false;// activation is not broken code is still valid 
        }else{
            return true;// we have a code but it is not a match, $wtgcsv_activationbroken will be used to let user know
        }
    }else{
        // no activation code record, we can assume no full edition activation done
        return false;          
    }
}   

/**
 * Formats number to a size for interface display, usually bytes returned from checking a file size
 * @param integer $size
 */
function wtgcsv_format_file_size($size) {
      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      if ($size == 0) { 
          return('n/a'); 
      } else {
          return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); 
      }
}            

/**
 * Returns cleaned string for use as filename - we remove all characters for the sake of shortenening
 * @param string $filename
 */
function wtgcsv_cleanfilename( $filename ){
    $remove_these = array('-','_',' ',')','(',);
    $filename = str_replace ( $remove_these , '' ,  $filename );
    return $filename;
}

/**
* Removes special characters and converts to lowercase
*/
function wtgcsv_clean_string($string){ 
    $string = preg_replace("/[^a-zA-Z0-9s]/", "", $string);
    $string = strtolower ( $string );
    return $string;
}

/**
 * Checks if an extension is loaded on the server
 * @uses get_loaded_extensions()
 * @param string $giving_extension (name of the extension)
 * @return boolean (if extension is loaded returns true)
 */
function wtgcsv_is_extensionloaded($giving_extension){
    $loaded_extensions = get_loaded_extensions();
    foreach($loaded_extensions as $key => $extension){
        if($extension == $giving_extension){
            return true;
        }
    }
    return false;
}

/**
* Create giving log file
* 
* @returns boolean, true if file is created or already exists, false otherwise
* 
* @param string $logtype, general,admin,user,sql,error
* @global $wtgcsv_logfile_header (array of log file column titles)
* 
*/
function wtgcsv_create_logfile($logtype){       
    if (wtgcsv_logfile_exists($logtype)) {
        return true;
    }else{
        global $wtgcsv_logfile_header;

        // ensure directory exists
        if(!is_dir(WTG_CSV_CONTENTFOLDER_DIR)){
            if (!mkdir(WTG_CSV_CONTENTFOLDER_DIR, 0700, true)) {
                ### @todo log this matter in options (functions to be written)
                return false;
            }
        }

        $logfilepath = wtgcsv_logfilepath($logtype);
        
        $fp = fopen(wtgcsv_logfilepath($logtype),'w');// if auto deleted, this will create it again
           
        if( !$fp ){    
            ### @todo store outcome in database (maybe create a set of options for priority issues)          
        }else{   
            $result = fputcsv($fp, $wtgcsv_logfile_header );//Returns the length of the written string or FALSE on failure.
            fclose($fp);

            return $result;
        }    
    } 
}

/**
* Delete giving log file
* @return boolean
* @param string $logtype (error,user,admin,general,sql)
*/
function wtgcsv_delete_logfile($logtype){
    return unlink(wtgcsv_logfilepath($logtype));    
} 

/**
* Disables log entries for giving log file
* 
* @global $wtgcsv_adm_set
* @param mixed $logtype
* @return returns the response from update_option function
*/
function wtgcsv_disable_logfile($logtype){
    global $wtgcsv_adm_set;
    $wtgcsv_adm_set = get_option( WTG_CSV_ABB.'adminset' );
    if($wtgcsv_adm_set){
        $wtgcsv_adm_set['log_'.$logtype.'_active'] = false;
        return update_option(WTG_CSV_ABB.'adminset',$wtgcsv_adm_set);
    }
}

/**
* Activate giving log file
* 
* @global $wtgcsv_adm_set
* @param string $logtype (sql,error,user,admin,general)
* @return bool
*/
function wtgcsv_activate_logfile($logtype){
    global $wtgcsv_adm_set;
    $wtgcsv_adm_set = get_option( WTG_CSV_ABB.'adminset' );
    if($wtgcsv_adm_set){
        $wtgcsv_adm_set['log_'.$logtype.'_active'] = true;
        return update_option( WTG_CSV_ABB.'adminset',$wtgcsv_adm_set);
    }
}

/**
 * Install main content folder in wp-content directory for holding uploaded items
 * Called from install function in install.php if constant is not equal to false WTG_CSV_CONTENTFOLDER_DIR
 *
 * @return boolean true if folder installed or already exists false if failed
 */
function wtgcsv_install_contentfolder($pathdir,$output = false){
    $contentfolder_outcome = true;

    // does folder already exist
    if(!is_dir($pathdir)){
        $contentfolder_outcome = wtgcsv_createfolder($pathdir);
    }else{
        return true;
    }

    if(!$contentfolder_outcome){
        $contentfolder_outcome = false;
        if($output){
            wtgcsv_notice('Plugins content folder could be not created:'.$pathdir, 'error', 'Tiny');
        }
    }elseif($contentfolder_outcome){
         if($output){
            wtgcsv_notice('Plugin content folder has been created here: '.$pathdir, 'success', 'Tiny');
         }
    }

    return $contentfolder_outcome;
}

/**
* Deletes the plugins main content folder
* 
* @param mixed $pathdir (the path to be deleted)
* @param mixed $output (boolean true means that the file was found and deleted)
*/
function wtgcsv_delete_contentfolder($pathdir,$output = false){
    if(!is_dir($pathdir)){
        wtgcsv_notice(WTG_CSV_PLUGINTITLE . ' could not locate the main content folder, it appears it
        may have already been deleted or moved.', 'warning', 'Extra');
        return false;
    }else{
        rmdir($pathdir);
        return true;
    }
}

/**
* Updates locally stored tab menu array by hiding or displaying the giving tab number within the giving page
* 
* @param boolean $newstate, pass false to hide tab or true to display it
* @param mixed $pageid
* @param mixed $tab_number
* 
* @return bool, the result from update_option()
*/
function wtgcsv_hideshow_tab($newstate,$pageid,$tab_number){
    
    global $wtgcsv_mpt_arr; 
    
    $wtgcsv_mpt_arr[ $pageid ]['tabs'][ $tab_number ]['display'] = $newstate;      
    
    return wtgcsv_update_tabmenu($wtgcsv_mpt_arr);           
}  

/**
* Updates locally stored copy of tab menu array
* 
* @uses serialize 
* @param mixed $wtgcsv_mpt_arr
* @return bool
*/
function wtgcsv_update_tabmenu(){
    global $wtgcsv_mpt_arr;
    return update_option(WTG_CSV_ABB . 'tabmenu',serialize($wtgcsv_mpt_arr)); 
}

/**
* Checks all critical template system files and returns
* @return boolean, true if all files found or false if any are missing 
*/
function wtgcsv_templatefiles_missing($output = false){
    global $wtgcsv_templatesystem_files;

    if(!isset($wtgcsv_templatesystem_files) || !is_array($wtgcsv_templatesystem_files)){
        return false;
    }
        
    foreach( $wtgcsv_templatesystem_files as $key => $fileitem ){
        
        $path = '';          
        $path .= WTG_CSV_DIR . 'templatesystem' . $fileitem['path'] . $fileitem['name'];
         
        if($fileitem['extension'] != 'folder'){        
            $path .= '.' . $fileitem['extension']; 
        }

        if(!file_exists($path)){ 
        
            if($output){
                wtgcsv_notice('A files important for the plugin to operate appear to be missing. The expect
                file should be on the follow path...<br /><br />' . $path,'error','Small',' Core File Missing: ','','echo');             
            }
               
            return true;// yes file is missing
        } 
    }
        
    return false; 
}

/**
* Validates the string entered as a name and ensures it does not already exist to
* help avoid the user confusing two different data import jobs 
* 
* @return boolean true if valid else false
* 
* @todo HIGHPRIORITY, complete function
*/
function wtgcsv_validate_dataimportjob_name(){
    $result = true;
    # ensure name is unique among existing job names
    # ensure name does not include special char
    return $result;
}

/**
* Creates random code or can be used to make passwords
* 
*/
function wtgcsv_create_code($length = 10,$specialchars = false) { 

    if($specialchars){
        $chars = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789£%^&*";        
    }else{
        $chars = "abcdefghjkmnopqrstuvwxyz023456789";
    }
     
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    $length = $length - 1;
    
    while ($i <= $length) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 
} 

/**
* Returns the current project code
*/
function wtgcsv_get_current_project_code(){
    return get_option('wtgcsv_currentprojectcode');
}

/**
* Deletes the wtgcsv_currentprojectcode option record, used when deleting a project when it is also the current project.
* I took this approach to help users cleanup the database when removing the plugin. 
*/
function wtgcsv_delete_option_currentprojectcode(){
    return delete_option('wtgcsv_currentprojectcode');    
}

function wtgcsv_delete_option_currentjobcode(){
    return delete_option('wtgcsv_currentjobcode');    
}

/**
* Updates/Creates option record for holding the current job code
* 
* @param mixed $job_code
*/
function wtgcsv_update_option_currentjob_code($job_code){
    global $wtgcsv_currentjob_code;
    $wtgcsv_currentjob_code = $job_code;
    return update_option('wtgcsv_currentjobcode',$job_code);     
}

function wtgcsv_get_option_currentjobcode(){
    return get_option('wtgcsv_currentjobcode');    
}

/**
* Counts the number of available templates
* 
* @param string $template_type postcontent,customfieldvalue,categorydescription,postexcerpt,keywordstring,dynamicwidgetcontent
* @todo HIGHPRIORITY, filter out none category description templates
*/
function wtgcsv_count_contenttemplates($template_type){
    // post query argument for get_posts function
    $args = array(
        'post_type' => 'wtgcsvcontent'
    );

    global $post;
    $myposts = get_posts( $args );
    return count($myposts);      
}

/**
* Update the current project wordpress option record
* If user deletes project which is set as current project, the value is set too false 
*/
function wtgcsv_update_currentproject($project_code){
    global $wtgcsv_currentproject_code;
    $wtgcsv_currentproject_code = $project_code;
    return update_option('wtgcsv_currentprojectcode',$project_code);    
}
                
/**
* Deletes post creation project.
* Updates project list array and deletes project option record.
* 
* @param mixed $project_code
* @return boolean, false if a failure is detected in trying to remove any part of the project else true is returned
*/
function wtgcsv_delete_postcreationproject($project_code,$current_project_code = false){
    global $wtgcsv_projectslist_array;
    
    // check if wtgcsv_currentprojectcode matches the project being deleted and set it to false if so
    if(isset($current_project_code) && $project_code == $current_project_code){
       wtgcsv_update_currentproject(false);
    }
    
    // now remove the project from the project list array    
    unset($wtgcsv_projectslist_array[$project_code]);
    $updatelist_result = wtgcsv_update_option_postcreationproject_list($wtgcsv_projectslist_array);
    
    // finally we delete the projects own record in wordpress options tables
    $delete_result = delete_option('wtgcsv_' . $project_code);
    
    if($updatelist_result === false || $delete_result === false){
        return false;
    }
    
    return true;
}

/**
* Updates "projectlist" option, requires the array itself to be passed
*/
function wtgcsv_update_option_postcreationproject_list($wtgcsv_projectslist_array){
    return update_option('wtgcsv_projectslist',serialize($wtgcsv_projectslist_array));    
}

/**
* Delete data import job using giving job code. Does not delete files or table.
* Deletes option record holding history and csv file configuration.
* Deletes entry in import job array
* 
* Handles output, will display messages regarding outcomes
* 
* @param mixed $jobcode
* @param boolean $output, true will cause visual output false will only return boolean
*/
function wtgcsv_delete_dataimportjob_postrequest($jobcode,$output = true){
    global $wtgcsv_dataimportjobs_array;

    $function_outcome = true;
                    
    // first delete the jobs own record in options table
    $deleteoption_result = wtgcsv_delete_dataimportjob_optionrecord($jobcode);
    if($deleteoption_result != false){
        if($output){
            wtgcsv_notice('Data import job named '.$wtgcsv_dataimportjobs_array[$jobcode]['name'].' has been deleted.','success','Extra'); 
        }    
    }else{
        if($output){
            wtgcsv_notice('Data import job named '.$wtgcsv_dataimportjobs_array[$jobcode]['name'].' could not be deleted. The Wordpress option record for this job may still be in the options table and require manual removal. Please report this issue. If however you already removed the option record manually being this action then that may cause this error and it can be ignored.','error','Extra'); 
        }
        $function_outcome = false;
    }
    
    // loop through global jobs array, unset each job code match
    foreach( $wtgcsv_dataimportjobs_array as $one => $two){
        if($one == $jobcode){
            unset($wtgcsv_dataimportjobs_array[$jobcode]);
        }
    }
    
    $updatejobsarray_result = update_option('wtgcsv_dataimportjobs',$wtgcsv_dataimportjobs_array);

    return $function_outcome;   
}

/**
* Initializes the array for a job i.e data import job. Adds some defaults.
* The full array is added too in the wtgcsv_form_createdataimportjob() function.
* All files and their headers are added.
* 
* @param string $jobname
* @param string $code
*/
function wtgcsv_create_jobarray($jobname,$code){

    $jobarray['name'] = $jobname;
    $jobarray['code'] = $code;
    $jobarray['totalrows'] = 0;// total rows from all files
    // last event statistic values
    $jobarray['stats']['lastevent']['loop_count'] = 0;
    $jobarray['stats']['lastevent']['processed'] = 0;
    $jobarray['stats']['lastevent']['inserted'] = 0;    
    $jobarray['stats']['lastevent']['updated'] = 0;    
    $jobarray['stats']['lastevent']['deleted'] = 0;        
    $jobarray['stats']['lastevent']['void'] = 0;        
    $jobarray['stats']['lastevent']['dropped'] = 0;
    $jobarray['stats']['lastevent']['duplicates'] = 0;
    // total of all event statistic values
    $jobarray['stats']['allevents']['progress'] = 0;
    $jobarray['stats']['allevents']['inserted'] = 0;    
    $jobarray['stats']['allevents']['updated'] = 0;
    $jobarray['stats']['allevents']['deleted'] = 0;
    $jobarray['stats']['allevents']['void'] = 0;    
    $jobarray['stats']['allevents']['dropped'] = 0;    
    $jobarray['stats']['allevents']['duplicates'] = 0;
    return $jobarray;    
}

/**
* Adds a job table too the job tables array record in wordpress options table
* @uses wtgcsv_update_option_jobtables_array() which uses update_option()
*/
function wtgcsv_add_jobtable($new_jobtable){
    global $wtgcsv_jobtable_array;// set in main file
    $wtgcsv_jobtable_array[] = $new_jobtable;
    wtgcsv_update_option_jobtables_array($wtgcsv_jobtable_array);
}

/**
* Returns percentage of data import job completion.
* 
* @param mixed $jobcode
*/
function wtgcsv_calculate_dataimportjob_progress_percentage($jobcode){
    $projecttotal_progress = 0;
    $projecttotal_rows = 0;
    // first get data import job array
    $jobarray = wtgcsv_get_dataimportjob($jobcode);
    // loop through files - then use each filename to get that files $progress counter 
    foreach($jobarray['files'] as $csvfile_id => $csvfile_name){
        $projecttotal_progress = $projecttotal_progress + $jobarray['stats'][$csvfile_name]['progress'];    
    }

    $percentage = $projecttotal_progress/$jobarray['totalrows'] * 100;  

    return $percentage;   
}

/**
* Checks if a $_POST submission has requested specific template for editing.
* If no request, will return empty array and values to indicate too other functions that they should return null values. 
*/
function wtgcsv_get_template_bypostrequest(){

    $templatedesign_array = array();
    $templatedesign_array['template_id'] = 0; 
    $templatedesign_array['template_name'] = 'Please Enter Template Design Name';
    $templatedesign_array['template_content'] = 'Create a template here, remember you can use the HTML screen also';
    
    // check if form submitted for opening existing template designs           
    if(isset($_POST["wtgcsv_opencontentdesign"]) && isset($_POST["wtgcsv_templatename_and_id"])){

        // extract post_id from the wtgcsv_templatename_and_id value which is the buttons visual text
        $templatedesign_array['template_id'] = wtgcsv_extract_value_from_string_between_two_values('(',')',$_POST["wtgcsv_templatename_and_id"]);    

        // get post (post type: wtgcsvtemplate)
        $template_post_object = get_post($templatedesign_array['template_id']);
         
        $templatedesign_array['template_name'] = $template_post_object->post_title;
        $templatedesign_array['template_content'] = $template_post_object->post_content; 
    }

    return $templatedesign_array;   
}

/**
* Get part of a string, specifically the string between two giving characters
* 
* @param string $start_limiter, start character
* @param string $end_limiter, end character
* @param string $haystack, string to be searched
* @return string or false on failure
* 
*/
function wtgcsv_extract_value_from_string_between_two_values($start_limiter,$end_limiter,$haystack){
    $start_pos = strpos($haystack,$start_limiter);
    if ($start_pos === false){
        return false;
    }

    $end_pos = strpos($haystack,$end_limiter,$start_pos);

    if ($end_pos === false){
        return false;
    }

    return substr($haystack, $start_pos+1, ($end_pos-1)-$start_pos);
}

/**
* Updates default content template value in giving project.
* 
* @param mixed $wtgcsv_currentproject_code
* @param mixed $template_id
*/
function wtgcsv_update_default_contenttemplate($project_code,$template_id){
    global $wtgcsv_project_array;  
    // add template id (post id) to project default_contenttemplate_id value
    $wtgcsv_project_array['default_contenttemplate_id'] = $template_id;
    return wtgcsv_update_option_postcreationproject($project_code,$wtgcsv_project_array);        
}

function wtgcsv_update_default_titletemplate($project_code,$template_id){
    global $wtgcsv_project_array;  
    // add template id (post id) to project default_titletemplate_id value
    $wtgcsv_project_array['default_titletemplate_id'] = $template_id;
    return wtgcsv_update_option_postcreationproject($project_code,$wtgcsv_project_array);        
}

/**
* Gets the meta description value from project array.
* @returns boolean false if no meta description exists or project array could not be retrieved    * 
*/
function wtgcsv_get_project_metadescription(){
    global $wtgcsv_currentproject_code;
    $project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);
    if(!$project_array){
        return false;
    }else{
        if( !isset($project_array['metadescription_template']) ){
            return false;
        }else{
            return $project_array['metadescription_template'];
        }
    }
}

/**
* Returns projects date column if set 
*/
function wtgcsv_get_project_datecolumn($project_code){
    $project_array = wtgcsv_get_project_array($project_code);
    if(isset($project_array['dates']['date_column']['table_name']) && isset($project_array['dates']['date_column']['column_name'])){
        return $project_array['dates']['date_column']['table_name'] . '-' . $project_array['dates']['date_column']['column_name'];
    }else{
        return 'Date Column Not Set';
    }
}

/**
* Determines if a database table is a ready to be used a post creation project table 
* 
* @param string $table_name
* @return boolean
*/
function wtgcsv_is_wtgcsv_postprojecttable($table_name){

    // ensure the table exists before running tests
    $table_exists = wtgcsv_does_table_exist($table_name);
    if(!$table_exists){return;} 
        
    // list of all the post project columns required
    $required_columns = array('wtgcsv_id',
                    'wtgcsv_postid',
                    'wtgcsv_postcontent',
                    'wtgcsv_inuse',
                    'wtgcsv_imported',
                    'wtgcsv_updated',
                    'wtgcsv_changed',
                    'wtgcsv_applied');
    
    // confirm wtgcsv_ exists in tablename                
    $wtgcsv_in_tablename = strstr($table_name,'wtgcsv_');
    if(!$wtgcsv_in_tablename){
        return false;
    }

    // get the tables array of column names
    $table_columns_array = wtgcsv_sql_get_tablecolumns($table_name,true);
    if(!$table_columns_array){return;}
    
    // change $all_required_columns_found to false if one of the $required_columns are not found
    $all_required_columns_found = true;
    
    $column_counter = 0;
    $config_counter = 0;// reset per column
    
    foreach( $required_columns as $key => $column_name){

        $is_in_array = in_array($column_name,$table_columns_array);
        if(!$is_in_array){ echo $column_name .'<br />'; 
            return false;    
        }
        
        ++$column_counter;
    }  
  
    return $all_required_columns_found;     
}       
    
?>