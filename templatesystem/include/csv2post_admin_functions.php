<?php  
/**
* Deletes posts for one or more projects.
* Updates project tables so that the data can easily be used again.
* 
* @param mixed $project_code
* @param mixed $range (csv2post_undo_currentproject,csv2post_undo_last10minutes,csv2post_undo_last60minutes,csv2post_undo_last24hours,csv2post_undo_allprojects)
* @returns false on failure or numeric (number of posts deleted) on success 
*/
function csv2post_delete_project_posts_byrange($project_code,$range){
    global $csv2post_projectslist_array;
    
    // loop through all projects
    $posts_deleted = 0;
    
    foreach($csv2post_projectslist_array as $the_project_code => $project){
        
        if($range != 'allprojects' && $project_code == $the_project_code){
            
            // get project array
            $the_project_array = csv2post_get_project_array($the_project_code);
            
            // query post ID in project table
            $record_result = csv2post_WP_SQL_used_records($the_project_array['maintable'],9999999,'csv2post_postid');
            if($record_result){
                foreach($record_result as $key => $rec){
                   
                   // delete the post
                   ### TODO:LOWPRIORITY,create a general admin setting for forcing the delete and not putting posts in trash
                   wp_delete_post($rec['csv2post_postid'],false);
                   
                   // update project table
                   csv2post_WP_SQL_reset_project_record($rec['csv2post_postid'],$the_project_array['maintable']);
                   
                   ++$posts_deleted;  
                }
            }

            return $posts_deleted;
            
        }else{
            
             // get project array
            $the_project_array = csv2post_get_project_array($the_project_code);
            
            // query post ID in project table
            $record_result = csv2post_WP_SQL_used_records($the_project_array['maintable'],9999999,'csv2post_postid');
            if($record_result){
                foreach($record_result as $key => $rec){
                   
                   // delete the post
                   ### TODO:LOWPRIORITY,create a general admin setting for forcing the delete and not putting posts in trash
                   wp_delete_post($rec['csv2post_postid'],false);
                   
                   // update project table
                   csv2post_WP_SQL_reset_project_record($rec['csv2post_postid'],$the_project_array['maintable']);
                   
                   ++$posts_deleted;  
                }
            }              
        }
    }
    
    return $posts_deleted;  
}
        
/**
* Determines if domain owner is subscribing (currently effects premium support services, bonus downloads, extra credits etc)
* Subscription is not required for activation of full edition, that requires membership (which does not need annual payments)
* 
* @return boolean
*/
function csv2post_is_subscribed(){
    global $csv2post_is_domainregistered;
                     
    // is domain registered and has user giving permission for email authorisation
    if($csv2post_is_domainregistered === true){
   
        $function_boolean_result = false;
        
        // begin result array defaults
        $soapcall_result_array = array();
        $soapcall_result_array['result'] = true;
        $soapcall_result_array['rejected'] = false;
        $soapcall_result_array['rejectedreason'] = 'Not Rejected';        
        
        // use domain to make a call to web services
        $soapcall_result_array = csv2post_SOAP_checksubscriptionstatus_for_domain();
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
* @param mixed $csv2post_callcode
* @global $csv2post_callcode, set in main file
*/
function csv2post_is_callcodevalid(){
    global $csv2post_callcode;
               
    $soapcall_result_array = array();
    $soapcall_result_array = csv2post_SOAP_validate_call_code($csv2post_callcode);
                   
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
function csv2post_is_domainregistered(){
    
    $soapcall_result_array = array();
    $soapcall_result_array = csv2post_SOAP_confirm_current_domain_is_registered();
    
    if( $soapcall_result_array['resultcode'] == 2 ){
        return false;
    }elseif( $soapcall_result_array['resultcode'] == 3 ){

        // store call code - common use after this function is for generating activation code
        csv2post_update_callcode($soapcall_result_array['callcode']);
        
        return true;
    }else{
        return false;
    }
}

/**
* Stores call code in Wordpress options table
*/
function csv2post_update_callcode($callcode){
    return update_option(WTG_C2P_ABB . 'callcode',$callcode);
}

/**
* Gets the call code record if it exists 
*/
function csv2post_get_callcode(){
    return get_option(WTG_C2P_ABB . 'callcode');                       
}

/**
* Called from main file using add_action. 
* 1. Is and must always be within an admin check for security. We do the check in the main file so we dont need to do it multiple times in many functions.
* 
* @todo HIGHPRIORITY, this function does not appear to be finished and overall export ability could be improved on interface
* @todo HIGHPRIORITY, Ajax wont do anything with this but add the code for avoiding it when ajax call
* @todo LOWPRIORITY, consider another approach using fputcsv as used in csv2post_dfone_csvexport_finishedsubmissions()
*/
function csv2post_export_singlesqltable_as_csvfile(){
    if(isset($_POST['csv2post_post_processing_required'])){
        if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'exportsingletabledata'){
                 
            global $csv2post_is_free;

            if($csv2post_is_free || !strstr( $_POST['wtgpt_exporttable'] , 'csv2post_' )){
                csv2post_notice('This action is not permitted for security. We do not want to provide a free tool that allows any tables in
                the database to be exported. Only the paid edition, created with developers in mind, offers this feature.','warning','Large','Export Not Permitted','','echo');
            }else{
                
                ### TODO:CRITICAL, check of a table has any records, else exit
                global $wpdb;
                
                // get string of column names for using in SELECT query and CSV file header
                $column_string = csv2post_WP_SQL_build_columnstring($_POST['wtgpt_exporttable']);
                                                  
                $query_results = $wpdb->get_results( 'SELECT ' . $column_string . ' FROM ' . $_POST['wtgpt_exporttable'],ARRAY_A );
                
                if(!$query_results){
                    csv2post_notice('No records could be obtained for export from table named '.$_POST['wtgpt_exporttable'].'. Please ensure you have selected the correct database table for export.','warning','Large','No Records To Export','','echo');                    
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
                
                exit;
            }
        }
    }    
} 

function csv2post_array_to_string(){
    
}

/**
* Implode array into a string
*            
* @param mixed $value
* @param mixed $delimeter
*/
function csv2post_build_string($array,$delimeter = ','){
    return implode($delimeter, $array);  
}
                    
/**
* Called after csv2post_is_activated which determines if plugin currently has full edition activation state
* Called before csv2post_is_domainregistered simply to avoid constantly checking domain after activation even if broken
* 
* If activation code value found but our activation check failed ($csv2post_is_activated) then we have a broken activation 
* 
* @requires $csv2post_is_activated to be populated first 
*/
function csv2post_is_activationbroken(){
    global $csv2post_activationcode;
    if($csv2post_activationcode){
        global $csv2post_is_activated;// populated by soap call to confirm activation code still valid
        if($csv2post_is_activated){
            return false;// activation is not broken code is still valid 
        }else{
            return true;// we have a code but it is not a match, $csv2post_activationbroken will be used to let user know
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
function csv2post_format_file_size($size) {
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
function csv2post_cleanfilename( $filename ){
    $remove_these = array('-','_',' ',')','(',);
    $filename = str_replace ( $remove_these , '' ,  $filename );
    return $filename;
}

/**
* Removes special characters and converts to lowercase
*/
function csv2post_clean_string($string){ 
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
function csv2post_is_extensionloaded($giving_extension){
    $loaded_extensions = get_loaded_extensions();
    foreach($loaded_extensions as $key => $extension){
        if($extension == $giving_extension){
            return true;
        }
    }
    return false;
}
                          
/**
 * Install main content folder in wp-content directory for holding uploaded items
 * Called from install function in install.php if constant is not equal to false WTG_C2P_CONTENTFOLDER_DIR
 *
 * @return boolean true if folder installed or already exists false if failed
 */
function csv2post_install_contentfolder($pathdir,$output = false){
    $contentfolder_outcome = true;

    // does folder already exist
    if(!is_dir($pathdir)){
        $contentfolder_outcome = csv2post_createfolder($pathdir);
    }else{
        return true;
    }

    if(!$contentfolder_outcome){
        $contentfolder_outcome = false;
        if($output){
            csv2post_notice('Plugins content folder could be not created:'.$pathdir, 'error', 'Tiny');
        }
    }elseif($contentfolder_outcome){
         if($output){
            csv2post_notice('Plugin content folder has been created here: '.$pathdir, 'success', 'Tiny');
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
function csv2post_delete_contentfolder($pathdir,$output = false){
    if(!is_dir($pathdir)){
        global $csv2post_plugintitle;
        csv2post_notice($csv2post_plugintitle . ' could not locate the main content folder, it appears it
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
function csv2post_hideshow_tab($newstate,$pageid,$tab_number){
    
    global $csv2post_mpt_arr; 
    
    $csv2post_mpt_arr['menu'][ $pageid ]['tabs'][ $tab_number ]['display'] = $newstate;      
    
    return csv2post_update_tabmenu($csv2post_mpt_arr);           
}  

/**
* Updates locally stored copy of tab menu array
* 
* @uses serialize 
* @param mixed $csv2post_mpt_arr
* @return bool
*/
function csv2post_update_tabmenu(){
    global $csv2post_mpt_arr;
    return update_option('csv2post_tabmenu',serialize($csv2post_mpt_arr)); 
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
        $path .= WTG_C2P_DIR . 'templatesystem' . $fileitem['path'] . $fileitem['name'];
         
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

/**
* Validates the string entered as a name and ensures it does not already exist to
* help avoid the user confusing two different data import jobs 
* 
* @return boolean true if valid else false
* 
* @todo MEDIUMPRIORITY, complete function
*/
function csv2post_validate_dataimportjob_name($jobname){
    # ensure name is unique among existing job names
    # ensure name does not include special char
    return true;
}

/**
* Creates random code or can be used to make passwords
* 
*/
function csv2post_create_code($length = 10,$specialchars = false) { 

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
* Deletes the csv2post_currentprojectcode option record, used when deleting a project when it is also the current project.
* I took this approach to help users cleanup the database when removing the plugin. 
*/
function csv2post_delete_option_currentprojectcode(){
    return delete_option('csv2post_currentprojectcode');    
}

function csv2post_delete_option_currentjobcode(){
    return delete_option('csv2post_currentjobcode');    
}

/**
* Updates/Creates option record for holding the current job code
* 
* @param mixed $job_code
*/
function csv2post_update_option_currentjob_code($job_code){
    global $csv2post_currentjob_code;
    $csv2post_currentjob_code = $job_code;
    return update_option('csv2post_currentjobcode',$job_code);     
}

function csv2post_get_option_currentjobcode(){
    return get_option('csv2post_currentjobcode');    
}        

/**
* Update the current project wordpress option record
* If user deletes project which is set as current project, the value is set to false 
*/
function csv2post_update_currentproject($project_code){
    global $csv2post_currentproject_code;
    $csv2post_currentproject_code = $project_code;
    return update_option('csv2post_currentprojectcode',$project_code);    
}
                
/**
* Deletes post creation project.
* Updates project list array and deletes project option record.
* 
* @param mixed $project_code
* @return boolean, false if a failure is detected in trying to remove any part of the project else true is returned
*/
function csv2post_delete_postcreationproject($project_code,$current_project_code = false){
    global $csv2post_projectslist_array;
    
    // check if csv2post_currentprojectcode matches the project being deleted and set it to false if so
    if(isset($current_project_code) && $project_code == $current_project_code){
       csv2post_update_currentproject(false);
    }
    
    // now remove the project from the project list array    
    unset($csv2post_projectslist_array[$project_code]);
    $updatelist_result = csv2post_update_option_postcreationproject_list($csv2post_projectslist_array);
    
    // finally we delete the projects own record in wordpress options tables
    $delete_result = delete_option('csv2post_' . $project_code);
    
    if($updatelist_result === false || $delete_result === false){
        return false;
    }
    
    return true;
}

/**
* Updates "projectlist" option, requires the array itself to be passed
*/
function csv2post_update_option_postcreationproject_list($csv2post_projectslist_array){
    return update_option('csv2post_projectslist',serialize($csv2post_projectslist_array));    
}

/**
* Checks giving job table to decide if it has been used in a project.
* 1. Should only pass a table created by CSV 2 POST (with project columns)
* 2. Currently used for post creation projects only
*/
function csv2post_is_table_used($table_name){
    // for post creation projects we will check the csv2post_postid column for a value
    // if even one record has a value then the table has been used
    $result = csv2post_WP_SQL_used_records($table_name,1);
    if(!$result){
        return false;
    }else{
        return true;
    }  
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
function csv2post_delete_dataimportjob_postrequest($jobcode,$output = true){
    global $csv2post_dataimportjobs_array;

    $function_outcome = true;
                    
    // first delete the jobs own record in options table
    $deleteoption_result = csv2post_delete_dataimportjob_optionrecord($jobcode);
    if($deleteoption_result != false){
        if($output){
            csv2post_notice('Data import job named '.$csv2post_dataimportjobs_array[$jobcode]['name'].' has been 
            deleted.','success','Extra'); 
        }    
    }else{
        if($output){
            csv2post_notice('Data import job named '.$csv2post_dataimportjobs_array[$jobcode]['name'].' could not be 
            deleted. The Wordpress option record for this job may still be in the options table and require manual 
            removal. Please report this issue. If however you already removed the option record manually being this 
            action then that may cause this error and it can be ignored.','error','Extra'); 
        }
        $function_outcome = false;
    }
    
    // loop through global jobs array, unset each job code match
    foreach( $csv2post_dataimportjobs_array as $one => $two){
        if($one == $jobcode){
            unset($csv2post_dataimportjobs_array[$jobcode]);
        }
    }
    
    $updatejobsarray_result = update_option('csv2post_dataimportjobs',$csv2post_dataimportjobs_array);

    return $function_outcome;   
}

/**
* Initializes the array for a job i.e data import job. Adds some defaults.
* The full array is added to in the csv2post_form_createdataimportjob() function.
* All files and their headers are added.
* 
* @param string $jobname
* @param string $code
*/
function csv2post_create_jobarray($jobname,$code){

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
* Adds a job table to the job tables array record in wordpress options table
* @uses csv2post_update_option_jobtables_array() which uses update_option()
*/
function csv2post_add_jobtable($new_jobtable){
    global $csv2post_jobtable_array;// set in main file
    $csv2post_jobtable_array[] = $new_jobtable;
    csv2post_update_option_jobtables_array($csv2post_jobtable_array);
}

/**
* Returns percentage of data import job completion.
* 
* @param mixed $jobcode
*/
function csv2post_calculate_dataimportjob_progress_percentage($jobcode){
    $projecttotal_progress = 0;
    $projecttotal_rows = 0;
    // first get data import job array
    $jobarray = csv2post_get_dataimportjob($jobcode);
    // loop through files - then use each filename to get that files $progress counter 
    foreach($jobarray['files'] as $csvfile_id => $csvfile_name){
        $projecttotal_progress = $projecttotal_progress + $jobarray['stats'][$csvfile_name]['progress'];    
    }

    $percentage = $projecttotal_progress/$jobarray['totalrows'] * 100;  

    return $percentage;   
}

/**
* Checks if a $_POST submission has requested specific template for editing.
* If no request, will return empty array and values to indicate to other functions that they should return null values. 
*/
function csv2post_get_template_bypostrequest(){

    $templatedesign_array = array();
    $templatedesign_array['template_id'] = 0; 
    $templatedesign_array['template_name'] = 'Please Enter Template Design Name';
    $templatedesign_array['template_content'] = 'Create a template here, remember you can use the HTML screen also';
    
    // check if form submitted for opening existing template designs           
    if(isset($_POST["csv2post_opencontentdesign"]) && isset($_POST["csv2post_templatename_and_id"])){

        // extract post_id from the csv2post_templatename_and_id value which is the buttons visual text
        $templatedesign_array['template_id'] = csv2post_PHP_STRINGS_get_between_two_values('(',')',$_POST["csv2post_templatename_and_id"]);    

        // get post (post type: wtgcsvtemplate)
        $template_post_object = get_post($templatedesign_array['template_id']);
         
        $templatedesign_array['template_name'] = $template_post_object->post_title;
        $templatedesign_array['template_content'] = $template_post_object->post_content; 
    }

    return $templatedesign_array;   
}

/**
* Updates default content template value in giving project.
* 
* @param mixed $csv2post_currentproject_code
* @param mixed $template_id
*/
function csv2post_update_default_contenttemplate($project_code,$template_id){
    global $csv2post_project_array;  
    $csv2post_project_array['default_contenttemplate_id'] = $template_id;
    return csv2post_update_option_postcreationproject($project_code,$csv2post_project_array);        
}

function csv2post_update_default_titletemplate($project_code,$template_id){
    global $csv2post_project_array;  
    $csv2post_project_array['default_titletemplate_id'] = $template_id;
    return csv2post_update_option_postcreationproject($project_code,$csv2post_project_array);        
}

function csv2post_update_default_excerpttemplate($project_code,$template_id){
    global $csv2post_project_array;  
    $csv2post_project_array['default_excerpttemplate_id'] = $template_id;
    return csv2post_update_option_postcreationproject($project_code,$csv2post_project_array);        
}

/**
* Gets the meta description value from project array.
* @returns boolean false if no meta description exists or project array could not be retrieved    * 
*/
function csv2post_get_project_metadescription(){
    global $csv2post_currentproject_code;
    $project_array = csv2post_get_project_array($csv2post_currentproject_code);
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
function csv2post_get_project_datecolumn($project_code){
    $project_array = csv2post_get_project_array($project_code);
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
function csv2post_is_csv2post_postprojecttable($table_name){

    // ensure the table exists before running tests
    $table_exists = csv2post_WP_SQL_does_table_exist($table_name);
    if(!$table_exists){return false;} 
                  
    // list of all the post project columns required
    $required_columns = array('csv2post_id',
                    'csv2post_postid',
                    'csv2post_postcontent',
                    'csv2post_inuse',
                    'csv2post_imported',
                    'csv2post_updated',
                    'csv2post_changed',
                    'csv2post_applied');
    
    // confirm csv2post_ exists in tablename                
    $csv2post_in_tablename = strstr($table_name,'csv2post_');
    if(!$csv2post_in_tablename){
        return false;
    }

    // get the tables array of column names
    $table_columns_array = csv2post_WP_SQL_get_tablecolumns($table_name,true,true);
    if(!$table_columns_array){return false;}
    
    // change $all_required_columns_found to false if one of the $required_columns are not found
    $all_required_columns_found = true;
    
    $column_counter = 0;
    $config_counter = 0;// reset per column

    foreach( $required_columns as $key => $column_name){
                        
        $is_in_array = in_array($column_name,$table_columns_array);
        if(!$is_in_array){ 
            return false;    
        }
        
        ++$column_counter;
    }  
  
    return $all_required_columns_found;     
}       

/**
* Admin Triggered Automation
* This calls various functions to peform data import job or post creation project tasks. Events will 
* be execute.
* 1.Changes during this operation or new information since the user last logged in will also be displayed.
* 2. Setting values do not need to exist, if they do not exist they are on by default, this is to reduce the need for configuration in order to get the plugins full ability in motion
* 
* @todo LOWPRIORITY, add more Admin Triggered Automation on the General Settings screen
* 1. 
*/
function csv2post_admin_triggered_automation(){
    global $csv2post_adm_set,$csv2post_file_profiles;
    
    // new csv file check - cycle through all CSV files in-use by Data Import Jobs
    // this will also create a profile in $csv2post_file_profiles if one does not exist for file
    if(!isset($csv2post_adm_set['admintriggers']['newcsvfiles']['status']) || isset($csv2post_adm_set['admintriggers']['newcsvfiles']['status']) && $csv2post_adm_set['admintriggers']['newcsvfiles']['status'] == 1){
        csv2post_admin_triggered_newcsvfilescheck();            
    } 
} 

/**
* Checks if any of the CSV files in use have been overwritten with a newer copy and takes action to trigger updates.
* Check the $csv2post_adm_set['admintriggers']['newcsvfiles']['status'] before calling function.
* 1. This is the first admin trigger function
* 2. This is the only admin trigger function intended for free edition, it is a starting point for developers hacking free edition so thats good enough for now
* 
* @return boolean true if 1 file has a newer version, false on fault or no newer files found
*/
function csv2post_admin_triggered_newcsvfilescheck(){

    global $csv2post_adm_set,$csv2post_job_array,$csv2post_file_profiles,$csv2post_dataimportjobs_array;

    // ensure we have an array else we do nothing at all
    if(!is_array($csv2post_dataimportjobs_array)){
        return false;
    }

    // loop through all jobs so we can determine which files are in use        
    foreach($csv2post_dataimportjobs_array as $key => $job){
        
        // get current job array using job key
        $job_array = csv2post_get_dataimportjob($key);
        
        // ensure file array exists (just extra measures to avoid failures but this situation should never happen)
        if(!isset($job_array['files'])){
            ### TODO:MEDIUMPRIORITY, log this event
            return false;    
        }
        
        // loop through files and carry out date check to determine if file has changed since last checked
        foreach($job_array['files'] as $filekey => $csvfile_name){
            $file_exist_result = csv2post_files_does_csvfile_exist($csvfile_name);// returns boolean
            if($file_exist_result){
                 
                // get files modified time for comparing to the modified time we have stored in files profile
                $csvfile_currentmodified_time = csv2post_files_get_csvfile_filemtime($csvfile_name);
                  
                // does this file already have a profile? (if yes we get it else we set it)
                /* if we adapt plugin to handle files in many paths the profiles array will need to use paths as key */
                if(isset($csv2post_file_profiles[$csvfile_name]['currentmodtime'])){
                    
                    // does the files current modified time equal our stored modified time?
                    if($csv2post_file_profiles[$csvfile_name]['currentmodtime'] != $csvfile_currentmodified_time){
                         
                        // use time in profile and time in newer file to get formatted date
                        $csvfile_currentmodified_date = csv2post_date(0,csv2post_files_get_csvfile_filemtime($csvfile_name));
                        $csvfile_profilemodified_date = csv2post_date(0,$csv2post_file_profiles[$csvfile_name]['currentmodtime']);                         

                        // update file profile
                        csv2post_files_update_fileprofile($csvfile_name);
                        
                        // update data import job array - reset progress counters so that Advanced Data Import can run (includes updating ability)
                        $job_array["stats"]["allevents"]['progress'] = 0;
                        $job_array['stats'][$csvfile_name]['progress'] = 0;
                        $job_array['stats'][$csvfile_name]['lastrow'] = 0;  

                        // display notice about a newer csv file being detected
                        if(isset($csv2post_adm_set['admintriggers']['newcsvfiles']['display']) && $csv2post_adm_set['admintriggers']['newcsvfiles']['display'] == 1){
                            csv2post_notice('An updated CSV file has been detected. Your file named
                            <strong>'.$csvfile_name.'</strong> had a modified date of <strong>'.$csvfile_profilemodified_date.'</strong> and it is now 
                            <strong>'.$csvfile_currentmodified_date.'</strong>. 
                            <p>Your data import job named <strong>'.$job_array['name'].'</strong> (code:'.$key.') has been
                            reset in-order to perform updating by re-importing the data from the newer file.</p>','success','Large','Updated CSV File Detected','','echo');        
                        }                               
                        
                        // we will only do one file to avoid over processing during this event
                        return true;
                    }    
                       
                }else{
                    
                    // create profile for this file - this function will add everything the plugin requires
                    csv2post_files_update_fileprofile($csvfile_name);
                    
                }      
            }
        }    
    }
    return false;
}

/**
* Checks the wtgcsvimportercontent folder for CSV file.
* Very basic function because we only use CSV files in one directory. 
* 
* @param mixed $csvfile
* @returns the result of is_file() which is boolean
*/
function csv2post_files_does_csvfile_exist($csvfile_name){
    return is_file(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name);     
}

/**
* Gets the modified time of a CSV file in the plugins content folder
* 
* @param mixed $csvfile
* @return bool
*/
function csv2post_files_get_csvfile_filemtime($csvfile_name){
    return filemtime(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name);     
} 

/**
* Adds a file and its meta data to the $csv2post_file_profiles array
* or overwrites the existing data essentially updating the profile
* 
* @param mixed $csvfile_name
*/
function csv2post_files_update_fileprofile($csvfile_name){
        
    global $csv2post_file_profiles;
    $csv2post_file_profiles[$csvfile_name]['profileupdated'] = time();
    
    //store current modified time (latest detected)
    // this is also stored with imported records and job array. We can comparing the two dates using those two methods.
    // this is important for when we are dealing with a specific record and data import job array no longer exists. 
    $csv2post_file_profiles[$csvfile_name]['currentmodtime'] = csv2post_files_get_csvfile_filemtime($csvfile_name);
    csv2post_update_option_fileprofiles($csv2post_file_profiles);
}                         
?>