<?php                                  
#################################################
#                                               #
#      Quick Start - FREE FUNCTIONS             #
#                                               #
#################################################
function csv2post_form_ECI_free_step18_createposts(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreecreateposts' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code,$csv2post_project_array;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        // update the ECI session array
//$csv2post_ecisession_array['nextstep'] = 19;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array); 
                
        // free edition processes all records at once, $_POST['csv2post_postsamount'] will not be set   
        $post_id = csv2post_create_posts_basic($csv2post_currentproject_code,'manual');
        if($post_id){
            // no false returned (false indicates a failure)
            // $post_id will be the last post ID created
            csv2post_notice_postresult('success','Posts Created','Post creation went smoothly, no 
            problems were detected. The last post ID created was <strong>'.$post_id.'</strong>.');
            ### TODO:LOWPRIORITY, add link and url to last created post to the output  
        }else{
           // must be a failure, if multiple posts were requests the failure is big enough to output it to the user
           csv2post_notice_postresult('warning','Problem Detected','You may not have any records or your project
           configuration is causing some type of conflict and is not allowing posts to be created in your blogs current status. If you feel this is
           a fault please contact us.');
        }    
        
        return false;
    }else{
        return true;
    }     
} 
                       
function csv2post_form_ECI_free_step17_posttypes(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeposttypes' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        
        global $csv2post_project_array,$csv2post_currentproject_code;
        $csv2post_project_array['defaultposttype'] = $_POST['csv2post_radio_defaultpostype'];
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 
            
        // update the ECI session array
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        $csv2post_ecisession_array['nextstep'] = 18;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        csv2post_notice_postresult('success','Post Type Saved','Your post type has been saved.');
        
        return false;
    }else{
        return true;
    }     
} 
       
function csv2post_form_ECI_free_step16_themesupport(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'quickstartfreethemesupport' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        if(!isset($_POST['csv2post_radio_postformat'])){
            $csv2post_project_array['postformat']['default'] = 'standard';
        }else{
            $csv2post_project_array['postformat']['default'] = $_POST['csv2post_radio_postformat'];
        }        
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        $csv2post_ecisession_array['nextstep'] = 17;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     

        csv2post_notice_postresult('success','Theme Settings Saved','All of your theme settings are saved.
        All your post will use the '.$csv2post_project_array['postformat']['default'].' Post Format.'); 
        
        return false;
    }else{
        return true;
    }     
} 

function csv2post_form_ECI_free_step15_authors(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreedefaultauthor' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        global $csv2post_project_array,$csv2post_currentproject_code;

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        $csv2post_project_array['authors']['defaultauthor'] = $_POST['csv2post_ecifreedefaultauthor_select'];
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 

        $csv2post_ecisession_array['nextstep'] = 16;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        csv2post_notice_postresult('success','Default Author Saved','A default author has been saved');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step14_textspinning(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        // not currently in free edition
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step13_tags(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreetags' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
                
        if($_POST['csv2post_eci_freetags_methods'] == 'no'){
            // nothing needs to be done
            csv2post_notice_postresult('success','No Featured Images Wanted','You opted to not use featured images in your posts.');    
        }else{
            
            global $csv2post_project_array,$csv2post_currentproject_code;
            
            $csv2post_project_array['tags']['default']['table'] = 'csv2post_' . $csv2post_ecisession_array['dijcode'];
            $csv2post_project_array['tags']['default']['column'] = $_POST['csv2post_eci_freetags_methods'];                       
            $csv2post_project_array['tags']['method'] = 'premade'; 
            
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);                
            
            csv2post_notice_postresult('success','Tags Configured','Your tags data will be added to your posts providing your posts.');    
        }

        $csv2post_ecisession_array['nextstep'] = 15;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step12_images(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeimages' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
      
        if($_POST['csv2post_eci_freefeaturedimages_methods'] == 'no'){
            // nothing needs to be done
            csv2post_notice_postresult('success','No Featured Images Wanted','You opted to not use featured images in your posts.');    
        }else{
            
            global $csv2post_project_array,$csv2post_currentproject_code;

            $csv2post_project_array['images']['featuredimage']['table'] = 'csv2post_' . $csv2post_ecisession_array['dijcode'];            
            $csv2post_project_array['images']['featuredimage']['column'] = $_POST['csv2post_csvfileheader_eci_freefeaturedimages_WTGTestB'];
            
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);                
            
            csv2post_notice_postresult('success','Featured Images Setup','Your posts will have featured images providing the image URL are valid.');    
        }

        $csv2post_ecisession_array['nextstep'] = 13;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);    
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step11_postupdateoptions(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreenotpermittedinfreeedition' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        // not part of free edition
        return false;
    }else{
        return true;
    }     
}
    
function csv2post_form_ECI_free_step10_categories(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreecategories' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code,$csv2post_project_array; 
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        
        $csv2post_project_array['categories']['default'] = $_POST['csv2post_createcategorymappingecifreecategory_select'];

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);        
                    
        $csv2post_ecisession_array['nextstep'] = 12;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        csv2post_notice_postresult('success','Category Saved','You have set a default category, the category ID is '.$_POST['csv2post_createcategorymappingecifreecategory_select'].'.');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step9_customfields(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreecustomfields' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code,$csv2post_project_array;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

        // get last array key for current custom fields if they exist
        if(isset($csv2post_project_array['custom_fields']['basic'])){
            $last_array_key = csv2post_get_array_nextkey($csv2post_project_array['custom_fields']['basic']);
        }else{
            $last_array_key = 0;
        }
           
        // loop through headers
        $job_headers_array = csv2post_get_dataimportjob_headers_singlefile($csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);
        foreach($job_headers_array as $key => $header){

            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['table_name'] = 'csv2post_' . $csv2post_ecisession_array['dijcode'];                
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['column_name'] = $header['sql'];
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['meta_key'] = $_POST['csv2post_ecifree_cf_'.$key];
            ++$last_array_key;
        }           

        // update project option         
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        // update the ECI session array
        $csv2post_ecisession_array['nextstep'] = 10;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     
        
        csv2post_notice_postresult('success','Custom Fields Saved','Your custom field settings have been saved.');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step8_postdates(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreepostdates' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code,$csv2post_project_array;

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        $file = $csv2post_ecisession_array['filenamenoext'];
        
        if($_POST['csv2post_eci_freedates_methods'] == 'default'){
            
            unset($csv2post_project_array['dates']['currentmethod']);
             
        }elseif($_POST['csv2post_eci_freedates_methods'] == 'data'){
            
            $csv2post_project_array['dates']['date_column']['table_name'] = 'csv2post_' . $csv2post_ecisession_array['dijcode'];          
            $csv2post_project_array['dates']['date_column']['column_name'] = $_POST['csv2post_csvfileheader_eci_freedates_' . $file];
            $csv2post_project_array['dates']['currentmethod'] = 'data';
             
        }else{
            unset($csv2post_project_array['dates']['currentmethod']);    
        }  
   
        ### TODO:MEDIUMPRIORITY, test a date value from users data, also consider a tool for converting dates to require format
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        // update the ECI session array              
        $csv2post_ecisession_array['nextstep'] = 9;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);
        
        csv2post_notice_postresult('success','Data Method Saved','Your selected date method has been saved.');     
        
        return false;
    }else{
        return true;
    }     
}
 
function csv2post_form_ECI_free_step7_poststatus(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreepoststatus' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        if(!isset($_POST['csv2post_radio_poststatus'])){
            $csv2post_project_array['poststatus'] = 'publish';
        }else{
            $csv2post_project_array['poststatus'] = $_POST['csv2post_radio_poststatus'];
        }
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        $csv2post_ecisession_array['nextstep'] = 8;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     

        csv2post_notice_postresult('success','Post Status Saved','All your post status will be set to ' . $csv2post_project_array['poststatus'] . '.');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step6_seo(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){
        // currently not in free edition, feel free to hack and let us know what you do so we know what abilities users would like put here
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step5_titletemplate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreesetuptitletemplate' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        
        $file = $csv2post_ecisession_array['filenamenoext'];
        
        $template_id = csv2post_insert_titletemplate($file . ' ' . csv2post_date(),'#'.$_POST['csv2post_csvfileheader_eci_pair_description_'.$file]);
        
        if(!is_numeric($template_id)){
            csv2post_notice_postresult('error','Title Template Not Created','A new title template could not be created. Please report
            this issue and get help before continuing.');
            return false;
        }
        
        csv2post_update_default_titletemplate($csv2post_currentproject_code,$template_id);
        
        $csv2post_ecisession_array['nextstep'] = 7;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     

        csv2post_notice_postresult('success','Title Template Created','A new title template was created.');
        
        return false;
    }else{
        return true;
    }     
}

function csv2post_form_ECI_free_step4_contenttemplate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreesetupcontenttemplate' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_currentproject_code;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
                     
        // one template per CSV file with the Quick Start so if the title exists already, we delete that first
        $does_post_exist = get_page_by_title( $_POST['csv2post_contentname'], ARRAY_A, 'wtgcsvcontent' );

        if($does_post_exist != NULL){wp_delete_post($does_post_exist['ID']);}
             
        $template_id = csv2post_insert_post_contenttemplate($_POST['csv2post_wysiwyg_editor'],$_POST['csv2post_contentname']);
  
        if(!is_numeric($template_id)){
            csv2post_notice_postresult('error','Content Template Not Created','A new content template could not be created. Please report
            this issue and get help before continuing.');
            return false;
        }
        
        csv2post_update_default_contenttemplate($csv2post_currentproject_code,$template_id); 
        
        // update the ECI session array 
        $csv2post_ecisession_array['nextstep'] = 5;
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);     

        csv2post_notice_postresult('success','Content Template Created','A new content template was created
        and set as your projects default template. You may edit the template under Content Templates in the
        main Wordpress menu, it is a post type.');
            
        return false;
    }else{
        return true;
    }     
}
    
function csv2post_form_ECI_free_step3_importdate(){
    if(isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeimportdata' && isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main'){

        global $csv2post_is_free;
        
        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        
        $job_code = $csv2post_ecisession_array['dijcode'];
        $file_name = $csv2post_ecisession_array['filename'];
  
        // perform data import
        $overall_result = 'success';
        $dataimportjob_array = csv2post_data_import_from_csvfile_basic($file_name,'csv2post_'.$job_code,9999999,$job_code);
        
        // determine new $overall_result and apply styling to the main notice to suit it
        if($dataimportjob_array == false){
            csv2post_notice_postresult('error','Fault','There was a problem importing
            data, please seek support from the plugin author.');
            return false;
        }
        
        $intromes = '';

        // display result    
        csv2post_notice( '<h4>Data Import Result<h4>'.$intromes.'
        '.csv2post_notice( 'New Records: '.$dataimportjob_array["stats"]["lastevent"]['inserted'],'success','Small',false,'www.csv2post.com/notifications/new-records-count','return').'
        '.csv2post_notice( 'Void Records: '.$dataimportjob_array["stats"]["lastevent"]['void'],'info','Small',false,'www.csv2post.com/notifications/void-records-counter','return').'
        '.csv2post_notice( 'Dropped Rows: '.$dataimportjob_array["stats"]["lastevent"]['dropped'],'warning','Small',false,'www.csv2post.com/notifications/dropped-rows-counter','return').'
        '.csv2post_notice( 'Rows Processed: '.$dataimportjob_array["stats"]["lastevent"]['processed'],'info','Small',false,'www.csv2post.com/notifications/rows-processed-counter','return').'         
        ',$overall_result,'Extra','','','echo'); 

        $csv2post_ecisession_array['nextstep'] = 4;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);
                        
        return false;
    }else{
        return true;
    }     
}
                          
function csv2post_form_ECI_free_step2_confirmformat(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeconfirmformat'){

        $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();
        
        // set full filename
        $filename = $csv2post_ecisession_array['filename'];

        $file = $csv2post_ecisession_array['filenamenoext'];
                                       
        // if user did not enter field count
        if(!isset($_POST['csv2post_csvfile_fieldcount_' . $file]) || $_POST['csv2post_csvfile_fieldcount_' . $file] == ''){
            csv2post_notice_postresult('error','Column/Field Number Required','You did not enter a value for the number of columns your CSV file has.');
            return;
        }
                
        // if user did not select separator
        if(!isset($_POST['csv2post_newjob_separators' . $file])){
            csv2post_notice_postresult('error','No Separator Selected','Please select the separator/delimiter.');
            return;
        }
        
        // if user did not select quote
        if(!isset($_POST['csv2post_newjob_quote' . $file])){
            csv2post_notice_postresult('error','No Quote Selected','Please select the quote used in your CSV file.');
            return;
        }            

        $importjobname_validate_result = csv2post_validate_dataimportjob_name($file);
        if(!$importjobname_validate_result){
            csv2post_notice_postresult('error','Invalid Data Import Job Name','This job name has been determined as not suitable:'.$file.'. Please report this, we can make modifications to get around the problem quickly.');
            return;
        }
        
        // generate job code (used to name database table and option record for job history) 
        $code = csv2post_create_code(6); 

        // create an array for the job, to be stored in an option record of its own
        $jobarray = csv2post_create_jobarray($file,$code);
        $jobarray['jobname'] = $file;

        // free edition does not allow multiple files                
        $jobarray['filegrouping'] = 'single';
                         
        // add the file with the $fileid as key, $fileid is simple integer number beginning from 1
        $jobarray['files'][1] = $filename;

        // add separator
        $jobarray[$filename]['separator'] = $_POST['csv2post_newjob_separators' . $file];        
       
        // add quote
        if($_POST['csv2post_newjob_quote' . $file] == 'doublequote'){
            $jobarray[$filename]['quote'] = '"';    
        }elseif($_POST['csv2post_newjob_quote' . $file] == 'singlequote'){
            $jobarray[$filename]['quote'] = "'";
        }

        // add number of fields/columns
        $jobarray[$filename]['fields'] = $_POST['csv2post_csvfile_fieldcount_'.$file];    
       
        // add job stats for the file, required for multiple file jobs
        $jobarray['stats'][$filename]['progress'] = 0;
        $jobarray['stats'][$filename]['inserted'] = 0;    
        $jobarray['stats'][$filename]['updated'] = 0;
        $jobarray['stats'][$filename]['deleted'] = 0;
        $jobarray['stats'][$filename]['void'] = 0;    
        $jobarray['stats'][$filename]['dropped'] = 0;    
        $jobarray['stats'][$filename]['duplicates'] = 0;                    
        $jobarray['stats'][$filename]['rows'] = csv2post_count_csvfilerows($filename);                    

        // also add an array of each files headers with the file as key
        $jobarray[$filename]['headers'] = csv2post_get_file_headers_formatted($filename,1,$jobarray[$filename]['separator'],$jobarray[$filename]['quote'],$jobarray[$filename]['fields']);
         
        // set total rows
        $jobarray['totalrows'] = $jobarray['stats'][$filename]['rows'];
  
        $result = csv2post_update_dataimportjob($jobarray,$code);
        if(!$result){
            csv2post_notice_postresult('error','Failure','Could not save new Data Import Job, please report this.');
            return;        
        }
                   
        // set global $csv2post_currentjob_code as new code and set global $csv2post_job_array
        global $csv2post_currentjob_code,$csv2post_job_array;
        $csv2post_currentjob_code = $code;
        $csv2post_job_array = $jobarray;
                                           
        // in free edition we automatically delete the existing table if any
        csv2post_SQL_drop_dataimportjob_table('csv2post_'.$csv2post_currentjob_code);
                    
        // create a database table - multiple file jobs are put into a single table, column names are giving appended values to prevent conflict with shared names    
        $createtable_result = csv2post_WP_SQL_create_dataimportjob_table($csv2post_currentjob_code,'single');
        if(!$createtable_result){
            csv2post_notice_postresult('error','Failure','Your data import database table 
            could not be created, this is required for importing your data to before using 
            it to create posts. Please seek help from the plugin author.');
            return;       
        }
   
        // update csv2post_current_job option record
        csv2post_update_option_currentjob_code($code);
                        
        // update the Data Import Jobs Array (the list of all job ID)
        global $csv2post_dataimportjobs_array;
                        
        // if data import jobs array is not already set then this must be the first job - set it as an array
        if(!is_array($csv2post_dataimportjobs_array)){
            $csv2post_dataimportjobs_array = array();    
        }

        // add job to the array that only holds a list of jobs not job statistics
        csv2post_add_dataimportjob_to_list($code,$file);

        // set last step as 9 (by default we use start by zero allows us to confirm start was done)
        $csv2post_ecisession_array['nextstep'] = 3;
        $csv2post_ecisession_array['dijcode'] = $code;// add data import job code 
        $csv2post_ecisession_array['jobname'] = $file;

        #################################################
        #                                               #
        #        CREATE POST CREATION PROJECT           #
        #                                               #
        #################################################
        global $csv2post_currentproject_code,$csv2post_projectslist_array; 
        
        // delete existing project using the same $file as it is the same name also (we want ECI to be very simple)
        foreach($csv2post_projectslist_array as $procode => $project){ 
            if(isset($project['name']) && $project['name'] == $file){
                csv2post_delete_postcreationproject($procode,$csv2post_currentproject_code);
            }
        }
                               
        $createproject_result_code = csv2post_create_post_creation_project($file,array('csv2post_'.$code),'defaultorder');
        
        // now set the new project as the Current Project ($csv2post_currentproject_code)               
        if($createproject_result_code){
            
            // now set the new project as the Current Project ($csv2post_currentproject_code)               
            $csv2post_currentproject_code = $createproject_result_code;
            csv2post_update_currentproject($createproject_result_code);
            
            // update the ECI session array
            csv2post_option('csv2post_ecisession','update',$csv2post_ecisession_array);
                    
            csv2post_notice_postresult('success','Project Created','A data 
            import job was created for managing your data. A post creation 
            project was created for managing your post creation.');
        
        }else{
            csv2post_notice('A problem was detected when making the new Post 
            Creation Project. It is recommended that you attempt to make 
            the project again and please report this problem if it continues.','error','Large','Post Creation Project Not Created');    
        }  
        
        return false;
    }else{
        return true;
    }     
}

// Quick Start - Step 1 (in code it is zero) - Upload CSV File
function csv2post_form_ECI_free_step1_uploadcsvfile(){
    if(isset($_POST['csv2post_post_eciuploadcsvfile']) && $_POST['csv2post_post_eciuploadcsvfile'] == true
    && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecifreeuploadcsvfile'){
        global $csv2post_plugintitle;
        
        $upload = $_FILES['file'];
        
        // ensure user uploaded a .csv file
        if(!strstr($upload['name'],'.csv')){
            csv2post_notice('Sorry but '.$csv2post_plugintitle.' only accepts CSV 
            files with .csv extension right now.','error','Large','File Extension Not Allowed','','echo');
            return false;
        }        
        
        // check error value
        if($upload['error'] != 0){
            csv2post_notice('Sorry, your file could not upload. Please contact us for support and 
            give error code: ' . $upload['error'],'error','Large','CSV Upload Failure');
            return false;// not returning false due to failure, only returning false to indicate end of processing            
        }        
        
        // ensure file destination exists
        $open_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        if(!$open_result){
            csv2post_notice('File was not uploaded. Could not open the destination folder. 
            The folder is named wpcsvimportercontent and should be in the wp-content 
            directory. Please fix this before trying again.','error','Large','File Not Upload');
            return false;
        }

        // first reset ECI session array
        $csv2post_qs_array = array();
        $csv2post_qs_array['arrayupdated'] = time();
        $csv2post_qs_array['filename'] = $upload['name'];

        // check if filename already exists in destination - we will let the user know they wrote over an existing file
        $target_file_path =  WTG_C2P_CONTENTFOLDER_DIR . '/' . $upload['name'];
        $target_file_path_exists = file_exists( $target_file_path );
        if($target_file_path_exists){
            
            $csv2post_qs_array['filereplaced'] = true;
            
            // get existing files datestamp - we use it to ensure the new file is newer/changed and trigger data update
            $oldtime = filemtime( $target_file_path );
                    
            // delete the existing file
            unlink( $target_file_path );
            
            if ( file_exists( $target_file_path )){
                
                csv2post_notice('The name of your file being uploaded already exists in the target 
                folder. '.$csv2post_plugintitle.' could not remove the existing file, but it should have. 
                It may be because the existing file is in use, please investigate this then try again if 
                required. If some sort of permissions problem is causing this, you may delete the existing 
                file using FTP also.','error','Large','Existing File Not Removed'); 
                   
                // return now due to not being able to remove the existing file
                return false;
            }
            
            // file must not exist, unlink was success, let user know this was done
            csv2post_notice('The file name being uploaded existed already. The existing file was replaced.','info','Large','File Replaced');        
        }else{
            $csv2post_qs_array['filereplaced'] = false;
        }

        // now move temp file into target path
        $move_result = move_uploaded_file( $upload['tmp_name'], $target_file_path );
        
        // did the move fail
        if(!$move_result){
            csv2post_notice('Failed to upload CSV file, there was a problem moving the temporary file into the target directory, please investigate this issue.','error','Large','Upload Failed');
            return false;
        }
        
        // check that file is now in place
        if(!file_exists($target_file_path)){                                                                                      
            csv2post_notice('The server confirmed that the file was uploaded and put into the target 
            directory but now indicates the file is not there. Please report this problem.','error','Large','Uploaded File Missing');
            return;
        }
        
        // we use the files name without extension a lot so we will store it now 
        $csv2post_qs_array['filenamenoext'] = str_replace('.csv','',$upload['name']); 
        
        // set last step as 9 (by default we use start by zero allows us to confirm start was done)
        $csv2post_qs_array['nextstep'] = 2;
        
        // update the ECI session array
        csv2post_option('csv2post_ecisession','update',$csv2post_qs_array);
        
        // upload is a success
        csv2post_notice('The CSV file was uploaded, you can proceed to the next step.',
        'success','Large','CSV File Ready To Use');

        return false;
    }else{
        return true;
    }     
}

/**
* Processes request to make new post creation project
*/
function csv2post_form_create_post_creation_project(){

    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createpostcreationproject'){
        
        global $csv2post_currentproject_code,$csv2post_is_free,$csv2post_projectslist_array;
        
        // if no project name
        if(!isset($_POST['csv2post_projectname_name']) || $_POST['csv2post_projectname_name'] == NULL || $_POST['csv2post_projectname_name'] == '' || $_POST['csv2post_projectname_name'] == ' '){
            csv2post_notice('No project name was entered, please try again','error','Large','Project Name Required','','echo');    
            return false;
        }
        
        // if no database table selected
        if(!isset($_POST['csv2post_databasetables_array'])){
            csv2post_notice('You did not select any database tables for taking data from and putting into posts. Project was not created.','info','Large','Database Table Selection Required','','echo');    
            return false;
        }else{
            
            // carry out project table resets
            if(isset($_POST['csv2post_databasetables_resettable_array'])){

                if($csv2post_is_free){
                    
                    // does user want posts deleted also? Requires the same table to be selected 
                    if(isset($_POST['csv2post_databasetables_resetposts_array']) && $_POST['csv2post_databasetables_resetposts_array'] == $_POST['csv2post_databasetables_resettable_array']){
                        $reset_posts = true;
                        $reset_posts_notice = ' All posts related to the project table have been deleted also.';    
                    }else{
                        $reset_posts = false;
                    }
    
                    csv2post_WP_SQL_reset_project_table($_POST['csv2post_databasetables_resettable_array'],$reset_posts);
                    csv2post_notice('The table named '.$_POST['csv2post_databasetables_resettable_array'].' was reset as requested.','success','Large','Table Reset','','echo');                    
                
                }else{
                    foreach($_POST['csv2post_databasetables_resettable_array'] as $key => $table_name){
                        
                        // does user also want this tables posts deleted
                        if(isset($_POST['csv2post_databasetables_resetposts_array'])){
                            $reset_posts = false;
                            foreach($_POST['csv2post_databasetables_resetposts_array'] as $key => $t){
                                if($t == $_POST['csv2post_databasetables_resettable_array']){
                                    $reset_posts = true;    
                                }    
                            }
                        }
                        
                        csv2post_WP_SQL_reset_project_record($table_name,$reset_posts);
                        csv2post_notice('The table named '.$table_name.' was reset as requested.','success','Large','Table Reset','','echo');    
                    }  
                } 
            }
            
            // free edition does not allow mapping method selection on form
            if(isset($_POST['csv2post_projecttables_mappingmethod_inputname']) && !$csv2post_is_free){
                $mapping_method = $_POST['csv2post_projecttables_mappingmethod_inputname'];    
            }else{
                $mapping_method = 'defaultorder';
            }

            // free edition will submit selected database table as string, not array, make array for rest of plugins use
            if(!is_array($_POST['csv2post_databasetables_array'])){
                $tables_array = array($_POST['csv2post_databasetables_array']);// we add the single table name to an array in free edition                                
            }else{
                $tables_array = $_POST['csv2post_databasetables_array'];// paid edition value will already be an array
            }

            // create project function will return project code on success
            $createproject_result_code = csv2post_create_post_creation_project($_POST['csv2post_projectname_name'],$tables_array,$mapping_method);
            if($createproject_result_code){
                        
                // now set the new project as the Current Project ($csv2post_currentproject_code)               
                $csv2post_currentproject_code = $createproject_result_code;
                csv2post_update_currentproject($createproject_result_code);
                
                // do notification
                csv2post_notice('Your new Post Creation Project has been made. Please click on the Content Designs tab and create your main content layout for this project or select an existing one.','success','Large','Post Creation Project Created');
            
                // display next step message
                if(!$csv2post_is_free){
                    $table_count = count($_POST['csv2post_databasetables_array']);
                    if($table_count != 1){
                        csv2post_notice('You must now complete the Multiple Tables Project panel on the Projects screen.','step','Large','Next Step','','echo');    
                    }
                }
            
            }else{
                
                if($csv2post_is_free){
                    csv2post_notice('You have already created your project. The free edition 
                    allows one project at a time, please complete your post creation then delete the 
                    project. You may then create another project with a new database table that holds 
                    different data.','warning','Large','Post Creation Project Not Created','','echo');    
                }else{  
                    csv2post_notice('A problem was detected when making the new Post Creation Project. 
                    It is recommended that you attempt to make the project again and report this 
                    problem if it continues to happen.','error','Large','Post Creation Project Not Created');    
                }
            }  
        }
        
        return false;
    }else{
        return true;
    }     
}  

function csv2post_form_delete_persistentnotice(){
    if(isset($_POST['csv2post_post_deletenotice']) && $_POST['csv2post_post_deletenotice'] == true){
         
        global $csv2post_persistent_array;

        foreach($csv2post_persistent_array['notifications'] as $key => $notice){
            if($notice['id'] == $_POST['csv2post_post_deletenotice_id']){
                unset($csv2post_persistent_array['notifications'][$key]);
            }            
        }
        
        csv2post_option('csv2post_notifications','update',$csv2post_persistent_array);        
                  
        return false;
    }else{
        return true;
    }     
}          

/**
* Process CSV file upload      
*/
function csv2post_form_upload_csv_file(){
    global $csv2post_projectslist_array,$csv2post_schedule_array,$csv2post_plugintitle;
    
    if(isset($_POST['csv2post_post_uploadcsvfile']) && $_POST['csv2post_post_uploadcsvfile'] == true){
        
        $upload = $_FILES['file'];  

        if(!strstr($upload['name'],'.csv')){
            csv2post_notice('Sorry but '.$csv2post_plugintitle.' only accepts CSV files with .csv extension right now.','error','Large','File Extension Not Allowed','','echo');
            return false;
        }
        
        // check error
        if($upload['error'] != 0){
            csv2post_notice('Your file was not uploaded, the error code is ' . $upload['error'],'error','Large','Upload Failed');
            return false;// not returning false due to failure, only returning false to indicate end of processing            
        }     
        
        // ensure file destination exists
        $open_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        if(!$open_result){
            csv2post_notice('File was not uploaded. Could not open the destination folder. The folder is named wpcsvimportercontent and should be in the wp-content directory. Please fix this before trying again.','error','Large','File Not Upload');
            return false;
        }

        // check if filename already exists in destination - we will let the user know they wrote over an existing file
        $target_file_path =  WTG_C2P_CONTENTFOLDER_DIR . '/' . $upload['name'];
        $target_file_path_exists = file_exists( $target_file_path );
        if($target_file_path_exists){
            // get existing files datestamp - we use it to ensure the new file is newer/changed and trigger data update
            $oldtime = filemtime( $target_file_path );
                    
            // delete the existing file
            unlink( $target_file_path );
            
            if ( file_exists( $target_file_path )){
                csv2post_notice('The name of your file being uploaded already exists in the target folder. '.$csv2post_plugintitle.' could not remove the existing file, but it should have. It may be because the existing file is in use, please investigate this then try again if required. If some sort of permissions problem is causing this, you may delete the existing file using FTP also.','error','Large','Existing File Not Removed');    
                // return now due to not being able to remove the existing file
                return false;
            }
            
            // file must not exist, unlink was success, let user know this was done
            csv2post_notice('The file name being uploaded existed already. The existing file was replaced.','info','Large','File Replaced');        
        }
        
        // now move temp file into target path
        $move_result = move_uploaded_file( $upload['tmp_name'], $target_file_path );
        
        // did the move fail
        if(!$move_result){
            csv2post_notice('Failed to upload file, there was a problem moving the temporary file into the target directory, please investigate this issue.','error','Large','Upload Failed');
            return false;
        }
        
        // check that file is now in place
        if(!file_exists($target_file_path)){
            csv2post_notice('The server confirmed that the file was uploaded and put into the target 
            directory but it could not be located when confirming it. Please report this problem.','error','Large','Uploaded File Missing');
            return;
        }
        
        // upload is a success
        csv2post_notice('CSV file has been uploaded, you should now create a Data Import Job and select your new uploaded file.','success','Large','CSV File Uploaded');

        return false;
    }else{
        return true;
    }      
}

/**
* Create users in post creation project
*/
function csv2post_form_save_createusers_postproject(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createauthors'){

        global $csv2post_project_array,$csv2post_currentproject_code;

        // if email column not submitted
        if(!isset($_POST['csv2post_createusers_emailcolumn'])){
            csv2post_notice('Email address data is always required for creating Wordpress users. Please select your email address column.',
            'error','Large','No Email Data Selected','','echo');
            return false; 
        }
        
        ### TODO:LOWPRIORITY, check the email address data and ensure it is valid email address. This is to avoid issues during post creation
        
        // store email column and table
        $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_createusers_emailcolumn']);
        $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_createusers_emailcolumn']);
                    
        $csv2post_project_array['authors']['createusers']['emails']['table'] = $table_name;            
        $csv2post_project_array['authors']['createusers']['emails']['column'] = $column_name;
                
        // if username column submitted (optional)
        if(isset($_POST['csv2post_createusers_usernamecolumn'])){
            
            $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_createusers_usernamecolumn']);
            $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_createusers_usernamecolumn']);
                        
            $csv2post_project_array['authors']['createusers']['usernames']['table'] = $table_name;            
            $csv2post_project_array['authors']['createusers']['usernames']['column'] = $column_name;
        }        
            
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        csv2post_notice('Yourates.',
        'success','Large','Answers Saved','','echo');
           
        return false;
    }else{
        return true;
    }       
}  

/**
* Deletes one or more CSV files 
*/
function csv2post_form_delete_csvfile(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deletecsvfiles'){
        
        // if no csv file selected
        if(!isset($_POST['csv2post_delete_csvfiles']) || count($_POST['csv2post_delete_csvfiles']) == 0){
            csv2post_notice('No CSV files were selected, please try again.','error','Large','No CSV File Selected','','echo');
            return false;
        }

        $file_is_in_use = false;
        
        // loop through selected CSV files
        foreach($_POST['csv2post_delete_csvfiles'] as $key => $csv_file_name){
            $file_is_in_use = csv2post_is_csvfile_in_use($csv_file_name);
            
            // if file is in use
            if($file_is_in_use){
                csv2post_notice('The file named ' . $csv_file_name .' is in use. Please delete any data import job or project using the file before attempting to delete it.','warning','Small','File In Use','','echo');
            }else{
                unlink(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csv_file_name); 
                csv2post_notice( $csv_file_name .' Deleted','success','Small','','','echo');
            }
        }

        return false;
    }else{
        return true;
    }       
}      

/**
* Saves featured image table and column
*/
function csv2post_form_featuredimage(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'featuredimages'){

        global $csv2post_project_array,$csv2post_currentproject_code;

        $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_featuredimage_columnandtable']);
        $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_featuredimage_columnandtable']);            

        $csv2post_project_array['images']['featuredimage']['table'] = $table_name;            
        $csv2post_project_array['images']['featuredimage']['column'] = $column_name;
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 

        csv2post_notice('Your featured image column has been saved.','success','Large','Featured Images','','echo');
                 
        return false;
    }else{
        return true;
    }       
}          
  
/**
* Saves default author 
*/
function csv2post_form_save_default_author(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'defaultauthor'){
        global $csv2post_project_array,$csv2post_currentproject_code;

        if($_POST['csv2post_defaultauthor_select'] == 'notselected' || !is_numeric($_POST['csv2post_defaultauthor_select'])){
            csv2post_notice('You did not select an author, please try again.','error','Large','No Author Selected','','echo');
            return false;
        }

        $csv2post_project_array['authors']['defaultauthor'] = $_POST['csv2post_defaultauthor_select'];
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 

        csv2post_notice('Your have saved a default author.','success','Large','Default Author Saved','','echo');
         
        return false;
    }else{
        return true;
    }       
} 
  
/**
* Save Ultimate Taxonomy Manager category settings
*/
function csv2post_form_save_ultimatetaxonomymanager_categories(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ultimatetaxonomymanagercategories'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        // get and loop through ultimate taxonomy manager taxonomy fields 
        ### TODO:LOWPRIORITY, change this to only cycle through category related custom fields and do the same with the interface in categories screen        
        $catfields = csv2post_WP_SQL_ultimatetaxonomymanager_taxonomyfield();### TODO:LOWPRIORITY, change this to a function that gets category related custom fields only
        if(!$catfields){
            
            echo csv2post_notice('You have not used Ultimate Taxonomy Manager to create any custom taxonomy fields yet.','info','Large','No Custom Taxonomy Fields','','return');
            return false;
            
        }else{    
          
            // loop 5 times for five levels of categories
            for($i = 1; $i < 6; $i++){
                
                // now loop through category fields
                foreach ($catfields as $catfield){

                    // did user make selection for current field and current category level
                    if(isset($_POST['csv2post_utm_categorylevel'.$i.'_'.$catfield->field_name])){
                    
                        $csv2post_project_array['categories']['level'.$i]['utm'][$catfield->field_name]['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_utm_categorylevel'.$i.'_'.$catfield->field_name]);
                        $csv2post_project_array['categories']['level'.$i]['utm'][$catfield->field_name]['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_utm_categorylevel'.$i.'_'.$catfield->field_name]);            
   
                    }
                }
            } 
        
        }  
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 

        csv2post_notice('You have saved category taxonomy settings for using with Ultimate Taxonomy Manager plugin.',
        'success','Large','Ultimate Taxonomy Manager Category Settings Saved','','echo');
        
        return false;
    }else{
        return true;
    }       
}       
  
/**
* Save title data column
*/
function csv2post_form_save_title_data_column(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'titlecolumn'){
        global $csv2post_project_array,$csv2post_currentproject_code;

        $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_titlecolumn_menu']);
        $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_titlecolumn_menu']);            

        $csv2post_project_array['posttitles']['table'] = $table_name;            
        $csv2post_project_array['posttitles']['column'] = $column_name;       

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('The column holding post titles data has been saved. The plugin will only use this
        column and will not use any title templates you may have setup.','success','Large','Post Titles Column Saved','','echo');
                
        return false;
    }else{
        return true;
    }       
}      
 
/**
* Creates categories 
*/
function csv2post_form_create_categories(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createallcategories'){
        global $csv2post_is_free;
        
        // if is premium/paid edition 
        if(!$csv2post_is_free){
            csv2post_create_categories_advanced();
        }else{
            csv2post_create_categories_basic();
        }
        
        csv2post_notice('Category creation has finished. This notification does not take the 
        result into account, it is only to let you know that processing categories has ended.',
        'info','Large','Category Creation Ended','','echo');
                
        return false;
    }else{
        return true;
    }       
}  
  
/**
* Manual data import
*/
function csv2post_form_importdata(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_importdatarequest_postmethod']) && $_POST['csv2post_importdatarequest_postmethod'] == 'true'){
        global $csv2post_is_free;
        
        // if job code not in $_POST
        if(!isset($_POST['csv2post_importdatarequest_jobcode']) || $_POST['csv2post_importdatarequest_jobcode'] == NULL || !is_string($_POST['csv2post_importdatarequest_jobcode'])){
            csv2post_notice('A data import job code was not found in the submitted form data, no import could be started.','error','Large','No Job Code Submitted','','echo');
            return false;
        }
        
        $job_code = $_POST['csv2post_importdatarequest_jobcode'];
        
        // if no csv file value in $_POST
        if(!isset($_POST['csv2post_importselection_csvfiles'])){
            csv2post_notice('No CSV file name could be found in the submitted post data, no import could be carried out.','error','Large','No CSV Filename Found','','echo');    
            return false;
        }
        
        // get filename (currently preparing for multiple file import at once so we are submitting an array) 
        $file_name = $_POST['csv2post_importselection_csvfiles'][0];

        // set row number
        $row_number = 1;
        if($csv2post_is_free){
            $row_number = 9999999;    
        }elseif(!isset($_POST['csv2post_dataimport_rownumber_'.$job_code]) || !is_numeric($_POST['csv2post_dataimport_rownumber_'.$job_code])){
            csv2post_notice('No row number for import was submitted so only 1 record will be imported from '.$file_name.'.csv.','warning','Large','No Rows Number Submitted','','echo');    
        }elseif(isset($_POST['csv2post_dataimport_rownumber_'.$job_code]) && is_numeric($_POST['csv2post_dataimport_rownumber_'.$job_code])){
            $row_number = $_POST['csv2post_dataimport_rownumber_'.$job_code];        
        }
 
        // perform data import
        $overall_result = 'success';
        $dataimportjob_array = csv2post_data_import_from_csvfile_basic($file_name,'csv2post_'.$job_code,$row_number,$job_code);
        
        // determine new $overall_result and apply styling to the main notice to suit it
        if($dataimportjob_array == false){
            $overall_result = 'error';
        }
        
        // decide message text
        if($csv2post_is_free){
            $intromes = '';
        }else{
            $intromes = '<p>You requested '.$row_number.' row/s to be imported from '.$file_name.'.</p>';    
        }
        
        // display result    
        csv2post_notice( '<h4>Data Import Result<h4>'.$intromes.'
        '.csv2post_notice( 'New Records: '.$dataimportjob_array["stats"]["lastevent"]['inserted'],'success','Small',false,'www.csv2post.com/notifications/new-records-count','return').'
        '.csv2post_notice( 'Void Records: '.$dataimportjob_array["stats"]["lastevent"]['void'],'info','Small',false,'www.csv2post.com/notifications/void-records-counter','return').'
        '.csv2post_notice( 'Dropped Rows: '.$dataimportjob_array["stats"]["lastevent"]['dropped'],'warning','Small',false,'www.csv2post.com/notifications/dropped-rows-counter','return').'
        '.csv2post_notice( 'Rows Processed: '.$dataimportjob_array["stats"]["lastevent"]['processed'],'info','Small',false,'www.csv2post.com/notifications/rows-processed-counter','return').'     
        '.csv2post_notice( 'Job Progress: '.$dataimportjob_array["stats"]["allevents"]['progress'],'info','Small',false,'www.csv2post.com/notifications/job-progress-counter','return').'    
        ',$overall_result,'Extra','','','echo'); 

        return false;
    }else{
        return true;
    }     
}
  
/**
* Create a data rule for replacing specific values after import 
*/
function csv2post_form_create_datarule_replacevalue(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'replacevalues'){
        global $csv2post_currentjob_code;

        echo '<p>UNDER CONSTRUCTION</p>';

        return false;
    }else{
        return true;
    }          
} 

/**
* Saves tag rules submission
*/
function csv2post_form_save_tag_rules(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'tagrules'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        // save numeric allow/disallow setting
        if(isset($_POST['csv2post_numerics'])){
            $csv2post_project_array['tags']['rules']['numericterms'] = $_POST['csv2post_numerics'];    
        }
        
        // save excluded terms
        if(isset($_POST['csv2post_excludedtag']) && is_string($_POST['csv2post_excludedtag'])){
            
            // if there are already excluded terms, we need to put them into string for joining to new submission
            $old_string = '';
            if(isset($csv2post_project_array['tags']['rules']['excluded']) && is_array($csv2post_project_array['tags']['rules']['excluded'])){
                $old_string = implode($csv2post_project_array['tags']['rules']['excluded']);
            }
            
            $new_string = $_POST['csv2post_excludedtag'] . ',' . $old_string;
            
            $csv2post_project_array['tags']['rules']['excluded'] = explode(',',$new_string);   
        }
        
        // save tags per post
        if(isset($_POST['csv2post_tagsperpost']) && is_numeric($_POST['csv2post_tagsperpost'])){
            $csv2post_project_array['tags']['rules']['tagsperpost'] = $_POST['csv2post_tagsperpost'];    
        }
        
        // save tag string length
        if(isset($_POST['csv2post_tagstringlength']) && is_numeric($_POST['csv2post_tagstringlength'])){
            $csv2post_project_array['tags']['rules']['tagstringlength'] = $_POST['csv2post_tagstringlength'];    
        }
        
        // delete tags
        if(isset($_POST['csv2post_tagslist_delete'])){
            foreach($_POST['csv2post_tagslist_delete'] as $key => $delete_tag){
                ### TODO:HIGHPRIORITY, establish the best way to locate the tags in array and unset them    
            }
        }       

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Tag rules have been saved.','success','Large','Tag Rules/Settings Saved','','echo');
                
        return false;
    }else{
        return true;
    }          
} 

/**
* Saves advanced tag generator settings 
*/
function csv2post_form_save_tag_generator_settings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'generatetags'){
        global $csv2post_project_array,$csv2post_currentproject_code,$csv2post_plugintitle;
      
        if(!isset($_POST["csv2post_taggenerator_columns"])){
            csv2post_notice('No columns were selected. You must select data columns that hold suitable values for generating tags with.','error','Large','Please Select Columns','','echo');    
            return false;
        }
        
        // loop through selected columns
        foreach($_POST["csv2post_taggenerator_columns"] as $key => $table_column ){
            $csv2post_project_array['tags']['generator']['data'][$key]['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$table_column);
            $csv2post_project_array['tags']['generator']['data'][$key]['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$table_column);            
        }
        
        $csv2post_project_array['tags']['method'] = 'generator';       
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Tag generator settings have been saved and '.$csv2post_plugintitle.' will generator tags from your selected columns for all posts.','success','Large','Tag Generator Settings Saved','','echo');
        
        return false;
    }else{
        return true;
    }          
}

/**
* Resets publish date method to Wordpress default by deleting the "dates" value in project array 
*/
function csv2post_form_set_datemethod_default(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'projectdatemethod'){
        global $csv2post_currentproject_code,$csv2post_project_array;

        unset($csv2post_project_array['dates']['currentmethod']); 
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('The current projects publish dates will be controlled by Wordpress default.','success','Large','Publish Date Method Reset','','echo');      
  
        return false;
    }else{
        return true;
    }          
}

/**
* Deletes one or more database tables
*/
function csv2post_form_drop_database_tables(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createddatabasetableslist'){

        if(!isset($_POST["csv2post_table_array"])){
            csv2post_notice('You did not select any database tables. Check the boxes for the tables you want to delete.','warning','Large','No Tables Deleted','','echo');
            return false;
        }else{
            
            global $wpdb,$csv2post_jobtable_array,$csv2post_dataimportjobs_array;
   
            foreach($_POST["csv2post_table_array"] as $key => $table_name){
                
                // if table is in use by a data import job we do not delete it, the job must be deleted first
                $code = str_replace('csv2post_','',$table_name);   
                
                if(isset($csv2post_dataimportjobs_array[$code])){
                    csv2post_notice('Table named '.$table_name.' is still used by Data Import Job named '.$csv2post_dataimportjobs_array[$code]['name'].'. Please delete the job first then delete the database table.','warning','Large','Cannot Delete ' . $table_name,'','echo');
                }else{
                    
                    csv2post_SQL_drop_dataimportjob_table($table_name); 
                                            
                    csv2post_notice('','success','Small','Database Table Deleted: '.$table_name,'','echo');
                }  
            }
        }

        return false;
    }else{
        return true;
    }          
}

/**
* Deletes basic custom field rules
* @todo HIGHPRIORITY, change to delete many checked boxes at once not just one
*/
function csv2post_form_delete_basiccustomfields(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deletebasiccustomfieldrules'){
        global $csv2post_currentproject_code,$csv2post_project_array;
   
        unset($csv2post_project_array['custom_fields']['basic'][$_POST['csv2post_customfield_rule_arraykey']]);                        
                
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('You have deleted a basic custom field rule, one less meta value will be added to all posts from here on in this project.','success','Large','Basic Custom Field Rule Deleted','','echo');      

        return false;
    }else{
        return true;
    }          
}
  
/**
* Saves and activates incremental publish date settings
* @todo LOWPRIORITY, validate dates 
*/
function csv2post_form_save_incrementalpublishdate_settings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'incrementalpublishdatessettings'){
        global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;
   
        // do not allow save if free edition (bypassing this will cause problems during post creation)
        if($csv2post_is_free){
            csv2post_notice('The data method you submitted can only be used in the paid editions advanced post creation scripts. Your post publish dates will always default to the current time and date when they are created.','warning','Large','Date Method Not Available','','echo');
            return false;
        }
        
        // replace spaces in minutes increment string
        $minutes_increment = str_replace(' ','',$_POST['csv2post_increment_range']);
        $explode = explode('-',$minutes_increment);

        $csv2post_project_array['dates']['currentmethod'] = 'increment'; 
        $csv2post_project_array['dates']['increment']['start'] = $_POST['csv2post_publishdateincrement_start'];
        $csv2post_project_array['dates']['increment']['short'] = $explode[0];
        $csv2post_project_array['dates']['increment']['long'] = $explode[1];                
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Increment publish date settings have been saved. This method of applying publish dates has also been activated. Submit another form if you do not want to activate the incremental publish date method.','success','Large','Incremental Publish Date Settings Saved','','echo');      

        return false;
    }else{
        return true;
    }     
}

/**
* Saves and activates random publish date method settings
* @todo LOWPRIORITY, validate submitted dates, ensure end date is not before start  
*/
function csv2post_form_save_randompublishdate_settings(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'randompublishdatesettings'){
        global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;
      
        // do not allow save if free edition (bypassing this will cause problems during post creation)
        if($csv2post_is_free){
            csv2post_notice('The data method you submitted can only be used in the paid editions advanced post creation scripts. Your post publish dates will always default to the current time and date when they are created.','warning','Large','Date Method Not Available','','echo');
            return false;
        }
              
        $csv2post_project_array['dates']['currentmethod'] = 'random'; 
        $csv2post_project_array['dates']['random']['start'] = $_POST['csv2post_randompublishdate_start'];
        $csv2post_project_array['dates']['random']['end'] = $_POST['csv2post_randompublishdate_end'];

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Random publish date settings have been saved. This method of applying publish dates has also been activated. Submit another form if you do not want to activate the random publish date method.','success','Large','Random Publish Date Settings Saved','','echo');      
  
        return false;
    }else{
        return true;
    }      
}      
  
// Save category mapping (data values too)
function csv2post_form_save_category_mapping(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createcategorymappingrules'){
        global $csv2post_currentproject_code,$csv2post_project_array;
        
        // loop number of set category levels 
        for($lev = 1; $lev <= $_POST['csv2post_category_levels']; $lev++){

            // loop the number of distinct values in the current level i.e. 8 times for 8 distinct values in column
            for($dis = 1; $dis <= $_POST['csv2post_distinct_values_count_lev'.$lev]; $dis++){

                // this holds distinct value
                $_POST['csv2post_distinct_value_lev'.$lev.'_inc'.$dis];    
                // i.e. $_POST['csv2post_distinct_value_lev3_inc8']

                // ensure menu option is not "notselected" and the expected DISTINCT value is not null
                if(isset($_POST['csv2post_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select']) && $_POST['csv2post_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select'] != 'notselected' ){

                    $csv2post_project_array['categories']['level'.$lev]['mapping'][ $_POST['csv2post_distinct_value_lev'.$lev.'_inc'.$dis] ] = $_POST['csv2post_createcategorymapping_lev'.$lev.'_inc'.$dis.'_select'];

                }

            }
   
        }   
 
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Your category mapping has been saved','success','Large','Category Mapping Saved','','echo');

        return false;
    }else{
        return true;
    }      
}     

/**
* Saves default category (ID only)  
*/
function csv2post_form_save_default_category(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'defaultcategory'){
        
        $csv2post_project_array['categories']['default'] = $_POST['csv2post_defaultcategory_select'];

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_notice('Your default category has been saved','success','Large','Default Category Saved','','echo');

        return false;
    }else{
        return true;
    }      
} 
 
/**
* Save default tags column and table 
*/
function csv2post_form_save_default_tags_column(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'premadetagscolumn'){
        
        $csv2post_project_array['tags']['default']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_defaulttagsdata_select_columnandtable']);
        $csv2post_project_array['tags']['default']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_defaulttagsdata_select_columnandtable']);                       
        $csv2post_project_array['tags']['method'] = 'premade';
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        csv2post_notice('Your default tags column has been saved and if the tags are formatted as required by Wordpress they will be added to your posts.','success','Large','Default Tags Column Saved');    
                 
        return false;
    }else{
        return true;
    }      
}
    
/**
* Adds basic custom fields
*/
function csv2post_form_add_basic_custom_field(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createbasiccustomfieldrules'){

        // ensure meta-key was entered ### TODO:LOWPRIORITY, validate meta-key
        if(!isset($_POST['csv2post_key'])){
        
            csv2post_notice('You did not enter a meta-key for your custom field rule, please try again.','error','Large','No Meta-Key Entered');
            
        }else{ 
            
            // extract table name and column name from the string which holds both of them
            $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_customfield_select_columnandtable']);
            $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_customfield_select_columnandtable']);            

            // get last array key for current custom fields if they exist
            if(isset($csv2post_project_array['custom_fields']['basic'])){
                $last_array_key = csv2post_get_array_nextkey($csv2post_project_array['custom_fields']['basic']);
            }else{
                $last_array_key = 0;
            }
            
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['table_name'] = $table_name;
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['column_name'] = $column_name;
            $csv2post_project_array['custom_fields']['basic'][$last_array_key]['meta_key'] = $_POST['csv2post_key'];                        

            // update project option         
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

            csv2post_notice('Your your basic custom field rule has been saved and another meta value will be added to all posts created in this project.','success','Large','Basic Custom Field Rule Saved');    
        }    

        return false;
    }else{
        return true;
    }    
}

/**
* Updates the main date table and column   
*/
function csv2post_form_update_datecolumn(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'postdatescolumn'){
        global $csv2post_currentproject_code,$csv2post_project_array;
        
        // extract table name and column name from the string which holds both of them
        $table_name = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_datecolumn_select_columnandtable']);
        $column_name = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_datecolumn_select_columnandtable']);            
        
        // the selected table-column values have not already been set        
        $csv2post_project_array['dates']['date_column']['table_name'] = $table_name;            
        $csv2post_project_array['dates']['date_column']['column_name'] = $column_name;
        $csv2post_project_array['dates']['currentmethod'] = 'data';
        
        // expected date format - added 30th March 2013
        $csv2post_project_array['dates']['date_column']['format'] = $_POST['csv2post_datecolumn_format'];

        // update project option         
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);

        csv2post_notice('Your date column has been saved and posts publish date will be set using your data.','success','Large','Date Column Saved');    

        return false;
    }else{
        return true;
    }    
}   
  
/**
* Updates title template designs (post type wtgcsvtitle is updated)
*/
function csv2post_form_update_defaultposttype(){
    global $csv2post_currentproject_code,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'defaultposttype'){
   
        if( $_POST['csv2post_defaultpostype_original'] == $_POST['csv2post_radio_defaultpostype']){
            csv2post_notice('You selected the post type that is already set as your projects default, no changes were required.','info','Large','No Changes Required');    
        }else{
            $csv2post_project_array['defaultposttype'] = $_POST['csv2post_radio_defaultpostype'];
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 
            csv2post_notice('Your projects default post type is now '.$csv2post_project_array['defaultposttype'].' and all posts created from here on will be this type.','success','Large','Default Post Type Changed');    
            
            if($csv2post_project_array['defaultposttype'] == 'page'){
                csv2post_notice_postresult('info','New Panel Available','A new panel is available 
                on the Post Types screen to you for creating sub-pages.');
            }
        }

        return false;
    }else{
        return true;
    }    
}

/**
* Updates title template designs (post type wtgcsvtitle is updated)
*/
function csv2post_form_update_titletemplates(){
    global $csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'edittitletemplates'){
 
        if( !isset($_POST['csv2post_titletemplate_total']) || $_POST['csv2post_titletemplate_total'] == 0){
            csv2post_notice('No changes have been made as you do not have any 
            title templates. You must use the Create Title Template panel before using the 
            update feature.','warning','Large','No Changes Made');
            return false;
        }
        
        for ($i = 1; $i <= $_POST['csv2post_titletemplate_total']; $i++) {
            
            // only update the posts for which values have been changed
            if( $_POST['csv2post_titletemplate_design_'.$i] != $_POST['csv2post_titletemplate_design_original_'.$i] ){

                // Update title template post
                $my_post = array();
                $my_post['ID'] = $_POST['csv2post_titletemplate_postid_'.$i];
                $my_post['post_content'] = $_POST['csv2post_titletemplate_design_'.$i];
                $my_post['post_type'] = 'wtgcsvtitle';            
                $my_post['post_category'] = array(0);
                
                // Update the post into the database
                $update_result = wp_update_post( $my_post ); 
                if( csv2post_is_WP_Error($update_result)){
                    csv2post_notice('Wordpress function wp_update_post returns a Wordpress error (WP_Error). This should not happen even if an update was not carried out due to no changes made, that would return 0. Please report this issue. The post ID (custom post type wtgcsvtitle) is '.$_POST['csv2post_titletemplate_postid_'.$i].' and is a Title Template.','error','Large','Error Updating Title Template Named ' . $_POST['csv2post_titletemplate_posttitle_'.$i]);
                }elseif( $update_result == 0){
                    csv2post_notice('Wordpress function wp_update_post returned 0, meaning no update was required as no changes were made. This should not happen, the plugin is meant to avoid attempting an update if the user has not edited a Title Template. Please report this issue.','error','Large','Possible Error Updating Template Title Named ' . $_POST['csv2post_titletemplate_posttitle_'.$i]);                    
                }else{
                    csv2post_notice('Wordpress function wp_update_post updated your Title Template named '.$_POST['csv2post_titletemplate_posttitle_'.$i].' and all projects using the template will continue to use the updated version.','success','Large','Title Template Updated');
                }               
            }
        }
              
        return false;
    }else{
        return true;
    }    
} 
  
/**
* Inserts a new title template (post type wtgcsvtitle)
*/
function csv2post_form_insert_title_template(){
    global $csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createtitletemplates'){
 
        // validate template name
        if(!isset($_POST['csv2post_titletemplate_name']) || $_POST['csv2post_titletemplate_name'] == null || $_POST['csv2post_titletemplate_name'] == ' '){
            csv2post_notice('Please enter a name for your title template so that you can identify it properly','error','Large','Content Template Name Required');        
            return false;// tells this file that $_POST processing is complete
        }

        // validate template design
        if(!isset($_POST['csv2post_titletemplate_title']) || $_POST['csv2post_titletemplate_title'] == null || $_POST['csv2post_titletemplate_title'] == ' '){
            csv2post_notice('Please enter a title template design, you must use column replacement tokens for it to work','error','Large','Content Template Name Required');        
            return false;// tells this file that $_POST processing is complete
        }
         
        // save title template
        $save_result = csv2post_insert_titletemplate($_POST['csv2post_titletemplate_name'],$_POST['csv2post_titletemplate_title']);
        if(csv2post_is_WP_Error($save_result)){
            csv2post_notice('No changes were saved, you did make changes before your submission','warning','Large','No Changes Made');    
        }else{
                     
            // if current project does not yet have a default content template
            $setasdefault = '';
            $template_id = csv2post_get_default_titletemplate_id($csv2post_currentproject_code);
            if(!$template_id){
                // current project has no default content template so we will save the new one as it
                csv2post_update_default_titletemplate($csv2post_currentproject_code,$save_result);
                // link the template to the project by adding csv2post_project_id custom meta field 
                add_post_meta($save_result, 'csv2post_project_id', $csv2post_currentproject_code, false);
                // extend output message to confirm default also set                    
                $setasdefault = ' and it has been set as your current projects default title template.';
            }
                
            csv2post_notice('Your new title template has been saved'.$setasdefault.'.','success','Large','New Title Template Saved');
        }
              
        return false;
    }else{
        return true;
    }    
} 

/**
* Updates current projects default template
*/
function csv2post_form_change_default_contenttemplate(){
    global $csv2post_currentproject_code;
    if(isset($_POST['csv2post_change_default_contenttemplate']) && isset($_POST['csv2post_templatename_and_id'])){
  
        // extract template id from string
        $template_id = csv2post_PHP_STRINGS_get_between_two_values('(',')',$_POST['csv2post_templatename_and_id']);        

        if(!is_numeric($template_id)){
            csv2post_notice('The template ID could not be extracted from the submission, please try again then report this issue.','error','Large','Error Saving Default Content Template');
        }else{
            
            // link the template to the project by adding csv2post_project_id custom meta field 
            add_post_meta($template_id, 'csv2post_project_id', $csv2post_currentproject_code, false);
                        
            csv2post_update_default_contenttemplate($csv2post_currentproject_code,$template_id);
            csv2post_notice('The template you selected has been saved as your current projects default template design.','success','Large','Default Content Template Saved');
        }
        
        return false;
    }else{
        return true;
    }    
}

function csv2post_form_change_default_titletemplate(){
    global $csv2post_currentproject_code;
    if(isset($_POST['csv2post_change_default_titletemplate']) && isset($_POST['csv2post_templatename_and_id'])){
  
        // extract template id from string
        $template_id = csv2post_PHP_STRINGS_get_between_two_values('(',')',$_POST['csv2post_templatename_and_id']);        

        if(!is_numeric($template_id)){
            csv2post_notice('The title template ID (also post id) could not be extracted from the submission, please try again then report this issue.','error','Large','Error Saving Default Title Template');
        }else{
            // link the template to the project by adding csv2post_project_id custom meta field 
            add_post_meta($template_id, 'csv2post_project_id', $csv2post_currentproject_code, false);
                        
            csv2post_update_default_titletemplate($csv2post_currentproject_code,$template_id);
            csv2post_notice('The title template you selected has been saved as your current projects default template design.','success','Large','Default Title Template Saved');
        }
        
        return false;
    }else{
        return true;
    }    
} 

function csv2post_form_change_default_excerpttemplate(){
    global $csv2post_currentproject_code;
    if(isset($_POST['csv2post_change_default_excerpttemplate']) && isset($_POST['csv2post_change_default_excerpttemplate'])){
  
        // extract template id from string
        $template_id = csv2post_PHP_STRINGS_get_between_two_values('(',')',$_POST['csv2post_templatename_and_id']);        

        if(!is_numeric($template_id)){
            csv2post_notice('The excerpt template ID could not be extracted from the submission, please try again then report this issue.','error','Large','Error Saving Default Excerpt Template');
        }else{
            
            // link the template to the project by adding csv2post_project_id custom meta field 
            add_post_meta($template_id, 'csv2post_project_id', $csv2post_currentproject_code, false);
                            
            csv2post_update_default_excerpttemplate($csv2post_currentproject_code,$template_id);
            csv2post_notice('The excerpt template you selected has been saved as your current projects default excerpt template design.','success','Large','Default Excerpt Template Saved');
        }
        
        return false;
    }else{
        return true;
    }    
}    
  
/**
* Saves content template design - new or old (update or insert), will create new post or update existing one.
* Design ID is also Wordpress post ID 
* @todo LOWPRIORITY, consider using custom taxonomies (categories) for applying template types
*/
function csv2post_form_save_contenttemplate(){  
    global $csv2post_currentproject_code;// TODO ADD THIS TO POST IN CUSTOM FIELD
    
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'templateeditor'){
        
        // if we change this variable it causes new wtgcsvtemplate post to be created
        $create_new_wtgcsvtemplate_post = false;
                              
        // has a template design id been submitted, if so then the user is editing an existing design after opening it                                                                                                                                                                                                                                                 
        if(isset($_POST['csv2post_templateid']) && is_numeric($_POST['csv2post_templateid'])){
          
            // the user may want a design to be created from the previous, this is done by changing the template design name
            if($_POST["csv2post_templatename"] == $_POST["csv2post_templatename_previous"]){
             
                // update existing design using design ID (post_id for wtgcsvcontent custom post type)
                $my_post = array();
                $my_post['ID'] = $_POST['csv2post_templateid'];
                $my_post['post_type'] = 'wtgcsvcontent';
                $my_post['post_title'] = $_POST['csv2post_templatename'];            
                $my_post['post_content'] = $_POST['csv2post_wysiwyg_editor'];
                $my_post['post_category'] = array(0);
                
                // Update the post into the database
                $wp_update_post_result = wp_update_post( $my_post );

                // nothing further needs to be done
                return false;                
                
            }else{
           
                // the user has changed the template name, this is how the user forces new template to be created
                $create_new_wtgcsvtemplate_post = true;                  
            }
            
        }else{       
            // no existing id in the $_POST, create new template
            $create_new_wtgcsvtemplate_post = true;            
        }
              
        if($create_new_wtgcsvtemplate_post){   
                  
            $wpinsertpost_result = csv2post_insert_post_contenttemplate($_POST['csv2post_wysiwyg_editor'],$_POST['csv2post_templatename']);// returns post ID
              
            if(!$wpinsertpost_result || csv2post_is_WP_Error($wpinsertpost_result) || $wpinsertpost_result == 0 ){
                csv2post_notice('Could not create new content template design. It requires the insertion of a new post record but Wordpress returned an error. Please try again then report further problems.','error','Large','Could Not Save Template');
            }elseif(is_numeric($wpinsertpost_result)){
                
                // link the template to the project by adding csv2post_project_id custom meta field 
                add_post_meta($wpinsertpost_result, 'csv2post_project_id', $csv2post_currentproject_code, false);
        
                // add design type/s to posts meta
                if(isset($_POST["csv2post_designtype"]) && is_array($_POST["csv2post_designtype"])){

                    $count = count($_POST["csv2post_designtype"]);
                    if($count > 1){
                        
                        $first = true;
                        foreach($_POST["csv2post_designtype"] as $key => $type){
                            add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', $type, false);   
                        }
    
                    }else{   
                      
                        add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', $_POST["csv2post_designtype"][0], false);

                        // if a single post type selected, set template as the default for the type selected
                        // excerpt
                        if($_POST["csv2post_designtype"][0] == 'postexcerpt'){
                                                 
                            $setasdefault = '';
                            $template_id = csv2post_get_default_excerpttemplate_id($csv2post_currentproject_code);
                            if(!$template_id){

                                // current project has no default content template so we will save the new one as it
                                csv2post_update_default_excerpttemplate($csv2post_currentproject_code,$wpinsertpost_result);
                                                   
                                // extend output message to confirm default also set                    
                                $setasdefault = ' and it has been set as your current projects default excerpt template.';
                            }                                
                        }                
                    }
             
                }else{
                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'postcontent',false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'customfieldvalue', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'categorydescription', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'postexcerpt', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'keywordstring', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'dynamicwidgetcontent', false);                    
                    add_post_meta($wpinsertpost_result, '_csv2post_templatetypes', 'seovalue', false);
                }
           
                // if current project does not yet have a default content template we will use this one
                $setasdefault = '';
                $template_id = csv2post_get_default_contenttemplate_id($csv2post_currentproject_code);
                if(!$template_id){
                     
                    // current project has no default content template so we will save the new one as it
                    csv2post_update_default_contenttemplate($csv2post_currentproject_code,$wpinsertpost_result);
                                       
                    // extend output message to confirm default also set                    
                    $setasdefault = ' and it has been set as your current projects default content template.';
                }
                                
                csv2post_notice('Your new content template has been saved'.$setasdefault.'. You can select it in your projects settings and edit it using the same editor as you created it with.','success','Large','New Template Saved');
            }            
        }
        
        return false;
    }else{
        return true;
    }    
}  
    
/**
* Changes the CURRENT PROJECT so that the user may change settings
*/
function csv2post_form_change_current_project(){
    global $csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'selectcurrentproject'){
        if( $_POST['csv2post_radio_projectcode'] == $csv2post_currentproject_code){
            csv2post_notice('You submitted the same project as the one already set as your Current Project. No changes were made.','info','Large','No Changes Made');    
        }else{
            csv2post_update_currentproject($_POST['csv2post_radio_projectcode']);
            csv2post_notice('Your current project has been changed and you will not be working on project '.$_POST['csv2post_radio_projectcode'].'.','success','Large','Project Changed');            
        }
        return false;
    }else{
        return true;
    }    
}    

/**
* Deletes one or more post creation projects from $_POST submission
*/
function csv2post_form_delete_post_creation_projects(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'deleteprojects'){
        global $csv2post_is_free,$csv2post_currentproject_code;
        
        if(!$csv2post_is_free && !isset($_POST['csv2post_projectcodes_array'])){
            csv2post_notice('You did not select projects for deletion, no changes have been made.','info','Large','No Projects Deleted');    
        }else{
            
            if($csv2post_is_free){
                
                //free edition has one project, so we can use $csv2post_currentproject_code
                // Do not try to get around this limitation, required functions for later processes are not included with the free download
                csv2post_delete_postcreationproject($csv2post_currentproject_code);
                csv2post_delete_option_currentprojectcode();
                csv2post_notice('Your project with code '.$csv2post_currentproject_code.' has been deleted.','success','Large','Project ('.$csv2post_currentproject_code.') Deleted');                

            }else{
                
                foreach($_POST['csv2post_projectcodes_array'] as $key => $project_code){
                    
                    // if  $csv2post_currentprojectcode equals the project being deleted, then delete current project option
                    if($csv2post_currentproject_code == $project_code){
                        csv2post_delete_option_currentprojectcode();   
                    }
                    
                    csv2post_delete_postcreationproject($project_code);
                    csv2post_notice('Your project with code '.$project_code.' has been deleted.','success','Large','Project '.$project_code.' Deleted');    
                }
                
            }
        }
        return false;
    }else{
        return true;
    }    
}    

/**
* Processes request to delete multiple data import jobs selected on Start tab 
*/
function csv2post_form_delete_dataimportjobs(){
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'data' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'deletedataimportjob'){
        if(!isset($_POST['csv2post_jobcode_array'])){
            csv2post_notice('You did not select any data import jobs for deletion, no changes have been made.','info','Small');    
        }else{
            global $csv2post_currentjob_code;
            
            // loop through submitted job codes 
            foreach( $_POST['csv2post_jobcode_array'] as $jobcode ){
                
                // if job being deleted equals the current job, delete the option record for current job
                if($jobcode == $csv2post_currentjob_code){
                    csv2post_delete_option_currentjobcode();
                }
                
                $deletejob_result = csv2post_delete_dataimportjob_postrequest($jobcode,true);
            }
        }
        return false;
    }else{
        return true;
    }     
}  

/**
* Creates data import job
* @todo HIGHPRIORITY, failure still shows SUCCESS GREEN notification, improve the failure line to show RED ERROR notification
*/
function csv2post_form_createdataimportjob(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'data' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createdataimportjobcsvfiles'){
        global $csv2post_is_free,$csv2post_plugintitle;
        
        // warn user when they do not submit parts of the profile
        if(!isset($_POST['csv2post_jobname_name'])){
            csv2post_notice('You did not enter a Job Name, please try again.','error','Large','No Job Name Entered','','echo');
            return false;    
        }
    
        if(isset($_POST['csv2post_newjob_included_csvfiles'])){
            foreach($_POST['csv2post_newjob_included_csvfiles'] as $key => $csvfile_name){ 
            
                // remove .csv from filename
                $filename = str_replace('.csv','',$csvfile_name);
                                       
                // if user did not enter field count
                if(!isset($_POST['csv2post_csvfile_fieldcount_' . $filename]) || $_POST['csv2post_csvfile_fieldcount_' . $filename] == ''){
                    csv2post_notice('You did not enter your CSV file column/field number. '.$csv2post_plugintitle.' will attempt to 
                    count them but if you experience problems please enter the number manually.','warning','Large','Column Count Not Entered','','echo');    
                }
                
                // if user did not select separator
                if(!isset($_POST['csv2post_newjob_separators' . $filename])){
                    csv2post_notice('You never selected a separator. The plugin will attempt to guess it but if you
                    experience problems you should select it manually.','warning','Large','No Separator Selected','','echo');
                }
                
                // if user did not select quote
                if(!isset($_POST['csv2post_newjob_quote' . $filename])){
                    csv2post_notice('You never selected a quote. The plugin will attempt to guess it but if you
                    experience problems please select it manually.','warning','Large','No Quote Selected','','echo');
                }            
            }      
        }

        // set variable for building output html
        $extendednotice = '';
        
        // set function boolean outcome (used at end to display notification for success or fail)
        $functionoutcome = false;
        
        $importjobname_validate_result = csv2post_validate_dataimportjob_name($_POST['csv2post_jobname_name']);
        
        if($importjobname_validate_result){
            
            if(isset($_POST['csv2post_newjob_included_csvfiles'])){
                
                // generate job code (used to name database table and option record for job history) 
                $code = csv2post_create_code(6); 
        
                // create an array for the job, to be stored in an option record of its own
                $jobarray = csv2post_create_jobarray($_POST['csv2post_jobname_name'],$code);
                $jobarray['jobname'] = $_POST['csv2post_jobname_name'];

                // determine if this is a multi file job or single
                if($csv2post_is_free){
                    $job_file_group = 'single';// free edition does not allow multiple files    
                }else{
                    // count the number of files submitted
                    $numbers_of_files = count($_POST['csv2post_newjob_included_csvfiles']);
                    if($numbers_of_files > 1){
                        $job_file_group = 'multiple';    
                    }else{
                        $job_file_group = 'single';
                    }
                }

                // add established file group type to the array (no use for it as I add it but adding it just in case)                
                $jobarray['filegrouping'] = $job_file_group;
                                   
                // count files, counter acts as file id within the job array, it is also appended to column names 
                $fileid = 1;
                 
                // add each csv file to the jobarray
                // we add more default stats here, while we are doing the                            
                foreach($_POST['csv2post_newjob_included_csvfiles'] as $key => $csvfile_name){
                    
                    // add the file with the $fileid as key, $fileid is simple integer number beginning from 1
                    $jobarray['files'][$fileid] = $csvfile_name;
                                        
                    // we need first part of filename for appending in $_POST submissions
                    $fileChunks = explode(".", $csvfile_name);

                    // establish separator
                    if(isset($_POST['csv2post_newjob_separators' . $fileChunks[0]])){
                        $jobarray[$csvfile_name]['separator'] = $_POST['csv2post_newjob_separators' . $fileChunks[0]];        
                    }else{
                        $jobarray[$csvfile_name]['separator'] = csv2post_get_file_separator($csvfile_name,$fileid);
                    }
                    
                    // establish quote
                    if(isset($_POST['csv2post_newjob_quote' . $fileChunks[0]])){
                        
                        if($_POST['csv2post_newjob_quote' . $fileChunks[0]] == 'doublequote'){
                            $jobarray[$csvfile_name]['quote'] = '"';    
                        }elseif($_POST['csv2post_newjob_quote' . $fileChunks[0]] == 'singlequote'){
                            $jobarray[$csvfile_name]['quote'] = "'";
                        }else{
                            $jobarray[$csvfile_name]['quote'] = '"';
                        }
                                
                    }else{
                        $jobarray[$csvfile_name]['quote'] = csv2post_get_file_quote($csvfile_name,$fileid,'PEAR');
                    }                     
   
                    // establish number of fields/columns - we need seperator at least to do this if user never submitted integer value
                    if(isset($_POST['csv2post_csvfile_fieldcount_'.$fileChunks[0]]) && is_numeric($_POST['csv2post_csvfile_fieldcount_'.$fileChunks[0]])){
                        $jobarray[$csvfile_name]['fields'] = $_POST['csv2post_csvfile_fieldcount_'.$fileChunks[0]];    
                    }else{
                        $jobarray[$csvfile_name]['fields'] = csv2post_establish_csvfile_fieldnumber($csvfile_name,$jobarray[$csvfile_name]['separator']);
                    }   
                    
                    // add job stats for the file, required for multiple file jobs
                    $jobarray['stats'][$csvfile_name]['progress'] = 0;
                    $jobarray['stats'][$csvfile_name]['inserted'] = 0;    
                    $jobarray['stats'][$csvfile_name]['updated'] = 0;
                    $jobarray['stats'][$csvfile_name]['deleted'] = 0;
                    $jobarray['stats'][$csvfile_name]['void'] = 0;    
                    $jobarray['stats'][$csvfile_name]['dropped'] = 0;    
                    $jobarray['stats'][$csvfile_name]['duplicates'] = 0;                    
                    $jobarray['stats'][$csvfile_name]['rows'] = csv2post_count_csvfilerows($csvfile_name);                    

                    // also add an array of each files headers with the file as key
                    $jobarray[$csvfile_name]['headers'] = csv2post_get_file_headers_formatted($csvfile_name,$fileid,$jobarray[$csvfile_name]['separator'],$jobarray[$csvfile_name]['quote'],$jobarray[$csvfile_name]['fields']);
                     
                    // count total rows
                    $jobarray['totalrows'] = $jobarray['totalrows'] + $jobarray['stats'][$csvfile_name]['rows'];
                    ++$fileid;                        
                }

                $result = csv2post_update_dataimportjob($jobarray,$code);
                if($result){
                    
                    // set global $csv2post_currentjob_code as new code and set global $csv2post_job_array
                    global $csv2post_currentjob_code,$csv2post_job_array;
                    
                    $csv2post_currentjob_code = $code;// set the global $csv2post_currentjob_code
                    $csv2post_job_array = $jobarray;// set the global $jobarray
                    
                    // in free edition we automatically delete the existing table if any
                    csv2post_SQL_drop_dataimportjob_table('csv2post_'.$csv2post_currentjob_code);
     
                    // create a database table - multiple file jobs are put into a single table, column names are giving appended values to prevent conflict with shared names    
                    $createtable_result = csv2post_WP_SQL_create_dataimportjob_table($csv2post_currentjob_code,$job_file_group);

                    if(!$createtable_result){
                        $functionoutcome = false;
                        $extendednotice .= csv2post_notice('The data import jobs database table could not be created, it is required for storing your data and was to be named csv2post_'.$code.'. Please try again then seek support.','warning','Extra','','','return');        
                    }else{
                        
                        // update csv2post_current_job option record
                        csv2post_update_option_currentjob_code($code);
                        
                        // update the Data Import Jobs Array (the list of all job ID)
                        global $csv2post_dataimportjobs_array;
                        
                        // if data import jobs array is not already set then this must be the first job - set it as an array
                        if(!$csv2post_dataimportjobs_array){
                            $csv2post_dataimportjobs_array = array();    
                        }

                        // add job to the array that only holds a list of jobs not job statistics
                        csv2post_add_dataimportjob_to_list($code,$_POST['csv2post_jobname_name']);
                        
                        $functionoutcome = true;
                        $extendednotice .= csv2post_notice('A new database table named csv2post_' . $code.' was created for storing your data for the new Data Import Job.','info','Extra','','','return');    
                    
                    }
                }else{
                    $functionoutcome = false;
                    $extendednotice .= csv2post_notice('Could not create data import task, reason unknown. Please try again then report this problem if it continues.','warning','Extra','','','return');                    
                }
            }else{
                $functionoutcome = false;
                $extendednotice .= csv2post_notice('You did not select any CSV files for your new Data Import Job. Please try again.','warning','Extra','','','return');
            }
        }else{
            $functionoutcome = false;
            $extendednotice .= csv2post_notice('Your Data Import Job name is invalid, please do not include special characters or use more than 30 characters.','info','Extra','','','return');
        }
        
        // decide the initial notice
        if($functionoutcome){
            $initialnotice = 'Your new data import job named '.$_POST['csv2post_jobname_name'].' has been created and no problems were detected. You can now go to the Import tab and begin importing rows from your CSV file/s into your database as records.';    
        }else{
            $initialnotice = 'Sorry your new data import job named '.$_POST['csv2post_jobname_name'].' was NOT created, a problem was detected. More details should be provided below this message.';
        }
        
        // undo changes that were made to the blog despite an overall fail
        ### TODO:MEDIUMPRIORITY, remove database table and job entry to the job array if an overall failure is reached
        
        // display result
        csv2post_notice('<h4>Create New Data Import Job Result</h4>' . $initialnotice . $extendednotice);

        if($functionoutcome){
            if($csv2post_is_free){
                csv2post_notice('You should now click on the Basic Import screen and begin importing your data.','step','Large','Next Step',false,'echo');    
            }else{
                csv2post_notice('You should now click on the Advanced Import screen and begin importing your data manually or
                configure the plugins Schedule Settings to import data automatically.','step','Large','Next Step',false,'echo');                
            }        
        }
        
        return false;
    }else{
        return true;
    }     
}  
                                                    
/**
* Creates the csv file folder in the wp-content path
*/
function csv2post_form_deletecontentfolder(){
    if(isset($_POST['csv2post_contentfolder_delete'])){ 
        // this function does the output when set to true for 2nd parameter
        csv2post_delete_contentfolder(WTG_C2P_CONTENTFOLDER_DIR,true);    
        return false; 
    }else{
        return true;
    }    
} 

/**
* Creates the csv file folder in the wp-content path
*/
function csv2post_form_createcontentfolder(){
    if(isset($_POST['csv2post_contentfolder_create'])){ 
        // this function does the output when set to true for 2nd parameter
        csv2post_install_contentfolder_wpcsvimportercontent(WTG_C2P_CONTENTFOLDER_DIR,true);    
        return false;
    }else{
        return true;
    }    
}  
 
/**
* Reset Quick Start session array 
*/
function csv2post_form_reseteci(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'ecireset'){
        csv2post_INSTALL_ecisession();        
        csv2post_notice_postresult('success','Quick Start Reset','You can now start with Step One of the Quick Start system.');        
        return false;
    }else{
        return true;
    }     
}  
                  
/**
* Save sub-page by permalinks
* 
* @todo LOWPRIORITY, prevent user selecting the same column twice
*/
function csv2post_form_subpage_bypermalinks(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'subpagesbypermalinks'){
        
        global $csv2post_project_array,$csv2post_currentproject_code;

        if($_POST['csv2post_subpage_permalinks_radio'] == 'off'){
            
            $csv2post_project_array['subpages']['status'] = false;

            csv2post_notice_postresult('success','Sub-page Grouping Method Disabled','Your post creation
            will not create sub-pages at all. This action disables all methods. Please submit a sub-page
            settings form if you still wish to create sub-pages.'); 
                        
        }else{
      
            $csv2post_project_array['subpages']['levelcolumn']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bypermalinks_level']);
            $csv2post_project_array['subpages']['levelcolumn']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bypermalinks_level']);            
                    
            $csv2post_project_array['subpages']['slugscolumn']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bypermalinks_slug']);
            $csv2post_project_array['subpages']['slugscolumn']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bypermalinks_slug']);            

            // is another method active? If so make user aware that it will be deactivated as only one method can run at a time
            if(isset($csv2post_project_array['subpages']['status']) && $csv2post_project_array['subpages']['status'] == true){
                if(isset($csv2post_project_array['subpages']['method']) && $csv2post_project_array['subpages']['method'] != 'permalinks'){
                    csv2post_notice_postresult('warning','Sub-page Method Changed',
                    'You already had a sub-page method active but only one method can be used at a time. The
                    settings saved for your other submitted method will not be used. The grouping method
                    will now be used for your current project.');    
                }
            }

            $csv2post_project_array['subpages']['status'] = true;
            $csv2post_project_array['subpages']['method'] = 'permalinks';
            $csv2post_project_array['subpages']['stage'] = 1;// this is increased per stage and used to determine what level of pages is to be created
            
            csv2post_notice_postresult('success','Sub-page Grouping Method Activated','Your post creation
            will setup sub-pages providing your data is suitable for the permalink method.');            
        }

        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);            
                        
        return false;
    }else{
        return true;
    }     
} 

/**
* save sub-page by grouping
* NOT IN USE YET
*/
function csv2post_form_subpage_bygrouping(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'subpagesbygroupingtwocolumn'){

        global $csv2post_project_array,$csv2post_currentproject_code;
                          
        $table_name1 = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bygrouping_parent']);
        $column_name1 = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bygrouping_parent']);            
                
        $table_name2 = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bygrouping_sub1']);
        $column_name2 = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bygrouping_sub1']);            
                     
        if(isset($_POST['csv2post_subpages_bygrouping_sub2']) && $_POST['csv2post_subpages_bygrouping_sub2'] != 'notselected'){
            $table_name3 = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_subpages_bygrouping_sub2']);
            $column_name3 = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_subpages_bygrouping_sub2']);            
        }
        
        // is another method active? If so make user aware that it will be deactivated as only one method can run at a time
        if(isset($csv2post_project_array['subpages']['status']) && $csv2post_project_array['subpages']['status'] == true){
            if(isset($csv2post_project_array['subpages']['method']) && $csv2post_project_array['subpages']['method'] != 'grouping'){
                csv2post_notice_postresult('warning','Sub-page Method Changed',
                'You already had a sub-page method active but only one method can be used at a time. The
                settings saved for your other submitted method will not be used. The grouping method
                will now be used for your current project.');    
            }
        }

        $csv2post_project_array['subpages']['status'] = true;
        $csv2post_project_array['subpages']['method'] = 'grouping';
        $csv2post_project_array['subpages']['stage'] = 1;// this is increased per stage and used to determine what level of pages is to be created           
        $csv2post_project_array['subpages']['slugscolumn']['table'] = 'grouping';
        $csv2post_project_array['subpages']['slugscolumn']['column'] = 'grouping';
        $csv2post_project_array['subpages']['subone']['table'] = $table_name1;
        $csv2post_project_array['subpages']['subone']['column'] = $column_name1;
        $csv2post_project_array['subpages']['subtwo']['table'] = $table_name2;
        $csv2post_project_array['subpages']['subtwo']['column'] = $column_name2;        
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array); 
        
        csv2post_notice_postresult('success','Sub-page Grouping Method Activated','Your post creation
        will setup sub-pages providing your data is suitable for the grouping method.');
        
        return false;
    }else{
        return true;
    }     
}    
    
/**
* Process post creation for giving project 
*/
function csv2post_form_start_post_creation(){
    global $csv2post_projectslist_array,$csv2post_schedule_array,$csv2post_is_free,$csv2post_project_array,$csv2post_currentproject_code;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_post_creation_request'])){
        
        // store post type in project array
        if(isset($_POST['csv2post_radio_poststatus'])){
            $csv2post_project_array['poststatus'] = $_POST['csv2post_radio_poststatus'];
        }
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
          
        // free edition processes all records at once, $_POST['csv2post_postsamount'] will not be set
        $target_posts = 999999;
        if(!$csv2post_is_free){
            $target_posts = $_POST['csv2post_postsamount'];    
        }
    
        // subpages
        $subpagelevel = false;
        if(isset($csv2post_project_array['subpages']['status'] ) && $csv2post_project_array['subpages']['status'] == true
        && isset($csv2post_project_array['subpages']['stage']) && is_numeric($csv2post_project_array['subpages']['stage'])){
            $subpagelevel = $csv2post_project_array['subpages']['stage'];    
        }
        
        // call create posts function     
        $post_id = csv2post_create_posts($_POST['csv2post_project_code'],$target_posts,'manual',$subpagelevel);
        if($post_id){
            
            // no false returned (false indicates a failure)
            // $post_id will be the last post ID created
            csv2post_notice('Post creation went smoothly, no problems were detected. The last post ID created was <strong>'.$post_id.'</strong>.','success','Large','Post Creation Complete','','echo');
            ### TODO:LOWPRIORITY, add link and url to last created post to the output
                
        }else{
           // must be a failure, if multiple posts were requests the failure is big enough to output it to the user
           csv2post_notice('No post ID was returned during post creation. This is usually because all 
           records have been used to create posts and the project is finished. This warning is simply 
           to recommend that you confirm all records used or report a discrepancy.','warning','Small',
           'Projects Post Creation Complete','','echo');
        }
         
        return false;
    }else{
        return true;
    }      
}                    

/**
* Activate or disable text spinning 
*/
function csv2post_form_textspinning_switch(){
    if(isset( $_POST[WTG_C2P_ABB.'hidden_pageid'] ) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'projects' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'textspinningswitch'){
        global $csv2post_textspin_array,$csv2post_adm_set;

        if(isset($csv2post_textspin_array['settings']['status']) && $csv2post_textspin_array['settings']['status'] == true){
            $csv2post_textspin_array['settings']['status'] = false;
            csv2post_notice_postresult('success','Text Spin Features ','You have disabled
            text spin features. This will reduce processing during post creation and hide options.
            However at does not disable shortcodes already in use.');       
        }else{
            $csv2post_textspin_array['settings']['status'] = true;
            csv2post_notice_postresult('success','Text Spin Features On','You have activated
            text spin features. It will put all post content through more processing during post creation
            and display more accordion panels.');                          
        }
        
        csv2post_update_option_textspin($csv2post_textspin_array);        
        
        return false;
    }else{
        return true;
    }     
}   

/**
* Saves basic categories form
*/
function csv2post_form_save_categories_standard(){
    global $csv2post_currentproject_code,$csv2post_is_free,$csv2post_project_array;
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'standardcategories'){

        // ensure the previous column has been selected for every column user submits
        $required_column_missing = false;// set to true if a required column has not been selected
        $required_column_level = false;// change to level 1,2,3 or 4 to indicate which column has not been selected but should be
        
        // check for level 1 - always required
        if( $_POST['csv2post_categorylevel1_select_columnandtable'] == 'notselected' ){
            csv2post_notice('You did not select a level one data table and column, you must always use level one if you want to create categories using this panel.','error','Large','Level One Not Selected');
            return false;//discontinue post function processing
        }
        
        // check if 3 is set - requires 2
        if( $_POST['csv2post_categorylevel3_select_columnandtable'] != 'notselected' && $_POST['csv2post_categorylevel2_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 2;
        }
        
        // check if 4 is set - requires 3
        if( !$csv2post_is_free && $_POST['csv2post_categorylevel4_select_columnandtable'] != 'notselected' && $_POST['csv2post_categorylevel3_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 3;
        }       
        
        // check if 5 is set - requires 4
        if( !$csv2post_is_free && $_POST['csv2post_categorylevel5_select_columnandtable'] != 'notselected' && $_POST['csv2post_categorylevel4_select_columnandtable'] == 'notselected' ){
            $required_column_missing = true;
            $required_column_level = 4;
        }        
        
        // only continue if all required columns have been selected
        if($required_column_missing){
            $column_above_missing_level = $required_column_level + 1;
            csv2post_notice('You did not select all required columns. You selected a column for category level '.$column_above_missing_level.' but did not select one for category level '.$required_column_level.'. You must select category columns in order as displayed i.e. use 1,2 and 3 for three levels not 1,2 and 4.','error','Large','Missing Category Column Selection');
            return false;// discontinues post functions processing        
        }else{
    
            $csv2post_project_array = csv2post_get_project_array($csv2post_currentproject_code);   
            
            // apply depth
            $csv2post_project_array['categories']['applydepth'] = $_POST['csv2post_categorisationlevel_basic'];
            
            // add level 1 
            $csv2post_project_array['categories']['level1']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel1_select_columnandtable']);
            $csv2post_project_array['categories']['level1']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel1_select_columnandtable']);            

            // add level 2
            if($_POST['csv2post_categorylevel2_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level2']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel2_select_columnandtable']);
                $csv2post_project_array['categories']['level2']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel2_select_columnandtable']);                     
            }elseif(isset($csv2post_project_array['categories']['level2']) && $_POST['csv2post_categorylevel2_select_columnandtable'] == 'notselected'){
                unset($csv2post_project_array['categories']['level2']);            
            }
            
            // add level 3
            if($_POST['csv2post_categorylevel3_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level3']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel3_select_columnandtable']);
                $csv2post_project_array['categories']['level3']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel3_select_columnandtable']);                     
            }elseif(isset($csv2post_project_array['categories']['level3']) && $_POST['csv2post_categorylevel3_select_columnandtable'] == 'notselected'){
                unset($csv2post_project_array['categories']['level3']);           
            }                

            // add level 4
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel4_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level4']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel4_select_columnandtable']);
                $csv2post_project_array['categories']['level4']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel4_select_columnandtable']);                     
            }elseif(isset($csv2post_project_array['categories']['level4']) && $_POST['csv2post_categorylevel4_select_columnandtable'] == 'notselected'){
                unset($csv2post_project_array['categories']['level4']);           
            }
            
            // add level 5
            if(!$csv2post_is_free && $_POST['csv2post_categorylevel5_select_columnandtable'] != 'notselected'){
                $csv2post_project_array['categories']['level5']['table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_categorylevel5_select_columnandtable']);
                $csv2post_project_array['categories']['level5']['column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_categorylevel5_select_columnandtable']);                     
            }elseif(isset($csv2post_project_array['categories']['level5']) && $_POST['csv2post_categorylevel5_select_columnandtable'] == 'notselected'){
                unset($csv2post_project_array['categories']['level5']);            
            }            
  
            // update project option         
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
            
            csv2post_notice('Your basic type category configuration has been saved and categories will be created during post creation. Posts will be assigned to their proper category.','success','Large','Standard Category Settings Saved');    
        }
  
        return false;
    }else{
        return true;
    }    
}

/**
* Creates one level of categories at a time 
*/
function csv2post_form_create_category_level(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'createcategoriesperlevel'){
        global $csv2post_is_free;
        
        if(!$csv2post_is_free){
            csv2post_WP_CATEGORIES_manuallevels_advanced($_POST['csv2post_categories_next_level']);
        }else{
            csv2post_WP_CATEGORIES_manuallevels_basic($_POST['csv2post_categories_next_level']);
        }

        return false;
    }else{
        return true;
    }     
} 

/**
* Delete all categories created with the current project 
*/
function csv2post_form_undo_categories(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'undocategoriescurrentproject'){
        global $csv2post_currentproject_code,$csv2post_project_array,$csv2post_is_free;  
        
        $categories_deleted_count = 0;
        
        $pro_table = csv2post_get_project_maintable($csv2post_currentproject_code);
        
        // query csv2post_catid column
        $records = csv2post_WP_SQL_select_catidcolumn($pro_table); 
        if(!$records){
            csv2post_n_postresult('warning','No Category Data','There is no category
            ID values in your data. If you are sure you created categories and not already undone them, please
            contact the plugin author for support.');
            return;
        }

        // keep track of the combinations of cat ID already deleted to avoid running deletion more than once
        $cats_deleted_array = array();
        
        foreach($records as $key => $category){

            if($category['csv2post_catid'] != NULL && !in_array($category['csv2post_catid'],$cats_deleted_array)){
                
                // explode the ID's and delete each category with those ID
                $category_IDs_array = explode(',',$category['csv2post_catid']);

                foreach($category_IDs_array as $key => $cat_ID){
                    if(wp_delete_category( $cat_ID )){
                        ++$categories_deleted_count;
                    }
                }
                
                // update records csv2post_catid value with NULL where csv2post_catid matches our string
                csv2post_WP_SQL_categories_resetIDs($pro_table,$category['csv2post_catid']);
                
                // update cats_deleted_array
                $cats_deleted_array[] = $category['csv2post_catid'];    
            }        
        }
        
        // reset category level tracking - will loop 10 times should we ever add more levels
        for($i=1;$i<=10;$i++){
            if(isset($csv2post_project_array['categories']['level'.$i]['complete'])){
                unset($csv2post_project_array['categories']['level'.$i]['complete']);
            }
        }
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_n_postresult('success','Projects Categories Deleted','A total of '.$categories_deleted_count.' were deleted');        
         
        return false;
    }else{
        return true;
    }     
} 

/**
* Saves easy configuration questions
*/
function csv2post_form_save_easyconfigurationquestions(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'easyconfigurationquestions'){
        global $csv2post_adm_set,$csv2post_ecq_array;
        
        // save answers
        foreach($csv2post_ecq_array as $key => $q){
            // if $_POST value for this question
            if(isset($_POST['csv2post_'.$key])){
                $csv2post_adm_set['ecq'][$key] = $_POST['csv2post_'.$key];  
            }  
        }

        /**
        * Where there are existing settings we will update those settings to help make this
        * function central to the ECQ system. However if there is no existing system, consider
        * makign one. If one is not required required, then use the ['ecq'] value itself in the appropriate
        * script. 
        */
        
        ### TODO:HIGHPRIORITY, some question processing requires other systems to be complete, when ready please complete the processing below
        
        // 102 - Data Tables (all or csv2post)
        if($csv2post_adm_set['ecq'][102] == 'yes'){$csv2post_adm_set['dbtablesscope'] = 'all';}else{$csv2post_adm_set['dbtablesscope'] = 'csv2post';}
        // 103 - Schedule/Automation Trigger (admin also or public only)
        if($csv2post_adm_set['ecq'][103] == 'yes'){/* TODO:MEDIUMPRIORITY, was a setting but it was removed, we will apply this later */}
        // 104 - New version tweets
        if($csv2post_adm_set['ecq'][104] == 'yes'){/* return answer using User Experience Program when it is complete */}                                   
        // 105 - Use log system
        if($csv2post_adm_set['ecq'][105] == 'yes'){/* TODO:MEDIUMPRIORITY, complete when new log to database complete */}
        // 106 - RSS feed tutorials and videos
        if($csv2post_adm_set['ecq'][106] == 'yes'){/* return answer using User Experience Program when it is complete */}
        // 107 - Encoding
        if($csv2post_adm_set['ecq'][107] == 'yes'){/* process once encoding functions re-vised and complete */}
        // 108 - Hide jQuery theme and use Wordpress CSS
        if($csv2post_adm_set['ecq'][108] == 'yes'){update_option('csv2post_theme','wordpresscss'); }  
        // 109 - Only one user
        if($csv2post_adm_set['ecq'][109] == 'yes'){/* a) screen permissions panel hidden b) page permissions panel hidden */}
        // 110 - Do you need to merge two or more CSV files into one set of data?
        if($csv2post_adm_set['ecq'][110] == 'no'){/* no setting - answer will be used to hide multiple file related features */}
        // 111 - Table to table
        if($csv2post_adm_set['ecq'][111] == 'yes'){/* TODO:MEDIUMPRIORITY, apply this when we have controls for hiding and displaying screens, change those settings here. This will prevent the screen being displayed again if user re-installs menu array */}
        // 112 - Two or more database tables
        if($csv2post_adm_set['ecq'][112] == 'yes'){/* radios instead of checkboxes are set on table selection when creating new project */}
        // 113 - Content template rules
        if($csv2post_adm_set['ecq'][113] == 'yes'){/* hides panels related to contact template rules */}
        // 114 - Post dates
        if($csv2post_adm_set['ecq'][114] == 'yes'){/* TODO:MEDIUMPRIORITY,when screen display settings finished hide post dates tab screen on yes */}
        // 115 - Post updating 
        if($csv2post_adm_set['ecq'][115] == 'yes'){/* TODO:MEDIUMPRIORITY, once screen options complete hide updating screens */}  
        // 116 - Social networking
        if($csv2post_adm_set['ecq'][116] == 'yes'){/* TODO:MEDIUMPRIORITY, return answer using User Experience Program when it is complete */}
        // 117 - URL Cloaking
        if($csv2post_adm_set['ecq'][117] == 'yes'){/* TODO:MEDIUMPRIORITY, once screen options complete hide related screens */}
        // 118 - Text Spinning
        if($csv2post_adm_set['ecq'][118] == 'yes'){/* TODO:MEDIUMPRIORITY, once screen options complete hide related screens */}
        // 119 - Create authors
        if($csv2post_adm_set['ecq'][119] == 'yes'){/* TODO:MEDIUMPRIORITY, once screen options complete hide related screens */}
        // 120 - Display info or video buttons in panels?
        if($csv2post_adm_set['ecq'][120] == 'yes'){$csv2post_adm_set['interface']['panels']['supportbuttons']['status'] = 'display';}
        // 121 - One or more projects
        if($csv2post_adm_set['ecq'][121] == 'yes'){/* TODO:MEDIUMPRIORITY, return answer using User Experience Program when it is complete */}
        // 122 - User Experience Program
        if($csv2post_adm_set['ecq'][122] == 'yes'){/* TODO:HIGHPRIORITY, this is a system and all systems need to be 90% comlete asap, then activate it here */}
        // 123 - Register domain as user
        if($csv2post_adm_set['ecq'][123] == 'yes'){/* TODO:MEDIUMPRIORITY, return answer using User Experience Program when it is complete, also setup a way for user to manually submit domain with URL GET at our end, users should have incentives to do so once credits system in place as a service */}
        // 124 - Support account using wordpressplugin@csv2post.com
        if($csv2post_adm_set['ecq'][124] == 'yes'){/* TODO:MEDIUMPRIORITY, create support account and pass details to us using SOAP once web services complete */}

        csv2post_update_option_adminsettings($csv2post_adm_set);
   
        csv2post_notice('Your answers for the Easy Configuration Questions have been saved. Please remember
        that this may hide features, display new features or change the way a feature operates.',
        'success','Large','Answers Saved','','echo');
           
        return false;
    }else{
        return true;
    }       
}    

/**
* Data panel one settings
* 
*/
function csv2post_form_save_settings_datapanelone(){
         if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'panelone'){
        
        global $csv2post_adm_set;

        $csv2post_adm_set['encoding']['type'] = $_POST['csv2post_radiogroup_encoding'];
        $csv2post_adm_set['admintriggers']['newcsvfiles']['status'] = $_POST['csv2post_radiogroup_detectnewcsvfiles'];
        $csv2post_adm_set['admintriggers']['newcsvfiles']['display'] = $_POST['csv2post_radiogroup_detectnewcsvfiles_display'];
        $csv2post_adm_set['postfilter']['status'] = $_POST['csv2post_radiogroup_postfilter'];          
        $csv2post_adm_set['postfilter']['tokenrespin']['status'] = $_POST['csv2post_radiogroup_spinnertokenrespin'];        
 
        csv2post_update_option_adminsettings($csv2post_adm_set);

        csv2post_n_postresult('success','Data Related Settings Saved','We
        recommend that you monitor the plugin for a short time and ensure
        your new settings are as expected.');
        
        return false;
    }else{
        return true;
    } 
}

function csv2post_form_save_postslugdata(){
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'projects' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'postslug'){
        global $csv2post_currentproject_code,$csv2post_project_array;
        
        $csv2post_project_array['slugs']['custom']['tablename'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_slug_columnandtable']);    
        $csv2post_project_array['slugs']['custom']['columnname'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_slug_columnandtable']); 
        
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_n_postresult('success','Post Slug Data Setup','Your post slugs will be set using your own 
        data instead of being based on your post titles. However if any of your slug values are missing 
        CSV 2 POST will allow Wordpress to apply its usual default procedure for creating post slugs.');
            
        // return false to stop all further post validation function calls
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        // return true for the form validation system, tells it to continue checking other functions for validation form submissions
        return true;
    }                 
}    
     
function csv2post_form_reinstall_databasetables(){
    if(isset($_POST[WTG_C2P_ABB.'hidden_pageid']) && $_POST[WTG_C2P_ABB.'hidden_pageid'] == 'main' && isset($_POST[WTG_C2P_ABB.'hidden_panel_name']) && $_POST[WTG_C2P_ABB.'hidden_panel_name'] == 'reinstalldatabasetables'){
        
        $tables = 0;
        $result = true;
        $result = csv2post_INSTALL_reinstall_databasetables();++$tables;
        if($result){
            csv2post_n_postresult('success','Tables Re-Installed Successfully','A total of '.$tables.' tables were deleted then created. All data in the original tables is lost.');
        }else{   
            csv2post_n_postresult('error','Tables Re-Installation Failed','A total of '.$tables.' tables were meant to be deleted then installed again but a problem was detected. Please
            try again then investigate the issue. It may be a single table causing this issue. Please report it and we will be happy to help.');
        }
        
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    }      
} 

/**
* Saves basic seo options          
*/
function csv2post_form_save_basic_seo_options(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'projects' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'basicseooptions'){
        global $csv2post_project_array,$csv2post_currentproject_code;
        
        // title
        if($_POST['csv2post_seo_title'] == 'fault'){
            csv2post_n_postresult('error','Problem Saving SEO Title','The SEO form did not submit a table and column name. Please seek support.');    
        }else{
            $csv2post_project_array['seo']['basic']['title_key'] = $_POST['csv2post_seo_key_title'];
            $csv2post_project_array['seo']['basic']['title_table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_seo_title']);    
            $csv2post_project_array['seo']['basic']['title_column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_seo_title']);            
        }
        
        // description
        if($_POST['csv2post_seo_description'] == 'fault'){
            csv2post_n_postresult('error','Problem Saving SEO Description','Your SEO form did not submit a table and column name. Please seek support.');    
        }else{
            $csv2post_project_array['seo']['basic']['description_key'] = $_POST['csv2post_seo_key_description'];
            $csv2post_project_array['seo']['basic']['description_table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_seo_description']);    
            $csv2post_project_array['seo']['basic']['description_column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_seo_description']);            
        }
         
        // keywords
        if($_POST['csv2post_seo_keywords'] == 'fault'){
            csv2post_n_postresult('error','Problem Saving SEO Title','Sorry the SEO form did not submit a table and column name. Please seek support.');    
        }else{
            $csv2post_project_array['seo']['basic']['keywords_key'] = $_POST['csv2post_seo_key_title'];
            $csv2post_project_array['seo']['basic']['keywords_table'] = csv2post_explode_tablecolumn_returnnode(',',0,$_POST['csv2post_seo_keywords']);    
            $csv2post_project_array['seo']['basic']['keywords_column'] = csv2post_explode_tablecolumn_returnnode(',',1,$_POST['csv2post_seo_keywords']);            
        }
         
        csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        
        csv2post_n_postresult('success','Basic SEO Settings Saved','You have setup basic SEO settings. If you are using the premium edition you may now configure advanced SEO settings.');
                   
        return false;
    }else{
        return true;
    }       
}    

/**
* Saves easy configuration questions
* 
* @todo HIGHPRIORITY, complete this function. Add option to reverse specific groups of posts by time/date range.
*/
function csv2post_form_undo_posts(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'creation' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'undopostscurrentproject'){
        global $csv2post_currentproject_code,$csv2post_project_array;

        $number_of_posts_deleted = 0;
                
        // if current project options selected but no posts made with project
        $postscreated = csv2post_does_project_have_posts($csv2post_currentproject_code);
        if(!$postscreated){
            csv2post_notice('The current project does not have any posts according to the projects main table','warning','Large','No Posts','','echo');
            return false;        
        } 
        
        // Sub-page
        // if sub-page in use and all posts are to be deleted we need to reset the stage counter
        if(isset($csv2post_project_array['subpages']['stage'])){
            $csv2post_project_array['subpages']['stage'] = 1;
            csv2post_update_option_postcreationproject($csv2post_currentproject_code,$csv2post_project_array);
        }
            
        // delete posts
        $number_of_posts_deleted = csv2post_delete_project_posts_byrange($csv2post_currentproject_code,'currentproject');
        
        if($number_of_posts_deleted > 0){
            
            $plural = "'s";
            if($number_of_posts_deleted == 1){
                $plural = '';    
            }
            
            csv2post_notice('You deleted ' . $number_of_posts_deleted .' posts. The post ID have also been removed from their
            project table so that the records are ready to use again.','success','Large',$number_of_posts_deleted . " Post".$plural." Deleted",'','echo');
             
        }else{
            csv2post_notice('No posts were deleted as there are no post ID in the project tables checked.','info','Large','No Posts Deleted','','echo');
        }        
           
        return false;
    }else{
        return true;
    }       
}       
?>