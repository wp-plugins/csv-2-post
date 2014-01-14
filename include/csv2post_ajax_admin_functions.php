<?php
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
/**
* Imports data from CSV file for NEW RECORD INSERT - This is a manual function.
*/
function csv2post_ajax_dataimportjob_import_manual() {
    
    // create ajax referer - made up using panel name
    check_ajax_referer( "csv2post_referer_dataimportjob_csvfileimport" );// exampleajaxtwo is panel name
    $overall_result = 'success';
    $dataimportjob_array = csv2post_data_import_from_csvfile_basic($_POST[ 'csvfilename' ], 'csv2post_' . $_POST[ 'jobcode' ],$_POST['targetrows'],$_POST[ 'jobcode' ]);
    
    // determine new $overall_result and apply styling to the main notice to suit it
    if($dataimportjob_array == false){
        $overall_result = 'error';
    }
    
    // display result    
    echo csv2post_notice('<h4>Data Import Result<h4>
    <p>You requested up to '.$_POST[ 'targetrows' ].' rows to be imported from '.urldecode($_POST[ 'csvfilename' ]).'.</p>
    '.csv2post_notice('New Records: '.$dataimportjob_array["stats"]["lastevent"]['inserted'],'success','Small',false,'','return').'
    '.csv2post_notice('Void Records: '.$dataimportjob_array["stats"]["lastevent"]['void'],'info','Small',false,'','return').'
    '.csv2post_notice('Dropped Rows: '.$dataimportjob_array["stats"]["lastevent"]['dropped'],'warning','Small',false,'','return').'
    '.csv2post_notice('Rows Processed: '.$dataimportjob_array["stats"]["lastevent"]['processed'],'info','Small',false,'','return').'     
    '.csv2post_notice('Job Progress: '.$dataimportjob_array["stats"]["allevents"]['progress'],'info','Small',false,'','return').'    
    ',$overall_result,'Extra','','','return');  

    die();
}
add_action( 'wp_ajax_action_dataimportjob_csvfileimport', 'csv2post_ajax_dataimportjob_import_manual' );

function csv2post_ajax_dataimportjob_requestupate() {
    check_ajax_referer( "csv2post_referer_dataimportjob_csvfileimport" );
    $count_records_result = csv2post_WP_SQL_count_records_forfile( urldecode( 'csv2post_' . $_POST[ 'jobcode' ] ),$_POST['csvfilename'],csv2post_get_csvfile_id($_POST['csvfilename'],$_POST[ 'jobcode' ]) );
    echo $count_records_result;
    
    die();
}
add_action( 'wp_ajax_dataimportjob_requestupdate', 'csv2post_ajax_dataimportjob_requestupate' );

#######################################################################
#                                                                     #
#           Create New Data Import Actions and Ajax Referer           #
#                                                                     #
#######################################################################
/**
* Checks if the user entered data import job name has already been used or not
* then displays the result using csv2post_notice()
* 
* @todo HIGHPRIORITY, requires data import job array to be called and compare submitting name against existing 
*/
function csv2post_ajax_createdataimportjobcsvfiles_validatefield() {
    
    check_ajax_referer( "csv2post_referer_createdataimportjobcsvfiles" );// createdataimportjobcsvfiles is panel name
    
    // TODO:HIGHPRIORITY, to avoid the user getting confused, warn them about duplicate job names (not used as an ID though so we will allow duplicate, that is the users choice)
    ////$importjobname_validate_result = csv2post_validate_dataimportjob_name(); 
    
    echo csv2post_notice(urldecode( $_POST[ 'csv2post_jobname' ] ) .' is a good data import job name, please continue' ,'success','Small','Job Name Is Suitable','','return');
    
    die();
}
add_action( 'wp_ajax_action_createdataimportjobcsvfiles_validatefield', 'csv2post_ajax_createdataimportjobcsvfiles_validatefield' );
/**
* NOT IN USE for this form, used in conjuction with save button, may be added later but would require other 
* tabs to be updated with changes. Complex and possibly not worth doing. 
*/
function csv2post_ajax_createdataimportjobcsvfiles_saveform() {
    check_ajax_referer( "csv2post_referer_createdataimportjobcsvfiles" );// createdataimportjobcsvfiles is panel name
    echo csv2post_notice('The POST Value Processed By Ajax Is: ' . urldecode( $_POST[ 'colour' ] ) . ' END OF VALUE','success','Small','Testing','','return');
    die();
}
add_action( 'wp_ajax_action_createdataimportjobcsvfiles_saveform', 'csv2post_ajax_createdataimportjobcsvfiles_saveform' );

######################################################################
#                                                                    #
#                          CREATE NEW PROJECT                        #
#                                                                    #
######################################################################
function csv2post_ajax_createproject_checkprojectname() {
    
    check_ajax_referer( "csv2post_referer_createproject_checkprojectname" );// createdataimportjobcsvfiles is panel name
    
    // TODO:HIGHPRIORITY, to avoid the user getting confused, warn them about duplicate job names (not used as an ID though so we will allow duplicate, that is the users choice)
    ////$importjobname_validate_result = csv2post_validate_dataimportjob_name(); 
    
    echo csv2post_notice(urldecode( $_POST[ 'csv2post_projectname' ] ) .' is a suitable project name, please continue' ,'success','Small','Suitable Project Name','','return');
    
    die();
}
add_action( 'wp_ajax_action_createproject_checkprojectname', 'csv2post_ajax_createproject_checkprojectname' );
?>
