<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreetags';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 12: Tags');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 13){

         csv2post_n_incontent('This step has been complete.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>

        <script>
        $(function() {
            $( "#csv2post_eci_freetags_switch" ).buttonset();
        });
        </script>

        <div id="csv2post_eci_freetags_switch">
            <input type="radio" id="csv2post_eci_freetags_no" name="csv2post_eci_freetags_methods" value="no" checked />
            <label for="csv2post_eci_freetags_no"> Do Not Create Tags</label>
            <?php csv2post_GUI_br();?>
            <input type="radio" id="csv2post_eci_freetags_yes" name="csv2post_eci_freetags_methods" value="yes" />
            <label for="csv2post_eci_freetags_yes">Create Tags</label>               
        </div>

        <br />
                
        <strong>Select Tags Column:</strong><?php echo csv2post_menu_csvfile_headers('eci_freetags',$csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);?><br />        
 
        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_promptdiv($jsform_set);
        } 
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>
