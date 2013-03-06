<?php 
/*
echo csv2post_notice('This is screen allows us to not only carry out an initial data import but we can also
update our data with it. Use this screen instead of the Basic Import screen if you plan to run updates. It allows 
us to select an ID column so that a relationship exists between CSV file rows and existing database records. There is
no other way to update data, sometime of unique ID value is always required.
It is important to note that the update is applied to the Data Import Job database table before being used elsewhere.
Our approach is one step at a time for the security and safety of your blog, especially on the public side. Further
action is required after data is imported or updated if you want the data to be displayed in posts.',
'info','Large','Screen Introduction','','return');
*/
?>

<?php 
##################################################################################
#                                                                                #
#         START OF DATA IMPORT JOB PANELS LOOP - CREATES A PANEL PER JOB         #
#                                                                                #
##################################################################################
if(!isset($csv2post_dataimportjobs_array) || !is_array($csv2post_dataimportjobs_array) || count($csv2post_dataimportjobs_array) == 0){
    echo csv2post_notice('You do not have any Data Import jobs, please create one on the Start screen','info','Small','','','return');    
}else{
             
    // foreach job
    foreach( $csv2post_dataimportjobs_array as $jobcode => $job ){

        $job_array = csv2post_get_dataimportjob($jobcode);
             
        ++$panel_number;// increase panel counter so this panel has unique ID
        $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);                      
        $panel_array['panel_name'] = 'advanceddataimportjob' . $jobcode;// slug to act as a name and part of the panel ID 
        $panel_array['panel_title'] = __('Data Import Job: ' . $job['name']);// user seen panel header text 
        $panel_array['panel_id'] = $panel_array['panel_name'] . $panel_number;// creates a unique id, may change from version to version but within a version it should be unique
        $panel_array['panel_help'] = __('Please refresh the browser in order to view the latest job statistics (until more Ajax is added). Your data import panel for ' . $job['name'] . ' allows you to import rows from individual CSV files. You can also manually update the statistics. By default rows are imported and put into the database table using an UPDATE query, not an INSERT. The rows are placed in order as found in the CSV files. Meaning all CSV files within a single job must be in matching order for the finished table of data to be correct. This is only the default behaviour as there is the ability to save a set of key columns which contain some type of ID per record. Each CSV file must contain the same column of ID values in order for this ability to work. This allows the rows in each CSV file to be in any order and still be updated to the correct record in the database.');
        // Form Settings - create the array that is passed to jQuery form functions
        $jsform_set_override = array();
        $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
        $jsform_set['dialogbox_title'] = 'Import Data';
        $jsform_set['noticebox_content'] = 'You are about to import data from your CSV file. Data updating will also be done if your CSV file has been updated. Do you wish to continue?';
        
        csv2post_panel_header( $panel_array );?>

            <?php 
            // begin form and add hidden values
            csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
            csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
            ?> 
    
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
                                $( "#csv2post_advancedimportselection_<?php echo $object_type;?>_<?php echo $jobcode;?>" ).buttonset();
                            });
                            </script>

                            <div id="csv2post_advancedimportselection_<?php echo $object_type;?>_<?php echo $jobcode;?>">                    
                                <input type="<?php echo $object_type;?>" name="csv2post_importselection_csvfiles[]" id="csv2post_advancedimportselection_csvfiles<?php echo $jobcode;?>" value="<?php echo $csv_filename;?>" checked />
                                <label for="csv2post_advancedimportselection_csvfiles<?php echo $jobcode;?>">*</label>                     
                            </div>
                            
                        <?php     
                        ### TODO:HIGHPRIORITY, change the PEARCSVmethod for quote in the fget column
                        echo '</td>
                        <td>'.$csv_filename.'</td><td>';?>              
                                            
                        <p>
                            <select id="csv2post_advancedidcolumn_<?php echo $jobcode;?>_<?php echo $fileChunks[0];?>" name="csv2post_advancedidcolumn_<?php echo $jobcode;?>_<?php echo $fileChunks[0];?>" class="csv2post_multiselect_menu">
                                <?php csv2post_display_headers_menuoptions($job_array[$csv_filename]['headers'],$jobcode);?>
                            </select>
                        </p>

                        <?php                         
                        echo '</td>';?>

                    </tr><?php                         

                    echo '</table><br />';
                }
            }?>

            <h4>Import Type</h4>
            <script>
            $(function() {
                $( "#csv2post_dataimport_advancedreset_<?php echo $jobcode;?>_<?php echo $fileChunks[0];?>" ).buttonset();
            });
            </script>

            <div id="csv2post_dataimport_advancedreset_<?php echo $jobcode;?>_<?php echo $fileChunks[0];?>">
                <input type="radio" id="csv2post_radio_continue_<?php echo $jobcode;?>_<?php echo $fileChunks[0];?>" name="csv2post_radio_progresscontrols" value="continue" checked />
                <label for="csv2post_radio_continue_<?php echo $jobcode;?>_<?php echo $fileChunks[0];?>">Initial Import (continue )</label>
                
                <input type="radio" id="csv2post_radio_reset_<?php echo $jobcode;?>_<?php echo $fileChunks[0];?>" name="csv2post_radio_progresscontrols" value="reset" />
                <label for="csv2post_radio_reset_<?php echo $jobcode;?>_<?php echo $fileChunks[0];?>">Updating (reset progress counters)</label>            
            </div>
            
    
        <?php
        ### TODO:MEDIUMPRIORITY, these tables assume all stats exist. We should deal with this. I think
        ### we should initialize a statistic value if it is missing, so put the array through a function.
        ### That we zero exists as the counter/stat
                           

        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        }

        csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);

        #####################################
        #         DISPLAY MAIN STATS        #
        #####################################
        echo '<br />';
        echo '<h4>Main Statistics</h4>';
        echo '
        <table class="widefat post fixed">            
          <tr><td width="200">Rows In File/s: </td><td  width="50">'.$job_array['totalrows'].'</td><td>in multiple file import jobs all files should have the same number of rows</td></tr>
          <tr><td width="200">Progress: </td><td>'.$job_array['stats']['allevents']['progress'].'</td><td>combined import from all files</td></tr>                                                                                                         
        </table>';            
                    
        #####################################
        #       DISPLAY LAST EVENT STATS    #
        #####################################
        echo '<h4>Last Event Statistics</h4>';
        echo '
        <table class="widefat post fixed">
        <tr><td width="200">Rows In File: </td><td>'.$job_array['totalrows'].'</td><td></td></tr>               
        <tr><td width="200">Loop Count: </td><td>'.$job_array['stats']['lastevent']['loop_count'].'</td><td></td></tr>
        <tr><td>Rows Processed: </td><td>'.$job_array['stats']['lastevent']['processed'].'</td><td></td></tr>
        <tr><td>Records Inserted: </td><td>'.$job_array['stats']['lastevent']['inserted'].'</td><td></td></tr>
        <tr><td>Records Updated: </td><td>'.$job_array['stats']['lastevent']['updated'].'</td><td></td></tr>
        <tr><td>Records Deleted: </td><td>'.$job_array['stats']['lastevent']['deleted'].'</td><td></td></tr>
        <tr><td>Records Void: </td><td>'.$job_array['stats']['lastevent']['void'].'</td><td></td></tr>
        <tr><td>Rows Dropped: </td><td>'.$job_array['stats']['lastevent']['dropped'].'</td><td></td></tr>
        <tr><td>Duplicates Found: </td><td>'.$job_array['stats']['lastevent']['duplicates'].'</td><td></td></tr>                                                                                    
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

        csv2post_panel_footer(); 
                                                    
    }// end of $job loop
}
?>
