<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreeconfirmformat';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 2: Confirm CSV File Format');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select the separator, delimiter and enter the number of columns for your file');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_help'] = __('All .csv files have a separator, specific number of columns much like
a spreadsheet has and they may have a quote which is used to wrap individual values. Quotes are recommended
to help software determine individual values and avoid problems with special characters within quotes. Do not
worry if your file does not use quotes, it should still work. We have determined that it is best to enter
the separator, number of columns and quote manually rather than the plugin establishing them automatically.');
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Ensure CSV Format Is Correct';
$jsform_set['noticebox_content'] = 'Entering incorrect values will cause problems and require a restart. Please
keep this in mind if you are unsure about your CSV file and do experience difficutly. Do you wish to continue saving?';
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 2){

        csv2post_n_incontent('You have completed this step and a new 
        data import job was created named '.$csv2post_ecisession_array['jobname'].', its unique code 
        is '.$csv2post_ecisession_array['dijcode'].'.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?> 
        
        <?php   
        global $csv2post_is_free;  

        // remove .csv from filename
        $filename_array = explode('.',$csv2post_ecisession_array['filename']);
              
        echo '<table class="widefat post fixed">';
                
        echo '
        <tr>
            <td width="200">CSV File Name</td>
            <td width="70">Columns</td>        
            <td width="110">Separator</td>
            <td width="80">Quote</td> 
        </tr>';
           
        echo '
        <tr>
            <td>'.$csv2post_ecisession_array['filename'].'</td>
            <td><input type="text" name="csv2post_csvfile_fieldcount_'.$filename_array[0].'" size="2" maxlength="2" value="" /></td>
            <td>'; ?>

                <script>
                $(function() {
                    $( "#csv2post_newjob_separator_radios_<?php echo $filename_array[0];?>" ).buttonset();
                });
                </script>

                <div id="csv2post_newjob_separator_radios_<?php echo $filename_array[0];?>">
                    <input type="radio" id="csv2post_separator_comma_<?php echo $filename_array[0];?>" name="csv2post_newjob_separators<?php echo $filename_array[0];?>" value="," /><label for="csv2post_separator_comma_<?php echo $filename_array[0];?>">,</label>
                    <input type="radio" id="csv2post_separator_semicolon_<?php echo $filename_array[0];?>" name="csv2post_newjob_separators<?php echo $filename_array[0];?>" value=";" /><label for="csv2post_separator_semicolon_<?php echo $filename_array[0];?>">;</label>
                    <input type="radio" id="csv2post_separator_tab_<?php echo $filename_array[0];?>" name="csv2post_newjob_separators<?php echo $filename_array[0];?>" value="|" /><label for="csv2post_separator_tab_<?php echo $filename_array[0];?>">|</label>                
                </div>

            </td>
            <td>
                <script>
                $(function() {                                                                                          
                    $( "#csv2post_newjob_quote_radios_<?php echo $filename_array[0];?>" ).buttonset();
                });
                </script>

                <div id="csv2post_newjob_quote_radios_<?php echo $filename_array[0];?>">
                    <input type="radio" id="csv2post_quote_double_<?php echo $filename_array[0];?>" name="csv2post_newjob_quote<?php echo $filename_array[0];?>" value="doublequote" /><label for="csv2post_quote_double_<?php echo $filename_array[0];?>">"</label>
                    <input type="radio" id="csv2post_quote_single_<?php echo $filename_array[0];?>" name="csv2post_newjob_quote<?php echo $filename_array[0];?>" value="singlequote" /><label for="csv2post_quote_single_<?php echo $filename_array[0];?>">'</label>                
                </div>                        
            
            </td>
        </tr><?php                         

        echo '</table>';     
        ?>

        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        } 
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>