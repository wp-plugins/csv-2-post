<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreepostdates';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 8: Publish Date');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('You can apply pre-made dates in your data as your publish dates');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_help'] = __('You can apply pre-made dates in your data as your publish dates.
If your dates are set in the future your posts will be scheduled to be published by Wordpress.');
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'NOT IN USE';
$jsform_set['noticebox_content'] = 'NOT IN USE';
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 8){

        csv2post_n_incontent('This step has been complete.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
                
        <script>
        $(function() {
            $( "#csv2post_eci_freedates_method" ).buttonset();
        });
        </script>

        <div id="csv2post_eci_freedates_method">
            <input type="radio" id="csv2post_eci_freedates_default" name="csv2post_eci_freedates_methods" value="default" /><label for="csv2post_eci_freedates_default">Use Wordpress Default Date</label>
            <input type="radio" id="csv2post_eci_freedates_data" name="csv2post_eci_freedates_methods" value="data" /><label for="csv2post_eci_freedates_data">Use My Dates Data</label>               
        </div>

        <br />
        
        <strong>Select Dates Column:</strong><?php echo csv2post_menu_csvfile_headers('eci_freedates',$csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);?><br />

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