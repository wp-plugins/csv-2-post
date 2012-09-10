<?php
echo csv2post_notice('Still under construction, for testing only.','warning','Small','','','return');
##################################################################################
#                                                                                #
#         START OF DATA IMPORT JOB PANELS LOOP - CREATES A PANEL PER JOB         #
#                                                                                #
##################################################################################
if(!isset($csv2post_dataimportjobs_array) || count($csv2post_dataimportjobs_array) == 0){
    echo csv2post_notice('You do not have any Data Import jobs, please create one on the Start screen','info','Small','','','return');    
}else{

    // foreach job
    foreach( $csv2post_dataimportjobs_array as $jobcode => $job ){

        $job_array = csv2post_get_dataimportjob($jobcode);
             
        ++$panel_number;// increase panel counter so this panel has unique ID
        $panel_array = array();                       
        $panel_array['panel_name'] = 'advanceddataimportjob' . $jobcode;// slug to act as a name and part of the panel ID 
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
        $jsform_set['noticebox_content'] = 'You are about to import data from your CSV file. Data updating will also be done if your CSV file has been updated. Do you wish to continue?';
        
        csv2post_panel_header( $panel_array );?>

        <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);?>
 
            <input type="hidden" name="csv2post_importdatarequest_jobcode" value="<?php echo $jobcode;?>">
            <input type="hidden" name="csv2post_importdatarequest_advanced_postmethod" value="true">
                                          
            <?php
            if($csv2post_is_free){
                echo '<input type="hidden" name="csv2post_importselection_csvfiles[]" value="'.$job_array['files'][1].'">';    
            }else{?>
            
                How many rows do you want to import?<br />
                <input type="text" name="csv2post_dataimport_rownumber_<?php echo $jobcode;?>" value="">
                                
                <?php 
                echo '<br /><br />';
                
                foreach($job_array['files'] as $key => $csv_filename){ 
                 
                    $fileChunks = explode(".", $csv_filename);

                    echo '<table class="widefat post fixed">';
                        
                    echo '
                    <tr>
                        <td width="50">Select</td>    
                        <td width="150">File Names</td>
                        <td>ID Column</td>
                    </tr>';
                    
                    echo '
                    <tr>
                        <td>';
                            
                            // determine radio or checkboxes
                            ### TODO:LOWPRIORITY, offer the option of importing from multiple files in one event
                            $object_type = 'radio';
                            if($csv2post_is_free){
                                $object_type = 'radio';
                            }?>
                            
                            <script>
                            $(function() {
                                $( "#csv2post_advancedimportselection_<?php echo $object_type;?>_<?php echo $fileChunks[0];?>" ).buttonset();
                            });
                            </script>

                            <div id="csv2post_advancedimportselection_<?php echo $object_type;?>_<?php echo $fileChunks[0];?>">                    
                                <input type="<?php echo $object_type;?>" name="csv2post_importselection_csvfiles[]" id="csv2post_advancedimportselection_csvfiles<?php echo $fileChunks[0];?>" value="<?php echo $csv_filename;?>" checked />
                                <label for="csv2post_advancedimportselection_csvfiles<?php echo $fileChunks[0];?>">*</label>                     
                            </div>
                            
                        <?php     
                        ### TODO:HIGHPRIORITY, change the PEARCSVmethod for quote in the fget column
                        echo '</td>
                        <td>'.$csv_filename.'</td><td>';
                        
                        echo csv2post_menu_csvfile_headers($panel_array['panel_name'],$jobcode,$csv_filename);
                        
                        echo '</td>';?>

                    </tr><?php                         

                    echo '</table><br />';
                }
            }?>

        <?php
        ### TODO:MEDIUMPRIORITY, these tables assume all stats exist. We should deal with this. I think
        ### we should initialize a statistic value if it is missing, so put the array through a function.
        ### That we zero exists as the counter/stat
                           
        // add the javascript that will handle our form action, prevent submission and display dialogue box
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

        // add end of form - dialogue box does not need to be within the <form>
        csv2post_formend_standard('Start Data Import',$jsform_set['form_id']); 

        #####################################
        #         DISPLAY MAIN STATS        #
        #####################################
        echo '<h4>Main Statistics</h4>';
        echo '
        <table class="widefat post fixed">            
          <tr><td width="200">Rows In File/s: </td><td  width="50">'.$job_array['totalrows'].'</td><td>in multiple file import jobs all files should have the same number of rows</td></tr>
          <tr><td width="200">Progress: </td><td>'.$job_array['stats']['allevents']['progress'].'</td><td></td></tr>                                                                                                         
        </table>';            
                    
        #####################################
        #       DISPLAY LAST EVENT STATS    #
        #####################################
        echo '<h4>Last Event Statistics</h4>';
        echo '
        <table class="widefat post fixed">
  <tr><td width="200">Rows In File: </td><td>'.$job_array['totalrows'].'</td></tr>               
        <tr><td width="200">Loop Count: </td><td>'.$job_array['stats']['lastevent']['loop_count'].'</td></tr>
        <tr><td>Rows Processed: </td><td>'.$job_array['stats']['lastevent']['processed'].'</td></tr>
        <tr><td>Records Inserted: </td><td>'.$job_array['stats']['lastevent']['inserted'].'</td></tr>
        <tr><td>Records Updated: </td><td>'.$job_array['stats']['lastevent']['updated'].'</td></tr>
        <tr><td>Records Deleted: </td><td>'.$job_array['stats']['lastevent']['deleted'].'</td></tr>
        <tr><td>Records Void: </td><td>'.$job_array['stats']['lastevent']['void'].'</td></tr>
        <tr><td>Rows Dropped: </td><td>'.$job_array['stats']['lastevent']['dropped'].'</td></tr>
        <tr><td>Duplicates Found: </td><td>'.$job_array['stats']['lastevent']['duplicates'].'</td></tr>                                                                                    
        </table>';            
             
        #####################################
        #       DISPLAY ALL EVENT STATS     #
        #####################################
        echo '<h4>All Event Statistics</h4>';
        echo '
        <table class="widefat post fixed">
  <tr><td width="200">Rows In File: </td><td>'.$job_array['totalrows'].'</td></tr>               
        <tr><td width="200">Rows Processed: </td><td>'.$job_array['stats']['allevents']['progress'].'</td></tr>
        <tr><td>Records Inserted: </td><td>'.$job_array['stats']['allevents']['inserted'].'</td></tr>
        <tr><td>Records Updated: </td><td>'.$job_array['stats']['allevents']['updated'].'</td></tr>
        <tr><td>Records Deleted: </td><td>'.$job_array['stats']['allevents']['deleted'].'</td></tr>
        <tr><td>Records Void: </td><td>'.$job_array['stats']['allevents']['void'].'</td></tr>
        <tr><td>Rows Dropped: </td><td>'.$job_array['stats']['allevents']['dropped'].'</td></tr>
        <tr><td>Duplicates Found: </td><td>'.$job_array['stats']['allevents']['duplicates'].'</td></tr>                                                                                    
        </table>'; 
                  
        ###########################
        #   DISPLAY FILE STATUS   #
        ###########################
        echo '<h4>Per File Statistics and Status</h4>';
        
        // decide overall status
        ### TODO:HIGHPRIORIY, check file still exists
        ### TODO:MEDIUM, has file datestamp went backwards, we need to store the datestamps for this
        $state = 'success';
        
        // decide intro message
        ### TODO:LOWPRIORITY, add more states in relation to the checks done above
        if($state = 'success'){
            $im = 'No problems detected with this file, it is in place and ready to be imported';
        }
        
        foreach($job_array['files'] as $key => $csv_filename){ 
            
            // build message
            $message = '
            <p>'.$im.'</p>
            <table class="widefat post fixed">
            <tr><td width="200">Rows In File: </td><td>'.$job_array['stats'][$csv_filename]['rows'].'</td></tr>               
            <tr><td width="200">Rows Processed: </td><td>'.$job_array['stats'][$csv_filename]['progress'].'</td></tr>
            <tr><td>Records Inserted: </td><td>'.$job_array['stats'][$csv_filename]['inserted'].'</td></tr>
            <tr><td>Records Updated: </td><td>'.$job_array['stats'][$csv_filename]['updated'].'</td></tr>
            <tr><td>Records Deleted: </td><td>'.$job_array['stats'][$csv_filename]['deleted'].'</td></tr>
            <tr><td>Records Void: </td><td>'.$job_array['stats'][$csv_filename]['void'].'</td></tr>
            <tr><td>Rows Dropped: </td><td>'.$job_array['stats'][$csv_filename]['dropped'].'</td></tr>
            <tr><td>Duplicates Found: </td><td>'.$job_array['stats'][$csv_filename]['duplicates'].'</td></tr>                                                                                    
            </table>';

            echo csv2post_notice($message,$state,'Small',$csv_filename,'','return');
        } 
        
        // end of form (including jquery prompts/dialogue)            
        csv2post_jquery_form_prompt($jsform_set);  
        csv2post_panel_footer(); 
                                                    
    }// end of $job loop
}
?>