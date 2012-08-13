<?php
##################################################################################
#                                                                                #
#         START OF DATA IMPORT JOB PANELS LOOP - CREATES A PANEL PER JOB         #
#                                                                                #
##################################################################################
#
#  On 3rd August 2012 Ryan Bayne setup 2nd method - $_POST submissions.
#  The purpose is for debugging during form submission and doing import while
#  Wordpress is loading, closest to the state the blog would be in during automation. 
$method = 'post';// post or ajax
### TODO:MEDIUMPRIORITY, WARNING, the ajax method may be bugged, use post method until fully tested, pay attention too the filemtime function
if($method == 'ajax'){
    if($csv2post_dataimportjobs_array){
        foreach( $csv2post_dataimportjobs_array as $jobcode => $job ){

        $job_array = csv2post_get_dataimportjob($jobcode);
        
        ++$panel_number;// increase panel counter so this panel has unique ID
        $panel_array = array();                       
        $panel_array['panel_name'] = 'dataimportjob' . $jobcode;// slug to act as a name and part of the panel ID 
        $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
        $panel_array['panel_title'] = __('Data Import Job: ' . $job['name']);// user seen panel header text 
        $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
        $panel_array['tabnumber'] = $csv2post_tab_number; 
        $panel_array['panel_id'] = $panel_array['panel_name'] . $panel_number;// creates a unique id, may change from version to version but within a version it should be unique
        $panel_array['panel_intro'] = __('This is your data import job named ' . $job['name'] .' and the job code is ' . $jobcode);
        $panel_array['panel_help'] = __('Please refresh the browser in order to view the latest job statistics (until more Ajax is added). Your data import panel for ' . $job['name'] . ' allows you to import rows from individual CSV files. You can also manually update the statistics. By default rows are imported and put into the database table using an UPDATE query, not an INSERT. The rows are placed in order as found in the CSV files. Meaning all CSV files within a single job must be in matching order for the finished table of data to be correct. This is only the default behaviour as there is the ability to save a set of key columns which contain some type of ID per record. Each CSV file must contain the same column of ID values in order for this ability to work. This allows the rows in each CSV file to be in any order and still be updated to the correct record in the database.');
        $panel_array['help_button'] = csv2post_helpbutton_text(false,false);
        ?>
        <?php csv2post_panel_header( $panel_array );?>    
                        
            <?php $nonce = wp_create_nonce( "csv2post_referer_dataimportjob_csvfileimport" );?>
            
            <?php $total_job_progress_bar_value = csv2post_calculate_dataimportjob_progress_percentage($jobcode);?>
            
            <script>
                $(function() {
                    $( <?php echo '"#csv2post_progressbar_dataimport_'.$jobcode.'"';?> ).progressbar({
                        value: <?php echo $total_job_progress_bar_value;?>
                    });
                });
            </script>  
            <div id="csv2post_progressbar_dataimport_<?php echo $jobcode;?>"></div>                 
             
            <?php foreach($job_array['files'] as $key => $csv_filename){?>
                 
                <?php $csv_filename_cleaned = csv2post_clean_string($csv_filename);?>
               
                <script  type='text/javascript'>
                <!--
                var count = 0;

                // When the document loads do everything inside here ...
                jQuery(document).ready(function(){
                    
                    <?php
                    // get import rate buttons array (sets the numbe per button)
                    $importrate_array = array();// TODO: add ability for user to set each buttons import rate
                    $importrate_array[0]['letter'] = 'a';
                    $importrate_array[0]['rate'] = '9000999';
                    $importrate_array[1]['letter'] = 'b';
                    $importrate_array[1]['rate'] = '1'; 
                    $importrate_array[2]['letter'] = 'c';
                    $importrate_array[2]['rate'] = '100';
                    $importrate_array[3]['letter'] = 'd';
                    $importrate_array[3]['rate'] = '1000';
                    $importrate_array[4]['letter'] = 'e';
                    $importrate_array[4]['rate'] = '10000';
                                                                                            
                    foreach( $importrate_array as $key => $button ){?>                       
                        
                        // request data import event - E (10,000 by default)
                        jQuery('#request_import_<?php echo $button['letter'];?>_<?php echo $jobcode . $csv_filename_cleaned;?>').click(function() { //start function when Random button is clicked
                            
                            jQuery.ajax({
                                type: "post",url: "admin-ajax.php",data: { action: 'action_dataimportjob_csvfileimport', jobcode: '<?php echo $jobcode;?>', csvfilename: '<?php echo $csv_filename;?>', targetrows:<?php echo $button['rate'];?>, _ajax_nonce: '<?php echo $nonce; ?>' },
                                beforeSend: function() {jQuery("#loading_div_for_<?php echo $jobcode;?>").fadeIn('fast');
                                jQuery("#formstatus_div_for_<?php echo $jobcode;?>").fadeOut("fast");}, //fadeIn loading just when link is clicked
                                success: function(html){ //so, if data is retrieved, store it in html
                                    jQuery("#loading_div_for_<?php echo $jobcode;?>").fadeOut('slow');
                                    jQuery("#formstatus_div_for_<?php echo $jobcode;?>").html( html ); //show the html inside formstatus div
                                    jQuery("#formstatus_div_for_<?php echo $jobcode;?>").fadeIn("fast"); //animation
                                }
                            }); //close jQuery.ajax
                            
                            // update the imported rows counter
                            jQuery.ajax({                       
                                type: "post",url: "admin-ajax.php",data: { action: 'dataimportjob_requestupdate', jobcode: '<?php echo $jobcode;?>', csvfilename: '<?php echo $csv_filename;?>', _ajax_nonce: '<?php echo $nonce; ?>' },
                                beforeSend: function() {jQuery("#loading_div_for_<?php echo $jobcode;?>").fadeIn('fast');}, //fadeIn loading just when link is clicked
                                success: function(html){ //so, if data is retrieved, store it in html
                                    jQuery("#loading_div_for_<?php echo $jobcode;?>").fadeOut('slow');
                                    jQuery("#thevalue_<?php echo $jobcode . $csv_filename_cleaned;?>").val(html); //fadeIn the html inside helloworld div
                                }       
                            }); //close jQuery.ajax 
                                                            
                        })
                           
                                
                    <?php }?>
                                                
                })
                -->
                </script>
                
            <?php }?>

            <!-- Start Of Buttons Table --> 
                            
                <?php foreach($job_array['files'] as $key => $csv_filename){?>
                
                <table>
                    <?php $csv_filename_cleaned = csv2post_clean_string($csv_filename);?>
                    <tr>
                        
                        <?php 
                        if(!$csv2post_is_free){?>                                  
                            <td><input type='submit' name='action' id='request_import_a_<?php echo $jobcode . $csv_filename_cleaned;?>' value='Import All Rows' /></td>         
                            <td><input type='submit' name='action' id='request_import_b_<?php echo $jobcode . $csv_filename_cleaned;?>' value='1 Row' /></td>            
                            <td><input type='submit' name='action' id='request_import_c_<?php echo $jobcode . $csv_filename_cleaned;?>' value='100 Rows' /></td>            
                            <td><input type='submit' name='action' id='request_import_d_<?php echo $jobcode . $csv_filename_cleaned;?>' value='1000 Rows' /></td>
                        <?php }?>
                                                            
                        <td><input type='submit' name='action' id='request_import_e_<?php echo $jobcode . $csv_filename_cleaned;?>' value='<?php if($csv2post_is_free){echo 'Click To Import Data';}else{echo '10,000 Rows';}?>' /></td>   
                        
                        <td><strong>Already Imported</strong><input type='text' name='thevalue' id='thevalue_<?php echo $jobcode . $csv_filename_cleaned;?>' value='<?php echo csv2post_sql_count_records_forfile('csv2post_'.$jobcode,$csv_filename,$key); ?>' size="10" readonly /> </td>
                    </tr>
                </table>
                <?php }?>
                            
                  
            <!-- End Of Buttons Table -->
            
            <style type='text/css'>
            #loading_div_for_<?php echo $jobcode;?> { clear:both; background:url(images/loading.gif) center top no-repeat; text-align:center;padding:33px 0px 0px 0px; font-size:12px;display:none; font-family:Verdana, Arial, Helvetica, sans-serif; }
            </style>
                
            <!-- Ajax Output - applies to entire job panel, all forms within -->
            <br />
            <div id='formstatus_div_for_<?php echo $jobcode;?>'></div>
            <div id='loading_div_for_<?php echo $jobcode;?>'>Importing Data Please Wait!</div>  
                
        <?php csv2post_panel_footer();?>             
                        
    <?php }// end of main loop
    }
    
}else{

    if($csv2post_dataimportjobs_array){

        // foreach job
        foreach( $csv2post_dataimportjobs_array as $jobcode => $job ){

            $job_array = csv2post_get_dataimportjob($jobcode);

            ++$panel_number;// increase panel counter so this panel has unique ID
            $panel_array = array();                       
            $panel_array['panel_name'] = 'dataimportjob' . $jobcode;// slug to act as a name and part of the panel ID 
            $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
            $panel_array['panel_title'] = __('Data Import Job: ' . $job['name']);// user seen panel header text 
            $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
            $panel_array['tabnumber'] = $csv2post_tab_number; 
            $panel_array['panel_id'] = $panel_array['panel_name'] . $panel_number;// creates a unique id, may change from version to version but within a version it should be unique
            $panel_array['panel_intro'] = __('This is your data import job named ' . $job['name'] .' and the job code is ' . $jobcode);
            $panel_array['panel_help'] = __('Please refresh the browser in order to view the latest job statistics (until more Ajax is added). Your data import panel for ' . $job['name'] . ' allows you to import rows from individual CSV files. You can also manually update the statistics. By default rows are imported and put into the database table using an UPDATE query, not an INSERT. The rows are placed in order as found in the CSV files. Meaning all CSV files within a single job must be in matching order for the finished table of data to be correct. This is only the default behaviour as there is the ability to save a set of key columns which contain some type of ID per record. Each CSV file must contain the same column of ID values in order for this ability to work. This allows the rows in each CSV file to be in any order and still be updated to the correct record in the database.');
            $panel_array['help_button'] = csv2post_helpbutton_text(false,false);
            // Form Settings - create the array that is passed to jQuery form functions
            $jsform_set_override = array();
            $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
            $jsform_set['dialoguebox_title'] = 'Import Data';
            $jsform_set['noticebox_content'] = 'You are about to import data from your CSV file, do you wish to continue?';
            
            csv2post_panel_header( $panel_array );?>
            
            <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);?>
     
                <input type="hidden" name="csv2post_importdatarequest_jobcode" value="<?php echo $jobcode;?>">
                
                <input type="hidden" name="csv2post_importdatarequest_postmethod" value="true">
                <p>        
                    Select CSV File: 
                    <select name="csv2post_dataimport_selectcsvfile_<?php echo $jobcode;?>" id="csv2post_dataimport_selectcsvfile_id_<?php echo $jobcode;?>" class="csv2post_multiselect_menu">
                        <?php csv2post_menu_options_job_csvfiles($jobcode); ?>                                                                                                                     
                    </select>
                </p>
      
                <script>
                $("#csv2post_dataimport_selectcsvfile_id_<?php echo $jobcode;?>").multiselect({
                   multiple: false,
                   header: "Select CSV File",
                   noneSelectedText: "Select CSV File",
                   selectedList: 1
                });
                </script>
                
                How many rows do you want to import?<br />
                <input type="text" name="csv2post_dataimport_rownumber_<?php echo $jobcode;?>" value="">
                
                <br />

            <?php                   
            // add the javascript that will handle our form action, prevent submission and display dialogue box
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

            // add end of form - dialogue box does not need to be within the <form>
            csv2post_formend_standard('Start Data Import',$jsform_set['form_id']); 
            csv2post_jquery_form_prompt($jsform_set);  
            csv2post_panel_footer();             
                        
        }// end of main loop
    }
}
?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'deletedataimportjob';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Delete Data Import Jobs');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('A list of all data import jobs that can be deleted');
$panel_array['panel_help'] = __('As the plugin becomes more advanced, some Data Import Jobs may not allow deletion in certain circumstances. They will probably show in the list but not allow selection.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialoguebox_title'] = 'Delete Selected Jobs';
$jsform_set['noticebox_content'] = 'You are about to delete select data import jobs, are you sure you want to continue?';
// TODO: LOWPRIORITY, replace table using data table script
// TODO: LOWPRIORITY, update dialogue content with a list of the selected jobs
?>

<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','','');?>

    <?php csv2post_list_dataimportjobs();?>

    <?php 
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
    csv2post_formend_standard('Delete',$jsform_set['form_id']);
    csv2post_jquery_form_prompt($jsform_set);
    ?>

<?php csv2post_panel_footer();?>
