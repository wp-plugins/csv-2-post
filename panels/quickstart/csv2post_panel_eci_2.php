<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreeconfirmformat';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 2: CSV File and Post Creation Setup');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
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
            <td>';?>

                <script>
                $(function() {
                    $( "#csv2post_newjob_separator_radios_<?php echo $filename_array[0];?>" ).buttonset();
                });
                </script>

                <div id="csv2post_newjob_separator_radios_<?php echo $filename_array[0];?>">
                    <input type="radio" id="csv2post_separator_comma_<?php echo $filename_array[0];?>" name="csv2post_newjob_separators<?php echo $filename_array[0];?>" value="," checked /><label for="csv2post_separator_comma_<?php echo $filename_array[0];?>">,</label>
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
                    <input type="radio" id="csv2post_quote_double_<?php echo $filename_array[0];?>" name="csv2post_newjob_quote<?php echo $filename_array[0];?>" value="doublequote" checked /><label for="csv2post_quote_double_<?php echo $filename_array[0];?>">"</label>
                    <input type="radio" id="csv2post_quote_single_<?php echo $filename_array[0];?>" name="csv2post_newjob_quote<?php echo $filename_array[0];?>" value="singlequote" /><label for="csv2post_quote_single_<?php echo $filename_array[0];?>">'</label>                
                </div>                        
            
            </td>
        </tr><?php                         
        echo '</table>';?>
        
        <h4>Ping Status</h4>
        <script>
        $(function() {
            $( "#csv2post_pingstatus" ).buttonset();
        });
        </script>
        
        <div id="csv2post_pingstatus"><?php      
            $o = ''; $c = 'checked';
            if(isset($csv2post_project_array['pingstatus']) && $csv2post_project_array['pingstatus'] == 'open'){
                $o = 'checked'; $c = '';
            }elseif(isset($csv2post_project_array['pingstatus']) && $csv2post_project_array['pingstatus'] == 'closed'){
                $o = ''; $c = 'checked'; 
            }else{
                // project ping default not set so we now make use of the blogs default ping
                $d = get_option('default_ping_status');
                if($d == 'closed'){
                    $o = ''; $c = 'checked';        
                }elseif($d == 'open'){
                    $o = 'checked'; $c = '';
                }
            }?>
            <input type="radio" id="csv2post_pingstatus_open_id" name="csv2post_pingstatus" value="open" <?php echo $o;?> /><label for="csv2post_pingstatus_open_id">Open</label>
            <input type="radio" id="csv2post_pingstatus_closed_id" name="csv2post_pingstatus" value="closed" <?php echo $c;?> /><label for="csv2post_pingstatus_closed_id">Closed</label>          
        </div>
             
        <h4>Comment Status</h4>
        <script>
        $(function() {
            $( "#csv2post_commentstatus" ).buttonset();
        });
        </script>
        
        <div id="csv2post_commentstatus"><?php
            $o = ''; $c = 'checked';
            if(isset($csv2post_project_array['commentstatus']) && $csv2post_project_array['commentstatus'] == 'open'){
                $o = 'checked'; $c = '';
            }elseif(isset($csv2post_project_array['commentstatus']) && $csv2post_project_array['commentstatus'] == 'closed'){
                $o = ''; $c = 'checked'; 
            }else{
                // project ping default not set so we now make use of the blogs default ping
                $d = get_option('default_comment_status');
                if($d == 'closed'){
                    $o = ''; $c = 'checked';        
                }elseif($d == 'open'){
                    $o = 'checked'; $c = '';
                }
            }?>
            <input type="radio" id="csv2post_commentstatus_open_id" name="csv2post_commentstatus" value="open" <?php echo $o;?> /><label for="csv2post_commentstatus_open_id">Open</label>
            <input type="radio" id="csv2post_commentstatus_closed_id" name="csv2post_commentstatus" value="closed" <?php echo $c;?> /><label for="csv2post_commentstatus_closed_id">Closed</label>          
        </div>
            
        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        } 
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>